@extends('landing-page.template.body')


@section('styles')
@include('landing-page.about.gallery.components._index-styles')
@endsection

@section('content')

{{-- =============================================
     HERO + GALLERY SECTION (merged, like contact-us)
     ============================================= --}}
<section class="gl-info-section hero-fun py-5 wow fadeIn" data-wow-delay="0.1s">

    {{-- ── Hero / Jumbotron Carousel ────────────────────────── --}}
    <div class="hero-carousel-wrapper">
        <div class="hero-carousel-card">

            {{-- Banner Image --}}
            <div class="hero-slide">
                <img class="hero-image"
                     src="https://lh3.googleusercontent.com/d/1Y4z7FlfDyACvm6jyaWvCQHNB_-1NgnVz"
                     alt="Galeri LDK Syahid" />
            </div>

            {{-- Desktop Hadith --}}
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
                    <span class="desktop-countdown-number" id="gl-countdown-desktop">60</span>
                    <span>detik</span>
                </div>
                <div class="hero-divider-desktop"></div>
                <div class="container position-relative" style="z-index:20;">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-8">
                            <div class="hero-desktop-card">
                                <div class="hero-desktop-badge">
                                    <span class="badge-icon">📖</span>
                                    <span class="hadith-fade-text" id="gl-source-desktop">Hadits dalam 1 Menit</span>
                                </div>
                                <div class="hadith-desktop-wrapper" id="gl-wrapper-desktop">
                                    <p class="hero-desktop-arab hadith-fade-text" id="gl-arab-desktop"></p>
                                    <p class="hero-desktop-text hadith-fade-text" id="gl-text-desktop">
                                        <span class="loading-text">Sedang Menyiapkan Hadits</span>
                                        <span class="loading-dots">
                                            <span class="dot">.</span>
                                            <span class="dot">.</span>
                                            <span class="dot">.</span>
                                        </span>
                                    </p>
                                    <span class="hero-desktop-number hadith-fade-text" id="gl-num-desktop"></span>
                                </div>
                                <button class="desktop-toggle-btn" id="gl-toggle-desktop">
                                    <span class="toggle-text">Selengkapnya</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>{{-- /hero-desktop-content --}}

            {{-- Mobile Hadith --}}
            <div class="hero-mobile-content d-lg-none" id="gl-hadith-mobile-content">
                <div class="hadith-background-animation mobile">
                    <div class="floating-icon icon-1">📖</div>
                    <div class="floating-icon icon-3">✨</div>
                    <div class="floating-icon icon-5">🕌</div>
                    <div class="floating-shape shape-1"></div>
                    <div class="floating-shape shape-2"></div>
                </div>
                <div class="hero-divider-mobile"></div>
                <div class="hero-mobile-badge gl-hadith-badge-m">
                    <span class="badge-icon">📖</span>
                    <span class="hadith-fade-text" id="gl-source-mobile">Hadits dalam 1 Menit</span>
                </div>
                <div class="hadith-mobile-wrapper" id="gl-wrapper-mobile">
                    <p class="hero-mobile-arab hadith-fade-text" id="gl-arab-mobile"></p>
                    <p class="hero-mobile-desc hadith-fade-text" id="gl-text-mobile">
                        <span class="loading-text">Sedang Menyiapkan Hadits</span>
                        <span class="loading-dots">
                            <span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
                        </span>
                    </p>
                    <span class="hadith-number hadith-fade-text" id="gl-num-mobile"></span>
                </div>
                <div class="mobile-action-area">
                    <button class="hadith-toggle" id="gl-toggle-mobile">
                        <span class="hadith-toggle-text">Selengkapnya</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="mobile-countdown">
                        <span>Hadits berikutnya dalam</span>
                        <span class="mobile-countdown-number" id="gl-countdown-mobile">60</span>
                        <span>detik</span>
                    </div>
                </div>
            </div>{{-- /hero-mobile-content --}}

        </div>{{-- /hero-carousel-card --}}
    </div>{{-- /hero-carousel-wrapper --}}

    {{-- ── Gallery Section ─────────────────────────────────── --}}
    <div class="container mt-5" id="gl-gallery-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="gl-section-badge">
                <span>📸</span>
                <span>Galeri Kegiatan</span>
                <span class="gl-badge-pulse"></span>
            </div>
            <h2 class="gl-section-title mt-3">Dokumentasi Kegiatan</h2>
            <p class="gl-section-sub">Mengabadikan setiap momen berharga dalam perjalanan dakwah kami</p>
        </div>

        <div id="gl-cards-wrap">
            @include('landing-page.about.gallery.components._gallery-cards')
        </div>
    </div>{{-- /container --}}
</section>

{{-- =============================================
     VIDEO LIGHTBOX OVERLAY (YouTube embed)
     ============================================= --}}
<div class="gl-video-overlay" id="gl-video-overlay">
    <button class="gl-video-close" id="gl-video-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="gl-video-wrap">
        <iframe id="gl-video-iframe" src="" frameborder="0"
                allow="autoplay; encrypted-media; fullscreen"
                allowfullscreen></iframe>
    </div>
</div>

{{-- Photo Zoom Overlay --}}
<div class="gl-zoom-overlay" id="gl-zoom-overlay" role="dialog" aria-modal="true">
    <button class="gl-zoom-close" id="gl-zoom-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
    <button class="gl-zoom-prev" id="gl-zoom-prev" aria-label="Foto sebelumnya"><i class="fas fa-chevron-left"></i></button>
    <button class="gl-zoom-next" id="gl-zoom-next" aria-label="Foto berikutnya"><i class="fas fa-chevron-right"></i></button>
    <div class="gl-zoom-img-wrap">
        <img id="gl-zoom-img" src="" alt="Foto galeri">
    </div>
    <div class="gl-zoom-counter" id="gl-zoom-counter"></div>
</div>

{{-- =============================================
     MOBILE BOTTOM SHEET
     ============================================= --}}
<div class="gl-bs-backdrop" id="gl-bs-backdrop"></div>
<div class="gl-bottom-sheet" id="gl-bottom-sheet" role="dialog" aria-modal="true" aria-label="Galeri Kegiatan">
    <div class="gl-bs-handle"></div>
    <button class="gl-bs-close" id="gl-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="gl-bs-content" id="gl-bs-content">
        {{-- Populated by JS --}}
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* Gallery data — passed from Laravel to JS */
    var GL_DATA = @json($glData);
</script>
@include('landing-page.about.gallery.components._index-scripts')
@endsection
