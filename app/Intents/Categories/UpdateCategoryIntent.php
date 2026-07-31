<?php

namespace App\Intents\Categories;

use App\Intents\Contracts\IntentInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;

class UpdateCategoryIntent implements IntentInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function handle(array $parameters): array
    {
        $id = $parameters['id'] ?? null;
        if (!$id) {
            return [
                'status' => 'error',
                'message' => 'Parameter id kategori wajib disertakan.'
            ];
        }

        $data = array_filter([
            'name' => $parameters['name'] ?? null,
            'type' => $parameters['type'] ?? null,
        ]);

        $category = $this->categoryRepository->update($id, $data);

        return [
            'status' => 'success',
            'message' => "Kategori berhasil diperbarui.",
            'data' => $category
        ];
    }
}
