<?php

namespace App\Services;

use App\Models\PortalToken;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PortalTokenService
{
    /**
     * Portal registry — single source of truth for all portal URLs.
     * Ambil dari .env jika tersedia, fallback ke localhost + port default.
     */
    protected function portals(): array
    {
        return [
            'engineering' => [
                // 'base_url' => env('PORTAL_ENGINEERING_URL', 'http://localhost:8090'),
                'base_url' => env('PORTAL_ENGINEERING_URL', 'http://10.11.10.130:8090'),
                'callback' => '/auth/sso/callback',
                'label'    => 'Engineering',
            ],
            'warehouse' => [
                // 'base_url' => env('PORTAL_WAREHOUSE_URL', 'http://localhost:8087'),
                'base_url' => env('PORTAL_WAREHOUSE_URL', 'http://10.11.10.130:8087'),
                'callback' => '/auth/sso/callback',
                'label'    => 'Warehouse',
            ],
            'production' => [
                // 'base_url' => env('PORTAL_PRODUCTION_URL', 'http://localhost:8095'),
                'base_url' => env('PORTAL_PRODUCTION_URL', 'http://10.11.10.130:8095'),
                'callback' => '/auth/sso/callback',
                'label'    => 'Production',
            ],
            'qc' => [
                // 'base_url' => env('PORTAL_QC_URL', 'http://localhost:8081'),
                'base_url' => env('PORTAL_QC_URL', 'http://10.11.10.130:8081'),
                'callback' => '/auth/sso/callback',
                'label'    => 'Quality Control',
            ],
        ];
    }

    /**
     * Cek apakah portal key valid.
     */
    public function isValidPortal(string $portalTarget): bool
    {
        return isset($this->portals()[$portalTarget]);
    }

    /**
     * Dapatkan semua definisi portal (untuk tampilan dashboard).
     */
    public function getPortals(): array
    {
        return array_map(fn($p) => [
            'base_url' => $p['base_url'],
            'label'    => $p['label'],
        ], $this->portals());
    }

    /**
     * Generate one-time SSO token untuk user targeting portal tertentu.
     */
    public function generateToken(User $user, string $portalTarget): PortalToken
    {
        // Hapus token lama yang belum dipakai untuk user & portal yang sama
        PortalToken::where('user_id', $user->id)
            ->where('portal_target', $portalTarget)
            ->where('used', false)
            ->delete();

        return PortalToken::create([
            'token'         => Str::random(64),
            'user_id'       => $user->id,
            'portal_target' => $portalTarget,
            'user_data'     => [
                'id'         => $user->id,
                'username'   => $user->username,
                'email'      => $user->email,
                'name'       => $user->nama_lengkap ?? $user->username,
                'nik'        => $user->nik,
                'jabatan'    => $user->jabatan,
                'departemen' => $user->departemen,
                'bagian'     => $user->bagian,
            ],
            'expires_at' => now()->addMinutes(5),
        ]);
    }

    /**
     * Generate URL redirect browser ke portal SSO callback.
     * Ini yang dipakai setelah user menekan tombol portal di dashboard.
     * $path: Opsional path tujuan di portal target (misal: /inventory/items/1)
     */
    public function generateRedirectUrl(User $user, string $portalTarget, ?string $path = null): ?string
    {
        $portals = $this->portals();
        $portal  = $portals[$portalTarget] ?? null;

        if (!$portal) {
            Log::warning("SSO: Portal target tidak dikenal [{$portalTarget}]");
            return null;
        }

        $token = $this->generateToken($user, $portalTarget);

        $callbackUrl = rtrim($portal['base_url'], '/') . $portal['callback'] . '?token=' . $token->token;

        if ($path) {
            $callbackUrl .= '&next=' . urlencode($path);
        }

        Log::info("SSO: Token dihasilkan untuk [{$portalTarget}]", [
            'user'         => $user->username,
            'callback_url' => $callbackUrl,
        ]);

        return $callbackUrl;
    }

    /**
     * Verifikasi token — dipanggil oleh portal consumer via POST /api/sso/verify.
     * Return user_data jika valid, null jika tidak valid/expired.
     */
    public function verifyToken(string $token): ?array
    {
        $portalToken = PortalToken::where('token', $token)->first();

        if (!$portalToken || !$portalToken->isValid()) {
            Log::warning("SSO: Token tidak valid atau sudah expired", [
                'token_prefix' => substr($token, 0, 8) . '...',
            ]);
            return null;
        }

        $portalToken->markAsUsed();

        Log::info("SSO: Token berhasil diverifikasi", [
            'portal' => $portalToken->portal_target,
            'user'   => $portalToken->user_data['username'] ?? 'unknown',
        ]);

        return $portalToken->user_data;
    }
}
