<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getWarehouseNotifications()
    {
        $user = auth()->user();
        if (!$user) return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);

        try {
            // URL warehouse app. Ganti sesuai environment jika perlu.
            $warehouseUrl = 'http://10.11.10.130:8087';

            $response = \Illuminate\Support\Facades\Http::get($warehouseUrl . '/api/notifications/external/get-data', [
                'username' => $user->username,
                'departemen' => $user->departemen,
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke Warehouse system: ' . $e->getMessage()
            ], 500);
        }
    }
}
