<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ReviewController;


Route::post('/register', [ AuthController::class, 'register' ]);
Route::post('/login', [ AuthController::class, 'login' ]);
Route::get('/logout', [ AuthController::class, 'logout' ]);
Route::get('/user_profile', [ AuthController::class, 'index' ])->middleware('auth:sanctum');

// decrypt the cookie for front-end developer
Route::get('/decrypt', [ AuthController::class, 'decrypt' ]);

// books
Route::post('/book/create', [ BookController::class, 'store' ])->middleware('auth:sanctum');
Route::get('/books', [ BookController::class, 'index']);
Route::get('/books/{search}', [ BookController::class, 'show']);
Route::put('/book/edit/{id}', [ BookController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/book/delete/{id}', [ BookController::class,'destroy'])->middleware('auth:sanctum');

// reviews
Route::get('/reviews/book/{id}', [ ReviewController::class, 'index' ]);
Route::post('/review/create/{id}', [ ReviewController::class, 'store' ])->middleware('auth:sanctum');
Route::put('/review/edit/{id}', [ ReviewController::class, 'update' ])->middleware('auth:sanctum');
Route::delete('/review/delete/{id}', [ ReviewController::class, 'destroy' ])->middleware('auth:sanctum');