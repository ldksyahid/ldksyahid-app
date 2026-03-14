@extends('landing-page.template.body')
{{-- =====================================================
     CONTENT
     ===================================================== --}}
@section('content')

<div style="display:none;">
    <audio src="{{ asset('audio/mars-ldksyahid.mp3') }}" type="audio/mpeg" autoplay loop></audio>
</div>

<section class="ms-section wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">

        {{-- Section Header --}}
        <div class="text-center mb-5 ms-reveal">
            <div class="ms-badge">
                <span class="ms-badge-pulse"></span>
                Tentang Kami
            </div>
            <h2 class="section-title mb-2">
                Struktur <span class="text-gradient">Kepengurusan</span>
            </h2>
            <div class="section-divider mx-auto"></div>
            <p class="section-description mt-3">
                Mengenal pengurus dan struktur UKM LDK Syahid UIN Jakarta secara lebih dekat
            </p>
        </div>

        @if(count($poststructure) > 0)

        {{-- =====================================================
             DESKTOP: Konten sheet ditampilkan langsung (inline)
             ===================================================== --}}
        <div class="desktop-only">
            <div class="ms-desktop-inline">
                @foreach($poststructure as $key => $data)
                <div class="ms-di-card ms-reveal ms-d{{ ($key % 3) + 1 }}">

                    {{-- ── ATAS: gradient — foto kiri + info+deskripsi kanan ── --}}
                    <div class="ms-di-left">

                        {{-- Watermark angka batch --}}
                        <div class="ms-di-batch-wm">{{ $data->batch }}</div>

                        {{-- Foto frame --}}
                        <div class="ms-di-photo-wrap">
                            <img
                                src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id }}"
                                alt="Foto Pengurus LDK Syahid {{ $data->batch }}"
                                loading="lazy"
                                onerror="if(!this.dataset.err){this.src='https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';this.dataset.err=1;}"
                            >
                        </div>

                        {{-- Info + Deskripsi --}}
                        <div class="ms-di-info">
                            <div class="ms-mob-eyebrow">LDK Syahid {{ $data->batch }}</div>
                            <h5 class="ms-mob-hname" style="font-size:1.1rem;">{{ $data->structureName }}</h5>
                            <div style="display:flex;align-items:center;gap:0.45rem;flex-wrap:wrap;">
                                <span class="ms-di-period-badge">
                                    <i class="fas fa-calendar-alt" style="font-size:0.6rem;"></i>
                                    Masa Bakti {{ $data->period }}
                                </span>
                                @if($loop->first)
                                <span class="ms-mob-current">
                                    <i class="fas fa-star" style="font-size:0.52rem;"></i>
                                    Pengurus Saat Ini
                                </span>
                                @endif
                            </div>

                            {{-- Separator --}}
                            <div class="ms-di-separator"></div>

                            {{-- Deskripsi langsung di sini --}}
                            <div class="ms-dm-desc-label" style="color:rgba(255,255,255,0.6);margin-bottom:0.3rem;">
                                <i class="fas fa-info-circle"></i>
                                Tentang Kepengurusan
                            </div>
                            <p class="ms-di-desc">{{ $data->structureDescription }}</p>
                        </div>

                    </div>
                    {{-- /ATAS --}}

                    {{-- ── BAWAH: bagan struktur (collapsible) ── --}}
                    <div class="ms-di-right">
                        <div class="ms-di-chart-section">

                            {{-- Toggle button --}}
                            <button class="ms-di-chart-toggle" type="button" aria-expanded="false">
                                <span class="ms-di-chart-toggle-label">
                                    <i class="fas fa-sitemap" style="color:var(--primary);"></i>
                                    Bagan Struktur Kepengurusan
                                </span>
                                <span class="ms-di-chart-toggle-icon">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>

                            {{-- Collapsible chart --}}
                            <div class="ms-di-chart-body">
                                <img
                                    src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id_2 }}=s3000"
                                    alt="Bagan Struktur LDK Syahid {{ $data->batch }}"
                                    loading="lazy"
                                    onerror="if(!this.dataset.err){this.dataset.err=1;this.style.display='none';}"
                                >
                            </div>

                        </div>
                    </div>
                    {{-- /BAWAH --}}

                </div>
                @endforeach
            </div>
        </div>
        {{-- /DESKTOP --}}

        {{-- =====================================================
             MOBILE: Owl Carousel
             ===================================================== --}}
        <div class="mobile-only">
            <div class="ms-mob-wrap">
                <div class="ms-carousel owl-carousel" id="msCarousel">
                    @foreach($poststructure as $key => $data)
                    <div>
                        <div class="ms-mobile-card">

                            {{-- Gradient Hero Header --}}
                            <div class="ms-mob-hero">
                                <div class="ms-mob-hero-row">
                                    <div>
                                        <div class="ms-mob-eyebrow">LDK Syahid {{ $data->batch }}</div>
                                        <h6 class="ms-mob-hname">{{ $data->structureName }}</h6>
                                    </div>
                                    @if($loop->first)
                                    <span class="ms-mob-current">
                                        <i class="fas fa-star" style="font-size:0.52rem;"></i>
                                        Pengurus Saat Ini
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Profile Photo — full contain, no crop --}}
                            <div class="ms-mob-photo-area">
                                <img
                                    src="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id }}"
                                    alt="Foto Pengurus LDK Syahid {{ $data->batch }}"
                                    loading="lazy"
                                    onerror="if(!this.dataset.err){this.src='https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';this.dataset.err=1;}"
                                >
                            </div>

                            {{-- Info --}}
                            <div class="ms-mob-info">
                                <p class="ms-mob-period">
                                    <i class="fas fa-calendar-alt me-1"></i>Masa Bakti {{ $data->period }}
                                </p>
                                <p class="ms-mob-desc">
                                    {{ Str::limit($data->structureDescription, 130) }}
                                </p>
                            </div>

                            {{-- View Detail Button — opens full popup --}}
                            <button
                                class="ms-view-chart-btn ms-detail-btn"
                                type="button"
                                data-name="{{ $data->structureName }}"
                                data-batch="LDK Syahid {{ $data->batch }}"
                                data-period="{{ $data->period }}"
                                data-desc="{{ $data->structureDescription }}"
                                data-photo="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id }}"
                                data-chart="https://lh3.googleusercontent.com/d/{{ $data->gdrive_id_2 }}=s3000"
                            >
                                <i class="fas fa-expand-alt"></i>
                                Lihat Selengkapnya
                            </button>

                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Custom Navigation: Dots only --}}
                <div class="ms-mob-nav" id="msMobNav">
                    <div class="ms-mob-dots" id="msMobDots"></div>
                </div>

            </div>
        </div>
        {{-- /MOBILE --}}

        @else

        {{-- Empty State --}}
        <div class="ms-empty ms-reveal">
            <div class="ms-empty-icon"><i class="fas fa-users"></i></div>
            <h4 class="fw-bold mb-2" style="color:var(--dark);">Struktur Belum Tersedia</h4>
            <p class="text-secondary mb-0">Informasi struktur kepengurusan LDK Syahid akan segera diperbarui.</p>
        </div>

        @endif

    </div>
