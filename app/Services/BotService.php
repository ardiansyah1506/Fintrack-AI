<?php

namespace App\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use App\Services\ReminderService;
use App\Services\RecurringBillService;
use App\Services\SavingGoalService;
use App\Services\BudgetService;

class BotService
{
    public function __construct(
        protected TransactionService $transactionService,
        protected CategoryService $categoryService,
        protected ReportService $reportService,
        protected StatisticService $statisticService,
        protected DashboardService $dashboardService,
        protected ReminderService $reminderService,
        protected RecurringBillService $recurringBillService,
        protected SavingGoalService $savingGoalService,
        protected BudgetService $budgetService
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
            'create_reminder' => $this->handleCreateReminder($parameters),
            'create_bill' => $this->handleCreateBill($parameters),
            'create_budget' => $this->handleCreateBudget($parameters),
            'create_saving_goal' => $this->handleCreateSavingGoal($parameters),
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
        $id = $params['id'] ?? null;
        if (empty($id)) {
            $latest = $this->transactionService->getLatestTransaction();
            if (!$latest) {
                throw new InvalidArgumentException("Belum ada transaksi yang dapat diperbarui.");
            }
            $id = $latest->id;
        }

        if (empty($params['category']) && !empty($params['category_name'])) {
            $params['category'] = $params['category_name'];
        }

        $transaction = $this->transactionService->updateTransaction($id, $params);

        return [
            'intent' => 'update_transaction',
            'status' => 'success',
            'message' => 'Transaksi berhasil diperbarui',
            'transaction' => $transaction,
        ];
    }

    protected function handleDeleteTransaction(array $params): array
    {
        $id = $params['id'] ?? null;
        if (empty($id)) {
            $latest = $this->transactionService->getLatestTransaction();
            if (!$latest) {
                throw new InvalidArgumentException("Belum ada transaksi yang dapat dihapus.");
            }
            $id = $latest->id;
        }

        $this->transactionService->deleteTransaction($id);

        return [
            'intent' => 'delete_transaction',
            'status' => 'success',
            'message' => "Transaksi ID {$id} berhasil dihapus",
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

    protected function handleCreateReminder(array $params): array
    {
        $reminder = $this->reminderService->createReminder($params);
        return [
            'intent' => 'create_reminder',
            'status' => 'success',
            'message' => 'Pengingat berhasil dibuat',
            'reminder' => $reminder,
        ];
    }

    protected function handleCreateBill(array $params): array
    {
        $bill = $this->recurringBillService->createBill($params);
        return [
            'intent' => 'create_bill',
            'status' => 'success',
            'message' => 'Tagihan rutin berhasil dibuat',
            'bill' => $bill,
        ];
    }
    
    protected function handleCreateBudget(array $params): array
    {
        $budget = $this->budgetService->createBudget($params);
        return [
            'intent' => 'create_budget',
            'status' => 'success',
            'message' => 'Budget berhasil dibuat',
            'budget' => $budget,
        ];
    }

    protected function handleCreateSavingGoal(array $params): array
    {
        $goal = $this->savingGoalService->createGoal($params);
        return [
            'intent' => 'create_saving_goal',
            'status' => 'success',
            'message' => 'Target tabungan berhasil dibuat',
            'saving_goal' => $goal,
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
                'create_reminder' => 'Membuat pengingat (params: title, due_date, due_time, priority)',
                'create_bill' => 'Membuat tagihan rutin (params: name, category, amount, repeat)',
                'create_budget' => 'Membuat batas anggaran bulanan (params: category, amount)',
                'create_saving_goal' => 'Membuat target tabungan (params: title, target_amount, deadline)',
                'help' => 'Menampilkan daftar intent bot',
            ],
        ];
    }
}
