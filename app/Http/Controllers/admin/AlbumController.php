<?php

namespace App\Http\Controllers\admin;

use App\Models\RumahIbadah;
use Illuminate\Support\Str;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AlbumController extends Controller
{


    public function index()
    {

        return view('admin.albumdesa.index');
    }
    public function create()
    {
        return view('admin.albumdesa.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);
        $albumdesa = new Album();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/Album/', $uploadFile);
            $albumdesa->image = $uploadFile;
        }
        $albumdesa->title = $request->input('title');
        $albumdesa->save();
        if ($albumdesa) {
            return redirect()->route('albumdesa.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('albumdesa.index')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    public function show($id)
    {
        return view('admin.albumdesa.show', [
            'albumdesa' => album::findOrFail($id)
        ]);
    }

    public function edit(album $albumdesa)
    {
        $albumdesa = album::findOrFail($albumdesa->id);
        return view('admin.albumdesa.edit', [
            'albumdesa' => $albumdesa
        ]);
    }

    public function update(Request $request, album $albumdesa)
    {
        $this->validate($request, [
            'title' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);
        $albumdesa = album::findOrFail($albumdesa->id);
        if ($request->hasFile('image')) {
            if (File::exists("images/poto-kalimas/Album/" . $albumdesa->image)) {
                File::delete("images/poto-kalimas/Album/" . $albumdesa->image);
            }
            $file = $request->file("image");
            $uploadFile = time() . '_' . $file->getClientOriginalName();
            $file->move('images/poto-kalimas/Album/', $uploadFile);
            $albumdesa->image = $uploadFile;
        }
        $albumdesa->update([
            'title' => $request->title,
        ]);
        if ($albumdesa) {
            return redirect()->route('albumdesa.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->route('albumdesa.index')->with('error', 'Data Gagal Diupdate');
        }
    }

    public function destroy($id)
    {
        $albumdesa = album::findOrFail($id);
        if (File::exists("images/poto-kalimas/Album/" . $albumdesa->image)) {
            File::delete("images/poto-kalimas/Album/" . $albumdesa->image);
        }
        $albumdesa->delete();
        return redirect()->route('albumdesa.index');
    }
}