</section>

{{-- =====================================================
     LIGHTBOX MODAL
     ===================================================== --}}
<div
    class="ms-lightbox"
    id="msLightbox"
    role="dialog"
    aria-modal="true"
    aria-labelledby="msLbTitleText"
>
    <div class="ms-lb-backdrop" id="msLbBackdrop"></div>
    <div class="ms-lb-content" role="document">
        <div class="ms-lb-header">
            <span class="ms-lb-title" id="msLbTitleText"></span>
            <button class="ms-lb-close" id="msLbClose" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="ms-lb-body">
            <img id="msLbImg" src="" alt="Bagan Struktur UKM LDK Syahid">
        </div>
    </div>
</div>

{{-- =====================================================
     DETAIL POPUP MODAL — Bottom Sheet (Mobile)
     ===================================================== --}}
<div
    class="ms-detail-modal"
    id="msDetailModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="msDmName"
>
    <div class="ms-dm-backdrop" id="msDmBackdrop"></div>
    <div class="ms-dm-sheet" id="msDmSheet">
        <div class="ms-dm-handle"></div>

        {{-- Gradient Header --}}
        <div class="ms-dm-header">
            <div class="ms-dm-header-info">
                <div class="ms-dm-eyebrow" id="msDmBatch"></div>
                <h5 class="ms-dm-name" id="msDmName"></h5>
                <span class="ms-dm-period-badge" id="msDmPeriod">
                    <i class="fas fa-calendar-alt" style="font-size:0.62rem;"></i>
                </span>
            </div>
            <button class="ms-dm-close" id="msDmClose" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Scrollable Body --}}
        <div class="ms-dm-body">

            {{-- Profile Photo --}}
            <div class="ms-dm-photo-wrap">
                <img id="msDmPhoto" src="" alt="">
            </div>

            {{-- Description --}}
            <div class="ms-dm-desc-wrap">
                <div class="ms-dm-desc-label">
                    <i class="fas fa-info-circle" style="color:var(--primary);"></i>
                    Tentang Kepengurusan
                </div>
                <p id="msDmDesc"></p>
            </div>

            {{-- Structure Chart --}}
            <div class="ms-dm-chart-section">
                <div class="ms-dm-chart-label">
                    <i class="fas fa-sitemap" style="color:var(--primary);"></i>
                    Bagan Struktur Kepengurusan
                </div>
                <img id="msDmChart" src="" alt="">
            </div>

        </div>
    </div>
</div>

@endsection

@section('styles')
@include('landing-page.about.management-structure.components._index-styles')
@endsection

@section('scripts')
@include('landing-page.about.management-structure.components._index-scripts')
@endsection
