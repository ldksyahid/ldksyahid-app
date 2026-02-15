{{-- Jumbotron / Hero Section - Fun & Modern Design --}}
<section class="hero-fun">
    <div class="hero-carousel-wrapper wow fadeInUp" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide carousel-fade hero-carousel-card" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-inner">
            @forelse($postjumbotron as $key => $post)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <div class="hero-slide has-content">
                    <img class="hero-image"
                         src="https://lh3.googleusercontent.com/d/{{ $post->gdrive_id }}"
                         alt="{{ $post->title }}" />

                    {{-- Content Overlay (Desktop Only) --}}
                    <div class="hero-content-overlay d-none d-lg-block">
                        <div class="container h-100">
                            <div class="row h-100 align-items-center">
                                <div class="col-lg-8 col-xl-7">
                                    <div class="hero-content-box">
                                        <div class="hero-badge animate__animated animate__fadeInDown">
                                            <span class="badge-icon">👑</span>
                                            <span>LDK Syahid</span>
                                        </div>
                                        <h1 class="hero-title-fun animate__animated animate__fadeInUp">
                                            {{ $post->title }}
                                        </h1>
                                        @if ($post->description)
                                        <p class="hero-subtitle-fun animate__animated animate__fadeIn animate__delay-1s">
                                            {{ $post->description }}
                                        </p>
                                        @endif
                                        @if ($post->btnname && $post->btnlink)
                                        <div class="hero-buttons animate__animated animate__fadeInUp animate__delay-2s">
                                            <a href="{{ $post->btnlink }}" target="_blank" class="hero-btn-primary">
                                                <span>{{ $post->btnname }}</span>
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                            <a href="#about-section" class="hero-btn-secondary">
                                                <span>Kenali Kami</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Content (below image) --}}
                <div class="hero-mobile-content d-lg-none">
                    <div class="hero-mobile-badge">
                        <span class="badge-icon">👑</span>
                        <span>LDK Syahid</span>
                    </div>
                    <h2 class="hero-mobile-title">{{ $post->title }}</h2>
                    @if ($post->description)
                    <p class="hero-mobile-desc">{{ Str::limit($post->description, 100) }}</p>
                    @endif
                    @if ($post->btnname && $post->btnlink)
                    <a href="{{ $post->btnlink }}" target="_blank" class="hero-mobile-btn">
                        <span>{{ $post->btnname }}</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    @else
                    <a href="#about-section" class="hero-mobile-btn">
                        <span>Kenali Kami</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="carousel-item active">
                <div class="hero-slide">
                    <img class="hero-image"
                         src="https://lh3.googleusercontent.com/d/1Cur2mISU8cwkWcyBuiwv9aGYNTxsZMPo"
                         alt="Default Background" />
                </div>

                {{-- Desktop Hadith Content (Below Image) --}}
                <div class="hero-desktop-content d-none d-lg-block">
                    {{-- Background Animation & Icons --}}
                    <div class="hadith-background-animation">
                        <div class="floating-icon icon-1">📖</div>
                        <div class="floating-icon icon-2">🕌</div>
                        <div class="floating-icon icon-3">✨</div>
                        <div class="floating-icon icon-4">🌙</div>
                        <div class="floating-icon icon-5">⭐</div>
                        <div class="floating-icon icon-6">☪️</div>
                        <div class="floating-icon icon-7">📚</div>
                        <div class="floating-icon icon-8">🤲</div>
                        <div class="floating-shape shape-1"></div>
                        <div class="floating-shape shape-2"></div>
                    </div>

                    {{-- Countdown Timer - Bottom Right --}}
                    <div class="desktop-countdown">
                        <span>Hadits berikutnya dalam</span>
                        <span class="desktop-countdown-number" id="countdown-number-desktop">60</span>
                        <span>detik</span>
                    </div>

                    {{-- PEMBATAS SETENGAH LINGKARAN DENGAN WARNA PUTIH --}}
                    <div class="hero-divider-desktop"></div>

                    <div class="container position-relative" style="z-index: 20;">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xl-8">
                                <div class="hero-desktop-card">
                                    <div class="hero-desktop-badge">
                                        <span class="badge-icon">📖</span>
                                        <span class="hadith-fade-text" id="hadith-source-desktop">Hadits dalam 1 Menit</span>
                                    </div>

                                    <div class="hadith-desktop-wrapper" id="hadith-desktop-wrapper">
                                        <p class="hero-desktop-arab hadith-fade-text" id="hadith-arab-desktop"></p>
                                        <p class="hero-desktop-text hadith-fade-text" id="hadith-text-desktop">
                                            <span class="loading-text">Sedang Menyiapkan Hadits</span>
                                            <span class="loading-dots">
                                                <span class="dot">.</span>
                                                <span class="dot">.</span>
                                                <span class="dot">.</span>
                                            </span>
                                        </p>
                                        <span class="hero-desktop-number hadith-fade-text" id="hadith-number-desktop"></span>
                                    </div>

                                    <button class="desktop-toggle-btn" id="hadith-toggle-desktop">
                                        <span class="toggle-text">Selengkapnya</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mobile Hadith Content (Below Image) --}}
                <div class="hero-mobile-content d-lg-none" id="hadith-mobile-content">
                    {{-- Background Animation & Icons for Mobile --}}
                    <div class="hadith-background-animation mobile">
                        <div class="floating-icon icon-1">📖</div>
                        <div class="floating-icon icon-3">✨</div>
                        <div class="floating-icon icon-5">🕌</div>
                        <div class="floating-shape shape-1"></div>
                        <div class="floating-shape shape-2"></div>
                    </div>

                    {{-- PEMBATAS SETENGAH LINGKARAN MOBILE DENGAN WARNA PUTIH --}}
                    <div class="hero-divider-mobile"></div>

                    <div class="hero-mobile-badge">
                        <span class="badge-icon">📖</span>
                        <span class="hadith-fade-text" id="hadith-source-mobile">Hadits dalam 1 Menit</span>
                    </div>

                    <div class="hadith-mobile-wrapper" id="hadith-mobile-wrapper">
                        <p class="hero-mobile-arab hadith-fade-text" id="hadith-arab-mobile"></p>
                        <p class="hero-mobile-desc hadith-fade-text" id="hadith-text-mobile">
                            <span class="loading-text">Sedang Menyiapkan Hadits</span>
                            <span class="loading-dots">
                                <span class="dot">.</span>
                                <span class="dot">.</span>
                                <span class="dot">.</span>
                            </span>
                        </p>
                        <span class="hadith-number hadith-fade-text" id="hadith-number-mobile"></span>
                    </div>

                    <div class="mobile-action-area">
                        <button class="hadith-toggle" id="hadith-toggle-mobile">
                            <span class="hadith-toggle-text">Selengkapnya</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>

                        {{-- Mobile Countdown - Bottom Right --}}
                        <div class="mobile-countdown">
                            <span>Hadits berikutnya dalam</span>
                            <span class="mobile-countdown-number" id="countdown-number-mobile">60</span>
                            <span>detik</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Navigation Arrows --}}
        @if(count($postjumbotron) > 1)
        <button class="carousel-nav carousel-nav-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-nav carousel-nav-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </button>

        {{-- Carousel Indicators - inside carousel card, below mobile content --}}
        <div class="carousel-indicators-fun">
            @foreach($postjumbotron as $key => $post)
            <button type="button"
                    data-bs-target="#header-carousel"
                    data-bs-slide-to="{{ $key }}"
                    class="indicator-dot {{ $key === 0 ? 'active' : '' }}"
                    aria-label="Slide {{ $key + 1 }}">
            </button>
            @endforeach
        </div>
        @endif
        </div>
    </div>
