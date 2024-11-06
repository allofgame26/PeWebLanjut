<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BarangModel;
use App\Models\KategoriModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\support\Facades\Validator;


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

        $kategoris = KategoriModel::all();
        
        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategoris' => $kategoris]);
    }
    public function list(Request $request){
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli','harga_jual','kategori_id')->with('kategori'); 
    
        // Apply category filter if selected
    if ($request->filled('kategori_id')) {
        $barang->where('kategori_id', $request->kategori_id);
    }
 
        return DataTables::of($barang) 
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()  
            ->addColumn('aksi', function ($barang) {  // menambahkan kolom aksi 
                // $btn  = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                // $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
                // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">' 
                //         . csrf_field() . method_field('DELETE') .  
                //         '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';      
            $btn  = '<button onclick="modalAction(\''.url('/barang/'.$barang->barang_id.'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/barang/'.$barang->barang_id.'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/barang/'.$barang->barang_id.'/confirm_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
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
    // Create Ajax
    public function create_ajax(){
        $kategori = KategoriModel::select('kategori_id','kategori_nama')->get();

        return view('barang.create_ajax')->with('kategori',$kategori);
       }

       public function store_ajax(Request $request){
          // pengecekan apakh request berupa ajax
          if($request->ajax() || $request->wantsJson()){
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3',
                'barang_nama' => 'required|string|max:100',
                'harga_beli' => 'required|integer',
                'harga_jual' => 'required|integer',
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

            BarangModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data User berhasil disimpan'
            ]);
            redirect('/');
          }
       }
      // Edit Ajax
      public function edit_ajax(string $id){
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id','kategori_nama')->get();

        return view('barang.edit_ajax',['barang'=> $barang, 'kategori' => $kategori]);
      } 
      //Update Ajax
      public function update_ajax(Request $request,string $id){
         if($request->ajax() || $request->wantsJson()){
              $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|max:10',
                'barang_nama' => 'required|string|max:100',
                'harga_beli' => 'required|integer',
                'harga_jual' => 'required|integer',
              ];
            
              $validator = Validator::make($request->all(), $rules); 
 
        if ($validator->fails()) { 
            return response()->json([ 
                'status'   => false,    // respon json, true: berhasil, false: gagal 
                'message'  => 'Validasi gagal.', 
                'msgField' => $validator->errors()  // menunjukkan field mana yang error 
            ]); 
        } 
 
        $check = BarangModel::find($id); 
             
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
        $barang = BarangModel::find($id);

        return view('barang.delete_ajax',['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id){
        if($request->ajax()|| $request->wantsJson()){
            $barang = BarangModel::find($id);
            if($barang){
                $barang->delete();
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
            return redirect('/');
        }
    }

    public function import(){
        return view('barang.import');
    }

    public function import_ajax(Request $request){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            $file = $request->file('file_barang'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel

            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'kategori_id' => $value['A'],
                            'barang_kode' => $value['B'],
                            'barang_nama' => $value['C'],
                            'harga_beli' => $value['D'],
                            'harga_jual' => $value['E'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    BarangModel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/barang'); 
    }
}
