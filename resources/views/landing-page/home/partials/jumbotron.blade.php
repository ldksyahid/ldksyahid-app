{{-- Jumbotron / Hero Section - Fun & Modern Design --}}
<section class="hero-fun">
    {{-- Decorative Elements --}}
    <div class="hero-decorations">
        <div class="hero-deco hero-deco-1"></div>
        <div class="hero-deco hero-deco-2"></div>
        <div class="hero-deco hero-deco-3"></div>
        <div class="hero-sparkle hero-sparkle-1">✨</div>
        <div class="hero-sparkle hero-sparkle-2">⭐</div>
        <div class="hero-sparkle hero-sparkle-3">🌟</div>
    </div>

    <div class="hero-carousel-wrapper">
        <div id="header-carousel" class="carousel slide carousel-fade hero-carousel-card" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($postjumbotron as $key => $post)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <div class="hero-slide">
                    <img class="hero-image"
                         src="https://lh3.googleusercontent.com/d/{{ $post->gdrive_id }}"
                         alt="{{ $post->title }}" />

                    {{-- Fun Gradient Overlay --}}
                    <div class="hero-overlay-fun"></div>

                    {{-- Content --}}
                    <div class="hero-content-wrapper">
                        <div class="container">
                            <div class="row justify-content-center justify-content-lg-start">
                                <div class="col-lg-8 col-xl-7">
                                    <div class="hero-content-box">
                                        {{-- Badge --}}
                                        <div class="hero-badge animate__animated animate__fadeInDown">
                                            <span class="badge-icon">🎉</span>
                                            <span>LDK Syahid</span>
                                        </div>

                                        {{-- Title --}}
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
                                            <a href="{{ $post->btnlink }}"
                                               target="_blank"
                                               class="hero-btn-primary">
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
            </div>
            @empty
            <div class="carousel-item active">
                <div class="hero-slide">
                    <img class="hero-image"
                         src="https://lh3.googleusercontent.com/d/1Cur2mISU8cwkWcyBuiwv9aGYNTxsZMPo"
                         alt="Default" />
                    <div class="hero-overlay-fun"></div>
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
                <span class="dot-fill"></span>
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
        padding-top: 80px; /* Space for navbar */
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
    }

    @media (min-width: 992px) {
        .hero-carousel-wrapper {
            padding: 1.5rem 2.5rem;
        }

        .hero-carousel-card {
            border-radius: 32px;
        }
    }

    /* Decorative Elements - Hidden as we use body decorations */
    .hero-decorations {
        display: none;
    }

    .hero-deco {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
    }

    .hero-deco-1 {
        width: 200px;
        height: 200px;
        background: var(--primary);
        top: 10%;
        right: -50px;
        animation: floatBubble 8s ease-in-out infinite;
    }

    .hero-deco-2 {
        width: 150px;
        height: 150px;
        background: var(--primary-dark);
        bottom: 20%;
        left: -30px;
        animation: floatBubble 10s ease-in-out infinite reverse;
    }

    .hero-deco-3 {
        width: 100px;
        height: 100px;
        background: var(--secondary);
        top: 50%;
        right: 10%;
        animation: floatBubble 12s ease-in-out infinite;
    }

    .hero-sparkle {
        position: absolute;
        font-size: 1.5rem;
        animation: sparkle 3s ease-in-out infinite;
    }

    .hero-sparkle-1 { top: 15%; left: 10%; animation-delay: 0s; }
    .hero-sparkle-2 { top: 30%; right: 15%; animation-delay: 1s; }
    .hero-sparkle-3 { bottom: 25%; left: 20%; animation-delay: 2s; }

    @keyframes floatBubble {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50% { transform: translate(20px, -30px) scale(1.1); }
    }

    @keyframes sparkle {
        0%, 100% { opacity: 0.3; transform: scale(1) rotate(0deg); }
        50% { opacity: 0.8; transform: scale(1.2) rotate(180deg); }
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

    /* Overlay removed for better image visibility */
    .hero-overlay-fun {
        display: none;
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
        border: 1px solid rgba(255, 255, 255, 0.2);
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
    }

    /* Buttons */
    .hero-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        justify-content: center;
    }

    .hero-btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: white;
        color: var(--primary);
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .hero-btn-primary:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 15px 50px rgba(0, 167, 157, 0.4);
    }

    .hero-btn-primary i {
        transition: transform 0.3s ease;
    }

    .hero-btn-primary:hover i {
        transform: translateX(5px);
    }

    .hero-btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: transparent;
        color: white;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .hero-btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: white;
        color: white;
    }

    /* Carousel Indicators */
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
        overflow: hidden;
    }

    .indicator-dot .dot-fill {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.3s ease;
    }

    .indicator-dot.active {
        width: 32px;
        border-radius: 50px;
        background: white;
    }

    .indicator-dot:hover .dot-fill {
        transform: scale(1);
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

    .carousel-nav:hover {
        background: white;
        color: var(--primary);
        transform: translateY(-50%) scale(1.1);
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .hero-content-box {
            text-align: left;
        }

        .hero-title-fun {
            font-size: 4rem;
        }

        .hero-subtitle-fun {
            font-size: 1.25rem;
            margin-left: 0;
        }

        .hero-buttons {
            justify-content: flex-start;
        }

        .hero-badge {
            margin-bottom: 2rem;
        }
    }

    /* Mobile Styles */
    @media (max-width: 991.98px) {
        .hero-fun {
            padding-top: 70px;
        }

        .hero-carousel-wrapper {
            padding: 1rem;
        }

        .hero-carousel-card {
            border-radius: 20px;
        }

        .hero-slide {
            min-height: 350px;
            height: 45vh;
            max-height: 450px;
        }

        .hero-decorations {
            display: none;
        }

        .carousel-nav {
            display: none;
        }

        .hero-title-fun {
            font-size: 1.75rem;
        }

        .hero-content-wrapper {
            padding: 80px 0 60px;
        }

        .hero-btn-primary,
        .hero-btn-secondary {
            padding: 0.75rem 1.25rem;
            font-size: 0.85rem;
        }

        .carousel-indicators-fun {
            bottom: 20px;
        }
    }
</style>
