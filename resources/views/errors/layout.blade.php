<!DOCTYPE html>
<html lang="id">
    <head>
        <script>(function(){if(localStorage.getItem('darkMode')==='enabled')document.documentElement.setAttribute('data-theme','dark');})()</script>
        <meta charset="utf-8" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
        <title>@yield('title') &#9679; LDK Syahid</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="LDK Syahid, UIN Jakarta" name="keywords" />
        <meta content="Halaman Error - LDK Syahid UIN Jakarta" name="description" />
        <link href="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" rel="icon" />

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>

        {{-- Icon Libraries --}}
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>

        {{-- CSS Libraries --}}
        <link href="{{ asset('landing-page-ext-rsrc/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/lib/animate/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/css/style-v1.0.0.css') }}" rel="stylesheet" />

        @include('errors.components._layout-styles')
    </head>

    <body>
        {{-- Animated Background Scene --}}
        <div class="error-scene">
            {{-- Blobs --}}
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>

            {{-- Floating particles --}}
            <div class="particle particle-1"></div>
            <div class="particle particle-2"></div>
            <div class="particle particle-3"></div>
            <div class="particle particle-4"></div>
            <div class="particle particle-5"></div>
            <div class="particle particle-6"></div>

            {{-- Background icons --}}
            <div class="bg-icon bg-icon-1"><i class="fas fa-star"></i></div>
            <div class="bg-icon bg-icon-2"><i class="fas fa-heart"></i></div>
            <div class="bg-icon bg-icon-3"><i class="fas fa-book-open"></i></div>
            <div class="bg-icon bg-icon-4"><i class="fas fa-mosque"></i></div>
            <div class="bg-icon bg-icon-5"><i class="fas fa-moon"></i></div>
        </div>

        {{-- Navbar --}}
        <div class="error-navbar">
            <a href="/">
                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="LDK Syahid">
                <div>
                    <span class="brand-name">LDK Syahid</span>
                    <span class="brand-tagline">UIN Jakarta</span>
                </div>
            </a>
            <button id="errDarkToggle" class="error-dark-toggle" title="Mode Gelap">
                <i class="fas fa-moon"></i>
            </button>
        </div>

        {{-- Error Content --}}
        <div class="error-wrapper">
            <div class="error-card-glow">
            <div class="error-card">
                {{-- Animated Icon --}}
                <div class="error-icon-wrap">
                    <div class="error-icon-bg"></div>
                    <div class="orbit-dot orbit-dot-1"></div>
                    <div class="orbit-dot orbit-dot-2"></div>
                    <div class="orbit-dot orbit-dot-3"></div>
                    <i class="@yield('icon', 'fas fa-exclamation-triangle')"></i>
                </div>

                {{-- Emoji --}}
                <div class="error-emoji">@yield('emoji', '')</div>

                {{-- Error Code --}}
                <div class="error-code">
                    <span class="error-code-text">@yield('code')</span>
                    <span class="error-code-shadow" aria-hidden="true">@yield('code')</span>
                </div>

                {{-- Text --}}
                <h1 class="error-title">@yield('heading')</h1>
                <p class="error-message">@yield('description')</p>

                {{-- Actions --}}
                <div class="error-actions">
                    <a href="/" class="btn-err-primary">
                        <i class="fas fa-home"></i> Kembali ke Beranda
                    </a>
                    <a href="javascript:history.back()" class="btn-err-secondary">
                        <i class="fas fa-arrow-left"></i> Halaman Sebelumnya
                    </a>
                </div>
            </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="error-footer">
            &copy; {{ date('Y') }} <a href="/">LDK Syahid</a> UIN Syarif Hidayatullah Jakarta
        </div>

        {{-- Scripts --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/wow/wow.min.js') }}"></script>
        @include('errors.components._layout-scripts')
    </body>
</html>
