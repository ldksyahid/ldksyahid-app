{{-- Jumbotron / Hero Section - Fun & Modern Design --}}
<section class="hero-fun">
    <div class="hero-carousel-wrapper wow fadeInUp" data-wow-delay="0.1s">
        <div id="header-carousel" class="carousel slide carousel-fade hero-carousel-card" data-bs-ride="carousel" data-bs-interval="60000">
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
                                            <span class="badge-icon">🎉</span>
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
                        <span class="badge-icon">🎉</span>
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
                    {{-- Countdown Timer - Bottom Right --}}
                    <div class="desktop-countdown">
                        <span>Hadits berikutnya dalam</span>
                        <span class="desktop-countdown-number" id="countdown-number-desktop">60</span>
                        <span>detik</span>
                    </div>

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10 col-xl-8">
                                <div class="hero-desktop-card">
                                    <div class="hero-desktop-badge">
                                        <span class="badge-icon">📖</span>
                                        <span id="hadith-source-desktop">Hadits Harian</span>
                                    </div>

                                    <div class="hadith-desktop-wrapper" id="hadith-desktop-wrapper">
                                        <p class="hero-desktop-arab" id="hadith-arab-desktop"></p>
                                        <p class="hero-desktop-text" id="hadith-text-desktop">Memuat hadits...</p>
                                        <span class="hero-desktop-number" id="hadith-number-desktop"></span>
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
                    <div class="hero-mobile-badge">
                        <span class="badge-icon">📖</span>
                        <span id="hadith-source-mobile">Hadits Harian</span>
                    </div>

                    <div class="hadith-mobile-wrapper" id="hadith-mobile-wrapper">
                        <p class="hero-mobile-arab" id="hadith-arab-mobile"></p>
                        <p class="hero-mobile-desc" id="hadith-text-mobile">Memuat hadits...</p>
                        <span class="hadith-number" id="hadith-number-mobile"></span>
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

        {{-- Carousel Indicators --}}
        @if(count($postjumbotron) > 1)
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

        {{-- Navigation Arrows --}}
        @if(count($postjumbotron) > 1)
        <button class="carousel-nav carousel-nav-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-nav carousel-nav-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </button>
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
        padding: 1.5rem 1.5rem 2.5rem;
        margin-top: -20px;
        position: relative;
        z-index: 5;
        border-radius: 0 0 32px 32px;
    }

    .hero-desktop-content::before {
        content: '';
        position: absolute;
        top: -30px;
        left: 0;
        width: 100%;
        height: 40px;
        background: white;
        border-radius: 50% 50% 0 0;
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
        z-index: 10;
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
    }

    .hadith-desktop-wrapper {
        max-height: 150px;
        overflow: hidden;
        position: relative;
        transition: max-height 0.5s ease;
        margin-bottom: 0.75rem;
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
    }

    .hero-desktop-arab {
        font-family: 'Amiri', 'Traditional Arabic', serif;
        font-size: 1.4rem;
        line-height: 2;
        color: var(--dark);
        margin-bottom: 0.75rem;
        direction: rtl;
        padding: 0 0.5rem;
    }

    .hero-desktop-text {
        font-size: 0.85rem;
        color: var(--gray);
        line-height: 1.6;
        margin-bottom: 0.35rem;
        font-style: italic;
    }

    .hero-desktop-number {
        display: block;
        font-size: 0.7rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.5rem;
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
        padding: 1.25rem 1.25rem 1rem;
        text-align: center;
        background: white;
        border-radius: 0 0 20px 20px;
        margin-top: -20px;
        position: relative;
        z-index: 4;
    }

    .hero-mobile-content::before {
        content: '';
        position: absolute;
        top: -20px;
        left: 0;
        width: 100%;
        height: 30px;
        background: white;
        border-radius: 30% 30% 0 0;
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
    }

    .hero-mobile-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--dark);
        line-height: 1.3;
        margin-bottom: 0.4rem;
    }

    .hero-mobile-arab {
        font-size: 1.1rem;
        color: var(--dark);
        line-height: 2;
        margin-bottom: 0.75rem;
        direction: rtl;
        font-family: 'Amiri', 'Traditional Arabic', serif;
        padding: 0 0.5rem;
    }

    .hero-mobile-desc {
        font-size: 0.85rem;
        color: var(--gray);
        line-height: 1.5;
        margin-bottom: 0.75rem;
        font-style: italic;
    }

    .hadith-mobile-wrapper {
        max-height: 150px;
        overflow: hidden;
        position: relative;
        transition: max-height 0.4s ease;
        margin-bottom: 1rem;
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
    }

    .hadith-number {
        display: block;
        font-size: 0.7rem;
        color: var(--primary);
        font-weight: 600;
        margin-top: 0.5rem;
        opacity: 0.7;
    }

    /* Mobile Action Area - Flex container for toggle and countdown */
    .mobile-action-area {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 0.5rem;
        padding: 0 0.25rem;
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

    /* Mobile Countdown - Now positioned in flex container */
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
    .carousel-indicators-fun {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 10;
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
        }

        .hero-slide {
            height: auto;
        }

        .hero-image {
            height: auto;
            max-height: 280px;
        }

        .carousel-nav {
            width: 36px;
            height: 36px;
            font-size: 0.8rem;
        }

        .carousel-nav-prev { left: 10px; }
        .carousel-nav-next { right: 10px; }

        .carousel-indicators-fun {
            bottom: 20px;
            right: 15px;
            left: auto;
            transform: none;
        }

        .indicator-dot {
            background: rgba(0, 167, 157, 0.2);
        }

        .indicator-dot.active {
            background: var(--primary);
        }
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

    // Hadith elements
    const desktopElements = {
        arab: document.getElementById('hadith-arab-desktop'),
        text: document.getElementById('hadith-text-desktop'),
        source: document.getElementById('hadith-source-desktop'),
        number: document.getElementById('hadith-number-desktop'),
        wrapper: document.getElementById('hadith-desktop-wrapper'),
        toggle: document.getElementById('hadith-toggle-desktop'),
        countdown: document.getElementById('countdown-number-desktop')
    };

    const mobileElements = {
        arab: document.getElementById('hadith-arab-mobile'),
        text: document.getElementById('hadith-text-mobile'),
        source: document.getElementById('hadith-source-mobile'),
        number: document.getElementById('hadith-number-mobile'),
        wrapper: document.getElementById('hadith-mobile-wrapper'),
        toggle: document.getElementById('hadith-toggle-mobile'),
        countdown: document.getElementById('countdown-number-mobile')
    };

    // Exit if no hadith elements
    if (!desktopElements.arab && !mobileElements.arab) return;

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

    // Toggle functionality
    function setupToggle(wrapper, toggleBtn) {
        if (!wrapper || !toggleBtn) return;

        toggleBtn.addEventListener('click', function() {
            const isExpanded = wrapper.classList.toggle('expanded');
            toggleBtn.classList.toggle('expanded');
            const textSpan = toggleBtn.querySelector('.toggle-text, .hadith-toggle-text');
            if (textSpan) {
                textSpan.textContent = isExpanded ? 'Sembunyikan' : 'Selengkapnya';
            }
        });
    }

    setupToggle(desktopElements.wrapper, desktopElements.toggle);
    setupToggle(mobileElements.wrapper, mobileElements.toggle);

    function checkOverflow(wrapper, toggleBtn) {
        if (!wrapper || !toggleBtn) return;

        if (wrapper.scrollHeight > 150) {
            toggleBtn.style.display = 'inline-flex';
        } else {
            toggleBtn.style.display = 'none';
        }
    }

    function updateCountdown() {
        if (desktopElements.countdown) {
            desktopElements.countdown.textContent = timeLeft;
        }
        if (mobileElements.countdown) {
            mobileElements.countdown.textContent = timeLeft;
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

    async function fetchRandomHadith() {
        try {
            // Fade out
            [desktopElements.wrapper, mobileElements.wrapper].forEach(w => {
                if (w) w.style.opacity = '0';
            });

            const book = books[Math.floor(Math.random() * books.length)];
            const number = Math.floor(Math.random() * book.max) + 1;
            const res = await fetch(`https://api.hadith.gading.dev/books/${book.id}/${number}`);
            const json = await res.json();

            setTimeout(() => {
                if (json.code === 200 && json.data && json.data.contents) {
                    const contents = json.data.contents;

                    // Reset expanded state
                    [desktopElements.wrapper, mobileElements.wrapper].forEach(w => {
                        if (w) {
                            w.classList.remove('expanded');
                            w.style.opacity = '1';
                        }
                    });

                    [desktopElements.toggle, mobileElements.toggle].forEach(t => {
                        if (t) {
                            t.classList.remove('expanded');
                            const textSpan = t.querySelector('.toggle-text, .hadith-toggle-text');
                            if (textSpan) textSpan.textContent = 'Selengkapnya';
                        }
                    });

                    // Update desktop
                    if (desktopElements.arab) desktopElements.arab.textContent = contents.arab;
                    if (desktopElements.text) desktopElements.text.textContent = `"${contents.id}"`;
                    if (desktopElements.source) desktopElements.source.textContent = book.name;
                    if (desktopElements.number) desktopElements.number.textContent = `${book.name} No. ${contents.number}`;

                    // Update mobile
                    if (mobileElements.arab) mobileElements.arab.textContent = contents.arab;
                    if (mobileElements.text) mobileElements.text.textContent = `"${contents.id}"`;
                    if (mobileElements.source) mobileElements.source.textContent = book.name;
                    if (mobileElements.number) mobileElements.number.textContent = `${book.name} No. ${contents.number}`;

                    // Check overflow
                    setTimeout(() => {
                        checkOverflow(desktopElements.wrapper, desktopElements.toggle);
                        checkOverflow(mobileElements.wrapper, mobileElements.toggle);
                    }, 100);

                    resetCountdown();
                }
            }, 300);
        } catch (e) {
            console.error('Error:', e);
            const defaultText = 'Membangun generasi muda yang berilmu, berakhlak, dan bermanfaat bagi umat.';

            if (desktopElements.text) desktopElements.text.textContent = defaultText;
            if (mobileElements.text) mobileElements.text.textContent = defaultText;

            if (desktopElements.source) desktopElements.source.textContent = 'LDK Syahid';
            if (mobileElements.source) mobileElements.source.textContent = 'LDK Syahid';

            if (desktopElements.arab) desktopElements.arab.textContent = '';
            if (mobileElements.arab) mobileElements.arab.textContent = '';

            if (desktopElements.number) desktopElements.number.textContent = '';
            if (mobileElements.number) mobileElements.number.textContent = '';

            [desktopElements.wrapper, mobileElements.wrapper].forEach(w => {
                if (w) w.style.opacity = '1';
            });

            [desktopElements.toggle, mobileElements.toggle].forEach(t => {
                if (t) t.style.display = 'none';
            });
        }
    }

    // Initialize
    fetchRandomHadith();
    startCountdown();

    // Cleanup
    window.addEventListener('beforeunload', function() {
        if (countdownInterval) clearInterval(countdownInterval);
    });
});
</script>
