<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Pasar;
use App\Models\RumahIbadah;
use App\Models\TempatWisata;
use App\Models\Sekolah;

class DataUserController extends Controller
{
public function index(){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::get();
        $sekolah = Sekolah::get();
        $tempat_wisata = TempatWisata::get();
        $rumah_ibadah = RumahIbadah::get();
        return view('user.welcome',[
            'lokasi'=>$lokasi,
            'pasar' =>$pasar,
            'sekolah' => $sekolah,
            'tempat_wisata' => $tempat_wisata,
            'rumah_ibadah' => $rumah_ibadah,
        ]);
    }
}
