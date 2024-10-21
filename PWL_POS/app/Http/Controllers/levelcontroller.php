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
            $btn  = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> '; 
            $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">' 
                    . csrf_field() . method_field('DELETE') .  
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
            return $btn; 
        }) 
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true);
    }

    // Create Data
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Level',
            'list' => ['Home','Level','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Data Level'
        ];

        $activeMenu = 'level';

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'level_kode'  => 'required|string|max:3|unique:m_level,level_kode',
            'level_nama'  => 'required|string|max:15'
        ]);

        LevelModel::create([
            'level_kode'  => $request->level_kode,
            'level_nama'  => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil Disimpan');
    }
    // Detail Data
    public function show(string $id){
        $level = LevelModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Level',
            'list' => ['Home','Level','Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level'
        ];

        $activeMenu = 'level';

        return view('level.show',['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level,'activeMenu' => $activeMenu]);
    }
    // Update Data
    public function edit(string $id){

        $level = LevelModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Level',
            'list' => ['Home','Level','Edit']
        ];
        $page = (object)[
            'title' => 'Edit Level'
        ];
        $activeMenu = 'level'; //set menu aktif

        return view('level.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'level' => $level]);
    }
    public function update(Request $request, string $id){
        $request->validate([
            'level_kode'  => 'required|string|max:3|unique:m_level,level_kode',
            'level_nama'  => 'required|string|max:15'
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);

        return redirect('/level')->with('success', 'Data Level berhasil diubah');

    }
    // Hapus data
    public function destroy(string $id){
        $check = LevelModel::find($id);
            if(!$check){
                return redirect('/level')->with('error','Data level tidak ditemukan');
            }

            try{
                LevelModel::destroy($id);

                return redirect('/level')->with('success','Data level berhasil dihapus');
            }catch (\Illuminate\Database\QueryException $e){
                // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan
                return redirect('/level')->with('error','Data level gagal dihapus masuk terdapat tabel lain yang terkait dengan data ini');
            }
    }
}
