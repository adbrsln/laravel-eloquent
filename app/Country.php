<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function posts(){
        // return $this->hasManyThrough('first table','secondtable');
        return $this->hasManyThrough('App\Post','App\User');
        //first table : has the user id that relate to second table
        //second table:  has country id that relates to country table
        //example : post(user_id) have User(Country_id) have Country(id) 
         //the country id will look into second table . and the user id will look into the first table
    }
}
