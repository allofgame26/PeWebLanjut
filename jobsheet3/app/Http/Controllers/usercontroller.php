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
            'level_id' => 5,
            'username' => 'customer1',
            'nama' => 'Pelanggan',
            'password' => Hash::make('12345')
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
}
