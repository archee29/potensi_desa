@extends('layouts.admin.admin-layout')

@section('title')
    Tambah Data
@endsection

@section('add_css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #map {
            height: 500px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid pt-4 px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Pasar</li>
                <li class="breadcrumb-item"><i class="fa fa-store-alt me-2"></i>Pasar</li>
                <li class="breadcrumb-item"><a href="/pasar/create"><i class="fas fa-plus-circle me-2"></i>Tambah Data
                        Pasar</a></li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="create" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Tambah Data Pasar</div>
                        <div class="card-body">
                            <form action="{{ route('lokasi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('desa') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Desa">
                                    <label for="floatingInput">Author</label>
                                    @error('desa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('desa') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Desa">
                                    <label for="floatingInput">Judul</label>
                                    @error('desa')
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
                                    <a href="/pasar">
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {
            $('#dataSpaces').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,

                // Route untuk menampilkan data space
                ajax: '{{ route('data-space') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'lokasi'
                    },
                    {
                        data: 'action'
                    }
                ]
            })
        })
    </script>
@endpush


