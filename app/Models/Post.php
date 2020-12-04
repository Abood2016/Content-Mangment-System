<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Post extends Model
{
    use Sluggable, SearchableTrait;
    protected $guarded = [];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    protected $searchable = [
        'columns' => [
            'posts.title'  => 10,
            'posts.description'  => 10,

        ]
    ];

    function category()
    {
        return $this->belongsTo(Category::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function comments()
    {
        return $this->hasMany(Comment::class);
    }

    function approved_comments()
    {
        return $this->hasMany(Comment::class)->whereStatus(1);
    }

    function media()
    {
        return $this->hasMany(Post_images::class);
    }
}
