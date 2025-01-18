<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\TokenController;

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

Route::post('login', [TokenController::class, 'login']);

/* Route::middleware('auth:sanctum')->group(function () { */
    Route::get('/quiz', [QuizController::class, 'index']);
    Route::post('/quiz/submit', [QuizController::class, 'submit']);
/* }); */