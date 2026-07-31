<?php

namespace App\Intents\Categories;

use App\Intents\Contracts\IntentInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;

class CreateCategoryIntent implements IntentInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function handle(array $parameters): array
    {
        $name = $parameters['name'] ?? null;
        $type = $parameters['type'] ?? 'expense';

        if (!$name) {
            return [
                'status' => 'error',
                'message' => 'Parameter name wajib diisi untuk membuat kategori.'
            ];
        }

        $category = $this->categoryRepository->create([
            'name' => $name,
            'type' => $type
        ]);

        return [
            'status' => 'success',
            'message' => "Kategori '{$category->name}' berhasil dibuat.",
            'data' => $category
        ];
    }
}
