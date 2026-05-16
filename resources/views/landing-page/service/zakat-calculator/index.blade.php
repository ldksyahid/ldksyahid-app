@extends('landing-page.template.body')

@section('styles')
@include('landing-page.service.zakat-calculator.components._index-styles')
@endsection

@section('content')
<section class="zk-section mt-5">
    <div class="container">
        <div class="zk-layout">

            {{-- ===== LEFT: INFO COLUMN ===== --}}
            <div class="zk-col-info wow fadeInLeft" data-wow-delay="0.1s">

                <p class="zk-deco-label">Kalkulator Islami</p>
                <h1 class="zk-deco-title">Kalkulator Zakat</h1>
                <div class="zk-deco-bar"></div>

                <div class="zk-deco-quote">
                    <p class="zk-quran-arabic">وَأَقِيمُوا الصَّلَاةَ وَآتُوا الزَّكَاةَ وَارْكَعُوا مَعَ الرَّاكِعِينَ</p>
                    <p>"Dan dirikanlah shalat, tunaikanlah zakat, dan rukuklah beserta orang-orang yang rukuk."</p>
                    <span>&#9679; QS. Al-Baqarah 2: 43</span>
                </div>

                <div class="zk-how-card">
                    <p class="zk-how-title"><i class="fas fa-info-circle"></i> Cara Penggunaan</p>
                    <ul class="zk-how-list">
                        <li><span class="zk-how-bullet"></span>Perbarui harga emas jika diperlukan</li>
                        <li><span class="zk-how-bullet"></span>Pilih jenis zakat yang ingin dihitung</li>
                        <li><span class="zk-how-bullet"></span>Isi data sesuai panduan pada form</li>
                        <li><span class="zk-how-bullet"></span>Hasil zakat dihitung otomatis real-time</li>
                        <li><span class="zk-how-bullet"></span>Cek panduan nisab untuk referensi hukum</li>
                    </ul>
                </div>

                <div class="zk-method-card">
                    <p class="zk-method-title"><i class="fas fa-balance-scale"></i> Metode Perhitungan</p>
                    <p class="zk-method-body">
                        Zakat Penghasilan menggunakan metode <strong>Bruto</strong> (dari penghasilan kotor)
                        atas dasar <em>ihtiyath</em> sesuai <strong>Fatwa MUI No.3/2003</strong>.
                    </p>
                </div>

            </div>{{-- /zk-col-info --}}

            {{-- ===== RIGHT: CALCULATOR FORM ===== --}}
            <div class="zk-col-form wow fadeInRight" data-wow-delay="0.2s">

                {{-- ── Main Calculator Card ── --}}
                <div class="zk-form-card">

                    {{-- Gold Price Panel --}}
                    <div class="zk-gold-panel">
                        <div class="zk-gold-shimmer"></div>
                        <div class="zk-gold-top">
                            <div class="zk-gold-brand">
                                <div class="zk-gold-icon-wrap">
                                    <i class="fas fa-coins"></i>
                                </div>
                                <div class="zk-gold-brand-info">
                                    <p class="zk-gold-brand-label">Harga Emas</p>
                                    <p class="zk-gold-brand-src">
                                        <a href="https://www.logammulia.com/id/harga-emas-hari-ini" target="_blank" rel="noopener">Antam · logammulia.com</a>
                                    </p>
                                </div>
                            </div>
                            <button type="button" class="zk-gold-fetch-btn" id="zkFetchGoldBtn">
                                <i class="fas fa-sync-alt" id="zkFetchIcon"></i>
                                <span id="zkFetchBtnText">Perbarui</span>
                            </button>
                        </div>
                        <div class="zk-gold-price-row">
                            <span class="zk-gold-price-cur">Rp</span>
                            <span class="zk-gold-price-num" id="goldPriceDisplay">2.600.000</span>
                            <span class="zk-gold-price-unit">/gram</span>
                        </div>
                        <div class="zk-gold-footer">
                            <span class="zk-gold-live-dot"></span>
                            <span class="zk-gold-live-label">Harga aktif · diperbarui otomatis</span>
                        </div>
                        <div id="zkGoldFetchStatus" class="zk-gold-fetch-status" style="display:none;"></div>
                    </div>

                    {{-- Jenis Zakat --}}
                    <div class="zk-form-group">
                        <label class="zk-form-label">
                            <i class="fas fa-mosque"></i> Jenis Zakat
                        </label>
                        <div class="zk-pill-wrap">
                            <div class="zk-pill active" data-type="penghasilan">💼 Penghasilan</div>
                            <div class="zk-pill"         data-type="maal">🏦 Maal</div>
                            <div class="zk-pill"         data-type="emas">🥇 Emas/Perak</div>
                            <div class="zk-pill"         data-type="perdagangan">🛒 Perdagangan</div>
                            <div class="zk-pill"         data-type="pertanian">🌾 Pertanian</div>
                            <div class="zk-pill"         data-type="peternakan">🐄 Peternakan</div>
                            <div class="zk-pill"         data-type="fitrah">🌙 Fitrah</div>
                        </div>
                    </div>

                    {{-- Description Box --}}
                    <div class="zk-desc-box" id="zakatTypeDesc">
                        Zakat atas penghasilan/profesi bulanan. Tarif <strong>2,5%</strong> dari penghasilan bruto jika mencapai nisab.
                    </div>

                    {{-- INPUT: Penghasilan / Maal / Emas --}}
                    <div id="wealthInputSection">
                        <div class="zk-form-group">
                            <label class="zk-form-label" id="labelWealth">Penghasilan Bersih Per Bulan</label>
                            <div class="zk-input-group">
                                <span class="zk-input-prefix" id="currencyPrefix">Rp</span>
                                <input type="text" inputmode="numeric"
                                       class="zk-form-input zk-input-with-prefix"
                                       id="total_wealth" placeholder="Contoh: 5.000.000">
                            </div>
                            <small class="zk-form-hint" id="nisabDesc"></small>
                        </div>
                    </div>

                    {{-- INPUT: Fitrah --}}
                    <div id="fitrahInputSection" style="display:none;">
                        <div class="zk-form-group">
                            <label class="zk-form-label">Jumlah Jiwa / Tanggungan</label>
                            <input type="number" class="zk-form-input" id="total_jiwa" value="1" min="1">
                            <small class="zk-form-hint">Standar Zakat Fitrah: Rp 50.000 / jiwa (BAZNAS Pusat)</small>
                        </div>
                    </div>

                    {{-- INPUT: Perdagangan --}}
                    <div id="perdaganganInputSection" style="display:none;">
                        <div class="zk-form-group">
                            <label class="zk-form-label">📦 Nilai Stok Barang Dagangan</label>
                            <div class="zk-input-group">
                                <span class="zk-input-prefix">Rp</span>
                                <input type="text" inputmode="numeric"
                                       class="zk-form-input zk-input-with-prefix"
                                       id="stok_barang" placeholder="Contoh: 50.000.000">
                            </div>
                        </div>
                        <div class="zk-form-group">
                            <label class="zk-form-label">💳 Piutang Dagang yang Dapat Ditagih</label>
                            <div class="zk-input-group">
                                <span class="zk-input-prefix">Rp</span>
                                <input type="text" inputmode="numeric"
                                       class="zk-form-input zk-input-with-prefix"
                                       id="piutang_dagang" placeholder="Contoh: 10.000.000">
                            </div>
                        </div>
                        <div class="zk-form-group">
                            <label class="zk-form-label">🏦 Kas / Bank (Modal Lancar)</label>
                            <div class="zk-input-group">
                                <span class="zk-input-prefix">Rp</span>
                                <input type="text" inputmode="numeric"
                                       class="zk-form-input zk-input-with-prefix"
                                       id="kas_bank" placeholder="Contoh: 20.000.000">
                            </div>
                        </div>
                        <div class="zk-form-group">
                            <label class="zk-form-label">📉 Utang Dagang Jatuh Tempo</label>
                            <div class="zk-input-group">
                                <span class="zk-input-prefix">Rp</span>
                                <input type="text" inputmode="numeric"
                                       class="zk-form-input zk-input-with-prefix"
                                       id="utang_dagang" placeholder="Contoh: 5.000.000">
                            </div>
                            <small class="zk-form-hint">Utang yang jatuh tempo dalam tahun berjalan saja yang boleh dikurangi.</small>
                        </div>
                        <div class="zk-dagang-summary">
                            <div class="zk-dagang-summary-label">Aset Bersih Dagang (Stok + Piutang + Kas − Utang)</div>
                            <div class="zk-dagang-summary-val" id="total_perdagangan_display">Rp 0</div>
                        </div>
                        <small class="zk-form-hint" id="nisabDescDagang"></small>
                    </div>

                    {{-- INPUT: Pertanian --}}
                    <div id="pertanianInputSection" style="display:none;">
                        <div class="zk-form-group">
                            <label class="zk-form-label">🌾 Sumber Pengairan</label>
                            <div class="zk-tarif-wrap">
                                <label class="zk-tarif-label">
                                    <input type="radio" name="tarif_pertanian" value="irigasi" checked>
                                    💧 Irigasi / Biaya Pengairan<br>
                                    <small>Tarif 5%</small>
                                </label>
                                <label class="zk-tarif-label">
                                    <input type="radio" name="tarif_pertanian" value="hujan">
                                    🌧️ Tadah Hujan / Tanpa Biaya<br>
                                    <small>Tarif 10%</small>
                                </label>
                            </div>
                        </div>
                        <div class="zk-form-group">
                            <label class="zk-form-label">⚖️ Hasil Panen (Kg Gabah)</label>
                            <input type="number" class="zk-form-input" id="hasil_panen_kg"
                                   min="0" placeholder="Contoh: 700">
                            <small class="zk-form-hint">
                                Nisab: 653 kg gabah per panen. Tidak disyaratkan haul. | Ref: Fatwa MUI No.3/2003
                            </small>
                        </div>
                        <small class="zk-form-hint">
                            Konversi nilai Rp menggunakan estimasi harga gabah Rp 6.000/kg. Sesuaikan dengan harga aktual daerah Anda.
                        </small>
                    </div>

                    {{-- INPUT: Peternakan --}}
                    <div id="peternakanInputSection" style="display:none;">
                        <div class="zk-form-group">
                            <label class="zk-form-label">🐄 Jenis Hewan Ternak</label>
                            <select class="zk-form-select" id="jenis_hewan">
                                <option value="kambing">🐑 Kambing / Domba</option>
                                <option value="sapi">🐄 Sapi</option>
                                <option value="kerbau">🦬 Kerbau (diqiyaskan sapi)</option>
                                <option value="unta">🐪 Unta</option>
                            </select>
                            <small class="zk-form-hint">Hewan harus berupa sa'imah (digembalakan) dan dimiliki ≥ 1 haul.</small>
                        </div>
                        <div class="zk-form-group">
                            <label class="zk-form-label">🔢 Jumlah Hewan (Ekor)</label>
                            <input type="number" class="zk-form-input" id="jumlah_hewan"
                                   min="0" placeholder="Contoh: 40">
                            <small class="zk-form-hint" id="nisabDescPeternakan"></small>
                        </div>
                    </div>

                    {{-- Result Box --}}
                    <div class="zk-result-box" id="resultBox">
                        <h6 class="zk-result-status" id="statusZakat"></h6>
                        <div class="zk-result-amount" id="totalZakat">Rp 0</div>
                        <div id="extraInfo"></div>
                        <div id="payButtonContainer" style="display:none;" class="mt-4">
                            <button type="button" class="zk-pay-btn" id="zkOpenOrgModal">
                                <i class="fas fa-heart"></i>
                                <span>Tunaikan Zakat Sekarang</span>
                            </button>
                        </div>
                    </div>

                </div>{{-- /zk-form-card main --}}

                {{-- ── Panduan Nisab Card ── --}}
                <div class="zk-form-card mt-4">
                    <div class="zk-card-title-wrap">
                        <div class="zk-card-title-icon"><i class="fas fa-book-open"></i></div>
                        <span class="zk-card-title">Panduan Nisab Zakat</span>
                    </div>

                    <div class="zk-accordion">

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-penghasilan">
                                <span class="zk-acc-title-text">💼 Zakat Penghasilan</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-penghasilan">
                                <div class="zk-acc-content">
                                    Nisab: <strong>85gr emas/tahun</strong> (atau 85/12 per bulan). Tarif <strong>2,5%</strong>. Dasar: <em>Fatwa MUI No.3/2003</em>.
                                </div>
                            </div>
                        </div>

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-maal">
                                <span class="zk-acc-title-text">🏦 Zakat Maal</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-maal">
                                <div class="zk-acc-content">
                                    Nisab: <strong>85gr emas</strong>, disimpan <strong>≥ 1 haul</strong>. Tarif <strong>2,5%</strong>. Berlaku untuk tabungan, deposito, saham, uang tunai.
                                </div>
                            </div>
                        </div>

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-emas">
                                <span class="zk-acc-title-text">🥇 Zakat Emas/Perak</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-emas">
                                <div class="zk-acc-content">
                                    Nisab emas: <strong>85 gram</strong>. Nisab perak: <strong>595 gram</strong>. Tarif <strong>2,5%</strong>. Disyaratkan ≥ 1 haul.
                                </div>
                            </div>
                        </div>

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-perdagangan">
                                <span class="zk-acc-title-text">🛒 Zakat Perdagangan</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-perdagangan">
                                <div class="zk-acc-content">
                                    Nisab: <strong>85gr emas</strong> (≥ 1 haul). Dasar hitung: <strong>(Stok + Piutang Lancar + Kas) − Utang Jatuh Tempo</strong>. Tarif <strong>2,5%</strong>. Dasar: <em>Fatwa MUI No.4/2014</em>.
                                </div>
                            </div>
                        </div>

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-pertanian">
                                <span class="zk-acc-title-text">🌾 Zakat Pertanian</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-pertanian">
                                <div class="zk-acc-content">
                                    Nisab: <strong>653 kg gabah</strong> (setara 524 kg beras) per panen. <strong>Tidak perlu haul</strong>.
                                    Tarif: <strong>10%</strong> jika tadah hujan, <strong>5%</strong> jika menggunakan irigasi/biaya.
                                    Dasar: QS. Al-An'am: 141 & Fatwa MUI No.3/2003.
                                </div>
                            </div>
                        </div>

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-peternakan">
                                <span class="zk-acc-title-text">🐄 Zakat Peternakan</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-peternakan">
                                <div class="zk-acc-content">
                                    <p class="mb-2">Disyaratkan <strong>sa'imah</strong> (digembalakan) &amp; <strong>≥ 1 haul</strong>. Kadar zakat berupa hewan, bukan uang.</p>
                                    <p class="zk-table-label">🐑 KAMBING/DOMBA</p>
                                    <table class="zk-nisab-table mb-3">
                                        <tr><th>Jumlah</th><th>Zakat</th></tr>
                                        <tr><td>1 – 39</td><td>Belum wajib</td></tr>
                                        <tr><td>40 – 120</td><td>1 ekor kambing</td></tr>
                                        <tr><td>121 – 200</td><td>2 ekor kambing</td></tr>
                                        <tr><td>201 – 399</td><td>3 ekor kambing</td></tr>
                                        <tr><td>≥ 400</td><td>+1 ekor per 100</td></tr>
                                    </table>
                                    <p class="zk-table-label">🐄 SAPI / 🦬 KERBAU</p>
                                    <table class="zk-nisab-table mb-3">
                                        <tr><th>Jumlah</th><th>Zakat</th></tr>
                                        <tr><td>1 – 29</td><td>Belum wajib</td></tr>
                                        <tr><td>30 – 39</td><td>1 ekor umur ≥ 1 th</td></tr>
                                        <tr><td>40 – 59</td><td>1 ekor umur ≥ 2 th</td></tr>
                                        <tr><td>60 – 69</td><td>2 ekor umur ≥ 1 th</td></tr>
                                        <tr><td>≥ 70</td><td>Kombinasi per 30/40 ekor</td></tr>
                                    </table>
                                    <p class="zk-table-label">🐪 UNTA</p>
                                    <table class="zk-nisab-table">
                                        <tr><th>Jumlah</th><th>Zakat</th></tr>
                                        <tr><td>1 – 4</td><td>Belum wajib</td></tr>
                                        <tr><td>5 – 9</td><td>1 ekor kambing</td></tr>
                                        <tr><td>10 – 14</td><td>2 ekor kambing</td></tr>
                                        <tr><td>25 – 35</td><td>1 ekor unta ≥ 1 th</td></tr>
                                        <tr><td>36 – 45</td><td>1 ekor unta ≥ 2 th</td></tr>
                                        <tr><td>≥ 76</td><td>2 ekor unta ≥ 2 th</td></tr>
                                    </table>
                                    <p class="mt-2 mb-0 zk-form-hint">Ref: Kitab Fiqh Zakat, Yusuf Qardhawi & KMA RI</p>
                                </div>
                            </div>
                        </div>

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-fitrah">
                                <span class="zk-acc-title-text">🌙 Zakat Fitrah</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-fitrah">
                                <div class="zk-acc-content">
                                    Wajib tiap Muslim yang mampu. Besaran: <strong>2,5 kg beras</strong>/jiwa atau setara <strong>Rp 45.000–55.000</strong>. Standar: <em>BAZNAS Pusat Rp 50.000</em>.
                                </div>
                            </div>
                        </div>

                        <div class="zk-acc-item">
                            <button type="button" class="zk-acc-header" data-zk-target="acc-beda">
                                <span class="zk-acc-title-text">🔍 Kenapa Berbeda dengan BSI / Platform Lain?</span>
                                <i class="fas fa-chevron-down zk-acc-chevron"></i>
                            </button>
                            <div class="zk-acc-body" id="acc-beda">
                                <div class="zk-acc-content">
                                    Platform seperti BSI menggunakan metode <strong>Netto</strong>: penghasilan dikurangi kebutuhan pokok dan cicilan dulu baru dihitung 2,5%. Kalkulator ini pakai <strong>Bruto</strong> atas dasar <em>ihtiyath</em> (Fatwa MUI No.3/2003). Keduanya sah secara syariat.
                                </div>
                            </div>
                        </div>

                    </div>{{-- /zk-accordion --}}
                </div>{{-- /panduan nisab card --}}

                {{-- ── Catatan Penting ── --}}
                <div class="zk-warning-card mt-4">
                    <p class="zk-warning-title"><i class="fas fa-exclamation-triangle"></i> Catatan Penting</p>
                    <ul class="zk-warning-list">
                        <li>Harga emas diambil otomatis dari <a href="https://www.logammulia.com/id/harga-emas-hari-ini" target="_blank" rel="noopener">logammulia.com (Antam)</a>. Gunakan tombol <em>Perbarui</em> untuk menyegarkan data.</li>
                        <li>Zakat Pertanian: konversi nilai Rp menggunakan estimasi harga gabah Rp 6.000/kg. Sesuaikan dengan harga aktual daerah Anda.</li>
                        <li>Zakat Peternakan dibayarkan dalam bentuk <strong>hewan</strong>, bukan uang tunai. Nilai Rp di hasil hanya estimasi.</li>
                        <li>Kalkulator ini bersifat alat bantu estimasi. Konsultasikan ke lembaga amil zakat untuk kepastian hukum.</li>
                        <li>Dasar hukum: QS. At-Taubah: 103, QS. Al-An'am: 141, HR. Bukhari &amp; Muslim, Fatwa MUI No.3/2003 &amp; No.4/2014.</li>
                    </ul>
                </div>

            </div>{{-- /zk-col-form --}}

        </div>{{-- /zk-layout --}}
    </div>{{-- /container --}}
