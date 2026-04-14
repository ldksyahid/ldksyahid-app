{{-- FILE: resources/views/landing-page/service/zakat-calculator/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.zakat-calculator.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section id="zakat-calculator">
    <div class="container">

        {{-- ── Section Header ──────────────────────────────────── --}}
        {{-- Header --}}
    <section id="zakat-header" class="d-flex align-items-center justify-content-center text-center text-white" style="background: var(--primary-color); padding: 120px 0 80px 0;">
        <div class="container">
            <div class="mb-3">
                <img src="{{ asset('assets/img/service/zakat-icon.png') }}" alt="Icon Zakat" class="img-fluid" style="max-height: 100px; border-radius: 15px;">
            </div>
                <h1 class="fw-bold">Kalkulator Zakat</h1>
                <p class="opacity-75">Hitung kewajiban zakat Anda dengan mudah dan akurat sesuai syariat.</p>
        </div>
    </section>

        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.08s">
            <div class="sl-gold-badge">
                <span class="sl-gold-badge-pulse"></span>
                <i class="fas fa-coins text-warning"></i>
                <span>Harga Emas: <span id="goldPriceDisplay">Memuat...</span></span>
            </div>
            <h2 class="sl-zakat-title mb-2">Kalkulator Zakat</h2>
            <p class="sl-zakat-sub">Gunakan kalkulator ini untuk menghitung kewajiban zakat Anda</p>
        </div>

        <div class="row g-4">

            {{-- ── Kiri: Main Calculator ───────────────────────── --}}
            <div class="col-lg-7 wow fadeInLeft" data-wow-delay="0.12s">
                <div class="sl-zakat-card h-100">

                    <label class="sl-zakat-label">Jenis Zakat</label>
                    <div class="sl-pill-wrap">
                        <div class="sl-pill active" data-type="penghasilan">💼 Penghasilan</div>
                        <div class="sl-pill" data-type="maal">🏦 Maal (Tabungan)</div>
                        <div class="sl-pill" data-type="emas">🥇 Emas/Perak</div>
                        <div class="sl-pill" data-type="fitrah">🌙 Fitrah</div>
                    </div>

                    <div class="row">

                        {{-- Input Nominal (Penghasilan / Maal / Emas) --}}
                        <div class="col-12" id="wealthInputSection">
                            <div class="mb-4">
                                <label class="sl-zakat-label" id="labelWealth">
                                    Penghasilan Bersih Per Bulan
                                </label>
                                <div class="d-flex" id="wealthInputWrapper">
                                    <span class="sl-input-prefix" id="currencyPrefix">Rp</span>
                                    <input type="number"
                                           class="form-control sl-zakat-input sl-input-with-prefix"
                                           id="total_wealth"
                                           min="0"
                                           placeholder="Contoh: 10000000">
                                </div>
                                <small class="sl-zakat-hint" id="nisabDesc">
                                    Nisab per bulan: Rp 18.416.667 (Setara 85gr emas/12)
                                </small>
                            </div>
                        </div>

                        {{-- Input Fitrah --}}
                        <div class="col-12" id="fitrahInputSection" style="display:none;">
                            <div class="mb-4">
                                <label class="sl-zakat-label">Jumlah Jiwa / Tanggungan</label>
                                <input type="number"
                                       class="sl-zakat-input"
                                       id="total_jiwa"
                                       value="1"
                                       min="1">
                                <small class="sl-zakat-hint">
                                    Standar Zakat Fitrah: Rp 50.000 / jiwa
                                </small>
                            </div>
                        </div>

                    </div>

                    {{-- Hasil --}}
                    <div class="sl-res-box" id="resultBox">
                        <h6 class="fw-bold mb-2 text-uppercase"
                            id="statusZakat"
                            style="letter-spacing: 1px;"></h6>
                        <div class="sl-res-amount" id="totalZakat">Rp 0</div>

                        <div id="payButtonContainer" style="display:none;" class="mt-4">
                            <a href="{{ url('/celengansyahid') }}"
                               class="sl-form-submit text-decoration-none">
                                <i class="fas fa-heart"></i>
                                <span>Tunaikan via Celengan Syahid</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>{{-- /col-lg-7 --}}


            {{-- ── Kanan: Edukasi & Catatan ────────────────────── --}}
            <div class="col-lg-5 wow fadeInRight" data-wow-delay="0.15s">

                {{-- Panduan Nisab --}}
                <div class="sl-zakat-card mb-4">
                    <div class="sl-form-title mb-4">
                        <div class="sl-form-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <span class="sl-zakat-label mb-0">Panduan Nisab Zakat</span>
                    </div>

                    <div class="accordion sl-accordion" id="accordionNisab">

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne">
                                    💼 Zakat Penghasilan
                                </button>
                            </h2>
                            <div id="collapseOne"
                                 class="accordion-collapse collapse"
                                 data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Nisab setara <strong>85 gram emas per tahun</strong>, atau
                                    <strong>85/12 gram per bulan</strong>. Tarifnya
                                    <strong>2,5%</strong> dari penghasilan bersih.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo">
                                    🏦 Zakat Maal
                                </button>
                            </h2>
                            <div id="collapseTwo"
                                 class="accordion-collapse collapse"
                                 data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Nisab setara <strong>85 gram emas</strong> dan telah disimpan
                                    selama <strong>1 haul (1 tahun)</strong>. Tarif
                                    <strong>2,5%</strong> dari total harta simpanan.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree">
                                    🥇 Zakat Emas/Perak
                                </button>
                            </h2>
                            <div id="collapseThree"
                                 class="accordion-collapse collapse"
                                 data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Nisab emas: <strong>85 gram</strong>. Nisab perak:
                                    <strong>595 gram</strong>. Tarif <strong>2,5%</strong>.
                                    Berlaku setelah 1 haul.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour">
                                    🌙 Zakat Fitrah
                                </button>
                            </h2>
                            <div id="collapseFour"
                                 class="accordion-collapse collapse"
                                 data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Wajib bagi setiap Muslim yang mampu. Besarannya
                                    <strong>2,5 kg atau 3,5 liter beras</strong> per jiwa,
                                    atau setara uang <strong>Rp 45.000 – Rp 55.000</strong>
                                    per jiwa.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Disclaimer --}}
                <div class="sl-zakat-card sl-warning p-4">
                    <h6 class="fw-bold text-warning-emphasis mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i> Catatan Penting
                    </h6>
                    <ul class="sl-info-list ps-0">
                        <li>Harga emas diambil berdasarkan estimasi harga rata-rata tahun berjalan.</li>
                        <li>Nisab ditetapkan otomatis, tidak dapat diubah manual.</li>
                        <li>Kalkulator ini bersifat alat bantu estimasi. Konsultasikan dengan
                            lembaga amil zakat untuk kepastian hukum.</li>
                        <li>Zakat fitrah menggunakan standar nilai uang Baznas pusat.</li>
                    </ul>
                </div>

            </div>{{-- /col-lg-5 --}}

        </div>{{-- /row --}}

    </div>{{-- /container --}}
</section>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.zakat-calculator.components._index-scripts')
@endsection