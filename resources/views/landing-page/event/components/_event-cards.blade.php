{{-- ===========================================================
     EVENT CARDS PARTIAL
     Rendered both on initial load and via AJAX.
     Variables required: $postevent (LengthAwarePaginator)
     =========================================================== --}}

@php
    $cardColors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#0ea5e9'];
    $now = \Carbon\Carbon::now();

    function evStatus($event, $now) {
        if ($event->start && $now->lt($event->start))
            return ['key' => 'upcoming', 'label' => 'Akan Datang',    'cls' => 'ev-status-upcoming'];
        if ($event->finished && $now->gt($event->finished) || (empty($event->start) || empty($event->finished)))
            return ['key' => 'past',     'label' => 'Telah Selesai',   'cls' => 'ev-status-past'];
        return     ['key' => 'ongoing',  'label' => 'Berlangsung',     'cls' => 'ev-status-ongoing'];
    }
@endphp


{{-- ── Desktop Grid (d-none d-lg-block) ───────────────────────── --}}
<div class="d-none d-lg-block">
    @if($postevent->isEmpty())
        <div class="ev-empty-state">
            <div class="ev-empty-visual">
                <div class="ev-empty-deco ev-empty-deco-1"></div>
                <div class="ev-empty-deco ev-empty-deco-2"></div>
                <div class="ev-empty-deco ev-empty-deco-3"></div>
                <div class="ev-empty-ring ev-empty-ring-1"></div>
                <div class="ev-empty-ring ev-empty-ring-2"></div>
                <div class="ev-empty-icon-wrap">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="ev-empty-sparkle ev-empty-sparkle-1">✨</span>
                    <span class="ev-empty-sparkle ev-empty-sparkle-2">🎪</span>
                    <span class="ev-empty-sparkle ev-empty-sparkle-3">🔍</span>
                </div>
            </div>
            <h4 class="ev-empty-title">Kegiatan Tidak Ditemukan</h4>
            <p class="ev-empty-sub">Coba ubah kata kunci atau hapus beberapa filter yang aktif</p>
            <div class="ev-empty-tips">
                <span class="ev-empty-tip">💡 Coba kata kunci lebih umum</span>
                <span class="ev-empty-tip">🗑️ Hapus beberapa filter</span>
                <span class="ev-empty-tip">📅 Coba tahun berbeda</span>
            </div>
        </div>
    @else
        <div class="ev-grid">
            @foreach($postevent as $event)
            @php
                $accent  = $cardColors[$loop->index % count($cardColors)];
                $excerpt = substr(strip_tags(html_entity_decode($event->broadcast)), 0, 110);
                if (strlen(strip_tags(html_entity_decode($event->broadcast))) > 110) $excerpt .= '…';
                $st = evStatus($event, $now);
                $isNew = $event->created_at && $event->created_at->gte($now->copy()->subDays(7));
            @endphp
            <div class="ev-card wow fadeInUp"
                 style="--ev-accent: {{ $accent }}"
                 data-wow-delay="0.{{ ($loop->index % 3 + 1) }}s">

                {{-- Poster Image --}}
                <a href="{{ $event->getEventUrl() }}" class="ev-card-img-wrap">
                    <img src="{{ $event->getPosterUrl() ?? 'https://placehold.co/400x300/e0f7f5/00a79d?text=Event' }}"
                         alt="{{ $event->title }}"
                         class="ev-card-img" loading="lazy">

                    {{-- Status badge --}}
                    <div class="ev-card-status {{ $st['cls'] }}">
                        @if($st['key'] !== 'past')<span class="ev-status-dot"></span>@endif
                        {{ $st['label'] }}
                    </div>

                    {{-- New badge --}}
                    @if($isNew)
                    <div class="ev-card-new-badge">Baru</div>
                    @endif

                    {{-- Date badge --}}
                    @if($event->start)
                    <div class="ev-card-date">
                        <span class="ev-card-date-num">{{ $event->start->format('d') }}</span>
                        <span class="ev-card-date-month">{{ $event->start->isoFormat('MMM') }}</span>
                    </div>
                    @endif
                </a>

                {{-- Card Body --}}
                <div class="ev-card-body">
                    <span class="ev-card-division">
                        <span class="ev-division-dot"></span>
                        {{ $event->division }}
                    </span>

                    <h3 class="ev-card-title">
                        <a href="{{ $event->getEventUrl() }}">{{ $event->title }}</a>
                    </h3>

                    @if($excerpt)
                    <p class="ev-card-excerpt">{{ $excerpt }}</p>
                    @endif

                    <div class="ev-card-meta">
                        @if($event->start)
                        <div class="ev-card-meta-row">
                            <i class="far fa-calendar-alt"></i>
                            <span>{{ $event->start->isoFormat('D MMMM Y') }}</span>
                        </div>
                        @endif
                        @if($event->place || $event->location)
                        <div class="ev-card-meta-row">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->place ?? $event->location }}</span>
                        </div>
                        @endif
                    </div>

                    <a href="{{ $event->getEventUrl() }}" class="ev-read-btn">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>

                    <div class="ev-card-share">
                        <span class="ev-card-share-label">Bagikan</span>
                        <div class="ev-card-share-btns">
                            <button class="ev-card-share-btn ev-card-share-btn--copy"
                                    title="Salin URL"
                                    data-url="{{ $event->getEventUrl() }}"
                                    onclick="evCopyUrl(this.dataset.url, event)">
                                <i class="fas fa-link"></i>
                            </button>
                            <button class="ev-card-share-btn ev-card-share-btn--wa"
                                    title="WhatsApp"
                                    data-url="{{ $event->getEventUrl() }}"
                                    data-title="{{ e($event->title) }}"
                                    onclick="evShareWa(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="ev-card-share-btn ev-card-share-btn--tw"
                                    title="X"
                                    data-url="{{ $event->getEventUrl() }}"
                                    data-title="{{ e($event->title) }}"
                                    onclick="evShareTw(this.dataset.url, this.dataset.title, event)">
                                <span class="xi">X</span>
                            </button>
                        </div>
                    </div>

                </div>{{-- /ev-card-body --}}
            </div>{{-- /ev-card --}}
            @endforeach
        </div>{{-- /ev-grid --}}
    @endif
