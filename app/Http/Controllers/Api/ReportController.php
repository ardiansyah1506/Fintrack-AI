<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * GET /api/report/daily
     */
    public function daily(Request $request)
    {
        $date = $request->query('date', Carbon::now()->format('Y-m-d'));
        $report = $this->reportService->getDailyReport($date);

        return $this->successResponse($report, 'Berhasil mengambil laporan harian', 200, 'daily_report', 'report');
    }

    /**
     * GET /api/report/weekly
     */
    public function weekly(Request $request)
    {
        $now = Carbon::now();
        $startDate = $request->query('start_date', $now->copy()->startOfWeek()->format('Y-m-d'));
        $endDate = $request->query('end_date', $now->copy()->endOfWeek()->format('Y-m-d'));

        $report = $this->reportService->getWeeklyReport($startDate, $endDate);

        return $this->successResponse($report, 'Berhasil mengambil laporan mingguan', 200, 'weekly_report', 'report');
    }

    /**
     * GET /api/report/monthly
     */
    public function monthly(Request $request)
    {
        $now = Carbon::now();
        $year = (int) $request->query('year', $now->year);
        $month = (int) $request->query('month', $now->month);

        $report = $this->reportService->getMonthlyReport($year, $month);

        return $this->successResponse($report, 'Berhasil mengambil laporan bulanan', 200, 'monthly_report', 'report');
    }
}

