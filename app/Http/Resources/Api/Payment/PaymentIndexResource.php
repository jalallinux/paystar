<?php

namespace App\Http\Resources\Api\Payment;

use App\Http\Resources\Api\Auth\MeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentIndexResource extends JsonResource
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
            'created_at' => $this->resource->created_at->timestamp,
        ];
    }
}
