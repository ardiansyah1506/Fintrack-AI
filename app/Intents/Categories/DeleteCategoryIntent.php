<?php

namespace App\Intents\Categories;

use App\Intents\Contracts\IntentInterface;
use App\Contracts\Repositories\CategoryRepositoryInterface;

class DeleteCategoryIntent implements IntentInterface
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function handle(array $parameters): array
    {
        $id = $parameters['id'] ?? null;
        if (!$id) {
            return ['intent' => 'delete_category', 
                'status' => 'error',
                'message' => 'Parameter id kategori wajib disertakan.'
            ];
        }

        $this->categoryRepository->delete($id);

        return ['intent' => 'delete_category', 
            'status' => 'success',
            'message' => "Kategori berhasil dihapus."
        ];
    }
}
