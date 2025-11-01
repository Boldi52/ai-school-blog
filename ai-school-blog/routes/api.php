<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\PostController;

Route::prefix('v1')->group(function () {
    Route::post('/posts', [PostController::class, 'store']);   
    Route::get('/posts', [PostController::class, 'index']);    
    Route::get('/posts/{post}', [PostController::class, 'show']); 

    Route::get('/posts/filter/stance/{stance}', [PostController::class, 'filterByStance']);
    Route::get('/posts/filter/author/{author}', [PostController::class, 'filterByAuthor']);
    Route::get('/posts/filter/tag/{tag}', [PostController::class, 'filterByTag']);
});
