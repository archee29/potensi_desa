@extends('layouts.admin.admin-layout')

@section('title')
    Detail
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-newspaper me-2"></i>Data Pemerintahan</li>
                <li class="breadcrumb-item"><a href="/data/show"><i class="fas fa-eye me-2"></i>Detail Data Pemerintahan</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="show" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Lihat Data APBDes 2022</h6>
                    <div class="form mb-3">
                        <input class="form-control" type="text" value="Author" aria-label="readonly input example"
                            readonly>
                    </div>
                    <div class="form mb-3">
                        <input class="form-control" type="text" value="Judul" aria-label="readonly input example"
                            readonly>
                    </div>
                    <div class="form mb-3">
                        <textarea aria-label="readonly input example" class="form-control" placeholder="Isi" id="floatingTextarea"
                            style="height: 150px;" readonly></textarea>
                    </div>
                    <div class="form mb-3">
                        <input class="form-control" type="text" value="Gambar" aria-label="readonly input example"
                            readonly>
                    </div>
                    <div class="form md:w-2/3 mb-3">
                        <label for="formFile" class="form-label mt-3">Tanggal Upload</label>
                        <input
                            class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            aria-label="readonnly input example" id="inline-full-name" name="created_at"
                            type="datetime-local" value="" readonly>
                    </div>
                    <div class="m-n2">
                        <button type="button" class="btn btn-outline-primary m-2">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
