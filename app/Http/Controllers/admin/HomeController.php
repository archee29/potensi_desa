<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.home');
    }

    public function lokasi(){
        return view ('admin.lokasi');
    }

    public function artikel(){
        return view ('admin.artikel');
    }

    public function profile(){
        return view ('admin.profile');
    }

    public function pemerintahan(){
        return view ('admin.pemerintahan');
    }

    public function data(){
        return view ('admin.data');
    }

}
