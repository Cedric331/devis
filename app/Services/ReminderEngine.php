<?php

namespace App\Services;

use Carbon\Carbon;

class ReminderEngine
{
    /**
     * Calculate reminder dates (J+2 and J+7) based on the provided date.
     *
     * @return array<int, Carbon>
     */
    public function schedule(Carbon $sentAt): array
    {
        return [
            $sentAt->copy()->addDays(2),
            $sentAt->copy()->addDays(7),
        ];
    }
}
