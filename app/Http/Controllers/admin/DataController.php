<?php

namespace App\Http\Controllers\admin;

use App\Models\Pasar;
use App\Models\Lokasi;
use App\Models\TempatWisata;
use App\Models\Artikel;
use App\Models\Sekolah;
use App\Models\RumahIbadah;
use App\Models\WisataDesa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Motto;
use App\Models\Pemerintahan;
use App\Models\Tentang;
use App\Models\Visimisi;

class DataController extends Controller
{
    public function dataLokasi()
    {
        $lokasi =  Lokasi::orderBy('created_at', 'DESC');
        return datatables()->of($lokasi)
            ->addColumn('action', function ($lokasi) {
                return view('admin.lokasi.action', compact('lokasi'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
    public function dataPasar()
    {
        $pasar = Pasar::orderBy('created_at', 'DESC');
        return datatables()->of($pasar)
            ->addColumn('action', function ($pasar) {
                return view('admin.potensi.pasar.action', compact('pasar'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function dataWisataDesa()
    {
        $wisata_desa = WisataDesa::orderBy('created_at', 'DESC');
        return datatables()->of($wisata_desa)
            ->addColumn('action', function ($wisata_desa) {
                return view('admin.potensi.wisata-desa.action', compact('wisata_desa'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function dataRumahIbadah()
    {
        $rumah_ibadah = RumahIbadah::orderBy('created_at', 'DESC');
        return datatables()->of($rumah_ibadah)
            ->addColumn('action', function ($rumah_ibadah) {
                return view('admin.potensi.rumah-ibadah.action', compact('rumah_ibadah'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function dataAlbum()
    {
        $albumdesa = Album::orderBy('created_at', 'DESC');
        return datatables()->of($albumdesa)
            ->addColumn('action', function ($albumdesa) {
                return view('admin.albumdesa.action', compact('albumdesa'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function dataVisimisiDesa()
    {
        $visimisi = Visimisi::orderBy('created_at', 'DESC');
        return datatables()->of($visimisi)
            ->addColumn('action', function ($visimisi) {
                return view('admin.visimisi.action', compact('visimisi'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function dataMottoDesa()
    {
        $mottodesa = Motto::orderBy('created_at', 'DESC');
        return datatables()->of($mottodesa)
            ->addColumn('action', function ($mottodesa) {
                return view('admin.mottodesa.action', compact('mottodesa'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }


    public function dataPemerintahan()
    {
        $pemerintahan = Pemerintahan::orderBy('created_at', 'DESC');
        return datatables()->of($pemerintahan)
            ->addColumn('action', function ($pemerintahan) {
                return view('admin.pemerintahan.action', compact('pemerintahan'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }

    public function dataTentangDesa()
    {
        $tentangdesa = Tentang::orderBy('created_at', 'DESC');
        return datatables()->of($tentangdesa)
            ->addColumn('action', function ($tentangdesa) {
                return view('admin.tentang.action', compact('tentangdesa'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }




    public function dataSekolah()
    {
        $sekolah = Sekolah::orderBy('created_at', 'DESC');
        return datatables()->of($sekolah)
            ->addColumn('action', function ($sekolah) {
                return view('admin.potensi.sekolah.action', compact('sekolah'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
}
