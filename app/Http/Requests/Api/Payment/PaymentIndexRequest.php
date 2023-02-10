<?php

namespace App\Http\Requests\Api\Payment;

use App\Http\Requests\Api\PaginateAndOrderableRequest;

class PaymentIndexRequest extends PaginateAndOrderableRequest
{
    public function authorize()
    {
        return true;
    }

    protected function orderedColumns(): array
    {
        return ['id', 'amount', 'status', 'created_at', 'updated_at'];
    }
}
