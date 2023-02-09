<?php

namespace App\Http\Resources\Api\Payment;

use App\Http\Resources\Api\Auth\MeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'amount' => $this->resource->amount,
            'ref_num' => $this->resource->ref_num,
            'token' => $this->resource->token,
            'url' => $this->resource->url,
            'created_at' => $this->resource->created_at->timestamp,
            'user' => new MeResource($this->resource->user),
        ];
    }
}
