<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(){
        return view('admin.lokasi.index');
    }

    public function create(){
        $lokasi= Lokasi::get()->first();
        return view ('admin.lokasi.create',[
            'lokasi'=>$lokasi,
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'desa'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'keterangan'=>'required',
            'titik'=>'required'
        ]);

        $lokasi=new Lokasi();
        if($request->hasFile('image')){
            $file = $reques->file('image');
            $uploadFile=time() .'_'. $file->getClientOriginalName();
            $file->move('images/Poto-Kalimas', $uploadFile);
            $lokasi->image = $uploadFile;
        }
        $lokasi->desa =$request->input('desa');
        $lokasi->jenis_potensi = Str::jenispotensi($request->name,'_');
        $lokasi->titik=$request->input('titik');
        $lokasi->keterangan=$request->input('keterangan');
        $lokasi->save();

        if($lokasi){
            return redirect()->route('admin.lokasi.index')->with('success','Data Berhasil Disimpan');
        } else{
            return redirect()->route('admin.lokasi.index')->with('error','Data Gagal Disimpan');
        }
    }

    public function show(){
        return view ('admin.lokasi.show');
    }

    public function edit(Lokasi $lokasi){
        // $lokasi = Lokasi::findOrFail($lokasi->id);
        // return view ('admin.lokasi.edit',[
        //     'lokasi'=>$lokasi
        // ]);
        return view('admin.lokasi.edit');
    }

    public function update (Request $request, Lokasi $lokasi){
        $this->validate($request,[
            'desa'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'keterangan'=>'required',
            'titik'=>'required'
        ]);
        $lokasi = Lokasi::findOrFail($space->id);
        if($request->hasFile('image')){
            if(File::exists("images/Poto-Kalimas".$lokasi->image)){
                File::delete("images/Poto-Kalimas".$lokasi->image);
            }
            $lokasi= $request->file("image");
            $uploadFile = time(). '_' . $file->getClientOriginalName();
            $file->move('images/Poto-Kalimas', $uploadFile);
            $lokasi->image=$uploadFile;

        }
        $lokasi->update([
            'desa'=>$request->desa,
            'titik'=>$request->titik,
            'keterangan'=>$request->keterangan,
            'jenis_potensi'=>Str::jenis_potensi($request->name,'_'),
        ]);
        if($lokasi){
            return redirect()->route('admin.lokasi.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('admin.lokasi.index')->with('errors','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $lokasi = Space::findOrFail($id);
        if(File::exists("images/Poto-Kalimas".$lokasi->image)){
            File::delete("images/Poto-Kalimas". $lokasi->image);
        }
        $lokasi->delete();
        return redirect()->route('admin.lokasi.index');
    }
}
