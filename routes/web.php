<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Route as RoutingRoute;

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




Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/posts/{post}/reaction',[PostController::class,'toggle_react']);
Route::post('/comments/{comment}/reaction',[PostController::class,'toggle_react']);


Route::resource('/posts',PostController::class);
Route::resource('/comments',CommentController::class);

Route::resource('/Profile',ProfileController::class);

Auth::routes();

