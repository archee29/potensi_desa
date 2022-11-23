@extends('layouts.user.user-layout')
@extends('layouts.user.map-navbar')

@section('title')
    Potensi Desa
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

@section('leaflet_script')
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

        @foreach ($wisata_desa as $item)
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
            @foreach ($wisata_desa as $key => $value)
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
            @foreach ($wisata_desa as $item)
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

@section('content')
    <div id="pemerintahan-desa" class="container-xxl py-5  my-5 bg-white p-0">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Potensi Desa</h6>
                <h2 class="mt-2">Detail Data</h2>
            </div>

            <div id="struktur" class="row mt-n2 wow fadeInUp" data-wow-delay="0.1s">
                <div class="col-12 text-center">
                    <ul class="list-inline mb-5" id="portfolio-flters">
                        {{-- <li class="btn px-3 pe-4 active" data-filter="*">Semua</li> --}}
                        <li class="btn px-3 pe-4 active" data-bs-toggle="collapse" data-bs-target="#data_sekolah"
                            data-filter=".first">
                            Sekolah</li>
                        <li class="btn px-3 pe-4" data-bs-toggle="collapse" data-bs-target="#data_rumah_ibadah"
                            data-filter=".second">Rumah Ibadah
                        </li>
                        <li class="btn px-3 pe-4" data-bs-toggle="collapse" data-bs-target="#data_wisata"
                            data-filter=".three">Wisata</li>
                        <li class="btn px-3 pe-4" data-bs-toggle="collapse" data-bs-target="#data_pasar"
                            data-filter=".four">Pasar</li>
                    </ul>
                </div>
            </div>

            <div class="row g-10">
                <div id="data_sekolah" class="container-xxl py-5 bg-white collapse show first">
                    <div class="container px-lg-5 overflow-hidden">
                        <div class="card wow zoomIn" data-wow-delay="0.1s">
                            <div class="card-header">{{ __('Data Sekolah') }}</div>
                            <div class="card-body">
                                <table class="table" id="detail_data_sekolah">
                                    <thead>
                                        <tr>
                                            <th>No. </th>
                                            <th>Author </th>
                                            <th>Opsi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="data_pasar" class="container-xxl py-5 bg-white collapse second">
                    <div class="container px-lg-5">
                        <div class="card wow zoomIn" data-wow-delay="0.1s">
                            <div class="card-header">{{ __('Data Pasar') }}</div>
                            <div class="card-body">
                                <table class="table" id="detail_data_pasar">
                                    <thead>
                                        <tr>
                                            <th>No. </th>
                                            <th>Author </th>
                                            <th>Opsi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="data_rumah_ibadah" class="container-xxl py-5 bg-white collapse three">
                    <div class="container px-lg-5">
                        <div class="card wow zoomIn" data-wow-delay="0.1s">
                            <div class="card-header">{{ __('Data Rumah Ibadah') }}</div>
                            <div class="card-body">
                                <table class="table" id="detail_data_rumah_ibadah">
                                    <thead>
                                        <tr>
                                            <th>No. </th>
                                            <th>Author </th>
                                            <th>Opsi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="data_wisata" class="container-xxl py-5 bg-white collapse four">
                    <div class="container px-lg-5">
                        <div class="card wow zoomIn" data-wow-delay="0.1s">
                            <div class="card-header">{{ __('Data Wisata Desa') }}</div>
                            <div class="card-body">
                                <table class="table" id="detail_data_wisata_desa">
                                    <thead>
                                        <tr>
                                            <th>No. </th>
                                            <th>Author </th>
                                            <th>Opsi </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    {{-- Sekolah --}}
    <script>
        $(function() {
            $('#detail_data_sekolah').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,

                ajax: '{{ route('detail-data-sekolah') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'author'
                    },
                    {
                        data: 'show'
                    }
                ]
            });
        });
    </script>

    {{-- Pasar --}}
    <script>
        $(function() {
            $('#detail_data_pasar').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,

                ajax: '{{ route('detail-data-pasar') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'author'
                    },
                    {
                        data: 'show'
                    }
                ]
            });
        });
    </script>

    {{--  Rumah Ibadah  --}}
    <script>
        $(function() {
            $('#detail_data_rumah_ibadah').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,

                ajax: '{{ route('detail-data-rumah-ibadah') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'author'
                    },
                    {
                        data: 'show'
                    }
                ]
            });
        });
    </script>

    {{-- Wisata --}}
    <script>
        $(function() {
            $('#detail_data_wisata_desa').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                lengthChange: false,
                autoWidth: false,

                ajax: '{{ route('detail-data-wisata') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'author'
                    },
                    {
                        data: 'show'
                    }
                ]
            });
        });
    </script>
@endpush
