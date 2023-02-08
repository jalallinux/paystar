<?php

use App\Http\Controllers\Api\AuthController;
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
