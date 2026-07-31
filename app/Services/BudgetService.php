<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class BudgetService
{
    public function getAllBudgets(): Collection
    {
        return Budget::all();
    }

    public function createBudget(array $data): Budget
    {
        return Budget::create($data);
    }

    public function updateBudget($id, array $data): Budget
    {
        $budget = Budget::findOrFail($id);
        $budget->update($data);
        return $budget;
    }

    public function deleteBudget($id): void
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();
    }

    public function getBudgetSummary()
    {
        $budgets = Budget::all();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->format('Y-m-d');
        $endOfMonth = $now->copy()->endOfMonth()->format('Y-m-d');

        $summary = [];
        foreach ($budgets as $budget) {
            $totalExpense = Transaction::where('category', $budget->category)
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $remaining = max(0, $budget->amount - $totalExpense);
            $percentage = $budget->amount > 0 ? min(100, round(($totalExpense / $budget->amount) * 100, 2)) : 0;

            $status_color = 'green';
            if ($percentage >= 90) {
                $status_color = 'red';
            } elseif ($percentage >= 50) {
                $status_color = 'yellow';
            }

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
