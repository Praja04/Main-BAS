<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/portal/{target}', [DashboardController::class, 'generateTokenRedirect'])->name('portal.redirect');
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
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        // Dashboard utama
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/boiler', [DashboardController::class, 'Dashboard_Boiler'])->name('boiler');
        Route::get('/utility', [DashboardController::class, 'Dashboard_Utility'])->name('utility');
        Route::get('/scoring', [DashboardController::class, 'Dashboard_scoring'])->name('scoring');

        // QC
        Route::get('/blending', [DashboardController::class, 'Dashboard_Blending'])->name('blending');
        Route::get('/disolver', [DashboardController::class, 'Dashboard_Disolver'])->name('disolver');
        Route::get('/monitoring-turun', [DashboardController::class, 'Dashboard_monitoring_turun'])->name('monitoring_turun');
        Route::get('/pasteurisasi', [DashboardController::class, 'Dashboard_Pasteurisasi'])->name('pasteurisasi');
        Route::get('/monitoring-storage', [DashboardController::class, 'Dashboard_monitoring_storage'])->name('monitoring_storage');
        Route::get('/rm', [DashboardController::class, 'Dashboard_RM'])->name('rm');

        // PRD
        Route::get('/pasteurisasi1', [DashboardController::class, 'Dashboard_pasteurisasi1'])->name('pasteurisasi1');
        Route::get('/pasteurisasi2', [DashboardController::class, 'Dashboard_pasteurisasi2'])->name('pasteurisasi2');
        Route::get('/retail', [DashboardController::class, 'Dashboard_retail'])->name('retail');
        Route::get('/downtime-retail', [DashboardController::class, 'Dashboard_downtime_retail'])->name('downtime_retail');

        // Warehouse
        Route::get('/p2h', [DashboardController::class, 'Dashboard_p2h'])->name('p2h');
        Route::get('/tkbm', [DashboardController::class, 'Dashboard_tkbm'])->name('tkbm');
        Route::get('/soh', [DashboardController::class, 'Dashboard_SOH'])->name('soh');
    });

    Route::prefix('mesin')->name('mesin.')->group(function () {
        Route::get('/daily-tank', [DashboardController::class, 'Mesin_DailyTank'])->name('daily-tank');
        Route::get('/pasteur1', [DashboardController::class, 'Mesin_Pasteur1'])->name('pasteur1');
        Route::get('/pasteur2', [DashboardController::class, 'Mesin_Pasteur2'])->name('pasteur2');
        Route::get('/disolver', [DashboardController::class, 'Mesin_Disolver'])->name('disolver');
        Route::get('/boiler', [DashboardController::class, 'Mesin_Boiler'])->name('boiler');
        Route::get('/glucose', [DashboardController::class, 'Mesin_Glucose'])->name('glucose');
    });

});



