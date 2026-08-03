<?php

namespace App\Services;

use App\Contracts\Repositories\RecurringBillRepositoryInterface;
use App\Contracts\Repositories\ReminderRepositoryInterface;
use App\Contracts\Repositories\TransactionRepositoryInterface;
use Carbon\Carbon;

class DashboardService
{
    public function __construct(
        protected StatisticService $statisticService,
        protected TransactionRepositoryInterface $transactionRepository,
        protected ReminderRepositoryInterface $reminderRepository,
        protected RecurringBillRepositoryInterface $recurringBillRepository
    ) {}

    /**
     * Get main summary metrics for dashboard cards.
     */
    public function getSummaryMetrics(): array
    {
        $now = Carbon::now();

        $totalIncome = (float) $this->transactionRepository->sumByTypeAndMonth('income', $now->year, $now->month);
        $totalExpense = (float) $this->transactionRepository->sumByTypeAndMonth('expense', $now->year, $now->month);
        $currentBalance = $totalIncome - $totalExpense;

        $monthlyIncome = (float) $this->transactionRepository->sumByTypeAndMonth('income', $now->year, $now->month);
        $monthlyExpense = (float) $this->transactionRepository->sumByTypeAndMonth('expense', $now->year, $now->month);

        $monthlyBalance = $monthlyIncome - $monthlyExpense;
        $totalTransactionsCount = $this->transactionRepository->countAll();

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
     * Get AI Summary metrics using Repositories (Clean Architecture).
     */
    public function getAiSummary(): array
    {
        $summaryMetrics = $this->getSummaryMetrics();

        return [
            'balance' => $summaryMetrics['current_balance'],
            'reminders_count' => $this->reminderRepository->countByStatus('pending'),
            'bills_count' => $this->recurringBillRepository->countByStatus('active')
        ];
    }

    /**
     * Get recent transactions for dashboard feed.
     */
    public function getRecentTransactions(int $limit = 5)
    {
        return $this->transactionRepository->getRecent($limit);
    }

    /**
     * Get complete dashboard payload.
     */
    public function getDashboardData(): array
    {
        return [
            'summary' => $this->getSummaryMetrics(),
            'recent_transactions' => $this->getRecentTransactions(5),
            'bills_count' => $this->recurringBillRepository->countByStatus('active'),
            'reminders_count' => $this->reminderRepository->countByStatus('pending'),
            'income_vs_expense_chart' => $this->statisticService->getIncomeVsExpenseChartData(),
            'expense_by_category_chart' => $this->statisticService->getExpenseByCategoryChartData(),
            'weekly_trend_chart' => $this->statisticService->getWeeklyTrendChartData(),
            'monthly_trend_chart' => $this->statisticService->getMonthlyTrendChartData(),
        ];
    }
}
