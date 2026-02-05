<!DOCTYPE html>
<html lang="id">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        <title>{{ isset($title) ? $title : 'Default' }} &#9679; LDK Syahid</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="LDK Syahid, UIN Jakarta, Dakwah Kampus, Islam" name="keywords" />
        <meta content="Website resmi UKM LDK Syahid UIN Syarif Hidayatullah Jakarta" name="description" />
        <link href="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" rel="icon" />

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>

        {{-- Open Graph --}}
        @yield('openGraph')

        {{-- Icon Libraries --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>

        {{-- CSS Libraries --}}
        <link href="{{ asset('landing-page-ext-rsrc/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/lib/animate/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

        {{-- Custom CSS --}}
        <link href="{{ asset('landing-page-ext-rsrc/css/style.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('proker-counter-by-yuda-ext-rsrc/css/style-new.css') }}">
        <link href="{{ asset('css/itsupport.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/pagination.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/cardservice.css') }}" rel="stylesheet" />
        <link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />

        {{-- ReCaptcha --}}
        {!! ReCaptcha::htmlScriptTagJsApi() !!}

        {{-- Additional Scripts --}}
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
        <script src="{{ asset('proker-counter-by-yuda-ext-rsrc/js/code.js') }}" charset="utf-8" async></script>

        @yield('head')
    </head>

    <body id="body-lp">
        @yield('styles')

        {{-- Decorative Background Elements --}}
        <div class="decorative-bg">
            {{-- Floating shapes --}}
            <div class="deco-shape deco-circle-1"></div>
            <div class="deco-shape deco-circle-2"></div>
            <div class="deco-shape deco-circle-3"></div>
            <div class="deco-shape deco-blob-1"></div>
            <div class="deco-shape deco-blob-2"></div>

            {{-- Floating icons --}}
            <div class="deco-icon deco-icon-1"><i class="fas fa-star"></i></div>
            <div class="deco-icon deco-icon-2"><i class="fas fa-heart"></i></div>
            <div class="deco-icon deco-icon-3"><i class="fas fa-book-open"></i></div>
            <div class="deco-icon deco-icon-4"><i class="fas fa-mosque"></i></div>
            <div class="deco-icon deco-icon-5"><i class="fas fa-hands-praying"></i></div>
            <div class="deco-icon deco-icon-6"><i class="fas fa-crescent-moon"></i></div>
        </div>

        {{-- Spinner / Loader --}}
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-fun">
                <div class="spinner-bounce"></div>
                <div class="spinner-bounce"></div>
                <div class="spinner-bounce"></div>
            </div>
        </div>

        {{-- Main Content --}}
        <div id="photo">
            @include('landing-page.template.nav-bar')
            @yield('content')
            @include('landing-page.template.footer')
        </div>

        {{-- Back to Top Button --}}
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top">
            <i class="bi bi-arrow-up"></i>
        </a>

        {{-- JavaScript Libraries --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/owl.carousel.min.js') }}"></script>

        {{-- Custom JavaScript --}}
        <script src="{{ asset('landing-page-ext-rsrc/js/main.js') }}"></script>

        @yield('scripts')

        {{-- SweetAlert --}}
        @include('sweetalert::alert')

        @if(session('sweetalert_error'))
        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Akses Ditolak',
                text: 'Anda tidak memiliki izin untuk mengakses halaman ini.',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#00a79d'
            });
        </script>
        @endif
    </body>
</html>
