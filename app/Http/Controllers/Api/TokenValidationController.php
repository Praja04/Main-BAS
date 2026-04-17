<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PortalTokenService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TokenValidationController extends Controller
{
    protected PortalTokenService $tokenService;

    public function __construct(PortalTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * Endpoint SSO verifikasi token.
     * Dipanggil oleh portal consumer (Warehouse, Engineering, dll.)
     * setelah menerima ?token=xxx dari URL callback.
     *
     * Request: POST /api/sso/verify
     * Headers: X-SSO-Secret: {SSO_SECRET_KEY dari .env}
     * Body:    { "token": "xxx" }
     *
     * Response sukses: { "success": true, "user_data": {...} }
     * Response gagal:  { "success": false, "message": "..." }
     */
    public function verify(Request $request)
    {
        // Validasi shared secret key
        $secret         = $request->header('X-SSO-Secret');
        $expectedSecret = config('app.sso_secret_key');

        if (!$secret || $secret !== $expectedSecret) {
            Log::warning('SSO: Percobaan verifikasi dengan secret key tidak valid', [
                'ip' => $request->ip(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Validasi input
        $request->validate([
            'token' => 'required|string|size:64',
        ]);

        $userData = $this->tokenService->verifyToken($request->input('token'));

        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah kadaluarsa',
            ], 401);
        }

        return response()->json([
            'success'   => true,
            'user_data' => $userData,
        ]);
    }
}
