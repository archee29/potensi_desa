<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\TempatWisata;
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
        $tempat_wisata = new TempatWisata();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile = time() .'_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/wisata/',$uploadFile);
            $tempat_wisata->image = $uploadFile;
        }
        $tempat_wisata->author = $request->input('author');
        $tempat_wisata->dusun = $request->input('dusun');
        $tempat_wisata->slug = Str::slug($request->dusun,'-');
        $tempat_wisata->nama_wisata = $request->input('nama_wisata');
        $tempat_wisata->keterangan = $request->input('keterangan');
        $tempat_wisata->location = $request->input('location');
        $tempat_wisata->save();
        if($tempat_wisata){
            return redirect()->route('wisata.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('wisata.index')->with('error','Data Gagal Ditambakan');
        }
    }

    public function show(){
        return view ('admin.potensi.wisata.show');
    }

    public function edit(TempatWisata $tempat_wisata){
        $tempat_wisata = TempatWisata::findOrFail($tempat_wisata->id);
        return view('admin.potensi.wisata.edit',[
            'tempat_wisata'=>$tempat_wisata
        ]);

    }

    public function update (Request $request, TempatWisata $tempat_wisata){
         $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_wisata'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $tempat_wisata = TempatWisata::findOrFail($tempat_wisata->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/wisata/" . $tempat_wisata->image)){
                File::delete("images/poto-kalimas/wisata/" . $tempat_wisata->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/wisata/',$uploadFile);
            $tempat_wisata->image = $uploadFile;
        }
        $tempat_wisata->update([
            'author'=>$request->author,
            'dusun'=>$request->dusun,
            'slug'=>Str::slug($request->dusun,'-'),
            'nama_wisata'=>$request->nama_wisata,
            'keterangan'=>$request->keterangan,
            'location'=>$request->location,
        ]);
         if($tempat_wisata){
            return redirect()->route('wisata.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('wisata.index')->with('error','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $tempat_wisata = Wisata::findOrFail($id);
        if(File::exists("images/poto-kalimas/wisata/" . $tempat_wisata->image)){
            File::delete("images/poto-kalimas/wisata/" . $tempat_wisata ->image);
        }
        $tempat_wisata->delete();
        return redirect()->route('wisata.index');
    }
}
