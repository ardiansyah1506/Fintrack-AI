<?php

namespace App\Services;

use App\Models\Transaction;
use Carbon\Carbon;

class DashboardService
{
    public function __construct(
        protected StatisticService $statisticService
    ) {}

    /**
     * Get main summary metrics for dashboard cards.
     */
    public function getSummaryMetrics(): array
    {
        $now = Carbon::now();

        $totalIncome = (float) Transaction::where('type', 'income')->sum('amount');
        $totalExpense = (float) Transaction::where('type', 'expense')->sum('amount');
        $currentBalance = $totalIncome - $totalExpense;

        $monthlyIncome = (float) Transaction::where('type', 'income')
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');

        $monthlyExpense = (float) Transaction::where('type', 'expense')
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');

        $monthlyBalance = $monthlyIncome - $monthlyExpense;
        $totalTransactionsCount = Transaction::count();

        return [
            'current_balance' => $currentBalance,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'monthly_income' => $monthlyIncome,
            'monthly_expense' => $monthlyExpense,
            'monthly_balance' => $monthlyBalance,
            'total_transactions' => $totalTransactionsCount,
        ];
    }

    /**
     * Get recent transactions for dashboard feed.
     */
    public function getRecentTransactions(int $limit = 5)
    {
        return Transaction::query()
            ->orderBy('transaction_date', 'desc')
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get complete dashboard payload.
     */
    public function getDashboardData(): array
    {
        return [
            'summary' => $this->getSummaryMetrics(),
            'recent_transactions' => $this->getRecentTransactions(5),
            'income_vs_expense_chart' => $this->statisticService->getIncomeVsExpenseChartData(),
            'expense_by_category_chart' => $this->statisticService->getExpenseByCategoryChartData(),
            'weekly_trend_chart' => $this->statisticService->getWeeklyTrendChartData(),
            'monthly_trend_chart' => $this->statisticService->getMonthlyTrendChartData(),
        ];
    }
}
