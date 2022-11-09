<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(){
        return view('admin.lokasi.index');
    }

    public function create(){
        return view ('admin.lokasi.create');
    }

    public function store(){

    }

    public function show(){
        return view ('admin.lokasi.show');
    }

    public function edit(){
        return view ('admin.lokasi.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
