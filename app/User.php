<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes;

    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'username';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'id','name', 'email', 'password','username',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
       return $this->hasOne('App\Profile','user_id','id');
    }

    public function blogs()
    {
        return $this->hasMany('App\Blog','user_id','id');
    }

    public function roles(){
        return $this->belongsToMany('App\Role','role_user','user_id','role_id','id','id');
    }

    public function tours()
    {
        return $this->hasMany('App\Tour','user_id','id');
    }

    public function book_tour()
    {
        return $this->hasMany('App\Model\book_tour','user_id','id');
    }

    public function hotels()
    {
        return $this->hasMany('App\Hotel','user_id','id');
    }

    public function vehicles()
    {
        return $this->hasMany('App\Vehicle','user_id','id');
    }

    public function book_hotel()
    {
        return $this->hasMany('App\Model\book_hotel','user_id','id');
    }

    public function book_vehicle()
    {
        return $this->hasMany('App\Model\book_vehicle','user_id','id');
    }
}
