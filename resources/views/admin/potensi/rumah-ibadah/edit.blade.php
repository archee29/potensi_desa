@extends('layouts.admin.admin-layout')

@section('title')
    Edit Data
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
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-place-of-worship me-2"></i>Rumah Ibadah</li>
                <li class="breadcrumb-item"><a href="/rumah-ibadah/create"><i class="fas fa-pencil-alt me-2"></i>Edit Data
                        Rumah Ibadah</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="edit" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Edit Data Rumah Ibadah</div>
                        <div class="card-body">
                            <form action="{{ route('rumah-ibadah.update', $rumah_ibadah) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="form-floating mb-3">
                                    <input type="text" name="author"
                                        class="form-control @error('author') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" value="{{ $rumah_ibadah->author }}">
                                    <label for="floatingInput">Author</label>
                                    @error('author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="dusun"
                                        class="form-control @error('dusun') is-invalid @enderror" id="floatingInput"
                                        placeholder="Nama Desa" value="{{ $rumah_ibadah->dusun }}">
                                    <label for="floatingInput">Dusun</label>
                                    @error('dusun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="nama_tempat_ibadah"
                                        class="form-control @error('nama_tempat_ibadah') is-invalid @enderror"
                                        id="floatingInput" placeholder="Nama Desa"
                                        value="{{ $rumah_ibadah->nama_rumah_ibadah }}">
                                    <label for="floatingInput">Nama Rumah Ibadah</label>
                                    @error('nama_tempat_ibadah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select @error('agama') is-invalid @enderror" id="floatingSelect"
                                        name="agama" aria-label="Floating label Pilih Jenis Potensi example">
                                        <option value=""{{ $rumah_ibadah->agama == null ? 'selected' : '' }}>Agama
                                        </option>
                                        <option value="islam"{{ $rumah_ibadah->agama == 'islam' ? 'selected' : '' }}>
                                            Islam</option>
                                        <option value="kristen"{{ $rumah_ibadah->agama == 'kristen' ? 'selected' : '' }}>
                                            Kristen</option>
                                        <option value="katolik"{{ $rumah_ibadah->agama == 'katolik' ? 'selected' : '' }}>
                                            Katolik</option>
                                        <option value="budha"{{ $rumah_ibadah->agama == 'budha' ? 'selected' : '' }}>
                                            Budha</option>
                                        <option value="hindu"{{ $rumah_ibadah->agama == 'hindu' ? 'selected' : '' }}>
                                            Hindu</option>
                                    </select>
                                    <label for="floatingSelect">Silahkan Pilih</label>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan"
                                        id="floatingTextarea" style="height: 150px;" name="keterangan">{{ $rumah_ibadah->keterangan }}</textarea>
                                    <label for="floatingTextarea">Keterangan</label>
                                    @error('keterangan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label mt-3">Poto Rumah Ibadah</label><br>
                                    <img id="previewImage" class="mb-3 mt-2  " src="{{ $rumah_ibadah->getImage() }}"
                                        width="20%">
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="image" name="image">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="">Lokasi</label>
                                    <input type="text" name="location" posisi="sekarang"
                                        class="form-control @error('location') is-invalid @enderror"
                                        aria-describedby="button-addon1" readonly id=""
                                        value="{{ $rumah_ibadah->location }}">
                                    <button class="btn btn-outline-primary mt-3 btn-block" type="button" id="button-addon1"
                                        onclick="getlokasi()">Dapatkan Titik</button>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div id="map"></div>

                                <div class="md:w-2/3 mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan Tanggal Edit</label>
                                    <input
                                        class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                        id="inline-full-name" name="created_at" type="datetime-local"
                                        value="{{ $rumah_ibadah->created_at }}">
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-outline-success m-2">Edit Data</button>
                                    <a href="/sekolah">
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

        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v10',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            streets = L.tileLayer(mbUrl, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            });

        var map = L.map('map', {
            center: [{{ $rumah_ibadah->location }}],
            zoom: 14,
            layers: [streets]
        });

        var baseLayers = {
            //"Grayscale": grayscale,
            "Streets": streets,
            "Satellite": satellite
        };

        var overlays = {
            "Streets": streets,
            "Satellite": satellite,
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        var curLocation = [{{ $rumah_ibadah->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'true',
        });
        // map.addLayer(marker);

        marker.on('dragend', function(event) {
            var location = marker.getLatLng();
            marker.setLatLng(location, {
                draggable: 'true',
            }).bindPopup(location).update();

            $('#location').val(location.lat + "," + location.lng).keyup()
        });

        var loc = document.querySelector("[name=location]");
        // map.on("click", function(e) {
        //     var lat = e.latlng.lat;
        //     var lng = e.latlng.lng;

        //     if (!marker) {
        //         marker = L.marker(e.latlng).addTo(map);
        //     } else {
        //         marker.setLatLng(e.latlng);
        //     }
        //     loc.value = lat + "," + lng;
        // });
        var titik = document.querySelector("[posisi = sekarang]");
        var ps = document.querySelector("[name=location]");

        function getlokasi() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }

        function showPosition(posisi) {
            titik.value = posisi.coords.latitude + " , " + posisi.coords.longitude;
            ps.value = posisi.coords.latitude + " , " + posisi.coords.longitude;
            L.marker([posisi.coords.latitude, posisi.coords.longitude])
                .addTo(map)
                .bindPopup("<b>Hai!</b><br />Ini adalah Lokasi Rumah Ibadah");

        }
    </script>
@endpush
