<?php
namespace App\Intents\Statistics;
use App\Intents\Contracts\IntentInterface;
use App\Services\ReportService;
use Carbon\Carbon;
class ReportIntent implements IntentInterface {
    public function __construct(protected ReportService $reportService) {}
    public function handle(array $params): array {
        $intent = $params['_active_intent'] ?? 'daily_report';
        $now = Carbon::now();
        if ($intent === 'daily_report') {
            $date = $params['date'] ?? $now->format('Y-m-d');
            return ['intent' => 'daily_report', 'report' => $this->reportService->getDailyReport($date)];
        } elseif ($intent === 'weekly_report') {
            $startDate = $params['start_date'] ?? $now->copy()->startOfWeek()->format('Y-m-d');
            $endDate = $params['end_date'] ?? $now->copy()->endOfWeek()->format('Y-m-d');
            return ['intent' => 'weekly_report', 'report' => $this->reportService->getWeeklyReport($startDate, $endDate)];
        } elseif ($intent === 'monthly_report') {
            $year = (int) ($params['year'] ?? $now->year);
            $month = (int) ($params['month'] ?? $now->month);
            return ['intent' => 'monthly_report', 'report' => $this->reportService->getMonthlyReport($year, $month)];
        }
        return [];
    }
}