<?php

namespace App\Http\Controllers\admin;

use id;
use App\Models\Admin;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


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
        // return view('admin.artikel.index');

        $artikel = DB::table('tb_artikel') -> get();
        // mengirim data blog ke view
        return view('admin.artikel.index', ['artikel' => $artikel]);
    }

    public function create(){
        return view ('admin.artikel.create');
    }

    public function store(){

    }

    public function show(){
        return view ('admin.artikel.show');
    }

    public function edit($id){
        // return view ('admin.artikel.edit');
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', [
          'artikel' => $artikel]);
    }

    public function update (){

    }

    public function destroy(){

    }
}
