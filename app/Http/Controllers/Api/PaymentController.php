<?php

namespace App\Http\Controllers\Api;

use App\Enums\PaymentStatus;
use App\Http\Requests\Api\Payment\PaymentIndexRequest;
use App\Http\Requests\Api\Payment\PaymentStoreRequest;
use App\Http\Resources\Api\Payment\PaymentDetailResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Payment\PaymentIndexResource;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(PaymentIndexRequest $request)
    {
        $payments = $request->user()->payments()
            ->orderBy($request->orderBy(), $request->orderType())
            ->paginate($request->query('perPage'));
        return PaymentIndexResource::collection($payments);
    }

    public function store(PaymentStoreRequest $request)
    {
        $payment = $request->user()->payments()
            ->create($request->safe()->only('amount'));

        return new PaymentDetailResource($payment);
    }

    public function show(Request $request, Payment $payment)
    {
        throw_if(
            $payment->user->id != $request->user()->id,
            new AuthorizationException
        );
        return new PaymentDetailResource($payment);
    }

    public function callback(Request $request, Payment $payment)
    {
        throw_if(
            $payment->id != $request->input('order_id')
            || $payment->ref_num != $request->input('ref_num')
            || !PaymentStatus::PENDING()->equals($payment->status),
            new AuthorizationException
        );

        $columns = $request->input('status') == 1 ? [
            'card_number' => $request->input('card_number'),
            'tracking_code' => $request->input('tracking_code'),
            'transaction_id' => $request->input('transaction_id'),
            'status' => PaymentStatus::SUCCESS()
        ] : [
            'status' => PaymentStatus::FAILED(),
            'error_code' => $request->input('status')
        ];

        $payment->update($columns);

        return new PaymentDetailResource($payment);
    }
}
