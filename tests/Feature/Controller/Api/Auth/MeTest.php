<?php

namespace Tests\Feature\Controller\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeTest extends TestCase
{
    use WithFaker;

    const EMAIL = 'smjjalalzadeh93@gmail.com';
    const PASSWORD = 'password';

    private function fetchToken(): string
    {
        return $this->post(route('api.auth.login'), [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ])->json('data.access_token');
    }

    public function test_me_success()
    {
        $response = $this->get(route('api.auth.me'), [
            'Authorization' => "Bearer {$this->fetchToken()}"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'uuid',
                    'name',
                    'email',
                    'balance',
                    'created_at',
                ]
            ]);
    }

    public function test_me_failed_invalid_token()
    {
        $response = $this->get(route('api.auth.me'), [
            'Authorization' => "Bearer {$this->faker->streetName}"
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }
}
