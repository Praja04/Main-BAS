<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/sso/redirect/{portal}', [AuthController::class, 'showLoginForm'])->name('sso.redirect');
Route::post('/portal/{target}', [DashboardController::class, 'generateTokenRedirect'])->name('portal.redirect');

//manage user
Route::middleware(['auth'])->group(function () {
    Route::prefix('users')->as('users.')->group(function () {
        Route::get('/index', [AuthController::class, 'manage_user'])->name('users.index');
        Route::get('/data', [AuthController::class, 'getUsers'])->name('get'); // API untuk DataTables
        Route::post('/', [AuthController::class, 'store'])->name('store'); // Simpan user baru
        Route::get('/{id}/edit', [AuthController::class, 'edit'])->name('edit'); // Ambil data user untuk edit
        Route::post('/{id}', [AuthController::class, 'update'])->name('update'); // Update user
        Route::delete('/{id}', [AuthController::class, 'destroy'])->name('destroy'); // Hapus user
    });
});

Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/change-password', function () {
            return view('profile.change-password');
        })->name('change-password');
        Route::post('/update-password', [ProfileController::class, 'changePassword'])->name('update-password');
    });

    ///////// Dashboard Routes /////////
    Route::prefix('home')->name('dashboard.')->group(function () {
        // Dashboard utama
        Route::get('/', [DashboardController::class, 'index'])->name('index');
    });
});
