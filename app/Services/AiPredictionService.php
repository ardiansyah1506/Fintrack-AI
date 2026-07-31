<?php

namespace App\Services;

use App\Contracts\Repositories\AiPredictionRepositoryInterface;

class AiPredictionService
{
    protected $repository;

    public function __construct(AiPredictionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll() {
        return $this->repository->all();
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
