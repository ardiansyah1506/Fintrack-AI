<?php

use Carbon\Carbon;

if (!function_exists('formatCurrency')) {
    /**
     * Format a number into Indonesian Rupiah currency format.
     */
    function formatCurrency($amount, $prefix = 'Rp '): string
    {
        return $prefix . number_format((float) $amount, 0, ',', '.');
    }
}

if (!function_exists('formatDate')) {
    /**
     * Format a date into readable Indonesian string format.
     */
    function formatDate($date, string $format = 'd M Y'): string
    {
        if (!$date) {
            return '-';
        }

        try {
            return Carbon::parse($date)->translatedFormat($format);
        } catch (\Throwable $e) {
            return (string) $date;
        }
    }
}

if (!function_exists('calculateBalance')) {
    /**
     * Calculate net balance between income and expense.
     */
    function calculateBalance($incomeTotal, $expenseTotal): float
    {
        return (float) $incomeTotal - (float) $expenseTotal;
    }
}

if (!function_exists('transactionBadge')) {
    /**
     * Return Tailwind CSS badge styling array or string based on transaction type.
     */
    function transactionBadge(string $type): array
    {
        if (strtolower($type) === 'income') {
            return [
                'label' => 'Income',
                'bg' => 'bg-emerald-100 dark:bg-emerald-900/40',
                'text' => 'text-emerald-700 dark:text-emerald-400',
                'border' => 'border-emerald-200 dark:border-emerald-800',
                'icon' => 'arrow-down-left',
            ];
        }

        return [
            'label' => 'Expense',
            'bg' => 'bg-rose-100 dark:bg-rose-900/40',
            'text' => 'text-rose-700 dark:text-rose-400',
            'border' => 'border-rose-200 dark:border-rose-800',
            'icon' => 'arrow-up-right',
        ];
    }
}
