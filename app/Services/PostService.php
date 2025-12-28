<?php

namespace App\Services;

use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class PostService
{
    
    public function getAllPosts(int $perPage = 10): PostCollection
    {
        $posts = Post::with(['category', 'author', 'comments', 'topics'])
                    ->withCount('comments')
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
                    
        return new PostCollection($posts);
    }
    
    public function getPost(Post $post): PostResource
    {
        $post->load(['category', 'author', 'comments', 'topics']);
        return new PostResource($post);
    }
    
    public function createPost(array $data): PostResource
    {
        $post = Post::create($data);

        if (isset($data['topic_ids'])) {
            $post->topics()->attach($data['topic_ids']);
        }

        $post->load(['category', 'author', 'comments', 'topics']);
        return new PostResource($post);
    }
    
    public function updatePost(Post $post, array $data): PostResource
    {
        $post->update($data);

        if (isset($data['topic_ids'])) {
            $post->topics()->sync($data['topic_ids']);
        }

        $post->load(['category', 'author', 'comments', 'topics']);
        return new PostResource($post);
    }
    
    public function deletePost(Post $post): void
    {
        $post->delete();
    }
    
    public function getPostsByCategory(int $categoryId, int $perPage = 10): PostCollection
    {
        $posts = Post::with(['category', 'author', 'comments', 'topics'])
                    ->withCount('comments')
                    ->where('category_id', $categoryId)
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
        
        return new PostCollection($posts);
    }
    
    public function getPostsByAuthor(int $authorId, int $perPage = 10): PostCollection
    {
        $posts = Post::with(['category', 'author', 'comments', 'topics'])
                    ->withCount('comments')
                    ->where('author_id', $authorId)
                    ->orderBy('created_at', 'desc')
                    ->paginate($perPage);
        
        return new PostCollection($posts);
    }
}