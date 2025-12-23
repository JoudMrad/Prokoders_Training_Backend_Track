<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        $post = Post::create($validated);
        return response()->json($post, 201);
    }   
    
    public function index()
    {
        return response()->json(Post::all());
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id'
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, 204);
    }
}
