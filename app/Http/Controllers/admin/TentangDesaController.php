<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pemerintahan;
use App\Models\Tentang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TentangDesaController extends Controller
{


    public function index_fr()
    {

        $posts = Tentang::latest();
        $tentangdesa = $posts->get();
        return view('user.welcome', [
            'tentangdesa' => $tentangdesa,
        ]);
    }

    public function index()
    {
        return view('admin.tentang.index');
    }

    public function create()
    {
        return view('admin.tentang.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'isi' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);
        $tentangdesa = new Tentang();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/Tentang/', $uploadFile);
            $tentangdesa->image = $uploadFile;
        }
        $tentangdesa->isi = $request->input('isi');
        $tentangdesa->save();
        if ($tentangdesa) {
            return redirect()->route('tentangdesa.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('tentangdesa.index')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    public function show($id)
    {
        return view('admin.tentang.show', [
            'tentangdesa' => Tentang::findOrFail($id)
        ]);
    }

    public function edit(Tentang $tentangdesa)
    {
        $tentangdesa = Tentang::findOrFail($tentangdesa->id);
        return view('admin.tentang.edit', [
            'tentangdesa' => $tentangdesa
        ]);
    }


    public function update(Request $request, Tentang $tentangdesa)
    {
        $this->validate($request, [
            'isi' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);
        $tentangdesa = Tentang::findOrFail($tentangdesa->id);
        if ($request->hasFile('image')) {
            if (File::exists("images/poto-kalimas/Tentang/" . $tentangdesa->image)) {
                File::delete("images/poto-kalimas/Tentang/" . $tentangdesa->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/Tentang/', $uploadFile);
            $tentangdesa->image = $uploadFile;
        }
        $tentangdesa->update([
            'isi' => $request->isi,
        ]);
        if ($tentangdesa) {
            return redirect()->route('tentangdesa.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->route('tentangdesa.index')->with('error', 'Data Gagal Diupdate');
        }
    }

    public function destroy($id)
    {
        $tentangdesa = Tentang::findOrFail($id);
        if (File::exists("images/poto-kalimas/Tentang/" . $tentangdesa->image)) {
            File::delete("images/poto-kalimas/Tentang/" . $tentangdesa->image);
        }
        $tentangdesa->delete();
        return redirect()->route('tentangdesa.index');
    }
}
