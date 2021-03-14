<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;

    protected $table = 'vehicles';

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag','tags_vehicle','vehicle_id','tag_id','id','id');
    }

    public function bookings()
    {
        return $this->hasMany('App\Model\book_vehicle', 'vehicle_id', 'id');
    }
}
