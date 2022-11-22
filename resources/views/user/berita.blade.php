@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
<div class="container-xxl bg-white p-0">
<div class="container px-lg-5">

    <div class="row g-4">
        @forelse ($berita as $berita)
        <div class="col-md-6 col-lg-4">
            <div class="mb-5 max-h-60 overflow-hidden blog-image rounded-xl">
                <img class="w-full" width="250px" height="250px" src="/image/{{ $berita->image }}" />
              </div>
            <a href="javascript:void(0)">{{ $berita->author }}</a> &nbsp;&nbsp; &nbsp;&nbsp;<a >{{ date('d-m-Y', strtotime($berita->created_at)); }}</a>
            <br>
            <br>
            <h5 class="text-black mb-4"> {{ $berita->title }}</h5>
            <p>{{ Str::limit($berita->content, 40) }}</p>
            <a class="text-theme-color" href="/berita/{{ $berita->title }}">
                    Baca Selengkapnya ->
            </a>
        </div>
        @empty
                <h2 class="mt-20 text-2xl	font-extrabold	">Oh Tidak Halaman Masih Kosong ...</h2>
            @endforelse
    </div>
</div>
</div>

@endsection
