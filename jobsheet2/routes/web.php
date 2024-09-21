<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return 'Selamat Datang';
});

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/Hello', function () {
    return 'Hello World';
});

Route::get('/world', function(){
    return 'World';
});

Route::get('/about',function(){
    return 'Nama : Rizki Arya Prayoga NIM : 2141762051';
});

// Route::get('/user/{name}', function($name){
//     return 'Nama saya '.$name;
// });

Route::get('/posts/{post}/comment/{comment}', function($post,$comment){
    return 'Pos ke-'.$post.' Komentar ke - '.$comment; 
});

Route::get('/user/{name?}', function($name = null){
    return 'Nama Saya'.$name;
});

Route::get('/user/profile', function () {
    //
})->name('profile');

Route::get('/hello',[WelcomeController::class,'hello']);

Route::get('/',[HomeController::class,'index']);

Route::get('/about',[AboutController::class,'about']);

Route::get('articles/{id}',[ArticleController::class,'articles']);

Route::get('/greeting',[WelcomeController::class,'greeting']);