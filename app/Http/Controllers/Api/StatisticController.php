<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StatisticService;
use App\Traits\ApiResponse;

class StatisticController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected StatisticService $statisticService
    ) {}

    /**
     * GET /api/statistics
     */
    public function index()
    {
        $data = [
            'income_vs_expense' => $this->statisticService->getIncomeVsExpenseChartData(),
            'expense_by_category' => $this->statisticService->getExpenseByCategoryChartData(),
            'weekly_trend' => $this->statisticService->getWeeklyTrendChartData(),
            'monthly_trend' => $this->statisticService->getMonthlyTrendChartData(),
        ];

        return $this->successResponse(
            $data,
            'Berhasil mengambil statistik keuangan',
            200,
            'statistics',
            'statistics'
        );
    }
}
