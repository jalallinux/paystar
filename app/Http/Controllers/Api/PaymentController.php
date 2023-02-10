<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Payment\PaymentCallbackRequest;
use App\Http\Requests\Api\Payment\PaymentIndexRequest;
use App\Http\Requests\Api\Payment\PaymentStoreRequest;
use App\Http\Resources\Api\Payment\PaymentDetailResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Payment\PaymentIndexResource;
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
        return PaymentIndexResource::collection($payments);
    }

    /**
     * Store a newly created payment in storage.
     *
     * @param PaymentStoreRequest $request
     * @return PaymentDetailResource
     */
    public function store(PaymentStoreRequest $request)
    {
        $payment = $request->user()->payments()
            ->create($request->safe()->only('amount'));

        return new PaymentDetailResource($payment);
    }

    /**
     * Display the specified payment.
     *
     * @param Request $request
     * @param Payment $payment
     * @return PaymentDetailResource
     * @throws \Throwable
     */
    public function show(Request $request, Payment $payment)
    {
        throw_if(
            $payment->user->id != $request->user()->id,
            new AuthorizationException
        );
        return new PaymentDetailResource($payment);
    }

    /**
     * Callback the specified payment in storage.
     *
     * @param PaymentCallbackRequest $request
     * @param Payment $payment
     * @return \Illuminate\Http\Response
     */
    public function callback(PaymentCallbackRequest $request, Payment $payment)
    {
        $request->dd();
    }
}
