@extends('landing-page.template.body')

@php
/* Pre-process gallery data for both Blade rendering and JS */
$glData = $postgallery->map(function ($post, $idx) {
    $photos = [];
    if ($post->gdrive_id) $photos[] = $post->gdrive_id;
    for ($i = 1; $i <= 12; $i++) {
        $k = 'gdrive_id_' . $i;
        if ($post->$k) $photos[] = $post->$k;
    }
    $vid = '';
    if ($post->linkEmbedYoutube) {
        $u = $post->linkEmbedYoutube;
        if      (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $u, $m)) $vid = $m[1];
        elseif  (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $u, $m)) $vid = $m[1];
        elseif  (preg_match('/youtu\.be\/([^\&\?\/]+)/', $u, $m)) $vid = $m[1];
        elseif  (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $u, $m)) $vid = $m[1];
    }
    return [
        'idx'     => $idx,
        'name'    => $post->eventName,
        'theme'   => $post->eventTheme,
        'desc'    => $post->eventDescription,
        'linkDoc' => $post->linkDoc ?? null,
        'photos'  => $photos,
        'videoId' => $vid,
    ];
})->values()->all();
@endphp

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
    <div class="container mt-5">

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

        @if($postgallery->isEmpty())
        {{-- Empty State --}}
        <div class="gl-empty-state wow fadeIn" data-wow-delay="0.2s">
            <div class="gl-empty-icon">📷</div>
            <h4>Belum Ada Dokumentasi</h4>
            <p>Dokumentasi kegiatan akan segera hadir, insyaAllah.</p>
        </div>

        @else

        {{-- ── Desktop Card List (d-none d-lg-block) — semua foto inline ── --}}
        <div class="d-none d-lg-block">
            @foreach($postgallery as $idx => $post)
            @php
                $pcount   = count($glData[$idx]['photos']);
                $hasVideo = !empty($glData[$idx]['videoId']);
                $ytThumb  = $hasVideo ? 'https://img.youtube.com/vi/' . $glData[$idx]['videoId'] . '/maxresdefault.jpg' : '';
            @endphp
            <div class="gl-event-card wow fadeInUp" data-wow-delay="{{ 0.1 + ($idx * 0.08) }}s">

                {{-- Gradient Header (replaces thin accent line) --}}
                <div class="gl-card-header">
                    <div class="gl-card-header-left">
                        <span class="gl-card-header-name">{{ $post->eventName }}</span>
                    </div>
                    <div class="gl-card-header-badges">
                        @if($hasVideo)
                        <span class="gl-video-badge"><i class="fab fa-youtube"></i> Video</span>
                        @endif
                        @if($pcount > 0)
                        <span class="gl-photo-count"><i class="fas fa-images"></i> {{ $pcount }} foto</span>
                        @endif
                    </div>
                </div>

                {{-- Card Body —  all content inline --}}
                <div class="gl-card-body">

                    <h3 class="gl-card-title">{{ $post->eventTheme }}</h3>
                    <p class="gl-card-desc">{{ $post->eventDescription }}</p>

                    {{-- All photos grid --}}
                    @if($pcount > 0)
                    <div class="gl-photo-grid">
                        @foreach($glData[$idx]['photos'] as $pidx => $pid)
                        <div class="gl-grid-item"
                             onclick="glOpenZoomInline({{ $idx }}, {{ $pidx }})">
                            <img src="https://lh3.googleusercontent.com/d/{{ $pid }}"
                                 alt="Foto {{ $pidx + 1 }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- YouTube — click buka lightbox embed --}}
                    @if($hasVideo)
                    <div class="gl-video-section">
                        <div class="gl-video-label">
                            <i class="fab fa-youtube"></i> Video Dokumentasi
                        </div>
                        <div class="gl-video-thumb"
                             onclick="glOpenVideo('{{ $glData[$idx]['videoId'] }}')">
                            <img src="{{ $ytThumb }}" alt="YouTube"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $glData[$idx]['videoId'] }}/hqdefault.jpg'">
                            <div class="gl-play-btn"><i class="fas fa-play"></i></div>
                        </div>
                    </div>
                    @endif

                    {{-- Doc link --}}
                    @if(!empty($post->linkDoc))
                    <div class="gl-card-footer">
                        <a href="{{ $post->linkDoc }}" target="_blank" rel="noopener" class="gl-doc-link">
                            <i class="fas fa-folder-open"></i>
                            <span>Dokumentasi Lengkap</span>
                        </a>
                    </div>
                    @endif

                </div>
            </div>
            @endforeach
        </div>{{-- /desktop list --}}

        {{-- ── Mobile Carousel (d-lg-none) ────────────────────────── --}}
        <div class="d-lg-none wow fadeInUp" data-wow-delay="0.2s">
            <div class="owl-carousel" id="gl-mobile-owl">
                @foreach($postgallery as $idx => $post)
                @php
                    $mpcount  = count($glData[$idx]['photos']);
                    $mthumb   = $glData[$idx]['photos'][0] ?? null;
                    $mhasVid  = !empty($glData[$idx]['videoId']);
                @endphp
                <div class="gl-mobile-card" onclick="glOpenBottomSheet({{ $idx }})">
                    @if($mthumb)
                    <div class="gl-mobile-thumb">
                        <img src="https://lh3.googleusercontent.com/d/{{ $mthumb }}"
                             alt="{{ $post->eventTheme }}" loading="lazy">
                        <div class="gl-mobile-thumb-overlay">
                            @if($mpcount > 0)
                            <span class="gl-m-count"><i class="fas fa-images"></i> {{ $mpcount }}</span>
                            @endif
                            @if($mhasVid)
                            <span class="gl-m-video"><i class="fab fa-youtube"></i></span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="gl-mobile-card-body">
                        <div class="gl-mobile-meta">
                            <span class="gl-m-tag">{{ Str::limit($post->eventName, 28) }}</span>
                        </div>
                        <h5 class="gl-m-title">{{ $post->eventTheme }}</h5>
                        <p class="gl-m-desc">{{ Str::limit($post->eventDescription, 100) }}</p>
                        <div class="gl-m-tap-hint">
                            <span>Ketuk untuk lihat galeri</span>
                            <i class="fas fa-hand-pointer"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="gl-owl-dots" id="gl-owl-dots"></div>
        </div>{{-- /mobile carousel --}}

        @endif
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
    const GL_DATA = @json($glData);
</script>
@include('landing-page.about.gallery.components._index-scripts')
@endsection
