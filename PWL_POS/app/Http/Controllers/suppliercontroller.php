<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\suppliermodel;

class suppliercontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar supplier',
            'list' => ['Home', 'supplier']
        ];
        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];
        $activeMenu = 'supplier'; //set menu yang sedang aktif
        
        return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(){
        $supplier = suppliermodel::select('supplier_id','supplier_kode','supplier_nama','supplier_alamat'); 
    
 
        return DataTables::of($supplier) 
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($supplier) {  // menambahkan kolom aksi 
                $btn  = '<a href="'.url('/supplier/' . $supplier->supplier_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/supplier/' . $supplier->supplier_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/supplier/'.$supplier->supplier_id).'">' 
                        . csrf_field() . method_field('DELETE') .  
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    //create data
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah supplier',
            'list' => ['Home','supplier','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Data supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'supplier_kode'  => 'required|string|max:10|unique:m_supplier,supplier_kode',
            'supplier_nama'  => 'required|string|max:35',
            'supplier_alamat' => 'required|string|max:50'
        ]);

        suppliermodel::create([
            'supplier_kode'  => $request->supplier_kode,
            'supplier_nama'  => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil Disimpan');
    }

    // Detail
    public function show(string $id){
        $supplier = suppliermodel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Supplier',
            'list' => ['Home','Supplier','Detail']
        ];

        $page = (object) [
            'title' => 'Detail Supplier'
        ];

        $activeMenu = 'supplier';

        return view('supplier.show',['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier,'activeMenu' => $activeMenu]);
    }

    // Edit Data
    public function edit(string $id){
        $supplier = suppliermodel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Supplier',
            'list' => ['Home','Supplier','Edit']
        ];
        $page = (object)[
            'title' => 'Edit Supplier'
        ];
        $activeMenu = 'supplier'; //set menu aktif

        return view('supplier.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'supplier' => $supplier]);
    }
    public function update(Request $request,string $id){
        $request->validate([
            'supplier_kode'  => 'required|string|max:10',
            'supplier_nama'  => 'required|string|max:35',
            'supplier_alamat' => 'required|string|max:50'
        ]);

        suppliermodel::find($id)->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);

        return redirect('/supplier')->with('success', 'Data supplier berhasil diubah');
    }
    // Delete Data
    public function destroy(Request $request,string $id){
        $check = suppliermodel::find($id);
        if(!$check){
            return redirect('/supplier')->with('error','Data supplier tidak ditemukan');
        }

        try{
            suppliermodel::destroy($id);

            return redirect('/supplier')->with('success','Data supplier berhasil dihapus');
        }catch (\Illuminate\Database\QueryException $e){
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan
            return redirect('/supplier')->with('error','Data supplier gagal dihapus masuk terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
