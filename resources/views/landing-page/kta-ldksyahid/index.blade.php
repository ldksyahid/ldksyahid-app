{{-- resources/views/landing-page/kta-ldksyahid/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.kta-ldksyahid.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

{{-- ── Hero Section ─────────────────────────────────────────────────── --}}
<section class="kta-hero wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <div class="kta-hero-inner">

            {{-- Photo column --}}
            <div class="kta-photo-wrap wow fadeInLeft" data-wow-delay="0.2s">
                @if (!empty($ktaData->gdrive_id))
                    <img class="kta-photo"
                         src="https://lh3.googleusercontent.com/d/{{ $ktaData->gdrive_id }}"
                         alt="{{ $ktaData->fullName }}">
                @elseif ($ktaData->gender !== 'Male')
                    <img class="kta-photo"
                         src="https://lh3.googleusercontent.com/d/15Q9hUkS-yvTBCtF4_KZUy9o725MZ9z6n"
                         alt="Foto Default">
                @else
                    <img class="kta-photo"
                         src="https://lh3.googleusercontent.com/d/1CACDd_5vjzM82KTR08ND_nGbqtePHRsj"
                         alt="Foto Default">
                @endif
                <div class="kta-ldk-badge">
                    <img src="https://lh3.googleusercontent.com/d/1LsDxFAt1WU66CNp-2CN3J2qWXXJHlWIY"
                         alt="LDK Syahid Badge">
                </div>
            </div>

            {{-- Text column --}}
            <div class="kta-hero-text wow fadeInRight" data-wow-delay="0.3s">
                <div class="kta-hero-top">
                    <span class="kta-member-num">
                        <i class="fas fa-id-card"></i>
                        {{ $ktaData->memberNumber }}
                    </span>
                    <img class="kta-ldk-logo"
                         src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                         alt="LDK Syahid">
                </div>

                <h1 class="kta-hero-name">{{ $ktaData->fullName }}</h1>

                <div class="kta-hero-chips">
                    <span class="kta-chip">
                        <i class="fas fa-users"></i>
                        {{ $ktaData->getGeneration->generationName }}
                    </span>
                    <span class="kta-chip">
                        <i class="fas fa-university"></i>
                        {{ $ktaData->getFaculty->facultyName }}
                    </span>
                </div>

                @if (!empty($ktaData->background))
                    <p class="kta-hero-bio">{{ $ktaData->background }}</p>
                @endif
            </div>

        </div>
    </div>
</section>


{{-- ── Main Content ──────────────────────────────────────────────────── --}}
<section class="kta-main">
    <div class="container">
        <div class="kta-content-grid">

            {{-- Left: Biodata ─────────────────────────────────────── --}}
            <div class="kta-card wow fadeInUp" data-wow-delay="0.1s">
                <div class="kta-card-hdr">
                    <div class="kta-card-hdr-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h3>Biodata Anggota</h3>
                </div>
                <div class="kta-card-body">

                    <div class="kta-info-item">
                        <div class="kta-info-label">
                            <span class="kta-bullet"></span>
                            NIM
                        </div>
                        <div class="kta-info-value">{{ $ktaData->nim }}</div>
                    </div>

                    <div class="kta-info-item">
                        <div class="kta-info-label">
                            <span class="kta-bullet"></span>
                            Fakultas
                        </div>
                        <div class="kta-info-value">{{ $ktaData->getFaculty->facultyName }}</div>
                    </div>

                    <div class="kta-info-item">
                        <div class="kta-info-label">
                            <span class="kta-bullet"></span>
                            Program Studi
                        </div>
                        <div class="kta-info-value">{{ $ktaData->getMajor->majorName }}</div>
                    </div>

                    <div class="kta-info-item">
                        <div class="kta-info-label">
                            <span class="kta-bullet"></span>
                            Angkatan
                        </div>
                        <div class="kta-info-value">{{ $ktaData->getGeneration->generationName }}</div>
                    </div>

                    @if (!empty($ktaData->email))
                    <div class="kta-info-item">
                        <div class="kta-info-label">
                            <span class="kta-bullet"></span>
                            Email
                        </div>
                        <div class="kta-info-value">{{ $ktaData->email }}</div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- Right: Slogan + Social ──────────────────────────── --}}
            <div class="kta-right-col">

                {{-- Slogan --}}
                @if (!empty($ktaData->slogan))
                <div class="kta-card wow fadeInUp" data-wow-delay="0.15s">
                    <div class="kta-card-hdr">
                        <div class="kta-card-hdr-icon">
                            <i class="fas fa-quote-left"></i>
                        </div>
                        <h3>Slogan</h3>
                    </div>
                    <div class="kta-card-body">
                        <div class="kta-quote-wrap">
                            <span class="kta-quote-mark">"</span>
                            <p class="kta-quote-text">{{ $ktaData->slogan }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Social Media --}}
                @if (!empty($ktaData->instagram) || !empty($ktaData->linkedIn))
                <div class="kta-card wow fadeInUp" data-wow-delay="0.2s">
                    <div class="kta-card-hdr">
                        <div class="kta-card-hdr-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>
                        <h3>Temui Saya</h3>
                    </div>
                    <div class="kta-card-body">
                        @if (!empty($ktaData->instagram))
                        <a href="{{ $ktaData->instagram }}" target="_blank" rel="noopener noreferrer"
                           class="kta-social-btn kta-social-btn--ig">
                            <i class="fab fa-instagram"></i>
                            Instagram
                        </a>
                        @endif
                        @if (!empty($ktaData->linkedIn))
                        <a href="{{ $ktaData->linkedIn }}" target="_blank" rel="noopener noreferrer"
                           class="kta-social-btn kta-social-btn--li">
                            <i class="fab fa-linkedin-in"></i>
                            LinkedIn
                        </a>
                        @endif
                    </div>
                </div>
                @endif

            </div>{{-- /kta-right-col --}}

        </div>{{-- /kta-content-grid --}}
    </div>
