<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return $this->postService->getAllPosts($perPage);
    }

    public function store(StorePostRequest $request)
    {
        return $this->postService->createPost($request->validated());
    }

    public function show(Post $post) 
    {
        return $this->postService->getPost($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        return $this->postService->updatePost($post, $request->validated());
    }

    public function destroy(Post $post) 
    {
        $this->postService->deletePost($post);
        return response()->json(null, 204);
    }

    public function postsByCategory(Request $request, $categoryId)
    {
        $perPage = $request->get('per_page', 10);
        return $this->postService->getPostsByCategory((int)$categoryId, $perPage);
    }

    public function postsByAuthor(Request $request, $authorId)
    {
        $perPage = $request->get('per_page', 10);
        return $this->postService->getPostsByAuthor((int)$authorId, $perPage);
    }
}
