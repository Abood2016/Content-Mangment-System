<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Nicolaslopezj\Searchable\SearchableTrait;

class Page extends Model
{
    use Sluggable,SearchableTrait;
    protected $guarded = [];
    protected $table = 'posts';

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
        return $this->belongsTo(Category::class,'category_id','id');
    }

    function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

   
    function media()
    {
        return $this->hasMany(Post_images::class,'post_id','id');
    }

    public function status()
    {
        return $this->status = 1 ? 'Active' : 'DeActive';
    }

}
