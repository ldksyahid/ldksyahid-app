@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.report.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="rp-page-section py-5 wow fadeIn mt-5" data-wow-delay="0.1s">

    {{-- ── Hero Jumbotron (Hadith type) ──────────────────────────── --}}
    <x-hero-jumbotron type="hadith">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1RNWVLrXSyfS5kXXllib3HyGOyBZEW257"
                 alt="Laporan LDK Syahid" />
        </div>
    </x-hero-jumbotron>


    {{-- ── Report Section ────────────────────────────────────────── --}}
    <div class="container mt-5" id="rp-report-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="rp-section-badge">
                <span>📋</span>
                <span>Laporan</span>
                <span class="rp-badge-pulse"></span>
            </div>
            <h2 class="rp-section-title mt-3">Laporan LDK Syahid</h2>
            <p class="rp-section-sub">Dokumentasi transparan dan akuntabel seluruh kegiatan LDK Syahid</p>
        </div>

        {{-- ── Info Card (Features) ────────────────────────────── --}}
        <div class="rp-info-card wow fadeInUp mb-5" data-wow-delay="0.15s">
            <p class="rp-info-desc">
                UKM LDK Syahid menyajikan berbagai laporan dengan standar kualitas tinggi yang
                mencerminkan integritas organisasi. Setiap laporan dirancang untuk memberikan
                gambaran utuh tentang kinerja, keuangan, dan program kerja kepada seluruh
                anggota dan stakeholders.
            </p>
            <div class="rp-features-grid">
                <div class="rp-feature-item">
                    <div class="rp-feature-icon"><i class="fas fa-check-double"></i></div>
                    <div class="rp-feature-text">
                        <span class="rp-feature-title">Akurat dan Terverifikasi</span>
                        <span class="rp-feature-sub">Data yang disajikan telah melalui proses validasi ketat</span>
                    </div>
                </div>
                <div class="rp-feature-item">
                    <div class="rp-feature-icon"><i class="fas fa-globe"></i></div>
                    <div class="rp-feature-text">
                        <span class="rp-feature-title">Terbuka dan Transparan</span>
                        <span class="rp-feature-sub">Dapat diakses publik tanpa batasan akses</span>
                    </div>
                </div>
                <div class="rp-feature-item">
                    <div class="rp-feature-icon"><i class="fas fa-clock"></i></div>
                    <div class="rp-feature-text">
                        <span class="rp-feature-title">Tepat Waktu dan Teratur</span>
                        <span class="rp-feature-sub">Diterbitkan sesuai jadwal yang telah ditetapkan</span>
                    </div>
                </div>
                <div class="rp-feature-item">
                    <div class="rp-feature-icon"><i class="fas fa-layer-group"></i></div>
                    <div class="rp-feature-text">
                        <span class="rp-feature-title">Komprehensif dan Lengkap</span>
                        <span class="rp-feature-sub">Mencakup seluruh aspek yang diperlukan</span>
                    </div>
                </div>
                <div class="rp-feature-item">
                    <div class="rp-feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <div class="rp-feature-text">
                        <span class="rp-feature-title">Analitis dan Informatif</span>
                        <span class="rp-feature-sub">Disertai analisis mendalam untuk pengambilan keputusan</span>
                    </div>
                </div>
                <div class="rp-feature-item">
                    <div class="rp-feature-icon"><i class="fas fa-sitemap"></i></div>
                    <div class="rp-feature-text">
                        <span class="rp-feature-title">Terstruktur dan Sistematis</span>
                        <span class="rp-feature-sub">Format penyajian yang mudah dipahami</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Cards Wrap ───────────────────────────────────────── --}}
        <div id="rp-cards-wrap">
            @include('landing-page.report.components._report-cards')
        </div>

    </div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="rp-bs-backdrop" id="rp-bs-backdrop"></div>
<div class="rp-bottom-sheet" id="rp-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Laporan">
    <button class="rp-bs-close" id="rp-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="rp-bs-content" id="rp-bs-content">
        {{-- Populated by JS via rpOpenBottomSheet() --}}
    </div>
</div>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.report.components._index-scripts')
@endsection