</section>

<style>
    :root {
        --primary: #00a79d;
        --primary-dark: #008b82;
        --primary-light: #e0f7f5;
        --dark: #2c3e50;
        --gray: #7f8c8d;
    }

    .hero-fun {
        position: relative;
        overflow: visible;
        background: transparent;
        padding-top: 80px;
        margin-bottom: 0;
    }

    .hero-carousel-wrapper {
        padding: 1rem;
        background: transparent;
        margin-bottom: 0;
    }

    .hero-carousel-card {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        background: white;
    }

    @media (min-width: 992px) {
        .hero-carousel-wrapper {
            padding: 1.5rem 2.5rem;
        }

        .hero-carousel-card {
            border-radius: 32px;
        }
    }

    /* Slide Styles */
    .hero-slide {
        position: relative;
        width: 100%;
        overflow: hidden;
    }

    .hero-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: cover;
    }

    /* Desktop Image Height */
    @media (min-width: 992px) {
        .hero-slide {
            height: 550px;
        }

        .hero-image {
            height: 550px;
            object-fit: cover;
        }
    }

    /* Desktop Content Overlay (for regular posts) */
    .hero-content-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0.6) 100%);
        z-index: 2;
    }

    .hero-content-box {
        color: white;
        padding: 2rem;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        margin-bottom: 1.5rem;
        color: white;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .badge-icon {
        font-size: 1.1rem;
    }

    .hero-title-fun {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        line-height: 1.2;
        margin-bottom: 1rem;
        text-shadow: 2px 4px 20px rgba(0, 0, 0, 0.3);
    }

    .hero-subtitle-fun {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 2rem;
        max-width: 600px;
        line-height: 1.6;
        text-shadow: 1px 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .hero-btn-primary,
    .hero-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .hero-btn-primary:hover,
    .hero-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.35);
        color: white;
        transform: scale(1.05);
    }

    /* Desktop Hadith Content */
    .hero-desktop-content {
        background: white;
        padding: 0 1.5rem 2.5rem;
        margin-top: -20px;
        position: relative;
        z-index: 5;
        border-radius: 0 0 32px 32px;
        overflow: visible;
    }

    /* PEMBATAS DESKTOP - WARNA PUTIH */
    .hero-divider-desktop {
        position: absolute;
        top: -40px;
        left: -10px;
        width: calc(100% + 20px);
        height: 60px;
        background: white;
        border-radius: 50% 50% 0 0;
        z-index: 30;
    }

    /* Background Animation & Icons - TIDAK TERPENGARUH FADE */
    .hadith-background-animation {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
        pointer-events: none;
        /* Tidak ada transition */
    }

    .floating-icon {
        position: absolute;
        font-size: 2.5rem;
        opacity: 0.25;
        color: var(--primary);
        animation: float 15s infinite ease-in-out;
        z-index: 1;
        pointer-events: none;
        filter: drop-shadow(0 2px 5px rgba(0,0,0,0.1));
        display: block;
        /* Tidak ada transition */
    }

    .floating-shape {
        position: absolute;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle at 30% 30%, var(--primary-light), transparent 70%);
        border-radius: 50%;
        opacity: 0.2;
        animation: pulse 20s infinite ease-in-out;
        z-index: 1;
        pointer-events: none;
        filter: blur(8px);
        display: block;
        mix-blend-mode: multiply;
        /* Tidak ada transition */
    }

    /* Floating Icons Positions - Desktop - DIPERBAIKI POSISINYA */
    .hadith-background-animation:not(.mobile) .icon-1 {
        top: 10%;
        left: 5%;
        animation-delay: 0s;
    }
    .hadith-background-animation:not(.mobile) .icon-2 {
        bottom: 15%;
        right: 8%;
        animation-delay: 2s;
        font-size: 2.5rem;
    }
    .hadith-background-animation:not(.mobile) .icon-3 {
        top: 25%;
        right: 15%;
        animation-delay: 4s;
        font-size: 1.8rem;
    }
    .hadith-background-animation:not(.mobile) .icon-4 {
        bottom: 20%;
        left: 12%;
        animation-delay: 6s;
        font-size: 2.2rem;
    }
    .hadith-background-animation:not(.mobile) .icon-5 {
        top: 40%;
        left: 20%;
        animation-delay: 8s;
    }
    .hadith-background-animation:not(.mobile) .icon-6 {
        top: 65%;
        right: 15%;
        animation-delay: 10s;
        font-size: 2.3rem;
    }
    .hadith-background-animation:not(.mobile) .icon-7 {
        bottom: 8%;
        left: 15%;
        animation-delay: 12s;
    }
    .hadith-background-animation:not(.mobile) .icon-8 {
        top: 20%;
        right: 25%;
        animation-delay: 14s;
        font-size: 2.4rem;
    }

    /* Floating Shapes Positions - Desktop - DIPERBAIKI POSISINYA */
    .hadith-background-animation:not(.mobile) .shape-1 {
        top: 20%;
        right: 10%;
        width: 150px;
        height: 150px;
        animation: pulse 18s infinite;
        background: radial-gradient(circle at 20% 20%, var(--primary-light), transparent 80%);
    }
    .hadith-background-animation:not(.mobile) .shape-2 {
        bottom: 10%;
        left: 5%;
        width: 120px;
        height: 120px;
        animation: pulse 22s infinite reverse;
        background: radial-gradient(circle at 80% 80%, var(--primary-light), transparent 80%);
    }

    /* Mobile Background Animation */
    .hadith-background-animation.mobile .icon-1 {
        top: 20%;
        left: 5%;
        font-size: 2rem;
        animation: float 12s infinite;
    }
    .hadith-background-animation.mobile .icon-3 {
        top: 15%;
        right: 10%;
        font-size: 1.8rem;
        animation: float 16s infinite 2s;
    }
    .hadith-background-animation.mobile .icon-5 {
        top: 40%;
        left: 15%;
        font-size: 1.9rem;
        animation: float 15s infinite 4s;
    }
    .hadith-background-animation.mobile .shape-1 {
        top: 20%;
        right: 5%;
        width: 90px;
        height: 90px;
        animation: pulse 15s infinite;
        background: radial-gradient(circle at 30% 30%, var(--primary-light), transparent 70%);
    }
    .hadith-background-animation.mobile .shape-2 {
        bottom: 5%;
        left: 10%;
        width: 60px;
        height: 60px;
        animation: pulse 18s infinite reverse;
        background: radial-gradient(circle at 70% 70%, var(--primary-light), transparent 70%);
    }

    /* Animasi yang lebih terlihat */
    @keyframes float {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        25% {
            transform: translateY(-20px) rotate(8deg);
        }
        50% {
            transform: translateY(15px) rotate(-8deg);
        }
        75% {
            transform: translateY(-8px) rotate(5deg);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 0.2;
        }
        50% {
            transform: scale(1.4);
            opacity: 0.35;
        }
    }

    /* Desktop Countdown - Bottom Right */
    .desktop-countdown {
        position: absolute;
        bottom: 20px;
        right: 30px;
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(6px);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.75rem;
        z-index: 40;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .desktop-countdown-number {
        font-weight: 700;
        color: #ffd700;
        margin: 0 2px;
    }

    .hero-desktop-card {
        max-width: 900px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        z-index: 35;
        padding-top: 30px;
    }

    .hero-desktop-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50px;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        z-index: 35;
    }

    .hadith-desktop-wrapper {
        max-height: 150px;
        overflow: hidden;
        position: relative;
        transition: max-height 0.5s ease;
        margin-bottom: 0.75rem;
        z-index: 35;
    }

    .hadith-desktop-wrapper.expanded {
        max-height: 2000px;
    }

    .hadith-desktop-wrapper:not(.expanded)::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        background: linear-gradient(to bottom, transparent, white);
        pointer-events: none;
        z-index: 36;
    }

    /* Smooth text transitions - HANYA UNTUK TEKS */
    .hadith-fade-text {
        transition: opacity 0.5s ease-in-out;
        opacity: 1;
    }

    .hadith-fade-text.fade-out {
        opacity: 0;
    }

    /* Loading animation styles */
    .loading-text {
        display: inline-block;
    }

    .loading-dots {
        display: inline-block;
        margin-left: 2px;
    }

    .dot {
        display: inline-block;
        animation: bounce 1.4s infinite;
        font-size: 1.2rem;
        line-height: 1;
    }

    .dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes bounce {
        0%, 60%, 100% {
            transform: translateY(0);
            opacity: 0.3;
        }
        30% {
            transform: translateY(-5px);
            opacity: 1;
        }
    }

    @keyframes navBubble {
        0% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.5;
        }
        100% {
            transform: translate(-50%, -50%) scale(2.8);
            opacity: 0;
        }
    }

    .hero-desktop-arab {
        font-family: 'Amiri', 'Traditional Arabic', serif;
        font-size: 1.4rem;
        line-height: 2;
        color: var(--dark);
        margin-bottom: 0.75rem;
        direction: rtl;
        padding: 0 0.5rem;
        position: relative;
        z-index: 35;
    }

    .hero-desktop-text {
        font-size: 0.85rem;
        color: var(--gray);
        line-height: 1.6;
        margin-bottom: 0.35rem;
        font-style: italic;
        position: relative;
        z-index: 35;
    }

    .hero-desktop-number {
        display: block;
        font-size: 0.7rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 35;
    }

    .desktop-toggle-btn {
        background: none;
        border: 1px solid var(--primary-light);
        color: var(--primary);
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        margin-top: 0.25rem;
        position: relative;
        z-index: 35;
    }

    .desktop-toggle-btn:hover,
    .desktop-toggle-btn:focus,
    .desktop-toggle-btn:active {
        background: transparent;
        border-color: var(--primary-light);
        color: var(--primary);
        transform: none;
        box-shadow: none;
        outline: none;
    }

    .desktop-toggle-btn i {
        transition: transform 0.3s ease;
        font-size: 0.7rem;
    }

    .desktop-toggle-btn.expanded i {
        transform: rotate(180deg);
    }

    /* Mobile Content Styles */
    .hero-mobile-content {
        padding: 0 1.25rem 1rem;
        text-align: center;
        background: white;
        border-radius: 0 0 20px 20px;
        margin-top: -20px;
        position: relative;
        z-index: 4;
        overflow: visible;
    }

    /* PEMBATAS MOBILE - WARNA PUTIH */
    .hero-divider-mobile {
        position: absolute;
        top: -30px;
        left: -5px;
        width: calc(100% + 10px);
        height: 45px;
        background: white;
        border-radius: 50% 50% 0 0;
        z-index: 30;
        box-shadow: 0 -3px 10px rgba(0, 0, 0, 0.02);
        border-bottom: 1px solid rgba(255, 255, 255, 0.5);
    }

    .hero-mobile-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 50px;
        padding: 0.3rem 0.85rem;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
        position: relative;
        z-index: 35;
        margin-top: 20px;
    }

    .hero-mobile-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.3;
        margin-bottom: 0.4rem;
        position: relative;
        z-index: 35;
    }

    .hero-mobile-arab {
        font-size: 1.1rem;
        color: var(--dark);
        line-height: 2;
        margin-bottom: 0.75rem;
        direction: rtl;
        font-family: 'Amiri', 'Traditional Arabic', serif;
        padding: 0 0.5rem;
        position: relative;
        z-index: 35;
    }

    .hero-mobile-desc {
        font-size: 0.85rem;
        color: var(--gray);
        line-height: 1.5;
        margin-bottom: 0.75rem;
        font-style: italic;
        position: relative;
        z-index: 35;
    }

    .hadith-mobile-wrapper {
        max-height: 150px;
        overflow: hidden;
        position: relative;
        transition: max-height 0.4s ease;
        margin-bottom: 1rem;
        z-index: 35;
    }

    .hadith-mobile-wrapper.expanded {
        max-height: 2000px;
    }

    .hadith-mobile-wrapper:not(.expanded)::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 40px;
        background: linear-gradient(to bottom, transparent, white);
        pointer-events: none;
        z-index: 36;
    }

    .hadith-number {
        display: block;
        font-size: 0.7rem;
        color: var(--primary);
        font-weight: 600;
        margin-top: 0.5rem;
        opacity: 0.7;
        position: relative;
        z-index: 35;
    }

    /* Mobile Action Area */
    .mobile-action-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
        padding: 0 0.25rem;
        position: relative;
        z-index: 35;
    }

    .hadith-toggle {
        background: none;
        border: 1px solid var(--primary-light);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0.4rem 1.2rem;
        outline: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .hadith-toggle:hover,
    .hadith-toggle:focus,
    .hadith-toggle:active {
        background: transparent;
        border-color: var(--primary-light);
        color: var(--primary);
        transform: none;
        box-shadow: none;
        outline: none;
    }

    .hadith-toggle i {
        font-size: 0.6rem;
        transition: transform 0.3s ease;
    }

    .hadith-toggle.expanded i {
        transform: rotate(180deg);
    }

    .mobile-countdown {
        background: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(6px);
        color: rgba(255, 255, 255, 0.85);
        padding: 0.3rem 0.9rem;
        border-radius: 50px;
        font-size: 0.65rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        white-space: nowrap;
        flex-shrink: 0;
        z-index: 40;
    }

    .mobile-countdown-number {
        font-weight: 700;
        color: #ffd700;
        margin: 0 2px;
    }

    .hero-mobile-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 0.55rem 1.25rem;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 167, 157, 0.3);
        margin-top: 0.5rem;
    }

    .hero-mobile-btn:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 167, 157, 0.4);
    }

    .hero-mobile-btn i {
        font-size: 0.7rem;
        transition: transform 0.3s ease;
    }

    .hero-mobile-btn:hover i {
        transform: translateX(3px);
    }

    /* Carousel Controls */
    .hero-carousel-wrapper {
        position: relative;
    }

    .carousel-indicators-fun {
        position: absolute;
        bottom: 42px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        z-index: 10;
        max-width: 80%;
    }

    .indicator-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        border: none;
        padding: 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .indicator-dot.active {
        width: 32px;
        border-radius: 50px;
        background: white;
    }

    .carousel-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-nav-prev { left: 25px; }
    .carousel-nav-next { right: 25px; }

    .carousel-nav:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-50%) scale(1.1);
    }

    /* Mobile Adjustments */
    @media (max-width: 991.98px) {
        .hero-fun {
            padding-top: 65px;
        }

        .hero-carousel-wrapper {
            padding: 0.75rem;
        }

        .hero-carousel-card {
            border-radius: 20px;
            overflow: hidden;
        }

        .hero-slide {
            height: auto;
        }

        .hero-image {
            height: 220px;
            object-fit: cover;
        }

        /* Dark nav buttons, scale only on click - no color change */
        .carousel-nav {
            width: 36px;
            height: 36px;
            font-size: 0.8rem;
            background: rgba(0, 0, 0, 0.45);
            border-color: rgba(255, 255, 255, 0.15);
            top: 110px; /* center of 220px image */
        }

        .carousel-nav::before,
        .carousel-nav::after {
            display: none;
        }

        .carousel-nav:hover,
        .carousel-nav:active {
            background: rgba(0, 0, 0, 0.45);
            transform: translateY(-50%) scale(1.2);
        }

        .carousel-nav-prev { left: 10px; }
        .carousel-nav-next { right: 10px; }

        /* Indicators inside card, below button */
        .carousel-indicators-fun {
            position: relative;
            bottom: auto;
            left: auto;
            transform: none;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 6px;
            padding: 0.5rem 1rem 1.25rem;
            max-width: 100%;
            background: white;
        }

        .indicator-dot {
            width: 8px;
            height: 8px;
            background: rgba(0, 167, 157, 0.25);
        }

        .indicator-dot.active {
            width: 20px;
            background: var(--primary);
        }
    }

    /* Background bubble circles - only for regular post slides, not default hadith */
    .hero-mobile-content:not(#hadith-mobile-content) {
        isolation: isolate;
    }

    .hero-mobile-content:not(#hadith-mobile-content)::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: inherit;
        background:
            radial-gradient(circle at 10% 20%, rgba(0,167,157,0.07) 0%, transparent 50%),
            radial-gradient(circle at 90% 15%, rgba(0,167,157,0.06) 0%, transparent 45%),
            radial-gradient(circle at 75% 80%, rgba(0,167,157,0.08) 0%, transparent 55%),
            radial-gradient(circle at 20% 85%, rgba(0,167,157,0.05) 0%, transparent 40%),
            radial-gradient(circle at 50% 50%, rgba(0,167,157,0.04) 0%, transparent 60%);
        pointer-events: none;
        z-index: 0;
    }

    .hero-mobile-content:not(#hadith-mobile-content) > * {
        position: relative;
        z-index: 1;
    }

    /* Desktop Text Alignment */
    @media (min-width: 992px) {
        .hero-content-box {
            text-align: left;
            padding-left: 3rem;
        }

        .hero-title-fun {
            font-size: 3.5rem;
        }
    }

    /* Small mobile devices */
    @media (max-width: 480px) {
        .mobile-action-area {
            flex-direction: column;
            gap: 0.75rem;
            align-items: stretch;
        }

        .mobile-countdown {
            align-self: flex-end;
        }

        .hadith-toggle {
            align-self: flex-start;
        }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('header-carousel');
    if (!carousel) return;

    // Update indicators
    carousel.addEventListener('slid.bs.carousel', function(e) {
        const dots = document.querySelectorAll('.indicator-dot');
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[e.to]) {
            dots[e.to].classList.add('active');
        }
    });

    // Function to get fresh elements (to handle DOM changes)
    function getFreshElements() {
        return {
            desktop: {
                arab: document.getElementById('hadith-arab-desktop'),
                text: document.getElementById('hadith-text-desktop'),
                source: document.getElementById('hadith-source-desktop'),
                number: document.getElementById('hadith-number-desktop'),
                wrapper: document.getElementById('hadith-desktop-wrapper'),
                toggle: document.getElementById('hadith-toggle-desktop'),
                countdown: document.getElementById('countdown-number-desktop')
            },
            mobile: {
                arab: document.getElementById('hadith-arab-mobile'),
                text: document.getElementById('hadith-text-mobile'),
                source: document.getElementById('hadith-source-mobile'),
                number: document.getElementById('hadith-number-mobile'),
                wrapper: document.getElementById('hadith-mobile-wrapper'),
                toggle: document.getElementById('hadith-toggle-mobile'),
                countdown: document.getElementById('countdown-number-mobile')
            }
        };
    }

    // Function to refresh text elements array - HANYA TEKS YANG MEMILIKI CLASS hadith-fade-text
    function getTextElements() {
        const elements = getFreshElements();
        const textElements = [];

        // Tambahkan elemen desktop yang memiliki class hadith-fade-text
        if (elements.desktop.arab && elements.desktop.arab.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.arab);
        if (elements.desktop.text && elements.desktop.text.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.text);
        if (elements.desktop.number && elements.desktop.number.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.number);
        if (elements.desktop.source && elements.desktop.source.classList.contains('hadith-fade-text'))
            textElements.push(elements.desktop.source);

        // Tambahkan elemen mobile yang memiliki class hadith-fade-text
        if (elements.mobile.arab && elements.mobile.arab.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.arab);
        if (elements.mobile.text && elements.mobile.text.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.text);
        if (elements.mobile.number && elements.mobile.number.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.number);
        if (elements.mobile.source && elements.mobile.source.classList.contains('hadith-fade-text'))
            textElements.push(elements.mobile.source);

        return textElements;
    }

    const books = [
        { id: 'bukhari', name: 'HR. Bukhari', max: 6638 },
        { id: 'muslim', name: 'HR. Muslim', max: 4930 },
        { id: 'abu-daud', name: 'HR. Abu Daud', max: 4419 },
        { id: 'tirmidzi', name: 'HR. Tirmidzi', max: 3625 },
        { id: 'ibnu-majah', name: 'HR. Ibnu Majah', max: 4285 },
        { id: 'nasai', name: 'HR. Nasai', max: 5364 },
    ];

    let timeLeft = 60;
    let countdownInterval;
    let isFetching = false;
    let retryCount = 0;
    const MAX_RETRY = 5;
    let retryTimeout = null;

    // Toggle functionality with event delegation
    function setupToggleListeners() {
        document.addEventListener('click', function(e) {
            // Desktop toggle
            if (e.target.closest('#hadith-toggle-desktop')) {
                const toggle = document.getElementById('hadith-toggle-desktop');
                const wrapper = document.getElementById('hadith-desktop-wrapper');
                if (toggle && wrapper) {
                    e.preventDefault();
                    const isExpanded = wrapper.classList.toggle('expanded');
                    toggle.classList.toggle('expanded');
                    const textSpan = toggle.querySelector('.toggle-text');
                    if (textSpan) {
                        textSpan.textContent = isExpanded ? 'Sembunyikan' : 'Selengkapnya';
                    }
                }
            }

            // Mobile toggle
            if (e.target.closest('#hadith-toggle-mobile')) {
                const toggle = document.getElementById('hadith-toggle-mobile');
                const wrapper = document.getElementById('hadith-mobile-wrapper');
                if (toggle && wrapper) {
                    e.preventDefault();
                    const isExpanded = wrapper.classList.toggle('expanded');
                    toggle.classList.toggle('expanded');
                    const textSpan = toggle.querySelector('.hadith-toggle-text');
                    if (textSpan) {
                        textSpan.textContent = isExpanded ? 'Sembunyikan' : 'Selengkapnya';
                    }
                }
            }
        });
    }

    function checkOverflow() {
        const desktopWrapper = document.getElementById('hadith-desktop-wrapper');
        const desktopToggle = document.getElementById('hadith-toggle-desktop');
        const mobileWrapper = document.getElementById('hadith-mobile-wrapper');
        const mobileToggle = document.getElementById('hadith-toggle-mobile');

        if (desktopWrapper && desktopToggle) {
            if (desktopWrapper.scrollHeight > 150) {
                desktopToggle.style.display = 'inline-flex';
            } else {
                desktopToggle.style.display = 'none';
            }
        }

        if (mobileWrapper && mobileToggle) {
            if (mobileWrapper.scrollHeight > 150) {
                mobileToggle.style.display = 'inline-flex';
            } else {
                mobileToggle.style.display = 'none';
            }
        }
    }

    function updateCountdown() {
        const desktopCountdown = document.getElementById('countdown-number-desktop');
        const mobileCountdown = document.getElementById('countdown-number-mobile');

        if (desktopCountdown) {
            desktopCountdown.textContent = timeLeft;
        }
        if (mobileCountdown) {
            mobileCountdown.textContent = timeLeft;
        }
    }

    function resetCountdown() {
        timeLeft = 60;
        updateCountdown();
    }

    function startCountdown() {
        if (countdownInterval) clearInterval(countdownInterval);

        countdownInterval = setInterval(() => {
            timeLeft--;
            updateCountdown();

            if (timeLeft <= 0) {
                timeLeft = 60;
                fetchRandomHadith();
            }
        }, 1000);
    }

    function fadeOutElements(callback) {
        const textElements = getTextElements();
        let completed = 0;
        const total = textElements.length;

        if (total === 0) {
            callback();
            return;
        }

        // Tambahkan class fade-out ke semua elemen
        textElements.forEach(el => {
            el.classList.add('fade-out');
        });

        // Tunggu transisi selesai
        const checkComplete = function() {
            completed++;
            if (completed === total) {
                callback();
            }
        };

        textElements.forEach(el => {
            const handler = function() {
                el.removeEventListener('transitionend', handler);
                checkComplete();
            };
            el.addEventListener('transitionend', handler);

            // Fallback jika transisi tidak berjalan
            setTimeout(() => {
                if (el.classList.contains('fade-out')) {
                    el.removeEventListener('transitionend', handler);
                    checkComplete();
                }
            }, 600);
        });
    }

    function fadeInElements() {
        const textElements = getTextElements();
        textElements.forEach(el => {
            el.classList.remove('fade-out');
        });
    }

    // Fungsi untuk menampilkan pesan error dengan retry count
    function showErrorMessage(message, showRetry = true) {
        const desktopText = document.getElementById('hadith-text-desktop');
        const mobileText = document.getElementById('hadith-text-mobile');
        const desktopSource = document.getElementById('hadith-source-desktop');
        const mobileSource = document.getElementById('hadith-source-mobile');
        const desktopArab = document.getElementById('hadith-arab-desktop');
        const mobileArab = document.getElementById('hadith-arab-mobile');
        const desktopNumber = document.getElementById('hadith-number-desktop');
        const mobileNumber = document.getElementById('hadith-number-mobile');
        const desktopToggle = document.getElementById('hadith-toggle-desktop');
        const mobileToggle = document.getElementById('hadith-toggle-mobile');

        let errorText = message;
        if (showRetry && retryCount > 0) {
            errorText = `${message} (Percobaan ke-${retryCount}/${MAX_RETRY})`;
        }

        if (desktopText) desktopText.innerHTML = errorText;
        if (mobileText) mobileText.innerHTML = errorText;

        if (desktopSource) desktopSource.textContent = 'Hadits dalam 1 Menit';
        if (mobileSource) mobileSource.textContent = 'Hadits dalam 1 Menit';

        if (desktopArab) desktopArab.textContent = '';
        if (mobileArab) mobileArab.textContent = '';

        if (desktopNumber) desktopNumber.textContent = '';
        if (mobileNumber) mobileNumber.textContent = '';

        if (desktopToggle) desktopToggle.style.display = 'none';
        if (mobileToggle) mobileToggle.style.display = 'none';
    }

    // Fungsi untuk retry dengan delay
    function scheduleRetry(delay = 3000) {
        if (retryTimeout) clearTimeout(retryTimeout);

        if (retryCount < MAX_RETRY) {
            retryTimeout = setTimeout(() => {
                fetchRandomHadith();
            }, delay);
        } else {
            // Jika sudah mencapai maksimal percobaan, tampilkan pesan dan reset counter
            showErrorMessage('Gagal memuat hadits setelah beberapa kali percobaan. Silakan refresh halaman.', false);
            retryCount = 0;
        }
    }

    async function fetchRandomHadith() {
        if (isFetching) return;
        isFetching = true;

        try {
            // Fade out semua teks
            await new Promise(resolve => {
                fadeOutElements(resolve);
            });

            const book = books[Math.floor(Math.random() * books.length)];
            const number = Math.floor(Math.random() * book.max) + 1;

            // Tambahkan timeout untuk fetch
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000);

            const res = await fetch(`https://api.hadith.gading.dev/books/${book.id}/${number}`, {
                signal: controller.signal
            }).finally(() => clearTimeout(timeoutId));

            const json = await res.json();

            if (json.code === 200 && json.data && json.data.contents) {
                retryCount = 0;
                const contents = json.data.contents;

                const desktopWrapper = document.getElementById('hadith-desktop-wrapper');
                const mobileWrapper = document.getElementById('hadith-mobile-wrapper');
                const desktopToggle = document.getElementById('hadith-toggle-desktop');
                const mobileToggle = document.getElementById('hadith-toggle-mobile');

                if (desktopWrapper) desktopWrapper.classList.remove('expanded');
                if (mobileWrapper) mobileWrapper.classList.remove('expanded');

                if (desktopToggle) {
                    desktopToggle.classList.remove('expanded');
                    const textSpan = desktopToggle.querySelector('.toggle-text');
                    if (textSpan) textSpan.textContent = 'Selengkapnya';
                }

                if (mobileToggle) {
                    mobileToggle.classList.remove('expanded');
                    const textSpan = mobileToggle.querySelector('.hadith-toggle-text');
                    if (textSpan) textSpan.textContent = 'Selengkapnya';
                }

                const desktopArab = document.getElementById('hadith-arab-desktop');
                const desktopText = document.getElementById('hadith-text-desktop');
                const desktopSource = document.getElementById('hadith-source-desktop');
                const desktopNumber = document.getElementById('hadith-number-desktop');

                if (desktopArab) desktopArab.textContent = contents.arab;
                if (desktopText) desktopText.innerHTML = `"${contents.id}"`;
                if (desktopSource) desktopSource.textContent = book.name;
                if (desktopNumber) desktopNumber.textContent = `${book.name} No. ${contents.number}`;

                const mobileArab = document.getElementById('hadith-arab-mobile');
                const mobileText = document.getElementById('hadith-text-mobile');
                const mobileSource = document.getElementById('hadith-source-mobile');
                const mobileNumber = document.getElementById('hadith-number-mobile');

                if (mobileArab) mobileArab.textContent = contents.arab;
                if (mobileText) mobileText.innerHTML = `"${contents.id}"`;
                if (mobileSource) mobileSource.textContent = book.name;
                if (mobileNumber) mobileNumber.textContent = `${book.name} No. ${contents.number}`;

                fadeInElements();

                setTimeout(() => {
                    checkOverflow();
                }, 100);

                resetCountdown();
            } else {
                throw new Error('Invalid response');
            }
        } catch (e) {
            console.error('Error:', e);

            retryCount++;

            let errorMessage = '';
            if (e.name === 'AbortError') {
                errorMessage = 'Timeout memuat hadits.';
            } else if (e.message === 'Failed to fetch') {
                errorMessage = 'Koneksi terputus.';
            } else {
                errorMessage = 'Gagal memuat hadits.';
            }

            showErrorMessage(errorMessage);
            fadeInElements();
            scheduleRetry(3000);

        } finally {
            isFetching = false;
        }
    }

    // Initialize dengan teks loading
    const desktopArab = document.getElementById('hadith-arab-desktop');
    const mobileArab = document.getElementById('hadith-arab-mobile');
    const desktopSource = document.getElementById('hadith-source-desktop');
    const mobileSource = document.getElementById('hadith-source-mobile');
    const desktopNumber = document.getElementById('hadith-number-desktop');
    const mobileNumber = document.getElementById('hadith-number-mobile');

    if (desktopArab) desktopArab.textContent = '';
    if (mobileArab) mobileArab.textContent = '';

    if (desktopSource) desktopSource.textContent = 'Hadits dalam 1 Menit';
    if (mobileSource) mobileSource.textContent = 'Hadits dalam 1 Menit';

    if (desktopNumber) desktopNumber.textContent = '';
    if (mobileNumber) mobileNumber.textContent = '';

    setupToggleListeners();

    setTimeout(() => {
        checkOverflow();
    }, 100);

    window.addEventListener('resize', function() {
        checkOverflow();
    });

    startCountdown();
    setTimeout(() => {
        fetchRandomHadith();
    }, 3000);
});
</script>
