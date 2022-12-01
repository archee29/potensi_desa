@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
<div id="data-desa" class="container-xxl py-5  my-5 bg-white p-0">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="position-relative d-inline text-primary ps-4">Data Dana Desa</h6>
                <h2 class="mt-2">Dana Desa</h2>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6 class="position-relative d-inline text-primary ps-4">Data Desa</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Nama Bidang</th>
                                <th scope="col">Jumlah Pengeluaran (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datadana as $datadana)
                            <tr>
                                <td>{{ $datadana->bidang }}</td>
                                <td>Rp. {{ $datadana->jumlah }}</td>
                            </tr>
                               @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
