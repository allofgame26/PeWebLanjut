<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use App\Models\usermodel;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\Hash;
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
        
        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    // Ambil data user dalam bentuk json untuk datatables 
    public function list(Request $request) 
    { 
    $users = UserModel::select('user_id', 'username', 'nama', 'level_id') ->with('level'); 
    
 
    return DataTables::of($users) 
        // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
        ->addIndexColumn()  
        ->addColumn('aksi', function ($user) {  // menambahkan kolom aksi 
            $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> '; 
            $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user->user_id).'">' 
                    . csrf_field() . method_field('DELETE') .  
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';      
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
}
