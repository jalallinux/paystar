<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\MeResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $ttl = config('jwt.ttl');
        $token = auth()->setTTL($ttl)->attempt($request->safe()->toArray());

        throw_if(!$token, new AuthenticationException);

        return new JsonResource([
            'type' => 'Bearer',
            'expire_at' => now()->addMinutes($ttl)->timestamp,
            'token' => $token,
        ]);
    }

    public function refresh(Request $request)
    {
        $ttl = config('jwt.refresh_ttl');
        return new JsonResource([
            'type' => 'Bearer',
            'expire_at' => now()->addMinutes($ttl)->timestamp,
            'token' => auth()->setTTL($ttl)->refresh(),
        ]);
    }

    public function me(Request $request)
    {
        return new MeResource(auth()->user());
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return response()->noContent();
    }
}
