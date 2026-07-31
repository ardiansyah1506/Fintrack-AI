<?php
namespace App\Intents\Budgets;
use App\Intents\Contracts\IntentInterface;
use App\Services\DashboardService;
class BudgetSummaryIntent implements IntentInterface {
    public function __construct(protected DashboardService $dashboardService) {}
    public function handle(array $params): array {
        return ['intent' => 'budget', 'metrics' => $this->dashboardService->getSummaryMetrics()];
    }
}