@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')

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
    <div class="container py-4 justify-content-center">
        <div class="row">
            <div class="col-md-6 col-xs-6 mb-2">
                <div class="card">
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

            <div class="col-md-6 col-xs-6">
                <div class="card">
                    <div class="card-header">Detail Map</div>
                    <div class="card-body">
                        <div id="map"></div>
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
