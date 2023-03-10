<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Middleware\PaymentCallbackOrigin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('auth.')->prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->middleware('guest')->name('login');

    Route::middleware('auth:api')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::get('refresh', [AuthController::class, 'refresh'])->name('refresh');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

Route::middleware('auth:api')->group(function () {

    Route::apiResource('payment', PaymentController::class)->except('destroy');

});

Route::middleware(PaymentCallbackOrigin::class)
    ->post('payment/{payment}/callback', [PaymentController::class, 'callback'])
    ->name('payment.callback');
