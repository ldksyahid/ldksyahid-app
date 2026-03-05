{{-- resources/views/landing-page/event/detail.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     OPEN GRAPH
     ══════════════════════════════════════════════════ --}}
@section('openGraph')
<meta property="og:title"       content="{{ $postevent->title }}" />
<meta property="og:type"        content="website" />
<meta property="og:url"         content="{{ url()->current() }}" />
<meta property="og:image"       content="{{ $postevent->getPosterUrl() ?? '' }}" />
<meta property="og:description" content="{{ substr(strip_tags($postevent->broadcast), 0, 160) }}" />
@endsection


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.event.components._detail-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')
@php
    use Carbon\Carbon;
    $now        = Carbon::now();
    $isUpcoming = $postevent->start    && $now->lt($postevent->start);
    $isPast     = $postevent->finished && $now->gt($postevent->finished);
    $isOngoing  = !$isUpcoming && !$isPast;
    $statusKey  = $isUpcoming ? 'upcoming' : ($isPast ? 'past' : 'ongoing');
    $statusLabel= $isUpcoming ? 'Akan Datang' : ($isPast ? 'Telah Selesai' : 'Berlangsung');
    $closeRegistCarbon = $postevent->closeRegist ? Carbon::parse($postevent->closeRegist) : null;
    $registOpen = !$isPast && (!$closeRegistCarbon || $now->lt($closeRegistCarbon));
    $canRegist  = $registOpen && $postevent->linkRegist;
@endphp

{{-- Reading progress bar --}}
<div class="ed-progress" id="ed-progress"></div>


