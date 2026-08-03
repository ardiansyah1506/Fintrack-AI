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
    public function index(
        \App\Services\BudgetService $budgetService,
        \App\Contracts\Repositories\SavingGoalRepositoryInterface $savingRepo
    )
    {
        $data = $this->dashboardService->getDashboardData();
        $data['budgetProgress'] = $budgetService->getBudgetSummary();
        $data['savingGoals'] = $savingRepo->all();

        return view('dashboard', $data);
    }
}
