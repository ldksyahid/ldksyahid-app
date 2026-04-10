{{-- resources/views/landing-page/kta-ldksyahid/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.kta-ldksyahid.components._index-styles')
@include('landing-page.home.partials.about.components._index-styles')
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
                    <img class="kta-photo kta-photo--default"
                         src="https://lh3.googleusercontent.com/d/15Q9hUkS-yvTBCtF4_KZUy9o725MZ9z6n"
                         alt="Foto Default">
                @else
                    <img class="kta-photo kta-photo--default"
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
        <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="kta-section-badge">
                <span>🕌</span>
                <span>Tentang LDK Syahid</span>
                <span class="kta-badge-pulse"></span>
            </div>
            <h2 class="kta-section-title mt-3">Kenali Organisasi Kami</h2>
        </div>

        {{-- Tab Nav --}}
        <div class="row justify-content-center mb-2 wow fadeInUp" data-wow-delay="0.2s">
            <div class="col-12 col-lg-auto">
                <div class="kta-tabs-wrapper">
                    <div class="kta-tabs-slider"></div>
                    <button class="kta-tab-btn active" data-tab="tentang">
                        <span class="kta-tab-icon">🕌</span>
                        <span class="kta-tab-text">Tentang</span>
                    </button>
                    <button class="kta-tab-btn" data-tab="visi">
                        <span class="kta-tab-icon">🔭</span>
                        <span class="kta-tab-text">Visi</span>
                    </button>
                    <button class="kta-tab-btn" data-tab="misi">
                        <span class="kta-tab-icon">🎯</span>
                        <span class="kta-tab-text">Misi</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Tab Contents --}}
        <div class="kta-tab-contents">

            {{-- Tab: Tentang (seperti Perkenalan di about) --}}
            <div class="kta-tab-content active" id="ktaTab-tentang">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-5 text-center">
                        <div class="about-img-cr">
                            <div class="img-frame">
                                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                                     alt="LDK Syahid" class="about-photo">
                            </div>
                            <div class="img-badge-cr">
                                <div class="badge-inner">
                                    <span class="badge-est">Sejak</span>
                                    <span class="badge-yr">1996</span>
                                </div>
                            </div>
                            <div class="img-float-tag tag-1">
                                <i class="fas fa-mosque"></i> Dakwah
                            </div>
                            <div class="img-float-tag tag-2">
                                <i class="fas fa-users"></i> Ukhuwah
                            </div>
                        </div>
                        <p class="mt-4 fst-italic text-muted px-3" style="font-size: 0.9rem;">LDK Syahid adalah UKM keislaman yang aktif dalam mentoring, kajian, rihlah, softskill, ukhuwah, dan pembentukan karakter kepemimpinan.</p>
                    </div>
                    <div class="col-lg-7">
                        <div class="intro-card-cr">
                            <div class="intro-header">
                                <div class="intro-icon-box">
                                    <i class="fas fa-mosque"></i>
                                    <div class="icon-ring"></div>
                                </div>
                                <div>
                                    <h4 class="intro-title">Lembaga Dakwah Kampus</h4>
                                    <span class="intro-subtitle">UIN Syarif Hidayatullah Jakarta</span>
                                </div>
                            </div>
                            <div class="intro-body">
                                <p style="text-align: justify;">
                                    LDK Syahid adalah Salah satu Unit Kegiatan Mahasiswa (UKM) bidang keislaman di UIN Jakarta. Kegiatan-kegiatan yang dilakukan oleh LDK Syahid ialah Mentoring Pekanan, Kajian Keislaman, Rihlah, Upgrading Softskill, Menguatkan Ukhuwah Islamiyah, Management SDM, Management Problem Solved, Pembentukan Karakter Kepemimpinan, dan masih banyak lagi. Outputnya adalah Anggota LDK Syahid menjadi generasi emas menyongsong kehidupan masyarakat madani.
                                </p>
                                <div class="features-grid-cr">
                                    <div class="feature-cr" data-tooltip="Belajar bersama setiap pekan">
                                        <span class="feature-emoji-cr">📖</span>
                                        <span class="feature-text-cr">Mentoring Pekanan</span>
                                        <div class="feature-shine"></div>
                                    </div>
                                    <div class="feature-cr" data-tooltip="Memperdalam ilmu agama">
                                        <span class="feature-emoji-cr">🎓</span>
                                        <span class="feature-text-cr">Kajian Keislaman</span>
                                        <div class="feature-shine"></div>
                                    </div>
                                    <div class="feature-cr" data-tooltip="Mempererat tali persaudaraan">
                                        <span class="feature-emoji-cr">🤝</span>
                                        <span class="feature-text-cr">Ukhuwah Islamiyah</span>
                                        <div class="feature-shine"></div>
                                    </div>
                                    <div class="feature-cr" data-tooltip="Tingkatkan kemampuan diri">
                                        <span class="feature-emoji-cr">⚡</span>
                                        <span class="feature-text-cr">Upgrading Softskill</span>
                                        <div class="feature-shine"></div>
                                    </div>
                                    <div class="feature-cr" data-tooltip="Program kepemimpinan">
                                        <span class="feature-emoji-cr">👑</span>
                                        <span class="feature-text-cr">Leadership Program</span>
                                        <div class="feature-shine"></div>
                                    </div>
                                    <div class="feature-cr" data-tooltip="Jelajah alam & kebersamaan">
                                        <span class="feature-emoji-cr">🏕️</span>
                                        <span class="feature-text-cr">Rihlah & Outbound</span>
                                        <div class="feature-shine"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab: Visi (seperti tab visi di about) --}}
            <div class="kta-tab-content" id="ktaTab-visi">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="vision-card-cr">
                            <div class="vision-bg-pattern"></div>
                            <div class="vision-icon-cr">
                                <div class="v-icon-inner">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="v-icon-orbit">
                                    <span class="orbit-dot" style="--delay: 0s">✨</span>
                                    <span class="orbit-dot" style="--delay: 1s">⭐</span>
                                    <span class="orbit-dot" style="--delay: 2s">🌟</span>
                                </div>
                            </div>
                            <h4 class="vision-title-cr">Visi LDK Syahid</h4>
                            <blockquote class="vision-quote-cr">
                                <span class="quote-mark">"</span>Terciptanya insan-insan dakwah yang memiliki kekokohan <span class="quote-hl">spiritualitas</span>, <span class="quote-hl">intelektualitas</span>, dan <span class="quote-hl">solidaritas</span> dengan etos profesionalisme menuju kampus yang islami dalam rangka mewujudkan <span class="quote-hl">khairu ummah</span>.<span class="quote-mark">"</span>
                            </blockquote>
                            <div class="vision-pillars-cr">
                                <div class="pillar-cr" data-icon="🤲" data-title="Spiritualitas" data-desc="Kekokohan iman, ibadah, dan akhlak sebagai fondasi utama">
                                    <div class="pillar-icon-cr">🤲</div>
                                    <span class="pillar-label-cr">Spiritualitas</span>
                                    <div class="pillar-hover-card">
                                        <p>Kekokohan iman, ibadah, dan akhlak sebagai fondasi utama</p>
                                    </div>
                                </div>
                                <div class="pillar-cr" data-icon="🧠" data-title="Intelektualitas" data-desc="Kecerdasan, wawasan luas, dan kemampuan berpikir kritis">
                                    <div class="pillar-icon-cr">🧠</div>
                                    <span class="pillar-label-cr">Intelektualitas</span>
                                    <div class="pillar-hover-card">
                                        <p>Kecerdasan, wawasan luas, dan kemampuan berpikir kritis</p>
                                    </div>
                                </div>
                                <div class="pillar-cr" data-icon="🤝" data-title="Solidaritas" data-desc="Persatuan, kebersamaan, dan kepedulian sesama">
                                    <div class="pillar-icon-cr">🤝</div>
                                    <span class="pillar-label-cr">Solidaritas</span>
                                    <div class="pillar-hover-card">
                                        <p>Persatuan, kebersamaan, dan kepedulian sesama</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab: Misi (flip cards seperti di about) --}}
            <div class="kta-tab-content" id="ktaTab-misi">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="mission-grid-cr">
                            @php
                                $misi = [
                                    ['emoji' => '📖', 'num' => '1', 'color' => '#00a79d', 'title' => 'Tarbiyah Madal Hayah', 'desc' => 'Pendidikan Sepanjang Hidup', 'detail' => 'Proses pendidikan berkelanjutan yang membentuk karakter dan keilmuan sepanjang hayat'],
                                    ['emoji' => '💝', 'num' => '2', 'color' => '#008f86', 'title' => 'Amal Sholeh', 'desc' => 'Perbuatan yang Baik', 'detail' => 'Mengamalkan kebaikan dalam setiap aspek kehidupan sehari-hari'],
                                    ['emoji' => '⚖️', 'num' => '3', 'color' => '#00a79d', 'title' => "Amar Ma'ruf Nahi Mungkar", 'desc' => 'Memerintahkan yang Baik dan Mencegah yang Mungkar', 'detail' => 'Menyeru kepada kebaikan dan mencegah kemungkaran di lingkungan kampus dan masyarakat'],
                                    ['emoji' => '🤲', 'num' => '4', 'color' => '#008f86', 'title' => 'Khidmatul Ummah', 'desc' => 'Pengabdian Masyarakat', 'detail' => 'Melayani dan mengabdi untuk kemaslahatan umat secara profesional'],
                                    ['emoji' => '🤝', 'num' => '5', 'color' => '#00a79d', 'title' => 'Wihdatul Ummah dan Ukhuwah Islamiyah', 'desc' => 'Persatuan Umat dan Ukhuwah Islamiyah', 'detail' => 'Mempersatukan umat dalam tali persaudaraan Islam yang kokoh'],
                                ];
                            @endphp
                            @foreach($misi as $index => $item)
                            <div class="mission-card-cr" style="--accent: {{ $item['color'] }}; --delay: {{ $index * 0.1 }}s">
                                <div class="mc-front">
                                    <div class="mc-num">{{ $item['num'] }}</div>
                                    <div class="mc-emoji">{{ $item['emoji'] }}</div>
                                    <h5 class="mc-title">{{ $item['title'] }}</h5>
                                    <p class="mc-desc">{{ $item['desc'] }}</p>
                                </div>
                                <div class="mc-back">
                                    <div class="mc-emoji">{{ $item['emoji'] }}</div>
                                    <h5 class="mc-title-back">{{ $item['title'] }}</h5>
                                    <p class="mc-detail">{{ $item['detail'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- /kta-tab-contents --}}

    </div>
</section>

{{-- Pillar Bottom Sheet (mobile — dibutuhkan tab Visi) --}}
<div class="pillar-sheet-backdrop" id="pillarBackdrop"></div>
<div class="pillar-bottom-sheet" id="pillarSheet">
    <div class="pbs-handle"></div>
    <div class="pbs-icon" id="pbsIcon"></div>
    <h5 class="pbs-title" id="pbsTitle"></h5>
    <p class="pbs-desc" id="pbsDesc"></p>
    <button class="pbs-close" id="pbsClose">Tutup</button>
</div>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.kta-ldksyahid.components._index-scripts')
@include('landing-page.home.partials.about.components._index-scripts')
@endsection
