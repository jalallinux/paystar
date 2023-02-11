<?php

namespace Tests\Feature\Controller\Api\Payment;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use WithFaker;

    public function test_payment_index_success()
    {
        $this->actingAs(User::query()->inRandomOrder()->firstOrFail());

        $response = $this->get(route('api.payment.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'status' => [
                            'label',
                            'value',
                        ],
                        'amount',
                        'tracking_code',
                        'card_number',
                        'created_at',
                    ]
                ],
                'links',
                'meta' => [
                    'current_page',
                    'last_page',
                    'per_page',
                    'total',
                ]
            ]);
    }

    public function test_payment_index_failed_guest()
    {
        $response = $this->get(route('api.payment.index'));

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
