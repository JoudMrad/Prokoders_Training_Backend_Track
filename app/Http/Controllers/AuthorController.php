<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Services\AuthorService;
use Illuminate\Http\Request;
use App\Models\Author; 

class AuthorController extends Controller
{
    protected $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        return $this->authorService->getAllAuthors($perPage);
    }

    public function store(StoreAuthorRequest $request)
    {
        return $this->authorService->createAuthor($request->validated());
    }

    public function show(Author $author) 
    {
        return $this->authorService->getAuthor($author);
    }

    public function update(UpdateAuthorRequest $request, Author $author) 
    {
        return $this->authorService->updateAuthor($author, $request->validated());
    }

    public function destroy(Author $author) 
    {
        $this->authorService->deleteAuthor($author);
        return response()->json(null, 204);
    }
}