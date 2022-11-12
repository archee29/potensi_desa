<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentrePoint;
use App\Models\Space;

class CentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('centrepoint.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.centrepoint.create');
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
            'location' => 'required'
        ]);

        // jalankan proses simpan data ke table centrepoint
        $centrePoint = new CentrePoint;
        $centrePoint->location = $request->input('location');
        $centrePoint->save();

        // setelah data disimpan redirect ke halaman index centrepoint
        if ($centrePoint) {
            return redirect()->route('centre-point.index')->with('success', 'Data berhasil Disimpan');
        } else {
            return redirect()->route('centre-point.index')->with('error', 'Data gagal Disimpan');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CentrePoint $centrePoint)
    {
         $centrePoint = CentrePoint::findOrFail($centrePoint->id);
        return view('centrepoint.edit',[
            'centrePoint' => $centrePoint
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CentrePoint $centrePoint)
    {
        $centrePoint = CentrePoint::findOrFail($centrePoint->id);
        $centrePoint->location = $request->input('location');
        $centrePoint->update();

        if ($centrePoint) {
            return redirect()->route('centre-point.index')->with('success', 'Data berhasil Diupdate');
        } else {
            return redirect()->route('centre-point.index')->with('error', 'Data gagal Diupdate');
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
        $centrePoint = CentrePoint::findOrFail($id);
        $centrePoint->delete();
        return redirect()->back();
    }
}
