<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataDesaController extends Controller
{
    public function index(){
        return view('admin.data.index');
    }

    public function create(){
        return view('admin.data.create');
    }

    public function store(){

    }

    public function show(){
        return view ('admin.data.show');
    }

    public function edit(){
        return view ('admin.data.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
