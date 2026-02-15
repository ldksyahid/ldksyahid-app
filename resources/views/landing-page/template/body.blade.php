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
        <div id="spinner" class="show position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex flex-column align-items-center justify-content-center" style="gap: 1.5rem; z-index: 99999;">
            <div class="spinner-fun-ldk">
                {{-- Orbit rings --}}
                <div class="ldk-ring ldk-ring-1"></div>
                <div class="ldk-ring ldk-ring-2"></div>
                {{-- Orbiting colored dots --}}
                <div class="ldk-dot-orbit ldk-dot-orbit-1"><span class="ldk-orbit-dot"></span></div>
                <div class="ldk-dot-orbit ldk-dot-orbit-2"><span class="ldk-orbit-dot"></span></div>
                <div class="ldk-dot-orbit ldk-dot-orbit-3"><span class="ldk-orbit-dot"></span></div>
                {{-- Logo center --}}
                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                     alt="LDK Syahid" class="ldk-spin-img">
            </div>
            {{-- Loading label --}}
            <div class="ldk-spin-label">
                <span class="ldk-spin-brand">LDK Syahid</span>
                <div class="ldk-spin-dots">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>

        <style>
            .spinner-fun-ldk {
                position: relative;
                width: 130px;
                height: 130px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .ldk-spin-img {
                width: 72px;
                height: 72px;
                border-radius: 18px;
                position: relative;
                z-index: 2;
                animation: ldkSpinPulse 2.2s ease-in-out infinite;
                box-shadow: 0 6px 24px rgba(0, 167, 157, 0.25);
            }

            .ldk-ring {
                position: absolute;
                inset: 0;
                border-radius: 50%;
                border: 2.5px solid transparent;
                pointer-events: none;
            }

            .ldk-ring-1 {
                border-top-color: #00a79d;
                border-right-color: #00a79d;
                animation: ldkOrbitFun 1.5s linear infinite;
                opacity: 0.7;
            }

            .ldk-ring-2 {
                inset: -12px;
                border-bottom-color: #f59e0b;
                border-left-color: #f59e0b;
                animation: ldkOrbitFun 2.2s linear infinite reverse;
                opacity: 0.5;
            }

            .ldk-dot-orbit {
                position: absolute;
                inset: -6px;
                border-radius: 50%;
                animation: ldkOrbitFun 2.8s linear infinite;
            }

            .ldk-dot-orbit-2 { animation-delay: -0.93s; }
            .ldk-dot-orbit-3 { animation-delay: -1.87s; }

            .ldk-orbit-dot {
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 9px;
                height: 9px;
                border-radius: 50%;
                display: block;
            }

            .ldk-dot-orbit-1 .ldk-orbit-dot { background: #00a79d; }
            .ldk-dot-orbit-2 .ldk-orbit-dot { background: #f59e0b; }
            .ldk-dot-orbit-3 .ldk-orbit-dot { background: #ec4899; }

            @keyframes ldkSpinPulse {
                0%, 100% { transform: scale(1); filter: drop-shadow(0 0 8px rgba(0,167,157,0.4)); }
                50%       { transform: scale(1.1); filter: drop-shadow(0 0 18px rgba(0,167,157,0.7)); }
            }

            @keyframes ldkOrbitFun {
                from { transform: rotate(0deg); }
                to   { transform: rotate(360deg); }
            }

            .ldk-spin-label {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }

            .ldk-spin-brand {
                font-weight: 700;
                font-size: 1rem;
                color: #1a1d1f;
                letter-spacing: -0.01em;
            }

            .ldk-spin-dots {
                display: flex;
                gap: 5px;
                align-items: center;
            }

            .ldk-spin-dots span {
                width: 7px;
                height: 7px;
                border-radius: 50%;
                animation: ldkDotBounce 0.7s ease-in-out infinite;
            }

            .ldk-spin-dots span:nth-child(1) { background: #00a79d; animation-delay: 0s; }
            .ldk-spin-dots span:nth-child(2) { background: #f59e0b; animation-delay: 0.12s; }
            .ldk-spin-dots span:nth-child(3) { background: #ec4899; animation-delay: 0.24s; }

            @keyframes ldkDotBounce {
                0%, 100% { transform: translateY(0); }
                50%       { transform: translateY(-7px); }
            }
        </style>

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
