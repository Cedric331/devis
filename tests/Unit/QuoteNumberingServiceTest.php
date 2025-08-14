<?php

use App\Services\QuoteNumberingService;
use Carbon\Carbon;

it('generates next quote number for same year', function () {
    $service = new QuoteNumberingService();
    $number = $service->generate('2024-0001', Carbon::create(2024, 5, 1));

    expect($number)->toBe('2024-0002');
});

it('resets sequence when year changes', function () {
    $service = new QuoteNumberingService();
    $number = $service->generate('2024-0005', Carbon::create(2025, 1, 1));

    expect($number)->toBe('2025-0001');
});
