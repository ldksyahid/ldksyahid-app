@php
    /* ── Persiapkan data galeri untuk JS (sama dengan about/gallery) ── */
    $homeGlData = [];
    foreach ($postgallery as $post) {
        $photos = [];
        if (!empty($post->gdrive_id)) $photos[] = $post->gdrive_id;
        for ($i = 1; $i <= 12; $i++) {
            $k = 'gdrive_id_' . $i;
            if (!empty($post->$k)) $photos[] = $post->$k;
        }

        $videoId = '';
        $url = $post->linkEmbedYoutube ?? '';
        if ($url) {
            if      (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $m))  $videoId = $m[1];
            elseif  (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $m)) $videoId = $m[1];
            elseif  (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $m))            $videoId = $m[1];
        }

        $homeGlData[] = [
            'name'    => $post->eventName        ?? '',
            'theme'   => $post->eventTheme       ?? '',
            'desc'    => $post->eventDescription ?? '',
            'photos'  => $photos,
            'videoId' => $videoId,
            'linkDoc' => $post->linkDoc          ?? '',
        ];
    }
@endphp

{{-- Gallery Section --}}
<section class="gallery-elegant py-5" id="gallery-section">
    <div class="container">

        {{-- Section Header --}}
        <div class="text-center mb-5 gallery-header-wrap">
            <div class="section-badge-gal">
                <span class="badge-emoji-gal">📸</span>
                <span>Galeri</span>
                <span class="badge-pulse-gal"></span>
            </div>
            <h2 class="section-title-gal">
                Dokumentasi <span class="title-highlight-gal">Kegiatan</span>
            </h2>
            <p class="section-description-gal">
                Momen-momen seru dari kegiatan LDK Syahid yang penuh manfaat!
            </p>
        </div>

        @if(count($postgallery) > 0)

        {{-- ── Desktop Card List ── --}}
        <div class="d-none d-lg-block" id="hgl-desktop-list">
            @foreach($postgallery as $idx => $post)
            @php
                $pcount   = count($homeGlData[$idx]['photos']);
                $hasVideo = !empty($homeGlData[$idx]['videoId']);
                $ytThumb  = $hasVideo
                    ? 'https://img.youtube.com/vi/' . $homeGlData[$idx]['videoId'] . '/maxresdefault.jpg'
                    : '';
            @endphp
            <div class="gl-event-card" data-gl-idx="{{ $idx }}">

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

                <div class="gl-card-body">
                    <h3 class="gl-card-title">{{ $post->eventTheme }}</h3>
                    <p class="gl-card-desc">{{ $post->eventDescription }}</p>

                    @if($pcount > 0)
                    <div class="gl-photo-grid">
                        @foreach($homeGlData[$idx]['photos'] as $pidx => $pid)
                        <div class="gl-grid-item" onclick="hglOpenZoomInline({{ $idx }}, {{ $pidx }})">
                            <img src="https://lh3.googleusercontent.com/d/{{ $pid }}"
                                 alt="Foto {{ $pidx + 1 }}" loading="lazy">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if($hasVideo)
                    <div class="gl-video-section">
                        <div class="gl-video-label">
                            <i class="fab fa-youtube"></i> Video Dokumentasi
                        </div>
                        <div class="gl-video-thumb" onclick="hglOpenVideo('{{ $homeGlData[$idx]['videoId'] }}')">
                            <img src="{{ $ytThumb }}" alt="YouTube"
                                 onerror="this.src='https://img.youtube.com/vi/{{ $homeGlData[$idx]['videoId'] }}/hqdefault.jpg'">
                            <div class="gl-play-btn"><i class="fas fa-play"></i></div>
                        </div>
                    </div>
                    @endif

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
        </div>{{-- /hgl-desktop-list --}}

        {{-- ── Mobile Card List ── --}}
        <div class="d-lg-none" id="hgl-mobile-list">
            @foreach($postgallery as $idx => $post)
            @php
                $mpcount = count($homeGlData[$idx]['photos']);
                $mthumb  = $mpcount > 0 ? $homeGlData[$idx]['photos'][0] : null;
                $mhasVid = !empty($homeGlData[$idx]['videoId']);
            @endphp
            <div class="gl-mobile-card" data-gl-idx="{{ $idx }}" onclick="hglOpenBottomSheet({{ $idx }})">
                @if($mthumb)
                <div class="gl-mobile-thumb">
                    <img src="https://lh3.googleusercontent.com/d/{{ $mthumb }}"
                         alt="{{ $post->eventTheme }}" loading="lazy">
                    <div class="gl-mobile-thumb-bottom">
                        <span class="gl-m-tag-img">{{ Str::limit($post->eventName, 22) }}</span>
                        <div class="gl-m-badges">
                            @if($mpcount > 0)
                            <span class="gl-m-count"><i class="fas fa-images"></i> {{ $mpcount }}</span>
                            @endif
                            @if($mhasVid)
                            <span class="gl-m-video"><i class="fab fa-youtube"></i></span>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="gl-mobile-card-no-thumb">
                    <span class="gl-m-tag">{{ Str::limit($post->eventName, 28) }}</span>
                </div>
                @endif
                <div class="gl-mobile-card-body">
                    <h5 class="gl-m-title">{{ $post->eventTheme }}</h5>
                    <p class="gl-m-desc">{{ Str::limit($post->eventDescription, 90) }}</p>
                    <div class="gl-m-tap-hint">
                        <span>Lihat galeri</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
            </div>
            @endforeach
        </div>{{-- /hgl-mobile-list --}}

        @else
        {{-- Empty State --}}
        <div class="gl-empty-state">
            <div class="gl-empty-icon">📷</div>
            <h4>Dokumentasi Belum Tersedia</h4>
            <p>Dokumentasi kegiatan akan segera hadir. Tunggu ya!</p>
        </div>
        @endif

        {{-- View All Button --}}
        @if(count($postgallery) > 0)
        <div class="text-center mt-5">
            <a href="/about/gallery" class="btn-view-all-gal">
                <span>Lihat Semua Galeri</span>
                <i class="fas fa-images"></i>
            </a>
        </div>
        @endif

    </div>
