<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RfidLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RfidLogController extends Controller
{
    /**
     * Menyimpan data scan RFID.
     *
     * Request: POST /api/rfid
     * Body:    { "sn_card": "ABC123DEF456" }
     *
     * Response sukses: { "success": true, "message": "...", "data": {...} }
     * Response gagal:  { "success": false, "message": "...", "errors": {...} }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sn_card' => 'required|string|max:255',
        ]);

        try {
            $rfidLog = RfidLog::create([
                'sn_card'   => $validated['sn_card'],
                'timestamp' => now(),
            ]);

            Log::info('RFID: Data scan berhasil disimpan', [
                'sn_card' => $rfidLog->sn_card,
                'id'      => $rfidLog->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data RFID berhasil disimpan',
            ], 201);

        } catch (\Exception $e) {
            Log::error('RFID: Gagal menyimpan data scan', [
                'sn_card' => $validated['sn_card'],
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data RFID',
            ], 500);
        }
    }
}
