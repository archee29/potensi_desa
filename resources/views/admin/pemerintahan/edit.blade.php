@extends('layouts.admin.admin-layout')

@section('title')
    Edit Data
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-newspaper me-2"></i>Pemerintahan</li>
                <li class="breadcrumb-item"><a href="/lokasi"><i class="fas fa-pencil-alt me-2"></i>Edit Data Pemerintahan</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="edit" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Edit Data Artikel</h6>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control " id="floatingInput" placeholder="Author">
                        <label for="floatingInput">Author</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control " id="floatingInput" placeholder="Judul Artikel">
                        <label for="floatingInput">Judul Artikel</label>
                    </div>
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Masukkan Isi Artikel" id="floatingTextarea" style="height: 150px;"></textarea>
                        <label for="floatingTextarea">Isi Artikel</label>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label mt-3">Masukkan File dengan format .png/.jpg</label>
                        <input class="form-control" type="file" id="formFile">
                    </div>
                    <div class="md:w-2/3 mb-3">
                        <label for="formFile" class="form-label mt-3">Edit Tanggal Upload</label>
                        <input
                            class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                            id="inline-full-name" name="created_at" type="datetime-local" value="">
                    </div>
                    <div class="m-n2">
                        <button type="button" class="btn btn-outline-success m-2">Edit Data Artikel</button>
                        <button type="button" class="btn btn-outline-danger m-2">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
