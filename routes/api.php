<?php

use App\Http\Controllers\TaskAPIController;
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
Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    // Task management routes
    Route::get('tasks', [TaskAPIController::class, 'index']);
    Route::post('tasks', [TaskAPIController::class, 'store']);
    Route::put('tasks/{task}', [TaskAPIController::class, 'update']);
    Route::delete('tasks/{task}', [TaskAPIController::class, 'destroy']);
});