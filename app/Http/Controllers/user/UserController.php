<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Pasar;
use App\Models\RumahIbadah;
use App\Models\Wisata;
use App\Models\Sekolah;

class UserController extends Controller
{
    public function index(){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::get();
        $sekolah = Sekolah::get();
        $wisata = Wisata::get();
        $rumah_ibadah = RumahIbadah::get();
        return view('user.detailPotensi',[
            'lokasi'=>$lokasi,
            'pasar' =>$pasar,
            'sekolah' => $sekolah,
            'wisata' => $wisata,
            'rumah_ibadah' => $rumah_ibadah,
        ]);
    }
}
