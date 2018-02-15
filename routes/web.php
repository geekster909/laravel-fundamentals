<?php

use App\Post;
use App\User;

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

// Route::get('/about', function () {
//     return 'About Page';
// });

// Route::get('/contact', function () {
//     return 'Contact Page';
// });

// Route::get('/post/{id}/{name}',function($id, $name) {
// 	return 'This is post number ' . $id . ' ' . $name;
// });

// Route:: get('/admin/posts/example', array( 'as' => 'admin.home', function() {

// 	$url = route('admin.home');

// 	return 'this url is ' . $url;
// }));

// Route::get('/post/{id}', 'PostsController@index');
// Route::resource('posts', 'PostsController');
Route::get('post/{id}', 'PostsController@show_post');

Route::get('/contact', 'PostsController@contact');

/*
|--------------------------------------------------------------------------
| DB Raw SQL Queries
|--------------------------------------------------------------------------
*/

// Route::get('/insert', function(){
	// DB::insert('INSERT INTO posts(title, content) VALUES(?, ?)', ['Larevel is awesome', 'Laravel is the best thingthat has happened to PHP, PERIOD']);
// });

// Route::get('/read', function(){
// 	$results = DB::select('SELECT * FROM posts WHERE id = ?', [1]);

// 	foreach ($results as $post) {
// 		return $post->title;
// 	}
// });

// Route::get('/update', function(){
// 	$update = DB::update('UPDATE posts SET title = "Updated title" WHERE id = ?', [2]);

// 	return $update;
// });

// Route::get('/delete', function(){
// 	$deleted = DB::delete('DELETE FROM posts WHERE id = ?', [2]);

// 	return $deleted;
// });

/*
|--------------------------------------------------------------------------
| ELOQUENT 
|--------------------------------------------------------------------------
*/

Route::get('/read', function() {
	$posts = Post::all();
	foreach ($posts as $post) {
		return $post->title;
	}
});

Route::get('/find', function() {
	$post = Post::find(1);
	return $post->title;
});

Route::get('/findwhere', function() {
	$posts = Post::where('id', 1)->orderBy('id', 'desc')->take(1)->get();
	foreach ($posts as $post) {
		return $post->title;
	}
});

Route::get('/findmore', function() {
	// $posts = Post::findOrFail(1);
	$posts = Post::where('id', '<', 50)->get();
	foreach ($posts as $post) {
		echo $post->title . '<br />';
	}
});

Route::get('/basicinsert', function() {
	$post = new Post;

	$post->title = 'New Eloquent Title';
	$post->content = 'Wow eloquent is really cool, look at this content';

	$post->save();
});
Route::get('/basicupdate', function() {
	$post = Post::find(4);

	$post->title = 'New Eloquent Title v2';
	$post->content = 'Wow eloquent is really cool, look at this content';

	$post->save();
});

Route::get('/create', function() {
	Post::create(['title'=>'The create method', 'content'=>'WOW I\'m learning a lot with Edwin Diaz']);
});

Route::get('/update', function() {
	Post::where('id', 1)->where('is_admin', 0)->update(['title' => 'NEW PHP TITLE', 'content' => 'I love my instructor']);
});

Route::get('/delete', function() {
	$post = Post::find(7);
	$post->delete();
});

Route::get('/delete2', function() {
	// Post::destroy(3);
	Post::destroy([4,5]);

	// Post::where('is_admin', 0)->delete();
});

Route::get('/softdelete', function() {
	Post::find(7)->delete();
});

Route::get('/readsoftdelete', function() {
	// $post = Post::withTrashed()->where('id',6)->get();
	$post = Post::withTrashed()->get();

	return $post;
});

Route::get('/restore', function() {
	Post::withTrashed()->where('id', 6)->restore();
});

Route::get('/forcedelete', function() {
	Post::onlyTrashed()->where('id', 7)->forceDelete();
});

/*
|--------------------------------------------------------------------------
| ELOQUENT Relationships
|--------------------------------------------------------------------------
*/

// One to One relationship
Route::get('/user/{id}/post', function($id) {
	$user = User::find($id)->post;
	// $user = User::find($id)->post->title;
	// $user = User::find($id)->post->content;

	return $user;
});

// Inverse One to One relationship
Route::get('/post/{id}/user', function($id) {
	return Post::find($id)->user->name;
});

// One to Many relationship
Route::get('/posts', function() {
	$user = User::find(1);

	foreach($user->posts as $post) {
		echo $post->title . '<br />';
	}
});

// Many to Many relationship
Route::get('/user/{id}/role', function($id) {
	// $user = User::find($id);
	
	// foreach($user->roles as $role) {
	// 	echo $role->name;
	// }
	$user = User::find($id)->roles()->orderBy('id', 'desc')->get();

	return $user;

});