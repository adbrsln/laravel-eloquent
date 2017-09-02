<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //ELEQUENT RELATIONSHIP : ONE TO ONE
    //desc:  since 1 post is made by one user
    public function post(){
        //this will use the id in table user connected to post column user_id column
        return $this->hasOne('App\Post');
    }
}
