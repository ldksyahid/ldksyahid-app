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
        <link href="{{ asset('Images/Logos/logoldksyahid.png') }}" rel="icon" />
        {!! ReCaptcha::htmlScriptTagJsApi() !!}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet"/>
        @yield('openGraph')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>
        <link rel="stylesheet" type="text/css" href="{{asset('landing-page-ext-rsrc/css/style.css')}}">
        <link href="{{ asset('landing-page-ext-rsrc/lib/animate/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('proker-counter-by-yuda-ext-rsrc/css/style.css') }}">
        <link href="{{ asset('landing-page-ext-rsrc/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/itsupport.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/cardservice.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/pagination.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/landing-page-mobile.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/css/style.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.js"></script>
        <script src="{{ asset('proker-counter-by-yuda-ext-rsrc/js/code.js') }}" charset="utf-8" async></script>
        @if((new \Jenssegers\Agent\Agent())->isMobile())
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        @endif
        @yield('head')
    </head>

    <body id="body-lp">

        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <div id="photo">
            @include('landing-page.template.nav-bar')
            @yield('content')
            @include('landing-page.template.footer')
        </div>
        <div id="arrow-up">
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top" style="border-radius: 100%;">
                <i class="bi bi-arrow-up"></i>
            </a>
        </div>

        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/js/main.js') }}"></script>
        @yield('scripts')
        @include('sweetalert::alert')
        @if((new \Jenssegers\Agent\Agent())->isMobile())
        <script src="{{ asset('js/landing-page-owl-carousel-mobile.js') }}"></script>
        @endif
    </body>
</html>
