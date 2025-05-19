<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Auth;

// Dashboard pengguna
Route::get('/user', [DashboardController::class, 'index'])->name('user.dashboard');

// Redirect root ke login admin
Route::get('/', fn() => redirect()->route('admin.login'));

// Authentication admin (login & logout) — tanpa middleware 'auth'
Route::prefix('admin')->name('admin.')->group(function() {
    Route::get('login',  [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('logout',[AuthController::class, 'logout'])->name('logout');
});

// Semua route yang butuh authentication
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function() {
    // Profile
    Route::get('profile/edit',   [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::post('profile/update',[AuthController::class, 'updateProfile'])->name('profile.update');

    // Form & proses import Excel
    Route::get('alumni/import',     [AlumniController::class, 'showImportForm'])->name('alumni.import-form');
    Route::post('alumni/import',    [AlumniController::class, 'import'])->name('alumni.import');

    // Download template dan sample acak
    Route::get('alumni/template',        [AlumniController::class, 'template'])->name('alumni.template');
    Route::get('alumni/sample-random',   [AlumniController::class, 'generateRandomExcel'])
         ->name('alumni.generate-sample');

    // Export data alumni
    Route::get('alumni/export',      [AlumniController::class, 'export'])->name('alumni.export');

    // Resource routes untuk CRUD alumni, kecualikan 'show' jika tidak dipakai
    Route::resource('alumni', AlumniController::class)
         ->except(['show']);

    // Laporan
    Route::get('reports',        [ReportController::class, 'index'])->name('reports');
    Route::post('reports/filter',[ReportController::class, 'filter'])->name('reports.filter');
    Route::get('reports/excel',  [ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::get('reports/pdf',    [ReportController::class, 'exportPdf'])->name('reports.pdf');
});
// Authentication Routes (single instance)
Auth::routes();

// Home route (single instance)
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
