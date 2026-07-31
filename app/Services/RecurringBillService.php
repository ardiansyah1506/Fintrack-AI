<?php

namespace App\Services;

use App\Contracts\Repositories\RecurringBillRepositoryInterface;

class RecurringBillService
{
    protected $repository;

    public function __construct(RecurringBillRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(array $filters = [], int $perPage = 10) {
        return $this->repository->getPaginated($filters, $perPage);
    }

    public function create(array $data) {
        return $this->repository->create($data);
    }

    public function update($id, array $data) {
        return $this->repository->update($id, $data);
    }

    public function delete($id) {
        return $this->repository->delete($id);
    }
}
