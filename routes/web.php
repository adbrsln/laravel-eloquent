<?php
//import post and user model
use App\Post;
use App\User;
use App\Role;
use App\Photo;
use App\Country;
use App\Tag;
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
            'user_id' => Auth::user()->id,
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

//restore the deleted data
Route::get('/restore',function(){
    Post::withTrashed()->where('is_admin',0)->restore(); 
});

//force delete the data
Route::get('/forcedelete',function(){
    Post::onlyTrashed()->where('is_admin',0)->forceDelete();
});

//Elequent Relationship ONE TO ONE 
Route::get('/user/{id}/post', function($id){
    return User::findOrFail($id)->post;
});
//Elequent Relationship ONE TO ONE: inverse relation
//desc: get user id from the post
Route::get('/post/{id}/user', function($id){
    return Post::findOrFail($id)->user->name;
});

//Elequent Relationship ONE TO Many
//desc: get all post from user
Route::get('/post', function(){
    $user = User::findOrFail($id);
    foreach($user->posts as $post){
        echo $post->title . "</br>";
    }
});

//Elequent Relationship Many to Many
//desc: get all roles from user
Route::get('/user/{id}/role', function($id){
    //get all roles current user id
    $user = User::findOrFail($id)->roles()->orderBy('id','asc')->get();
    
    return $user;

    //get current role
    // $user = User::findOrFail($id);
    // foreach($user->roles as $role){
    //     return $role->name ;
    // }
});

//Accessing the intermeidiate table / pivot table / hybrid lookup table
//desc: 
Route::get('/user/pivot', function(){
    $role = Role::findOrFail(1);
    foreach($role->users as $user){
        echo $user->pivot->created_at;
    }
});

//Accessing the intermeidiate table / pivot table / hybrid lookup table
//desc: 
Route::get('/user/country', function(){
    $country = Country::findOrFail(2);
    foreach($country->posts as $post){
        return $post->title;
    }
});

//polymorphic relation
Route::get('/user/photos', function(){
    $user = User::findOrFail(1);
    
    foreach($user->photos as $photo){
        return $photo;
    }
});

//Polymorphic inverse relation
Route::get('/photo/{id}/post', function($id){
    $photo = Photo::findOrFail($id);
    return $photo->imageable;
    
});

//Polymorphic many to many
Route::get('/post/tag', function(){
    $post = Post::findOrFail(2);
    foreach( $post->tags as $tag){
        echo $tag->name;
    }
    
});

//Polymorphic many to many
Route::get('/tag/post', function(){
    $tag = Tag::findOrFail(1);
    foreach( $tag->posts as $post){
        echo $post->title;
    }
    
});