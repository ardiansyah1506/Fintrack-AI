<?php
namespace App\Intents\Statistics;
use App\Intents\Contracts\IntentInterface;
use App\Services\StatisticService;
use App\Services\DashboardService;
class StatisticsIntent implements IntentInterface {
    public function __construct(protected StatisticService $statisticService, protected DashboardService $dashboardService) {}
    public function handle(array $params): array {
        return ['intent' => 'statistics', 'summary' => $this->dashboardService->getSummaryMetrics(), 'expense_by_category' => $this->statisticService->getExpenseByCategoryChartData()];
    }
}