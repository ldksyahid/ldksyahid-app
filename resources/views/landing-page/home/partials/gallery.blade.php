{{-- Gallery Section - Fun & Modern Design --}}
<section class="gallery-fun py-5">
    <div class="container">
        {{-- Section Header --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="section-badge-gallery">
                    <span class="badge-emoji">📸</span>
                    <span>Galeri</span>
                </div>
                <h2 class="section-title-fun">
                    Dokumentasi Kegiatan
                    <span class="title-camera">📷</span>
                </h2>
                <p class="section-description-fun">
                    Momen-momen seru dari kegiatan LDK Syahid yang penuh manfaat!
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/about/gallery" class="btn-view-all-gallery">
                    <span>Lihat Semua</span>
                    <i class="fas fa-images"></i>
                </a>
            </div>
        </div>

        {{-- Gallery Items --}}
        @forelse($postgallery as $gallery)
        <div class="gallery-card-fun wow fadeInUp" data-wow-delay="0.1s">
            {{-- Gallery Header --}}
            <div class="gallery-header">
                <div class="header-info">
                    <div class="event-badge-gallery">
                        <span class="badge-emoji">🎯</span>
                        <span>{{ $gallery->eventName }}</span>
                    </div>
                    <h4 class="gallery-title">{{ $gallery->eventTheme }}</h4>
                    <p class="gallery-desc d-none d-md-block">{{ $gallery->eventDescription }}</p>
                </div>

                @if (!empty($gallery->linkDoc))
                <a href="{{ $gallery->linkDoc }}" target="_blank" rel="noopener noreferrer" class="doc-link-fun">
                    <span class="link-emoji">🔗</span>
                    <span class="d-none d-md-inline">{{ \Illuminate\Support\Str::limit($gallery->linkDoc, 40, '...') }}</span>
                    <span class="d-md-none">Dokumentasi</span>
                    <i class="fas fa-external-link-alt"></i>
                </a>
                @endif
            </div>

            {{-- Gallery Grid --}}
            <div class="gallery-grid">
                {{-- Main Image --}}
                @if ($gallery->gdrive_id)
                <div class="gallery-main">
                    <div class="gallery-image-wrapper">
                        <img src="https://lh3.googleusercontent.com/d/{{ $gallery->gdrive_id }}"
                             alt="Main photo"
                             class="gallery-img-main">
                        <div class="image-overlay">
                            <span class="overlay-emoji">✨</span>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Additional Images --}}
                <div class="gallery-thumbs">
                    @for($i = 1; $i <= 12; $i++)
                        @php $gdriveKey = 'gdrive_id_' . $i; @endphp
                        @if ($gallery->$gdriveKey)
                        <div class="gallery-thumb-wrapper">
                            <img src="https://lh3.googleusercontent.com/d/{{ $gallery->$gdriveKey }}"
                                 alt="Photo {{ $i }}"
                                 class="gallery-img-thumb">
                            <div class="thumb-overlay">
                                <span class="thumb-emoji">📸</span>
                            </div>
                        </div>
                        @endif
                    @endfor
                </div>

                {{-- YouTube Video --}}
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
                    } elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $matches)) {
                        $videoId = $matches[1];
                    }

                    $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : '';
                @endphp
                @if($videoId)
                {{-- Desktop: Lightbox --}}
                <div class="gallery-video d-none d-lg-block">
                    <a href="{{ $gallery->linkEmbedYoutube }}" class="glightbox video-link-fun">
                        <div class="video-wrapper">
                            <img src="{{ $thumbnailUrl }}"
                                 class="video-thumbnail"
                                 alt="YouTube Thumbnail"
                                 onerror="this.onerror=null;this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'">
                            <div class="video-play-btn-fun">
                                <div class="play-circle">
                                    <i class="fas fa-play"></i>
                                </div>
                                <span class="play-text">Tonton Video 🎬</span>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Mobile/Tablet: Embed iframe --}}
                <div class="gallery-video-mobile d-lg-none">
                    <div class="video-badge">
                        <span>🎬</span>
                        <span>Video Dokumentasi</span>
                    </div>
                    <div class="iframe-wrapper">
                        <iframe width="100%"
                                height="200"
                                src="{{ $gallery->linkEmbedYoutube }}"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state-gallery wow fadeInUp" data-wow-delay="0.1s">
            <div class="empty-card">
                <div class="empty-emoji">🖼️</div>
                <h4 class="empty-title">Dokumentasi Belum Tersedia</h4>
                <p class="empty-text">Dokumentasi kegiatan akan segera hadir. Tunggu ya!</p>
                <div class="empty-decoration">
                    <span>📷</span>
                    <span>✨</span>
                    <span>🎬</span>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</section>

