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

}