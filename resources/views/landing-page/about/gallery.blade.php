@extends('landing-page.template.body')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1Y4z7FlfDyACvm6jyaWvCQHNB_-1NgnVz" alt="Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="container py-5">
    <div class="row">
        @forelse($postgallery as $post)
        <div class="col-12 mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="bg-white rounded-4 shadow p-4 rounded-custom shadow">
                <h6 class="text-primary">{{ $post->eventName }}</h6>
                <h3 class="mb-2">{{ $post->eventTheme }}</h3>
                <p class="text-muted" style="text-align: justify">{{ $post->eventDescription }}</p>

                @if (!empty($post->linkDoc))
                <p class="mt-2">Link Dokumentasi:
                    <a href="{{ $post->linkDoc }}" target="_blank" rel="noopener noreferrer">
                        {{ \Illuminate\Support\Str::limit($post->linkDoc, 70, '...') }}
                    </a>
                </p>
                @endif

                <div class="row g-3 mt-3">
                    @if ($post->gdrive_id)
                    <div class="col-lg-12">
                        <div class="position-relative overflow-hidden rounded-4 gallery-hover">
                            <img class="img-fluid w-100 rounded-4" src="https://lh3.googleusercontent.com/d/{{ $post->gdrive_id }}" alt="Main photo">
                        </div>
                    </div>
                    @endif

                    @for($i = 1; $i <= 12; $i++)
                        @php $gdriveKey = 'gdrive_id_' . $i; @endphp
                        @if ($post->$gdriveKey)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="overflow-hidden rounded-4 gallery-hover">
                                <img class="img-fluid w-100 rounded-4" src="https://lh3.googleusercontent.com/d/{{ $post->$gdriveKey }}" alt="Photo {{ $i }}">
                            </div>
                        </div>
                        @endif
                    @endfor

                    @if ($post->linkEmbedYoutube)
                    @php
                        // Improved YouTube video ID extraction
                        $url = $post->linkEmbedYoutube;
                        $videoId = '';

                        // Check for embed URL format
                        if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
                            $videoId = $matches[1];
                        }
                        // Check for regular URL format
                        elseif (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
                            $videoId = $matches[1];
                        }
                        // Check for youtu.be format
                        elseif (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
                            $videoId = $matches[1];
                        }
                        // Check for shortened youtu.be format
                        elseif (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $matches)) {
                            $videoId = $matches[1];
                        }

                        // Get thumbnail (try maxres first, then hqdefault as fallback)
                        $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : '';
                    @endphp
                    @if($videoId)
                    <div class="col-lg-12 mt-4">
                        <a href="{{ $post->linkEmbedYoutube }}" class="glightbox youtube-thumbnail">
                            <div class="position-relative rounded-4 overflow-hidden gallery-hover">
                                <img src="{{ $thumbnailUrl }}"
                                     class="img-fluid w-100 rounded-4"
                                     alt="YouTube Thumbnail"
                                     onerror="this.onerror=null;this.src='https://img.youtube.com/vi/{{ $videoId }}/hqdefault.jpg'">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center">
            <h4 class="text-muted">Dokumentasi Kegiatan Belum Tersedia</h4>
        </div>
        @endforelse
    </div>
</div>
@endsection

@section('styles')
<style>
.gallery-hover {
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border-radius: 1rem;
  cursor: pointer;
}

.gallery-hover:hover {
  transform: scale(1.03);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.rounded-custom {
  border-radius: 1.5rem;
}

.youtube-thumbnail {
    display: block;
    position: relative;
    transition: all 0.3s ease;
}

.youtube-thumbnail:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 70px;
    height: 70px;
    background: rgba(255, 0, 0, 0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0.9;
    transition: all 0.3s ease;
}

.play-button i {
    color: white;
    font-size: 30px;
    margin-left: 5px;
}

.youtube-thumbnail:hover .play-button {
    background: rgba(255, 0, 0, 1);
    transform: translate(-50%, -50%) scale(1.1);
}
</style>
@endsection

@section('scripts')
<!-- GLightbox CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

<!-- GLightbox JS -->
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
@endsection
