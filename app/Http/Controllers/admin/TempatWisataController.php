<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TempatWisataController extends Controller
{
    public function index(){
        return view('admin.potensi.wisata.index');
    }

    public function create(){
        return view ('admin.potensi.wisata.create');
    }

    public function store(){

    }

    public function show(){
        return view ('admin.potensi.wisata.show');
    }

    public function edit(){
        return viwe('admin.potensi.wisata.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