</section>

{{-- ── Overlays (di luar .container) ── --}}

{{-- Video Lightbox --}}
<div class="gl-video-overlay" id="hgl-video-overlay">
    <div class="gl-video-wrap">
        <iframe id="hgl-video-iframe" src="" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>
    </div>
    <button class="gl-video-close" id="hgl-video-close" aria-label="Tutup video">
        <i class="fas fa-times"></i>
    </button>
</div>

{{-- Photo Zoom Overlay --}}
<div class="gl-zoom-overlay" id="hgl-zoom-overlay">
    <div class="gl-zoom-img-wrap">
        <img id="hgl-zoom-img" src="" alt="Foto galeri">
    </div>
    <button class="gl-zoom-close" id="hgl-zoom-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
    <button class="gl-zoom-prev"  id="hgl-zoom-prev"  aria-label="Sebelumnya"><i class="fas fa-chevron-left"></i></button>
    <button class="gl-zoom-next"  id="hgl-zoom-next"  aria-label="Berikutnya"><i class="fas fa-chevron-right"></i></button>
    <div class="gl-zoom-counter"  id="hgl-zoom-counter"></div>
</div>

{{-- Mobile Bottom Sheet --}}
<div class="gl-bs-backdrop" id="hgl-bs-backdrop"></div>
<div class="gl-bottom-sheet"  id="hgl-bottom-sheet">
    <div class="gl-bs-handle"></div>
    <button class="gl-bs-close" id="hgl-bs-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
    <div class="gl-bs-content"  id="hgl-bs-content"></div>
</div>

<script>var HGL_DATA = {!! json_encode($homeGlData) !!};</script>

@include('landing-page.home.partials.gallery.components._index-styles')
@include('landing-page.home.partials.gallery.components._index-scripts')
