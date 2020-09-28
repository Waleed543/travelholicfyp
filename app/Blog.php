<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function categories(){
        return $this->belongsToMany('App\Model\blog_category','blog_category','blog_id','category_id','id','id');
    }

    public function images()
    {
        return $this->morphMany('App\Image','imageable');
    }

    public function allComments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment','commentable')->where('parent_id','=',null);
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag','tags_blog','blog_id','tag_id','id','id');
    }
}
