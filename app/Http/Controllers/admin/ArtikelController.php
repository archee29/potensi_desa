<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Artikel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ArtikelController extends Controller
{
    public function index(){
        // if (!$request->session()->has('admin')){
        //     return redirect('/login')->with('expired', 'Session Telah Berakhir');
        // }
        // else{
        //     $user = $request ->session()-> get('admin.data');
        //     $profiledata = Admin::where('username', '=', $user["username"])->first();
        //     $artikel = Artikel::get();
        //     return view('admin.artikel.index');
        // }
        return view('admin.artikel.index');
    }

    public function create(){
        return view ('admin.artikel.create');
    }

    public function store(){

    }

    public function show(){
        return view ('admin.artikel.show');
    }

    public function edit(){
        return view ('admin.artikel.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
