<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReviewController;

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

Route::post('/register', [ AuthController::class, 'register' ]);
Route::post('/login', [ AuthController::class, 'login' ]);
Route::get('/logout', [ AuthController::class, 'logout' ]);
Route::post('/user_profile', [ AuthController::class, 'index' ]);
// decrypt the cookie for front-end developer
Route::get('/decrypt', [ AuthController::class, 'decrypt' ]);

// books
Route::post('/book/create', [ BookController::class, 'store' ]);
Route::get('/books', [ BookController::class, 'index']);
Route::get('/books/{search}', [ BookController::class, 'show']);
Route::put('/book/edit/{id}', [ BookController::class, 'update']);
Route::delete('/book/delete/{id}', [ BookController::class, 'destroy']);

// reviews
Route::get('/reviews/book/{id}', [ ReviewController::class, 'index' ]);
Route::post('/review/create/{id}', [ ReviewController::class, 'store' ]);
Route::put('/review/edit/{id}', [ ReviewController::class, 'update' ]);
Route::delete('/review/delete/{id}', [ ReviewController::class, 'destroy' ]);