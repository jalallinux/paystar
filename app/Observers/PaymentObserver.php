<?php

namespace App\Observers;

use App\Facades\Paystar;
use App\Models\Payment;

class PaymentObserver
{
    /**
     * Handle the Payment "creating" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function creating(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "created" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function created(Payment $payment)
    {
        $invoice = Paystar::create($payment->amount, $payment->id, [
            'name' => $payment->user->name,
            'mail' => $payment->user->email,
        ]);
        $payment->update([
            'ref_num' => $invoice->get('ref_num'),
            'token' => $invoice->get('token'),
        ]);
    }

    /**
     * Handle the Payment "updated" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function updated(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "deleted" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function deleted(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "restored" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function restored(Payment $payment)
    {
        //
    }

    /**
     * Handle the Payment "force deleted" event.
     *
     * @param Payment $payment
     * @return void
     */
    public function forceDeleted(Payment $payment)
    {
        //
    }
}
