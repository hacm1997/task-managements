<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\TaskController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class)->except(['destroy']); //CRUD routes

    Route::get('tasks/{task}', [TaskController::class, 'show']);

    //routh for marking tasks as completed and not compelted
    Route::put('tasks/{task}/complete/{complete}', [TaskController::class, 'markAsCompleted']);

    Route::put('tasks/{task}/update', [TaskController::class, 'update']);

    //routh only admin user
    Route::delete('tasks/{task}', [TaskController::class, 'destroy']);

    Route::get('test', function () {
        return response()->json(['message' => 'API is working!']);
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->group(function () {
    Route::post('login', [CustomAuthController::class, 'login'])->name('custom.login');
    Route::post('register', [CustomAuthController::class, 'register']);
});
