<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataIdcard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DataIdcardController extends Controller
{
    /**
     * Menampilkan daftar SN card.
     *
     * GET /api/data-idcard
     */
    public function index()
    {
        try {
            // Ambil semua sn_card dari tabel data_idcard
            $snCards = DataIdcard::pluck('sn_card');

            return response()->json([
                'success' => true,
                'total'   => $snCards->count(),
                'data'    => $snCards,
            ], 200);

        } catch (\Exception $e) {
            Log::error('API: Gagal mengambil data sn_card', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data idcard',
            ], 500);
        }
    }
}
