<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function user($id,$nama){
        return view('User')
            ->with('nim','$id')
            ->with('nama','$nama');
    }

    public function penjualan(){
        return view('Penjualan');
    }

    public function home(){
        return view('Home');
    }
}
