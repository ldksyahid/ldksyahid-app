@extends('landing-page.template.body')

@section('styles')
@include('landing-page.schedule.components._index-styles')
@endsection

@section('content')

{{-- =====================================================
     HERO + SCHEDULE SECTION
     ===================================================== --}}
<section class="sch-page-section py-5 wow fadeIn mt-5" data-wow-delay="0.1s">

    {{-- ── Hero Jumbotron (Hadith) ─────────────────────────── --}}
    <x-hero-jumbotron type="hadith">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1_8BpRTDUtkXG9_9CMz7ZxH9k834azBWR"
                 alt="Jadwal LDK Syahid" />
        </div>
    </x-hero-jumbotron>

    {{-- ── Schedule List ───────────────────────────────────── --}}
    <div class="container mt-5" id="sch-list">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sch-section-badge">
                <span>📅</span>
                <span>Jadwal Kegiatan</span>
                <span class="sch-badge-pulse"></span>
            </div>
            <h2 class="sch-section-title mt-3">Jadwal LDK Syahid</h2>
            <p class="sch-section-sub">Temukan jadwal kegiatan dan agenda LDK Syahid secara lengkap di sini</p>
        </div>

        {{-- =====================================================
             DESKTOP: Stacked expand/collapse cards
             ===================================================== --}}
        <div class="sch-desktop-list">
            @forelse($postschedule as $key => $schedule)
            <div class="sch-card wow fadeInUp" data-wow-delay="{{ ($key % 4) * 0.1 }}s">

                {{-- Header (click to expand) --}}
                <div class="sch-card-header"
                     role="button"
                     tabindex="0"
                     aria-expanded="false"
                     aria-controls="sch-body-{{ $schedule->id }}"
                     data-target="sch-body-{{ $schedule->id }}">

                    <div class="sch-card-meta">
                        <div class="sch-meta-top">
                            <span class="sch-date-badge">
                                <i class="fas fa-calendar-day"></i>
                                {{ $schedule->month }} {{ $schedule->year }}
                            </span>
                            @if($loop->first)
                            <span class="sch-latest-badge">
                                <span class="sch-latest-dot"></span>
                                Terbaru
                            </span>
                            @endif
                        </div>
                        <h3 class="sch-card-title-text">{{ $schedule->title }}</h3>
                    </div>

                    <span class="sch-toggle-btn" aria-hidden="true">
                        <span class="sch-toggle-label">Lihat Jadwal</span>
                        <span class="sch-toggle-icon">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </span>

                </div>

                {{-- Collapsible body (schedule image) --}}
                <div class="sch-card-body" id="sch-body-{{ $schedule->id }}">
                    <div class="sch-img-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $schedule->gdrive_id }}"
                             alt="{{ $schedule->title }}"
                             class="sch-img"
                             loading="lazy">
                    </div>
                </div>

            </div>
            @empty
            <div class="sch-empty-state wow fadeInUp" data-wow-delay="0.1s">
                <span class="sch-empty-icon">📆</span>
                <h4 class="sch-empty-title">Jadwal Belum Tersedia</h4>
                <p class="sch-empty-desc">Jadwal kegiatan akan segera hadir. Pantau terus ya!</p>
            </div>
            @endforelse
        </div>

        {{-- =====================================================
             MOBILE: Owl Carousel
             ===================================================== --}}
        <div class="sch-mobile-wrap">
            <div class="sch-carousel owl-carousel" id="schCarousel">
                @forelse($postschedule as $key => $schedule)
                <div>
                    <div class="sch-mob-card">
                        <div class="sch-mob-card-header">
                            <span class="sch-mob-date-badge">
                                <i class="fas fa-calendar-day"></i>
                                {{ $schedule->month }} {{ $schedule->year }}
                            </span>
                            @if($loop->first)
                            <span class="sch-mob-latest-badge">
                                <span class="sch-latest-dot"></span>
                                Terbaru
                            </span>
                            @endif
                        </div>

                        <h5 class="sch-mob-card-title">{{ $schedule->title }}</h5>

                        <div class="sch-mob-img-wrap">
                            <img src="https://lh3.googleusercontent.com/d/{{ $schedule->gdrive_id }}"
                                 alt="{{ $schedule->title }}"
                                 loading="lazy">
                        </div>

                        <button class="sch-mob-expand-btn"
                                type="button"
                                data-title="{{ $schedule->title }}"
                                data-month="{{ $schedule->month }} {{ $schedule->year }}"
                                data-img="https://lh3.googleusercontent.com/d/{{ $schedule->gdrive_id }}">
                            <i class="fas fa-expand-alt"></i>
                            Lihat Jadwal Lengkap
                        </button>
                    </div>
                </div>
                @empty
                <div>
                    <div class="sch-mob-empty">
                        <span class="sch-empty-icon">📆</span>
                        <h4 class="sch-empty-title">Jadwal Belum Tersedia</h4>
                    </div>
                </div>
                @endforelse
            </div>
            <div class="sch-mob-nav" id="schMobNav">
                <button class="sch-mob-nav-btn" id="schMobPrev" aria-label="Sebelumnya">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="sch-mob-counter" id="schMobCounter">1 / 1</span>
                <button class="sch-mob-nav-btn" id="schMobNext" aria-label="Berikutnya">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

    </div>
</section>

{{-- =====================================================
     MOBILE BOTTOM SHEET MODAL
     ===================================================== --}}
<div class="sch-bottom-sheet" id="schBottomSheet"
     role="dialog"
     aria-modal="true"
     aria-labelledby="schBsTitle">

    <div class="sch-bs-backdrop" id="schBsBackdrop"></div>

    <div class="sch-bs-panel" id="schBsPanel">
        <div class="sch-bs-handle"></div>

        <div class="sch-bs-header">
            <div class="sch-bs-header-info">
                <p class="sch-bs-month" id="schBsMonth"></p>
                <h5 class="sch-bs-title" id="schBsTitle"></h5>
            </div>
            <button class="sch-bs-close" id="schBsClose" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="sch-bs-body">
            <img id="schBsImg" src="" alt="" class="sch-bs-img" loading="lazy">
        </div>
    </div>

</div>

@endsection

@section('scripts')
@include('landing-page.schedule.components._index-scripts')
@endsection
