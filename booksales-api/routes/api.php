<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Book
Route::apiResource('/books', BookController::class);

//Genre
Route::apiResource('/genres', GenreController::class);

//Author
Route::apiResource('/authors', AuthorController::class);

