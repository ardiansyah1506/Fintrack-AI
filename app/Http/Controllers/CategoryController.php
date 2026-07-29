<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $type = $request->query('type');
        $categories = $this->categoryService->getAllCategories($type);

        $expenseCategories = $categories->where('type', 'expense');
        $incomeCategories = $categories->where('type', 'income');

        return view('categories.index', compact('categories', 'expenseCategories', 'incomeCategories', 'type'));
    }

    /**
     * Store a newly created category.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->createCategory($request->validated());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update the specified category.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $this->categoryService->updateCategory($id, $request->validated());

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
