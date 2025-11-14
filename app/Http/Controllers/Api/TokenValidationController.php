<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PortalTokenService;
use Illuminate\Http\Request;

class TokenValidationController extends Controller
{
    protected PortalTokenService $tokenService;

    public function __construct(PortalTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function validateToken(Request $request)
    {
        $token = $request->input('token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan',
            ], 400);
        }

        $userData = $this->tokenService->validateToken($token);

        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah kadaluarsa',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user_data' => $userData,
        ]);
    }
}
