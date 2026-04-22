@extends('landing-page.template.body')

{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.components._index-styles')
@endsection

{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="sv-page-section py-5 wow fadeIn mt-5" data-wow-delay="0.1s">

    {{-- ── Hero Jumbotron ──────────────────────────────────────── --}}
    <x-hero-jumbotron type="hadith">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1GmgV8Pussl5orvOXnVfVePWxXjH866_x"
                 alt="Layanan LDK Syahid" />
        </div>
    </x-hero-jumbotron>

    {{-- ── Service Section ─────────────────────────────────────── --}}
    <div class="container mt-5" id="sv-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="sv-section-badge">
                <span>⚙️</span>
                <span>Layanan</span>
                <span class="sv-badge-pulse"></span>
            </div>
            <h2 class="sv-section-title mt-3">Layanan LDK Syahid</h2>
            <p class="sv-section-sub">Berbagai layanan digital untuk mendukung kegiatan dan administrasi UKM LDK Syahid</p>
        </div>

        {{-- ══════════════════════════════════════════════════
             DESKTOP GRID  (hidden below md)
             ══════════════════════════════════════════════════ --}}
        <div class="sv-grid wow fadeInUp" data-wow-delay="0.15s">

            {{-- ── Kalkulator Zakat ─────────────────────────────── --}}
            <div class="sv-card" style="--sv-accent: #22c55e;">
                <div class="sv-card-img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/18YyQOsL76IgJ3vnsWtkmLzzQT_UCVQCy"
                         alt="Kalkulator Zakat" class="sv-card-img" loading="lazy"
                         onerror="this.src='https://via.placeholder.com/400x200/22c55e/ffffff?text=Kalkulator+Zakat'">
                </div>
                <div class="sv-card-body">
                    <div class="sv-card-title-row">
                        <span class="sv-card-dot"></span>
                        <h5 class="sv-card-title">Kalkulator Zakat</h5>
                    </div>
                    <p class="sv-card-desc">
                        Hitung kewajiban zakat Anda secara otomatis — mencakup Zakat Penghasilan, Maal, Emas/Perak,
                        Perdagangan, Pertanian, Peternakan, dan Fitrah — sesuai nisab harga emas terkini
                        dan pedoman syariat Islam.
                    </p>
                    <div class="sv-card-footer">
                        <div class="sv-card-share-row">
                            <button class="sv-card-share-btn sv-share-copy"
                                    onclick="svCopyUrl('{{ url('/service/zakat-calculator') }}', event)">
                                <i class="fas fa-link"></i><span>Salin URL</span>
                            </button>
                            <button class="sv-card-share-btn sv-share-wa"
                                    onclick="svShareWa('{{ url('/service/zakat-calculator') }}', 'Kalkulator Zakat', event)">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </button>
                        </div>
                        <a href="{{ route('zakat-calculator') }}" target="_blank" rel="noopener" class="sv-card-cta">
                            <i class="fas fa-arrow-right"></i><span>Mulai</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Call Kestari ─────────────────────────────────── --}}
            <div class="sv-card" style="--sv-accent: #00a79d;">
                <div class="sv-card-img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/1q0rUVWPt2doB9_lgKOaKTDyHWbctHChX"
                         alt="Call Kestari" class="sv-card-img" loading="lazy">
                </div>
                <div class="sv-card-body">
                    <div class="sv-card-title-row">
                        <span class="sv-card-dot"></span>
                        <h5 class="sv-card-title">Call Kestari</h5>
                    </div>
                    <p class="sv-card-desc">Call Kestari merupakan tautan panggilan yang di dalamnya terdapat laman khusus berisi informasi penting untuk dibagikan kepada para Sekretaris Bidang/Biro, Sekretaris LDKSF dan Anggota LDK Syahid, yang berfungsi membantu mengarahkan pengguna dalam berkomunikasi lebih personal terkait Kesekretariatan.</p>
                    <div class="sv-card-footer">
                        <div class="sv-card-share-row">
                            <button class="sv-card-share-btn sv-share-copy"
                                    onclick="svCopyUrl('/callkestari', event)">
                                <i class="fas fa-link"></i><span>Salin URL</span>
                            </button>
                            <button class="sv-card-share-btn sv-share-wa"
                                    onclick="svShareWa('/callkestari', 'Call Kestari', event)">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </button>
                        </div>
                        <a href="/callkestari" target="_blank" rel="noopener" class="sv-card-cta">
                            <i class="fas fa-arrow-right"></i><span>Mulai</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Kalkulator Kestari ───────────────────────────── --}}
            <div class="sv-card" style="--sv-accent: #6366f1;">
                <div class="sv-card-img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/1DZdc8rblfJUSkN5Q-Faxsur2iOnI_IYm"
                         alt="Kalkulator Kestari" class="sv-card-img" loading="lazy">
                </div>
                <div class="sv-card-body">
                    <div class="sv-card-title-row">
                        <span class="sv-card-dot"></span>
                        <h5 class="sv-card-title">Kalkulator Kestari</h5>
                    </div>
                    <p class="sv-card-desc">Kalkulator Kestari merupakan sebuah program untuk membantu menghitung penilaian Program Kerja UKM LDK Syahid yang biasanya digunakan sebelum MSG atau MUSA/F dalam rangka mengevaluasi kinerja program secara objektif dan terukur.</p>
                    <div class="sv-card-footer">
                        <div class="sv-card-share-row">
                            <button class="sv-card-share-btn sv-share-copy"
                                    onclick="svCopyUrl('/kalkulatorkestari', event)">
                                <i class="fas fa-link"></i><span>Salin URL</span>
                            </button>
                            <button class="sv-card-share-btn sv-share-wa"
                                    onclick="svShareWa('/kalkulatorkestari', 'Kalkulator Kestari', event)">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </button>
                        </div>
                        <a href="/kalkulatorkestari" target="_blank" rel="noopener" class="sv-card-cta">
                            <i class="fas fa-arrow-right"></i><span>Mulai</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Perpendek URL ────────────────────────────────── --}}
            <div class="sv-card" style="--sv-accent: #f59e0b;">
                <div class="sv-card-img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/1BoMYgj-B2HNblHjkebs1ZRiVUuVre5Wf"
                         alt="Perpendek URL" class="sv-card-img" loading="lazy">
                </div>
                <div class="sv-card-body">
                    <div class="sv-card-title-row">
                        <span class="sv-card-dot"></span>
                        <h5 class="sv-card-title">Perpendek URL</h5>
                    </div>
                    <p class="sv-card-desc">Perpendek URL merupakan sebuah layanan untuk membuat URL/Link yang panjang menjadi singkat sehingga memudahkan untuk diketik dan dibagikan. Layanan ini hanya dapat digunakan oleh anggota UKM LDK Syahid UIN Jakarta.</p>
                    <div class="sv-card-footer">
                        <div class="sv-card-share-row">
                            <button class="sv-card-share-btn sv-share-copy"
                                    onclick="svCopyUrl('/shortlink', event)">
                                <i class="fas fa-link"></i><span>Salin URL</span>
                            </button>
                            <button class="sv-card-share-btn sv-share-wa"
                                    onclick="svShareWa('/shortlink', 'Perpendek URL', event)">
                                <i class="fab fa-whatsapp"></i><span>WhatsApp</span>
                            </button>
                        </div>
                        <a href="/shortlink" target="_blank" rel="noopener" class="sv-card-cta">
                            <i class="fas fa-arrow-right"></i><span>Mulai</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── Celengan Syahid (disabled) ───────────────────── --}}
            <div class="sv-card sv-card-disabled" style="--sv-accent: #10b981;">
                <div class="sv-card-img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/1CynJ5fKVEumKQLxLxncZC99ALkEmf_4t"
                         alt="Celengan Syahid" class="sv-card-img" loading="lazy">
                </div>
                <div class="sv-card-body">
                    <div class="sv-card-title-row">
                        <span class="sv-card-dot"></span>
                        <h5 class="sv-card-title">Celengan Syahid</h5>
                        <span class="sv-badge-coming"><i class="fas fa-clock"></i>Segera Hadir</span>
                    </div>
                    <p class="sv-card-desc">Celengan Syahid adalah sebuah layanan Donasi Crowdfunding secara online untuk membantu orang yang membutuhkan. Melalui Celengan Syahid, kita dapat berdonasi untuk berbagai keperluan seperti kemanusiaan, pendidikan, dan kebutuhan dasar lainnya.</p>
                    <div class="sv-card-footer">
                        <div class="sv-card-share-row"></div>
                        <button class="sv-card-cta sv-card-cta-disabled" disabled>
                            <i class="fas fa-clock"></i><span>Segera Hadir</span>
                        </button>
                    </div>
                </div>
            </div>

        </div>{{-- /sv-grid --}}


        {{-- ══════════════════════════════════════════════════
             MOBILE LIST  (hidden from md and above)
             ══════════════════════════════════════════════════ --}}
        <div class="sv-mobile-list wow fadeInUp" data-wow-delay="0.15s">

            {{-- ── Kalkulator Zakat ─────────────────────────────── --}}
            <div class="sv-m-card"
                 style="--sv-accent: #22c55e;"
                 onclick="svOpenSheet(this)"
                 data-title="Kalkulator Zakat"
                 data-desc="Hitung kewajiban zakat Anda secara otomatis — mencakup Zakat Penghasilan, Maal, Emas/Perak, Perdagangan, Pertanian, Peternakan, dan Fitrah — sesuai nisab harga emas terkini dan pedoman syariat Islam."
                 data-image="18YyQOsL76IgJ3vnsWtkmLzzQT_UCVQCy"
                 data-url="{{ route('zakat-calculator') }}"
                 data-accent="#22c55e"
                 data-label="Mulai"
                 data-disabled="0">
                <div class="sv-m-thumb">
                    <img src="https://lh3.googleusercontent.com/d/18YyQOsL76IgJ3vnsWtkmLzzQT_UCVQCy"
                         alt="Kalkulator Zakat" loading="lazy"
                         onerror="this.src='https://via.placeholder.com/80x80/22c55e/ffffff?text=Z'">
                </div>
                <div class="sv-m-info">
                    <h5 class="sv-m-title">Kalkulator Zakat</h5>
                    <p class="sv-m-desc">Hitung 7 jenis zakat sesuai nisab & pedoman syariat</p>
                    <span class="sv-m-hint"><i class="fas fa-info-circle"></i> Ketuk untuk detail</span>
                </div>
                <i class="fas fa-chevron-right sv-m-arrow"></i>
            </div>

            {{-- ── Call Kestari ─────────────────────────────────── --}}
            <div class="sv-m-card"
                 style="--sv-accent: #00a79d;"
                 onclick="svOpenSheet(this)"
                 data-title="Call Kestari"
                 data-desc="Call Kestari merupakan tautan panggilan yang di dalamnya terdapat laman khusus berisi informasi penting untuk dibagikan kepada para Sekretaris Bidang/Biro, Sekretaris LDKSF dan Anggota LDK Syahid."
                 data-image="1q0rUVWPt2doB9_lgKOaKTDyHWbctHChX"
                 data-url="/callkestari"
                 data-accent="#00a79d"
                 data-label="Mulai"
                 data-disabled="0">
                <div class="sv-m-thumb">
                    <img src="https://lh3.googleusercontent.com/d/1q0rUVWPt2doB9_lgKOaKTDyHWbctHChX"
                         alt="Call Kestari" loading="lazy">
                </div>
                <div class="sv-m-info">
                    <h5 class="sv-m-title">Call Kestari</h5>
                    <p class="sv-m-desc">Tautan panggilan untuk komunikasi dan informasi Kesekretariatan LDK Syahid</p>
                    <span class="sv-m-hint"><i class="fas fa-info-circle"></i> Ketuk untuk detail</span>
                </div>
                <i class="fas fa-chevron-right sv-m-arrow"></i>
            </div>

            {{-- ── Kalkulator Kestari ───────────────────────────── --}}
            <div class="sv-m-card"
                 style="--sv-accent: #6366f1;"
                 onclick="svOpenSheet(this)"
                 data-title="Kalkulator Kestari"
                 data-desc="Kalkulator Kestari merupakan sebuah program untuk membantu menghitung penilaian Program Kerja UKM LDK Syahid yang biasanya digunakan sebelum MSG atau MUSA/F."
                 data-image="1DZdc8rblfJUSkN5Q-Faxsur2iOnI_IYm"
                 data-url="/kalkulatorkestari"
                 data-accent="#6366f1"
                 data-label="Mulai"
                 data-disabled="0">
                <div class="sv-m-thumb">
                    <img src="https://lh3.googleusercontent.com/d/1DZdc8rblfJUSkN5Q-Faxsur2iOnI_IYm"
                         alt="Kalkulator Kestari" loading="lazy">
                </div>
                <div class="sv-m-info">
                    <h5 class="sv-m-title">Kalkulator Kestari</h5>
                    <p class="sv-m-desc">Program penghitung penilaian Program Kerja UKM LDK Syahid secara objektif</p>
                    <span class="sv-m-hint"><i class="fas fa-info-circle"></i> Ketuk untuk detail</span>
                </div>
                <i class="fas fa-chevron-right sv-m-arrow"></i>
            </div>

            {{-- ── Perpendek URL ────────────────────────────────── --}}
            <div class="sv-m-card"
                 style="--sv-accent: #f59e0b;"
                 onclick="svOpenSheet(this)"
                 data-title="Perpendek URL"
                 data-desc="Layanan untuk membuat URL/Link panjang menjadi singkat sehingga mudah diketik dan dibagikan. Khusus untuk anggota UKM LDK Syahid UIN Jakarta."
                 data-image="1BoMYgj-B2HNblHjkebs1ZRiVUuVre5Wf"
                 data-url="/shortlink"
                 data-accent="#f59e0b"
                 data-label="Mulai"
                 data-disabled="0">
                <div class="sv-m-thumb">
                    <img src="https://lh3.googleusercontent.com/d/1BoMYgj-B2HNblHjkebs1ZRiVUuVre5Wf"
                         alt="Perpendek URL" loading="lazy">
                </div>
                <div class="sv-m-info">
                    <h5 class="sv-m-title">Perpendek URL</h5>
                    <p class="sv-m-desc">Buat URL panjang menjadi singkat dan mudah dibagikan</p>
                    <span class="sv-m-hint"><i class="fas fa-info-circle"></i> Ketuk untuk detail</span>
                </div>
                <i class="fas fa-chevron-right sv-m-arrow"></i>
            </div>

            {{-- ── Celengan Syahid (disabled) ───────────────────── --}}
            <div class="sv-m-card sv-m-card-disabled" style="--sv-accent: #10b981;">
                <div class="sv-m-thumb">
                    <img src="https://lh3.googleusercontent.com/d/1CynJ5fKVEumKQLxLxncZC99ALkEmf_4t"
                         alt="Celengan Syahid" loading="lazy">
                </div>
                <div class="sv-m-info">
                    <h5 class="sv-m-title">Celengan Syahid</h5>
                    <p class="sv-m-desc">Layanan donasi crowdfunding untuk berbagai keperluan kemanusiaan dan pendidikan</p>
                    <span class="sv-m-hint sv-m-hint-disabled"><i class="fas fa-clock"></i> Segera Hadir</span>
                </div>
                <i class="fas fa-chevron-right sv-m-arrow"></i>
            </div>

        </div>{{-- /sv-mobile-list --}}

    </div>{{-- /container --}}
</section>

{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="sv-bs-backdrop" id="sv-bs-backdrop"></div>
<div class="sv-bottom-sheet" id="sv-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Layanan">
    <button class="sv-bs-close" id="sv-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="sv-bs-content" id="sv-bs-content">
        {{-- Populated by JS via svOpenSheet() --}}
    </div>
</div>

@endsection

{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.components._index-scripts')
@endsection