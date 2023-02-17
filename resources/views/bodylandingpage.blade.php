<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        <title>
            {{ isset($title) ? $title : 'Default' }} &#9679; LDK Syahid
        </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="keywords" />
        <meta content="" name="description" />
        <!-- Favicon -->
        <link href="{{ asset('Images/Logos/logoldksyahid.png') }}" rel="icon" />
        {{-- <link rel="shortcut icon" href="{{ asset('KestariHitungProkerbyYuda/images/kestari.ico') }}" type="image/x-icon"> --}}
        {!! ReCaptcha::htmlScriptTagJsApi() !!}

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
        rel="stylesheet"
        />

        <!-- Libraries Stylesheet -->
        <link rel="stylesheet" type="text/css" href="{{asset('LandingPageSource/css/style.css')}}">
        <link href="{{ asset('LandingPageSource/lib/animate/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('LandingPageSource/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('KestariHitungProkerbyYuda/css/style.css') }}">


        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('LandingPageSource/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/itsupport.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/cardservice.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/pagination.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />


        <!-- Template Stylesheet -->
        <link href="{{ asset('LandingPageSource/css/style.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js"></script>
        <script src="{{ asset('KestariHitungProkerbyYuda/js/code.js') }}" charset="utf-8" async></script>

        @yield('style')
    </head>

    <body id="body-lp">
        <!-- Spinner Start -->
        <div
        id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
        >
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->
        <div id="photo">
            {{-- Navbar Landing Page Start --}}
            @include('LandingPageView/LandingPageViewTemplate/navbarladingpage')
            {{-- Navbar Landing Page End --}}

            {{-- Content Landing Page Start --}}
            @yield('content')
            {{-- Content Landing Page End --}}

            {{-- Footer Landing Page Start --}}
            @include('LandingPageView/LandingPageViewTemplate/footerladingpage')
            {{-- Footer Landing Page End --}}
        </div>

        <!-- Back to Top -->
        <div id="arrow-up">
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top" style="border-radius: 100%;">
                <i class="bi bi-arrow-up"></i>
            </a>
        </div>

        <!-- JavaScript Libraries -->
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('LandingPageSource/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('LandingPageSource/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('LandingPageSource/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('LandingPageSource/lib/owlcarousel/owl.carousel.min.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('LandingPageSource/js/main.js') }}"></script>
        {{-- Script Landing Page Start --}}
        @yield('scripts')
        {{-- Script Landing Page End --}}
        @include('sweetalert::alert')
    </body>
</html>
