@extends('layouts.user.user-layout')
@include('layouts.user.map-navbar')

@section('title')
    Detail Sekolah
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
    <div id="detail-sekolah" class="container-xxl py-5">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Potensi Desa</h6>
                <h2 class="mt-2">Detail Sekolah</h2>
            </div>
            <div id="peta-desa" class="container-xxl py-5">

                <div class="container px-lg-5">
                    <div class="card wow zoomIn" data-wow-delay="0.1s">
                        <div class="card-header">Detail Sekolah</div>
                        <div class="card-body">
                            <p>
                            <h4><strong>Author :</strong></h4>
                            <h5>{{ $sekolah->author }}</h5>
                            </p>

                            <p>
                            <h4><strong>Keterangan :</strong></h4>
                            <p>{{ $sekolah->keterangan }}</p>
                            </p>

                            <p>
                            <h4>
                                <strong>Foto Sekolah</strong>
                            </h4>
                            <img class="img-fluid" width="200" src="{{ $sekolah->getImage() }}" alt="gambar_sekolah">
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('peta.index') }}" class="btn btn-outline-primary">Kembali</a>
                        </div>
                    </div>
                </div>

                <div class="container px-lg-5 mt-3">
                    <div class="card wow zoomIn" data-wow-delay="0.1s">
                        <div class="card-header">Detail Map</div>
                        <div class="card-body">
                            <div id="map"></div>
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


        var data{{ $sekolah->id }} = L.layerGroup()

        var map = L.map('map', {
            center: [{{ $sekolah->location }}],
            zoom: 20,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: [streets, data{{ $sekolah->id }}]
        });

        var baseLayers = {
            "Streets": streets,
            "Satellite": satellite,
            "Dark": dark,
        };

        var overlays = {
            //"Streets": streets
            "{{ $sekolah->dusun }}": data{{ $sekolah->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);


        var curLocation = [{{ $sekolah->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'false',
        });
        map.addLayer(marker);
    </script>
@endpush
