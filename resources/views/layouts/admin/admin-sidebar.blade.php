<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
        </a>

        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <i class="fas fa-user"></i>
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                </div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">Admin Dashboard</h6>
                <span>{{ Auth::user()->name }}</span>
            </div>
        </div>

        <div class="navbar-nav w-100">
            <a href="/home" class="nav-item nav-link {{ Request::path() == 'home' ? 'active' : '' }}"><i
                    class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
            <a href="/lokasi" class="nav-item nav-link {{ Request::path() == 'lokasi' ? 'active' : '' }}"><i
                    class="fa fa-map-marker-alt"></i>Lokasi</a>

            <div class="nav-item dropdown">
                <a href="/potensi" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-chart-line"></i>Potensi</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('rumah-ibadah.index') }}"
                        class="dropdown-item nav-link {{ Request::path() == 'rumah-ibadah' ? 'active' : '' }}"><i
                            class="fa fa-place-of-worship"></i>Rumah
                        Ibadah</a>
                    <a href="{{ route('wisata-desa.index') }}"
                        class="dropdown-item nav-link {{ Request::path() == 'wisata' ? 'active' : '' }}"><i
                            class="fa fa-globe-asia"></i>Tempat
                        Wisata</a>
                    <a href="/sekolah"
                        class="dropdown-item nav-link {{ Request::path() == 'sekolah' ? 'active' : '' }}"><i
                            class="fa fa-school"></i>Sekolah</a>
                    <a href="{{ route('pasar.index') }}"
                        class="dropdown-item nav-link {{ Request::path() == 'pasar' ? 'active' : '' }}"><i
                            class="fa fa-store-alt"></i>Pasar</a>
                </div>
            </div>

            <a href="/artikel" class="nav-item nav-link {{ Request::path() == 'artikel' ? 'active' : '' }}"><i
                    class="fa fa-newspaper"></i>Artikel</a>
            <a href="/tentangdesa" class="nav-item nav-link {{ Request::path() == 'tentangdesa' ? 'active' : '' }}"><i
                    class="fa fa-users"></i>Tentang Desa</a>
            <a href="/albumdesa" class="nav-item nav-link {{ Request::path() == 'albumdesa' ? 'active' : '' }}"><i
                    class="fa fa-users"></i>Album Desa</a>
            <a href="/pemerintahan"
                class="nav-item nav-link {{ Request::path() == 'pemerintahan' ? 'active' : '' }}"><i
                    class="fa fa-table me-2"></i>Pemerintahan</a>
            <a href="/mottodesa" class="nav-item nav-link {{ Request::path() == 'mottodesa' ? 'active' : '' }}"><i
                    class="fa fa-table me-2"></i>Motto Desa </a>
            <a href="/visimisi" class="nav-item nav-link {{ Request::path() == 'visimisi' ? 'active' : '' }}"><i
                    class="fa fa-table me-2"></i>Visi - Misi </a>
            <div class="nav-item dropdown">
                <a href="" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i
                        class="fa fa-chart-line"></i>Data Desa</a>
                <div class="dropdown-menu bg-transparent border-0">

                    <a href="/datadana"
                        class="dropdown-item nav-link {{ Request::path() == 'pasar' ? 'active' : '' }}"><i
                            class="fa fa-database"></i>Data Dana</a>
                    <a href="/datapenduduk"
                        class="dropdown-item nav-link {{ Request::path() == 'pasar' ? 'active' : '' }}"><i
                            class="fa fa-database"></i>Data Penduduk</a>
                </div>
            </div>


        </div>

    </nav>
</div>
