@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
    <div class="container-xxl py-5  my-5 bg-white p-0">
        <div class="container px-lg-5 ">
            <div class="row g-5">
                @forelse ($tentangdesa as $tentangdesa)
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-2">
                            <h6 class="position-relative text-primary ps-4">About</h6>
                            <h2 class="mt-2">Tentang Desa</h2>
                        </div>
                        <p class="mb-4">{{ $tentangdesa->isi }}</p>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" width="700px" height="400px"
                            src="/images/poto-kalimas/Tentang/{{ $tentangdesa->image }}">
                    </div>
                @empty
                    <h2 class="mt-20 text-2xl	font-extrabold	">Oh Tidak Halaman Masih Kosong ...</h2>
                @endforelse
            </div>
        </div>
    </div>
@endsection
