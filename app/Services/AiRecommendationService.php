<?php

namespace App\Services;

use App\Contracts\Repositories\AiRecommendationRepositoryInterface;

class AiRecommendationService
{
    protected $repository;

    public function __construct(AiRecommendationRepositoryInterface $repository)
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
