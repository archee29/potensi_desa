<?php

namespace App\Http\Controllers\admin;

use App\Models\Artikel;
use App\Models\Tentang;
use App\Models\Pemerintahan;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Dana;
use App\Models\Motto;
use App\Models\Penduduk;
use App\Models\Visimisi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ArtikelController extends Controller
{
    public function index()
    {
        // return view('admin.artikel.index');

        // mengirim data blog ke view
        $artikel = DB::table('tb_artikel')->get();
        return view('admin.artikel.index', ['artikel' => $artikel]);
    }

    public function depanProfil()
    {

        $posts = Pemerintahan::latest();
        $profil = $posts->get();
        return view('user.welcome', ['profil' => $profil,]);
    }


    public function depanArtikel()
    {
        $posts = Artikel::latest();

        if (request('search')) {
            $posts->where('title', 'like', '%' . request('search') . '%');
        }

        $berita = $posts->get();
        return view('user.hal-berita', ['berita' => $berita,]);
    }

    public function depanTentangDesa()
    {
        $posts = Tentang::latest();

        if (request('search')) {
            $posts->where('title', 'like', '%' . request('search') . '%');
        }

        $tentangdesa = $posts->get();
        return view('user.hal-tentangdesa', ['tentangdesa' => $tentangdesa,]);
    }


    public function depanHome()
    {
        $posts7 = Dana::latest();
        $datadana = $posts7->get();

        $posts6 = Penduduk::latest();
        $datapenduduk = $posts6->get();

        $posts5 = Visimisi::latest();
        $visimisi = $posts5->get();

        $posts4 = Motto::latest();
        $mottodesa = $posts4->get();

        $posts3 = Album::latest();
        $albumdesa = $posts3->get();

        $posts2 = Tentang::latest();
        $tentangdesa = $posts2->get();

        $posts = Pemerintahan::latest();
        $profil = $posts->get();
        $count = DB::table('tb_artikel')->count();
        $beritaa = DB::table('tb_artikel')->get();
        return view('user.welcome', [
            "beritaa" => $beritaa,
            "count" => $count,
            'profil' => $profil,
            'tentangdesa' => $tentangdesa,
            'albumdesa' => $albumdesa,
            'mottodesa' => $mottodesa,
            'visimisi' => $visimisi,
            'datapenduduk' => $datapenduduk,
            'datadana' => $datadana,
        ]);
    }


    public function isiArtikel(Artikel $berita)
    {
        $count = DB::table('tb_artikel')->count();
        $beritaa = DB::table('tb_artikel')->get();
        return view('user.isi-berita', ["berita" => $berita, "beritaa" => $beritaa, "count" => $count]);
    }

    public function create()
    {
        return view('/admin/artikel/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'author' => 'required',
            'title' => 'required|unique:tb_artikel',
            'content' => 'required',

        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }

        Artikel::create($input);

        $artikell = DB::table('tb_artikel')->get();
        // mengirim data blog ke view
        return view('admin.artikel.index', ['artikel' => $artikell]);
    }

    public function show($id)
    {
        // return view ('admin.artikel.show');
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.show', [
            'artikel' => $artikel
        ]);
    }

    public function edit($id)
    {
        // return view ('admin.artikel.edit');
        $artikel = Artikel::findOrFail($id);
        return view('admin.artikel.edit', [
            'artikel' => $artikel
        ]);
    }

    public function update(Request $request, Artikel $artikelll)
    {
        $request->validate([
            'author' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);
        $input = $request->all();
        if ($image = $request->file('image')) {
            $destinationPath = 'image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        } else {
            unset($input['image']);
        }
        $artikelll->update($input);
        return redirect()->action([ArtikelController::class, 'index']);
    }

    public function destroy(Artikel $artikel, $id)
    {
        DB::table('tb_artikel')->where('id', $id)->delete();
        return redirect()->action([ArtikelController::class, 'index']);
    }
}
