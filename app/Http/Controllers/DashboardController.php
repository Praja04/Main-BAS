<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PortalTokenService;
use PhpParser\Node\Expr\FuncCall;

class DashboardController extends Controller
{
    protected PortalTokenService $tokenService;

    public function __construct(PortalTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function index()
    {
        $user = Auth::user();

        $portals = [
            'engineering' => 'http://10.11.10.130:8090/engineering/public',
            'warehouse'   => 'http://10.11.10.130:8087/warehouse/public',
            'production'  => 'http://10.11.10.130:8095/production/public',
            'qc'          => 'http://10.11.10.130:8081',
        ];

        return view('dashboard', [
            'user' => $user,
            'portals' => $portals,
        ]);
    }

    public function generateTokenRedirect($target)
    {
        $user = Auth::user();

        // Validasi portal target
        $allowedPortals = ['engineering', 'warehouse', 'production', 'qc'];
        if (!in_array($target, $allowedPortals)) {
            return back()->with('error', 'Portal tidak valid');
        }

        // Generate token
        $portalToken = $this->tokenService->generateToken($user, $target);

        // Kirim token ke portal tujuan
        $result = $this->tokenService->sendTokenToPortal($portalToken);

        if (!$result['success']) {
            return back()->with('error', $result['message']);
        }

        // Redirect ke URL yang diberikan portal
        if (isset($result['redirect_url'])) {
            return redirect()->away($result['redirect_url']);
        }

        return back()->with('error', 'Portal tidak mengembalikan URL redirect');
    }

    public function Dashboard_Boiler()
    {
        return view('dashboard_boiler');
    }


    public function Dashboard_Utility()
    {
        return view('dashboard_utility');
    }

    public function Dashboard_scoring()
    {
        return view('dashboard_scoring');
    }

    //QC
    public function Dashboard_Blending()
    {
        return view('dashboard_blending');
    }
    public function Dashboard_Disolver()
    {
        return view('dashboard_disolver');
    }
    public function Dashboard_monitoring_turun()
    {
        return view('dashboard_monitoring_turun');
    }
    public function Dashboard_Pasteurisasi()
    {
        return view('dashboard_pasteurisasi');
    }
    public function Dashboard_monitoring_storage()
    {
        return view('dashboard_monitoring_storage');
    }
    public function Dashboard_RM()
    {
        return view('dashboard_rm');
    }

    //PRD
    public function Dashboard_pasteurisasi1()
    {
        return view('dashboard_pasteurisasi1');
    }
    public function Dashboard_pasteurisasi2()
    {
        return view('dashboard_pasteurisasi2');
    }
    public function Dashboard_retail()
    {
        return view('dashboard_retail');
    }
    public function Dashboard_downtime_retail()
    {
        return view('dashboard_downtime_retail');
    }

    //warehouse
    public function Dashboard_p2h()
    {
        return view('dashboard_p2h');
    }
    public function Dashboard_tkbm()
    {
        return view('dashboard_tkbm');
    }
    public function Dashboard_SOH()
    {
        return view('dashboard_soh');
    }

    // Data Mesin
    // Data Mesin
    public function Mesin_DailyTank()
    {
        return view('mesin.daily_tank');
    }

    public function Mesin_Pasteur1()
    {
        return view('mesin.pasteur1');
    }

    public function Mesin_Pasteur2()
    {
        return view('mesin.pasteur2');
    }

    public function Mesin_Disolver()
    {
        return view('mesin.disolver');
    }

    public function Mesin_Boiler()
    {
        return view('mesin.boiler');
    }

    public function Mesin_Glucose()
    {
        return view('mesin.glucose');
    }
}

