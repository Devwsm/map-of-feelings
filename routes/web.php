<?php

use App\Http\Controllers\checkinController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\importExportController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\pressconController;
use App\Http\Controllers\pressconGuestController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
    Route::get('/', [homeController::class, 'home'])->name('home');
    Route::post('/coordinate', [homeController::class, 'storeCoordinate'])->name('coordinate.store');
});

Route::prefix('/')->group(function () {
    Route::get('/login', [loginController::class, 'create'])->name('login');
    Route::post('/login', [loginController::class, 'store'])->name('login.store');
    Route::post('/logout', [loginController::class, 'destroy'])->name('logout');
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    // Admin & staff berdua boleh
    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/', [dashboardController::class, 'index'])->name('dashboard');
        Route::get('/checkin', [checkinController::class, 'index'])->name('dashboard.checkin');
        Route::get('/checkin/search', [checkinController::class, 'search'])->name('dashboard.checkin.search');
        Route::post('/checkin/{guest}', [checkinController::class, 'store'])->name('dashboard.checkin.store');
    });

    // Cuma admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/tamu', [pressconGuestController::class, 'index'])->name('dashboard.tamu');
        Route::get('/tamu/create', [pressconGuestController::class, 'create'])->name('dashboard.tamu.create');
        Route::post('/tamu', [pressconGuestController::class, 'store'])->name('dashboard.tamu.store');
        Route::get('/tamu/{guest}/edit', [pressconGuestController::class, 'edit'])->name('dashboard.tamu.edit');
        Route::put('/tamu/{guest}', [pressconGuestController::class, 'update'])->name('dashboard.tamu.update');
        Route::delete('/tamu/{guest}', [pressconGuestController::class, 'destroy'])->name('dashboard.tamu.destroy');
        Route::post('/dashboard/tamu/{guest}/generate-qr', [pressconGuestController::class, 'generateQr'])->name('dashboard.tamu.generate-qr');

        Route::get('/export', [importExportController::class, 'index'])->name('dashboard.export');
        Route::get('/export/database', [importExportController::class, 'exportDatabase'])->name('dashboard.export.database');
        Route::get('/export/database/preview', [importExportController::class, 'previewDatabase'])->name('dashboard.export.database.preview');

        Route::get('/export/mood-submissions/excel', [importExportController::class, 'exportMoodSubmissionsExcel'])->name('dashboard.export.mood-submissions.excel');
        Route::get('/export/mood-submissions/pdf', [importExportController::class, 'exportMoodSubmissionsPdf'])->name('dashboard.export.mood-submissions.pdf');
        Route::get('/export/mood-submissions/preview', [importExportController::class, 'previewMoodSubmissions'])->name('dashboard.export.mood-submissions.preview');

        Route::get('/export/guest-checkin/excel', [importExportController::class, 'exportGuestCheckinExcel'])->name('dashboard.export.guest-checkin.excel');
        Route::get('/export/guest-checkin/pdf', [importExportController::class, 'exportGuestCheckinPdf'])->name('dashboard.export.guest-checkin.pdf');
        Route::get('/export/guest-checkin/preview', [importExportController::class, 'previewGuestCheckin'])->name('dashboard.export.guest-checkin.preview');
    });

    // panel & admin berdua boleh
    Route::middleware('role:panel,admin')->group(function () {
        Route::get('/panel', [homeController::class, 'panel'])->name('dashboard.panel');
        Route::get('/panel/submissions', [homeController::class, 'submissions'])->name('dashboard.panel.submissions');
        Route::get('/panel/{mood}/edit', [homeController::class, 'editPanel'])->name('dashboard.panel.edit');
        Route::put('/panel/{mood}', [homeController::class, 'updatePanel'])->name('dashboard.panel.update');
    });
});

Route::prefix('/presscon-inv')->group(function () {
    Route::get('/', [pressconController::class, 'landing'])->name('presscon-inv.landing');
    Route::get('/{guest}', [pressconGuestController::class, 'show'])->name('presscon-inv.guest');
    Route::post('/{guest}/rsvp', [pressconGuestController::class, 'rsvp'])->name('presscon-inv.rsvp');
});