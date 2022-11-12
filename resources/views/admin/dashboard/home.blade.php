@extends('layouts.admin.admin-layout')
@section('title')
    Dashboard
@endsection

{{-- @section('add_css')
    <style>
        #map {
            height: 500px;
        }
    </style>
@endsection

@section('add_script')
    <script>
        // var map = L.map('map').setView([-0.08581514293429128, 109.22367233774284], 14);

        const cities = L.layerGroup();

        const mLittleton = L.marker([-0.08409853108529625, 109.20564789434026]).bindPopup('TOKO').addTo(cities);
        const mDenver = L.marker([-0.08817548410057909, 109.21178478816542]).bindPopup('HOME STAY').addTo(cities);
        const mAurora = L.marker([-0.08302564864123735, 109.22504562866874]).bindPopup('SURAU').addTo(cities);
        const mGolden = L.marker([-0.08315439453607652, 109.20594830173029]).bindPopup('MASJID').addTo(cities);

        const mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
        const mbAttr =
            'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';

        const streets = L.tileLayer(mbUrl, {
            id: 'mapbox/streets-v11',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });

        const osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="/home">Desa Kalimas</a>'
        });

        const map = L.map('map', {
            center: [-0.08613885331428853, 109.22359369596721],
            zoom: 14,
            layers: [osm, cities]
        });

        const baseLayers = {
            'OpenStreetMap': osm,
            'Streets': streets
        };

        const overlays = {
            'Cities': cities
        };

        const layerControl = L.control.layers(baseLayers, overlays).addTo(map);
        const crownHill = L.marker([-0.08409853108529625, 109.20564789434026]).bindPopup('Toko');
        const rubyHill = L.marker([-0.08817548410057909, 109.21178478816542]).bindPopup('Home Stay');

        const parks = L.layerGroup([crownHill, rubyHill]);

        const satellite = L.tileLayer(mbUrl, {
            id: 'mapbox/satellite-v9',
            tileSize: 512,
            zoomOffset: -1,
            attribution: mbAttr
        });
        layerControl.addBaseLayer(satellite, 'Satellite');
        layerControl.addOverlay(parks, 'Parks');
    </script>
@endsection --}}

@section('add_css')
    <style>
        #map {
            height: 500px;
        }
    </style>
@endsection

@section('add_script')
    <script>
        var map = L.map('map').setView([-0.08418436167954874, 109.20590538638888], 14);
        // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 19,
        //     attribution: '&copy; <a href="http://untan.ac.id">MBKM Smart Village Tanjungpura</a>',
        // }).addTo(map);
        L.tileLayer('http://{s}.google.com/vt?lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
        }).addTo(map);

        var tokoIcon = L.icon({
            iconUrl: 'images/map icon/toko.png',

            iconSize: [30, 35], // size of the icon
            shadowSize: [50, 64], // size of the shadow
            iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62], // the same for the shadow
            popupAnchor: [-3, -76], // point from which the popup should open relative to the iconAnchor
        });
        // L.marker([-0.08418436167954874, 109.20590538638888], {
        //     icon: tokoIcon
        // }).addTo(map).on('click', function(e) {
        //     alert(e.latlng);
        // });

        var latlngs = [
            [
                -0.08571144059300195,
                109.2300535244699

            ],
            [
                -0.06891640675939925,
                109.21974185824399
            ],
            [
                -0.07842541139949333,
                109.17815745975275
            ],
            [
                -0.0981225228139806,
                109.1980398341558
            ],
            [
                -0.08577322662537767,
                109.23045673401123
            ]
        ];
        var polyline = L.polyline(latlngs, {
            color: 'blue'
        }).addTo(map);


        // zoom the map to the polyline
        map.fitBounds(polyline.getBounds());
    </script>
@endsection


@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                    </li>
                </ol>
            </nav>

            <div class="card border-opacity-100 border-1">
                <div class="card-header border-info">
                    <h6 class="mt-2">Peta Potensi Desa Keseluruhan</h6>
                </div>
                <div class="card-body">
                    <div id="map">
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Recent Salse</h6>
                <a href="">Show All</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-dark">
                            <th scope="col"><input class="form-check-input" type="checkbox"></th>
                            <th scope="col">Date</th>
                            <th scope="col">Invoice</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                        <tr>
                            <td><input class="form-check-input" type="checkbox"></td>
                            <td>01 Jan 2045</td>
                            <td>INV-0123</td>
                            <td>Jhon Doe</td>
                            <td>$123</td>
                            <td>Paid</td>
                            <td><a class="btn btn-sm btn-primary" href="">Detail</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
@endsection

{{-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Map Box</div>
                    <div class="card-body" style='width: 100%; height: 60vh;'>
                        <div>a</div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

{{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <div class="col-sm-12 col-xl-6">
                        <div class="bg-light rounded h-100 p-4">
                            <iframe class="position-relative rounded w-100 h-100"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd"
                                frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                                tabindex="0"></iframe>
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div> --}}
