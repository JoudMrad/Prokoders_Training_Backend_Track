<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 15);
        return $this->commentService->getAllComments($perPage);
    }

    public function store(StoreCommentRequest $request)
    {
        return $this->commentService->createComment($request->validated());
    }

    public function show(Comment $comment)
    {
        return $this->commentService->getComment($comment);
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        return $this->commentService->updateComment($comment, $request->validated());
    }

    public function destroy(Comment $comment)
    {
        $this->commentService->deleteComment($comment);
        return response()->json(null, 204);
    }

    public function postComments(Request $request, Post $post)
    {
        $perPage = $request->get('per_page', 15);
        return $this->commentService->getPostComments($post, $perPage);
    }
}
