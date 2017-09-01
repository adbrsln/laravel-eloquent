<?php
use App\Post;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//read all records
Route::get('/read', function(){
    $posts = Post::all(); //pulling all the records

    foreach($posts as $post){
        return $post->title;
    }
});

//read certain record
Route::get('/find', function(){
    $post = Post::find(1); //pulling #1 the records

    return $post->title;
});

Route::get('/findwhere',function(){
    $post = Post::where('id', 3)->orderBy('id','desc')->take(1)->get();
    return $post;
});

Route::get('/findmore',function(){
    $posts = Post::findOrFail(4); //try to find a record error post #4 is not available
    return $posts;
});

Route::get('/findmore',function(){
    $posts = Post::where('users_count', '<', 50)->firstOrFail();
    return $posts;
});