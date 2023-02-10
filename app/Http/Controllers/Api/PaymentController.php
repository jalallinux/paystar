<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Payment\PaymentCallbackRequest;
use App\Http\Requests\Api\Payment\PaymentIndexRequest;
use App\Http\Requests\Api\Payment\PaymentStoreRequest;
use App\Http\Resources\Api\Payment\PaymentResource;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payment.
     *
     * @param PaymentIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(PaymentIndexRequest $request)
    {
        $payments = $request->user()->payments()
            ->orderBy($request->orderBy(), $request->orderType())
            ->paginate($request->query('perPage'));
        return PaymentResource::collection($payments);
    }

    /**
     * Store a newly created payment in storage.
     *
     * @param PaymentStoreRequest $request
     * @return PaymentResource
     */
    public function store(PaymentStoreRequest $request)
    {
        $payment = $request->user()->payments()
            ->create($request->safe()->only('amount'));

        return new PaymentResource($payment);
    }

    /**
     * Display the specified payment.
     *
     * @param Request $request
     * @param Payment $payment
     * @return PaymentResource
     * @throws \Throwable
     */
    public function show(Request $request, Payment $payment)
    {
        throw_if(
            $payment->user->id != $request->user()->id,
            new AuthorizationException
        );
        return new PaymentResource($payment);
    }

    /**
     * Callback the specified payment in storage.
     *
     * @param PaymentCallbackRequest $request
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentCallbackRequest $request, Payment $payment)
    {
        $request->dd();
    }
}
