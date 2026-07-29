<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * Display financial report page with daily, weekly, and monthly filters.
     */
    public function index(Request $request)
    {
        $period = $request->query('period', 'monthly');
        $now = Carbon::now();

        if ($period === 'daily') {
            $date = $request->query('date', $now->format('Y-m-d'));
            $report = $this->reportService->getDailyReport($date);
        } elseif ($period === 'weekly') {
            $startDate = $request->query('start_date', $now->copy()->startOfWeek()->format('Y-m-d'));
            $endDate = $request->query('end_date', $now->copy()->endOfWeek()->format('Y-m-d'));
            $report = $this->reportService->getWeeklyReport($startDate, $endDate);
        } else {
            $period = 'monthly';
            $year = (int) $request->query('year', $now->year);
            $month = (int) $request->query('month', $now->month);
            $report = $this->reportService->getMonthlyReport($year, $month);
        }

        $reportData = $report;

        return view('reports.index', compact('reportData', 'period'));
    }
}
