<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * GET /api/categories
     */
    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllCategories($request->query('type'));

        return $this->successResponse(
            CategoryResource::collection($categories),
            'Berhasil mengambil data kategori'
        );
    }

    /**
     * POST /api/categories
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());

        return $this->successResponse(
            new CategoryResource($category),
            'Kategori berhasil dibuat',
            201
        );
    }

    /**
     * GET /api/categories/{id}
     */
    public function show($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        return $this->successResponse(
            new CategoryResource($category),
            'Berhasil mengambil detail kategori'
        );
    }

    /**
     * PUT /api/categories/{id}
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryService->updateCategory($id, $request->validated());

        return $this->successResponse(
            new CategoryResource($category),
            'Kategori berhasil diperbarui'
        );
    }

    /**
     * DELETE /api/categories/{id}
     */
    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return $this->successResponse(
            null,
            'Kategori berhasil dihapus'
        );
    }
}
