<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Str;
use App\Models\Pemerintahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\Models\RumahIbadah;

class PemerintahanController extends Controller
{
    public function index(){

        return view('admin.pemerintahan.index');
    }
    public function create(){
        return view('admin.pemerintahan.create');
    }
    public function store(Request $request){
        $this->validate($request,[
            'name'=>'required',
            'jabatan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
        ]);
        $pemerintahan = new Pemerintahan();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $uploadFile = time() .'_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/Pemerintahan/',$uploadFile);
            $pemerintahan->image = $uploadFile;
        }
        $pemerintahan->name = $request->input('name');
        $pemerintahan->jabatan = $request->input('jabatan');
        $pemerintahan->save();
        if($pemerintahan){
            return redirect()->route('pemerintahan.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('pemerintahan.index')->with('error','Data Gagal Ditambahkan');
        }

    }

    public function show($id){
        return view('admin.pemerintahan.show', [
            'pemerintahan' => Pemerintahan::findOrFail($id)
        ]);
    }

    public function edit(Pemerintahan $pemerintahan){
        $pemerintahan = Pemerintahan::findOrFail($pemerintahan->id);
        return view ('admin.pemerintahan.edit',[
            'pemerintahan'=>$pemerintahan
        ]);
    }

    public function update (Request $request, Pemerintahan $pemerintahan){
        $this->validate($request,[
            'name'=>'required',
            'jabatan'=>'required',
            'image'=>'image|mimes:png,jpg,jpeg',
        ]);
        $pemerintahan = Pemerintahan::findOrFail($pemerintahan->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/Pemerintahan/" . $pemerintahan->image)){
                File::delete("images/poto-kalimas/Pemerintahan/" . $pemerintahan->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/Pemerintahan/',$uploadFile);
            $pemerintahan->image = $uploadFile;
        }
        $pemerintahan->update([
           'name'=>$request->name,
            'jabatan'=>$request->jabatan,
        ]);
         if($pemerintahan){
            return redirect()->route('pemerintahan.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('pemerintahan.index')->with('error','Data Gagal Diupdate');
        }
    }

    public function destroy($id){
        $pemerintahan = Pemerintahan::findOrFail($id);
        if(File::exists("images/poto-kalimas/rumah ibadah/" . $pemerintahan->image)){
            File::delete("images/poto-kalimas/rumah ibadah/" . $pemerintahan ->image);
        }
        $pemerintahan->delete();
        return redirect()->route('pemerintahan.index');
    }
}
