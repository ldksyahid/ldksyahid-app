{{-- Gallery Section - Modern & Elegant --}}
<section class="gallery-elegant py-5" id="gallery-section">
    <div class="container">
        {{-- Section Header (Centered) --}}
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

        {{-- Gallery Items --}}
        @forelse($postgallery as $key => $gallery)
        <div class="gallery-item-elegant" style="--anim-delay: {{ $key * 0.1 }}s">
            {{-- Event Header --}}
            <div class="event-header-gal">
                <div class="event-info-gal">
                    <div class="event-badge-gal">
                        <span class="badge-icon">🎯</span>
                        <span>{{ $gallery->eventName }}</span>
                    </div>
                    <h3 class="event-title-gal">{{ $gallery->eventTheme }}</h3>
                    <p class="event-desc-gal d-none d-md-block">{{ $gallery->eventDescription }}</p>
                </div>
                @if (!empty($gallery->linkDoc))
                <a href="{{ $gallery->linkDoc }}" target="_blank" rel="noopener noreferrer" class="doc-link-gal">
                    <i class="fas fa-link"></i>
                    <span class="d-none d-md-inline">{{ \Illuminate\Support\Str::limit($gallery->linkDoc, 35, '...') }}</span>
                    <span class="d-md-none">Dokumentasi</span>
                    <i class="fas fa-external-link-alt ms-1"></i>
                </a>
                @endif
            </div>

            {{-- Desktop Gallery Grid --}}
            <div class="gallery-grid-desktop d-none d-lg-block">
                {{-- Main Image (Full Width Row) --}}
                @if ($gallery->gdrive_id)
                <div class="gallery-main-img-full">
                    <div class="img-wrapper-main">
                        <img src="https://lh3.googleusercontent.com/d/{{ $gallery->gdrive_id }}"
                             alt="{{ $gallery->eventTheme }}"
                             class="img-main-gal">
                    </div>
                </div>
                @endif

                {{-- Thumbnail Grid (Full Width Row) --}}
                <div class="gallery-thumbs-grid">
                    @php $thumbCount = 0; @endphp
                    @for($i = 1; $i <= 12; $i++)
                        @php $gdriveKey = 'gdrive_id_' . $i; @endphp
                        @if ($gallery->$gdriveKey && $thumbCount < 8)
                        @php $thumbCount++; @endphp
                        <div class="gallery-thumb-item">
                            <div class="img-wrapper-thumb">
                                <img src="https://lh3.googleusercontent.com/d/{{ $gallery->$gdriveKey }}"
                                     alt="Foto {{ $i }}"
                                     class="img-thumb-gal">
                            </div>
                        </div>
                        @endif
                    @endfor

                    {{-- Show remaining count if more than 8 --}}
                    @php
                        $totalImages = 0;
                        for($i = 1; $i <= 12; $i++) {
                            $gdriveKey = 'gdrive_id_' . $i;
                            if ($gallery->$gdriveKey) $totalImages++;
                        }
                        $remaining = $totalImages - 8;
                    @endphp
                    @if($remaining > 0 && isset($gallery->gdrive_id_9))
                    <div class="gallery-thumb-item">
                        <div class="img-wrapper-thumb more-wrapper">
                            <img src="https://lh3.googleusercontent.com/d/{{ $gallery->gdrive_id_9 }}"
                                 alt="More"
                                 class="img-thumb-gal">
                            <div class="more-overlay-count">
                                <span class="more-number">+{{ $remaining }}</span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Video Section (Desktop - Full Width Row) --}}
                @if ($gallery->linkEmbedYoutube)
                @php
                    $url = $gallery->linkEmbedYoutube;
                    $videoId = '';
                    if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
                        $videoId = $matches[1];
                    } elseif (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
                        $videoId = $matches[1];
                    } elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
                        $videoId = $matches[1];
                    }
                    $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : '';
                @endphp
                @if($videoId)
                <div class="gallery-video-section">
                    <a href="{{ $gallery->linkEmbedYoutube }}" class="glightbox-gal video-link-gal">
                        <img src="{{ $thumbnailUrl }}"
                             class="video-thumb-gal"
                             alt="Video"
                             onerror="this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'">
                        <div class="video-play-overlay">
                            <div class="play-button-gal">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @endif
            </div>

            {{-- Mobile Grid (Show All Images) --}}
            <div class="gallery-mobile-grid d-lg-none">
                {{-- Main Image (Full Width) --}}
                @if ($gallery->gdrive_id)
                <div class="mobile-grid-main">
                    <div class="mobile-img-wrapper">
                        <img src="https://lh3.googleusercontent.com/d/{{ $gallery->gdrive_id }}"
                             alt="{{ $gallery->eventTheme }}"
                             class="mobile-img-main">
                    </div>
                </div>
                @endif

                {{-- Thumbnail Grid --}}
                <div class="mobile-grid-thumbs">
                    @for($i = 1; $i <= 12; $i++)
                        @php $gdriveKey = 'gdrive_id_' . $i; @endphp
                        @if ($gallery->$gdriveKey)
                        <div class="mobile-thumb-item">
                            <div class="mobile-thumb-wrapper">
                                <img src="https://lh3.googleusercontent.com/d/{{ $gallery->$gdriveKey }}"
                                     alt="Foto {{ $i }}"
                                     class="mobile-thumb-img">
                            </div>
                        </div>
                        @endif
                    @endfor
                </div>

                {{-- Video (Mobile) --}}
                @if ($gallery->linkEmbedYoutube && $videoId)
                <div class="mobile-video-wrapper">
                    <div class="mobile-video-card">
                        <div class="iframe-wrapper-mobile">
                            <iframe width="100%"
                                    height="100%"
                                    src="{{ $gallery->linkEmbedYoutube }}"
                                    title="Video"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state-gal">
            <div class="empty-icon-gal">📷</div>
            <h4 class="empty-title-gal">Dokumentasi Belum Tersedia</h4>
            <p class="empty-text-gal">Dokumentasi kegiatan akan segera hadir. Tunggu ya!</p>
        </div>
        @endforelse

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

@include('landing-page.home.partials.gallery.components._index-styles')
@include('landing-page.home.partials.gallery.components._index-scripts')
