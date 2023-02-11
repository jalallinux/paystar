<?php

namespace Tests\Feature\Controller\Api\Auth;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;

    const EMAIL = 'smjjalalzadeh93@gmail.com';
    const PASSWORD = 'password';

    public function test_login_success()
    {
        $response = $this->post(route('api.auth.login'), [
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'token_type',
                    'expires_at',
                ]
            ]);
    }

    public function test_login_failed_email()
    {
        $response = $this->post(route('api.auth.login'), [
            'email' => $this->faker->streetName,
            'password' => self::PASSWORD,
        ]);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email'
                ]
            ]);
    }

    public function test_login_failed_password()
    {
        $response = $this->post(route('api.auth.login'), [
            'email' => self::EMAIL,
            'password' => $this->faker->streetName,
        ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
            ]);
    }
}
