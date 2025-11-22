<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// ---------------------------
// Public Routes
// ---------------------------
Route::view('/', 'page.landing-page.index')->name('home');
Route::view('/about', 'page.landing-page.about')->name('about');
Route::view('/panduan', 'page.landing-page.guide')->name('panduan');
Route::view('/contact', 'page.landing-page.contact')->name('contact');

// ---------------------------
// Auth Routes
// ---------------------------
Route::get('/login', [AuthController::class,'loginForm'])->name('login');
Route::post('/login', [AuthController::class,'login'])->name('login.post');

Route::get('/register', [AuthController::class,'registerForm'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register.post');

Route::get('/forgot-password', [AuthController::class,'forgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class,'forgot'])->name('password.email');

Route::get('/logout', [AuthController::class,'logout'])->name('logout');

// ---------------------------
// Dashboard Routes (protected by auth)
// ---------------------------
Route::middleware(['auth'])->group(function () {

    Route::prefix('dashboard')->name('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'showAlatDashboard'])->name('');
        Route::get('/alat', [DashboardController::class, 'showSensorDashboard'])->name('.sensor');
        Route::get('/tools/alat', [DashboardController::class, 'showToolsAlat'])->name('.tools.alat');
        Route::get('/tools/sensor', [DashboardController::class, 'showToolsSensor'])->name('.tools.sensor');
        Route::get('/profile', [DashboardController::class, 'showProfile'])->name('.profile');
    });

});
