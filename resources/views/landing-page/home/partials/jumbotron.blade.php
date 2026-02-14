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

                    {{-- Dark Overlay for readability --}}
                    <div class="hero-overlay-fun"></div>

                    {{-- Content (Desktop) --}}
                    <div class="hero-content-wrapper d-none d-lg-block">
                        <div class="container">
                            <div class="row justify-content-center justify-content-lg-start">
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
                         alt="Default" />
                </div>

                {{-- Mobile default content with Hadith API --}}
                <div class="hero-mobile-content d-lg-none" id="hadith-mobile-content">
                    <div class="hero-mobile-badge">
                        <span class="badge-icon">📖</span>
                        <span id="hadith-source">Hadits Harian</span>
                    </div>
                    <div class="hadith-content" id="hadith-content">
                        <p class="hero-mobile-arab" id="hadith-arab"></p>
                        <p class="hero-mobile-desc" id="hadith-text">Memuat hadits...</p>
                    </div>
                    <button class="hadith-toggle" id="hadith-toggle" style="display:none;"><span class="hadith-toggle-text">Selengkapnya</span> <i class="fas fa-chevron-down"></i></button>
                    <span class="hadith-number" id="hadith-number"></span>
                    <a href="#about-section" class="hero-mobile-btn">
                        <span>Kenali Kami</span>
                        <i class="fas fa-chevron-down"></i>
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        {{-- Fun Carousel Indicators --}}
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
    }

    @media (min-width: 992px) {
        .hero-carousel-wrapper {
            padding: 1.5rem 2.5rem;
        }

        .hero-carousel-card {
            border-radius: 32px;
        }
    }

    .hero-slide {
        min-height: 450px;
        height: 65vh;
        max-height: 650px;
        position: relative;
        display: flex;
        align-items: center;
    }

    .hero-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Overlay - only on slides with content */
    .hero-overlay-fun {
        display: none;
    }

    .hero-slide.has-content .hero-overlay-fun {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.45) 0%, rgba(0, 0, 0, 0.2) 50%, rgba(0, 0, 0, 0.35) 100%);
        z-index: 2;
    }

    .hero-content-wrapper {
        position: relative;
        z-index: 4;
        width: 100%;
        padding: 120px 0 80px;
    }

    .hero-content-box {
        text-align: center;
    }

    /* Badge */
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

    /* Title */
    .hero-title-fun {
        font-family: var(--font-primary);
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
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
        text-shadow: 1px 2px 10px rgba(0, 0, 0, 0.2);
    }

    /* Buttons */
    .hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
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
    .hero-btn-primary:active,
    .hero-btn-secondary:hover,
    .hero-btn-secondary:active {
        background: rgba(255, 255, 255, 0.35);
        color: white;
        transform: scale(1.1);
    }

    /* ===== Carousel Indicators ===== */
    .carousel-indicators-fun {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 5;
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
        position: relative;
    }

    .indicator-dot.active {
        width: 32px;
        border-radius: 50px;
        background: white;
    }

    .indicator-dot:not(.active):hover {
        background: rgba(255, 255, 255, 0.6);
    }

    /* Navigation Arrows */
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
        z-index: 5;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-nav-prev { left: 25px; }
    .carousel-nav-next { right: 25px; }

    .carousel-nav:hover,
    .carousel-nav:active {
        background: rgba(255, 255, 255, 0.35);
        transform: translateY(-50%) scale(1.15);
    }

    /* ===== Desktop Styles ===== */
    @media (min-width: 992px) {
        .hero-content-box {
            text-align: left;
        }

        .hero-title-fun {
            font-size: 3.5rem;
        }

        .hero-subtitle-fun {
            font-size: 1.2rem;
            margin-left: 0;
        }

        .hero-buttons {
            justify-content: flex-start;
        }

        .hero-badge {
            margin-bottom: 2rem;
        }
    }

    /* ===== Mobile Styles ===== */
    @media (max-width: 991.98px) {
        .hero-fun {
            padding-top: 65px;
        }

        .hero-carousel-wrapper {
            padding: 0.75rem;
        }

        .hero-carousel-card {
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            overflow: visible;
        }

        .hero-carousel-card .carousel-inner {
            border-radius: 20px 20px 0 0;
            overflow: hidden;
        }

        .hero-slide {
            min-height: 0;
            height: auto;
            max-height: none;
        }

        .hero-image {
            position: relative;
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .hero-slide.has-content .hero-overlay-fun {
            display: none;
        }


        .carousel-nav {
            width: 36px;
            height: 36px;
            font-size: 0.8rem;
        }

        .carousel-nav-prev { left: 10px; }
        .carousel-nav-next { right: 10px; }

        .carousel-nav:hover,
        .carousel-nav:active {
            transform: translateY(-50%) scale(1.15);
        }

        .carousel-indicators-fun {
            position: absolute;
            bottom: 12px;
            right: 12px;
            left: auto;
            transform: none;
            gap: 6px;
            z-index: 5;
        }

        .indicator-dot {
            width: 8px;
            height: 8px;
            background: rgba(0, 167, 157, 0.2);
        }

        .indicator-dot.active {
            width: 22px;
            background: var(--primary);
        }

        .indicator-dot:not(.active):hover {
            background: rgba(0, 167, 157, 0.4);
        }
    }

    /* ===== Mobile Content Below Image ===== */
    .hero-mobile-content {
        padding: 1rem 1.25rem 1.25rem;
        text-align: center;
        background: white;
        border-radius: 0 0 20px 20px;
        margin-top: -30px;
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
        margin-bottom: 0.6rem;
    }

    .hero-mobile-badge .badge-icon {
        font-size: 0.85rem;
    }

    .hero-mobile-title {
        font-family: var(--font-primary);
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
        margin-bottom: 0.5rem;
        direction: rtl;
        font-family: 'Amiri', 'Traditional Arabic', serif;
        transition: opacity 0.4s ease;
    }

    .hero-mobile-desc {
        font-size: 0.82rem;
        color: var(--gray);
        line-height: 1.5;
        margin-bottom: 0.5rem;
        transition: opacity 0.4s ease;
    }

    .hadith-number {
        display: block;
        font-size: 0.7rem;
        color: var(--primary);
        font-weight: 600;
        margin-bottom: 0.6rem;
        opacity: 0.7;
    }

    .hadith-content {
        max-height: 120px;
        overflow: hidden;
        position: relative;
        transition: max-height 0.4s ease, opacity 0.4s ease;
    }

    .hadith-content.expanded {
        max-height: 2000px;
    }

    .hadith-content:not(.expanded)::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 30px;
        background: linear-gradient(to bottom, transparent, white);
        pointer-events: none;
    }

    .hadith-toggle {
        background: none;
        border: none;
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0.2rem 0;
        margin-bottom: 0.4rem;
        outline: none;
        -webkit-tap-highlight-color: transparent;
    }

    .hadith-toggle:hover,
    .hadith-toggle:active,
    .hadith-toggle:focus {
        color: var(--primary);
        background: none;
        box-shadow: none;
        outline: none;
    }

    .hadith-toggle i {
        font-size: 0.6rem;
        margin-left: 0.2rem;
        transition: transform 0.3s ease;
    }

    .hadith-toggle.expanded i {
        transform: rotate(180deg);
    }

    .hadith-fade-out {
        opacity: 0;
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
    }

    .hero-mobile-btn:hover,
    .hero-mobile-btn:active {
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(0, 167, 157, 0.4);
    }

    .hero-mobile-btn i {
        font-size: 0.7rem;
        transition: transform 0.3s ease;
    }

    .hero-mobile-btn:hover i {
        transform: translateX(3px);
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('header-carousel');
    if (!carousel) return;

    // Update indicator dots on slide change
    carousel.addEventListener('slid.bs.carousel', function(e) {
        const dots = document.querySelectorAll('.indicator-dot');
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[e.to]) {
            dots[e.to].classList.add('active');
        }
    });

    // Hadith API - auto fetch random hadith every 10 seconds
    const hadithArab = document.getElementById('hadith-arab');
    const hadithText = document.getElementById('hadith-text');
    const hadithSource = document.getElementById('hadith-source');
    const hadithNumber = document.getElementById('hadith-number');
    const hadithContent = document.getElementById('hadith-content');
    const hadithToggle = document.getElementById('hadith-toggle');

    if (!hadithText) return;

    const books = [
        { id: 'bukhari', name: 'HR. Bukhari', max: 6638 },
        { id: 'muslim', name: 'HR. Muslim', max: 4930 },
        { id: 'abu-daud', name: 'HR. Abu Daud', max: 4419 },
        { id: 'tirmidzi', name: 'HR. Tirmidzi', max: 3625 },
        { id: 'ibnu-majah', name: 'HR. Ibnu Majah', max: 4285 },
        { id: 'nasai', name: 'HR. Nasai', max: 5364 },
    ];

    // Toggle expand/collapse
    const toggleText = hadithToggle ? hadithToggle.querySelector('.hadith-toggle-text') : null;
    if (hadithToggle) {
        hadithToggle.addEventListener('click', function() {
            const isExpanded = hadithContent.classList.toggle('expanded');
            hadithToggle.classList.toggle('expanded');
            if (toggleText) toggleText.textContent = isExpanded ? 'Sembunyikan' : 'Selengkapnya';
        });
    }

    function checkOverflow() {
        // Show toggle only if content overflows
        if (hadithContent.scrollHeight > 125) {
            hadithToggle.style.display = '';
        } else {
            hadithToggle.style.display = 'none';
        }
    }

    async function fetchRandomHadith() {
        try {
            const book = books[Math.floor(Math.random() * books.length)];
            const number = Math.floor(Math.random() * book.max) + 1;
            const res = await fetch(`https://api.hadith.gading.dev/books/${book.id}/${number}`);
            const json = await res.json();

            if (json.code === 200 && json.data && json.data.contents) {
                const contents = json.data.contents;

                // Fade out
                hadithContent.style.opacity = '0';

                setTimeout(() => {
                    // Reset to collapsed
                    hadithContent.classList.remove('expanded');
                    if (hadithToggle) {
                        hadithToggle.classList.remove('expanded');
                        if (toggleText) toggleText.textContent = 'Selengkapnya';
                    }

                    hadithArab.textContent = contents.arab;
                    hadithText.textContent = `"${contents.id}"`;
                    hadithSource.textContent = book.name;
                    hadithNumber.textContent = `${book.name} No. ${contents.number}`;

                    // Fade in
                    hadithContent.style.opacity = '1';

                    // Check if toggle needed
                    setTimeout(checkOverflow, 50);
                }, 400);
            }
        } catch (e) {
            hadithText.textContent = 'Membangun generasi muda yang berilmu, berakhlak, dan bermanfaat bagi umat.';
            hadithSource.textContent = 'LDK Syahid';
            hadithArab.textContent = '';
            hadithNumber.textContent = '';
            if (hadithToggle) hadithToggle.style.display = 'none';
        }
    }

    // Fetch first hadith immediately
    fetchRandomHadith();

    // Auto-rotate every 10 seconds
    setInterval(fetchRandomHadith, 10000);
});
</script>