</section>


{{-- ── Organization Section ─────────────────────────────────────────── --}}
<section class="kta-org-section">
    <div class="container">

        {{-- Section header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="kta-section-badge">
                <span>🕌</span>
                <span>Tentang LDK Syahid</span>
                <span class="kta-badge-pulse"></span>
            </div>
            <h2 class="kta-section-title mt-3">Visi & Misi Kami</h2>
        </div>

        {{-- Vision + Mission grid --}}
        <div class="kta-org-grid">

            {{-- Vision --}}
            <div class="kta-org-card wow fadeInLeft" data-wow-delay="0.1s">
                <div class="kta-org-card-hdr">
                    <div class="kta-org-card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Visi</h3>
                </div>
                <div class="kta-org-card-body">
                    <p>"Terciptanya insan-insan dakwah yang memiliki kekokohan spiritualitas, intelektualitas, dan solidaritas dengan etos profesionalisme menuju kampus yang islami dalam rangka mewujudkan khairu ummah."</p>
                </div>
            </div>

            {{-- Mission --}}
            <div class="kta-org-card wow fadeInRight" data-wow-delay="0.2s">
                <div class="kta-org-card-hdr">
                    <div class="kta-org-card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Misi</h3>
                </div>
                <div class="kta-org-card-body">
                    <ol class="kta-mission-list">
                        <li>Tarbiyah Madal Hayah (Pendidikan Sepanjang Hidup)</li>
                        <li>Amal Sholeh (Perbuatan yang Baik)</li>
                        <li>Amar Ma'ruf Nahi Mungkar (Memerintahkan yang Baik dan Mencegah yang Mungkar)</li>
                        <li>Khidmatul Ummah (Pengabdian Masyarakat)</li>
                        <li>Wihdatul Ummah dan Ukhuwah Islamiyah (Persatuan Umat dan Ukhuwah Islamiyah)</li>
                    </ol>
                </div>
            </div>

        </div>{{-- /kta-org-grid --}}

        {{-- Description --}}
        <div class="kta-org-desc wow fadeInUp" data-wow-delay="0.25s">
            <p>LDK Syahid adalah Salah satu Unit Kegiatan Mahasiswa (UKM) bidang keislaman di UIN Jakarta. Kegiatan-kegiatan yang dilakukan oleh LDK Syahid ialah Mentoring Pekanan, Kajian Keislaman, Rihlah, Upgrading Softskill, Menguatkan Ukhuwah Islamiyah, Management SDM, Management Problem Solved, Pembentukan Karakter Kepemimpinan, dan masih banyak lagi. Outputnya adalah Anggota LDK Syahid menjadi generasi emas menyongsong kehidupan masyarakat madani.</p>
        </div>

    </div>
</section>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.kta-ldksyahid.components._index-scripts')
@endsection
