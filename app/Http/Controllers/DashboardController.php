<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Display the main dashboard with statistics and charts.
     */
    public function index()
    {
        $data = $this->dashboardService->getDashboardData();

        return view('dashboard', $data);
    }
}
