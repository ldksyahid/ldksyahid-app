{{-- ================================================================
     Hero / Jumbotron Carousel Component
     Usage:
       <x-hero-jumbotron>
           <div class="hero-slide">
               <img class="hero-image" src="..." alt="..." />
           </div>
       </x-hero-jumbotron>

     Include styles in @section('styles'):
       @include('components.hero-jumbotron.styles')

     Include scripts in @section('scripts'):
       @include('components.hero-jumbotron.scripts')
     ================================================================ --}}

<div class="hero-carousel-wrapper">
    <div class="hero-carousel-card">

        {{-- Hero slide — provided by parent via $slot --}}
        {{ $slot }}

        {{-- ── Desktop Hadith Content (d-none d-lg-block) ── --}}
        <div class="hero-desktop-content d-none d-lg-block">
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
            <div class="desktop-countdown">
                <span>Hadits berikutnya dalam</span>
                <span class="desktop-countdown-number" id="hj-countdown-desktop">60</span>
                <span>detik</span>
            </div>
            <div class="hero-divider-desktop"></div>
            <div class="container position-relative" style="z-index:20;">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-xl-8">
                        <div class="hero-desktop-card">
                            <div class="hero-desktop-badge">
                                <span class="badge-icon">📖</span>
                                <span class="hadith-fade-text" id="hj-source-desktop">Hadits dalam 1 Menit</span>
                            </div>
                            <div class="hadith-desktop-wrapper" id="hj-wrapper-desktop">
                                <p class="hero-desktop-arab hadith-fade-text" id="hj-arab-desktop"></p>
                                <p class="hero-desktop-text hadith-fade-text" id="hj-text-desktop">
                                    <span class="loading-text">Sedang Menyiapkan Hadits</span>
                                    <span class="loading-dots">
                                        <span class="dot">.</span>
                                        <span class="dot">.</span>
                                        <span class="dot">.</span>
                                    </span>
                                </p>
                                <span class="hero-desktop-number hadith-fade-text" id="hj-num-desktop"></span>
                            </div>
                            <button class="desktop-toggle-btn" id="hj-toggle-desktop">
                                <span class="toggle-text">Selengkapnya</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>{{-- /hero-desktop-content --}}

        {{-- ── Mobile Hadith Content (d-lg-none) ── --}}
        <div class="hero-mobile-content d-lg-none" id="hj-hadith-mobile-content">
            <div class="hadith-background-animation mobile">
                <div class="floating-icon icon-1">📖</div>
                <div class="floating-icon icon-3">✨</div>
                <div class="floating-icon icon-5">🕌</div>
                <div class="floating-shape shape-1"></div>
                <div class="floating-shape shape-2"></div>
            </div>
            <div class="hero-divider-mobile"></div>
            <div class="hero-mobile-badge">
                <span class="badge-icon">📖</span>
                <span class="hadith-fade-text" id="hj-source-mobile">Hadits dalam 1 Menit</span>
            </div>
            <div class="hadith-mobile-wrapper" id="hj-wrapper-mobile">
                <p class="hero-mobile-arab hadith-fade-text" id="hj-arab-mobile"></p>
                <p class="hero-mobile-desc hadith-fade-text" id="hj-text-mobile">
                    <span class="loading-text">Sedang Menyiapkan Hadits</span>
                    <span class="loading-dots">
                        <span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
                    </span>
                </p>
                <span class="hadith-number hadith-fade-text" id="hj-num-mobile"></span>
            </div>
            <div class="mobile-action-area">
                <button class="hadith-toggle" id="hj-toggle-mobile">
                    <span class="hadith-toggle-text">Selengkapnya</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="mobile-countdown">
                    <span>Hadits berikutnya dalam</span>
                    <span class="mobile-countdown-number" id="hj-countdown-mobile">60</span>
                    <span>detik</span>
                </div>
            </div>
        </div>{{-- /hero-mobile-content --}}

    </div>{{-- /hero-carousel-card --}}
</div>{{-- /hero-carousel-wrapper --}}
