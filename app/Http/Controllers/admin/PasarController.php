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
            'content'=>'required',
            'image'=>'required',
            'location'=>'required'
        ]);
        $pasar = new Pasar();
        if($request ->hasFile('image')){
            $file=$request->file('image');
            $uploadFile=time().'_'.$file->getClientOriginalName();
            $file->move('images/poto-kalimas/pasar',$uploadFile);
            $pasar->image=$uploadFile;
        }

        $pasar->author = $request->input('author');
        $pasar->jenis_potensi=Str::jenis_potensi($request->author);
        $pasar->titik=$request->input('titik');
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

    public function update (){

    }

    public function destroy($id){
        // $pasar = Pasar::findOrFail($id);
        // if(File::exixts(""))
    }
}
