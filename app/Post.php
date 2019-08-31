<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['title', 'content'];

    // Defining the relationship of a Post -> a Like
    // Post [hasMany] Likes (One to Many)
    // Like [belongsTo] Post (One to One)
    public function likes()
    {
        return $this->hasMany('App\Like');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    // Mutator to convert all post titles to lowercase
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = strtolower($value);
    }

}