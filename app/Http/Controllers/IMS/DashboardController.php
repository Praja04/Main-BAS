<?php

namespace App\Http\Controllers\IMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\MasterDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display IMS Dashboard Statistics
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Hitung total request
        $query = DocumentRequest::query();

        if (strtolower($user->departemen) !== 'ims') {
            // Jika bukan IMS, hanya lihat statistik departemen sendiri
            $query->whereHas('user', function($q) use ($user) {
                $q->where('departemen', $user->departemen);
            });
        }

        // Statistik Status
        $totalRequests = (clone $query)->count();
        $pendingCount = (clone $query)->whereIn('status', ['Waiting Check...', 'Revise'])->count();
        $approvedCount = (clone $query)->where('status', 'Approved')->count();
        $completedCount = (clone $query)->where('status', 'Complete')->count();

        // Statistik Tipe Request (Pie Chart Data)
        $typeOfReqStats = (clone $query)
            ->select('type_of_req', DB::raw('count(*) as total'))
            ->groupBy('type_of_req')
            ->pluck('total', 'type_of_req')
            ->toArray();

        // Statistik Tipe Dokumen (Bar Chart Data)
        $typeOfDocStats = (clone $query)
            ->select('type_of_doc', DB::raw('count(*) as total'))
            ->groupBy('type_of_doc')
            ->pluck('total', 'type_of_doc')
            ->toArray();

        // Total Master Document yang ada
        $totalMasterDocs = MasterDocument::count();

        // Request Terbaru
        $recentRequests = (clone $query)->with('user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('ims.dashboard.index', compact(
            'totalRequests',
            'pendingCount',
            'approvedCount',
            'completedCount',
            'typeOfReqStats',
            'typeOfDocStats',
            'totalMasterDocs',
            'recentRequests'
        ));
    }
}
