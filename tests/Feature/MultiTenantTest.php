<?php

use App\Models\Client;
use App\Models\Company;
use App\Models\Scopes\CompanyScope;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

use function Pest\Laravel\actingAs;

it('isolates data per company', function () {
    $companyA = Company::factory()->create();
    $companyB = Company::factory()->create();

    $userA = User::factory()->for($companyA)->create();
    $userB = User::factory()->for($companyB)->create();

    $clientA = Client::factory()->for($companyA)->create();
    $clientB = Client::factory()->for($companyB)->create();

    actingAs($userA);
    CompanyScope::set($userA->company_id);

    expect(Client::all())->toHaveCount(1)
        ->first()->is($clientA);

    expect(fn () => Gate::authorize('view', $clientB))
        ->toThrow(AuthorizationException::class);
});
