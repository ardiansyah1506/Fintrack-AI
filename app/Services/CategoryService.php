<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Get all categories, optionally filtered by type.
     */
    public function getAllCategories(?string $type = null): Collection
    {
        $query = Category::withCount('transactions')->orderBy('name', 'asc');

        if ($type) {
            $query->where('type', strtolower($type));
        }

        return $query->get();
    }

    /**
     * Find category by ID.
     */
    public function getCategoryById(int $id): Category
    {
        return Category::withCount('transactions')->findOrFail($id);
    }

    /**
     * Create a new category.
     */
    public function createCategory(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'type' => strtolower($data['type']),
            'color' => $data['color'] ?? '#6B7280',
            'icon' => $data['icon'] ?? 'folder',
        ]);
    }

    /**
     * Update an existing category.
     */
    public function updateCategory(int $id, array $data): Category
    {
        $category = $this->getCategoryById($id);
        $oldName = $category->name;

        $category->update([
            'name' => $data['name'] ?? $category->name,
            'type' => strtolower($data['type'] ?? $category->type),
            'color' => $data['color'] ?? $category->color,
            'icon' => $data['icon'] ?? $category->icon,
        ]);

        if (isset($data['name']) && $data['name'] !== $oldName) {
            \App\Models\Transaction::where('category', $oldName)->update(['category' => $data['name']]);
        }

        return $category;
    }

    /**
     * Delete category by ID.
     */
    public function deleteCategory(int $id): bool
    {
        $category = $this->getCategoryById($id);
        return (bool) $category->delete();
    }
}
