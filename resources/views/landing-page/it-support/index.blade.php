{{-- resources/views/landing-page/it-support/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.it-support.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')
@php
    $accentColors = ['#00a79d', '#6366f1', '#10b981', '#f59e0b', '#0ea5e9', '#8b5cf6', '#ef4444', '#ec4899'];
@endphp

<section class="its-section">
<div class="container">

    {{-- ── Section Header ──────────────────────────────────────── --}}
    <div class="text-center mb-5 mt-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="its-section-badge">
            <span>💻</span>
            <span>Tim Teknologi</span>
            <span class="its-badge-pulse"></span>
        </div>
        <h2 class="its-section-title mt-3">IT Support LDK Syahid</h2>
        <p class="its-section-sub">Tim ahli yang berkomitmen memberikan yang terbaik di bidang teknologi untuk UKM LDK Syahid</p>
    </div>


    {{-- ══════════════════════════════════════════════════
         DESKTOP GRID  (lg and above)
         ══════════════════════════════════════════════════ --}}
    <div class="d-none d-lg-block">

        @if($postitsupport->isEmpty())
            <div class="its-empty-state wow fadeInUp" data-wow-delay="0.1s">
                <div class="its-empty-visual">
                    <div class="its-empty-ring its-empty-ring-1"></div>
                    <div class="its-empty-ring its-empty-ring-2"></div>
                    <div class="its-empty-icon-wrap"><i class="fas fa-users"></i></div>
                </div>
                <h4 class="its-empty-title">Belum Ada Anggota</h4>
                <p class="its-empty-sub">Tim IT Support LDK Syahid akan segera hadir.</p>
            </div>
        @else
            <div class="its-grid">
                @foreach($postitsupport as $member)
                @php
                    $accent  = $accentColors[$loop->index % count($accentColors)];
                    $isNew   = $member->created_at && $member->created_at->gte(\Carbon\Carbon::now()->subDays(30));
                    $photo   = 'https://lh3.googleusercontent.com/d/' . $member->gdrive_id;
                    $delay   = '0.' . ($loop->index % 4 + 1) . 's';
                @endphp
                <div class="its-card wow fadeInUp"
                     data-wow-delay="{{ $delay }}"
                     style="--its-accent: {{ $accent }}">

                    {{-- Gradient header --}}
                    <div class="its-card-hdr">
                        @if($isNew)
                        <div class="its-card-new-badge">Terbaru</div>
                        @endif
                    </div>

                    {{-- Circular photo — overlaps header --}}
                    <div class="its-photo-band">
                        <div class="its-photo-ring">
                            <img src="{{ $photo }}"
                                 alt="{{ $member->name }}"
                                 class="its-card-img"
                                 loading="lazy">
                        </div>
                    </div>

                    {{-- Card body --}}
                    <div class="its-card-body">
                        <span class="its-position-badge">{{ $member->position }}</span>
                        <h3 class="its-card-name">{{ $member->name }}</h3>
                        @if($member->forkat)
                        <div class="its-forkat">
                            <span class="its-bullet"></span>
                            <span>{{ $member->forkat }}</span>
                        </div>
                        @endif
                        <div class="its-social-links">
                            @if($member->linkInstagram)
                            <a href="{{ $member->linkInstagram }}"
                               target="_blank" rel="noopener noreferrer"
                               class="its-social-btn its-social-btn--ig"
                               title="Instagram {{ $member->name }}"
                               onclick="event.stopPropagation()">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if($member->linkLinkedin)
                            <a href="{{ $member->linkLinkedin }}"
                               target="_blank" rel="noopener noreferrer"
                               class="its-social-btn its-social-btn--li"
                               title="LinkedIn {{ $member->name }}"
                               onclick="event.stopPropagation()">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                        </div>
                    </div>{{-- /its-card-body --}}

                </div>{{-- /its-card --}}
                @endforeach
            </div>{{-- /its-grid --}}
        @endif

    </div>{{-- /desktop --}}


    {{-- ══════════════════════════════════════════════════
         MOBILE CAROUSEL  (below lg)
         ══════════════════════════════════════════════════ --}}
    <div class="d-lg-none">

        @if($postitsupport->isEmpty())
            <div class="its-empty-state">
                <div class="its-empty-visual">
                    <div class="its-empty-ring its-empty-ring-1"></div>
                    <div class="its-empty-ring its-empty-ring-2"></div>
                    <div class="its-empty-icon-wrap"><i class="fas fa-users"></i></div>
                </div>
                <h4 class="its-empty-title">Belum Ada Anggota</h4>
                <p class="its-empty-sub">Tim IT Support LDK Syahid akan segera hadir.</p>
            </div>
        @else
            <div class="its-mobile-carousel" id="its-mobile-carousel">
                @foreach($postitsupport as $member)
                @php
                    $accent = $accentColors[$loop->index % count($accentColors)];
                    $isNew  = $member->created_at && $member->created_at->gte(\Carbon\Carbon::now()->subDays(30));
                    $photo  = 'https://lh3.googleusercontent.com/d/' . $member->gdrive_id;
                @endphp
                <div class="its-mobile-card"
                     style="--its-accent: {{ $accent }}"
                     data-name="{{ e($member->name) }}"
                     data-position="{{ e($member->position) }}"
                     data-forkat="{{ e($member->forkat) }}"
                     data-photo="{{ $photo }}"
                     data-instagram="{{ e($member->linkInstagram) }}"
                     data-linkedin="{{ e($member->linkLinkedin) }}"
                     data-accent="{{ e($accent) }}"
                     onclick="itsOpenSheet(this)">

                    {{-- Mobile gradient header --}}
                    <div class="its-m-hdr">
                        @if($isNew)
                        <div class="its-card-new-badge">Terbaru</div>
                        @endif
                    </div>

                    {{-- Mobile circular photo --}}
                    <div class="its-m-photo-band">
                        <div class="its-m-photo-ring">
                            <img src="{{ $photo }}" alt="{{ $member->name }}" loading="lazy">
                        </div>
                    </div>

                    {{-- Mini body --}}
                    <div class="its-m-body">
                        <span class="its-position-badge">{{ $member->position }}</span>
                        <h4 class="its-m-name">{{ $member->name }}</h4>
                        @if($member->forkat)
                        <div class="its-forkat--sm">
                            <span class="its-bullet"></span>
                            <span>{{ $member->forkat }}</span>
                        </div>
                        @endif
                        <p class="its-m-tap-hint">Tap untuk detail 👆</p>
                    </div>

                </div>{{-- /its-mobile-card --}}
                @endforeach
            </div>{{-- /its-mobile-carousel --}}

            <div class="its-carousel-dots" id="its-carousel-dots"></div>
        @endif

    </div>{{-- /mobile --}}

</div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="its-bs-backdrop" id="its-bs-backdrop"></div>
<div class="its-bottom-sheet" id="its-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Anggota">
    <button class="its-bs-close" id="its-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="its-bs-content" id="its-bs-content">
        {{-- Populated by JS via itsOpenSheet() --}}
    </div>
</div>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.it-support.components._index-scripts')
@endsection
