@extends('layouts.admin.admin-layout')

@section('title')
    Detail
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
    <style>
        #map {
            width: 100%
        }

        /*Legend specific*/
        .legend {
            padding: 6px 8px;
            font: 14px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            /*box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);*/
            /*border-radius: 5px;*/
            line-height: 24px;
            color: #555;
        }

        .legend h4 {
            text-align: center;
            font-size: 16px;
            margin: 2px 12px 8px;
            color: #777;
        }

        .legend span {
            position: relative;
            bottom: 3px;
        }

        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin: 0 8px 0 0;
            opacity: 0.7;
        }

        .legend i.icon {
            background-size: 18px;
            background-color: rgba(255, 255, 255, 1);
        }
    </style>
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
                        <div class="card-header">Detail Data Lokasi</div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="Nama Desa"
                                    name="nama_desa" value="{{ $lokasi->nama_desa }}" readonly>
                                <label for="floatingInput">Nama Desa</label>
                            </div>

                            <div class="form-floating mb-3">
                                <select class="form-select" id="floatingSelect"
                                    aria-label="Floating label Pilih Jenis Potensi example" name="jenis_potensi" disabled>
                                    <option selected value=""{{ $lokasi->jenis_potensi == null ? 'selected' : '' }}>
                                        Jenis
                                        Potensi</option>
                                    <option
                                        value="rumah_ibadah"{{ $lokasi->jenis_potensi == 'rumah_ibadah' ? 'selected' : '' }}>
                                        Rumah Ibadah</option>
                                    <option value="sekolah"{{ $lokasi->jenis_potensi == 'sekolah' ? 'selected' : '' }}>
                                        Sekolah</option>
                                    <option value="wisata"{{ $lokasi->jenis_potensi == 'wisata' ? 'selected' : '' }}>
                                        Wisata</option>
                                    <option value="pasar"{{ $lokasi->jenis_potensi == 'pasar' ? 'selected' : '' }}>
                                        Pasar</option>
                                </select>
                                <label for="floatingSelect">Silahkan Pilih Jenis Potensi</label>
                            </div>

                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Masukkan Keterangan" id="floatingTextarea" style="height: 150px;"
                                    name="keterangan" readonly>{{ $lokasi->keterangan }}</textarea>
                                <label for="floatingTextarea">Keterangan</label>
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label mt-3">Poto Lokasi</label> <br>
                                <img id="previewImage" class="mb-3 mt-2" src="{{ $lokasi->getImage() }}" width="20%"
                                    alt="gambar_desa">
                                <input class="form-control" type="file" id="image" name="image" readonly disabled>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Lokasi</label>
                                <input type="text" name="location" value="{{ $lokasi->location }}" class="form-control"
                                    readonly id="">
                            </div>
                            <div id="map"></div>

                            <div class="md:w-2/3 mb-3">
                                <label for="formFile" class="form-label mt-3">Masukkan Tanggal Edit</label>
                                <input
                                    class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                    id="inline-full-name" name="created_at" type="datetime-local"
                                    value="{{ $lokasi->created_at }}" readonly>
                            </div>

                            <div class="form-group mt-3">
                                <a href="/lokasi">
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
            center: [{{ $lokasi->location }}],
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

        var curLocation = [{{ $lokasi->location }}];
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
        map.on("click", function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (!marker) {
                marker = L.marker(e.latlng).addTo(map);
            } else {
                marker.setLatLng(e.latlng);
            }
            loc.value = lat + "," + lng;
        });
        var titik = document.querySelector("[posisi = sekarang]");

        function getlokasi() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
        }

        function showPosition(posisi) {
            titik.value = posisi.coords.latitude + " , " + posisi.coords.longitude;
            L.marker([posisi.coords.latitude, posisi.coords.longitude])
                .addTo(map)
                .bindPopup("<b>Hai!</b><br />Ini adalah lokasi mu");

        }
    </script>
@endpush
