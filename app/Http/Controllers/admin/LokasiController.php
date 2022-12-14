<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

// use App\Models\Category;
use App\Models\Lokasi;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(Request $request){
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
            'nama_desa'=>'required',
            // 'jenis_potensi'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
            'keterangan'=>'required',
        ]);

        $lokasi = new Lokasi();

        if($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile=time() .'_'. $file->getClientOriginalName();
            $file->move('images/Poto-Kalimas/desa/', $uploadFile);
            $lokasi->image = $uploadFile;
        };

        $lokasi->nama_desa =$request->input('nama_desa');
        // $lokasi->jenis_potensi =$request->input('jenis_potensi');
        $lokasi->location=$request->input('location');
        $lokasi->keterangan=$request->input('keterangan');
        $lokasi->save();

        if($lokasi){
            return redirect()->route('lokasi.index')->with('success','Data Berhasil Disimpan');
        } else{
            return redirect()->route('lokasi.index')->with('error','Data Gagal Disimpan');
        }
    }

    public function show($id){
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.lokasi.show',[
            'lokasi'=>$lokasi
        ]);
    }

    public function edit(Lokasi $lokasi){
        $lokasi = Lokasi::findOrFail($lokasi->id);
        return view('admin.lokasi.edit',[
            'lokasi'=>$lokasi
        ]);
        // return view('admin.lokasi.edit');
    }

    public function update (Request $request, Lokasi $lokasi){
        $this->validate($request,[
            'nama_desa'=>'required',
            // 'jenis_potensi'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required',
            'keterangan'=>'required',
        ]);
        $lokasi = Lokasi::findOrFail($lokasi->id);
        if($request->hasFile('image')){
            if(File::exists("images/Poto-Kalimas/desa/".$lokasi->image)){
                File::delete("images/Poto-Kalimas/desa/".$lokasi->image);
            }
            $file = $request->file("image");
            $uploadFile = time(). '_' . $file->getClientOriginalName();
            $file->move('images/Poto-Kalimas/desa/', $uploadFile);
            $lokasi->image=$uploadFile;

        }
        $lokasi->update([
            'nama_desa'=>$request->nama_desa,
            // 'jenis_potensi'=>$request->jenis_potensi,
            'location'=>$request->location,
            'keterangan'=>$request->keterangan,
        ]);

        if($lokasi){
            return redirect()->route('lokasi.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('lokasi.index')->with('errors','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $lokasi = Lokasi::findOrFail($id);
        if(File::exists("images/Poto-Kalimas/desa/".$lokasi->image)){
            File::delete("images/Poto-Kalimas/desa/". $lokasi->image);
        }
        $lokasi->delete();
        return redirect()->route('lokasi.index');
    }
}
