<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class DataPendudukController extends Controller
{
    public function index()
    {

        return view('admin.datapenduduk.index');
    }
    public function create()
    {
        return view('admin.datapenduduk.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'dusun' => 'required',
            'cowok' => 'required',
            'cewek' => 'required',
            'jumlah' => 'required',
            'luas' => 'required',
        ]);
        $datapenduduk = new Penduduk();
        $datapenduduk->dusun = $request->input('dusun');
        $datapenduduk->cowok = $request->input('cowok');
        $datapenduduk->cewek = $request->input('cewek');
        $datapenduduk->jumlah = $request->input('jumlah');
        $datapenduduk->luas = $request->input('luas');
        $datapenduduk->save();
        if ($datapenduduk) {
            return redirect()->route('datapenduduk.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('datapenduduk.index')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    public function show($id)
    {
        return view('admin.datapenduduk.show', [
            'datapenduduk' => Penduduk::findOrFail($id)
        ]);
    }

    public function edit(Penduduk $datapenduduk)
    {
        $datapenduduk = Penduduk::findOrFail($datapenduduk->id);
        return view('admin.datapenduduk.edit', [
            'datapenduduk' => $datapenduduk
        ]);
    }

    public function update(Request $request, Penduduk $datapenduduk)
    {
        $this->validate($request, [
            'dusun' => 'required',
            'cowok' => 'required',
            'cewek' => 'required',
            'jumlah' => 'required',
            'luas' => 'required',
        ]);
        $datapenduduk = Penduduk::findOrFail($datapenduduk->id);
        $datapenduduk->update([
            'dusun' => $request->dusun,
            'cowok' => $request->cowok,
            'cewek' => $request->cewek,
            'jumlah' => $request->jumlah,
            'luas' => $request->luas,
        ]);
        if ($datapenduduk) {
            return redirect()->route('datapenduduk.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->route('datapenduduk.index')->with('error', 'Data Gagal Diupdate');
        }
    }

    public function destroy($id)
    {
        $datapenduduk = Penduduk::findOrFail($id);
        $datapenduduk->delete();
        return redirect()->route('datapenduduk.index');
    }
}
