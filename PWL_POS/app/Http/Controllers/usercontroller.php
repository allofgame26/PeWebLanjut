<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usermodel;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;

class usercontroller extends Controller
{
    public function index(){

        //tambah data dengan Eluqoment Model
        $data = [
            'level_id' => 2,
            'username' => 'manager22',
            'nama' => 'Manager dua dua',
            'password' => hash::make('12345'),
        ];
        usermodel::insert($data);

        //Mencoba Akses model usermodel
        $user = usermodel::all();// ambil semua data dari tabel m_user
        return view('user',['data' => $user]);
    }

    public function update(){
        $data = [
            'nama' => 'Pelanggan Pertama'
        ];
        usermodel::where('username', 'customer1')->update($data); // update data user
    }

    public function viewall(){
        $user = usermodel::all();// ambil semua data dari tabel m_user
        return view('user',['data' => $user]);
    }

    public function find(){
        $user = usermodel::find(2);
        return view('user',['data' => $user]);
    }

    public function where(){
        $user = usermodel::where('level_id', 1)->first();
        return view('user',['data' => $user]);
    }
    public function firstwhere(){
        $user = usermodel::firstwhere('level_id', 2);
        return view('user',['data' => $user]);
    }
    public function findor(){
        $user = usermodel::findor(20,['username', 'nama'], function(){
            abort(404);
        });
        return view('user',['data' => $user]);
    }
    public function findorfail(){
        $user = usermodel::findOrFail(1);
        return view('user',['data' => $user]);
    }
    public function wherefindorfail(){
        $user = usermodel::where('username','manager')->firstOrFail();
        return view('user',['data' => $user]);
    }
    public function wherecount(){
        $user = usermodel::where('level_id','2')->count();
        // dd($user); // Dump or Die. Digunkan untuk menampilkan isi variabel dan menghentikan eksekusi script secara langsung.
        return view('user',['data' => $user]);
    }
    public function firstorcreate(){
        $user = usermodel::firstOrCreate(
            [
                'username' => 'manager22',
                'nama' => 'Manager Dua Dua',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ],
        );
        return view('user',['data' => $user]);
    }
    public function firstornew(){
        $user = usermodel::firstOrNew(
            ['username' => 'manager33'],
            [
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ]
        );
        $user ->save();
        
        return view('user',['data' => $user]);
    }
    public function dirtyclean(){
        $user = usermodel::create(
            [   'username' => 'manager55',
                'nama' => 'Manager55',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ]
        );
        $user ->username = 'manager56';

        $user->isDirty(); // pengecekan apakah ada atribut model yang telah diubah sejak model diambil
        $user->isDirty('username'); // True telah diuubah
        $user->isDirty('nama'); // false karena tidak dirubah
        $user->isDirty(['nama','username']); // True telah dirubah karena username telah dirubah

        $user->isClean(); // pengecekan apakah ada suatu attribut tetap tidak berubah sejak model diambil
        $user->isClean('username'); // hasil false, karena sudah terganti oleh data baru
        $user->isClean('nama'); // hasil true, dikarenakan attribut nama tidak ada perubahan
        $user->isClean(['nama','username']); // False, Karena ada data yang telah di ubah

        $user ->save();

        $user->isDirty(); //false
        $user->isClean(); //true
        dd($user->isDirty());
    }
    public function waschange(){
        $user = usermodel::create(
            [   'username' => 'manager11',
                'nama' => 'Manager11',
                'password' => Hash::make('12345'),
                'level_id' => 2,
            ]
        );
        $user ->username = 'manager12';

        $user ->save();

        $user->wasChanged(); // pengecekan apakah ada atribut model yang telah diubah sejak model diambil
        $user->wasChanged('username'); // True telah diuubah
        $user->wasChanged('nama'); // false karena tidak dirubah
        $user->wasChanged(['nama','username']); // True telah dirubah karena username telah dirubah

        dd($user->wasChanged(['nama','username']));
    }
}
