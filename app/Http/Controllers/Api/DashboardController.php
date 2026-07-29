<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Traits\ApiResponse;

class DashboardController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * GET /api/dashboard
     */
    public function index()
    {
        $data = $this->dashboardService->getDashboardData();

        return $this->successResponse(
            $data,
            'Berhasil mengambil data dashboard'
        );
    }
}
