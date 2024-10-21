<?php

use App\Http\Controllers\adminlteController;
use App\Http\Controllers\barangcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\levelcontroller;
use App\Http\Controllers\kategoricontroller;
use App\Http\Controllers\suppliercontroller;
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

// AdminLTE
Route::get('/',[WelcomeController::class, 'index']);

// User Routing
Route::group(['prefix' => 'user'], function() {
    Route::get('/',[usercontroller::class, 'index']); // Menampilkan halaman awal user
    Route::post('/list',[usercontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/create',[usercontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/store',[usercontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/{id}',[usercontroller::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit',[usercontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/{id}', [usercontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}',[usercontroller::class, 'destroy']); // menghapus data user
});

//Level Routing
Route::group(['prefix' => 'level'], function(){
    Route::get('/',[levelcontroller::class, 'index']);
    Route::post('/list',[levelcontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/create',[levelcontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/store',[levelcontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/{id}',[levelcontroller::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit',[levelcontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/{id}', [levelcontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}',[levelcontroller::class, 'destroy']); // menghapus data user
});
// Kategori Routing
Route::group(['prefix' => 'kategori'], function(){
    Route::get('/',[kategoricontroller::class, 'index']);
    Route::post('/list',[kategoricontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/create',[kategoricontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/store',[kategoricontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/{id}',[kategoricontroller::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit',[kategoricontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/{id}', [kategoricontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}',[kategoricontroller::class, 'destroy']); // menghapus data user
});
// Supplier Routing
Route::group(['prefix' => 'supplier'], function(){
    Route::get('/',[suppliercontroller::class, 'index']);
    Route::post('/list',[suppliercontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/create',[suppliercontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/store',[suppliercontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/{id}',[suppliercontroller::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit',[suppliercontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/{id}', [suppliercontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}',[suppliercontroller::class, 'destroy']); // menghapus data user
});
// Barang Routing
Route::group(['prefix' => 'barang'], function(){
    Route::get('/',[barangcontroller::class, 'index']);
    Route::post('/list',[barangcontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/create',[barangcontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/store',[barangcontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/{id}',[barangcontroller::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit',[barangcontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/{id}', [barangcontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}',[barangcontroller::class, 'destroy']); // menghapus data user
});
    


