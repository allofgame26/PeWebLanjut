<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\levelcontroller;
use App\Http\Controllers\kategoricontroller;
use App\Http\Controllers\usercontroller;
use App\Models\usermodel;

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
Route::get('/kategoricreate', [kategoricontroller::class, 'index']); // untuk query Builder
Route::get('/kategoriupdate', [kategoricontroller::class, 'update']);
Route::get('/kategoridelete', [kategoricontroller::class, 'delete']);
Route::get('/kategoriview', [kategoricontroller::class, 'view']);
Route::get('/userview',[usercontroller::class, 'index']);
Route::get('/userupdate',[usercontroller::class, 'update']);
