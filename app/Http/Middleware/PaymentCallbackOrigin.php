<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PaymentCallbackOrigin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function handle(Request $request, Closure $next)
    {
        throw_if(
            app()->environment('production') &&
            parse_url($request->header('origin'), PHP_URL_HOST) != config('services.paystar.origin'),
            new AuthorizationException
        );
        return $next($request);
    }
}
