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

    //ELEQUENT RELATIONSHIP : ONE TO Many
    //desc:  return all posts
    public function posts(){
        //this will use the id in table user connected to post column user_id column
        return $this->hasMany('App\Post');
    }

    //ELEQUENT RELATIONSHIP : Many to Many
    public function roles(){
        //this will use the id in table user connected to post column user_id column
         
        return $this->belongsToMany('App\Role');

        //to customize tables name and columns  follow the format below

        // return $this->belongsToMany('App\Role','user_roles', 'user_id','role_id');
       
    }

    public function photos(){
        return $this->morphMany('App\Photo','imageable');
    }
}
