<!DOCTYPE html>
<html lang="id">
    <head>
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
        <link href="{{ asset('landing-page-ext-rsrc/css/style.css') }}" rel="stylesheet" />

        <style>
            :root {
                --err-primary: #00a79d;
                --err-primary-dark: #008f86;
                --err-primary-light: #e0f7f5;
                --err-accent: #f59e0b;
                --err-accent-pink: #ec4899;
                --err-bg: #f0faf9;
                --err-text: #1a2332;
                --err-muted: #6b7280;
            }

            body {
                font-family: 'Inter', sans-serif !important;
                background: var(--err-bg) !important;
                min-height: 100vh;
                overflow-x: hidden;
                display: flex;
                flex-direction: column;
                margin: 0;
            }

            /* Decorative floating shapes */
            .error-deco {
                position: fixed;
                inset: 0;
                pointer-events: none;
                z-index: 0;
                overflow: hidden;
            }

            .error-deco .shape {
                position: absolute;
                border-radius: 50%;
                opacity: 0.08;
            }

            .error-deco .shape-1 {
                width: 400px; height: 400px;
                background: var(--err-primary);
                top: -100px; right: -100px;
                animation: errFloat 8s ease-in-out infinite;
            }

            .error-deco .shape-2 {
                width: 300px; height: 300px;
                background: var(--err-accent);
                bottom: -80px; left: -80px;
                animation: errFloat 10s ease-in-out infinite reverse;
            }

            .error-deco .shape-3 {
                width: 200px; height: 200px;
                background: var(--err-accent-pink);
                top: 50%; left: 50%;
                transform: translate(-50%, -50%);
                animation: errFloat 12s ease-in-out infinite 2s;
            }

            @keyframes errFloat {
                0%, 100% { transform: translateY(0) scale(1); }
                50% { transform: translateY(-30px) scale(1.05); }
            }

            /* Main content area */
            .error-wrapper {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                z-index: 1;
                padding: 2rem 1rem;
            }

            .error-card {
                background: #fff;
                border-radius: 24px;
                box-shadow: 0 20px 60px rgba(0, 167, 157, 0.1), 0 1px 3px rgba(0, 0, 0, 0.05);
                padding: 3rem 2.5rem;
                max-width: 560px;
                width: 100%;
                text-align: center;
                position: relative;
                overflow: hidden;
            }

            .error-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 4px;
                background: linear-gradient(90deg, var(--err-primary), var(--err-accent), var(--err-accent-pink));
            }

            .error-icon-wrap {
                width: 120px;
                height: 120px;
                margin: 0 auto 1.5rem;
                background: var(--err-primary-light);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                animation: errPulse 3s ease-in-out infinite;
            }

            .error-icon-wrap i {
                font-size: 3rem;
                color: var(--err-primary);
            }

            .error-icon-wrap::after {
                content: '';
                position: absolute;
                inset: -6px;
                border-radius: 50%;
                border: 2px dashed var(--err-primary);
                opacity: 0.3;
                animation: errSpin 15s linear infinite;
            }

            @keyframes errPulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }

            @keyframes errSpin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .error-code {
                font-size: 5rem;
                font-weight: 900;
                background: linear-gradient(135deg, var(--err-primary), var(--err-primary-dark));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                line-height: 1;
                margin-bottom: 0.5rem;
                letter-spacing: -2px;
            }

            .error-title {
                font-size: 1.5rem;
                font-weight: 700;
                color: var(--err-text);
                margin-bottom: 0.75rem;
            }

            .error-message {
                font-size: 1rem;
                color: var(--err-muted);
                line-height: 1.7;
                margin-bottom: 2rem;
            }

            .error-actions {
                display: flex;
                gap: 0.75rem;
                justify-content: center;
                flex-wrap: wrap;
            }

            .btn-err-primary {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.75rem;
                background: linear-gradient(135deg, var(--err-primary), var(--err-primary-dark));
                color: #fff !important;
                border: none;
                border-radius: 12px;
                font-size: 0.95rem;
                font-weight: 600;
                text-decoration: none !important;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
            }

            .btn-err-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
            }

            .btn-err-secondary {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.75rem;
                background: transparent;
                color: var(--err-primary) !important;
                border: 2px solid var(--err-primary);
                border-radius: 12px;
                font-size: 0.95rem;
                font-weight: 600;
                text-decoration: none !important;
                transition: all 0.3s ease;
            }

            .btn-err-secondary:hover {
                background: var(--err-primary-light);
                transform: translateY(-2px);
            }

            /* Mini Navbar */
            .error-navbar {
                padding: 1.25rem 2rem;
                position: relative;
                z-index: 2;
            }

            .error-navbar a {
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                text-decoration: none !important;
            }

            .error-navbar img {
                width: 40px;
                height: 40px;
                border-radius: 10px;
            }

            .error-navbar .brand-name {
                font-weight: 700;
                font-size: 1.1rem;
                color: var(--err-text);
            }

            .error-navbar .brand-tagline {
                font-size: 0.75rem;
                color: var(--err-muted);
                display: block;
            }

            /* Mini Footer */
            .error-footer {
                text-align: center;
                padding: 1.5rem;
                color: var(--err-muted);
                font-size: 0.85rem;
                position: relative;
                z-index: 1;
            }

            .error-footer a {
                color: var(--err-primary);
                text-decoration: none;
                font-weight: 600;
            }

            /* Responsive */
            @media (max-width: 576px) {
                .error-card { padding: 2rem 1.5rem; border-radius: 18px; }
                .error-code { font-size: 3.5rem; }
                .error-title { font-size: 1.25rem; }
                .error-icon-wrap { width: 90px; height: 90px; }
                .error-icon-wrap i { font-size: 2.2rem; }
                .error-navbar { padding: 1rem; }
            }
        </style>
    </head>

    <body>
        {{-- Decorative Background --}}
        <div class="error-deco">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>

        {{-- Minimal Navbar --}}
        <div class="error-navbar">
            <a href="/">
                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="LDK Syahid">
                <div>
                    <span class="brand-name">LDK Syahid</span>
                    <span class="brand-tagline">UIN Jakarta</span>
                </div>
            </a>
        </div>

        {{-- Error Content --}}
        <div class="error-wrapper">
            <div class="error-card wow fadeInUp" data-wow-delay="0.1s">
                <div class="error-icon-wrap">
                    <i class="@yield('icon', 'fas fa-exclamation-triangle')"></i>
                </div>
                <div class="error-code">@yield('code')</div>
                <h1 class="error-title">@yield('heading')</h1>
                <p class="error-message">@yield('description')</p>
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

        {{-- Footer --}}
        <div class="error-footer">
            &copy; {{ date('Y') }} <a href="/">LDK Syahid</a> UIN Syarif Hidayatullah Jakarta
        </div>

        {{-- Scripts --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/wow/wow.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new WOW().init();
            });
        </script>
    </body>
</html>
