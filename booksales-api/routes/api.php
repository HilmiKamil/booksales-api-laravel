<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

//============== Public ===============//

//Book
Route::apiResource('/books', BookController::class)->only(['index', 'show']);

//Genre
Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);

//Author
Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);

//============== Only Admin ===============//

Route::middleware(['auth:api'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        //Book
        Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);
        //Genre
        Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);
        //Author
        Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);
    });
});
