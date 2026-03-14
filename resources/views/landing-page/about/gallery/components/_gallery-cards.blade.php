@if($postgallery->isEmpty())
{{-- Empty State --}}
<div class="gl-empty-state wow fadeIn" data-wow-delay="0.2s">
    <div class="gl-empty-icon">📷</div>
    <h4>Belum Ada Dokumentasi</h4>
    <p>Dokumentasi kegiatan akan segera hadir, insyaAllah.</p>
</div>

@else

{{-- ── Desktop Card List (d-none d-lg-block) ── --}}
<div class="d-none d-lg-block" id="gl-desktop-list">
    @foreach($postgallery as $idx => $post)
    @php
        $pcount   = count($glData[$idx]['photos']);
        $hasVideo = !empty($glData[$idx]['videoId']);
        $ytThumb  = $hasVideo ? 'https://img.youtube.com/vi/' . $glData[$idx]['videoId'] . '/maxresdefault.jpg' : '';
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
                @foreach($glData[$idx]['photos'] as $pidx => $pid)
                <div class="gl-grid-item" onclick="glOpenZoomInline({{ $idx }}, {{ $pidx }})">
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
                <div class="gl-video-thumb" onclick="glOpenVideo('{{ $glData[$idx]['videoId'] }}')">
                    <img src="{{ $ytThumb }}" alt="YouTube"
                         onerror="this.src='https://img.youtube.com/vi/{{ $glData[$idx]['videoId'] }}/hqdefault.jpg'">
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
</div>{{-- /desktop list --}}

{{-- ── Mobile List (d-lg-none) ── --}}
<div class="d-lg-none" id="gl-mobile-list">
    @foreach($postgallery as $idx => $post)
    @php
        $mpcount = count($glData[$idx]['photos']);
        $mthumb  = count($glData[$idx]['photos']) > 0 ? $glData[$idx]['photos'][0] : null;
        $mhasVid = !empty($glData[$idx]['videoId']);
    @endphp
    <div class="gl-mobile-card" data-gl-idx="{{ $idx }}" onclick="glOpenBottomSheet({{ $idx }})">
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
</div>{{-- /mobile list --}}

{{-- ── Pagination (reusable component) ── --}}
@include('components.pagination-custom.index', ['paginator' => $postgallery, 'itemLabel' => 'kegiatan'])

@endif
