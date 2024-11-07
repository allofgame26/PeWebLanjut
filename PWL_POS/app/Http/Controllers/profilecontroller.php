<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\usermodel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class profilecontroller extends Controller
{
    public function update_profile(Request $request)
    {
        $avatar = $request->file('avatar')->store('avatars');
        $request->user()->update([
            'avatar' => $avatar
        ]);

        return redirect()->back();
    }

    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Profil Saya',
            'list' => ['Home', 'Profil'],
        ];
    
        $page = (object)[
            'title' => 'Edit Profil Pengguna'
        ];
    
        $activeMenu = 'profile'; // Set menu yang aktif
    
        // Ambil data pengguna yang sedang login
        $user = Auth::user();
    
        // Pastikan user tidak null
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        // Ambil level_nama dari tabel m_level
        $level_nama = $user->level ? $user->level->level_nama : 'Tidak ada level'; // Menangani jika level tidak ada
        return view('profile.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user,
            'level_nama' => $level_nama // Kirim level_nama ke view
        ]);
    }
    
    public function update_info(Request $request)
    {
        $rules = [
            'username' => 'required|max:20|unique:m_user,username,' . $request->user()->user_id . ',user_id',
            'nama'     => 'required|max:100',
            'password' => 'nullable|min:6|confirmed',  // Password hanya wajib jika diisi, dan harus dikonfirmasi
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }
    
        $user = $request->user();  // Mendapatkan pengguna yang saat ini terautentikasi
    
        if ($user) {
            // Jika password diberikan, maka perbarui juga password
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);  // Hashing password baru
            }
    
            // Perbarui nama dan username
            $user->update([
                'username' => $request->username,
                'nama'     => $request->nama,
            ]);
    
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }
}
