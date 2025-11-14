<?php

namespace App\Services;

use App\Models\PortalToken;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PortalTokenService
{
    protected array $portalEndpoints = [
        'engineering' => [
            'base_url' => 'http://10.11.10.130:8090/engineering/public',
            'api_endpoint' => '/api/auth/validate-token',
        ],
        'warehouse' => [
            'base_url' => 'http://10.11.10.130:8087/warehouse/public',
            'api_endpoint' => '/api/auth/validate-token',
        ],
        'production' => [
            'base_url' => 'http://10.11.10.130:8095/production/public',
            'api_endpoint' => '/api/auth/validate-token',
        ],
        'qc' => [
            'base_url' => 'http://10.11.10.130:8081',
            'api_endpoint' => '/api/auth/validate-token',
        ],
    ];

    /**
     * Generate token untuk portal tertentu
     */
    public function generateToken(User $user, string $portalTarget): PortalToken
    {
        // Hapus token lama yang belum digunakan untuk user & portal yang sama
        PortalToken::where('user_id', $user->id)
            ->where('portal_target', $portalTarget)
            ->where('used', false)
            ->delete();

        $token = PortalToken::create([
            'token' => Str::random(64),
            'user_id' => $user->id,
            'portal_target' => $portalTarget,
            'user_data' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'name' => $user->name,
                'nik' => $user->nik,
                'jabatan' => $user->jabatan,
                'departemen' => $user->departemen,
                'bagian' => $user->bagian,
            ],
            'expires_at' => now()->addMinutes(5), // Token valid 5 menit
        ]);

        return $token;
    }

    /**
     * Kirim token ke portal target untuk validasi
     */
    public function sendTokenToPortal(PortalToken $portalToken): array
    {
        $portal = $this->portalEndpoints[$portalToken->portal_target] ?? null;

        if (!$portal) {
            return [
                'success' => false,
                'message' => 'Portal tidak ditemukan',
            ];
        }

        try {
            $response = Http::timeout(10)
                ->post($portal['base_url'] . $portal['api_endpoint'], [
                    'token' => $portalToken->token,
                    'user_data' => $portalToken->user_data,
                    'expires_at' => $portalToken->expires_at->toIso8601String(),
                ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'success' => true,
                    'redirect_url' => $data['redirect_url'] ?? null,
                    'session_token' => $data['session_token'] ?? null,
                ];
            }

            Log::error('Portal token validation failed', [
                'portal' => $portalToken->portal_target,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Gagal menghubungi portal: ' . $response->status(),
            ];
        } catch (\Exception $e) {
            Log::error('Portal communication error', [
                'portal' => $portalToken->portal_target,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Error komunikasi dengan portal: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Validasi token (untuk dipanggil dari portal lain)
     */
    public function validateToken(string $token): ?array
    {
        $portalToken = PortalToken::where('token', $token)->first();

        if (!$portalToken || !$portalToken->isValid()) {
            return null;
        }

        // Mark token as used
        $portalToken->markAsUsed();

        return $portalToken->user_data;
    }
}
