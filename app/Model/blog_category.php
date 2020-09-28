<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class blog_category extends Model
{
    protected $table = 'categories_for_blog';

    protected $guarded = [];

    public function blogs()
    {
        return $this->belongsToMany('App\Blog','blog_category','blog_id','category_id','id','id');
    }
}
