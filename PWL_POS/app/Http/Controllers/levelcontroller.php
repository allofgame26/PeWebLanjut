<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class levelcontroller extends Controller
{
    public function index(){
        $data = DB::select('Select * from m_level');
        return view('level', ['data' => $data]);
    }

    public function update(){
        $row = DB::update('update m_level set level_nama = ? , updated_at = ? where level_kode = ?',['customer',now(),'cus']);
        return 'Update Data berhasil. Jumlah data yang diupdate '. $row .' baris';
    }
    public function delete(){
        $row = DB::delete('delete from m_level where level_kode = ? ',['cus']);
        return 'Delete Data berhasil, jumlah data yang dihapus '.$row.' baris';
    }

    public function create(){
        DB::insert('insert into m_level(level_kode,level_nama,created_at) values (?,?,?)', ['cus','Pelanggan',now()]);
        return ' insert daya baru berhasil';
    }
}
