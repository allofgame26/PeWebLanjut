<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;
use App\Models\KategoriModel;

class barangcontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home', ' Barang']
        ];
        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];
        $activeMenu = 'barang'; //set menu yang sedang aktif
        
        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(Request $request){
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli','harga_jual','kategori_id')->with('kategori'); 
    
 
        return DataTables::of($barang) 
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($barang) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">' 
                        . csrf_field() . method_field('DELETE') .  
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';      
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    //create data
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home','Barang','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Data Barang'
        ];

        $kategori =KategoriModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'barang';

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'barang_kode'      => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama'      => 'required|string|max:100',
            'harga_beli'       => 'required|integer',
            'harga_jual'       => 'required|integer',
            'kategori_id'      => 'required|integer'
        ]);

        BarangModel::create([
            'barang_kode'      => $request->barang_kode,
            'barang_nama'      => $request->barang_nama,
            'harga_jual'       => $request->harga_jual,
            'harga_beli'       => $request->harga_beli,
            'kategori_id'      => $request->kategori_id
        ]);

        return redirect('/barang')->with('success', 'Data Barang berhasil Disimpan');
    }

    // Detail
    public function show(string $id){
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Barang',
            'list' => ['Home','Barang','Detail']
        ];

        $page = (object) [
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show',['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang,'activeMenu' => $activeMenu]);
    }

    // Edit Data
    public function edit(string $id){
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit Barang',
            'list' => ['Home','Barang','Edit']
        ];
        $page = (object)[
            'title' => 'Edit Barang'
        ];
        $activeMenu = 'barang'; //set menu aktif

        return view('barang.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu, 'kategori' => $kategori]);
    }
    public function update(Request $request,string $id){
        $request->validate([
            'barang_kode'      => 'required|string|max:10',
            'barang_nama'      => 'required|string|max:100',
            'harga_beli'       => 'required|integer',
            'harga_jual'       => 'required|integer',
            'kategori_id'      => 'required|integer'
        ]);
        BarangModel::find($id)->update([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect('/barang')->with('success', 'Data Barang berhasil diubah');
    }
    // Delete Data
    public function destroy(string $id){
        $check = BarangModel::find($id);
            if(!$check){
                return redirect('/barang')->with('error','Data Barang tidak ditemukan');
            }

            try{
                BarangModel::destroy($id);

                return redirect('/barang')->with('success','Data Barang berhasil dihapus');
            }catch (\Illuminate\Database\QueryException $e){
                // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan
                return redirect('/barang')->with('error','Data barang gagal dihapus masuk terdapat tabel lainyang terkait dengan data ini');
            }
    }
}
