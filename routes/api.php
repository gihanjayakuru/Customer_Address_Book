<?php

use App\Http\Controllers\API\CustomerApiController;
use App\Http\Controllers\API\ProjectApiController;
use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [ApiAuthController::class, 'register'])->name('api.register');
Route::post('login', [ApiAuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [ApiAuthController::class, 'logout'])->name('api.logout');
    Route::apiResource('customers', CustomerApiController::class);
    Route::apiResource('projects', ProjectApiController::class);
});
