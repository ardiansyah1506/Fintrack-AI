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
    public function index(
        \Illuminate\Http\Request $request,
        \App\Services\BudgetService $budgetService,
        \App\Contracts\Repositories\SavingGoalRepositoryInterface $savingRepo
    )
    {
        $data = $this->dashboardService->getDashboardData($request->query());
        $data['budgetProgress'] = $budgetService->getBudgetSummary();
        $data['savingGoals'] = $savingRepo->all();

        return $this->successResponse(
            $data,
            'Berhasil mengambil data dashboard',
            200,
            'dashboard_summary',
            'dashboard'
        );
    }

    /**
     * GET /api/dashboard/ai
     */
    public function aiSummary()
    {
        $data = $this->dashboardService->getAiSummary();

        return $this->successResponse(
            $data,
            'Data AI Summary Berhasil',
            200,
            'ai_summary',
            'dashboard'
        );
    }
}