</div>{{-- /desktop --}}


{{-- ── Mobile Carousel (d-lg-none) ─────────────────────────────── --}}
<div class="d-lg-none">
    @if($postevent->isEmpty())
        <div class="ev-empty-state">
            <div class="ev-empty-visual">
                <div class="ev-empty-deco ev-empty-deco-1"></div>
                <div class="ev-empty-deco ev-empty-deco-2"></div>
                <div class="ev-empty-ring ev-empty-ring-1"></div>
                <div class="ev-empty-ring ev-empty-ring-2"></div>
                <div class="ev-empty-icon-wrap">
                    <i class="fas fa-calendar-alt"></i>
                    <span class="ev-empty-sparkle ev-empty-sparkle-1">✨</span>
                    <span class="ev-empty-sparkle ev-empty-sparkle-2">🎪</span>
                </div>
            </div>
            <h4 class="ev-empty-title">Kegiatan Tidak Ditemukan</h4>
            <p class="ev-empty-sub">Coba ubah kata kunci atau hapus filter yang aktif</p>
            <div class="ev-empty-tips">
                <span class="ev-empty-tip">💡 Kata kunci lebih umum</span>
                <span class="ev-empty-tip">🗑️ Hapus filter</span>
            </div>
        </div>
    @else
        <div class="ev-mobile-carousel" id="ev-mobile-carousel">
            @foreach($postevent as $event)
            @php
                $accent  = $cardColors[$loop->index % count($cardColors)];
                $excerpt = substr(strip_tags(html_entity_decode($event->broadcast)), 0, 120);
                if (strlen(strip_tags(html_entity_decode($event->broadcast))) > 120) $excerpt .= '…';
                $st = evStatus($event, $now);
            @endphp
            <div class="ev-mobile-card"
                 style="--ev-accent: {{ $accent }}"
                 data-id="{{ $event->id }}"
                 data-title="{{ e($event->title) }}"
                 data-division="{{ e($event->division) }}"
                 data-date="{{ $event->start ? $event->start->isoFormat('dddd, D MMMM Y') : '-' }}"
                 data-location="{{ e($event->place ?? $event->location ?? '-') }}"
                 data-status="{{ $st['label'] }}"
                 data-status-cls="{{ $st['cls'] }}"
                 data-poster="{{ $event->getPosterUrl() ?? '' }}"
                 data-url="{{ $event->getEventUrl() }}"
                 data-excerpt="{{ e($excerpt) }}"
                 onclick="evOpenBottomSheet(this)">

                {{-- Thumbnail --}}
                <div class="ev-m-thumb">
                    <img src="{{ $event->getPosterUrl() ?? 'https://placehold.co/400x300/e0f7f5/00a79d?text=Event' }}"
                         alt="{{ $event->title }}" loading="lazy">
                    @if($event->start)
                    <div class="ev-card-date">
                        <span class="ev-card-date-num">{{ $event->start->format('d') }}</span>
                        <span class="ev-card-date-month">{{ $event->start->isoFormat('MMM') }}</span>
                    </div>
                    @endif
                    <div class="ev-card-status {{ $st['cls'] }} ev-status-sm">
                        @if($st['key'] !== 'past')<span class="ev-status-dot"></span>@endif
                        {{ $st['label'] }}
                    </div>
                    <div class="ev-m-tap-hint">Tap untuk detail 👆</div>
                </div>

                {{-- Card body --}}
                <div class="ev-m-body">
                    <span class="ev-m-division">{{ $event->division }}</span>
                    <h4 class="ev-m-title">{{ $event->title }}</h4>
                    @if($event->start)
                    <div class="ev-m-date">
                        <i class="far fa-calendar-alt"></i>
                        {{ $event->start->isoFormat('D MMM Y') }}
                    </div>
                    @endif
                    <div class="ev-card-share" style="margin-top:.5rem; padding-top:.6rem;">
                        <span class="ev-card-share-label">Bagikan</span>
                        <div class="ev-card-share-btns">
                            <button class="ev-card-share-btn ev-card-share-btn--copy"
                                    data-url="{{ $event->getEventUrl() }}"
                                    onclick="evCopyUrl(this.dataset.url, event)">
                                <i class="fas fa-link"></i>
                            </button>
                            <button class="ev-card-share-btn ev-card-share-btn--wa"
                                    data-url="{{ $event->getEventUrl() }}"
                                    data-title="{{ e($event->title) }}"
                                    onclick="evShareWa(this.dataset.url, this.dataset.title, event)">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button class="ev-card-share-btn ev-card-share-btn--tw"
                                    data-url="{{ $event->getEventUrl() }}"
                                    data-title="{{ e($event->title) }}"
                                    onclick="evShareTw(this.dataset.url, this.dataset.title, event)">
                                <span class="xi">X</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- /ev-mobile-card --}}
            @endforeach
        </div>{{-- /ev-mobile-carousel --}}

        {{-- Scroll indicator dots --}}
        <div class="ev-carousel-dots" id="ev-carousel-dots"></div>
    @endif
</div>{{-- /mobile --}}


{{-- ── Pagination ─────────────────────────────────────────────── --}}
<div class="ev-pagination-wrap mt-4">
    @include('components.pagination-custom.index', [
        'paginator'  => $postevent,
        'itemLabel'  => 'kegiatan',
    ])
</div>
