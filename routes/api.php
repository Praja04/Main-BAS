<?php
use App\Http\Controllers\Api\TokenValidationController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/validate-token', [TokenValidationController::class, 'validate']);