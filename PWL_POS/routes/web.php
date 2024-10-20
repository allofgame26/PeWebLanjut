<?php

use App\Http\Controllers\adminlteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\levelcontroller;
use App\Http\Controllers\kategoricontroller;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\WelcomeController;
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
Route::get('/levelcreate', [levelcontroller::class, 'create']);
Route::get('/levelupdate',[levelcontroller::class, 'update']);
Route::get('/leveldelete',[levelcontroller::class, 'delete']);
Route::get('/levelview', [levelcontroller::class, 'index']); // kenapa bisa jika kita membuat ini? tetapi jika memasukkan lewat route "/" tidak bisa
Route::get('/kategoricreate', [kategoricontroller::class, 'index']); // untuk query Builder
Route::get('/kategoriupdate', [kategoricontroller::class, 'update']);
Route::get('/kategoridelete', [kategoricontroller::class, 'delete']);
Route::get('/kategoriview', [kategoricontroller::class, 'view']);
Route::get('/userindex',[usercontroller::class, 'index']);
Route::get('/userupdate',[usercontroller::class, 'update']);
Route::get('/userfind',[usercontroller::class, 'find']);
Route::get('/userviewall',[usercontroller::class, 'viewall'])->name('user');
Route::get('/userwhere',[usercontroller::class, 'where']);
Route::get('/userfirst',[usercontroller::class, 'firstwhere']);
Route::get('/userfindor',[usercontroller::class, 'findor']);
Route::get('/userfindorfail',[usercontroller::class, 'findorfail']);
Route::get('/userwherefindorfail',[usercontroller::class, 'wherefindorfail']);
Route::get('/userwherecount',[usercontroller::class, 'wherecount']);
Route::get('/userfirstorcreate',[usercontroller::class, 'firstorcreate']);
Route::get('/userfirstornew',[usercontroller::class, 'firstornew']);
Route::get('/userdirtyclean',[usercontroller::class, 'dirtyclean']);
Route::get('/userwaschange',[usercontroller::class, 'waschange']);
Route::get('/user/tambah',[usercontroller::class, 'tambah'])->name('tambah');
Route::post('/user/tambah_simpan',[usercontroller::class, 'tambah_simpan'])->name('tambah_simpan');
Route::get('/user/ubah/{id}',[usercontroller::class, 'ubah'])->name('ubah');
Route::put('/user/ubah_simpan/{id}',[usercontroller::class, 'ubah_simpan'])->name('ubah_simpan');
Route::get('/user/hapus/{id}',[usercontroller::class, 'hapus'])->name('hapus');
Route::get('/',[WelcomeController::class, 'index']);


