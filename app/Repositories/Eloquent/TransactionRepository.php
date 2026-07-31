<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\TransactionRepositoryInterface;
use \Exception;
use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TransactionRepository implements TransactionRepositoryInterface
{
    protected $model;

    public function __construct(Transaction $model) {
        $this->model = $model;
    }

    public function all() { return $this->model->all(); }
    public function find($id) { return $this->model->findOrFail($id); }
    public function create(array $data) { return $this->model->create($data); }
    public function update($id, array $data) {
        $record = $this->find($id);
        $record->update($data);
        return $record;
    }
    public function delete($id) { return $this->find($id)->delete(); }
    public function query() { return $this->model->newQuery(); }

    public function buildQuery(array $filters) {
        $query = $this->model->query();
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")->orWhere('notes', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%");
            });
        }
        if (!empty($filters['type'])) { $query->where('type', strtolower($filters['type'])); }
        if (!empty($filters['category'])) { $query->where('category', $filters['category']); }
        if (!empty($filters['period'])) {
            $now = \Carbon\Carbon::now();
            switch ($filters['period']) {
                case 'today': case 'daily': case 'harian': $query->whereDate('transaction_date', $now->format('Y-m-d')); break;
                case 'this_week': case 'weekly': case 'mingguan': $query->whereBetween('transaction_date', [$now->copy()->startOfWeek()->format('Y-m-d'), $now->copy()->endOfWeek()->format('Y-m-d')]); break;
                case 'this_month': case 'monthly': case 'bulanan': $query->whereBetween('transaction_date', [$now->copy()->startOfMonth()->format('Y-m-d'), $now->copy()->endOfMonth()->format('Y-m-d')]); break;
            }
        }
        if (!empty($filters['date_start'])) { $query->whereDate('transaction_date', '>=', $filters['date_start']); }
        if (!empty($filters['date_end'])) { $query->whereDate('transaction_date', '<=', $filters['date_end']); }
        $sortBy = $filters['sort_by'] ?? 'transaction_date';
        $sortDir = strtolower($filters['sort_dir'] ?? 'desc') === 'asc' ? 'asc' : 'desc';
        if (!in_array($sortBy, ['transaction_date', 'amount', 'created_at', 'description', 'category'])) { $sortBy = 'transaction_date'; }
        return $query->orderBy($sortBy, $sortDir)->orderBy('id', 'desc');
    }

    public function getPaginatedTransactions(array $filters, int $perPage) {
        return $this->buildQuery($filters)->paginate($perPage)->withQueryString();
    }

    public function getFilteredSummary(array $filters) {
        $query = $this->buildQuery($filters);
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

    public function getLatestTransaction() {
        return $this->model->orderBy('id', 'desc')->first();
    }

    public function getTotalExpenseByCategoryAndDate($category, $start, $end) {
        return $this->model->where('category', $category)->where('type', 'expense')->whereBetween('transaction_date', [$start, $end])->sum('amount');
    }

    public function sumByTypeAndMonth($type, $year, $month) {
        return $this->model->where('type', $type)->whereYear('transaction_date', $year)->whereMonth('transaction_date', $month)->sum('amount');
    }

    public function sumByTypeAndDateRange($type, $startDate, $endDate) {
        return $this->model->where('type', $type)->whereBetween('transaction_date', [$startDate, $endDate])->sum('amount');
    }

    public function getExpensesByCategoryMonth($year, $month) {
        return $this->model->where('type', 'expense')->whereYear('transaction_date', $year)->whereMonth('transaction_date', $month)->select('category', \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'))->groupBy('category')->orderByDesc('total')->get();
    }
    
    public function getExpensesByCategoryDate($date) {
        return $this->model->whereDate('transaction_date', $date)->where('type', 'expense')->select('category', \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'))->groupBy('category')->orderByDesc('total')->get();
    }
    
    public function getExpensesByCategoryDateRange($start, $end) {
        return $this->model->whereBetween('transaction_date', [$start, $end])->where('type', 'expense')->select('category', \Illuminate\Support\Facades\DB::raw('SUM(amount) as total'))->groupBy('category')->orderByDesc('total')->get();
    }

    public function countAll() {
        return $this->model->count();
    }
    
    public function getRecent($limit = 5) {
        return $this->model->orderBy('transaction_date', 'desc')->orderBy('id', 'desc')->limit($limit)->get();
    }

    public function getByDate($date) {
        return $this->model->whereDate('transaction_date', $date)->orderBy('amount', 'desc')->get();
    }

    public function getByDateRange($start, $end) {
        return $this->model->whereBetween('transaction_date', [$start, $end])->orderBy('transaction_date', 'desc')->get();
    }

    public function getByMonth($year, $month) {
        return $this->model->whereYear('transaction_date', $year)->whereMonth('transaction_date', $month)->orderBy('transaction_date', 'desc')->get();
    }

}
