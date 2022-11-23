@extends('layouts.user.user-layout')
@include('layouts.user.map-navbar')

@section('title')
    Detail Rumah Ibadah
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
                    <div class="card-header">Detail Rumah Ibadah</div>
                    <div class="card-body">
                        <div class="form-floating mb-3">
                            <input type="text" name="author" class="form-control @error('author') is-invalid @enderror"
                                id="floatingInput" placeholder="Nama Desa" value="{{ $rumah_ibadah->author }}" readonly>
                            <label for="floatingInput">Author</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="dusun" class="form-control @error('dusun') is-invalid @enderror"
                                id="floatingInput" placeholder="Nama Desa" value="{{ $rumah_ibadah->dusun }}" readonly>
                            <label for="floatingInput">Dusun</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="nama_tempat_ibadah"
                                class="form-control @error('nama_tempat_ibadah') is-invalid @enderror" id="floatingInput"
                                placeholder="Nama Desa" value="{{ $rumah_ibadah->nama_rumah_ibadah }}" readonly>
                            <label for="floatingInput">Nama Rumah Ibadah</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select @error('agama') is-invalid @enderror" id="floatingSelect"
                                name="agama" aria-label="Floating label Pilih Jenis Potensi example" disabled>
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
                        </div>

                        <div class="form-floating">
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan Keterangan"
                                id="floatingTextarea" style="height: 150px;" name="keterangan" readonly>{{ $rumah_ibadah->keterangan }}</textarea>
                            <label for="floatingTextarea">Keterangan</label>
                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label mt-3">Poto Rumah Ibadah</label><br>
                            <img id="previewImage" class="mb-3 mt-2  " src="{{ $rumah_ibadah->getImage() }}"
                                width="20%">
                        </div>

                        <div class="md:w-2/3 mb-3">
                            <label for="formFile" class="form-label mt-3">Tanggal Upload</label>
                            <input
                                class=" form-control bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                                id="inline-full-name" name="created_at" type="datetime-local"
                                value="{{ $rumah_ibadah->created_at }}" readonly>
                        </div>
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


        var data{{ $rumah_ibadah->id }} = L.layerGroup()

        var map = L.map('map', {
            center: [{{ $rumah_ibadah->location }}],
            zoom: 20,
            fullscreenControl: {
                pseudoFullscreen: false
            },
            layers: [streets, data{{ $rumah_ibadah->id }}]
        });

        var baseLayers = {
            "Streets": streets,
            "Satellite": satellite,
            "Dark": dark,
        };

        var overlays = {
            //"Streets": streets
            "{{ $rumah_ibadah->dusun }}": data{{ $rumah_ibadah->id }},
        };

        L.control.layers(baseLayers, overlays).addTo(map);


        var curLocation = [{{ $rumah_ibadah->location }}];
        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'false',
        });
        map.addLayer(marker);
    </script>
@endpush
