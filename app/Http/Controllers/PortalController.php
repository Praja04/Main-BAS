<?php

namespace App\Http\Controllers;

use App\Models\UserPortal;
use Illuminate\Http\Request;
use Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class PortalController extends Controller
{
    // Show form untuk manage portal credentials
    public function index()
    {
        $user = auth()->user();
        $portals = $user->portals()->get();
        return view('portals.index', ['portals' => $portals]);
    }

    // Store/Update portal credentials
    public function store(Request $request)
    {
        $validated = $request->validate([
            'portal_name' => 'required|string|max:255',
            'portal_url' => 'required|url',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        auth()->user()->portals()->updateOrCreate(
            ['portal_name' => $validated['portal_name']],
            [
                'portal_url' => $validated['portal_url'],
                'username' => $validated['username'],
                'password' => $validated['password'],
            ]
        );

        return redirect()->back()->with('success', 'Portal credential berhasil disimpan');
    }

    // Get login form - Direct POST without CSRF fetching
    public function login($id)
    {
        $portal = auth()->user()->portals()
            ->where('id', $id)
            ->firstOrFail();

        $password = decrypt($portal->password);
        $portalUrl = rtrim($portal->portal_url, '/');

        // Cek berbagai kemungkinan login endpoint
        $loginEndpoints = [
            $portalUrl . '/login',
            $portalUrl . '/authenticate',
            $portalUrl . '/api/login',
            $portalUrl . '/user/login',
        ];

        \Log::info('Portal: ' . $portal->portal_name);
        \Log::info('Portal URL: ' . $portalUrl);
        \Log::info('Username: ' . $portal->username);
        \Log::info('Login Endpoints: ' . json_encode($loginEndpoints));

        return view('portals.login-form', [
            'portal' => $portal,
            'password' => $password,
            'portalUrl' => $portalUrl,
            'loginEndpoints' => $loginEndpoints,
        ]);
    }

    // Delete portal credential
    public function destroy($id)
    {
        UserPortal::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Portal credential berhasil dihapus');
    }
}
