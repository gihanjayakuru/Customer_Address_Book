<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProjectController;
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

Route::get('/', function () {
    return response()->json(['message' => 'Welcome to the application'], 200);
});

Route::post('register', [ApiAuthController::class, 'register']);
Route::post('login', [ApiAuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [ApiAuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('projects', ProjectController::class);
});
