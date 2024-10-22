<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\Models\usermodel;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\support\Facades\Validator;
use Monolog\Level;
use Yajra\DataTables\Facades\DataTables;

class usercontroller extends Controller
{
    // public function index(){

    //     //tambah data dengan Eluqoment Model
    //     $data = [
    //         'level_id' => 2,
    //         'username' => 'manager22',
    //         'nama' => 'Manager dua dua',
    //         'password' => hash::make('12345'),
    //     ];
    //     usermodel::insert($data);

    //     //Mencoba Akses model usermodel
    //     $user = usermodel::all();// ambil semua data dari tabel m_user
    //     return view('user',['data' => $user]);
    // }

    // public function update(){
    //     $data = [
    //         'nama' => 'Pelanggan Pertama'
    //     ];
    //     usermodel::where('username', 'customer1')->update($data); // update data user
    // }

    public function viewall(){
        $user = usermodel::with('level')->get(); // ambil semua data dari tabel m_user
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
    public function tambah(){

        return view('user_tambah');
    }
    public function tambah_simpan(Request $request){


        usermodel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make('$request->password'),
            'level_id' => $request->level_id
        ]);
        return redirect('/userviewall'); //redirect terhadap route
    }
    public function ubah($id){

        $user = usermodel::find($id);
        return view('user_ubah',['data' => $user]);
    }
    public function ubah_simpan($id,Request $request){

        $user = usermodel::find($id);

        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->password = Hash::make($request->password);
        $user->level_id = $request->level_id;

        $user->save();

        return redirect()->route('user');
    }
    public function hapus($id){
        $user = usermodel::find($id);
        $user->delete();

        return redirect()->route('user');
    }

    // AdminLTE
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar User',
            'list' => ['Home', ' User']
        ];
        $page = (object) [
            'title' => 'Daftar user yang terdaftar dalam sistem'
        ];
        $activeMenu = 'user'; //set menu yang sedang aktif

        // Get all levels for the filter
    $levels = LevelModel::select('level_id', 'level_nama')->get();
        
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu,'levels' => $levels]);
    }
    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request) 
    { 
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id') ->with('level'); 
    
    // Apply level filter if selected
    if ($request->has('level_id') && $request->level_id != '') {
        $users->where('level_id', $request->level_id);
    }
 
    return DataTables::of($users) 
        // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
        ->addIndexColumn()  
        ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi 
            // $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> '; 
            // $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
            // $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">' 
            //         . csrf_field() . method_field('DELETE') .  
            //         '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
            $btn  = '<button onclick="modalAction(\''.url('/user/'. $user->user_id .'/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .'/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
            $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id .'/confirm_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> ';
            return $btn; 
        }) 
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
        ->make(true); 
} 

    // Start Funnction Create User baru 

    public function create() {
        
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home','User','Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Data User'
        ];

        $level =LevelModel::all(); // ambil data level untuk ditampilkan di form
        $activeMenu = 'user';

        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
        
       public function store(Request $request){
        
        $request->validate([
            'username'  => 'required|string|min:3|unique:m_user,username',
            'nama'      => 'required|string|max:100',
            'password'  => 'required|min:5',
            'level_id'  => 'required|integer'
        ]);

        usermodel::create([
            'username'  => $request->username,
            'nama'      => $request->nama,
            'password'  => bcrypt($request->password), //password dienkripsi sebelum disimpan
            'level_id'  => $request->level_id
        ]);

        return redirect('/user')->with('success', 'Data User berhasil Disimpan');
       }  

       // END Funnction Create User baru

       // Start show detail user

       public function show(String $id){
        $user = usermodel::with('level')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail User',
            'list' => ['Home','User','Detail']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'user';

        return view('user.show',['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user,'activeMenu' => $activeMenu]);
       }
       // ENd Show detail user

       // Start Edit Profile
       public function edit(string $id){
            $user = usermodel::find($id);
            $level = LevelModel::all();

            $breadcrumb = (object)[
                'title' => 'Edit User',
                'list' => ['Home','User','Edit']
            ];
            $page = (object)[
                'title' => 'Edit User'
            ];
            $activeMenu = 'user'; //set menu aktif

            return view('user.edit',['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu, 'level' => $level]);
       }

       public function update(Request $request, string $id){
            $request->validate([
                'username' => 'required|string|min:3|unique:m_user,username,'.$id.',user_id',
                'nama' =>   'required|string|max:100',
                'password' => 'required|min:5',
                'level_id' => 'required|integer'
            ]);
            usermodel::find($id)->update([
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => $request->password ? bcrypt($request->password) : usermodel::find($id)->password,
                'level_id' => $request->level_id,
            ]);

            return redirect('/user')->with('success', 'Data user berhasil diubah');
       }
       //End Edit Profile

       //Start Hapus Data
       public function destroy(string $id){
            $check = usermodel::find($id);
            if(!$check){
                return redirect('/user')->with('error','Data user tidak ditemukan');
            }

            try{
                usermodel::destroy($id);

                return redirect('/user')->with('succes','Data user berhasil dihapus');
            }catch (\Illuminate\Database\QueryException $e){
                // jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan
                return redirect('/user')->with('error','Data user gagal dihapus masuk terdapat tabel lainyang terkait dengan data ini');
            }
       }

       // Create Ajax
       public function create_ajax(){
        $level = LevelModel::select('level_id','level_nama')->get();

        return view('user.create_ajax')->with('level',$level);
       }

       public function store_ajax(Request $request){
          // pengecekan apakh request berupa ajax
          if($request->ajax() || $request->wantsJson()){
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama' => 'required|string|max:100',
                'password' => 'required|min:6',
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

            usermodel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data User berhasil disimpan'
            ]);
          }
          redirect('/');
       }
      // Edit Ajax
      public function edit_ajax(string $id){
        $user = usermodel::find($id);
        $level = LevelModel::select('level_id','level_nama')->get();

        return view('user.edit_ajax',['user'=> $user, 'level' => $level]);
      } 
      //Update Ajax
      public function update_ajax(Request $request,string $id){
         if($request->ajax() || $request->wantsJson()){
              $rules = [
                'level_id' => 'required|integer', 
                'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id', 
                'nama'     => 'required|max:100', 
                'password' => 'nullable|min:6|max:20'
              ];
            
              $validator = Validator::make($request->all(), $rules); 
 
        if ($validator->fails()) { 
            return response()->json([ 
                'status'   => false,    // respon json, true: berhasil, false: gagal 
                'message'  => 'Validasi gagal.', 
                'msgField' => $validator->errors()  // menunjukkan field mana yang error 
            ]); 
        } 
 
        $check = UserModel::find($id); 
        if ($check) { 
            if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request 
                $request->request->remove('password'); 
            } 
             
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
    } 
    return redirect('/');
    }
    // delete ajax
    public function confirm_ajax(string $id){
        $user = usermodel::find($id);

        return view('user.delete_ajax',['user' => $user]);
    }

    public function delete_ajax(Request $request, $id){
        if($request->ajax()|| $request->wantsJson()){
            $user = usermodel::find($id);
            if($user){
                $user->delete();
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
    public function show_ajax($id){
        $user = usermodel::with('level')->find($id); // Assuming you have a relationship with 'level'

        if ($user) {
            return response()->json(['status' => true, 'data' => $user]);
        } else {
            return response()->json(['status' => false, 'message' => 'User  not found.']);
        }
    }
}

