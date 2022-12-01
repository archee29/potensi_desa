@extends('layouts.admin.admin-layout')

@section('title')
    Edit Data
@endsection

@section('add_css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-place-of-worship me-2"></i>Dana Desa</li>
                <li class="breadcrumb-item"><a href=""><i class="fas fa-pencil-alt me-2"></i>Edit Data
                        Dana Desa</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="edit" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Edit Data Dana Desa</div>
                        <div class="card-body">
                            <form action="{{ route('datadana.update', $datadana) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-floating mb-3">
                                    <input type="text" name="bidang"
                                        class="form-control @error('bidang') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" value="{{ $datadana->bidang }}">
                                    <label for="floatingInput">Nama Bidang</label>
                                    @error('bidang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-floating mb-3">
                                    <input type="text" name="jumlah"
                                        class="form-control @error('jumlah') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" value="{{ $datadana->jumlah }}">
                                    <label for="floatingInput">Jumlah Pengeluaran (Rp.)</label>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="md:w-2/3 mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan Tanggal Edit</label>
                                    <input
                                        class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                        id="inline-full-name" name="created_at" type="datetime-local"
                                        value="{{ $datadana->created_at }}">
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-outline-success m-2">Edit Data</button>
                                    <a href="/datadana">
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

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function() {
            readURL(this);
        });
    </script>
@endpush
