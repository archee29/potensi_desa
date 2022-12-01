@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
    <div class="container-xxl py-5  my-5 bg-white p-0">
        <div class="container px-lg-5 ">
              <div class="row">
                @forelse ($albumdesa as $albumdesa)
                    <div class="col-6 col-md-4">
                        <div id="image-card" class="row g-10 portfolio-container">
                            <div class="col-lg-12 portfolio-item wow zoomIn" data-wow-delay="0.1s">
                                <div class="position-relative rounded overflow-hidden">
                                    <img class="img-fluid w-60" src="images/poto-kalimas/Album/{{ $albumdesa->image }}"
                                        alt="">
                                    <div class="portfolio-overlay">
                                        <a class="btn btn-light" href="images/poto-kalimas/Album/{{ $albumdesa->image }}"
                                            data-lightbox="portfolio"><i class="fa fa-plus text-primary"></i></a>
                                        <div class="mt-auto">
                                            <small class="text-white"><i
                                                    class="fa fa-folder me-2"></i>{{ $albumdesa->title }}</small>

                                        </div>
                                    </div>
                                </div>
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
