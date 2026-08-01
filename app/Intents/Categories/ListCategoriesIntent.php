<?php

namespace App\Intents\Categories;

use App\Intents\Contracts\IntentInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;

class ListCategoriesIntent implements IntentInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function handle(array $parameters): array
    {
        $type = $parameters['type'] ?? null;

        $query = $this->categoryRepository->query();
        if ($type !== null && trim($type) !== '') {
            $query->where('type', strtolower(trim($type)));
        }

        $categories = $query->get();

        return [
            'status' => 'success',
            'message' => 'Berhasil mengambil daftar kategori.',
            'data' => $categories
        ];
    }
}
