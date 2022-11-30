<?php

namespace App\Http\Controllers\admin;

use App\Models\RumahIbadah;
use Illuminate\Support\Str;
use App\Models\Pemerintahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Visimisi;
use Illuminate\Support\Facades\File;

class VisimisiController extends Controller
{


    public function index()
    {

        return view('admin.visimisi.index');
    }
    public function create()
    {
        return view('admin.visimisi.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'jabatan' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);
        $visimisi = new Visimisi();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/visimisi/', $uploadFile);
            $visimisi->image = $uploadFile;
        }
        $visimisi->name = $request->input('name');
        $visimisi->visi = $request->input('visi');
        $visimisi->misi = $request->input('misi');
        $visimisi->jabatan = $request->input('jabatan');
        $visimisi->save();
        if ($visimisi) {
            return redirect()->route('visimisi.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('visimisi.index')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    public function show($id)
    {
        return view('admin.visimisi.show', [
            'visimisi' => Visimisi::findOrFail($id)
        ]);
    }

    public function edit(Visimisi $visimisi)
    {
        $visimisi = Visimisi::findOrFail($visimisi->id);
        return view('admin.visimisi.edit', [
            'visimisi' => $visimisi
        ]);
    }

    public function update(Request $request, Visimisi $visimisi)
    {
        $this->validate($request, [
            'name' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'jabatan' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);
        $visimisi = Visimisi::findOrFail($visimisi->id);
        if ($request->hasFile('image')) {
            if (File::exists("images/poto-kalimas/visimisi/" . $visimisi->image)) {
                File::delete("images/poto-kalimas/visimisi/" . $visimisi->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/visimisi/', $uploadFile);
            $visimisi->image = $uploadFile;
        }
        $visimisi->update([
            'name' => $request->name,
            'visi' => $request->visi,
            'misi' => $request->misi,
            'jabatan' => $request->jabatan,
        ]);
        if ($visimisi) {
            return redirect()->route('visimisi.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->route('visimisi.index')->with('error', 'Data Gagal Diupdate');
        }
    }

    public function destroy($id)
    {
        $visimisi = Visimisi::findOrFail($id);
        if (File::exists("images/poto-kalimas/visimisi/" . $visimisi->image)) {
            File::delete("images/poto-kalimas/visimisi/" . $visimisi->image);
        }
        $visimisi->delete();
        return redirect()->route('visimisi.index');
    }
}
