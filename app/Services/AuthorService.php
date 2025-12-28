<?php

namespace App\Services;

use App\Models\Author;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorCollection;

class AuthorService
{

    public function getAllAuthors(int $perPage = 10): AuthorCollection
    {
        $authors = Author::withCount('posts')->paginate($perPage);
        return new AuthorCollection($authors);
    }
    
    public function getAuthor(Author $author): AuthorResource
    {
        $author->load('posts');
        return new AuthorResource($author);
    }
    
    public function createAuthor(array $data): AuthorResource
    {
        $author = Author::create($data);
        return new AuthorResource($author);
    }
    
    public function updateAuthor(Author $author, array $data): AuthorResource
    {
        $author->update($data);
        return new AuthorResource($author);
    }
    
    public function deleteAuthor(Author $author): void
    {
        $author->delete();
    }
}