<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasarController extends Controller
{
    public function index(){
        return view('admin.potensi.pasar.index');
    }

    public function create(){
        return view ('admin.potensi.pasar.create');
    }

    public function store(){

    }

    public function show(){
        return view ('admin.potensi.pasar.show');
    }

    public function edit(){
        return view ('admin.potensi.pasar.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
