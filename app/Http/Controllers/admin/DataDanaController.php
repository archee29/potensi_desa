<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataDanaController extends Controller
{
    public function index()
    {
        return view('admin.datadana.index');
    }

    public function create()
    {
        return view('admin.datadana.create');
    }

    public function store()
    {
    }

    public function show()
    {
        return view('admin.datadana.show');
    }

    public function edit()
    {
        return view('admin.datadana.edit');
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
