<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Get Daily Financial Report.
     */
    public function getDailyReport(string $date): array
    {
        $targetDate = Carbon::parse($date)->format('Y-m-d');

        $incomeTotal = (float) Transaction::where('type', 'income')
            ->whereDate('transaction_date', $targetDate)
            ->sum('amount');

        $expenseTotal = (float) Transaction::where('type', 'expense')
            ->whereDate('transaction_date', $targetDate)
            ->sum('amount');

        $transactions = Transaction::whereDate('transaction_date', $targetDate)
            ->orderBy('amount', 'desc')
            ->get();

        $topExpense = $transactions->where('type', 'expense')->first();

        $categoryBreakdownRaw = Transaction::whereDate('transaction_date', $targetDate)
            ->where('type', 'expense')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $defaultColors = ['#F43F5E', '#8B5CF6', '#10B981', '#3B82F6', '#F59E0B', '#EC4899', '#6366F1'];
        $categoriesBreakdown = [];
        foreach ($categoryBreakdownRaw as $idx => $cat) {
            $categoriesBreakdown[] = [
                'name' => $cat->category,
                'color' => $defaultColors[$idx % count($defaultColors)],
                'total' => (float) $cat->total,
                'percentage' => $expenseTotal > 0 ? round(($cat->total / $expenseTotal) * 100, 1) : 0,
            ];
        }

        return [
            'period_type' => 'daily',
            'date' => $targetDate,
            'summary' => [
                'total_income' => $incomeTotal,
                'total_expense' => $expenseTotal,
                'net_balance' => $incomeTotal - $expenseTotal,
                'total_transactions' => $transactions->count(),
                'top_expense' => $topExpense,
            ],
            'categories_breakdown' => $categoriesBreakdown,
            'transactions' => $transactions,
        ];
    }

    /**
     * Get Weekly Financial Report.
     */
    public function getWeeklyReport(string $startDate, string $endDate): array
    {
        $start = Carbon::parse($startDate)->startOfDay()->format('Y-m-d');
        $end = Carbon::parse($endDate)->endOfDay()->format('Y-m-d');

        $incomeTotal = (float) Transaction::where('type', 'income')
            ->whereBetween('transaction_date', [$start, $end])
            ->sum('amount');

        $expenseTotal = (float) Transaction::where('type', 'expense')
            ->whereBetween('transaction_date', [$start, $end])
            ->sum('amount');

        $transactions = Transaction::whereBetween('transaction_date', [$start, $end])
            ->orderBy('transaction_date', 'desc')
            ->get();

        $topExpense = $transactions->where('type', 'expense')->sortByDesc('amount')->first();

        $categoryBreakdownRaw = Transaction::whereBetween('transaction_date', [$start, $end])
            ->where('type', 'expense')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $defaultColors = ['#F43F5E', '#8B5CF6', '#10B981', '#3B82F6', '#F59E0B', '#EC4899', '#6366F1'];
        $categoriesBreakdown = [];
        foreach ($categoryBreakdownRaw as $idx => $cat) {
            $categoriesBreakdown[] = [
                'name' => $cat->category,
                'color' => $defaultColors[$idx % count($defaultColors)],
                'total' => (float) $cat->total,
                'percentage' => $expenseTotal > 0 ? round(($cat->total / $expenseTotal) * 100, 1) : 0,
            ];
        }

        return [
            'period_type' => 'weekly',
            'start_date' => $start,
            'end_date' => $end,
            'summary' => [
                'total_income' => $incomeTotal,
                'total_expense' => $expenseTotal,
                'net_balance' => $incomeTotal - $expenseTotal,
                'total_transactions' => $transactions->count(),
                'top_expense' => $topExpense,
            ],
            'categories_breakdown' => $categoriesBreakdown,
            'transactions' => $transactions,
        ];
    }

    /**
     * Get Monthly Financial Report.
     */
    public function getMonthlyReport(int $year, int $month): array
    {
        $incomeTotal = (float) Transaction::where('type', 'income')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $expenseTotal = (float) Transaction::where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $transactions = Transaction::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $topExpense = $transactions->where('type', 'expense')->sortByDesc('amount')->first();

        $categoryBreakdownRaw = Transaction::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->where('type', 'expense')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $defaultColors = ['#F43F5E', '#8B5CF6', '#10B981', '#3B82F6', '#F59E0B', '#EC4899', '#6366F1'];
        $categoriesBreakdown = [];
        foreach ($categoryBreakdownRaw as $idx => $cat) {
            $categoriesBreakdown[] = [
                'name' => $cat->category,
                'color' => $defaultColors[$idx % count($defaultColors)],
                'total' => (float) $cat->total,
                'percentage' => $expenseTotal > 0 ? round(($cat->total / $expenseTotal) * 100, 1) : 0,
            ];
        }

        return [
            'period_type' => 'monthly',
            'year' => $year,
            'month' => $month,
            'month_name' => Carbon::create($year, $month, 1)->translatedFormat('F Y'),
            'summary' => [
                'total_income' => $incomeTotal,
                'total_expense' => $expenseTotal,
                'net_balance' => $incomeTotal - $expenseTotal,
                'total_transactions' => $transactions->count(),
                'top_expense' => $topExpense,
            ],
            'categories_breakdown' => $categoriesBreakdown,
            'transactions' => $transactions,
        ];
    }
}
