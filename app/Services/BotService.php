<?php

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;

class BotService
{
    public function __construct(
        protected TransactionService $transactionService,
        protected CategoryService $categoryService,
        protected ReportService $reportService,
        protected StatisticService $statisticService,
        protected DashboardService $dashboardService
    ) {}

    /**
     * Execute bot intent payload from n8n / Telegram Bot.
     */
    public function executeIntent(string $intent, array $parameters = []): array
    {
        $intentName = strtolower(trim($intent));

        return match ($intentName) {
            'create_transaction' => $this->handleCreateTransaction($parameters),
            'update_transaction' => $this->handleUpdateTransaction($parameters),
            'delete_transaction' => $this->handleDeleteTransaction($parameters),
            'statistics' => $this->handleStatistics($parameters),
            'daily_report' => $this->handleDailyReport($parameters),
            'weekly_report' => $this->handleWeeklyReport($parameters),
            'monthly_report' => $this->handleMonthlyReport($parameters),
            'budget', 'balance' => $this->handleBudget($parameters),
            'help' => $this->handleHelp(),
            default => throw new InvalidArgumentException("Intent '{$intent}' tidak dikenali. Gunakan intent 'help' untuk petunjuk."),
        };
    }

    protected function handleCreateTransaction(array $params): array
    {
        if (empty($params['category']) && !empty($params['category_name'])) {
            $params['category'] = $params['category_name'];
        }

        if (empty($params['category'])) {
            $params['category'] = 'Lainnya';
        }

        if (empty($params['transaction_date'])) {
            $dateVal = strtolower(trim($params['date'] ?? ''));
            if ($dateVal === 'today' || $dateVal === 'hari ini' || empty($dateVal)) {
                $params['transaction_date'] = Carbon::now()->format('Y-m-d');
            } elseif ($dateVal === 'yesterday' || $dateVal === 'kemarin') {
                $params['transaction_date'] = Carbon::now()->subDay()->format('Y-m-d');
            } else {
                try {
                    $params['transaction_date'] = Carbon::parse($dateVal)->format('Y-m-d');
                } catch (\Throwable $e) {
                    $params['transaction_date'] = Carbon::now()->format('Y-m-d');
                }
            }
        }

        $transaction = $this->transactionService->createTransaction($params);

        return [
            'intent' => 'create_transaction',
            'status' => 'success',
            'message' => 'Transaksi berhasil dicatat oleh Bot',
            'transaction' => $transaction,
        ];
    }

    protected function handleUpdateTransaction(array $params): array
    {
        if (empty($params['id'])) {
            throw new InvalidArgumentException("Parameter 'id' wajib diisi untuk intent update_transaction");
        }

        if (empty($params['category']) && !empty($params['category_name'])) {
            $params['category'] = $params['category_name'];
        }

        $transaction = $this->transactionService->updateTransaction($params['id'], $params);

        return [
            'intent' => 'update_transaction',
            'status' => 'success',
            'message' => 'Transaksi berhasil diperbarui',
            'transaction' => $transaction,
        ];
    }

    protected function handleDeleteTransaction(array $params): array
    {
        if (empty($params['id'])) {
            throw new InvalidArgumentException("Parameter 'id' wajib diisi untuk intent delete_transaction");
        }

        $this->transactionService->deleteTransaction($params['id']);

        return [
            'intent' => 'delete_transaction',
            'status' => 'success',
            'message' => "Transaksi ID {$params['id']} berhasil dihapus",
        ];
    }

    protected function handleStatistics(array $params): array
    {
        return [
            'intent' => 'statistics',
            'summary' => $this->dashboardService->getSummaryMetrics(),
            'expense_by_category' => $this->statisticService->getExpenseByCategoryChartData(),
        ];
    }

    protected function handleDailyReport(array $params): array
    {
        $date = $params['date'] ?? Carbon::now()->format('Y-m-d');
        return [
            'intent' => 'daily_report',
            'report' => $this->reportService->getDailyReport($date),
        ];
    }

    protected function handleWeeklyReport(array $params): array
    {
        $now = Carbon::now();
        $startDate = $params['start_date'] ?? $now->copy()->startOfWeek()->format('Y-m-d');
        $endDate = $params['end_date'] ?? $now->copy()->endOfWeek()->format('Y-m-d');

        return [
            'intent' => 'weekly_report',
            'report' => $this->reportService->getWeeklyReport($startDate, $endDate),
        ];
    }

    protected function handleMonthlyReport(array $params): array
    {
        $now = Carbon::now();
        $year = (int) ($params['year'] ?? $now->year);
        $month = (int) ($params['month'] ?? $now->month);

        return [
            'intent' => 'monthly_report',
            'report' => $this->reportService->getMonthlyReport($year, $month),
        ];
    }

    protected function handleBudget(array $params): array
    {
        return [
            'intent' => 'budget',
            'metrics' => $this->dashboardService->getSummaryMetrics(),
        ];
    }

    protected function handleHelp(): array
    {
        return [
            'intent' => 'help',
            'available_intents' => [
                'create_transaction' => 'Mencatat transaksi baru (params: transaction_date, type, category/category_name, amount, description, notes)',
                'update_transaction' => 'Memperbarui transaksi (params: id, ...field_to_update)',
                'delete_transaction' => 'Menghapus transaksi (params: id)',
                'statistics' => 'Mengambil statistik ringkas keuangan',
                'daily_report' => 'Mengambil laporan harian (params: date)',
                'weekly_report' => 'Mengambil laporan mingguan (params: start_date, end_date)',
                'monthly_report' => 'Mengambil laporan bulanan (params: year, month)',
                'budget' => 'Melihat ringkasan saldo & kas',
                'help' => 'Menampilkan daftar intent bot',
            ],
        ];
    }
}
