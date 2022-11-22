<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Pasar;
use App\Models\RumahIbadah;
use App\Models\WisataDesa;
use App\Models\Sekolah;

class UserController extends Controller
{
    public function index(){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::get();
        $sekolah = Sekolah::get();
        $wisata_desa = WisataDesa::get();
        $rumah_ibadah = RumahIbadah::get();
        return view('user.detailPotensi',[
            'lokasi'=>$lokasi,
            'pasar' =>$pasar,
            'sekolah' => $sekolah,
            'wisata_desa' => $wisata_desa,
            'rumah_ibadah' => $rumah_ibadah,
        ]);
    }
}
