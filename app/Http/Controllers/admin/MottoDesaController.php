<?php

namespace App\Http\Controllers\admin;

use App\Models\RumahIbadah;
use Illuminate\Support\Str;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Motto;
use Illuminate\Support\Facades\File;

class MottoDesaController extends Controller
{


    public function depanMottoDesa()
    {

        $posts = Motto::latest();
        $mottodesa = $posts->get();
        return view('user.hal-mottodesa', ['mottodesa' => $mottodesa,]);
    }


    public function index()
    {

        return view('admin.mottodesa.index');
    }
    public function create()
    {
        return view('admin.mottodesa.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'isi' => 'required',
        ]);
        $mottodesa = new Motto();
        $mottodesa->title = $request->input('title');
        $mottodesa->isi = $request->input('isi');
        $mottodesa->save();
        if ($mottodesa) {
            return redirect()->route('mottodesa.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('mottodesa.index')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    public function show($id)
    {
        return view('admin.mottodesa.show', [
            'mottodesa' => Motto::findOrFail($id)
        ]);
    }

    public function edit(Motto $mottodesa)
    {
        $mottodesa = Motto::findOrFail($mottodesa->id);
        return view('admin.mottodesa.edit', [
            'mottodesa' => $mottodesa
        ]);
    }

    public function update(Request $request, Motto $mottodesa)
    {
        $this->validate($request, [
            'title' => 'required',
            'isi' => 'required',
        ]);
        $mottodesa = Motto::findOrFail($mottodesa->id);
        $mottodesa->update([
            'title' => $request->title,
            'isi' => $request->isi,
        ]);
        if ($mottodesa) {
            return redirect()->route('mottodesa.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->route('mottodesa.index')->with('error', 'Data Gagal Diupdate');
        }
    }

    public function destroy($id)
    {
        $mottodesa = Motto::findOrFail($id);
        $mottodesa->delete();
        return redirect()->route('mottodesa.index');
    }
}
