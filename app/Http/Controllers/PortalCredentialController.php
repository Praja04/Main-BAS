<?php

namespace App\Http\Controllers;

use App\Models\PortalCredential;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalCredentialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Default portals
    private function getDefaultPortals()
    {
        return [
            [
                'portal_name' => 'Engineering',
                'portal_url' => 'http://10.11.10.130:8090/engineering/public',
                'icon' => '⚙️',
                'description' => 'Engineering Portal'
            ],
            [
                'portal_name' => 'Warehouse',
                'portal_url' => 'http://10.11.10.130:8087/warehouse/public',
                'icon' => '📦',
                'description' => 'Warehouse Management'
            ],
            [
                'portal_name' => 'QC',
                'portal_url' => 'http://10.11.10.130:8081/public',
                'icon' => '🔗',
                'description' => 'Portal 3'
            ],
            [
                'portal_name' => 'BAS EMPP',
                'portal_url' => 'http://10.11.10.130:8085/bas_empp/public',
                'icon' => '📋',
                'description' => 'BAS EMPP System'
            ],
            [
                'portal_name' => 'MY BAS ',
                'portal_url' => 'http://10.11.10.130:8093',
                'icon' => '🌐',
                'description' => 'Portal 5'
            ],
        ];
    }

    public function index()
    {
        $userId = Auth::id();
        $credentials = PortalCredential::where('user_id', $userId)
            ->where('is_active', true)
            ->get();

        // Tambahkan portal default yang belum tersimpan
        $defaultPortals = $this->getDefaultPortals();
        $portalNames = $credentials->pluck('portal_name')->toArray();

        foreach ($defaultPortals as $portal) {
            if (!in_array($portal['portal_name'], $portalNames)) {
                $credentials->push((object)[
                    'id' => null,
                    'portal_name' => $portal['portal_name'],
                    'portal_url' => $portal['portal_url'],
                    'icon' => $portal['icon'],
                    'description' => $portal['description'],
                    'username' => null,
                    'has_credential' => false,
                ]);
            }
        }

        return view('portals.index', compact('credentials'));
    }

    public function create()
    {
        $defaultPortals = $this->getDefaultPortals();
        return view('portals.create', compact('defaultPortals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'portal_name' => 'required|string|max:255',
            'portal_url' => 'required|url',
            'username' => 'required|string',
            'password' => 'required|string|min:6',
            'description' => 'nullable|string',
        ]);

        PortalCredential::create([
            'user_id' => Auth::id(),
            'portal_name' => $request->portal_name,
            'portal_url' => $request->portal_url,
            'username' => $request->username,
            'password' => $request->password,
            'description' => $request->description,
        ]);

        return redirect()->route('portals.index')->with('success', 'Kredensial berhasil disimpan');
    }

    public function edit(PortalCredential $portalCredential)
    {
        // Pastikan user hanya bisa edit kredensial miliknya
        if ($portalCredential->user_id !== Auth::id()) {
            abort(403);
        }

        return view('portals.edit', compact('portalCredential'));
    }

    public function update(Request $request, PortalCredential $portalCredential)
    {
        if ($portalCredential->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
            'description' => 'nullable|string',
        ]);

        $portalCredential->update([
            'username' => $request->username,
            'password' => $request->password,
            'description' => $request->description,
        ]);

        return redirect()->route('portals.index')->with('success', 'Kredensial berhasil diperbarui');
    }

    public function destroy(PortalCredential $portalCredential)
    {
        if ($portalCredential->user_id !== Auth::id()) {
            abort(403);
        }

        $portalCredential->delete();

        return redirect()->route('portals.index')->with('success', 'Kredensial berhasil dihapus');
    }
}
