<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>
            404 Not Found &#9679; LDK Syahid
        </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="keywords" />
        <meta content="" name="description" />


        <!-- Favicon -->
        <link href="{{ asset('Images/Logos/logoldksyahid.png') }}" rel="icon" />
        {{-- <link rel="shortcut icon" href="{{ asset('proker-counter-by-yuda-ext-rsrc/images/kestari.ico') }}" type="image/x-icon"> --}}


        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap"
        rel="stylesheet"
        />

        <!-- Icon Font Stylesheet -->
        <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet"
        />
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
        rel="stylesheet"
        />

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('e404/css/bd-coming-soon.css') }}" rel="stylesheet" />
        <link href="{{ asset('e404/css/bd-coming-soon.css.map') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/lib/animate/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('proker-counter-by-yuda-ext-rsrc/css/style.css') }}">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('landing-page-ext-rsrc/css/bootstrap.min.css') }}" rel="stylesheet" />

        <!-- Template Stylesheet -->
        <link href="{{ asset('landing-page-ext-rsrc/css/style.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/"></script>
        <script src="{{ asset('proker-counter-by-yuda-ext-rsrc/js/code.js') }}" charset="utf-8" async></script>
    </head>

    <body>
        <!-- Spinner Start -->
        <div
        id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
        >
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->

        {{-- Body Landing Page Start --}}
        <!-- 404 Start -->
        <div class="container-xxl wow fadeInUp" data-wow-delay="0.1s" style="margin-top: 7%">
            <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-12 mb-5" >
                    <img src="https://lh3.googleusercontent.com/d/1K96icn3irTFOATLyqYgdfAvES8vorV2v" alt="" width="300" height="300">
                    <h1 class="mb-4">Halaman tidak ditemukan</h1>
                    <p class="mb-4">
                        Maaf, halaman yang Kamu cari tidak ada disini!
                    </p>
                    <a class="btn btn-primary py-3 px-5" href="/">Kembali ke Beranda</a>
                </div>
            </div>
            </div>
        </div>
        <!-- 404 End -->
        {{-- Body Landing Page End --}}

        <!-- JavaScript Libraries -->
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/owl.carousel.min.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('landing-page-ext-rsrc/js/main.js') }}"></script>
        {{-- Script Landing Page Start --}}
        @yield('scripts')
        {{-- Script Landing Page End --}}
        @include('sweetalert::alert')
    </body>
</html>
