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
    ->addColumn('action',function($lokasi){
        return view('admin.lokasi.action',compact('lokasi'))->render();
    })
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }
 public function dataPasar(){
     $pasar = Pasar::orderBy('created_at','DESC');
     return datatables()->of($pasar)
     ->addColumn('action',function($pasar){
      return view('admin.potensi.pasar.action',compact('pasar'))->render();
     })
     ->addIndexColumn()
     ->rawColumns(['action'])
     ->toJson();
 }

 public function dataWisata(){
    $wisata = TempatWisata::orderBy('created_at','DESC');
    return datatables()->of($wisata)
    ->addColumn('action', function ($wisata){
        return view('admin.potensi.wisata.action',compact('wisata'))->render();
    })
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }

 public function dataRumahIbadah(){
    $rumah_ibadah =RumahIbadah::orderBy('created_at','DESC');
    return datatables()->of($rumah_ibadah)
    ->addColumn('action', function ($rumah_ibadah){
        return view('admin.potensi.rumah-ibadah.action',compact('rumah_ibadah'))->render();
    })
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }

 public function dataSekolah(){
    $sekolah =Sekolah::orderBy('created_at','DESC');
    return datatables()->of($sekolah)
    ->addColumn('action', function($sekolah){
        return view('admin.potensi.sekolah.action',compact('sekolah'))->render();
    })
    ->addIndexColumn()
    ->rawColumns(['action'])
    ->toJson();
 }

}
