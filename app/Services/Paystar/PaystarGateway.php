<?php

namespace App\Services\Paystar;

use App\Exceptions\CustomException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class PaystarGateway
{
    private PendingRequest $httpClient;

    public function __construct()
    {
        $this->httpClient = Http::baseUrl(config('services.paystar.base_url'))
            ->withToken($this->gatewayId())->asJson()->acceptJson();
    }

    public function create(int $amount, string $orderId, array $additional = []): Collection
    {
        $payload = array_merge([
            "amount" => $amount,
            "order_id" => $orderId,
            "callback" => ($callbackUrl = $this->makeCallbackUrl($orderId)),
            "sign" => $this->makeSignKey($amount, $orderId, $callbackUrl),
        ], $additional);

        $response = $this->httpClient->post("create", $payload);

        if ($response->json('status') != 1) {
            throw new CustomException(last(last($response->json('data'))), 400);
        }

        return $response->collect('data');
    }






    private function makeSignKey(int $amount, string $orderId, string $callbackUrl): string
    {
        return hash_hmac('SHA512', "{$amount}#{$orderId}#{$callbackUrl}", $this->signKey());
    }

    private function makeCallbackUrl(string $orderId): string
    {
        return route('api.payment.callback', $orderId);
    }

    private function signKey(): string
    {
        $key = config('services.paystar.sign_key');
        throw_if(empty($key));
        return $key;
    }

    private function gatewayId(): string
    {
        $id = config('services.paystar.gateway_id');
        throw_if(empty($id));
        return $id;
    }
}