{{-- GLightbox --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            plyr: {
                css: 'https://cdn.plyr.io/3.7.8/plyr.css',
                js: 'https://cdn.plyr.io/3.7.8/plyr.js',
                config: {
                    ratio: '16:9',
                    controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen'],
                    fullscreen: { enabled: true, fallback: true, iosNative: false }
                }
            }
        });
    });
</script>

<style>
    .gallery-fun {
        background: transparent;
    }

    /* Section Badge */
    .section-badge-gallery {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0, 167, 157, 0.2);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
    }

    .section-title-fun {
        font-family: var(--font-primary);
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .title-camera {
        display: inline-block;
        animation: cameraFlash 1.5s ease-in-out infinite;
    }

    @keyframes cameraFlash {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }

    .section-description-fun {
        color: var(--secondary);
        font-size: 1rem;
    }

    /* View All Button */
    .btn-view-all-gallery {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        background: var(--primary-gradient);
        color: white;
        padding: 0.875rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
        transition: all 0.3s ease;
    }

    .btn-view-all-gallery:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
        color: white;
    }

    /* Gallery Card */
    .gallery-card-fun {
        background: white;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
        padding: 1.5rem;
    }

    /* Gallery Header */
    .gallery-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .header-info {
        flex: 1;
    }

    .event-badge-gallery {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.375rem 0.875rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .gallery-title {
        font-family: var(--font-primary);
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }

    .gallery-desc {
        color: var(--secondary);
        font-size: 0.9rem;
        line-height: 1.6;
        text-align: justify;
        margin: 0;
    }

    .doc-link-fun {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.625rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .doc-link-fun:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 167, 157, 0.2);
        color: var(--primary);
    }

    /* Gallery Grid */
    .gallery-grid {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* Main Image */
    .gallery-main {
        width: 100%;
    }

    .gallery-image-wrapper {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
    }

    .gallery-img-main {
        width: 100%;
        height: 300px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-image-wrapper:hover .gallery-img-main {
        transform: scale(1.05);
    }

    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.1) 0%, rgba(0, 143, 134, 0.2) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-image-wrapper:hover .image-overlay {
        opacity: 1;
    }

    .image-overlay .overlay-emoji {
        font-size: 2.5rem;
    }

    /* Thumbnail Grid */
    .gallery-thumbs {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.75rem;
    }

    .gallery-thumb-wrapper {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
    }

    .gallery-img-thumb {
        width: 100%;
        height: 100px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .gallery-thumb-wrapper:hover .gallery-img-thumb {
        transform: scale(1.1);
    }

    .thumb-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.8) 0%, rgba(0, 143, 134, 0.9) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-thumb-wrapper:hover .thumb-overlay {
        opacity: 1;
    }

    .thumb-emoji {
        font-size: 1.5rem;
    }

    /* Video Section */
    .gallery-video {
        margin-top: 1rem;
    }

    .video-link-fun {
        display: block;
        text-decoration: none;
    }

    .video-wrapper {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
    }

    .video-thumbnail {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .video-link-fun:hover .video-thumbnail {
        transform: scale(1.05);
    }

    .video-play-btn-fun {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .play-circle {
        width: 80px;
        height: 80px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(0, 167, 157, 0.4);
        transition: all 0.3s ease;
    }

    .play-circle i {
        color: white;
        font-size: 1.5rem;
        margin-left: 4px;
    }

    .video-link-fun:hover .play-circle {
        transform: scale(1.1);
        box-shadow: 0 12px 35px rgba(0, 167, 157, 0.5);
    }

    .play-text {
        background: white;
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Video Mobile */
    .gallery-video-mobile {
        margin-top: 1rem;
    }

    .video-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        color: var(--primary);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .iframe-wrapper {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .iframe-wrapper iframe {
        display: block;
    }

    /* Empty State */
    .empty-state-gallery {
        display: flex;
        justify-content: center;
    }

    .empty-card {
        background: white;
        border-radius: 24px;
        padding: 3rem;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.06);
        max-width: 500px;
        width: 100%;
    }

    .empty-emoji {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-title {
        font-family: var(--font-primary);
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: var(--secondary);
        margin-bottom: 1.5rem;
    }

    .empty-decoration {
        display: flex;
        justify-content: center;
        gap: 1rem;
        font-size: 1.5rem;
    }

    /* Mobile Responsive */
    @media (max-width: 991.98px) {
        .gallery-header {
            flex-direction: column;
        }

        .gallery-thumbs {
            grid-template-columns: repeat(3, 1fr);
        }

        .gallery-img-thumb {
            height: 80px;
        }

        .section-title-fun {
            font-size: 1.5rem;
        }

        .btn-view-all-gallery {
            width: 100%;
            justify-content: center;
        }

        .gallery-card-fun {
            padding: 1rem;
        }
    }

    @media (min-width: 992px) {
        .gallery-img-main {
            height: 500px;
        }

        .gallery-img-thumb {
            height: 180px;
        }
    }
</style>
