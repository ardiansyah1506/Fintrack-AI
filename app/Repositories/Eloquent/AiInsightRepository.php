<?php
namespace App\Repositories\Eloquent;
use App\Contracts\Repositories\AiInsightRepositoryInterface;
class AiInsightRepository implements AiInsightRepositoryInterface {
    protected $model;
    public function __construct(\App\Models\AiInsight $model = null) { $class = '\App\Models\AiInsight'; $this->model = $model ?? new $class; }
    public function all() { return $this->model->all(); }
    public function find($id) { return $this->model->findOrFail($id); }
    public function create(array $data) { return $this->model->create($data); }
    public function update($id, array $data) { $record = $this->find($id); $record->update($data); return $record; }
    public function delete($id) { return $this->find($id)->delete(); }
    public function getPaginated(array $filters, int $perPage = 10) { $query = $this->model->newQuery(); if (!empty($filters['search'])) { $search = $filters['search']; $query->where(function($q) use ($search) { foreach (\Illuminate\Support\Facades\Schema::getColumnListing($this->model->getTable()) as $col) { $q->orWhere($col, 'like', "%{$search}%"); } }); } return $query->orderBy('id', 'desc')->paginate($perPage); }
}