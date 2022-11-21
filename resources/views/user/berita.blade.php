@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@section('content')
<div class="container py-5 px-lg-5">

    <div class="row g-5">
        @forelse ($artikel as $artikel)
        <div class="col-md-6 col-lg-4">
            <div class="mb-5 max-h-60 overflow-hidden blog-image rounded-xl">
                <img class="w-full" width="250px" src="/image/{{ $artikel->image }}" />
              </div>
            <a href="javascript:void(0)">{{ $artikel->author }}</a> &nbsp;&nbsp; &nbsp;&nbsp;<a >{{ date('d-m-Y', strtotime($artikel->created_at)); }}</a>
            <br>
            <br>
            <h5 class="text-black mb-4"> {{ $artikel->title }}</h5>
            <p>{{ Str::limit($artikel->content, 40) }}</p>
            <a class="text-theme-color" href="/artikel/{{ $artikel->title }}">
                    Baca Selengkapnya ->
            </a>
        </div>
        @empty
                <h2 class="mt-20 text-2xl	font-extrabold	">Oh Tidak Halaman Masih Kosong ...</h2>
            @endforelse
    </div>

@endsection
