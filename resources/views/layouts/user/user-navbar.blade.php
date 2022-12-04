  <div class="container-xxl position-relative p-0">
      <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
          <a href="" class="navbar-brand p-0">
              <h1 class="m-0"><i class="fa fa-search me-2"></i>SIP<span class="fs-5">Mas</span></h1>
              <!-- <img src="img/logo.png" alt="Logo"> -->
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
              <span class="fa fa-bars"></span>
          </button>
          <div class="collapse navbar-collapse " id="navbarCollapse">
              <div class="navbar-nav  ms-auto py-0">
                  <a href="/" class="nav-item nav-link {{ Request::path() == '/' ? 'active' : '' }}">Home</a>
                  <a href="/berita"
                      class="nav-item nav-link  {{ Request::path() == 'berita' ? 'active' : '' }} ">Berita</a>
                  <a href="/tentang-desa"
                      class="nav-item nav-link {{ Request::path() == 'tentang-desa' ? 'active' : '' }}">Tentang Desa</a>
                  <a href="/motto-desa"
                      class="nav-item nav-link {{ Request::path() == 'motto-desa' ? 'active' : '' }}">Motto Desa</a>




                  <div class="nav-item dropdown">
                      <a href="#data-desa" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Pemerintahan</a>
                      <div class="dropdown-menu m-0">
                          <a href="/pemerintahan-desa"
                              class="dropdown-item {{ Request::path() == 'pemerintahan-desa' ? 'active' : '' }}">Pemerintahan
                              Desa</a>
                          <a href="/visi-misi"
                              class="dropdown-item {{ Request::path() == 'visi-misi' ? 'active' : '' }}">Visi Dan
                              Misi</a>
                      </div>
                  </div>


                  <div class="nav-item dropdown">
                      <a href="#data-desa" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Data Desa</a>
                      <div class="dropdown-menu m-0">
                          <a href="/data-penduduk"
                              class="dropdown-item {{ Request::path() == 'data-penduduk' ? 'active' : '' }}">Statistik
                              Kependudukan</a>
                          <a href="/data-dana"
                              class="dropdown-item {{ Request::path() == 'data-dana' ? 'active' : '' }}">APBDes</a>
                      </div>
                  </div>

                  <a href="#contact"
                      class="nav-item nav-link {{ Request::path() == 'contact' ? 'active' : '' }}">Hubungi
                      Kami</a>
              </div>
              <button type="button" class="btn text-secondary ms-3" data-bs-toggle="modal"
                  data-bs-target="#searchModal"><i class="fa fa-search"></i></button>
              <a href="{{ route('peta.index') }}" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Peta
                  Desa</a>
          </div>
      </nav>

  </div>









  {{-- <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <div>
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/kuburaya.png') }}" width="30" class="d-inline-block">
                Desa Kalimas
            </a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
            aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Desa Kalimas</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="">Home</a>
                    </li>
                    <li class="nav-item">
                        @if (Route::has('login'))
                            <div class="hidden fixed top-0 right-0">
                                @auth
                                    <a href="{{ url('/home') }}" class="nav-link">Home</a>
                                @else
                                    <a href="{{ route('login') }}" class="nav-link">Log in</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif

                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex mt-3" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </div>
</nav> --}}

  {{-- <div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            @endauth
        </div>
    @endif


</div> --}}
