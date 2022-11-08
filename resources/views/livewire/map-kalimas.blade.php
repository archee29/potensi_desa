@extends('layouts.admin.admin-layout')

@section('title')
    Map
@endsection



@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Home</li>
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-tachometer-alt me-2"></i>Map</a>
                    </li>
                </ol>
            </nav>

            <div class="card border-opacity-100 border-1">
                <div class="card-header border-info">
                    <h6 class="mt-2">Peta Potensi Desa Keseluruhan</h6>
                </div>
                <div class="card-body">
                    <h1>map</h1>
                    <div id="map">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
        });
    </script>
@endpush
