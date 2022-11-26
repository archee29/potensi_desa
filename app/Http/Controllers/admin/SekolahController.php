<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facade\Validator;

class SekolahController extends Controller
{
    public function index(){
        return view('admin.potensi.sekolah.index');
    }

    public function create(){
        $lokasi = Lokasi::get()->first();
        return view('admin.potensi.sekolah.create',[
            'lokasi'=>$lokasi,
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_sekolah'=>'required',
            'jenis_sekolah'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $sekolah = new Sekolah();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile = time() .'_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/sekolah/',$uploadFile);
            $sekolah->image = $uploadFile;
        }
        $sekolah->author = $request->input('author');
        $sekolah->dusun = $request->input('dusun');
        $sekolah->slug = Str::slug($request->dusun,'-');
        $sekolah->nama_sekolah = $request->input('nama_sekolah');
        $sekolah->jenis_sekolah = $request->input('jenis_sekolah');
        $sekolah->keterangan = $request->input('keterangan');
        $sekolah->location = $request->input('location');
        $sekolah->save();
        if($sekolah){
            return redirect()->route('sekolah.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('sekolah.index')->with('error','Data Gagal Ditambahkan');
        }
    }

    public function show($id){
        $sekolah = Sekolah::findOrFail($id);
        return view('admin.potensi.sekolah.show',[
            'sekolah'=>$sekolah
        ]);
    }

    public function edit(Sekolah $sekolah){
        $sekolah = Sekolah::findOrFail($sekolah->id);
        return view('admin.potensi.sekolah.edit',[
            'sekolah'=>$sekolah
        ]);
    }

    public function update (Request $request, Sekolah $sekolah){
         $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'nama_sekolah'=>'required',
            'jenis_sekolah'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
        ]);
        $sekolah = Sekolah::findOrFail($sekolah->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/sekolah/" . $sekolah->image)){
                File::delete("images/poto-kalimas/sekolah/" . $sekolah->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/sekolah/',$uploadFile);
            $sekolah->image = $uploadFile;
        }
        $sekolah->update([
            'author'=>$request->author,
            'dusun'=>$request->dusun,
            'slug'=>Str::slug($request->dusun,'-'),
            'nama_sekolah'=>$request->nama_sekolah,
            'jenis_sekolah'=>$request->jenis_sekolah,
            'keterangan'=>$request->keterangan,
            'location'=>$request->location,
        ]);
         if($sekolah){
            return redirect()->route('sekolah.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('sekolah.index')->with('error','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $sekolah = Sekolah::findOrFail($id);
        if(File::exists("images/poto-kalimas/sekolah/" . $sekolah->image)){
            File::delete("images/poto-kalimas/sekolah/" . $sekolah ->image);
        }
        $sekolah->delete();
        return redirect()->route('sekolah.index');
    }
}
