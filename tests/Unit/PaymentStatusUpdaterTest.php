<?php

use App\Models\Payment;
use App\Models\Quote;
use App\Services\PaymentStatusUpdater;

it('marks quote as paid when a payment is paid', function () {
    $quote = new Quote();
    $quote->setRelation('payments', collect([
        new Payment(['status' => 'paid']),
    ]));

    (new PaymentStatusUpdater())->update($quote);

    expect($quote->status)->toBe('payment_paid');
});

it('marks quote as failed when a payment failed', function () {
    $quote = new Quote();
    $quote->setRelation('payments', collect([
        new Payment(['status' => 'failed']),
    ]));

    (new PaymentStatusUpdater())->update($quote);

    expect($quote->status)->toBe('payment_failed');
});

it('marks quote as pending when no payment', function () {
    $quote = new Quote();
    $quote->setRelation('payments', collect([
        new Payment(['status' => 'pending']),
    ]));

    (new PaymentStatusUpdater())->update($quote);

    expect($quote->status)->toBe('payment_pending');
});
