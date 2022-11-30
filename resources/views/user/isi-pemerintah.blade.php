@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')
@section('content')
<div class="container-xxl py-5  my-5 bg-white p-0">
<div class="container px-lg-5">
    <div class="slider owl-carousel">
        @forelse ($pemerintahan as $pemerintahan)
        <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
            <div class="team-item">
                <div class="d-flex">
                    <div class="flex-shrink-0 d-flex flex-column align-items-center mt-4 pt-5"
                        style="width: 75px;">
                        <a class="btn btn-square text-primary bg-white my-1" href=""><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square text-primary bg-white my-1" href=""><i
                                class="fab fa-twitter"></i></a>
                        <a class="btn btn-square text-primary bg-white my-1" href=""><i
                                class="fab fa-instagram"></i></a>
                        <a class="btn btn-square text-primary bg-white my-1" href=""><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                    <img class="img-fluid rounded w-60" src="images/poto-kalimas/Pemerintahan/{{ $pemerintahan->image }}" alt="{{ $pemerintahan->image }}">
                </div>
                <div class="px-4 py-3">
                    <h5 class="fw-bold m-0">{{ $pemerintahan->name}}</h5>
                    <span>{{ $pemerintahan->jabatan }}</span>
                </div>
            </div>
        </div>
        @empty
        @endforelse
    </div>
    <script>
        $(".slider").owlCarousel({
          loop: true,
          autoplay: true,
          autoplayTimeout: 2000, //2000ms = 2s;
          autoplayHoverPause: true,
        });
     </script>

</div>
</div>

@endsection

