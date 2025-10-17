<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

/*
Route::get('/', function () {
    return "Welcom To my Blog";
});

Route::get('/posts', function() {
    return "List of blog posts";
});

Route::get('/post/{id}', function ($id) {
    return " Viewing post with ID:" . $id;
});

Route::get('/author/{name?}', function($name = "Guest") {
    return "Author:" . $name;
});

Route::get('/dashboard', function() {
    return "Welcome to dashboard";
})->name('dashboard');

//Example of generating a URL
Route::get('/go-to-dashboard', function() {
    return route('dashboard');
});

//Returning a view on Route
Route::get('/hello', function() {
    return view('hello');
});

//Passing data to view
Route::get('/greet/{name}', function($name) {
    return view('greet', ['name' => $name]);
});

//Named view with dots
Route::get('/post', function () {
    return view('blog.post');
});
*/

// Route::get('/', [PageController::class, 'home'])->name('home');

// Route::get('/about', [PageController::class, 'about'])->name('about');

// Route::get('/posts', [PageController::class, 'posts'])->name('posts');

// Route::get('contact', [PageController::class, 'contact'])->name('contact');

//Route::resource('posts', PostController::class);

Route::get('/', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Comment Routes
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');

Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');

Route::put('/comments/{comment}/update', [CommentController::class, 'update'])->name('comments.update');

Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

//Protect posts with auth middleware
Route::middleware('auth')->group(function() {
    Route::resource('posts', PostController::class);
});
