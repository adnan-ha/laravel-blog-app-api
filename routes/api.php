<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::middleware(['guest:sanctum'])->group(function () {
  Route::post('/register', [AuthController::class, 'register']);
  Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Posts & Comments & categories & tags
Route::middleware(['auth:sanctum', 'not_blocked'])->group(function () {
  Route::get('/posts', [PostController::class, 'index']);
  Route::post('/posts', [PostController::class, 'store']);
  Route::get('/posts/{id}', [PostController::class, 'show']);
  Route::put('/posts/{id}', [PostController::class, 'update']);
  Route::delete('/posts/{id}', [PostController::class, 'destroy']);

  // comments
  Route::get('/comments/{PostID}', [CommentController::class, 'index']);
  Route::post('/comments', [CommentController::class, 'store']);
  Route::put('/comments/{id}', [CommentController::class, 'update']);
  Route::delete('/comments/{id}', [CommentController::class, 'destroy']);

  // categories
  Route::get('/categories', [CategoryController::class, 'index']);
  Route::get('/categories/{id}', [CategoryController::class, 'show']);

  // tags
  Route::get('/tags', [TagController::class, 'index']);
  Route::get('/tags/{id}', [TagController::class, 'show']);
});
