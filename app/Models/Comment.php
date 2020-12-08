<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    function post()
    {
        return $this->belongsTo(Post::class);
    }

}
