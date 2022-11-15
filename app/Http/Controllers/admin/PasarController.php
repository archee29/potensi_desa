<?php

namespace App\Http\Controllers\admin;

use App\Models\Pasar;
use Illuminate\Support\Str;
use App\Models\Lokasi;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasarController extends Controller
{
    public function index(){
        return view('admin.potensi.pasar.index');
    }

    public function create(){
        $lokasi = Lokasi::get()->first();
        return view ('admin.potensi.pasar.create',[
            'lokasi'=> $lokasi,
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'author'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
            'location'=>'required'
        ]);
        $pasar = new Pasar();
        if($request ->hasFile('image')){
            $file=$request->file('image');
            $uploadFile=time().'_'.$file->getClientOriginalName();
            $file->move('images/poto-kalimas/pasar/',$uploadFile);
            $pasar->image=$uploadFile;
        }

        $pasar->author = $request->input('author');
        $pasar->jenis_potensi=Str::jenis_potensi($request->jenis_potensi);
        $pasar->location=$request->input('location');
        $pasar->content = $request->input('content');
        $pasar->save();
        if($pasar){
            return redirect()->route('pasar.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('pasar.index')->with('success','Data Gagal Disimpan');
        }
    }

    public function show(){
        return view ('admin.potensi.pasar.show');
    }

    public function edit(){
        $pasar = Pasar::findOrFail($pasar->id);
        return view ('admin.potensi.pasar.edit',[
            'pasar'=>$pasar
        ]);
    }

    public function update (Request $request, Pasar $pasar){
        $this->validate($request,[
            'author'=>'required',
            'keterangan'=>'required',
            'image'=>'image|mimes::png,jpg,jpeg',
            'location'=>'required'
        ]);
        $pasar =Pasar::findOrFail($pasar->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/pasar/".$pasar->image)){
               File::delete("images/poto-kalimas/pasar/".$pasar->image);
            }
            $file=$request->file("image");
            $uploadFile=time().'_'.$file->getClientOriginalName();
            $file->move('images/poto-kalimas/pasar/',$uploadFile);
            $pasar->image = $uploadFile;
        }
        $pasar->update([
            'author'=>$request->author,
            'location'=>$request->location,
            'keterangan'=>$request->content,
            'jenis_potensi'=>Str::jenis_potensi($request->jenis_potensi,'-'),
        ]);
        if($pasar){
            return redirect()->route('pasar.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('pasar.index')->with('error', 'Data Gagal Di Update');
        }

    }

    public function destroy($id){
        $pasar = Pasar::findOrFail($id);
        if(File::exixts("images/poto-kalimas/pasar/".$pasar->image)){
            File::delete("images/poto-kalimas/pasar/".$pasar->image);
        }
        $pasar->delete();
        return redirect()->route('pasar.index');
    }
}
