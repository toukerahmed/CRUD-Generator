<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('orders', App\Http\Controllers\User\OrderController::class);
Route::apiResource('order1s', App\Http\Controllers\User\Order1Controller::class);
Route::apiResource('tasks', App\Http\Controllers\TaskController::class);
Route::apiResource('task1s', App\Http\Controllers\User\Task1Controller::class);