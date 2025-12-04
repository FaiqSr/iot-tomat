<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\SensorDataController;
use App\Http\Controllers\Api\PredictController;
use App\Http\Middleware\AdminMiddleware;

// ---------------------------
// Public Routes
// ---------------------------
Route::view('/', 'page.landing-page.index')->name('home');
Route::view('/about', 'page.landing-page.about')->name('about');
Route::view('/panduan', 'page.landing-page.guide')->name('panduan');
Route::view('/contact', 'page.landing-page.contact')->name('contact');

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

    // Admin area: uses AdminController which performs role check in constructor
    Route::prefix('admin')->name('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('');

        // Users CRUD
        Route::get('/users', [AdminController::class, 'usersIndex'])->name('.users');
        Route::get('/users/create', [AdminController::class, 'usersCreate'])->name('.users.create');
        Route::post('/users', [AdminController::class, 'usersStore'])->name('.users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'usersEdit'])->name('.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'usersUpdate'])->name('.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'usersDestroy'])->name('.users.destroy');

        // Sensors CRUD
        Route::get('/sensors', [AdminController::class, 'sensorsIndex'])->name('.sensors');
        Route::get('/sensors/create', [AdminController::class, 'sensorsCreate'])->name('.sensors.create');
        Route::post('/sensors', [AdminController::class, 'sensorsStore'])->name('.sensors.store');
        Route::get('/sensors/{id}/edit', [AdminController::class, 'sensorsEdit'])->name('.sensors.edit');
        Route::put('/sensors/{id}', [AdminController::class, 'sensorsUpdate'])->name('.sensors.update');
        Route::delete('/sensors/{id}', [AdminController::class, 'sensorsDestroy'])->name('.sensors.destroy');
    })->middleware([AdminMiddleware::class]);

    Route::prefix('dashboard')->name('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('');



        Route::get('/tools/sensor', [DashboardController::class, 'showToolsSensor'])->name('.tools.sensor');
        Route::post('/tools/sensor', [DashboardController::class, 'storeSensorOwner'])->name('.tools.sensor.store');
        Route::get('/tools/sensor/{id}', [DashboardController::class, 'showSensorDetail'])->name('.tools.sensor.show');
        Route::put('/tools/sensor/{id}', [DashboardController::class, 'updateSensor'])->name('.tools.sensor.update');
        Route::delete('/tools/sensor/{id}', [DashboardController::class, 'destroySensor'])->name('.tools.sensor.destroy');
        // Sensor groups
        Route::post('/tools/sensor/group', [DashboardController::class, 'storeSensorGroup'])->name('.tools.sensor.group.store');
        Route::put('/tools/sensor/group/{group}', [DashboardController::class, 'updateSensorGroup'])->name('.tools.sensor.group.update');
        Route::get('/profile', [DashboardController::class, 'showProfile'])->name('.profile');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('.profile.update');
        Route::put('/profile/address', [UserController::class, 'updateAddress'])->name('.profile.address.update');

        Route::get('/analytic', [DashboardController::class, 'showAnalytic'])->name('.analytic');

    });

});

// Predictions web UI (authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/predictions', [\App\Http\Controllers\PredictionController::class, 'index'])->name('predictions.index');
    Route::get('/predictions/{id}', [\App\Http\Controllers\PredictionController::class, 'show'])->name('predictions.show');
});

Route::post('/api/sensor/firebase', [SensorDataController::class, 'store'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

// ML prediction proxy endpoint
Route::post('/api/predict', [PredictController::class, 'predict'])
    ->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);

Route::get('/predictions/{id}/download', [PredictController::class, 'download'])->name('predictions.download');
