<?php

namespace App\Services;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryService
{

    public function getAllCategories(int $perPage = 10): CategoryCollection
    {
        $categories = Category::withCount('posts')->paginate($perPage);
        return new CategoryCollection($categories);
    }
    
    public function getCategoryWithPosts(Category $category): CategoryResource
    {
        $category->load('posts');
        return new CategoryResource($category);
    }
    
    public function createCategory(array $data): CategoryResource
    {
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function updateCategory(Category $category, array $data): CategoryResource
    {
        $category->update($data);
        return new CategoryResource($category);
    }
    
    public function deleteCategory(Category $category): void
    {
        $category->delete();
    }
    
    public function getCategoriesWithPosts(int $perPage = 10): CategoryCollection
    {
        $categories = Category::with(['posts' => function ($query) {
            $query->with(['author', 'comments', 'topics']);
        }])->paginate($perPage);
        
        return new CategoryCollection($categories);
    }
}