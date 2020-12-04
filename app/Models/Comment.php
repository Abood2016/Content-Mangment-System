<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    function posts()
    {
        return $this->belongsTo(Post::class);
    }

}
