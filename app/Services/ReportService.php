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

        $transactions = Transaction::with('category')
            ->whereDate('transaction_date', $targetDate)
            ->orderBy('amount', 'desc')
            ->get();

        $topExpense = $transactions->where('type', 'expense')->first();

        $categoryBreakdown = Transaction::where('transaction_date', $targetDate)
            ->where('transactions.type', 'expense')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total')
            ->get();

        return [
            'period_type' => 'daily',
            'date' => $targetDate,
            'income_total' => $incomeTotal,
            'expense_total' => $expenseTotal,
            'balance' => $incomeTotal - $expenseTotal,
            'total_transactions' => $transactions->count(),
            'top_expense' => $topExpense,
            'top_category' => $categoryBreakdown->first()?->name ?? '-',
            'category_breakdown' => $categoryBreakdown,
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

        $transactions = Transaction::with('category')
            ->whereBetween('transaction_date', [$start, $end])
            ->orderBy('transaction_date', 'desc')
            ->get();

        $topExpense = $transactions->where('type', 'expense')->sortByDesc('amount')->first();

        $categoryBreakdown = Transaction::whereBetween('transaction_date', [$start, $end])
            ->where('transactions.type', 'expense')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total')
            ->get();

        return [
            'period_type' => 'weekly',
            'start_date' => $start,
            'end_date' => $end,
            'income_total' => $incomeTotal,
            'expense_total' => $expenseTotal,
            'balance' => $incomeTotal - $expenseTotal,
            'total_transactions' => $transactions->count(),
            'top_expense' => $topExpense,
            'top_category' => $categoryBreakdown->first()?->name ?? '-',
            'category_breakdown' => $categoryBreakdown,
            'transactions' => $transactions,
        ];
    }

    /**
     * Get Monthly Financial Report.
     */
    public function getMonthlyReport(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth()->format('Y-m-d');
        $end = Carbon::create($year, $month, 1)->endOfMonth()->format('Y-m-d');

        $incomeTotal = (float) Transaction::where('type', 'income')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $expenseTotal = (float) Transaction::where('type', 'expense')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $transactions = Transaction::with('category')
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->orderBy('transaction_date', 'desc')
            ->get();

        $topExpense = $transactions->where('type', 'expense')->sortByDesc('amount')->first();

        $categoryBreakdown = Transaction::whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->where('transactions.type', 'expense')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select('categories.name', 'categories.color', DB::raw('SUM(transactions.amount) as total'))
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total')
            ->get();

        return [
            'period_type' => 'monthly',
            'year' => $year,
            'month' => $month,
            'month_name' => Carbon::create($year, $month, 1)->translatedFormat('F Y'),
            'income_total' => $incomeTotal,
            'expense_total' => $expenseTotal,
            'balance' => $incomeTotal - $expenseTotal,
            'total_transactions' => $transactions->count(),
            'top_expense' => $topExpense,
            'top_category' => $categoryBreakdown->first()?->name ?? '-',
            'category_breakdown' => $categoryBreakdown,
            'transactions' => $transactions,
        ];
    }
}
