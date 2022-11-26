<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\RumahIbadah;
use App\Models\Lokasi;

class RumahIbadahController extends Controller
{
    public function index(){
        return view('admin.potensi.rumah-ibadah.index');
    }

    public function create(){
        $lokasi = Lokasi::get()->first();
        return view('admin.potensi.rumah-ibadah.create',[
            'lokasi'=>$lokasi,
        ]);
    }


    public function store(Request $request){
        $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_tempat_ibadah'=>'required',
            'agama'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $rumah_ibadah = new RumahIbadah();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile = time() .'_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/Rumah Ibadah/',$uploadFile);
            $rumah_ibadah->image = $uploadFile;
        }
        $rumah_ibadah->author = $request->input('author');
        $rumah_ibadah->dusun = $request->input('dusun');
        $rumah_ibadah->slug = Str::slug($request->dusun,'-');
        $rumah_ibadah->nama_tempat_ibadah = $request->input('nama_tempat_ibadah');
        $rumah_ibadah->agama = $request->input('agama');
        $rumah_ibadah->keterangan = $request->input('keterangan');
        $rumah_ibadah->location = $request->input('location');
        $rumah_ibadah->save();
        if($rumah_ibadah){
            return redirect()->route('rumah-ibadah.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('rumah-ibadah.index')->with('error','Data Gagal Ditambahkan');
        }
    }

    public function show($id){
        $rumah_ibadah = RumahIbadah::findOrFail($id);
        return view ('admin.potensi.rumah-ibadah.show',[
            'rumah_ibadah'=>$rumah_ibadah
        ]);
    }

    public function edit(RumahIbadah $rumah_ibadah){
        $rumah_ibadah = RumahIbadah::findOrFail($rumah_ibadah->id);
        return view ('admin.potensi.rumah-ibadah.edit',[
            'rumah_ibadah'=>$rumah_ibadah
        ]);
    }

    public function update (Request $request, RumahIbadah $rumah_ibadah){
        $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_tempat_ibadah'=>'required',
            'agama'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $rumah_ibadah = RumahIbadah::findOrFail($rumah_ibadah->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/rumah ibadah/" . $rumah_ibadah->image)){
                File::delete("images/poto-kalimas/rumah ibadah/" . $rumah_ibadah->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/rumah ibadah/',$uploadFile);
            $rumah_ibadah->image = $uploadFile;
        }
        $rumah_ibadah->update([
           'author'=>$request->author,
            'dusun'=>$request->dusun,
            'slug'=>Str::slug($request->dusun,'-'),
            'nama_tempat_ibadah'=>$request->nama_tempat_ibadah,
            'agama'=>$request->agama,
            'keterangan'=>$request->keterangan,
            'location'=>$request->location,
        ]);
         if($rumah_ibadah){
            return redirect()->route('rumah-ibadah.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('rumah-ibadah.index')->with('error','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $rumah_ibadah = RumahIbadah::findOrFail($id);
        if(File::exists("images/poto-kalimas/rumah ibadah/" . $rumah_ibadah->image)){
            File::delete("images/poto-kalimas/rumah ibadah/" . $rumah_ibadah ->image);
        }
        $rumah_ibadah->delete();
        return redirect()->route('rumah-ibadah.index');
    }
}
