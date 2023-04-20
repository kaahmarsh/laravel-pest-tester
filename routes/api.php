<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Interface\Users\Http\Controllers\UserController;

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

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class,'index']);
    Route::post('/', [UserController::class,'store']);
    Route::get('/{id}', [UserController::class,'show']);
    Route::patch('/{id}', [UserController::class,'update']);
    Route::delete('/{id}', [UserController::class,'delete']);
});
