<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Dana;
use Illuminate\Http\Request;

class DataDanaController extends Controller
{

    public function depanDana()
    {

        $posts = Dana::latest();
        $datadana = $posts->get();
        return view('user.hal-dana', ['datadana' => $datadana,]);
    }

    public function index()
    {

        return view('admin.datadana.index');
    }
    public function create()
    {
        return view('admin.datadana.create');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'bidang' => 'required',
            'jumlah' => 'required',
        ]);
        $datadana = new Dana();
        $datadana->bidang = $request->input('bidang');
        $datadana->jumlah = $request->input('jumlah');
        $datadana->save();
        if ($datadana) {
            return redirect()->route('datadana.index')->with('success', 'Data Berhasil Ditambahkan');
        } else {
            return redirect()->route('datadana.index')->with('error', 'Data Gagal Ditambahkan');
        }
    }

    public function show($id)
    {
        return view('admin.datadana.show', [
            'datadana' => Dana::findOrFail($id)
        ]);
    }

    public function edit(Dana $datadana)
    {
        $datadana = Dana::findOrFail($datadana->id);
        return view('admin.datadana.edit', [
            'datadana' => $datadana
        ]);
    }

    public function update(Request $request, Dana $datadana)
    {
        $this->validate($request, [
            'bidang' => 'required',
            'jumlah' => 'required',
        ]);
        $datadana = Dana::findOrFail($datadana->id);
        $datadana->update([
            'bidang' => $request->bidang,
            'jumlah' => $request->jumlah,

        ]);
        if ($datadana) {
            return redirect()->route('datadana.index')->with('success', 'Data Berhasil Diupdate');
        } else {
            return redirect()->route('datadana.index')->with('error', 'Data Gagal Diupdate');
        }
    }

    public function destroy($id)
    {
        $datadana = Dana::findOrFail($id);
        $datadana->delete();
        return redirect()->route('datadana.index');
    }
}
