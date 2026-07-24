<?php

use App\Http\Controllers\homeController;
use App\Http\Controllers\pressconController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', [homeController::class, 'home'])->name('home');
});

Route::prefix('/presscon-inv')->group(function () {
    Route::get('/', [pressconController::class, 'landing'])->name('landing');
    Route::get('/guest', [pressconController::class, 'guest'])->name('guest');
});