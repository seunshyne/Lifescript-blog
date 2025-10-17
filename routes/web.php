<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;


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
