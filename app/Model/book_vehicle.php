<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class book_vehicle extends Model
{
    protected $table = 'book_vehicle';

    protected $guarded = [];

    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle','vehicle_id','id');
    }
}
