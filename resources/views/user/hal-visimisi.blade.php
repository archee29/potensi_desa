@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
    <div class="container-xxl py-5  my-5 bg-white p-0">
        <div class="container px-lg-5 ">
             <div class="owl-carousel testimonial-carousel">
                @forelse ($visimisi as $visimisi)
                    <div class="testimonial-item bg-transparent border rounded text-white p-4">
                        <i class="fa fa-quote-left fa-2x mb-4"></i>
                        <h4>Visi</h4>
                        <p align="center">{{ $visimisi->visi }}</p>
                        <h4>Misi</h4>
                        <p align="center">{{ $visimisi->misi }}</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle"
                                src="images/poto-kalimas/visimisi/{{ $visimisi->image }}"
                                style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h6 class="text-white mb-1">{{ $visimisi->jabatan }}</h6>
                                <small>{{ $visimisi->name }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                <h2 class="mt-20 text-2xl	font-extrabold	">Oh Tidak Halaman Masih Kosong ...</h2>
            @endforelse
            </div>
        </div>
    </div>
@endsection
