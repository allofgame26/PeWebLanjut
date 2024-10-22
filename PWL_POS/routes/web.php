<?php

use App\Http\Controllers\adminlteController;
use App\Http\Controllers\authcontroller;
use App\Http\Controllers\barangcontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\levelcontroller;
use App\Http\Controllers\kategoricontroller;
use App\Http\Controllers\suppliercontroller;
use App\Http\Controllers\usercontroller;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\stokcontroller;
use App\Http\Controllers\penjualancontroller;
use App\Http\Controllers\detailcontroller;
use App\Http\Middleware\Authenticate;
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
    Route::get('/create_ajax',[usercontroller::class,'create_ajax']); // menampilkan halaman form tambah user dengan ajax
    Route::post('/ajax',[usercontroller::class,'store_ajax']); // menyimpan data user baru ajax
    Route::get('/{id}/show_ajax',[usercontroller::class,'show_ajax']); // menyimpan data user baru ajax
    Route::get('/{id}',[usercontroller::class, 'show']); //menampilkan detail user
    // Route::get('/{id}/edit',[usercontroller::class, 'edit']); //menampilakn halaman form edit user
    // Route::put('/{id}', [usercontroller::class, 'update']); // menyimpan perubahan data user
    Route::get('/{id}/edit_ajax', [usercontroller::class, 'edit_ajax']); // menyimpan perubahan data user
    Route::put('/{id}/update_ajax', [usercontroller::class, 'update_ajax']); // menyimpan perubahan data user
    Route::get('/{id}/confirm_ajax', [usercontroller::class, 'confirm_ajax']); // memberikan confirm hapus
    Route::delete('/{id}/delete_ajax', [usercontroller::class, 'delete_ajax']); //menghapus data
    // Route::delete('/{id}',[usercontroller::class, 'destroy']); // menghapus data user
    
});

