<?php

namespace App\Services;

use Carbon\Carbon;

class QuoteNumberingService
{
    /**
     * Generate the next quote number using the {YEAR}-{SEQ} format.
     */
    public function generate(?string $lastNumber = null, ?Carbon $date = null): string
    {
        $date = $date ?? Carbon::now();
        $year = $date->format('Y');

        if ($lastNumber) {
            [$lastYear, $lastSeq] = explode('-', $lastNumber);
            $nextSeq = $lastYear === $year ? ((int) $lastSeq + 1) : 1;
        } else {
            $nextSeq = 1;
        }

        return sprintf('%s-%04d', $year, $nextSeq);
    }
}
