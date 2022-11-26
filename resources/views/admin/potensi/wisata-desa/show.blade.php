@extends('layouts.admin.admin-layout')

@section('title')
    Detail Data
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
                <li class="breadcrumb-item"><i class="fa fa-globe-asia me-2"></i>Wisata</li>
                <li class="breadcrumb-item"><a href="/wisata/show"><i class="fas fa-eye me-2"></i>Detail Data Wisata</a>
                </li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="show" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Detail Data Wisata</div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Nama Desa"
                                    name="author" value="{{ $wisata_desa->author }}" readonly>
                                <label for="floatingInput">Author</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Nama Desa"
                                    name="dusun" value="{{ $wisata_desa->dusun }}" readonly>
                                <label for="floatingInput">Dusun</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Nama Desa"
                                    name="nama_wisata" value="{{ $wisata_desa->nama_wisata }}" readonly>
                                <label for="floatingInput">Nama Wisata</label>
                            </div>

                            <div class="form-floating">
                                <textarea class="form-control" readonly placeholder="Masukkan Keterangan" id="floatingTextarea" style="height: 150px;"
                                    name="keterangan">{{ $wisata_desa->keterangan }}</textarea>
                                <label for="floatingTextarea">Keterangan</label>
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label mt-3">Poto Tempat Wisata</label> <br>
                                <img id="previewImage" class="mb-3 mt-2  " src="{{ $wisata_desa->getImage() }}"
                                    width="20%" <input class="form-control" type="file" id="image" name="image">
                                <input class="form-control" type="file" id="image" name="image" readonly disabled>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Lokasi</label>
                                <input type="text" name="location" posisi="sekarang" class="form-control" readonly
                                    id="" value="{{ $wisata_desa->location }}" aria-describedby="button-addon1">
                            </div>
                            <div id="map"></div>

                            <div class="md:w-2/3 mb-3">
                                <label for="formFile" class="form-label mt-3">Masukkan Tanggal Edit</label>
                                <input
                                    class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                    id="inline-full-name" name="created_at" type="datetime-local"
                                    value="{{ $wisata_desa->created_at }}" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <a href="{{ route('wisata-desa.index') }}">
                                    <button type="button" class="btn btn-outline-danger m-2">Kembali</button>
                                </a>
                            </div>
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
            center: [{{ $wisata_desa->location }}],
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

        var curLocation = [{{ $wisata_desa->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'true',
        });
        map.addLayer(marker);

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
                .bindPopup("<b>Hai!</b><br />Ini adalah Lokasi Wisata Desa");

        }
    </script>
@endpush
