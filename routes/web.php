<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Pengelola\CategoryController as PengelolaCategoryController;
use App\Http\Controllers\Pengelola\DashboardController as PengelolaDashboardController;
use App\Http\Controllers\Pengelola\EventController as PengelolaEventController;
use App\Http\Controllers\Pengelola\RegistrationController as PengelolaRegistrationController;
use App\Http\Controllers\Peserta\DashboardController as PesertaDashboardController;
use App\Http\Controllers\Peserta\RegistrationController as PesertaRegistrationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/events/{event}', [LandingController::class, 'show'])->name('events.show');
Route::middleware('auth')->get('/dashboard', function () {
    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'pengelola' => redirect()->route('pengelola.dashboard'),
        default => redirect()->route('peserta.dashboard'),
    };
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Peserta Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [PesertaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/registrations', [PesertaRegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/events/{event}/register', [PesertaRegistrationController::class, 'store'])->name('events.register');
    Route::delete('/registrations/{registration}', [PesertaRegistrationController::class, 'destroy'])->name('registrations.destroy');
});

/*
|--------------------------------------------------------------------------
| Pengelola Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pengelola'])->prefix('pengelola')->name('pengelola.')->group(function () {
    Route::get('/dashboard', [PengelolaDashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', PengelolaEventController::class);
    Route::resource('categories', PengelolaCategoryController::class);

    // Manajemen peserta pendaftaran per event
    Route::get('/events/{event}/registrations', [PengelolaRegistrationController::class, 'index'])->name('events.registrations');
    Route::patch('/registrations/{registration}/status', [PengelolaRegistrationController::class, 'updateStatus'])->name('registrations.update-status');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('events', AdminEventController::class);
    Route::get('/events/{event}/registrations', [AdminRegistrationController::class, 'index'])->name('events.registrations');
    Route::patch('/registrations/{registration}/status', [AdminRegistrationController::class, 'updateStatus'])->name('registrations.update-status');
});

/*
|--------------------------------------------------------------------------
| Authenticated User Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
