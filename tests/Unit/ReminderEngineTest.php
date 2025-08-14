<?php

use App\Services\ReminderEngine;
use Carbon\Carbon;

it('calculates reminder dates J+2 and J+7', function () {
    $engine = new ReminderEngine();
    $dates = $engine->schedule(Carbon::create(2024, 4, 10));

    expect($dates[0]->toDateString())->toBe('2024-04-12');
    expect($dates[1]->toDateString())->toBe('2024-04-17');
});
