<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class DataController extends Controller
{
 public function lokasi (){
    $lokasi =  Lokasi::orderBy('created_at', 'DESC');
    return datatables ()->of($lokasi)
    ->addColumn('action','lokasi.action')
    ->addIndeColumn()
    ->rawColumn(['action'])
    ->toJson();
 }
}
