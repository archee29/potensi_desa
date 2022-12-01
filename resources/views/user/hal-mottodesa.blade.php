@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
<div class="container-xxl py-5  my-5 bg-white p-0">
<div class="container px-lg-5">
    <div class="row g-4">
                @forelse ($mottodesa as $mottodesa)
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-home fa-2x"></i>
                            </div>
                            <h5 class="mb-3">{{ $mottodesa->title }}</h5>
                            <p>{{ $mottodesa->isi }}</p>
                        </div>
                    </div>
                @empty
                    <h2 class="mt-20 text-2xl	font-extrabold	">Oh Tidak Halaman Masih Kosong ...</h2>
                @endforelse
            </div>
</div>
</div>

@endsection
