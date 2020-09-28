<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [];

    public function blogs()
    {
        return $this->belongsToMany('App\Blog','tags_blog','tag_id','blog_id','id','id');
    }

    public function tours()
    {
        return $this->belongsToMany('App\Tour','tags_tour','tag_id','tour_id','id','id');
    }


}
