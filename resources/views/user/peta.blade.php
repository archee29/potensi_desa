@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')

@section('add_css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
        integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
        crossorigin="" />

    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
        integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
        crossorigin=""></script>

    {{-- cdn leaflet search --}}
    <link rel="stylesheet" href="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.css">
    <script src="https://labs.easyblog.it/maps/leaflet-search/src/leaflet-search.js"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .leaflet-container {
            height: 400px;
            width: 600px;
            max-width: 100%;
            max-height: 100%;
        }
    </style>

    <style>
        body {
            padding: 0;
            margin: 0;
        }

        #map {
            height: 100%;
            width: 100vw;
        }
    </style>
@endsection

@section('content')
    <div id="profile-desa" class="container-xxl py-5">

        <div class="container px-lg-5">

            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Peta</h6>
                <h2 class="mt-2">Peta Desa</h2>
            </div>

            <div class="row g-4">

                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-home fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Rumah Ibadah</h5>
                        <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                            lorem.</p>
                        <a class="btn px-3 mt-auto mx-auto" href="{{ route('peta.index') }}">Read
                            More</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-home fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Sekolah</h5>
                        <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                            lorem.</p>
                        <a class="btn px-3 mt-auto mx-auto" href="">Read More</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-home fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Pasar</h5>
                        <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                            lorem.</p>
                        <a class="btn px-3 mt-auto mx-auto" href="">Read More</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-home fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Wisata</h5>
                        <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                            lorem.</p>
                        <a class="btn px-3 mt-auto mx-auto" href="">Read More</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-home fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Hubungi Kami</h5>
                        <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                            lorem.</p>
                        <a class="btn px-3 mt-auto mx-auto" href="">Read More</a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                    <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                        <div class="service-icon flex-shrink-0">
                            <i class="fa fa-home fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Home</h5>
                        <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                            lorem.</p>
                        <a class="btn px-3 mt-auto mx-auto" href="/">Read More</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="map"></div>
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

        var map = L.map('map', {

            center: [{{ $lokasi->location }}],
            zoom: 14,
            layers: [streets]
        });

        var baseLayers = {
            "Grayscale": dark,
            "Satellite": satellite,
            "Streets": streets
        };

        var overlays = {
            "Streets": streets,
            "Grayscale": dark,
            "Satellite": satellite,
        };

        // Menampilkan popup data ketika marker di klik
        @foreach ($pasar as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showPasar', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Pasar</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach

        @foreach ($sekolah as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showSekolah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Sekolah</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach

        @foreach ($rumah_ibadah as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showRumahIbadah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Rumah Ibadah</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach

        @foreach ($wisata as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showWisata', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Wisata</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach


        // Membuat variable data detail potensi
        var dataPasar = [
            @foreach ($pasar as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];

        var dataSekolah = [
            @foreach ($sekolah as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];

        var dataRumahIbadah = [
            @foreach ($rumah_ibadah as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];

        var dataWisata = [
            @foreach ($wisata as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];

        // pada koding ini kita menambahkan control pencarian data
        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer);

        var controlSearch = new L.Control.Search({
            position: 'topleft',
            layer: markersLayer,
            initial: false,
            zoom: 17,
            markerLocation: true
        })


        //menambahkan variabel controlsearch pada addControl
        map.addControl(controlSearch);

        // looping variabel dataPasar utuk menampilkan data space ketika melakukan pencarian data
        for (i in dataPasar) {

            var title = dataPasar[i].title,
                loc = dataPasar[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);

            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($pasar as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showPasar', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Pasar</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }

        for (i in dataSekolah) {

            var title = dataSekolah[i].title,
                loc = dataSekolah[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);

            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($sekolah as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showSekolah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Sekolah</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }

        for (i in dataRumahIbadah) {

            var title = dataRumahIbadah[i].title,
                loc = dataRumahIbadah[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);

            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($rumah_ibadah as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showRumahIbadah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Rumah Ibadah</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }

        for (i in dataWisata) {

            var title = dataWisata[i].title,
                loc = dataWisata[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);

            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($wisata as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showWisata', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Wisata</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }


        L.control.layers(baseLayers, overlays).addTo(map);
    </script>
@endsection
