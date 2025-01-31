<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\NewsApiController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('passwordReset', [AuthController::class, 'resetPassword']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//articals
Route::get('/articles', [ArticlesController::class, 'index']); // Fetch all articles
Route::get('/articles/{id}', [ArticlesController::class, 'show']); // Fetch a single article


//new api 
Route::get('/news/top-headlines', [NewsApiController::class, 'topHeadlines']);
Route::get('/news/all-articles', [NewsApiController::class, 'allArticles']);
Route::get('/news/sources', [NewsApiController::class, 'sources']);

