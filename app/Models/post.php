<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
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
        return $this -> belongsTo(category::class);
    }

    public function author()
    {
        return $this -> belongsTo(author::class);
    }

    public function comments()
    {
        return $this -> hasMany(comment::class);
    }
}
