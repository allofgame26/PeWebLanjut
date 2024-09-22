<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\levelcontroller;

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
    return view('welcome');
});

Route::get('/levelcreate', [levelcontroller::class, 'create']);
Route::get('/levelupdate',[levelcontroller::class, 'update']);
Route::get('/leveldelete',[levelcontroller::class, 'delete']);
Route::get('/levelview', [levelcontroller::class, 'index']); // kenapa bisa jika kita membuat ini? tetapi jika memasukkan lewat route "/" tidak bisa