//Level Routing
Route::middleware(['authorize:ADM'])->group(function(){
    Route::get('/level',[levelcontroller::class, 'index']);
    Route::post('/level/list',[levelcontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/level/create',[levelcontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::get('/level/create_ajax',[levelcontroller::class,'create_ajax']); // menampilkan halaman form tambah user dengan ajax
    Route::post('/level/ajax',[levelcontroller::class,'store_ajax']); // menyimpan data user baru ajax
    Route::get('/level/{id}/edit_ajax', [levelcontroller::class, 'edit_ajax']); // menyimpan perubahan data user
    Route::put('/level/{id}/update_ajax', [levelcontroller::class, 'update_ajax']); // menyimpan perubahan data user
    Route::get('/level/{id}/confirm_ajax', [levelcontroller::class, 'confirm_ajax']); // memberikan confirm hapus
    Route::delete('/level/{id}/delete_ajax', [levelcontroller::class, 'delete_ajax']); //menghapus data
    Route::post('/level/store',[levelcontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/level/{id}',[levelcontroller::class, 'show']); //menampilkan detail user
    Route::get('/level/{id}/edit',[levelcontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/level/{id}', [levelcontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/level/{id}',[levelcontroller::class, 'destroy']); // menghapus data user
});

Route::middleware(['authorize:ADM,MNG'])->group(function(){
    Route::get('/barang',[barangcontroller::class, 'index']);
    Route::post('/barang/list',[barangcontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/barang/create_ajax',[barangcontroller::class,'create_ajax']); // menampilkan halaman form tambah user dengan ajax
    Route::post('/barang/ajax',[barangcontroller::class,'store_ajax']); // menyimpan data user baru ajax
    Route::get('/barang/{id}/edit_ajax', [barangcontroller::class, 'edit_ajax']); // menyimpan perubahan data user
    Route::put('/barang/{id}/update_ajax', [barangcontroller::class, 'update_ajax']); // menyimpan perubahan data user
    Route::get('/barang/{id}/confirm_ajax', [barangcontroller::class, 'confirm_ajax']); // memberikan confirm hapus
    Route::delete('/barang/{id}/delete_ajax', [barangcontroller::class, 'delete_ajax']); //menghapus data
    Route::get('/barang/create',[barangcontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::post('/barang/store',[barangcontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/barang/{id}',[barangcontroller::class, 'show']); //menampilkan detail user
    Route::get('/barang/{id}/edit',[barangcontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/barang/{id}', [barangcontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/barang/{id}',[barangcontroller::class, 'destroy']); // menghapus data user
});

// Route::group(['prefix' => 'level'], function(){
//     Route::get('/',[levelcontroller::class, 'index']);
//     Route::post('/list',[levelcontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
//     Route::get('/create',[levelcontroller::class, 'create']); // menampilkan halaman form tambah user
//     Route::get('/create_ajax',[levelcontroller::class,'create_ajax']); // menampilkan halaman form tambah user dengan ajax
//     Route::post('/ajax',[levelcontroller::class,'store_ajax']); // menyimpan data user baru ajax
//     Route::get('/{id}/edit_ajax', [levelcontroller::class, 'edit_ajax']); // menyimpan perubahan data user
//     Route::put('/{id}/update_ajax', [levelcontroller::class, 'update_ajax']); // menyimpan perubahan data user
//     Route::get('/{id}/confirm_ajax', [levelcontroller::class, 'confirm_ajax']); // memberikan confirm hapus
//     Route::delete('/{id}/delete_ajax', [levelcontroller::class, 'delete_ajax']); //menghapus data
//     Route::post('/store',[levelcontroller::class, 'store']); // Menyimpan data user baru
//     Route::get('/{id}',[levelcontroller::class, 'show']); //menampilkan detail user
//     Route::get('/{id}/edit',[levelcontroller::class, 'edit']); //menampilakn halaman form edit user
//     Route::put('/{id}', [levelcontroller::class, 'update']); // menyimpan perubahan data user
//     Route::delete('/{id}',[levelcontroller::class, 'destroy']); // menghapus data user
// });
// Kategori Routing
Route::group(['prefix' => 'kategori'], function(){
    Route::get('/',[kategoricontroller::class, 'index']);
    Route::post('/list',[kategoricontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
    Route::get('/create',[kategoricontroller::class, 'create']); // menampilkan halaman form tambah user
    Route::get('/create_ajax',[kategoricontroller::class,'create_ajax']); // menampilkan halaman form tambah user dengan ajax
    Route::post('/ajax',[kategoricontroller::class,'store_ajax']); // menyimpan data user baru ajax
    Route::get('/{id}/edit_ajax', [kategoricontroller::class, 'edit_ajax']); // menyimpan perubahan data user
    Route::put('/{id}/update_ajax', [kategoricontroller::class, 'update_ajax']); // menyimpan perubahan data user
    Route::get('/{id}/confirm_ajax', [kategoricontroller::class, 'confirm_ajax']); // memberikan confirm hapus
    Route::delete('/{id}/delete_ajax', [kategoricontroller::class, 'delete_ajax']); //menghapus data
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
    Route::get('/create_ajax',[suppliercontroller::class,'create_ajax']); // menampilkan halaman form tambah user dengan ajax
    Route::post('/ajax',[suppliercontroller::class,'store_ajax']); // menyimpan data user baru ajax
    Route::get('/{id}/edit_ajax', [suppliercontroller::class, 'edit_ajax']); // menyimpan perubahan data user
    Route::put('/{id}/update_ajax', [suppliercontroller::class, 'update_ajax']); // menyimpan perubahan data user
    Route::get('/{id}/confirm_ajax', [suppliercontroller::class, 'confirm_ajax']); // memberikan confirm hapus
    Route::delete('/{id}/delete_ajax', [suppliercontroller::class, 'delete_ajax']); //menghapus data
    Route::post('/store',[suppliercontroller::class, 'store']); // Menyimpan data user baru
    Route::get('/{id}',[suppliercontroller::class, 'show']); //menampilkan detail user
    Route::get('/{id}/edit',[suppliercontroller::class, 'edit']); //menampilakn halaman form edit user
    Route::put('/{id}', [suppliercontroller::class, 'update']); // menyimpan perubahan data user
    Route::delete('/{id}',[suppliercontroller::class, 'destroy']); // menghapus data user
});
// Barang Routing
// Route::group(['prefix' => 'barang'], function(){
//     Route::get('/',[barangcontroller::class, 'index']);
//     Route::post('/list',[barangcontroller::class, 'list']); // menampilkan data user dalambentuk json untuk datatables 
//     Route::get('/create_ajax',[barangcontroller::class,'create_ajax']); // menampilkan halaman form tambah user dengan ajax
//     Route::post('/ajax',[barangcontroller::class,'store_ajax']); // menyimpan data user baru ajax
//     Route::get('/{id}/edit_ajax', [barangcontroller::class, 'edit_ajax']); // menyimpan perubahan data user
//     Route::put('/{id}/update_ajax', [barangcontroller::class, 'update_ajax']); // menyimpan perubahan data user
//     Route::get('/{id}/confirm_ajax', [barangcontroller::class, 'confirm_ajax']); // memberikan confirm hapus
//     Route::delete('/{id}/delete_ajax', [barangcontroller::class, 'delete_ajax']); //menghapus data
//     Route::get('/create',[barangcontroller::class, 'create']); // menampilkan halaman form tambah user
//     Route::post('/store',[barangcontroller::class, 'store']); // Menyimpan data user baru
//     Route::get('/{id}',[barangcontroller::class, 'show']); //menampilkan detail user
//     Route::get('/{id}/edit',[barangcontroller::class, 'edit']); //menampilakn halaman form edit user
//     Route::put('/{id}', [barangcontroller::class, 'update']); // menyimpan perubahan data user
//     Route::delete('/{id}',[barangcontroller::class, 'destroy']); // menghapus data user
// });

// Auth Routing
Route::pattern('id','[0-9]+'); // ketika ada parameter (id), maka harus berupa angka
Route::get('/login',[authcontroller::class,'login'])->name('login');
Route::post('/postlogin',[authcontroller::class,'postlogin']);
Route::post('/logout',[authcontroller::class,'logout'])->middleware('auth');
Route::middleware(['auth'])->group(function(){
    // semua route didalam group ini harus lagin dlu
    // masukkan semua route yang perlu diauthentikasi disini
    Route::get('/',[WelcomeController::class, 'index']);
});

// Stok
Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
    Route::get('/stok', [stokcontroller::class, 'index']);          // menampilkan halaman awal stok
    Route::post('/stok/list', [stokcontroller::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/stok/create', [stokcontroller::class, 'create']);   // menampilkan halaman form tambah stok
    Route::get('/stok/create_ajax', [stokcontroller::class, 'create_ajax']);
    Route::post('/stok/ajax', [stokcontroller::class, 'store_ajax']);
    Route::post('/stok', [stokcontroller::class, 'store']);         // menyimpan data stok baru
    Route::get('/stok/{id}', [stokcontroller::class, 'show']);       // menampilkan detail stok
    Route::get('/stok/{id}/edit', [stokcontroller::class, 'edit']);  // menampilkan halaman form edit stok
    Route::put('/stok/{id}', [stokcontroller::class, 'update']);     // menyimpan perubahan data stok
    Route::get('/stok/{id}/edit_ajax', [stokcontroller::class, 'edit_ajax']);
    Route::put('/stok/{id}/update_ajax', [stokcontroller::class, 'update_ajax']);
    Route::get('/stok/{id}/delete_ajax', [stokcontroller::class, 'confirm_ajax']);
    Route::delete('/stok/{id}/delete_ajax', [stokcontroller::class, 'delete_ajax']);
    Route::delete('/stok/{id}', [stokcontroller::class, 'destroy']); // menghapus data stok
});

Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    Route::get('/penjualan', [PenjualanController::class, 'index']);          // menampilkan halaman awal stok
    Route::post('/penjualan/list', [PenjualanController::class, 'list']);      // menampilkan data stok dalam bentuk json untuk datatables
    Route::get('/penjualan/create', [PenjualanController::class, 'create']);   // menampilkan halaman form tambah stok
    Route::get('/penjualan/create_ajax', [PenjualanController::class, 'create_ajax']);
    Route::post('/penjualan/ajax', [PenjualanController::class, 'store_ajax']);
    Route::post('/penjualan', [PenjualanController::class, 'store']);         // menyimpan data stok baru
    Route::get('/penjualan/import', [PenjualanController::class, 'import']);
    Route::post('/penjualan/import_ajax', [PenjualanController::class, 'import_ajax']);
    Route::get('/penjualan/export_excel', [PenjualanController::class, 'export_excel']); // export excel
    Route::get('/penjualan/export_pdf', [PenjualanController::class, 'export_pdf']); // export pdf
    Route::get('/penjualan/{id}', [PenjualanController::class, 'show']);       // menampilkan detail stok
    Route::get('/penjualan/{id}/edit', [PenjualanController::class, 'edit']);  // menampilkan halaman form edit stok
    Route::put('/penjualan/{id}', [PenjualanController::class, 'update']);     // menyimpan perubahan data stok
    Route::get('/penjualan/{id}/edit_ajax', [PenjualanController::class, 'edit_ajax']);
    Route::put('/penjualan/{id}/update_ajax', [PenjualanController::class, 'update_ajax']);
    Route::get('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'confirm_ajax']);
    Route::delete('/penjualan/{id}/delete_ajax', [PenjualanController::class, 'delete_ajax']);
    Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy']); // menghapus data stok
});

Route::middleware(['authorize:ADM,MNG,STF'])->group(function () {
    Route::get('/detail', [DetailController::class, 'index']);          // menampilkan halaman awal stok
    Route::post('/detail/list', [DetailController::class, 'list']);  // menampilkan halaman form tambah stok
    Route::get('/detail/create_ajax', [DetailController::class, 'create_ajax']);
    Route::post('/detail/ajax', [DetailController::class, 'store_ajax']);       // menyimpan data stok baru
    Route::get('/detail/import', [DetailController::class, 'import']);
    Route::post('/detail/import_ajax', [DetailController::class, 'import_ajax']);
    Route::get('/detail/export_excel', [DetailController::class, 'export_excel']); // export excel
    Route::get('/detail/export_pdf', [DetailController::class, 'export_pdf']); // export pdf
    Route::get('/detail/{id}', [DetailController::class, 'show']);    // menyimpan perubahan data stok
    Route::get('/detail/{id}/edit_ajax', [DetailController::class, 'edit_ajax']);
    Route::put('/detail/{id}/update_ajax', [DetailController::class, 'update_ajax']);
    Route::get('/detail/{id}/delete_ajax', [DetailController::class, 'confirm_ajax']);
    Route::delete('/detail/{id}/delete_ajax', [DetailController::class, 'delete_ajax']);
    Route::delete('/detail/{id}', [DetailController::class, 'destroy']); // menghapus data stok
});
    


