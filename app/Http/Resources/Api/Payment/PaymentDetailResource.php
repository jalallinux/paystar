<?php

namespace App\Http\Resources\Api\Payment;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'status' => [
                'label' => $this->resource->status->label,
                'value' => $this->resource->status->value,
            ],
            'amount' => $this->resource->amount,
            'ref_num' => $this->resource->ref_num,
            'transaction_id' => $this->resource->transaction_id,
            'token' => $this->resource->token,
            'url' => $this->resource->url,
            'created_at' => $this->resource->created_at->timestamp,
        ];
    }
}
