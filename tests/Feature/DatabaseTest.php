<?php

use App\Models\{Company, Client, Quote, QuoteVersion, QuoteItem, QuoteAcceptance, Payment, QuoteEvent, QuoteView, Reminder, StripeAccount, User};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

it('runs migrations and basic relations', function () {
    $company = Company::factory()->create();
    $client = Client::factory()->create(['company_id' => $company->id]);

    $quote = Quote::create([
        'company_id' => $company->id,
        'client_id' => $client->id,
        'number' => '2025-0001',
        'currency' => 'EUR',
        'status' => 'draft',
        'public_hash' => Str::random(32),
        'deposit_percent' => 20,
        'payment_method' => 'stripe',
        'due_at' => now()->addDays(7),
    ]);

    $version = $quote->versions()->create([
        'version' => 1,
        'totals' => [],
        'render_hash' => Str::random(40),
    ]);

    $version->items()->create([
        'label' => 'Service',
        'qty' => 1,
        'unit_price_cents' => 1000,
        'tax_rate' => 20,
    ]);

    $quote->acceptances()->create([
        'version' => 1,
        'signer_name' => 'John',
        'ip' => '127.0.0.1',
        'signed_at' => now(),
    ]);

    $quote->payments()->create([
        'method' => 'stripe',
        'amount_cents' => 1000,
        'status' => 'pending',
    ]);

    $quote->events()->create([
        'type' => 'sent',
        'payload' => [],
    ]);

    $quote->views()->create([
        'ip' => '127.0.0.1',
        'user_agent' => 'test',
    ]);

    $quote->reminders()->create([
        'type' => 'first',
        'sent_at' => now(),
    ]);

    $company->stripeAccount()->create([
        'stripe_account_id' => 'acct_123',
    ]);

    expect($quote->client)->toBeInstanceOf(Client::class)
        ->and($quote->versions->first()->items->first()->label)->toBe('Service')
        ->and($quote->acceptances)->toHaveCount(1)
        ->and($company->stripeAccount->stripe_account_id)->toBe('acct_123');
});

it('assigns roles to users', function () {
    $company = Company::factory()->create();
    $user = User::factory()->create(['company_id' => $company->id]);

    $role = Role::create(['name' => 'owner']);
    $user->assignRole('owner');

    expect($user->hasRole('owner'))->toBeTrue();
});
