<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'published_at',
        'category_id',
        'author_id',
    ];

    public function category()
    {
        return $this -> belongsTo(Category::class);
    }

    public function author()
    {
        return $this -> belongsTo(Author::class);
    }

    public function comments()
    {
        return $this -> hasMany(Comment::class);
    }
    
    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'post_topic');
    }
}
