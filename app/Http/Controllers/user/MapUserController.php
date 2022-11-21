<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Models\Pasar;
use App\Models\RumahIbadah;
use App\Models\TempatWisata;
use App\Models\Sekolah;

use Illuminate\Http\Request;

class MapUserController extends Controller
{
    public function index(){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::get();
        $sekolah = Sekolah::get();
        $tempat_wisata = TempatWisata::get();
        $rumah_ibadah = RumahIbadah::get();
        return view('user.peta',[
            'lokasi'=>$lokasi,
            'pasar' =>$pasar,
            'sekolah' => $sekolah,
            'tempat_wisata' => $tempat_wisata,
            'rumah_ibadah' => $rumah_ibadah,
        ]);
    }

    public function showPasar($slug){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::where('slug', $slug)->first();
        return view('user.potensi.detailPasar',[
            'lokasi'=>$lokasi,
            'pasar'=>$pasar
        ]);
    }

    public function showSekolah($slug){
        $lokasi = Lokasi::get()->first();
        $sekolah = Sekolah::where('slug', $slug)->first();
        return view('user.potensi.detailSekolah',[
            'lokasi'=>$lokasi,
            'sekolah'=>$sekolah
        ]);
    }

    public function showRumahIbadah($slug){
        $lokasi = Lokasi::get()->first();
        $rumah_ibadah = RumahIbadah::where('slug', $slug)->first();
        return view('user.potensi.detailRumahIbadah',[
            'lokasi'=>$lokasi,
            'rumah_ibadah'=>$rumah_ibadah
        ]);
    }

    public function showWisata($slug){
        $lokasi = Lokasi::get()->first();
        $tempat_wisata = TempatWisata::where('slug', $slug)->first();
        return view('user.potensi.detailWisata',[
            'lokasi'=>$lokasi,
            'tempat_wisata'=>$tempat_wisata
        ]);
    }

}
