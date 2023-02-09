<?php

namespace App\Http\Controllers\Api;

use App\Facades\Paystar;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Payment\PaymentResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payment.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created payment in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return PaymentResource
     */
    public function store(Request $request)
    {
        /** @var Payment $payment */
        $payment = $request->user()->payments()->create([
            'amount' => $request->input('amount'),
        ]);

        return new PaymentResource($payment);
    }

    /**
     * Display the specified payment.
     *
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Callback the specified payment in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function callback(Request $request, Payment $payment)
    {
        $request->dd();
    }
}
