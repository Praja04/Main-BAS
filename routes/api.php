<?php

use App\Http\Controllers\Api\DataIdcardController;
use App\Http\Controllers\Api\RfidLogController;
use App\Http\Controllers\Api\TokenValidationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * SSO Verification Endpoint (tidak pakai auth middleware - portal tidak punya session Main-BAS)
 * Diproteksi menggunakan X-SSO-Secret header.
 */
Route::post('/sso/verify', [TokenValidationController::class, 'verify'])
    ->name('api.sso.verify');

/**
 * RFID Endpoint - Menyimpan data scan kartu RFID (SN Card)
 */
Route::post('/rfid', [RfidLogController::class, 'store'])
    ->name('api.rfid.store');

/**
 * Data ID Card Endpoint - Mendapatkan list semua SN Card
 */
Route::get('/data-idcard', [DataIdcardController::class, 'index'])
    ->name('api.data-idcard.index');

/**
 * User info (untuk portal yang sudah punya Sanctum token - opsional)
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'user'    => [
                'id'         => $request->user()->id,
                'username'   => $request->user()->username,
                'email'      => $request->user()->email,
                'nik'        => $request->user()->nik,
                'jabatan'    => $request->user()->jabatan,
                'departemen' => $request->user()->departemen,
                'bagian'     => $request->user()->bagian,
            ],
        ]);
    });
});
