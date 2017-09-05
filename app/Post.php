<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    //soft delete
    use SoftDeletes;
    protected $date= ['deleted_at'];

    protected $fillable = [
        //'user_id',
        'title',
        'content'
    ];

    //One to one relation ship to user
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function photos(){
        return $this->morphMany('App\Photo','imageable');
    }
}
