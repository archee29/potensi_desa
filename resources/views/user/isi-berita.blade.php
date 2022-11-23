
@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@section('content')
<div class="container py-5 px-lg-5">
    <div class="container-xxl bg-white p-0">
        <div class="container">
          <div class="flex flex-col text-center w-full">
            <h1
              class="
                sm:text-4xl text-2xl font-medium title-font text-gray-900 center-align
              ">
              {{ $berita->title }}
            </h1>
          </div>
        </div>


        <div class="container px-5 py-20 mx-auto">
            <div class="position-relative rounded overflow-hidden">
                <img class="img-fluid rounded mx-auto d-block" src="/image/{{ $berita->image }}">
                <br>
          <p class="break-words">
            {!! $berita->content !!}
            </p>
          <div class="xl:w-1/2 lg:w-3/4 w-full mx-auto text-center">

        <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-8 mb-6"></span>
        <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">{{ $berita->author }}</h2>
        <p class="text-gray-500">{{ date('d-m-Y', strtotime($berita->created_at)) }}</p>
    </div>
</div>
</div>
</div>


<h1 class="text-center sm:text-3xl
  text-2xl
  font-medium
  title-font
  mb-5 mt-5
  text-gray-900"> - Berita Lainnya - </h1>
  <div class="container-xxl py-5  my-5 bg-white p-0">
    <div class="container px-lg-5">
        <div class="row g-4">
            <div class="row g-4">
                @forelse (array_slice($beritaa->toArray(), 0, 3)  as $beritaa)
                <div class="col-md-6 col-lg-4">
                    <div class="mb-5 max-h-60 overflow-hidden blog-image rounded-xl">
                        <img class="w-full" width="250px" height="250px" src="/image/{{ $beritaa->image }}" />
                      </div>
                    <a href="javascript:void(0)">{{ $beritaa->author }}</a> &nbsp;&nbsp; &nbsp;&nbsp;<a >{{ date('d-m-Y', strtotime($beritaa->created_at)); }}</a>
                    <br>
                    <br>
                    <h5 class="text-black mb-4"> {{ $beritaa->title }}</h5>
                    <p>{{ Str::limit($beritaa->content, 40) }}</p>
                    <a class="text-theme-color" href="/berita/{{ $beritaa->title }}">
                            Baca Selengkapnya ->
                    </a>
                </div>
                @empty
                        <h2 class="mt-20 text-2xl	font-extrabold	">Oh Tidak Halaman Masih Kosong ...</h2>
                    @endforelse
        </div>
        <h1 class="text-center sm:text-3xl
              text-xl
              font-medium
              title-font
              mb-0 mt-20
              text-gray-900"> <a href="/berita">Lihat  {{ $count-1 }} Konten Lainnya</a> </h1>
    </div>
    </div>
</div>
</div>


@endsection