</section>
{{-- ===== POPUP: Pilih Lembaga Zakat ===== --}}
<div class="zk-org-backdrop" id="zkOrgBackdrop"></div>
<div class="zk-org-modal" id="zkOrgModal" role="dialog" aria-modal="true" aria-label="Pilih Lembaga Zakat">
    <div class="zk-org-modal-inner">

        <button type="button" class="zk-org-close" id="zkOrgClose" aria-label="Close">
            <i class="fas fa-times"></i>
        </button>

        <div class="zk-org-header">
            <p class="zk-org-header-label">Tunaikan Zakatmu</p>
            <h5 class="zk-org-header-title">Pilih Lembaga Zakat Terpercaya</h5>
        </div>

        <p class="zk-org-subtitle">
            Semua lembaga di bawah terdaftar resmi dan terpercaya dalam pengelolaan zakat di Indonesia.
        </p>

        <div class="zk-org-grid">

            <a href="https://digital.dompetdhuafa.org/" target="_blank" rel="noopener" class="zk-org-card">
                <div class="zk-org-logo-wrap">
                    <img src="https://logo.clearbit.com/dompetdhuafa.org"
                         alt="Dompet Dhuafa" class="zk-org-logo"
                         onerror="this.onerror=null;this.src='https://www.google.com/s2/favicons?domain=dompetdhuafa.org&sz=64'">
                </div>
                <span class="zk-org-name">Dompet Dhuafa</span>
                <span class="zk-org-tagline">Zakat, Infak &amp; Sedekah</span>
                <span class="zk-org-cta">Bayar Zakat <i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="https://www.rumahzakat.org/" target="_blank" rel="noopener" class="zk-org-card">
                <div class="zk-org-logo-wrap">
                    <img src="https://logo.clearbit.com/rumahzakat.org"
                         alt="Rumah Zakat" class="zk-org-logo"
                         onerror="this.onerror=null;this.src='https://www.google.com/s2/favicons?domain=rumahzakat.org&sz=64'">
                </div>
                <span class="zk-org-name">Rumah Zakat</span>
                <span class="zk-org-tagline">Berbagi untuk Sesama</span>
                <span class="zk-org-cta">Bayar Zakat <i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="https://baznas.go.id/" target="_blank" rel="noopener" class="zk-org-card">
                <div class="zk-org-logo-wrap">
                    <img src="https://logo.clearbit.com/baznas.go.id"
                         alt="BAZNAS" class="zk-org-logo"
                         onerror="this.onerror=null;this.src='https://www.google.com/s2/favicons?domain=baznas.go.id&sz=64'">
                </div>
                <span class="zk-org-name">BAZNAS</span>
                <span class="zk-org-tagline">Badan Amil Zakat Nasional</span>
                <span class="zk-org-cta">Bayar Zakat <i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="https://donasi.lazismu.org/" target="_blank" rel="noopener" class="zk-org-card">
                <div class="zk-org-logo-wrap">
                    <img src="https://logo.clearbit.com/lazismu.org"
                         alt="Lazismu" class="zk-org-logo"
                         onerror="this.onerror=null;this.src='https://www.google.com/s2/favicons?domain=lazismu.org&sz=64'">
                </div>
                <span class="zk-org-name">Lazismu</span>
                <span class="zk-org-tagline">Zakat Infak Sedekah Muhammadiyah</span>
                <span class="zk-org-cta">Bayar Zakat <i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="https://rumah-yatim.org/" target="_blank" rel="noopener" class="zk-org-card">
                <div class="zk-org-logo-wrap">
                    <img src="https://logo.clearbit.com/rumah-yatim.org"
                         alt="Rumah Yatim" class="zk-org-logo"
                         onerror="this.onerror=null;this.src='https://www.google.com/s2/favicons?domain=rumah-yatim.org&sz=64'">
                </div>
                <span class="zk-org-name">Rumah Yatim</span>
                <span class="zk-org-tagline">Berbagi Bersama Yatim &amp; Dhuafa</span>
                <span class="zk-org-cta">Bayar Zakat <i class="fas fa-arrow-right"></i></span>
            </a>

            <a href="https://kitabisa.com/" target="_blank" rel="noopener" class="zk-org-card">
                <div class="zk-org-logo-wrap">
                    <img src="https://logo.clearbit.com/kitabisa.com"
                         alt="Kitabisa" class="zk-org-logo"
                         onerror="this.onerror=null;this.src='https://www.google.com/s2/favicons?domain=kitabisa.com&sz=64'">
                </div>
                <span class="zk-org-name">Kitabisa</span>
                <span class="zk-org-tagline">Platform Donasi &amp; Zakat Online</span>
                <span class="zk-org-cta">Bayar Zakat <i class="fas fa-arrow-right"></i></span>
            </a>

        </div>{{-- /zk-org-grid --}}
    </div>{{-- /zk-org-modal-inner --}}
</div>{{-- /zk-org-modal --}}

@endsection

@section('scripts')
@include('landing-page.service.zakat-calculator.components._index-scripts')
@endsection
