<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangModel;
use App\Models\DetailModel;
use App\Models\PenjualanModel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class detailcontroller extends Controller
{
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Detail Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar Detail Penjualan yang terdaftar dalam sistem'
        ];
        $penjualan = PenjualanModel::all();
        $detail = DetailModel::all();
        $barang = BarangModel::all();
        return view('penjualan.detail', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'penjualan' => $penjualan,
            'detail' => $detail,
            'barang' => $barang,
            'page'=> $page
        ]);
    }

    public function list(Request $request)
    {
        $detail = DetailModel::select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah')
            ->with('barang')
            ->with('penjualan');

        if ($request->barang_id) {
            $detail->where('barang_id', $request->barang_id);
        }

        return DataTables::of($detail)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addColumn('aksi', function ($detail) { // menambahkan kolom aksi 
                $btn = '<a href="' . url('/detail/' . $detail->detail_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<a onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<button onclick="modalAction(\'' . url('/detail/' . $detail->detail_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    public function show(string $id)
    {
        $detail = DetailModel::with('barang')->find($id);
        $breadcrumb = (object) ['title' => 'Detail detail', 'list' => ['Home', 'detail', 'Detail']];
        $page = (object) ['title' => 'Detail detail'];
        $activeMenu = 'detail'; // set menu yang sedang aktif
        return view('detail.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        return view('detail.create_ajax')
            ->with('barang', $barang)
            ->with('penjualan', $penjualan);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id'  => 'required|integer',
                'barang_id'     => 'required|integer',
                'harga'         => 'required|string|min:3',
                'jumlah'        => 'required|string|min:1'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            DetailModel::create($request->all());
            return response()->json([
                'status'    => true,
                'message'   => 'Data barang berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $detail = DetailModel::find($id);
        $barang = BarangModel::select('barang_id', 'barang_nama')->get();
        $penjualan = PenjualanModel::select('penjualan_id', 'penjualan_kode')->get();
        return view('detail.edit_ajax', ['detail' => $detail, 'barang' => $barang, 'penjualan' => $penjualan]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id'  => 'required|integer',
                'barang_id'     => 'required|integer',
                'harga'         => 'required|string|min:3',
                'jumlah'        => 'required|string|min:1'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = DetailModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
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

    public function confirm_ajax(string $id)
    {
        $detail = DetailModel::find($id);
        return view('detail.confirm_ajax', ['detail' => $detail]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $detail = DetailModel::find($id);
            if ($detail) {
                $detail->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
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
