@extends('layouts.user.user-layout')
@include('layouts.user.map-navbar')

@section('title')
    Detail Wisata
@endsection

@section('add_css')
    {{-- cdn leaflet search --}}
    <link rel="stylesheet" href="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.css">
    <script src="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.js"></script>

    <style>
        #map {
            height: 500px;
        }
    </style>
@endsection


@section('content')
    <div id="detail-pasar" class="container-xxl py-5 bg-white">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Potensi Desa</h6>
                <h2 class="mt-2">Detail Wisata Desa</h2>
            </div>
            <div class="container-xxl py-5">
                <div class="container px-lg-5">
                    <div class="card wow zoomIn" data-wow-delay="0.1s">
                        <div class="card-header">Detail Wisata</div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('author') is-invalid @enderror"
                                    id="floatingInput" placeholder="Nama Desa" name="author"
                                    value="{{ $wisata_desa->author }}" readonly>
                                <label for="floatingInput">Author</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('dusun') is-invalid @enderror"
                                    id="floatingInput" placeholder="Nama Desa" name="dusun"
                                    value="{{ $wisata_desa->dusun }}" readonly>
                                <label for="floatingInput">Dusun</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('nama_wisata') is-invalid @enderror"
                                    id="floatingInput" placeholder="Nama Desa" name="nama_wisata"
                                    value="{{ $wisata_desa->nama_wisata }}" readonly>
                                <label for="floatingInput">Nama Wisata</label>
                            </div>

                            <div class="form-floating">
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan"
                                    id="floatingTextarea" style="height: 150px;" name="keterangan" readonly>{{ $wisata_desa->keterangan }}</textarea>
                                <label for="floatingTextarea">Keterangan</label>
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label mt-3">Poto Tempat Wisata</label> <br>
                                <img id="previewImage" class="mb-3 mt-2  " src="{{ $wisata_desa->getImage() }}"
                                    width="20%" <input class="form-control @error('image') is-invalid @enderror"
                                    type="file" id="image" name="image">
                            </div>

                            <div class="md:w-2/3 mb-3">
                                <label for="formFile" class="form-label mt-3">Tanggal Upload</label>
                                <input
                                    class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                    id="inline-full-name" name="created_at" type="datetime-local"
                                    value="{{ $wisata_desa->created_at }}" readonly>
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('detailPotensi.index') }}" class="btn btn-outline-primary">Kembali</a>
                        </div>
                    </div>
                </div>

                <div class="container px-lg-5 mt-3">
                    <div class="card wow zoomIn" data-wow-delay="0.1s">
                        <div class="card-header">Detail Map</div>
                        <div class="card-body">
                            <div id="map"></div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('detailPotensi.index') }}" class="btn btn-outline-primary">Kembali</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
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


        var data{{ $wisata_desa->id }} = L.layerGroup()

        var map = L.map('map', {
            center: [{{ $wisata_desa->location }}],
            zoom: 20,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: [streets, data{{ $wisata_desa->id }}]
        });

        var baseLayers = {
            "Streets": streets,
            "Satellite": satellite,
            "Dark": dark,
        };

        var overlays = {
            //"Streets": streets
            "{{ $wisata_desa->dusun }}": data{{ $wisata_desa->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);


        var curLocation = [{{ $wisata_desa->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'false',
        });
        map.addLayer(marker);
    </script>
@endpush
