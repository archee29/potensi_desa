@extends('layouts.admin.admin-layout')

@section('title')
    Detail
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-map-marker-alt me-2"></i>Lokasi</li>
                <li class="breadcrumb-item"><a href="/lokasi/show"><i class="fas fa-eye me-2"></i>Detail Lokasi</a></li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="show" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Tambah Data Lokasi</div>
                        <div class="card-body">
                            <form action="{{ route('lokasi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('desa') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Desa">
                                    <label for="floatingInput">Nama Desa</label>
                                    @error('desa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select @error('jenis_potensi') is-invalid @enderror"
                                        id="floatingSelect" aria-label="Floating label Pilih Jenis Potensi example">
                                        <option selected>Jenis Potensi</option>
                                        <option value="1">Rumah Ibadah</option>
                                        <option value="2">Sekolah</option>
                                        <option value="3">Wisata</option>
                                        <option value="3">Pasar</option>
                                    </select>
                                    <label for="floatingSelect">Silahkan Pilih Jenis Potensi</label>
                                    @error('jenis_potensi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan"
                                        id="floatingTextarea" style="height: 150px;"></textarea>
                                    <label for="floatingTextarea">Keterangan</label>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan File dengan format
                                        .png/.jpg</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="formFile">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="">Lokasi</label>
                                    <input type="text" name="location"
                                        class="form-control @error('titik') is-invalid @enderror" readonly id="">
                                    @error('titik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="map"></div>

                                <div class="md:w-2/3 mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan Tanggal Upload</label>
                                    <input
                                        class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                        id="inline-full-name" name="created_at" type="datetime-local" value="">
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-outline-success m-2">Tambah Data</button>
                                    <a href="/lokasi">
                                        <button type="button" class="btn btn-outline-danger m-2">Kembali</button>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
