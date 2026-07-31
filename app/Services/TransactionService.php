<?php

namespace App\Services;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionService
{
    protected $repository;

    public function __construct(TransactionRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getPaginatedTransactions(array $filters = [], int $perPage = 10): LengthAwarePaginator {
        return $this->repository->getPaginatedTransactions($filters, $perPage);
    }

    public function getFilteredSummary(array $filters = []): array {
        return $this->repository->getFilteredSummary($filters);
    }

    public function getTransactionById(int $id) {
        return $this->repository->find($id);
    }

    public function createTransaction(array $data) {
        return $this->repository->create([
            'transaction_date' => $data['transaction_date'],
            'type' => strtolower($data['type']),
            'category' => $data['category'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'notes' => $data['notes'] ?? null,
        ]);
    }

    public function updateTransaction(int $id, array $data) {
        return $this->repository->update($id, $data);
    }

    public function deleteTransaction(int $id): bool {
        return (bool) $this->repository->delete($id);
    }

    public function getLatestTransaction() {
        return $this->repository->getLatestTransaction();
    }
}
