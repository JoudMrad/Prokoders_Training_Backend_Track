<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Category; 

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return $this->categoryService->getAllCategories($perPage);
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryService->createCategory($request->validated());
    }

    public function show(Category $category) 
    {
        return $this->categoryService->getCategoryWithPosts($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category) 
    {
        return $this->categoryService->updateCategory($category, $request->validated());
    }

    public function destroy(Category $category) 
    {
        $this->categoryService->deleteCategory($category);
        return response()->json(null, 204);
    }

    public function categoriesWithPosts(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return $this->categoryService->getCategoriesWithPosts($perPage);
    }
}