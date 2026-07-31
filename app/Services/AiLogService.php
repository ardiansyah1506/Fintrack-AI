<?php
namespace App\Services;
use App\Contracts\Repositories\AiLogRepositoryInterface;
class AiLogService {
    public function __construct(protected AiLogRepositoryInterface $repository) {}
    public function getAll(array $filters = [], int $perPage = 10) { return $this->repository->getPaginated($filters, $perPage); }
    public function create(array $data) { return $this->repository->create($data); }
    public function update($id, array $data) { return $this->repository->update($id, $data); }
    public function delete($id) { return $this->repository->delete($id); }
}