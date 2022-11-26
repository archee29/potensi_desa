<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\lokasi;
use App\Models\Sekolah;
use App\Models\RumahIbadah;
use App\Models\WisataDesa;
use App\Models\Pasar;
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
        $lokasi = Lokasi::get()->first();
        $pasar = Pasar::get();
        $sekolah = Sekolah::get();
        $wisata_desa = WisataDesa::get();
        $rumah_ibadah = RumahIbadah::get();
        return view('admin.dashboard.home',[
            'lokasi'=>$lokasi,
            'pasar' =>$pasar,
            'sekolah' => $sekolah,
            'wisata_desa' => $wisata_desa,
            'rumah_ibadah' => $rumah_ibadah,
        ]);
    }
    public function showPasar($id){
        // return view ('admin.artikel.show');
        $pasar = Pasar::findOrFail($id);
        return view('admin.potensi.pasar.show', [
          'pasar' => $pasar]);
    }

}
