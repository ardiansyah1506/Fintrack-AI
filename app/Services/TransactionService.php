<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TransactionService
{
    /**
     * Build base query for transactions with filters.
     */
    protected function buildQuery(array $filters): Builder
    {
        $query = Transaction::with('category');

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['type'])) {
            $query->where('type', strtolower($filters['type']));
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['period'])) {
            $now = \Carbon\Carbon::now();
            switch ($filters['period']) {
                case 'today':
                case 'daily':
                case 'harian':
                    $query->whereDate('transaction_date', $now->format('Y-m-d'));
                    break;
                case 'this_week':
                case 'weekly':
                case 'mingguan':
                    $query->whereBetween('transaction_date', [
                        $now->copy()->startOfWeek()->format('Y-m-d'),
                        $now->copy()->endOfWeek()->format('Y-m-d')
                    ]);
                    break;
                case 'this_month':
                case 'monthly':
                case 'bulanan':
                    $query->whereBetween('transaction_date', [
                        $now->copy()->startOfMonth()->format('Y-m-d'),
                        $now->copy()->endOfMonth()->format('Y-m-d')
                    ]);
                    break;
            }
        }

        if (!empty($filters['date_start'])) {
            $query->whereDate('transaction_date', '>=', $filters['date_start']);
        }

        if (!empty($filters['date_end'])) {
            $query->whereDate('transaction_date', '<=', $filters['date_end']);
        }

        $sortBy = $filters['sort_by'] ?? 'transaction_date';
        $sortDir = strtolower($filters['sort_dir'] ?? 'desc') === 'asc' ? 'asc' : 'desc';

        if (!in_array($sortBy, ['transaction_date', 'amount', 'created_at', 'description'])) {
            $sortBy = 'transaction_date';
        }

        return $query->orderBy($sortBy, $sortDir)->orderBy('id', 'desc');
    }

    /**
     * Get paginated transactions.
     */
    public function getPaginatedTransactions(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->buildQuery($filters)->paginate($perPage)->withQueryString();
    }

    /**
     * Get total summary metrics for filtered transactions.
     */
    public function getFilteredSummary(array $filters = []): array
    {
        $query = $this->buildQuery($filters);

        // Remove order by for aggregate queries
        $query->reorder();

        $incomeTotal = (clone $query)->where('type', 'income')->sum('amount');
        $expenseTotal = (clone $query)->where('type', 'expense')->sum('amount');
        $count = $query->count();

        return [
            'income_total' => (float) $incomeTotal,
            'expense_total' => (float) $expenseTotal,
            'balance' => (float) ($incomeTotal - $expenseTotal),
            'total_count' => $count,
        ];
    }

    /**
     * Find transaction by ID.
     */
    public function getTransactionById(int $id): Transaction
    {
        return Transaction::with('category')->findOrFail($id);
    }

    /**
     * Create a new transaction.
     */
    public function createTransaction(array $data): Transaction
    {
        return Transaction::create([
            'transaction_date' => $data['transaction_date'],
            'type' => strtolower($data['type']),
            'category_id' => $data['category_id'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'notes' => $data['notes'] ?? null,
        ]);
    }

    /**
     * Update an existing transaction.
     */
    public function updateTransaction(int $id, array $data): Transaction
    {
        $transaction = $this->getTransactionById($id);

        $transaction->update([
            'transaction_date' => $data['transaction_date'] ?? $transaction->transaction_date,
            'type' => strtolower($data['type'] ?? $transaction->type),
            'category_id' => $data['category_id'] ?? $transaction->category_id,
            'amount' => $data['amount'] ?? $transaction->amount,
            'description' => $data['description'] ?? $transaction->description,
            'notes' => $data['notes'] ?? $transaction->notes,
        ]);

        return $transaction;
    }

    /**
     * Delete transaction by ID.
     */
    public function deleteTransaction(int $id): bool
    {
        $transaction = $this->getTransactionById($id);
        return (bool) $transaction->delete();
    }
}
