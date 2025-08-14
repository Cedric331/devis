<?php

namespace App\Services;

use App\Models\Quote;

class PaymentStatusUpdater
{
    /**
     * Update the quote payment status based on related payments.
     */
    public function update(Quote $quote): void
    {
        $statuses = $quote->payments->pluck('status');

        if ($statuses->contains('failed')) {
            $quote->status = 'payment_failed';
        } elseif ($statuses->contains('paid')) {
            $quote->status = 'payment_paid';
        } else {
            $quote->status = 'payment_pending';
        }
    }
}
