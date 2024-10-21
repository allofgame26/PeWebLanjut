<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LevelModel;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class levelcontroller extends Controller
{
    // public function index(){
    //     $data = DB::select('Select * from m_level');
    //     return view('level', ['data' => $data]);
    // }

    // public function update(){
    //     $row = DB::update('update m_level set level_nama = ? , updated_at = ? where level_kode = ?',['customer',now(),'cus']);
    //     return 'Update Data berhasil. Jumlah data yang diupdate '. $row .' baris';
    // }
    // public function delete(){
    //     $row = DB::delete('delete from m_level where level_kode = ? ',['cus']);
    //     return 'Delete Data berhasil, jumlah data yang dihapus '.$row.' baris';
    // }

    // public function create(){
    //     DB::insert('insert into m_level(level_kode,level_nama,created_at) values (?,?,?)', ['cus','Pelanggan',now()]);
    //     return ' insert daya baru berhasil';
    // }


    // Menu Utama
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Level',
            'list' => ['Home', 'Level']
        ];
        $page = (object) [
            'title' => 'Daftar Level yang terdaftar dalam sistem'
        ];
        $activeMenu = 'Level'; //set menu yang sedang aktif
        
        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(){
        $level = LevelModel::select('level_id','level_kode','level_nama'); 
    
 
    return DataTables::of($level) 
        // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
        ->addIndexColumn()  
        ->addColumn('aksi', function ($level) {  // menambahkan kolom aksi 
            $btn  = '<a href="'.url('/user/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> '; 
            $btn .= '<a href="'.url('/user/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$level->level_id).'">' 
                    . csrf_field() . method_field('DELETE') .  
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
            return $btn; 
        }) 
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true);
    }

    // Create Data
    public function create(){

    }
    public function store(){

    }
    // Detail Data
    public function show(){

    }
    // Update Data
    public function edit(){

    }
    public function update(){

    }
    // Hapus data
    public function destroy(){
        
    }
}
