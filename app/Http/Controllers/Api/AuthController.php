<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Resources\Api\Auth\MeResource;
use App\Http\Resources\Api\Auth\TokenResource;
use Illuminate\Auth\AuthenticationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $ttl = config('jwt.ttl');
        $token = auth()->setTTL($ttl)->attempt($request->safe()->toArray());

        throw_if(!$token, new AuthenticationException);

        return new TokenResource($token);
    }

    public function refresh()
    {
        $ttl = config('jwt.refresh_ttl');
        return new TokenResource(auth()->setTTL($ttl)->refresh());
    }

    public function me()
    {
        return new MeResource(auth()->user());
    }

    public function logout()
    {
        auth()->logout();
        return response()->noContent();
    }
}
