<?php

namespace App\Http\Controllers\admin;
use Illuminate\Http\Request;
use App\Models\Pasar;
use App\Models\Lokasi;
use App\Models\Sekolah;
use App\Models\RumahIbadah;
use App\Models\TempatWisata;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
 public function dataLokasi (){
    $lokasi =  Lokasi::orderBy('created_at', 'DESC');
    return datatables ()->of($lokasi)
    ->addColumn('action','lokasi.action')
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }
 public function dataPasar(){
     $pasar = Pasar::orderBy('created_at','DESC');
     return datatables()->of($pasar)
     ->addColumn('action','pasar.action')
     ->addIndexColumn()
     ->rawColumns(['action'])
     ->toJson();
 }

 public function dataWisata(){
    $wisata = TempatWisata::orderBy('created_at','DESC');
    return datatables()->of($wisata)
    ->addColumn('action','wisata.action')
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }

 public function dataRumahIbadah(){
    $rumah_ibadah =RumahIbadah::orderBy('created_at','DESC');
    return datatables()->of($rumah_ibadah)
    ->addColumn('action','rumah_ibadah.action')
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }

 public function dataSekolah(){
    $sekolah =Sekolah::orderBy('created_at','DESC');
    return datatables()->of($sekolah)
    ->addColumn('action','sekolah.action')
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }

}
