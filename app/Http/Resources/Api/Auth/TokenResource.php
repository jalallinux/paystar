<?php

namespace App\Http\Resources\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'access_token' => $this->resource,
            'token_type' => 'Bearer',
            'expires_at' => now()->addMinutes(auth()->factory()->getTTL())->getTimestamp()
        ];
    }
}