{{-- ── Hero Section ─────────────────────────────────────────────── --}}
<section class="ed-hero">
    <div class="ed-hero-bg"
         style="background-image: url('{{ $postevent->getPosterUrl() ?? 'https://placehold.co/1200x600/1a1a2e/00a79d?text=Event' }}')">
    </div>
    <div class="ed-hero-overlay"></div>

    <div class="ed-hero-content">
        <div class="container">

            {{-- Division badge --}}
            <div class="ed-hero-division">
                <span class="ed-hero-division-dot"></span>
                {{ $postevent->division }}
            </div>

            {{-- Title --}}
            <h1 class="ed-hero-title" id="ed-event-title">{{ $postevent->title }}</h1>

            {{-- Meta chips --}}
            <div class="ed-hero-metas">
                @if($postevent->start)
                <div class="ed-hero-meta">
                    <i class="far fa-calendar-alt"></i>
                    {{ $postevent->start->isoFormat('D MMMM Y') }}
                </div>
                @endif

                @if($postevent->place || $postevent->location)
                <div class="ed-hero-meta">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $postevent->place ?? $postevent->location }}
                </div>
                @endif

                <div class="ed-hero-status {{ $statusKey }}">
                    @if($statusKey !== 'past')<span class="ed-status-pulse"></span>@endif
                    {{ $statusLabel }}
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ── Content Wrap ────────────────────────────────────────────────── --}}
<div class="ed-content-wrap">
    <div class="container">

        {{-- Layout --}}
        <div class="ed-layout">

            {{-- ════════════════════════════════════════
                 MAIN COLUMN
                 ════════════════════════════════════════ --}}
            <div class="ed-main">

                {{-- ── Tab Navigation ───────────────────────── --}}
                <div class="ed-tabs-nav" role="tablist">
                    <button class="ed-tab-btn active" role="tab"
                            aria-controls="ed-tab-desc" aria-selected="true"
                            onclick="edSwitchTab(this, 'ed-tab-desc')">
                        <i class="fas fa-align-left"></i> Deskripsi
                    </button>
                    <button class="ed-tab-btn" role="tab"
                            aria-controls="ed-tab-doc" aria-selected="false"
                            onclick="edSwitchTab(this, 'ed-tab-doc')">
                        <i class="fas fa-folder-open"></i> Dokumentasi
                    </button>
                    <button class="ed-tab-btn" role="tab"
                            aria-controls="ed-tab-disc" aria-selected="false"
                            onclick="edSwitchTab(this, 'ed-tab-disc')">
                        <i class="fas fa-comments"></i> Pembahasan
                    </button>
                </div>

                {{-- ── Tab: Deskripsi ────────────────────────── --}}
                <div class="ed-tab-pane active" id="ed-tab-desc" role="tabpanel">
                    <div class="ed-card">
                        <div class="ed-body">
                            {!! $postevent->broadcast !!}
                        </div>
                    </div>
                </div>

                {{-- ── Tab: Dokumentasi ─────────────────────── --}}
                <div class="ed-tab-pane" id="ed-tab-doc" role="tabpanel">
                    <div class="ed-card">
                        <div class="ed-card-title">Dokumentasi Kegiatan</div>
                        @if($postevent->linkDoc || $postevent->linkPresent)
                        <div class="ed-doc-grid">
                            @if($postevent->linkDoc)
                            <a href="{{ $postevent->linkDoc }}" class="ed-doc-link"
                               target="_blank" rel="noopener noreferrer">
                                <div class="ed-doc-icon"><i class="fas fa-photo-video"></i></div>
                                <span>Foto &amp; Video</span>
                                <i class="fas fa-external-link-alt ms-auto" style="opacity:.4; font-size:.72rem;"></i>
                            </a>
                            @endif
                            @if($postevent->linkPresent)
                            <a href="{{ $postevent->linkPresent }}" class="ed-doc-link"
                               target="_blank" rel="noopener noreferrer">
                                <div class="ed-doc-icon"><i class="fas fa-file-powerpoint"></i></div>
                                <span>Presentasi</span>
                                <i class="fas fa-external-link-alt ms-auto" style="opacity:.4; font-size:.72rem;"></i>
                            </a>
                            @endif
                        </div>
                        @else
                        <div class="ed-doc-empty">
                            <i class="fas fa-folder-open"></i>
                            <p>Belum ada dokumentasi yang diunggah untuk kegiatan ini.</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- ── Tab: Pembahasan (Disqus) ─────────────── --}}
                <div class="ed-tab-pane" id="ed-tab-disc" role="tabpanel">
                    <div class="ed-comments-section">
                        <h3 class="ed-comments-title">Pembahasan</h3>
                        <p style="font-size:.88rem; color: var(--ed-gray); margin-bottom: 1.5rem;">
                            Diskusikan dan tanyakan seputar kegiatan <em>{{ $postevent->title }}</em> di sini.
                        </p>
                        <div id="disqus_thread"></div>
                    </div>
                </div>

                {{-- ── Share (persistent, di luar tab) ─────── --}}
                <div class="ed-share-section">
                    <span class="ed-share-label">Bagikan</span>
                    <div class="ed-share-btns">
                        <button class="ed-share-btn ed-share-btn--copy" onclick="edCopyUrl(event)">
                            <i class="fas fa-link"></i> Salin URL
                        </button>
                        <button class="ed-share-btn ed-share-btn--wa" onclick="edShareWa(event)">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </button>
                        <button class="ed-share-btn ed-share-btn--tw" onclick="edShareTw(event)">
                            <span style="font-weight:900; font-size:1rem; line-height:1; letter-spacing:-1px;">X</span>
                        </button>
                    </div>
                </div>

            </div>{{-- /ed-main --}}


            {{-- ════════════════════════════════════════
                 ASIDE COLUMN
                 ════════════════════════════════════════ --}}
            <div class="ed-aside">

                {{-- ── Event Info Card ──────────────────────── --}}
                <div class="ed-info-card">
                    <div class="ed-info-header">
                        <div class="ed-info-header-label">Detail Kegiatan</div>
                        <div class="ed-info-header-title">{{ Str::limit($postevent->title, 55) }}</div>
                    </div>
                    <div class="ed-ticket-sep"><div class="ed-ticket-sep-icon"><i class="fas fa-tag"></i></div></div>
                    <div class="ed-info-body">

                        {{-- Organizer --}}
                        <div class="ed-info-item">
                            <div class="ed-info-icon"><i class="fas fa-layer-group"></i></div>
                            <div class="ed-info-text">
                                <span class="ed-info-label">Penyelenggara</span>
                                <span class="ed-info-value">{{ $postevent->division }}</span>
                            </div>
                        </div>

                        {{-- Date --}}
                        @if($postevent->start)
                        <div class="ed-info-item">
                            <div class="ed-info-icon"><i class="far fa-calendar-alt"></i></div>
                            <div class="ed-info-text">
                                <span class="ed-info-label">Tanggal Pelaksanaan</span>
                                <span class="ed-info-value">
                                    {{ $postevent->start->isoFormat('dddd, D MMMM Y') }}
                                    @if($postevent->start->format('H:i') !== '00:00')
                                        <br><small style="font-weight:500; color: var(--ed-gray);">Pukul {{ $postevent->start->format('H:i') }} WIB</small>
                                    @endif
                                    @if($postevent->finished)
                                        <br><small style="font-weight:500; color: var(--ed-gray);">s/d {{ $postevent->finished->isoFormat('D MMMM Y') }}</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endif

                        {{-- Location --}}
                        @if($postevent->place || $postevent->location)
                        <div class="ed-info-item">
                            <div class="ed-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="ed-info-text">
                                <span class="ed-info-label">Lokasi</span>
                                <span class="ed-info-value">
                                    {{ $postevent->place ?? $postevent->location }}
                                    @if($postevent->place && $postevent->location && $postevent->place !== $postevent->location)
                                        <br><small style="font-weight:500; color: var(--ed-gray);">{{ $postevent->location }}</small>
                                    @endif
                                    @if($postevent->linkLocation)
                                        <br><a href="{{ $postevent->linkLocation }}" target="_blank" rel="noopener noreferrer">
                                            <i class="fas fa-directions" style="font-size:.7rem;"></i> Lihat peta
                                        </a>
                                    @endif
                                </span>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>{{-- /ed-info-card --}}


                {{-- ── Registration Card ────────────────────── --}}
                <div class="ed-regist-card{{ $registOpen && !$isPast ? ' regist-open' : '' }}">
                    <span class="ed-regist-open-label">
                        @if($isPast)
                            Kegiatan Telah Selesai
                        @elseif($isOngoing)
                            Kegiatan Sedang Berlangsung
                        @else
                            Pendaftaran {{ $registOpen ? 'Terbuka' : 'Ditutup' }}
                        @endif
                    </span>

                    {{-- Countdown (upcoming only) --}}
                    @if($isUpcoming && $postevent->start)
                    <div class="ed-countdown" id="ed-countdown-wrap"
                         data-target="{{ $postevent->start->toIso8601String() }}">
                        <div class="ed-countdown-unit">
                            <span class="ed-countdown-num" id="ed-cd-days">--</span>
                            <span class="ed-countdown-label">Hari</span>
                        </div>
                        <div class="ed-countdown-unit">
                            <span class="ed-countdown-num" id="ed-cd-hours">--</span>
                            <span class="ed-countdown-label">Jam</span>
                        </div>
                        <div class="ed-countdown-unit">
                            <span class="ed-countdown-num" id="ed-cd-mins">--</span>
                            <span class="ed-countdown-label">Menit</span>
                        </div>
                        <div class="ed-countdown-unit">
                            <span class="ed-countdown-num" id="ed-cd-secs">--</span>
                            <span class="ed-countdown-label">Detik</span>
                        </div>
                    </div>
                    @endif

                    {{-- Register button --}}
                    @if($canRegist)
                    <a href="{{ $postevent->linkRegist }}" class="ed-regist-btn"
                       target="_blank" rel="noopener noreferrer">
                        <i class="fas fa-user-plus"></i> Daftar Sekarang
                    </a>
                    @else
                    <div class="ed-regist-btn closed">
                        <i class="fas fa-lock"></i>
                        {{ $isPast ? 'Kegiatan Selesai' : 'Pendaftaran Ditutup' }}
                    </div>
                    @endif

                    {{-- Registration deadline --}}
                    @if($closeRegistCarbon && !$isPast)
                    @php $isUrgent = $registOpen && $now->diffInDays($closeRegistCarbon) <= 3; @endphp
                    <div class="ed-regist-deadline {{ $isUrgent ? 'urgent' : '' }}">
                        <i class="far fa-clock"></i>
                        {{ $registOpen ? 'Tutup' : 'Ditutup' }}: {{ $closeRegistCarbon->isoFormat('D MMM Y') }}
                    </div>
                    @endif

                </div>{{-- /ed-regist-card --}}


                {{-- ── Contact Persons ───────────────────────── --}}
                @if($postevent->cntctPrsn1 || $postevent->cntctPrsn2)
                <div class="ed-info-card">
                    <div class="ed-info-header">
                        <div class="ed-info-header-label">Butuh Bantuan?</div>
                        <div class="ed-info-header-title">Contact Person</div>
                    </div>
                    <div class="ed-ticket-sep"><div class="ed-ticket-sep-icon"><i class="fas fa-phone"></i></div></div>
                    <div class="ed-info-body">
                        <div class="ed-contact-list">
                            @if($postevent->cntctPrsn1)
                            <a href="https://wa.me/+62{{ $postevent->cntctPrsn1 }}"
                               class="ed-contact-item" target="_blank" rel="noopener noreferrer">
                                <div class="ed-contact-avatar"><i class="fab fa-whatsapp"></i></div>
                                <div>
                                    <div class="ed-contact-name">{{ $postevent->nameCntctPrsn1 ?? 'Contact 1' }}</div>
                                    <div class="ed-contact-num">0{{ $postevent->cntctPrsn1 }}</div>
                                </div>
                            </a>
                            @endif
                            @if($postevent->cntctPrsn2)
                            <a href="https://wa.me/+62{{ $postevent->cntctPrsn2 }}"
                               class="ed-contact-item" target="_blank" rel="noopener noreferrer">
                                <div class="ed-contact-avatar"><i class="fab fa-whatsapp"></i></div>
                                <div>
                                    <div class="ed-contact-name">{{ $postevent->nameCntctPrsn2 ?? 'Contact 2' }}</div>
                                    <div class="ed-contact-num">0{{ $postevent->cntctPrsn2 }}</div>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

            </div>{{-- /ed-aside --}}

        </div>{{-- /ed-layout --}}

    </div>{{-- /container --}}
</div>{{-- /ed-content-wrap --}}


{{-- ── Bottom Actions: Kembali + Kegiatan Lainnya ──────────────── --}}
<div class="ed-bottom-actions">
    <div class="container">
        <div class="ed-bottom-inner">
            <div class="ed-bottom-text">
                <h4 class="ed-bottom-title">Ada Kegiatan Lainnya!</h4>
                <p class="ed-bottom-sub">Jelajahi berbagai program dan kegiatan menarik lainnya dari LDK Syahid</p>
            </div>
            <div class="ed-bottom-btns">
                <a href="{{ route('event.index') }}" class="ed-bottom-more-btn">
                    <i class="fas fa-th-list"></i> Lihat Semua Kegiatan
                </a>
            </div>
        </div>
    </div>
</div>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.event.components._detail-scripts')
@endsection
