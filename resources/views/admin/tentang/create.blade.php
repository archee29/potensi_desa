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
                <li class="breadcrumb-item active" aria-current="page">Home</li>
                <li class="breadcrumb-item"><i class="fa fa-place-of-worship me-2"></i>Tentang Desa</li>
                <li class="breadcrumb-item"><a href=""><i class="fas fa-plus-circle me-2"></i>Tambah
                        Tentang Desa</a></li>
            </ol>
        </nav>
        <div class="row vh-80 bg-light rounded mx-0">
            <div id="create" class="col-sm-12 col-xl-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="card">
                        <div class="card-header">Tambah Tentang Desa</div>
                        <div class="card-body">
                            <form action="{{ route('tentangdesa.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-floating mb-3">
                                    <textarea name="isi" class="form-control @error('isi') is-invalid @enderror" id="floatingTextarea2" style="height: 100px"
                                        placeholder="Tentang Desa"></textarea>
                                    <label for="floatingTextarea2">Tentang Desa</label>
                                    @error('isi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan File dengan format
                                        .png/.jpg</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        id="formFile" name="image">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="md:w-2/3 mb-3">
                                    <label for="formFile" class="form-label mt-3">Masukkan Tanggal Upload</label>
                                    <input
                                        class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                        id="inline-full-name" name="created_at" type="datetime-local" value="">
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-outline-success m-2">Tambah Data</button>
                                    <a href="/tentangdesa">
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
        // fungsi ini akan berjalan ketika akan menambahkan gambar dimana fungsi ini
        // akan membuat preview image sebelum kita simpan gambar tersebut.
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        // Ketika tag input file denghan class image di klik akan menjalankan fungsi di atas
        $("#image").change(function() {
            readURL(this);
        });

        //         var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        //             'Imagery ?? <a href="https://www.mapbox.com/">Mapbox</a>',
        //             mbUrl =
        //             'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

        //         var satellite = L.tileLayer(mbUrl, {
        //                 id: 'mapbox/satellite-v9',
        //                 tileSize: 512,
        //                 zoomOffset: -1,
        //                 attribution: mbAttr
        //             }),
        //             dark = L.tileLayer(mbUrl, {
        //                 id: 'mapbox/dark-v10',
        //                 tileSize: 512,
        //                 zoomOffset: -1,
        //                 attribution: mbAttr
        //             }),
        //             streets = L.tileLayer(mbUrl, {
        //                 id: 'mapbox/streets-v11',
        //                 tileSize: 512,
        //                 zoomOffset: -1,
        //                 attribution: mbAttr
        //             });


        //         var map = L.map('map', {
        //             // titik koordinat disini kita dapatkan dari tabel centrepoint tepatnya dari field location
        //             // yang sebelumnya sudah kita tambahkan jadi lokasi map yang akan muncul  sesuai dengan tabel
        //             // centrepoint
        //             center: [-0.0837981240055652, 109.20594830173026],
        //             zoom: 14,
        //             layers: [streets]
        //         });

        //         var baseLayers = {
        //             //"Grayscale": grayscale,
        //             "Streets": streets,
        //             "Satellite": satellite
        //         };

        //         var overlays = {
        //             "Streets": streets,
        //             "Satellite": satellite,
        //         };

        //         L.control.layers(baseLayers, overlays).addTo(map);

        //         // Begitu juga dengan curLocation titik koordinatnya dari tabel centrepoint
        //         // lalu kita masukkan curLocation tersebut ke dalam variabel marker untuk menampilkan marker
        //         // pada peta.

        //         var curLocation = [-0.0837981240055652, 109.20594830173026];
        //         map.attributionControl.setPrefix(false);

        //         var marker = new L.marker(curLocation, {
        //             draggable: 'true',
        //         });
        //         map.addLayer(marker);

        //         marker.on('dragend', function(event) {
        //             var location = marker.getLatLng();
        //             marker.setLatLng(location, {
        //                 draggable: 'true',
        //             }).bindPopup(location).update();

        //             $('#location').val(location.lat + "," + location.lng).keyup()
        //         });

        //         var loc = document.querySelector("[name=location]");
        //         map.on("click", function(e) {
        //             var lat = e.latlng.lat;
        //             var lng = e.latlng.lng;

        //             if (!marker) {
        //                 marker = L.marker(e.latlng).addTo(map);
        //             } else {
        //                 marker.setLatLng(e.latlng);
        //             }
        //             loc.value = lat + "," + lng;
        //         });
    </script>
@endpush
