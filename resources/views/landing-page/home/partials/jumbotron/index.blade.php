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

@include('landing-page.home.partials.jumbotron.components._index-styles')
@include('landing-page.home.partials.jumbotron.components._index-scripts')
