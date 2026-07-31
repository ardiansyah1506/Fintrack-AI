<?php

namespace App\Services;

use App\Contracts\Repositories\BudgetRepositoryInterface;
use App\Contracts\Repositories\TransactionRepositoryInterface;
use Carbon\Carbon;

class BudgetService
{
    protected $budgetRepository;
    protected $transactionRepository;

    public function __construct(BudgetRepositoryInterface $budgetRepository, TransactionRepositoryInterface $transactionRepository) {
        $this->budgetRepository = $budgetRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function getAll(array $filters = [], int $perPage = 10) {
        return $this->budgetRepository->getPaginated($filters, $perPage);
    }

    public function create(array $data) {
        return $this->budgetRepository->create($data);
    }

    public function update($id, array $data) {
        return $this->budgetRepository->update($id, $data);
    }

    public function delete($id) {
        $this->budgetRepository->delete($id);
    }

    public function getBudgetSummary() {
        $budgets = $this->budgetRepository->all();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d');
        $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d');

        $summary = [];
        foreach ($budgets as $budget) {
            $totalExpense = $this->transactionRepository->getTotalExpenseByCategoryAndDate($budget->category, $startOfMonth, $endOfMonth);
            $remaining = max(0, $budget->amount - $totalExpense);
            $percentage = $budget->amount > 0 ? min(100, round(($totalExpense / $budget->amount) * 100, 2)) : 0;

            $status_color = 'green';
            if ($percentage >= 90) { $status_color = 'red'; }
            elseif ($percentage >= 50) { $status_color = 'yellow'; }

            $summary[] = [
                'id' => $budget->id,
                'category' => $budget->category,
                'amount' => $budget->amount,
                'spent' => $totalExpense,
                'remaining' => $remaining,
                'percentage' => $percentage,
                'status_color' => $status_color
            ];
        }
        return $summary;
    }
}
