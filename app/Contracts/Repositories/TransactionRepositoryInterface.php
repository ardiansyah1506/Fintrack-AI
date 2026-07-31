<?php

namespace App\Contracts\Repositories;

interface TransactionRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getPaginatedTransactions(array $filters, int $perPage);
    public function getFilteredSummary(array $filters);
    public function getLatestTransaction();
    public function getTotalExpenseByCategoryAndDate($category, $start, $end);
}
