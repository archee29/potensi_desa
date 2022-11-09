<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(){
        return view('admin.profile.index');
    }

    public function create(){
        return view('admin.profile.create');
    }

    public function store(){

    }

    public function show(){
        return view ('admin.profile.show');
    }

    public function edit(){
        return view ('admin.profile.edit');
    }

    public function update (){

    }

    public function destroy(){

    }
}
