<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticService
{
    /**
     * Get Income vs Expense comparisons for the last 6 months.
     */
    public function getIncomeVsExpenseChartData(): array
    {
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');

            $income = Transaction::where('type', 'income')
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->sum('amount');

            $expense = Transaction::where('type', 'expense')
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->sum('amount');

            $incomeData[] = (float) $income;
            $expenseData[] = (float) $expense;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $incomeData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.8)', // Emerald
                    'borderColor' => '#10B981',
                    'borderRadius' => 8,
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $expenseData,
                    'backgroundColor' => 'rgba(244, 63, 94, 0.8)', // Rose
                    'borderColor' => '#F43F5E',
                    'borderRadius' => 8,
                ],
            ],
        ];
    }

    /**
     * Get Expense breakdown by Category for current month.
     */
    public function getExpenseByCategoryChartData(): array
    {
        $now = Carbon::now();

        $expenses = Transaction::where('transactions.type', 'expense')
            ->whereYear('transaction_date', $now->year)
            ->whereMonth('transaction_date', $now->month)
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total')
            ->get();

        $labels = [];
        $data = [];
        $colors = [];

        foreach ($expenses as $item) {
            $labels[] = $item->name;
            $data[] = (float) $item->total;
            $colors[] = $item->color ?? '#6B7280';
        }

        if (empty($labels)) {
            $labels = ['Belum ada pengeluaran'];
            $data = [0];
            $colors = ['#E2E8F0'];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderWidth' => 2,
                    'borderColor' => '#ffffff',
                ],
            ],
        ];
    }

    /**
     * Get weekly transaction trend for current month.
     */
    public function getWeeklyTrendChartData(): array
    {
        $labels = ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'];
        $incomeData = [0, 0, 0, 0];
        $expenseData = [0, 0, 0, 0];

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        for ($week = 0; $week < 4; $week++) {
            $weekStart = $startOfMonth->copy()->addWeeks($week);
            $weekEnd = $weekStart->copy()->addDays(6)->endOfDay();

            $incomeData[$week] = (float) Transaction::where('type', 'income')
                ->whereBetween('transaction_date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
                ->sum('amount');

            $expenseData[$week] = (float) Transaction::where('type', 'expense')
                ->whereBetween('transaction_date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
                ->sum('amount');
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Income Mingguan',
                    'data' => $incomeData,
                    'borderColor' => '#10B981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
                [
                    'label' => 'Expense Mingguan',
                    'data' => $expenseData,
                    'borderColor' => '#F43F5E',
                    'backgroundColor' => 'rgba(244, 63, 94, 0.1)',
                    'tension' => 0.4,
                    'fill' => true,
                ],
            ],
        ];
    }

    /**
     * Get monthly transaction trend line for current year.
     */
    public function getMonthlyTrendChartData(): array
    {
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        $year = Carbon::now()->year;

        for ($m = 1; $m <= 12; $m++) {
            $month = Carbon::create($year, $m, 1);
            $labels[] = $month->translatedFormat('M');

            $incomeData[] = (float) Transaction::where('type', 'income')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $m)
                ->sum('amount');

            $expenseData[] = (float) Transaction::where('type', 'expense')
                ->whereYear('transaction_date', $year)
                ->whereMonth('transaction_date', $m)
                ->sum('amount');
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Trend Pemasukan',
                    'data' => $incomeData,
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
                [
                    'label' => 'Trend Pengeluaran',
                    'data' => $expenseData,
                    'borderColor' => '#EF4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'tension' => 0.3,
                    'fill' => true,
                ],
            ],
        ];
    }
}
