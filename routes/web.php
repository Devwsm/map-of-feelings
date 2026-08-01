<?php

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\pressconController;
use App\Http\Controllers\pressconGuestController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', [homeController::class, 'home'])->name('home');
});

Route::prefix('/')->group(function () {
    Route::get('/login', [loginController::class, 'create'])->name('login');
    Route::post('/login', [loginController::class, 'store'])->name('login.store');
    Route::post('/logout', [loginController::class, 'destroy'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index'])->name('dashboard');

    // Cuma admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard/tamu', [pressconGuestController::class, 'index'])->name('dashboard.tamu');
        Route::get('/dashboard/tamu/create', [pressconGuestController::class, 'create'])->name('dashboard.tamu.create');
        Route::post('/dashboard/tamu', [pressconGuestController::class, 'store'])->name('dashboard.tamu.store');
        Route::get('/dashboard/tamu/{guest}/edit', [pressconGuestController::class, 'edit'])->name('dashboard.tamu.edit');
        Route::put('/dashboard/tamu/{guest}', [pressconGuestController::class, 'update'])->name('dashboard.tamu.update');
        Route::delete('/dashboard/tamu/{guest}', [pressconGuestController::class, 'destroy'])->name('dashboard.tamu.destroy');
    });

    // Admin & staff berdua boleh
    Route::middleware('role:admin,staff')->group(function () {
        // Route::get('/dashboard/checkin', [...])->name('dashboard.checkin');
    });

    Route::middleware('role:panel')->group(function () {
        Route::get('/dashboard/panel', [homeController::class, 'panel'])->name('dashboard.panel');
        Route::get('/dashboard/panel/{mood}/edit', [homeController::class, 'editPanel'])->name('dashboard.panel.edit');
        Route::put('/dashboard/panel/{mood}', [homeController::class, 'updatePanel'])->name('dashboard.panel.update');
    });
});

Route::prefix('/presscon-inv')->group(function () {
    Route::get('/', [pressconController::class, 'landing'])->name('presscon-inv.landing');
    Route::get('/{guest}', [pressconGuestController::class, 'show'])->name('presscon-inv.guest');
    Route::post('/{guest}/rsvp', [pressconGuestController::class, 'rsvp'])->name('presscon-inv.rsvp');
});