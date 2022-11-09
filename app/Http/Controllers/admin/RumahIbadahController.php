<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RumahIbadahController extends Controller
{
    public function index(){
        return view('admin.potensi.rumah-ibadah.index');
    }

    public function create(){
        return view('admin.potensi.rumah-ibadah.create');
    }


    public function store(){

    }

    public function show(){
        return view ('admin.potensi.rumah-ibadah.show');
    }

    public function edit(){
        return view ('admin.potensi.rumah-ibadah.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
