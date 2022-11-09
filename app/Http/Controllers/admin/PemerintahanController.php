<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PemerintahanController extends Controller
{
    public function index(){
        return view('admin.pemerintahan.index');
    }
    public function create(){
        return view ('admin.pemerintahan.create');
    }
    public function store(){

    }

    public function show(){
        return view ('admin.pemerintahan.show');
    }

    public function edit(){
        return view ('admin.pemerintahan.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
