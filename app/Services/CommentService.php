<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class CommentService
{
    
    public function getAllComments(int $perPage = 15): CommentCollection
    {
        $comments = Comment::with('post')->orderBy('created_at', 'desc')->paginate($perPage);
        return new CommentCollection($comments);
    }
    
    public function getComment(Comment $comment): CommentResource
    {
        $comment->load('post');
        return new CommentResource($comment);
    }
    
    public function createComment(array $data): CommentResource
    {
        $comment = Comment::create($data);
        $comment->load('post');
        return new CommentResource($comment);
    }
    
    public function updateComment(Comment $comment, array $data): CommentResource
    {
        $comment->update($data);
        $comment->load('post');
        return new CommentResource($comment);
    }
    
    public function deleteComment(Comment $comment): void
    {
        $comment->delete();
    }
    
    public function getPostComments(Post $post, int $perPage = 15): CommentCollection
    {
        $comments = $post->comments()->with('post')->orderBy('created_at', 'desc')->paginate($perPage);
        return new CommentCollection($comments);
    }
}