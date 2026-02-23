@extends('landing-page.template.body')


@section('styles')
@include('landing-page.about.gallery.components._index-styles')
@endsection

@section('content')

{{-- =============================================
     HERO + GALLERY SECTION (merged, like contact-us)
     ============================================= --}}
<section class="gl-info-section hero-fun py-5 wow fadeIn" data-wow-delay="0.1s">

    {{-- ── Hero / Jumbotron Carousel (reusable component) ────────── --}}
    <x-hero-jumbotron>
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1Y4z7FlfDyACvm6jyaWvCQHNB_-1NgnVz"
                 alt="Galeri LDK Syahid" />
        </div>
    </x-hero-jumbotron>

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
