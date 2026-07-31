<?php

namespace App\Contracts\Repositories;

interface TransactionRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function query();
    public function buildQuery(array $filters);
    public function getPaginatedTransactions(array $filters, int $perPage);
    public function getFilteredSummary(array $filters);
    public function getLatestTransaction();
    public function getTotalExpenseByCategoryAndDate($category, $start, $end);
    public function sumByTypeAndMonth($type, $year, $month);
    public function sumByTypeAndDateRange($type, $startDate, $endDate);
    public function getExpensesByCategoryMonth($year, $month);
    public function getExpensesByCategoryDate($date);
    public function getExpensesByCategoryDateRange($start, $end);
    public function countAll();
    public function getRecent($limit = 5);
    public function getByDate($date);
    public function getByDateRange($start, $end);
    public function getByMonth($year, $month);
}
