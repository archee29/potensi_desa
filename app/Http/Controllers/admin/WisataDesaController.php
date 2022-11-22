<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\WisataDesa;
use App\Models\Lokasi;

class WisataDesaController extends Controller
{
     public function index(){
        return view('admin.potensi.wisata-desa.index');
    }

    public function create(){
        $lokasi = Lokasi::get()->first();
        return view ('admin.potensi.wisata-desa.create',[
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
        $wisata_desa = new WisataDesa();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile = time() .'_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/wisata-desa/',$uploadFile);
            $wisata_desa->image = $uploadFile;
        }
        $wisata_desa->author = $request->input('author');
        $wisata_desa->dusun = $request->input('dusun');
        $wisata_desa->slug = Str::slug($request->dusun,'-');
        $wisata_desa->nama_wisata = $request->input('nama_wisata');
        $wisata_desa->keterangan = $request->input('keterangan');
        $wisata_desa->location = $request->input('location');
        $wisata_desa->save();
        if($wisata_desa){
            return redirect()->route('wisata-desa.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('wisata-desa.index')->with('error','Data Gagal Ditambakan');
        }
    }

    public function show(){
        return view ('admin.potensi.wisata-desa.show');
    }

    public function edit(WisataDesa $wisata_desa){
        $wisata_desa = WisataDesa::findOrFail($wisata_desa->id);
        return view('admin.potensi.wisata-desa.edit',[
            'wisata_desa'=>$wisata_desa
        ]);

    }

    public function update (Request $request, WisataDesa $wisata_desa){
         $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_wisata'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $wisata_desa = WisataDesa::findOrFail($wisata_desa->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/wisata-desa/" . $wisata_desa->image)){
                File::delete("images/poto-kalimas/wisata-desa/" . $wisata_desa->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/wisata-desa/',$uploadFile);
            $wisata_desa->image = $uploadFile;
        }
        $wisata_desa->update([
            'author'=>$request->author,
            'dusun'=>$request->dusun,
            'slug'=>Str::slug($request->dusun,'-'),
            'nama_wisata'=>$request->nama_wisata,
            'keterangan'=>$request->keterangan,
            'location'=>$request->location,
        ]);
         if($wisata_desa){
            return redirect()->route('wisata-desa.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('wisata-desa.index')->with('error','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $wisata_desa = WisataDesa::findOrFail($id);
        if(File::exists("images/poto-kalimas/wisata-desa/" . $wisata_desa->image)){
            File::delete("images/poto-kalimas/wisata-desa/" . $wisata_desa ->image);
        }
        $wisata_desa->delete();
        return redirect()->route('wisata-desa.index');
    }
}
