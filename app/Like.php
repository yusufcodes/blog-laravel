<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // Defining the relationship of a Like -> a Post
    // Like [belongsTo] Post (One to One)
    // Post [hasMany] Likes (One to Many)
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
