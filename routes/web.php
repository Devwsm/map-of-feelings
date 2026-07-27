<?php

use App\Http\Controllers\homeController;
use App\Http\Controllers\pressconController;
use App\Http\Controllers\pressconGuestController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', [homeController::class, 'home'])->name('home');
});

Route::prefix('/presscon-inv')->group(function () {
    Route::get('/', [pressconController::class, 'landing'])->name('presscon-inv.landing');
    Route::get('/{guest}', [pressconGuestController::class, 'show'])->name('presscon-inv.guest');
    Route::post('/{guest}/rsvp', [pressconGuestController::class, 'rsvp'])->name('presscon-inv.rsvp');
});