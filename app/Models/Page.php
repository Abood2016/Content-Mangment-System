<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use Sluggable;
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

}
