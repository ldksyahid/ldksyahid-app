{{-- FILE: resources/views/landing-page/service/zakat-calculator/index.blade.php --}}
@extends('landing-page.template.body')

@section('styles')
@include('landing-page.service.zakat-calculator.components._index-styles')
@endsection

@section('content')
<section id="zakat-calculator">

    {{-- ── Header ─────────────────────────────────────────────── --}}
    <section id="zakat-header" class="d-flex align-items-center justify-content-center text-center text-white">
        <div class="container">
            <div class="mb-3">
                <img src="https://lh3.googleusercontent.com/d/18YyQOsL76IgJ3vnsWtkmLzzQT_UCVQCy"
                     alt="Icon Zakat" class="zk-header-icon img-fluid"
                     onerror="this.src='https://via.placeholder.com/100x100/00a79d/ffffff?text=Z'">
            </div>
            <h1 class="fw-bold">Kalkulator Zakat</h1>
            <p class="opacity-75">Hitung kewajiban zakat Anda dengan mudah dan cepat sesuai syariat.</p>
        </div>
    </section>

    <div class="container mt-4">

        {{-- ── Alert Info ───────────────────────────────────────── --}}
        <div class="alert alert-info text-center shadow-sm" style="border-radius:15px;">
            <h5 class="fw-bold mb-2">Pentingnya Zakat</h5>
            <p class="mb-2 fst-italic">"Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan dan mensucikan mereka..." <strong>(QS. At-Taubah: 103)</strong></p>
            <hr>
            <p class="mb-0 small text-muted text-start">
                <strong>Catatan Metode:</strong> Zakat Penghasilan menggunakan metode <strong>Bruto</strong> (langsung dari penghasilan kotor, tanpa dikurangi kebutuhan pokok).
                Metode ini dipilih atas dasar <em>ihtiyath</em> (kehati-hatian) sesuai <strong>Fatwa MUI No.3/2003</strong>.
                Beberapa platform lain (seperti BSI) menggunakan metode <strong>Netto</strong> sehingga variabelnya lebih banyak — keduanya sah secara syariat.
            </p>
        </div>

        {{-- ── Layout 2 Kolom ──────────────────────────────────── --}}
        <div class="row g-4 mt-2">

            {{-- ═══════════════════════════════════════════════════
                 KIRI: KALKULATOR UTAMA
                 ═══════════════════════════════════════════════════ --}}
            <div class="col-lg-7 wow fadeInLeft" data-wow-delay="0.12s">
                <div class="sl-zakat-card h-100">

                    {{-- ⚙️ Panel Harga Emas --}}
                    <div class="sl-gold-settings">
                        <div class="sl-gold-settings-title"><i class="fas fa-cog"></i> Pengaturan Harga Emas</div>
                        <div class="sl-gold-input-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-weight:700;color:#92400e;font-size:.85rem;">Rp</span>
                                <input type="text" id="goldPriceInput" class="sl-gold-input"
                                       placeholder="2.600.000" inputmode="numeric">
                                <span style="font-size:.8rem;color:#92400e;font-weight:600;">/gram</span>
                            </div>
                            <div class="sl-gold-ref">
                                Default: Rp 2.600.000/gr &nbsp;|&nbsp;
                                Ref: <a href="https://www.logammulia.com/id/harga-emas-hari-ini" target="_blank" rel="noopener">Antam</a>
                                / <a href="https://www.lbma.org.uk/prices-and-data/precious-metal-prices" target="_blank" rel="noopener">LBMA</a>
                                — perbarui sesuai harga aktual
                            </div>
                        </div>
                        <div class="mt-2">
                            <span class="sl-gold-badge">
                                <span class="sl-gold-badge-pulse"></span>
                                Harga Aktif: <span id="goldPriceDisplay">Rp 2.600.000/gr</span>
                            </span>
                        </div>
                    </div>

                    {{-- Pilihan Jenis Zakat --}}
                    <label class="sl-zakat-label">Jenis Zakat</label>
                    <div class="sl-pill-wrap">
                        <div class="sl-pill active"  data-type="penghasilan">💼 Penghasilan</div>
                        <div class="sl-pill"          data-type="maal">🏦 Maal</div>
                        <div class="sl-pill"          data-type="emas">🥇 Emas/Perak</div>
                        <div class="sl-pill"          data-type="perdagangan">🛒 Perdagangan</div>
                        <div class="sl-pill"          data-type="pertanian">🌾 Pertanian</div>
                        <div class="sl-pill"          data-type="peternakan">🐄 Peternakan</div>
                        <div class="sl-pill"          data-type="fitrah">🌙 Fitrah</div>
                    </div>

                    {{-- Deskripsi per jenis --}}
                    <div class="sl-zakat-desc-box" id="zakatTypeDesc">
                        Zakat atas penghasilan/profesi bulanan. Tarif <strong>2,5%</strong> dari penghasilan bruto jika mencapai nisab.
                    </div>

                    {{-- ── INPUT: Penghasilan / Maal / Emas ── --}}
                    <div id="wealthInputSection">
                        <div class="mb-4">
                            <label class="sl-zakat-label" id="labelWealth">Penghasilan Bersih Per Bulan</label>
                            <div class="d-flex">
                                <span class="sl-input-prefix" id="currencyPrefix">Rp</span>
                                <input type="text" inputmode="numeric"
                                       class="form-control sl-zakat-input sl-input-with-prefix"
                                       id="total_wealth" placeholder="Contoh: 5.000.000">
                            </div>
                            <small class="sl-zakat-hint" id="nisabDesc"></small>
                        </div>
                    </div>

                    {{-- ── INPUT: Fitrah ── --}}
                    <div id="fitrahInputSection" style="display:none;">
                        <div class="mb-4">
                            <label class="sl-zakat-label">Jumlah Jiwa / Tanggungan</label>
                            <input type="number" class="sl-zakat-input" id="total_jiwa" value="1" min="1">
                            <small class="sl-zakat-hint">Standar Zakat Fitrah: Rp 50.000 / jiwa (BAZNAS Pusat)</small>
                        </div>
                    </div>

                    {{-- ── INPUT: Perdagangan ── --}}
                    <div id="perdaganganInputSection" style="display:none;">
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="sl-zakat-label">📦 Nilai Stok Barang Dagangan</label>
                                <div class="d-flex">
                                    <span class="sl-input-prefix">Rp</span>
                                    <input type="text" inputmode="numeric"
                                           class="sl-zakat-input sl-input-with-prefix"
                                           id="stok_barang" placeholder="Contoh: 50.000.000">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="sl-zakat-label">💳 Piutang Dagang yang Dapat Ditagih</label>
                                <div class="d-flex">
                                    <span class="sl-input-prefix">Rp</span>
                                    <input type="text" inputmode="numeric"
                                           class="sl-zakat-input sl-input-with-prefix"
                                           id="piutang_dagang" placeholder="Contoh: 10.000.000">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="sl-zakat-label">🏦 Kas / Bank (Modal Lancar)</label>
                                <div class="d-flex">
                                    <span class="sl-input-prefix">Rp</span>
                                    <input type="text" inputmode="numeric"
                                           class="sl-zakat-input sl-input-with-prefix"
                                           id="kas_bank" placeholder="Contoh: 20.000.000">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="sl-zakat-label">📉 Utang Dagang Jatuh Tempo</label>
                                <div class="d-flex">
                                    <span class="sl-input-prefix">Rp</span>
                                    <input type="text" inputmode="numeric"
                                           class="sl-zakat-input sl-input-with-prefix"
                                           id="utang_dagang" placeholder="Contoh: 5.000.000">
                                </div>
                                <small class="sl-zakat-hint">Utang yang jatuh tempo dalam tahun berjalan saja yang boleh dikurangi.</small>
                            </div>
                        </div>
                        {{-- Summary aset bersih live --}}
                        <div class="sl-dagang-summary">
                            <div class="sl-dagang-summary-label">Aset Bersih Dagang (Stok + Piutang + Kas − Utang)</div>
                            <div class="sl-dagang-summary-val" id="total_perdagangan_display">Rp 0</div>
                        </div>
                        <small class="sl-zakat-hint" id="nisabDesc"></small>
                    </div>

                    {{-- ── INPUT: Pertanian ── --}}
                    <div id="pertanianInputSection" style="display:none;">
                        <div class="mb-3">
                            <label class="sl-zakat-label">🌾 Sumber Pengairan</label>
                            <div class="sl-tarif-wrap">
                                <label class="sl-tarif-label">
                                    <input type="radio" name="tarif_pertanian" value="irigasi" checked>
                                    💧 Irigasi / Biaya Pengairan<br>
                                    <small style="font-weight:400;font-size:.75rem;">Tarif 5%</small>
                                </label>
                                <label class="sl-tarif-label">
                                    <input type="radio" name="tarif_pertanian" value="hujan">
                                    🌧️ Tadah Hujan / Tanpa Biaya<br>
                                    <small style="font-weight:400;font-size:.75rem;">Tarif 10%</small>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="sl-zakat-label">⚖️ Hasil Panen (Kg Gabah)</label>
                            <input type="number" class="sl-zakat-input" id="hasil_panen_kg"
                                   min="0" placeholder="Contoh: 700">
                            <small class="sl-zakat-hint" id="nisabDesc">
                                Nisab: 653 kg gabah per panen. Tidak disyaratkan haul. | Ref: Fatwa MUI No.3/2003
                            </small>
                        </div>
                        <small class="sl-zakat-hint">
                            Konversi nilai Rp menggunakan estimasi harga gabah Rp 6.000/kg. Sesuaikan dengan harga aktual daerah Anda.
                        </small>
                    </div>

                    {{-- ── INPUT: Peternakan ── --}}
                    <div id="peternakanInputSection" style="display:none;">
                        <div class="mb-3">
                            <label class="sl-zakat-label">🐄 Jenis Hewan Ternak</label>
                            <select class="sl-zakat-select" id="jenis_hewan">
                                <option value="kambing">🐑 Kambing / Domba</option>
                                <option value="sapi">🐄 Sapi</option>
                                <option value="kerbau">🦬 Kerbau (diqiyaskan sapi)</option>
                                <option value="unta">🐪 Unta</option>
                            </select>
                            <small class="sl-zakat-hint">Hewan harus berupa sa'imah (digembalakan) dan dimiliki ≥ 1 haul.</small>
                        </div>
                        <div class="mb-3">
                            <label class="sl-zakat-label">🔢 Jumlah Hewan (Ekor)</label>
                            <input type="number" class="sl-zakat-input" id="jumlah_hewan"
                                   min="0" placeholder="Contoh: 40">
                            <small class="sl-zakat-hint" id="nisabDesc"></small>
                        </div>
                    </div>

                    {{-- ── Hasil ── --}}
                    <div class="sl-res-box" id="resultBox">
                        <h6 class="fw-bold mb-2 text-uppercase" id="statusZakat" style="letter-spacing:1px;"></h6>
                        <div class="sl-res-amount" id="totalZakat">Rp 0</div>
                        <div id="extraInfo"></div>
                        <div id="payButtonContainer" style="display:none;" class="mt-4">
                            <a href="{{ url('/donasi') }}" class="sl-form-submit text-decoration-none">
                                <i class="fas fa-heart"></i>
                                <span>Tunaikan Zakat Sekarang</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>{{-- /col-lg-7 --}}


            {{-- ═══════════════════════════════════════════════════
                 KANAN: EDUKASI & PANDUAN
                 ═══════════════════════════════════════════════════ --}}
            <div class="col-lg-5 wow fadeInRight" data-wow-delay="0.15s">

                {{-- Ayat & Hadis --}}
                <div class="sl-quran-card mb-4">
                    <div class="sl-quran-arabic">وَأَقِيمُوا الصَّلَاةَ وَآتُوا الزَّكَاةَ وَارْكَعُوا مَعَ الرَّاكِعِينَ</div>
                    <div class="sl-quran-trans">"Dan dirikanlah shalat, tunaikanlah zakat, dan rukuklah beserta orang-orang yang rukuk."</div>
                    <div class="sl-quran-src">📖 QS. Al-Baqarah: 43</div>
                </div>

                <div class="sl-quran-card mb-4" style="background:linear-gradient(135deg,#1e3a5f 0%,#0f2540 100%);">
                    <div class="sl-quran-arabic" style="font-size:1rem;">بُنِيَ الإِسْلَامُ عَلَى خَمْسٍ … وَإِيتَاءِ الزَّكَاةِ</div>
                    <div class="sl-quran-trans">"Islam dibangun atas lima perkara … dan menunaikan zakat."</div>
                    <div class="sl-quran-src">📜 HR. Bukhari No. 8 & Muslim No. 16</div>
                </div>

                {{-- Panduan Nisab — accordion multi-expand --}}
                <div class="sl-zakat-card mb-4">
                    <div class="sl-form-title mb-4">
                        <div class="sl-form-icon"><i class="fas fa-book-open"></i></div>
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
                            <div id="collapseOne" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Nisab: <strong>85gr emas/tahun</strong> (atau 85/12 per bulan). Tarif <strong>2,5%</strong>. Dasar: <em>Fatwa MUI No.3/2003</em>.
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
                            <div id="collapseTwo" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Nisab: <strong>85gr emas</strong>, disimpan <strong>≥ 1 haul</strong>. Tarif <strong>2,5%</strong>. Berlaku untuk tabungan, deposito, saham, uang tunai.
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
                            <div id="collapseThree" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Nisab emas: <strong>85 gram</strong>. Nisab perak: <strong>595 gram</strong>. Tarif <strong>2,5%</strong>. Disyaratkan ≥ 1 haul.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapsePerdagangan">
                                    🛒 Zakat Perdagangan
                                </button>
                            </h2>
                            <div id="collapsePerdagangan" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Nisab: <strong>85gr emas</strong> (≥ 1 haul). Dasar hitung: <strong>(Stok + Piutang Lancar + Kas) − Utang Jatuh Tempo</strong>. Tarif <strong>2,5%</strong>. Dasar: <em>Fatwa MUI No.4/2014</em>.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapsePertanian">
                                    🌾 Zakat Pertanian
                                </button>
                            </h2>
                            <div id="collapsePertanian" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Nisab: <strong>653 kg gabah</strong> (setara 524 kg beras) per panen. <strong>Tidak perlu haul</strong>.
                                    Tarif: <strong>10%</strong> jika tadah hujan, <strong>5%</strong> jika menggunakan irigasi/biaya.
                                    Dasar: QS. Al-An'am: 141 & Fatwa MUI No.3/2003.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapsePeternakan">
                                    🐄 Zakat Peternakan
                                </button>
                            </h2>
                            <div id="collapsePeternakan" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p class="mb-2">Disyaratkan <strong>sa'imah</strong> (digembalakan) & <strong>≥ 1 haul</strong>. Kadar zakat berupa hewan, bukan uang.</p>
                                    <p class="mb-1 fw-bold text-muted" style="font-size:.75rem;">🐑 KAMBING/DOMBA</p>
                                    <table class="sl-nisab-table mb-3">
                                        <tr><th>Jumlah</th><th>Zakat</th></tr>
                                        <tr><td>1 – 39</td><td>Belum wajib</td></tr>
                                        <tr><td>40 – 120</td><td>1 ekor kambing</td></tr>
                                        <tr><td>121 – 200</td><td>2 ekor kambing</td></tr>
                                        <tr><td>201 – 399</td><td>3 ekor kambing</td></tr>
                                        <tr><td>≥ 400</td><td>+1 ekor per 100</td></tr>
                                    </table>
                                    <p class="mb-1 fw-bold text-muted" style="font-size:.75rem;">🐄 SAPI / 🦬 KERBAU</p>
                                    <table class="sl-nisab-table mb-3">
                                        <tr><th>Jumlah</th><th>Zakat</th></tr>
                                        <tr><td>1 – 29</td><td>Belum wajib</td></tr>
                                        <tr><td>30 – 39</td><td>1 ekor umur ≥ 1 th</td></tr>
                                        <tr><td>40 – 59</td><td>1 ekor umur ≥ 2 th</td></tr>
                                        <tr><td>60 – 69</td><td>2 ekor umur ≥ 1 th</td></tr>
                                        <tr><td>≥ 70</td><td>Kombinasi per 30/40 ekor</td></tr>
                                    </table>
                                    <p class="mb-1 fw-bold text-muted" style="font-size:.75rem;">🐪 UNTA</p>
                                    <table class="sl-nisab-table">
                                        <tr><th>Jumlah</th><th>Zakat</th></tr>
                                        <tr><td>1 – 4</td><td>Belum wajib</td></tr>
                                        <tr><td>5 – 9</td><td>1 ekor kambing</td></tr>
                                        <tr><td>10 – 14</td><td>2 ekor kambing</td></tr>
                                        <tr><td>25 – 35</td><td>1 ekor unta ≥ 1 th</td></tr>
                                        <tr><td>36 – 45</td><td>1 ekor unta ≥ 2 th</td></tr>
                                        <tr><td>≥ 76</td><td>2 ekor unta ≥ 2 th</td></tr>
                                    </table>
                                    <p class="mt-2 mb-0" style="font-size:.75rem;color:#94a3b8;">Ref: Kitab Fiqh Zakat, Yusuf Qardhawi & KMA RI</p>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFitrah">
                                    🌙 Zakat Fitrah
                                </button>
                            </h2>
                            <div id="collapseFitrah" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Wajib tiap Muslim yang mampu. Besaran: <strong>2,5 kg beras</strong>/jiwa atau setara <strong>Rp 45.000–55.000</strong>. Standar: <em>BAZNAS Pusat Rp 50.000</em>.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseBeda">
                                    🔍 Kenapa Berbeda dengan BSI / Platform Lain?
                                </button>
                            </h2>
                            <div id="collapseBeda" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    Platform seperti BSI menggunakan metode <strong>Netto</strong>: penghasilan dikurangi kebutuhan pokok dan cicilan dulu baru dihitung 2,5%. Kalkulator ini pakai <strong>Bruto</strong> atas dasar <em>ihtiyath</em> (Fatwa MUI No.3/2003). Keduanya sah secara syariat.
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
                        <li>Harga emas dapat diperbarui manual. Ref: <a href="https://www.logammulia.com/id/harga-emas-hari-ini" target="_blank" rel="noopener">Antam</a> / <a href="https://www.lbma.org.uk" target="_blank" rel="noopener">LBMA</a>.</li>
                        <li>Zakat Pertanian: konversi nilai Rp menggunakan estimasi harga gabah Rp 6.000/kg. Sesuaikan dengan harga aktual daerah Anda.</li>
                        <li>Zakat Peternakan dibayarkan dalam bentuk <strong>hewan</strong>, bukan uang tunai. Nilai Rp di hasil hanya estimasi.</li>
                        <li>Kalkulator ini bersifat alat bantu estimasi. Konsultasikan ke lembaga amil zakat untuk kepastian hukum.</li>
                        <li>Dasar hukum: QS. At-Taubah: 103, QS. Al-An'am: 141, HR. Bukhari & Muslim, Fatwa MUI No.3/2003 & No.4/2014.</li>
                    </ul>
                </div>

            </div>{{-- /col-lg-5 --}}

        </div>{{-- /row --}}
    </div>{{-- /container --}}
</section>
@endsection

@section('scripts')
@include('landing-page.service.zakat-calculator.components._index-scripts')
@endsection