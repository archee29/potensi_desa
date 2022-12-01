@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
<div id="data-desa" class="container-xxl py-5  my-5 bg-white p-0">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Data Penduduk Desa</h6>
                <h2 class="mt-2">Statistik Kependudukan</h2>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="position-relative d-inline text-primary ps-4">Data Penduduk Desa</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Dusun</th>
                                <th scope="col">Laki - Laki</th>
                                <th scope="col">Perempuan</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Luas Wilayah (KM2)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datapenduduk as $datapenduduk)
                            <tr>
                                <td>{{ $datapenduduk->dusun }}</td>
                                <td>{{ $datapenduduk->cowok }}</td>
                                <td>{{ $datapenduduk->cewek }}</td>
                                <td>{{ $datapenduduk->jumlah }}</td>
                                <td>{{ $datapenduduk->luas }}</td>
                            </tr>
                               @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
