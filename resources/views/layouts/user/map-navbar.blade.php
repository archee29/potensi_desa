  <div class="container-xxl position-relative p-0">
      <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
          <a href="" class="navbar-brand p-0">
              <h1 class="m-0"><i class="fa fa-search me-2"></i>SI<span class="fs-5">Mas</span></h1>
              <!-- <img src="img/logo.png" alt="Logo"> -->
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
              <span class="fa fa-bars"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
              <div class="navbar-nav ms-auto py-0">
                  <a href="/" class="nav-item nav-link {{ Request::path() == '/' ? 'active' : '' }}">Home</a>
                  <a href="#tentang-desa"
                      class="nav-item nav-link {{ Request::path() == 'tentang-desa' ? 'active' : '' }}">Tentang Desa</a>
                  <a href="#profile-desa"
                      class="nav-item nav-link {{ Request::path() == 'profile-desa' ? 'active' : '' }}">Profile Desa</a>
                  <div class="nav-item dropdown">
                      <a href="#pemerintahan" class="nav-link dropdown-toggle"
                          data-bs-toggle="dropdown">Pemerintahan</a>
                      <div class="dropdown-menu m-0">
                          <a href="#pemerintahan-desa"
                              class="dropdown-item {{ Request::path() == 'pemerintahan-desa' ? 'active' : '' }}">Pemerintahan
                              Desa</a>
                          <a href="#pemerintahan-desa"
                              class="dropdown-item {{ Request::path() == 'pemerintahan-desa' ? 'active' : '' }}">Visi
                              dan Misi</a>
                      </div>
                  </div>
                  <div class="nav-item dropdown">
                      <a href="#data-desa" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">Data Desa</a>
                      <div class="dropdown-menu m-0">
                          <a href="#data-desa"
                              class="dropdown-item {{ Request::path() == 'data-desa' ? 'active' : '' }}">Statistik
                              Kependudukan</a>
                          <a href="#data-desa"
                              class="dropdown-item {{ Request::path() == 'data-desa' ? 'active' : '' }}">APBDes 2022</a>
                      </div>
                  </div>

                  <a href="#contact"
                      class="nav-item nav-link {{ Request::path() == 'contact' ? 'active' : '' }}">Hubungi
                      Kami</a>
              </div>
              <butaton type="button" class="btn text-secondary ms-3" data-bs-toggle="modal"
                  data-bs-target="#searchModal"><i class="fa fa-search"></i></butaton>
              <a href="/peta" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Peta Desa</a>
          </div>
      </nav>

      <div class="container-xxl py-5 bg-primary hero-header mb-5">
          <div class="container my-5 py-5 px-lg-5">
              <div class="row g-5 py-5">
                  <div class="col-lg-8 text-center text-lg-start">
                      <h1 class="text-white mb-4 animated zoomIn">Selamat Datang di
                          Website Desa Kalimas</h1>
                      <p class="text-white pb-3 animated zoomIn">Tempor rebum no at dolore lorem clita rebum rebum
                          ipsum rebum stet dolor sed justo kasd. Ut dolor sed magna dolor sea diam. Sit diam sit justo
                          amet ipsum vero ipsum clita lorem Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                          Vel incidunt voluptas tempora maiores. Vel fugit, cumque consequuntur maxime laboriosam error
                          consectetur enim perferendis ullam? Incidunt in repellendus minus excepturi itaque!
                          Tempor rebum no at dolore lorem clita rebum rebum
                          ipsum rebum stet dolor sed justo kasd. Ut dolor sed magna dolor sea diam. Sit diam sit justo
                          amet ipsum vero ipsum clita lorem Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                          Vel incidunt voluptas tempora maiores. Vel fugit, cumque consequuntur maxime laboriosam error
                          consectetur enim perferendis ullam? Incidunt in repellendus minus excepturi itaque!
                          Tempor rebum no at dolore lorem clita rebum rebum
                          ipsum rebum stet dolor sed justo kasd. Ut dolor sed magna dolor sea diam. Sit diam sit justo
                          amet ipsum vero ipsum clita lorem Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                          Vel incidunt voluptas tempora maiores. Vel fugit, cumque consequuntur maxime laboriosam error
                          consectetur enim perferendis ullam? Incidunt in repellendus minus excepturi itaque!</p>
                      <a href="/potensi"
                          class="btn btn-light py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Potensi Desa</a>
                      <a href="/peta"
                          class="btn btn-outline-light py-sm-3 px-sm-5 rounded-pill animated slideInRight">Peta
                          Desa</a>
                  </div>
                  <div class="col-lg-4 text-center text-lg-start">
                      <img class="img-fluid" src="user-rsc/img/logo_2.png"  alt="" width="600rem" height="600rem">
                  </div>
              </div>
          </div>
      </div>
  </div>
