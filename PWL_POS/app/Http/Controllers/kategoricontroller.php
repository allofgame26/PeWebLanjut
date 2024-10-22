<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\KategoriModel;
use Illuminate\support\Facades\Validator;

class kategoricontroller extends Controller
{
    // public function index(){
    //     $data = [
    //         'kategori_kode' => 'SNK',
    //         'kategori_nama' => 'Snack/Makanan Ringan',
    //         'created_at' => now()
    //     ];
    //     DB::table('m_kategori')->insert($data);
    //     return 'Insert Data baru berhasil';
    // }   
    // public function update(){
    //     $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->update(['kategori_nama' => 'Camilan']);
    //     return 'Update data berhasil. Jumlah data yang diupdate : '.$row.'baris';
    // }
    // public function delete(){
    //     $row = DB::table('m_kategori')->where('kategori_kode', 'SNK')->delete();
    //     return 'Delete data berhasil. Jumlah data yang didelete : '.$row.' baris';
    // }
    // public function view(){
    //     $data = DB::table('m_kategori')->get();
    //     return view('kategori', ['data' => $data]);
    // }
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'Kategori']
        ];
        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar dalam sistem'
        ];
        $activeMenu = 'kategori'; //set menu yang sedang aktif
        
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function list(){
        $kategori = KategoriModel::select('kategori_id','kategori_kode','kategori_nama'); 
    
 
        return DataTables::of($kategori) 
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($kategori) {  // menambahkan kolom aksi 
                // $btn  = '<a href="'.url('/kategori/' . $kategori->kategori_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                // $btn .= '<a href="'.url('/kategori/' . $kategori->kategori_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/kategori/'.$kategori->kategori_id).'">' 
                //         . csrf_field() . method_field('DELETE') .  
                //         '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                $btn  = '<button onclick="modalAction(\''.url('/kategori/'.$kategori->kategori_id.'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/kategori/'.$kategori->kategori_id.'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/kategori/'.$kategori->kategori_id.'/confirm_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    //create data
    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Kategori',
            'list' => ['Home','Kategori','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Data Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request){
        $request->validate([
            'kategori_kode'  => 'required|string|max:3|unique:m_kategori,kategori_kode',
            'kategori_nama'  => 'required|string|max:15'
        ]);

        KategoriModel::create([
            'kategori_kode'  => $request->kategori_kode,
            'kategori_nama'  => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil Disimpan');
    }

    // Detail
    public function show(string $id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Kategori',
            'list' => ['Home','Kategori','Detail']
        ];

        $page = (object) [
            'title' => 'Detail Kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show',['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori,'activeMenu' => $activeMenu]);
    }

    // Edit Data
    public function edit(string $id){
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Edit Kategori',
            'list' => ['Home','Kategori','Edit']
        ];
        $page = (object)[
            'title' => 'Edit Kategori'
        ];
        $activeMenu = 'kategori'; //set menu aktif

        return view('kategori.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategori' => $kategori]);
    }
    public function update(Request $request, string $id){
        $request->validate([
            'kategori_kode'  => 'required|string|max:3|unique:m_kategori,kategori_kode',
            'kategori_nama'  => 'required|string|max:15'
        ]);

        KategoriModel::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil diubah');
    }
    // Delete Data
    public function destroy(string $id){
        $check = KategoriModel::find($id);
        if(!$check){
            return redirect('/kategori')->with('error','Data kategori tidak ditemukan');
        }

        try{
            KategoriModel::destroy($id);

            return redirect('/kategori')->with('success','Data kategori berhasil dihapus');
        }catch (\Illuminate\Database\QueryException $e){
            // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan
            return redirect('/kategori')->with('error','Data kategori gagal dihapus masuk terdapat tabel lain yang terkait dengan data ini');
        }
    }
    // Create Ajax
    public function create_ajax(){
        $kategori = KategoriModel::select('kategori_id','kategori_nama')->get();

        return view('kategori.create_ajax')->with('kategori',$kategori);
       }

       public function store_ajax(Request $request){
          // pengecekan apakh request berupa ajax
          if($request->ajax() || $request->wantsJson()){
            $rules = [
                'kategori_kode' => 'required|string|min:3',
                'kategori_nama' => 'required|string|max:100',
            ];

            // use Illuminate\support\Facades\Validator
            $validator = Validator::make($request->all(),$rules);

            if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'masField' => $validator->errors()
                ]);
            }

            KategoriModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data kategori berhasil disimpan'
            ]);
          }
          redirect('/');
       }
      // Edit Ajax
      public function edit_ajax(string $id){
        $kategori = KategoriModel::find($id);

        return view('kategori.edit_ajax',['kategori'=> $kategori]);
      } 
      //Update Ajax
      public function update_ajax(Request $request,string $id){
         if($request->ajax() || $request->wantsJson()){
              $rules = [
                'kategori_kode'     => 'required|max:3', 
                'kategori_nama'     => 'required|max:100', 
              ];
            
              $validator = Validator::make($request->all(), $rules); 
 
        if ($validator->fails()) { 
            return response()->json([ 
                'status'   => false,    // respon json, true: berhasil, false: gagal 
                'message'  => 'Validasi gagal.', 
                'msgField' => $validator->errors()  // menunjukkan field mana yang error 
            ]); 
        } 
 
        $check = KategoriModel::find($id); 
             
            $check->update($request->all()); 
            return response()->json([ 
                'status'  => true, 
                'message' => 'Data berhasil diupdate' 
            ]); 
        } else{ 
            return response()->json([ 
                'status'  => false, 
                'message' => 'Data tidak ditemukan' 
            ]); 
        }
        return redirect('/'); 
    } 
    
    // delete ajax
    public function confirm_ajax(string $id){
        $kategori = KategoriModel::find($id);

        return view('kategori.delete_ajax',['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id){
        if($request->ajax()|| $request->wantsJson()){
            $kategori = KategoriModel::find($id);
            if($kategori){
                $kategori->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data Berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

}
