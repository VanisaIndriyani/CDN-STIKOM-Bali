<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/user', [DashboardController::class, 'index'])->name('user.dashboard');

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Semua route admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Login & Logout
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // ✅ Profile admin (edit & update)
        Route::get('/profile/edit', [AuthController::class, 'editProfile'])->name('profile.edit');
        // Change from PUT to POST for profile update
        Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

        // Manajemen alumni
        Route::resource('alumni', AlumniController::class)->except(['create', 'store', 'show']);
        Route::get('/alumni/export', [AlumniController::class, 'export'])->name('alumni.export');
     // ✅ ⬇️ Tambahkan ini untuk proses import file Excel
    Route::get('/alumni/import', function () {
        return view('admin.alumni.import');
    })->name('alumni.import.form');

    Route::post('/alumni/import', [AlumniController::class, 'import'])->name('alumni.import');
    Route::delete('/admin/alumni/{id}', [AlumniController::class, 'destroy'])->name('admin.alumni.destroy');



        // Laporan
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::post('/reports/filter', [ReportController::class, 'filter'])->name('reports.filter');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    });

// Authentication Routes
Auth::routes();

// Custom logout route
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
