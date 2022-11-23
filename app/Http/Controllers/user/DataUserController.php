<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Pasar;
use App\Models\RumahIbadah;
use App\Models\TempatWisata;
use App\Models\WisataDesa;
use App\Models\Sekolah;

class DataUserController extends Controller
{
    public function index(){
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::get();
        $sekolah = Sekolah::get();
        $wisata_desa = WisataDesa::get();
        $rumah_ibadah = RumahIbadah::get();
        return view('user.welcome',[
            'lokasi'=>$lokasi,
            'pasar' =>$pasar,
            'sekolah' => $sekolah,
            'wisata_desa' => $wisata_desa,
            'rumah_ibadah' => $rumah_ibadah,
        ]);
    }

    public function detailDataSekolah (){
        $sekolah = Sekolah::orderBy('created_at','DESC');
        return datatables()->of($sekolah)
        ->addColumn('show', function($sekolah){
            return view('user.potensi.sekolah.show', compact('sekolah'))->render();
        })
        ->addIndexColumn()
        ->rawColumns(['show'])
        ->toJson();
    }

    public function detailDataPasar (){
        $pasar = Pasar::orderBy('created_at','DESC');
        return datatables()->of($pasar)
        ->addColumn('show', function($pasar){
            return view('user.potensi.pasar.show', compact('pasar'))->render();
        })
        ->addIndexColumn()
        ->rawColumns(['show'])
        ->toJson();
    }

    public function detailDataRumahIbadah (){
        $rumah_ibadah = RumahIbadah::orderBy('created_at','DESC');
        return datatables()->of($rumah_ibadah)
        ->addColumn('show', function($rumah_ibadah){
            return view('user.potensi.rumah-ibadah.show', compact('rumah-ibadah'))->render();
        })
        ->addIndexColumn()
        ->rawColumns(['show'])
        ->toJson();
    }

    public function detailDataWisataDesa (){
        $wisata_desa = WisataDesa::orderBy('created_at','DESC');
        return datatables()->of($wisata_desa)
        ->addColumn('show', function($wisata_desa){
            return view('user.potensi.wisata-desa.show', compact('wisata-desa'))->render();
        })
        ->addIndexColumn()
        ->rawColumns(['show'])
        ->toJson();
    }

}
