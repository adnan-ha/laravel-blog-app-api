<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
  Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('login');
  Route::post('/', [AdminAuthController::class, 'login']);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
  // User
  Route::get('/users', [UserController::class, 'index'])->name('users.index');
  Route::post('/users', [UserController::class, 'store'])->name('users.store');
  Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
  Route::put('/users/{user}/block', [UserController::class, 'block'])->name('users.block');
  Route::put('/users/{user}/unblock', [UserController::class, 'unblock'])->name('users.unblock');

  // Categories
  Route::resource('categories', CategoryController::class);

  // Tags
  Route::resource('tags', TagController::class);

  //
  Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});
