<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index(){
        return view('admin.potensi.sekolah.index');
    }

    public function create(){
        return view('admin.potensi.sekolah.create');
    }

    public function store(){

    }

    public function show(){
        return view('admin.potensi.sekolah.show');
    }

    public function edit(){
        return view('admin.potensi.sekolah.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
