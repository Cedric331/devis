<?php

use App\Models\Client;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(Database\Seeders\RolePermissionSeeder::class);
});

it('allows owner to manage clients and quotes', function () {
    $owner = User::factory()->create();
    $owner->assignRole('owner');

    $this->actingAs($owner)
        ->post('/clients', ['name' => 'Acme'])
        ->assertCreated();

    $client = Client::where('company_id', $owner->company_id)->first();

    $this->actingAs($owner)
        ->post('/quotes', [
            'client_id' => $client->id,
            'number' => 'Q-1',
            'currency' => 'EUR',
            'status' => 'draft',
            'public_hash' => Str::random(10),
        ])->assertCreated();
});

it('forbids member from deleting clients and quotes', function () {
    $member = User::factory()->create();
    $member->assignRole('member');

    $client = Client::factory()->create(['company_id' => $member->company_id]);

    $this->actingAs($member)
        ->delete('/clients/'.$client->id)
        ->assertForbidden();

    $quote = Quote::create([
        'company_id' => $member->company_id,
        'client_id' => $client->id,
        'number' => 'Q-1',
        'currency' => 'EUR',
        'status' => 'draft',
        'public_hash' => Str::random(10),
    ]);

    $this->actingAs($member)
        ->delete('/quotes/'.$quote->id)
        ->assertForbidden();
});

it('denies access without permission', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/clients')
        ->assertForbidden();
});
