<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Wisata;
use App\Models\Lokasi;

class TempatWisataController extends Controller
{
    public function index(){
        return view('admin.potensi.wisata.index');
    }

    public function create(){
        $lokasi = Lokasi::get()->first();
        return view ('admin.potensi.wisata.create',[
            'lokasi'=>$lokasi,
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_wisata'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $wisata = new Wisata();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile = time() .'_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/wisata/',$uploadFile);
            $wisata->image = $uploadFile;
        }
        $wisata->author = $request->input('author');
        $wisata->dusun = $request->input('dusun');
        $wisata->slug = Str::slug($request->dusun,'-');
        $wisata->nama_wisata = $request->input('nama_wisata');
        $wisata->keterangan = $request->input('keterangan');
        $wisata->location = $request->input('location');
        $wisata->save();
        if($wisata){
            return redirect()->route('wisata.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('wisata.index')->with('error','Data Gagal Ditambakan');
        }
    }

    public function show($id){
        return view ('admin.potensi.wisata.show');
    }

    public function edit(Wisata $wisata){
        $wisata = Wisata::findOrFail($wisata->id);
        return view('admin.potensi.wisata.edit',[
            'wisata'=>$wisata
        ]);

    }

    public function update (Request $request, Wisata $wisata){
         $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_wisata'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $wisata = Wisata::findOrFail($wisata->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/wisata/" . $wisata->image)){
                File::delete("images/poto-kalimas/wisata/" . $wisata->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/wisata/',$uploadFile);
            $wisata->image = $uploadFile;
        }
        $wisata->update([
            'author'=>$request->author,
            'dusun'=>$request->dusun,
            'slug'=>Str::slug($request->dusun,'-'),
            'nama_wisata'=>$request->nama_wisata,
            'keterangan'=>$request->keterangan,
            'location'=>$request->location,
        ]);
         if($wisata){
            return redirect()->route('wisata.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('wisata.index')->with('error','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $wisata = Wisata::findOrFail($id);
        if(File::exists("images/poto-kalimas/wisata/" . $wisata->image)){
            File::delete("images/poto-kalimas/wisata/" . $wisata ->image);
        }
        $wisata->delete();
        return redirect()->route('wisata.index');
    }
}
