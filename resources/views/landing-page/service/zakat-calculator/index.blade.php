@extends('landing-page.template.body')

@section('content')

{{-- ===================== STYLES ===================== --}}
<style>
    /* ==========================================================
       1. MAIN LAYOUT
       ========================================================== */
    #zakat-calculator {
        padding-top: 6rem;
        padding-bottom: 5rem;
        min-height: 100vh;
        position: relative;
        z-index: 1;
    }

    /* ==========================================================
       2. BADGE HARGA EMAS  (ikutin sl-section-badge)
       ========================================================== */
    .sl-gold-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: rgba(0, 167, 157, .08);
        border: 1px solid rgba(0, 167, 157, .22);
        border-radius: 99px;
        padding: .35rem 1rem .35rem .7rem;
        font-size: .78rem;
        font-weight: 600;
        color: #007a73;
        letter-spacing: .04em;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }
    .sl-gold-badge-pulse {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #00a79d;
        animation: slBadgePulse 2s infinite;
    }

    /* ==========================================================
       3. SECTION TITLE / SUB  (ikutin sl-section-title/sub)
       ========================================================== */
    .sl-zakat-title {
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.2;
    }
    .sl-zakat-sub {
        color: #64748b;
        max-width: 560px;
        margin: .75rem auto 0;
        font-size: .95rem;
        line-height: 1.7;
    }

    /* ==========================================================
       4. KARTU  (ikutin sl-form-card)
       ========================================================== */
    .sl-zakat-card {
        background: linear-gradient(135deg, rgba(0, 167, 157, 0.05) 0%, rgba(255, 255, 255, 0.8) 100%);
        backdrop-filter: blur(20px);
        border: 2px solid rgba(0, 167, 157, 0.15);
        border-radius: 28px;
        padding: 2.5rem;
        box-shadow: 0 20px 60px rgba(0, 167, 157, 0.08);
        transition: border-color .3s, box-shadow .3s;
    }
    .sl-zakat-card:hover {
        border-color: rgba(0, 167, 157, 0.25);
        box-shadow: 0 25px 70px rgba(0, 167, 157, 0.12);
    }

    /* Warning card override */
    .sl-zakat-card.sl-warning {
        background: #fffbeb;
        border: 1px solid #fde68a;
        box-shadow: none;
    }
    .sl-zakat-card.sl-warning:hover {
        border-color: #fbbf24;
        box-shadow: none;
    }

    /* ==========================================================
       5. TYPE PILLS
       ========================================================== */
    .sl-pill-wrap {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }
    .sl-pill {
        padding: 10px 20px;
        background: rgba(0, 167, 157, .06);
        border: 1px solid rgba(0, 167, 157, .14);
        border-radius: 12px;
        cursor: pointer;
        white-space: nowrap;
        font-weight: 600;
        color: #475569;
        transition: all 0.3s;
    }
    .sl-pill.active {
        background: #00a79d;
        border-color: #00a79d;
        color: #ffffff;
    }

    /* ==========================================================
       6. FORM LABEL (ikutin sl-form-label)
       ========================================================== */
    .sl-zakat-label {
        display: flex;
        align-items: center;
        gap: .4rem;
        margin-bottom: .5rem;
        font-weight: 600;
        color: #2c3e50;
        font-size: .9rem;
    }

    /* ==========================================================
       7. INPUT  (ikutin sl-form-input)
       ========================================================== */
    .sl-zakat-input {
        width: 100%;
        height: 50px;
        padding: .875rem 1.125rem;
        border: 2px solid rgba(0, 167, 157, .2);
        border-radius: 14px;
        background: rgba(255, 255, 255, .9);
        color: #2c3e50;
        font-family: inherit;
        font-size: .9rem;
        font-weight: 600;
        transition: border-color .3s, box-shadow .3s, transform .3s, background .3s;
        outline: none;
        box-sizing: border-box;
        display: block;
    }
    .sl-zakat-input:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 4px rgba(0, 167, 157, .1);
        background: #fff;
        transform: translateY(-2px);
    }
    .sl-zakat-input::placeholder { color: rgba(0, 0, 0, .35); }

    /* Input group prefix "Rp" */
    .sl-input-prefix {
        height: 50px;
        padding: .875rem 1.125rem;
        border: 2px solid rgba(0, 167, 157, .2);
        border-right: none;
        border-radius: 14px 0 0 14px;
        background: rgba(0, 167, 157, .05);
        color: #007a73;
        font-weight: 700;
        display: flex;
        align-items: center;
        font-size: .9rem;
        flex-shrink: 0;
    }
    .sl-input-with-prefix { border-radius: 0 14px 14px 0 !important; }

    /* ==========================================================
       8. HINT TEXT  (ikutin sl-field-hint)
       ========================================================== */
    .sl-zakat-hint {
        font-size: .72rem;
        color: #94a3b8;
        margin-top: .3rem;
        line-height: 1.4;
    }

    /* ==========================================================
       9. RESULT BOX
       ========================================================== */
    .sl-res-box {
        margin-top: 30px;
        padding: 25px;
        border-radius: 20px;
        text-align: center;
        background: rgba(0, 167, 157, 0.05);
        border: 2px dashed #00a79d;
        display: none;
    }
    .sl-res-amount {
        font-size: 2.5rem;
        font-weight: 800;
        color: #00a79d;
    }

    /* ==========================================================
       10. ACCORDION  (ikutin custom-accordion)
       ========================================================== */
    .sl-accordion .accordion-item {
        border: 1px solid rgba(0, 167, 157, .14);
        border-radius: 16px !important;
        margin-bottom: 10px;
        overflow: hidden;
        background: transparent;
    }
    .sl-accordion .accordion-button {
        font-weight: 600;
        box-shadow: none !important;
        background: transparent;
        color: #2c3e50;
        padding: 1rem 1.25rem;
    }
    .sl-accordion .accordion-button:not(.collapsed) {
        color: #00a79d;
        background: rgba(0, 167, 157, 0.05);
    }
    .sl-accordion .accordion-body {
        font-size: .82rem;
        color: #475569;
        line-height: 1.6;
    }

    /* ==========================================================
       11. DARK MODE  — semua pakai [data-theme="dark"]
       ========================================================== */

    /* Background body */
    [data-theme="dark"] #zakat-calculator {
        background-color: transparent;
    }

    /* Badge */
    [data-theme="dark"] .sl-gold-badge {
        background: rgba(0,167,157,.1);
        border-color: rgba(0,167,157,.25);
        color: #4ade80;
    }

    /* Title / sub */
    [data-theme="dark"] .sl-zakat-title { color: #e2e8f0; }
    [data-theme="dark"] .sl-zakat-sub   { color: #9ca3af; }

    /* Kartu */
    [data-theme="dark"] .sl-zakat-card {
        background: linear-gradient(135deg, rgba(0,167,157,.08) 0%, rgba(26,29,36,.9) 100%);
        border-color: rgba(0,167,157,.2);
        box-shadow: 0 10px 40px rgba(0,0,0,.4);
        color: #e4e6eb;
    }
    [data-theme="dark"] .sl-zakat-card.sl-warning {
        background: rgba(245,158,11,.05);
        border-color: rgba(245,158,11,.2);
    }

    /* Pills */
    [data-theme="dark"] .sl-pill {
        background: rgba(0,167,157,.06);
        border-color: rgba(0,167,157,.18);
        color: #9ca3af;
    }
    [data-theme="dark"] .sl-pill.active {
        background: #00a79d;
        color: #fff;
    }

    /* Label */
    [data-theme="dark"] .sl-zakat-label { color: #cbd5e0; }

    /* Input */
    [data-theme="dark"] .sl-zakat-input {
        background: #1e2535;
        border-color: rgba(0,167,157,.25);
        color: #e2e8f0;
    }
    [data-theme="dark"] .sl-zakat-input:focus {
        background: #252b3b;
        border-color: #00a79d;
    }
    [data-theme="dark"] .sl-zakat-input::placeholder { color: rgba(226,232,240,.35); }
    [data-theme="dark"] .sl-input-prefix {
        background: rgba(0,167,157,.1);
        border-color: rgba(0,167,157,.25);
        color: #4ade80;
    }

    /* Hint */
    [data-theme="dark"] .sl-zakat-hint { color: #9ca3af; }

    /* Result box */
    [data-theme="dark"] .sl-res-box {
        background: rgba(0,167,157,.1);
    }

    /* Accordion */
    [data-theme="dark"] .sl-accordion .accordion-item {
        border-color: rgba(0,167,157,.2);
    }
    [data-theme="dark"] .sl-accordion .accordion-button {
        background-color: #1a1d24;
        color: #e4e6eb;
    }
    [data-theme="dark"] .sl-accordion .accordion-button:not(.collapsed) {
        background-color: rgba(0,167,157,.1);
        color: #4ade80;
    }
    [data-theme="dark"] .sl-accordion .accordion-body { color: #9ca3af; }
</style>

<section id="zakat-calculator">
    <div class="container">

        {{-- Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.08s">
            <div class="sl-gold-badge">
                <span class="sl-gold-badge-pulse"></span>
                <i class="fas fa-coins text-warning"></i>
                <span>Harga Emas: <span id="goldPriceDisplay">Rp 2.600.000/gr</span></span>
            </div>
            <h2 class="sl-zakat-title mb-2">Kalkulator Zakat</h2>
            <p class="sl-zakat-sub">Gunakan kalkulator ini untuk menghitung kewajiban zakat Anda</p>
        </div>

        <div class="row g-4">

            {{-- KIRI: Main Calculator --}}
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
                        {{-- Input Nominal --}}
                        <div class="col-12" id="wealthInputSection">
                            <div class="mb-4">
                                <label class="sl-zakat-label" id="labelWealth">Penghasilan Bersih Per Bulan</label>
                                <div class="d-flex">
                                    <span class="sl-input-prefix">Rp</span>
                                    <input type="number"
                                           class="form-control sl-zakat-input sl-input-with-prefix"
                                           id="total_wealth"
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
                                       value="1" min="1">
                                <small class="sl-zakat-hint">Standar Zakat Fitrah: Rp 50.000 / jiwa</small>
                            </div>
                        </div>
                    </div>

                    {{-- Hasil --}}
                    <div class="sl-res-box" id="resultBox">
                        <h6 class="fw-bold mb-2 text-uppercase" id="statusZakat" style="letter-spacing: 1px;"></h6>
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
            </div>

            {{-- KANAN: Edukasi & Catatan --}}
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
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    💼 Zakat Penghasilan
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Nisab setara <strong>85 gram emas per tahun</strong>, atau <strong>85/12 gram per bulan</strong>. Tarifnya <strong>2,5%</strong> dari penghasilan bersih.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    🏦 Zakat Maal
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Nisab setara <strong>85 gram emas</strong> dan telah disimpan selama <strong>1 haul (1 tahun)</strong>. Tarif <strong>2,5%</strong> dari total harta simpanan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    🥇 Zakat Emas/Perak
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Nisab emas: <strong>85 gram</strong>. Nisab perak: <strong>595 gram</strong>. Tarif <strong>2,5%</strong>. Berlaku setelah 1 haul.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    🌙 Zakat Fitrah
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionNisab">
                                <div class="accordion-body">
                                    Wajib bagi setiap Muslim yang mampu. Besarannya <strong>2,5 kg atau 3,5 liter beras</strong> per jiwa, atau setara uang <strong>Rp 45.000 – Rp 55.000</strong> per jiwa.
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
                        <li>Kalkulator ini bersifat alat bantu estimasi. Konsultasikan dengan lembaga amil zakat untuk kepastian hukum.</li>
                        <li>Zakat fitrah menggunakan standar nilai uang Baznas pusat.</li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</section>

@include('landing-page.service.zakat-calculator.scripts')
@endsection