<?php

namespace App\Services;

use App\Contracts\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $repository
    ) {}

    public function getAll(?string $type = null)
    {
        $query = $this->repository->query();
        if ($type !== null && trim($type) !== '') {
            $query->where('type', strtolower(trim($type)));
        }
        return $query->get();
    }

    public function getAllCategories(?string $type = null)
    {
        return $this->getAll($type);
    }

    public function getCategoryById($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function createCategory(array $data)
    {
        return $this->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function updateCategory($id, array $data)
    {
        return $this->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function deleteCategory($id)
    {
        return $this->delete($id);
    }
}
