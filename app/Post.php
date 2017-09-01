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
        'title',
        'content'
    ];
}
