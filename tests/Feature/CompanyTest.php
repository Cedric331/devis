<?php

use App\Models\Company;

it('can create a company', function () {
    $company = Company::factory()->create([
        'name' => 'Acme Inc.',
        'iban' => 'FR7630006000011234567890189',
        'bic' => 'AGRIFRPP',
        'payment_instructions' => 'Please pay via bank transfer.',
    ]);

    expect($company)
        ->name->toBe('Acme Inc.')
        ->iban->toBe('FR7630006000011234567890189')
        ->bic->toBe('AGRIFRPP')
        ->payment_instructions->toBe('Please pay via bank transfer.');
});
