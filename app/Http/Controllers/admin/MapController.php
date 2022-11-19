<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Pasar;
use App\Models\RumahIbadah;
use App\Models\Wisata;
use App\Models\Sekolah;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::get();
        return view('user.peta',[
            'pasar' =>$pasar,
            'lokasi'=>$lokasi
        ]);
    }
    public function show($slug){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::where('slug', $slug)->first();
        return view('user.potensi.detailPasar',[
            'lokasi'=>$lokasi,
            'pasar'=>$pasar
        ]);
    }
}
