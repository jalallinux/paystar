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
            "sign" => $this->makeSign("{$amount}#{$orderId}#{$callbackUrl}"),
            "callback_method" => 0, // 1 -> GET, other -> POST
        ], $additional);

        $response = $this->httpClient->post("create", $payload);

        if ($response->json('status') != 1) {
            throw new CustomException(last(last($response->json('data'))), 400);
        }

        return $response->collect('data');
    }

    public function verify(int $amount, string $ref_num, string $card_number, int $tracking_code): int
    {
        $payload = [
            "ref_num" => $ref_num,
            "amount" => $amount,
            "sign" => $this->makeSign("{$amount}#{$ref_num}#{$card_number}#{$tracking_code}"),
        ];

        $response = $this->httpClient->post("verify", $payload);

        return intval($response->json('status'));
    }



    private function makeSign(string $data, string $algo = 'SHA512', string $key = null): string
    {
        return hash_hmac($algo, $data, $key ?? $this->signKey());
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
