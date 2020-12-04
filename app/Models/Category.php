<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Cviebrock\EloquentSluggable\Sluggable;



class Category extends Model
{
  use Sluggable;

  protected $table = 'categories';

  protected $guarded = [];

  public function sluggable()
  {
    return [
      'slug' => [
        'source' => 'name'
      ]
    ];
  }

  function posts()
  {
    return $this->hasMany(Post::class);
  }
}
