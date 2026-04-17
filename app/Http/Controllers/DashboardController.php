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
    public function generateTokenRedirect($target)
    {
        if (!$this->tokenService->isValidPortal($target)) {
            return back()->with('error', 'Portal tidak valid.');
        }

        $user        = Auth::user();
        $redirectUrl = $this->tokenService->generateRedirectUrl($user, $target);

        if (!$redirectUrl) {
            return back()->with('error', 'Gagal generate token SSO untuk portal ini.');
        }

        // Redirect browser langsung ke portal — portal yang akan verifikasi token ke Main-BAS
        return redirect()->away($redirectUrl);
    }

    // ==================== Dashboard Views ====================

    // Engineering
    public function Dashboard_Boiler()       { return view('dashboard_boiler'); }
    public function Dashboard_Utility()      { return view('eng.dashboard_utility'); }
    public function Dashboard_scoring()      { return view('eng.dashboard_scoring_mesin'); }

    // QC
    public function Dashboard_Blending()            { return view('dashboard_blending'); }
    public function Dashboard_Disolver()             { return view('dashboard_disolver'); }
    public function Dashboard_monitoring_turun()     { return view('dashboard_monitoring_turun'); }
    public function Dashboard_Pasteurisasi()         { return view('dashboard_pasteurisasi'); }
    public function Dashboard_monitoring_storage()   { return view('dashboard_monitoring_storage'); }
    public function Dashboard_RM()                   { return view('dashboard_rm'); }

    // PRD
    public function Dashboard_pasteurisasi1()  { return view('dashboard_pasteurisasi1'); }
    public function Dashboard_pasteurisasi2()  { return view('dashboard_pasteurisasi2'); }
    public function Dashboard_retail()         { return view('dashboard_retail'); }
    public function Dashboard_downtime_retail(){ return view('dashboard_downtime_retail'); }

    // Warehouse
    public function Dashboard_p2h()  { return view('dashboard_p2h'); }
    public function Dashboard_tkbm() { return view('dashboard_tkbm'); }
    public function Dashboard_SOH()  { return view('dashboard_soh'); }

    // Mesin
    public function Mesin_DailyTank() { return view('mesin.mesin_daily_tank'); }
    public function Mesin_Pasteur1()  { return view('mesin.mesin_pasteur1'); }
    public function Mesin_Pasteur2()  { return view('mesin.mesin_pasteur2'); }
    public function Mesin_Disolver()  { return view('mesin.mesin_dissolver'); }
    public function Mesin_Boiler()    { return view('mesin.mesin_mesin_boiler'); }
    public function Mesin_Glucose()   { return view('mesin.mesin_glucose'); }
}
