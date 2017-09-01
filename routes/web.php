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

//try catch laravel eloquent
Route::get('/findmores',function(){
    $posts = Post::findOrFail(4); //try to find a record error post #4 is not available
    return $posts;
});

Route::get('/findmore',function(){
    $posts = Post::where('users_count', '<', 50)->firstOrFail();
    return $posts;
});

//eloquent insert new data
Route::get('/basicinsert',function(){
    $post = new Post;
    $post->title='new Eloquent title';
    $post->content='Lorem ipsupm this is eloquent  is really cool';
    $post->save();
});

//eloquent update data 
Route::get('/basicinsert2',function(){
    $post = Post::findOrFail(1);
    $post->title='New Updated #1 title';
    $post->content='Lorem ipsupm this is eloquent is really cool';
    $post->save();
});

Route::get('/create',function(){
    Post::create(
        [
            'title'=>'the  created method',
            'content'=>'wow im learning the created method'
        ]
    );
});
//update function
Route::get('/update',function(){
    Post::where('id',4)->where('is_admin',0)->update(['title'=>'updated NEWEST content','content'=>'This is updated content. i love my instructor']);
});

//delete function
Route::get('/delete',function(){
    $post = Post::find(6);
    $post->delete();
});

//delete function
Route::get('/delete3',function(){
    Post::destroy([4,5]);
    
    //using the query
    //Post::where('is_admin',0)->delete();
});

//softdelete 
Route::get('/softdelete',function(){
    Post::find(1)->delete();
});

//read softdelete
Route::get('/readsoftdelete',function(){
    // $post = Post::find(1);
    // return $post;

    //certain post
    // $post = Post::withTrashed()->where('id',1)->get();
    // return $post;

    //all post with all softdelete
    // $post = Post::withTrashed()->where('is_admin',0)->get();
    // return $post;

    //all post with softdelete
    $post = Post::onlyTrashed()->where('is_admin',0)->get();
    return $post;

});

Route::get('/restore',function(){
    Post::withTrashed()->where('is_admin',0)->restore();
});