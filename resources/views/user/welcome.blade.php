@extends('layouts.user.user-layout')
@include('layouts.user.user-navbar')
@include('layouts.user.isi-navbar')

@section('title')
    Home
@endsection
{{--
@section('add_css')
    <style>
        #map {
            height: 500px;
        }
    </style>
@endsection
@section('leaflet_script')
    <script>
        var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            mbUrl =
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
        var satellite = L.tileLayer(mbUrl, {
                id: 'mapbox/satellite-v9',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            dark = L.tileLayer(mbUrl, {
                id: 'mapbox/dark-v10',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            }),
            streets = L.tileLayer(mbUrl, {
                id: 'mapbox/streets-v11',
                tileSize: 512,
                zoomOffset: -1,
                attribution: mbAttr
            });
        var map = L.map('map', {
            center: [{{ $lokasi->location }}],
            zoom: 14,
            layers: [streets]
        });
        var baseLayers = {
            "Grayscale": dark,
            "Satellite": satellite,
            "Streets": streets
        };
        var overlays = {
            "Streets": streets,
            "Grayscale": dark,
            "Satellite": satellite,
        };
        // Menampilkan popup data ketika marker di klik
        @foreach ($pasar as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showPasar', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Pasar</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach
        @foreach ($sekolah as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showSekolah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Sekolah</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach
        @foreach ($rumah_ibadah as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showRumahIbadah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Rumah Ibadah</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach
        @foreach ($wisata_desa as $item)
            L.marker([{{ $item->location }}])
                .bindPopup(
                    "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                    "<div class='my-2'><strong>Nama Space:</strong> <br>{{ $item->dusun }}</div>" +
                    "<div><a href='{{ route('peta.showWisata', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Wisata</a></div>" +
                    "<div class='my-2'></div>"
                ).addTo(map);
        @endforeach
        // Membuat variable data detail potensi
        var dataPasar = [
            @foreach ($pasar as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];
        var dataSekolah = [
            @foreach ($sekolah as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];
        var dataRumahIbadah = [
            @foreach ($rumah_ibadah as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];
        var dataWisata = [
            @foreach ($wisata_desa as $key => $value)
                {
                    "loc": [{{ $value->location }}],
                    "title": '{!! $value->name !!}'
                },
            @endforeach
        ];
        // pada koding ini kita menambahkan control pencarian data
        var markersLayer = new L.LayerGroup();
        map.addLayer(markersLayer);
        var controlSearch = new L.Control.Search({
            position: 'topleft',
            layer: markersLayer,
            initial: false,
            zoom: 17,
            markerLocation: true
        })
        //menambahkan variabel controlsearch pada addControl
        map.addControl(controlSearch);
        // looping variabel dataPasar utuk menampilkan data space ketika melakukan pencarian data
        for (i in dataPasar) {
            var title = dataPasar[i].title,
                loc = dataPasar[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);
            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($pasar as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showPasar', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Pasar</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }
        for (i in dataSekolah) {
            var title = dataSekolah[i].title,
                loc = dataSekolah[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);
            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($sekolah as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showSekolah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Sekolah</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }
        for (i in dataRumahIbadah) {
            var title = dataRumahIbadah[i].title,
                loc = dataRumahIbadah[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);
            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($rumah_ibadah as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showRumahIbadah', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Rumah Ibadah</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }
        for (i in dataWisata) {
            var title = dataWisata[i].title,
                loc = dataWisata[i].loc,
                marker = new L.Marker(new L.latLng(loc), {
                    title: title
                });
            markersLayer.addLayer(marker);
            // melakukan looping data untuk memunculkan popup dari space yang dipilih
            @foreach ($wisata_desa as $item)
                L.marker([{{ $item->location }}])
                    .bindPopup(
                        "<div class='my-2'><img src='{{ $item->getImage() }}' class='img-fluid' width='700px'></div>" +
                        "<div class='my-2'><strong>Nama Spot:</strong> <br>{{ $item->dusun }}</div>" +
                        "<a href='{{ route('peta.showWisata', $item->slug) }}' class='btn btn-outline-info btn-sm'>Detail Wisata</a></div>" +
                        "<div class='my-2'></div>"
                    ).addTo(map);
            @endforeach
        }
        L.control.layers(baseLayers, overlays).addTo(map);
    </script>
@endsection --}}

@section('content')
    {{-- < class="container-xxl bg-white p-0"> --}}
        <div class="modal fade" id="searchModal" tabindex="-1">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content" style="background: rgba(29, 29, 39, 0.7);">
                    <div class="modal-header border-0">
                        <button type="button" class="btn bg-white btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center justify-content-center">
                        <div class="input-group" style="max-width: 600px;">
                            <input type="text" class="form-control bg-transparent border-light p-3"
                                placeholder="Type search keyword">
                            <button class="btn btn-light px-4"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div id="tentang-desa" class="container-xxl py-5 bg-white p-0">

            <div class="container px-lg-5 ">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="section-title position-relative mb-4 pb-2">
                            <h6 class="position-relative text-primary ps-4">About</h6>
                            <h2 class="mt-2">Tentang Desa</h2>
                        </div>
                        <p class="mb-4">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor sit. Aliqu diam
                            amet diam et eos labore. Clita erat ipsum et lorem et sit, sed stet no labore lorem sit.
                            Sanctus clita duo justo et tempor eirmod magna dolore erat amet</p>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="user-rsc/img/about.jpg">
                    </div>
                </div>
            </div>
        </div>

        <div id="iklan-desa" class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                    </div>
                </div>
            </div>
        </div>

        <div id="profile-desa" class="container-xxl py-5  my-5 bg-white p-0 ">
            <div class="container py-5 px-lg-5 ">
                <div class="section-title position-relative  mb-4 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Motto Desa</h6>
                    <h2 class="mt-2">Motto Desa</h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-home fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Aparatur Desa</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                                lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.3s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-home fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Berita Desa</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                                lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.6s">
                        <div class="service-item d-flex flex-column justify-content-center text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-home fa-2x"></i>
                            </div>
                            <h5 class="mb-3">Peta Desa</h5>
                            <p>Erat ipsum justo amet duo et elitr dolor, est duo duo eos lorem sed diam stet diam sed stet
                                lorem.</p>
                            <a class="btn px-3 mt-auto mx-auto" href="{{ route('peta.index') }}">Read More</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

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
                      text-gray-900"> <a href="/berita">Lihat  {{ $count-1 }} Berita Lainnya</a> </h1>
            </div>
            </div>
      </div>

        <div id="poto-kades" class="container-xxl py-5  my-5 bg-white p-0">
            <div class="container px-lg-5">
                <div class="section-title position-relative  mb-4 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Profile User </h6>
                    <h2 class="mt-2">Profile User</h2>
                </div>
                <div class="slider owl-carousel">
                    @forelse ($profil as $profil)
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
                                <img class="img-fluid rounded w-60" src="images/poto-kalimas/Pemerintahan/{{ $profil->image }}" alt="{{ $profil->image }}">
                            </div>
                            <div class="px-4 py-3">
                                <h5 class="fw-bold m-0">{{ $profil->name}}</h5>
                                <span>{{ $profil->jabatan }}</span>
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

        <div id="iklan-desa" class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                        <h3 class="text-white">Ready to get started</h3>
                        <small class="text-white">Diam elitr est dolore at sanctus nonumy.</small>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Enter Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                        <img class="img-fluid mt-5" style="height: 250px;" src="user-rsc/img/newsletter.png">
                    </div>
                </div>
            </div>
        </div>




        <div id="pemerintahan-desa" class="container-xxl py-5  my-5 bg-white p-0">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Pemerintahan</h6>
                    <h2 class="mt-2">Pemerintahan Desa</h2>
                </div>

                <div id="struktur" class="row mt-n2 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="col-12 text-center">
                        <ul class="list-inline mb-5" id="portfolio-flters">
                            <li class="btn px-3 pe-4 active" data-filter="*">Semua</li>
                            <li class="btn px-3 pe-4" data-filter=".first">Aparatur Desa</li>
                            <li class="btn px-3 pe-4" data-filter=".second">Badan Permusyawaratan Desa</li>
                            <li class="btn px-3 pe-4" data-filter=".three">Visi dan Misi</li>
                        </ul>
                    </div>
                </div>

                <div id="image-card" class="row g-10 portfolio-container">
                    <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.1s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="user-rsc/img/portfolio-1.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="user-rsc/img/portfolio-1.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.3s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="user-rsc/img/portfolio-2.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="user-rsc/img/portfolio-2.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.6s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="user-rsc/img/portfolio-3.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="user-rsc/img/portfolio-3.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.1s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="user-rsc/img/portfolio-4.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="user-rsc/img/portfolio-4.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item first wow zoomIn" data-wow-delay="0.3s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="user-rsc/img/portfolio-5.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="user-rsc/img/portfolio-5.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 portfolio-item second wow zoomIn" data-wow-delay="0.6s">
                        <div class="position-relative rounded overflow-hidden">
                            <img class="img-fluid w-100" src="user-rsc/img/portfolio-6.jpg" alt="">
                            <div class="portfolio-overlay">
                                <a class="btn btn-light" href="user-rsc/img/portfolio-6.jpg" data-lightbox="portfolio"><i
                                        class="fa fa-plus fa-2x text-primary"></i></a>
                                <div class="mt-auto">
                                    <small class="text-white"><i class="fa fa-folder me-2"></i>Web Design</small>
                                    <a class="h5 d-block text-white mt-1 mb-0" href="">Project Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="visi-struktur" class="container-xxl bg-primary testimonial three py-5 my-5 wow fadeInUp"
            data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="owl-carousel testimonial-carousel">

                    <div class="testimonial-item bg-transparent border rounded text-white p-4">
                        <i class="fa fa-quote-left fa-2x mb-3"></i>
                        <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                            labore diam
                        </p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-1.jpg"
                                style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h6 class="text-white mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-item bg-transparent border rounded text-white p-4">
                        <i class="fa fa-quote-left fa-2x mb-3"></i>
                        <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                            labore diam
                        </p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-2.jpg"
                                style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h6 class="text-white mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-item bg-transparent border rounded text-white p-4">
                        <i class="fa fa-quote-left fa-2x mb-3"></i>
                        <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                            labore diam
                        </p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-3.jpg"
                                style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h6 class="text-white mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-item bg-transparent border rounded text-white p-4">
                        <i class="fa fa-quote-left fa-2x mb-3"></i>
                        <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                            labore diam
                        </p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-4.jpg"
                                style="width: 50px; height: 50px;">
                            <div class="ps-3">
                                <h6 class="text-white mb-1">Client Name</h6>
                                <small>Profession</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="iklan-desa" class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                        <h3 class="text-white">Ready to get started</h3>
                        <small class="text-white">Diam elitr est dolore at sanctus nonumy.</small>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Enter Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                        <img class="img-fluid mt-5" style="height: 250px;" src="user-rsc/img/newsletter.png">
                    </div>
                </div>
            </div>
        </div>

        <div id="data-desa" class="container-xxl py-5  my-5 bg-white p-0">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Data Desa</h6>
                    <h2 class="mt-2">Statistik Kependudukan</h2>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h6 class="position-relative d-inline text-primary ps-4">Data Desa</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td colspan="2">Larry the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="data-dana" class="container-xxl py-5  my-5 bg-white p-0">
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
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Handle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>Thornton</td>
                                    <td>@fat</td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td colspan="2">Larry the Bird</td>
                                    <td>@twitter</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="iklan-desa" class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                        <h3 class="text-white">Ready to get started</h3>
                        <small class="text-white">Diam elitr est dolore at sanctus nonumy.</small>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Enter Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                        <img class="img-fluid mt-5" style="height: 250px;" src="user-rsc/img/newsletter.png">
                    </div>
                </div>
            </div>
        </div>

        <div id="contact" class="container-xxl py-5 bg-white p-0">
            <div class="container px-lg-5">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp"
                            data-wow-delay="0.1s">
                            <h6 class="position-relative d-inline text-primary ps-4">Hubungi Kami</h6>
                            <h2 class="mt-2">Silahkan Tuliskan Kritik & Saran</h2>
                        </div>
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Your Name">
                                            <label for="name">Nama</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Your Email">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject"
                                                placeholder="Subject">
                                            <label for="subject">Subject</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a message here" id="message" style="height: 150px"></textarea>
                                            <label for="message">Tuliskan Pesan</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit">Kirim</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="iklan-desa" class="container-xxl bg-primary newsletter my-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container px-lg-5">
                <div class="row align-items-center" style="height: 250px;">
                    <div class="col-12 col-md-6">
                        <h3 class="text-white">Ready to get started</h3>
                        <small class="text-white">Diam elitr est dolore at sanctus nonumy.</small>
                        <div class="position-relative w-100 mt-3">
                            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text"
                                placeholder="Enter Your Email" style="height: 48px;">
                            <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i
                                    class="fa fa-paper-plane text-primary fs-4"></i></button>
                        </div>
                    </div>
                    <div class="col-md-6 text-center mb-n5 d-none d-md-block">
                        <img class="img-fluid mt-5" style="height: 250px;" src="user-rsc/img/newsletter.png">
                    </div>
                </div>
            </div>
        </div>

        <div id="peta-desa" class="container-xxl py-5 bg-white p-0">
            <div class="container px-lg-5">
                <div class="section-title position-relative text-center mb-5 pb-2 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="position-relative d-inline text-primary ps-4">Peta</h6>
                    <h2 class="mt-2">Peta Desa</h2>
                </div>
                <div class="card border-opacity-100 border-1">
                    <div class="card-header border-info ">
                        <h4>Map Desa</h4>
                    </div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
@endsection

{{-- <div class="container-xxl bg-primary testimonial three py-5 my-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container py-5 px-lg-5">
            <div class="owl-carousel testimonial-carousel">
                <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                        labore diam
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-1.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1">Client Name</h6>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                        labore diam
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-2.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1">Client Name</h6>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                        labore diam
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-3.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1">Client Name</h6>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item bg-transparent border rounded text-white p-4">
                    <i class="fa fa-quote-left fa-2x mb-3"></i>
                    <p>Dolor et eos labore, stet justo sed est sed. Diam sed sed dolor stet amet eirmod eos
                        labore diam
                    </p>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid flex-shrink-0 rounded-circle" src="user-rsc/img/testimonial-4.jpg"
                            style="width: 50px; height: 50px;">
                        <div class="ps-3">
                            <h6 class="text-white mb-1">Client Name</h6>
                            <small>Profession</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
