<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PortalTokenService;

class DashboardController extends Controller
{
    protected PortalTokenService $tokenService;

    public function __construct(PortalTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function index()
    {
        $user    = Auth::user();
        $portals = $this->tokenService->getPortals();

        return view('dashboard', [
            'user'    => $user,
            'portals' => $portals,
        ]);
    }

    /**
     * Generate SSO token dan redirect browser langsung ke portal tujuan.
     * Portal kemudian akan pull-verify token ke endpoint /api/sso/verify Main-BAS.
     */
    public function generateTokenRedirect(Request $request, $target)
    {
        if (!$this->tokenService->isValidPortal($target)) {
            return back()->with('error', 'Portal tidak valid.');
        }

        $user        = Auth::user();
        $path        = $request->query('redirect'); // Ambil path tujuan (misal: /inventory/items/1)
        $redirectUrl = $this->tokenService->generateRedirectUrl($user, $target, $path);

        if (!$redirectUrl) {
            return back()->with('error', 'Gagal generate token SSO untuk portal ini.');
        }

        // Redirect browser langsung ke portal — portal yang akan verifikasi token ke Main-BAS
        return redirect()->away($redirectUrl);
    }
}
