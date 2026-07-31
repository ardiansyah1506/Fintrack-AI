<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function __construct(protected \App\Contracts\Repositories\TransactionRepositoryInterface $transactionRepository) {}

    /**
     * Get Daily Financial Report.
     */
    public function getDailyReport(string $date): array
    {
        $targetDate = Carbon::parse($date)->format('Y-m-d');

        $incomeTotal = (float) $this->transactionRepository->query()->where('type', 'income')->whereDate('transaction_date', $targetDate)->sum('amount');

        $expenseTotal = (float) $this->transactionRepository->query()->where('type', 'expense')->whereDate('transaction_date', $targetDate)->sum('amount');

        $transactions = $this->transactionRepository->getByDate($targetDate);

        $topExpense = $transactions->where('type', 'expense')->first();

        $categoryBreakdownRaw = $this->transactionRepository->getExpensesByCategoryDate($targetDate);

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

        $incomeTotal = (float) $this->transactionRepository->sumByTypeAndDateRange('income', $start, $end);

        $expenseTotal = (float) $this->transactionRepository->sumByTypeAndDateRange('expense', $start, $end);

        $transactions = $this->transactionRepository->getByDateRange($start, $end);

        $topExpense = $transactions->where('type', 'expense')->sortByDesc('amount')->first();

        $categoryBreakdownRaw = $this->transactionRepository->getExpensesByCategoryDateRange($start, $end);

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
        $incomeTotal = (float) $this->transactionRepository->sumByTypeAndMonth('income', $year, $month);

        $expenseTotal = (float) $this->transactionRepository->sumByTypeAndMonth('expense', $year, $month);

        $transactions = $this->transactionRepository->getByMonth($year, $month);

        $topExpense = $transactions->where('type', 'expense')->sortByDesc('amount')->first();

        $categoryBreakdownRaw = $this->transactionRepository->getExpensesByCategoryMonth($year, $month);

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
