<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admin Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('admin-rsc/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-rsc/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-rsc/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-rsc/css/style.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container-xxl position-relative bg-white d-flex p-0">
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        @include('layouts.admin.admin-sidebar')
        <div class="content">
            @include('layouts.admin.admin-navbar')
            @yield('content')
            <div class="container-fluid pt-4 px-4">
                <div class="bg-light rounded-top p-4">
                    <div class="row">
                        <div class="col-12 col-sm-6 text-center text-sm-start">
                            &copy; <a href="#">Sistem Informasi Desa Kalimas</a>, All Right Reserved.
                        </div>
                        <div class="col-12 col-sm-6 text-center text-sm-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="untan.ac.id">MBKM Smart Village Tanjungpura</a>
                            </br>
                            Distributed By <a class="border-bottom" href="">Kabupaten Kubu Raya</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin-rsc/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('admin-rsc/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('admin-rsc/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('admin-rsc/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin-rsc/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('admin-rsc/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('admin-rsc/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('admin-rsc/js/main.js') }}"></script>
</body>

</html>
