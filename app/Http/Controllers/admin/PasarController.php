<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasar;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PasarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.potensi.pasar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lokasi = Lokasi::get()->first();
        return view('admin.potensi.pasar.create',[
            'lokasi'=>$lokasi,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'judul'=>'required',
            'keterangan'=>'required',
            'location'=>'required',
            'image'=>'image|mime:png,jpg,jpeg',
        ]);
        $pasar = new Pasar();
        if($request->hasfIlE('image')){
            $file = $request->file('image');
            $uploadFile = time().'_'.$file->getClientOriginalName();
            $file->move('images/poto-kalimas/pasar/',$uploadFile);
            $pasar->image = $uploadFile;
        }
        $pasar->author=$request->input('author');
        $pasar->dusun = $request->input('dusun');
        $pasar->nama_dusun= Str::nama_dusun($request->dusun,'-');
        $pasar->judul = $request->input('judul');
        $pasar->keterangan = $request->input('keterangan');
        $pasar->location = $request->input('location');
        $pasar->save();
        if($pasar){
            return redirect()->route('pasar.index')->with('success','Data Berhasil Ditambahkan');
        }else{
            return redirect()->route('pasar.index')->with('error','Data Gagal Ditambakan');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pasar $pasar)
    {
        $pasar = Pasar::findOrFail($pasar->id);
        return view('admin.potensi.pasar.edit',[
            'pasar'=>$pasar
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pasar $pasar)
    {
        $this->validate($request,[
            'author'=>'required',
            'dusun'=>'required',
            'judul'=>'required',
            'keterangan'=>'required',
            'location'=>'required',
            'image'=>'image|mime:png,jpg,jpeg',
        ]);
        $pasar = Pasar::findOrFail($pasar->id);
        if($request->hasFile('image')){
            if(File::exists("images/poto-kalimas/pasar/".$pasar->image)){
                File::delete("images/poto-kalimas/pasar/".$pasar->image);
            }
            $file = $request->file("image");
            $uploadFile = time().'_'. $file->getClientOriginalName();
            $file->move('images/poto-kalimas/pasar/',$uploadFile);
            $pasar->image = $uploadFile;
        }
        $pasar->update([
            'author'=>$request->author,
            'dusun'=>$request->dusun,
            'nama_dusun'=>Str::nama_dusun($request->dusun,'-'),
            'judul'=>$request->judul,

            'keterangan'=>$request->keterangan,
            'location'=>$request->location,
        ]);
        if($pasar){
            return redirect()->route('pasar.index')->with('success','Data Berhasil Diupdate');
        }else{
            return redirect()->route('pasar.index')->with('error','Data Gagal Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pasar = Pasar::findOrFail($id);
        if(File::exists("images/poto-kalimas/pasar/" . $pasar->image)){
            File::delete("images/poto-kalimas/pasar/" . $pasar ->image);
        }
        $pasar->delete();
        return redirect()->route('pasar.index');

    }
}
