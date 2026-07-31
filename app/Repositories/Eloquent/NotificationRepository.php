<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\NotificationRepositoryInterface;
use \Exception;

class NotificationRepository implements NotificationRepositoryInterface
{
    protected $model;

    public function __construct($model = null)
    {
        $class = '\\App\\Models\\Notification';
        $this->model = $model ?? new $class;
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
}
