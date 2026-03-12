@extends('landing-page.template.body')

@section('styles')
@include('landing-page.service.proker-counter.components._index-styles')
@endsection

@section('content')
<section class="kk-section mt-5">
    <div class="container">
        <div class="kk-layout">

            {{-- ===== LEFT: INFO COLUMN ===== --}}
            <div class="kk-col-info wow fadeInLeft" data-wow-delay="0.1s">

                <p class="kk-deco-label">Alat Evaluasi</p>
                <h1 class="kk-deco-title">Kalkulator Kestari</h1>
                <div class="kk-deco-bar"></div>

                <div class="kk-deco-quote">
                    <p>"Dan janganlah kamu mengikuti sesuatu yang tidak kamu ketahui. Karena pendengaran, penglihatan, dan hati nurani, semua itu akan diminta pertanggungjawabannya."</p>
                    <span>&#9679; QS. Al-Isra' 17: 36</span>
                </div>

                <div class="kk-how-card">
                    <p class="kk-how-title"><i class="fas fa-info-circle"></i> Cara Penggunaan</p>
                    <ul class="kk-how-list">
                        <li><span class="kk-how-bullet"></span>Isi nama program kerja divisimu</li>
                        <li><span class="kk-how-bullet"></span>Sesuaikan jumlah pelaksanaan proker</li>
                        <li><span class="kk-how-bullet"></span>Buka tiap kriteria dan lengkapi datanya</li>
                        <li><span class="kk-how-bullet"></span>Nilai dihitung otomatis secara real-time</li>
                        <li><span class="kk-how-bullet"></span>Lihat rekap nilai di tabel evaluasi</li>
                    </ul>
                </div>

                {{-- Mobile: Lihat Rekap button --}}
                <button class="kk-view-score-btn d-lg-none" id="kk-view-score-btn" type="button">
                    <i class="fas fa-chart-pie"></i> Lihat Rekap Nilai
                </button>

            </div>{{-- /kk-col-info --}}

            {{-- ===== RIGHT: CALCULATOR FORM ===== --}}
            <div class="kk-col-form wow fadeInRight" data-wow-delay="0.2s">
                <div class="kk-form-card">

                    {{-- Program Name --}}
                    <div class="kk-form-group">
                        <label class="kk-form-label" for="proker1">
                            <i class="fas fa-clipboard-list"></i> Nama Program Kerja
                        </label>
                        <input type="text" class="kk-form-input" id="proker1"
                               placeholder="e.g. Workshop Keadministrasian"
                               oninput="refreshValue()">
                    </div>

                    {{-- ======================================================
                         REQUIRED WRAPPER: article.proker > div#proker_1
                         (external code.js uses these selectors)
                         ====================================================== --}}
                    <article class="proker">
                    <div id="proker_1">

                    {{-- Jumlah Pelaksanaan counter MUST be inside div#proker_1:
                         code.js:637 does global querySelector("p[id='jumlah_pelaksanaan']")
                         code.js:643 does parent.querySelector("p[id='jumlah_pelaksanaan']")
                         where parent = article.proker div#proker_1 --}}
                    <div class="kk-counter-wrap">
                        <span class="kk-counter-label">
                            <i class="fas fa-redo-alt"></i> Jumlah Pelaksanaan
                        </span>
                        <div class="kk-counter-controls">
                            <button type="button" class="kk-counter-btn kk-counter-min"
                                    onclick="kurang_pelaksanaan(1), refreshValue()">
                                <i class="fas fa-minus"></i>
                            </button>
                            <p class="kk-counter-val" id="jumlah_pelaksanaan">1</p>
                            <button type="button" class="kk-counter-btn kk-counter-plus"
                                    onclick="tambah_pelaksanaan(1), refreshValue()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ── ACCORDION ── --}}
                    <div class="kk-accordion">

                        {{-- SECTION 1: Kesesuaian Rencana (20%) --}}
                        <div class="kk-acc-item">
                            <button type="button" class="kk-acc-header collapsible">
                                <div class="kk-acc-header-left">
                                    <span class="kk-acc-weight">20%</span>
                                    <span class="kk-acc-title-text">Kesesuaian Rencana</span>
                                </div>
                                <div class="kk-acc-header-right">
                                    <span class="kk-acc-score persentase nilai" id="sesuai_rencana">-</span>
                                    <i class="fas fa-chevron-down kk-acc-chevron"></i>
                                </div>
                            </button>
                            <div class="kk-acc-body collapcontent">
                                <div class="unsur rencana">
                                    <div class="unsur">
                                        {{-- add_element kept for JS layout compatibility --}}
                                        <div class="kk-dyn-wrap add_element">
                                            <p class="kk-dyn-label">Deskripsi Program</p>
                                            <div class="kk-dyn-btns">
                                                <button type="button" class="kk-dyn-btn kk-dyn-add"
                                                        onclick="tambah_deskripsi(1), refreshValue()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="kk-dyn-btn kk-dyn-remove"
                                                        onclick="kurang_deskripsi(1), refreshValue()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div id="deskripsi_1">
                                            <div class="kk-check-row">
                                                <input type="text" class="kk-form-input"
                                                       name="target_1" placeholder="Memberikan Penyuluhan"
                                                       onchange="refreshValue()">
                                                <div class="kk-exec-area">
                                                    <span class="kk-exec-hint">Terlaksana di pelaksanaan ke:</span>
                                                    {{-- class="deskripsi" must be EXACT for external JS --}}
                                                    <div class="deskripsi">
                                                        <label class="kk-exec-item">
                                                            <input type="checkbox" class="kk-check"
                                                                   name="terlaksana" onchange="refreshValue()">
                                                            <span class="kk-exec-num">1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2: Kesesuaian Tujuan dan Sasaran (25%) --}}
                        <div class="kk-acc-item">
                            <button type="button" class="kk-acc-header collapsible">
                                <div class="kk-acc-header-left">
                                    <span class="kk-acc-weight">25%</span>
                                    <span class="kk-acc-title-text">Kesesuaian Tujuan &amp; Sasaran</span>
                                </div>
                                <div class="kk-acc-header-right">
                                    <span class="kk-acc-score persentase nilai" id="sesuai_tujuansasaran">-</span>
                                    <i class="fas fa-chevron-down kk-acc-chevron"></i>
                                </div>
                            </button>
                            <div class="kk-acc-body collapcontent">
                                <div class="unsur tujuansasaran">

                                    {{-- Tujuan --}}
                                    <div class="unsur tujuan">
                                        <div class="kk-dyn-wrap add_element">
                                            <p class="kk-dyn-label">
                                                Tujuan
                                                <span class="kk-inline-score nilai" id="sesuai_tujuan">-</span>
                                            </p>
                                            <div class="kk-dyn-btns">
                                                <button type="button" class="kk-dyn-btn kk-dyn-add"
                                                        onclick="tambah_tujuan(1), refreshValue()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="kk-dyn-btn kk-dyn-remove"
                                                        onclick="kurang_tujuan(1), refreshValue()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="tujuan_1">
                                            <div class="kk-check-row">
                                                <input type="text" class="kk-form-input"
                                                       name="target_1" placeholder="Memahami regulasi administrasi"
                                                       onchange="refreshValue()">
                                                <div class="kk-exec-area">
                                                    <span class="kk-exec-hint">Terlaksana di pelaksanaan ke:</span>
                                                    {{-- class="tujuan" must be EXACT for external JS --}}
                                                    <div class="tujuan">
                                                        <label class="kk-exec-item">
                                                            <input type="checkbox" class="kk-check"
                                                                   name="terlaksana" onchange="refreshValue()">
                                                            <span class="kk-exec-num">1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sasaran --}}
                                    <div class="unsur sasaran">
                                        <div class="kk-dyn-wrap add_element">
                                            <p class="kk-dyn-label">
                                                Sasaran
                                                <span class="kk-inline-score nilai" id="sesuai_sasaran">-</span>
                                            </p>
                                            <div class="kk-dyn-btns">
                                                <button type="button" class="kk-dyn-btn kk-dyn-add"
                                                        onclick="tambah_sasaran(1), refreshValue()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="kk-dyn-btn kk-dyn-remove"
                                                        onclick="kurang_sasaran(1), refreshValue()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="sasaran_1">
                                            <div class="kk-check-row">
                                                <input type="text" class="kk-form-input"
                                                       name="target_1" placeholder="Pengurus LDK Syahid"
                                                       onchange="refreshValue()">
                                                <div class="kk-exec-area">
                                                    <span class="kk-exec-hint">Terlaksana di pelaksanaan ke:</span>
                                                    {{-- class="sasaran" must be EXACT for external JS --}}
                                                    <div class="sasaran">
                                                        <label class="kk-exec-item">
                                                            <input type="checkbox" class="kk-check"
                                                                   name="terlaksana" onchange="refreshValue()">
                                                            <span class="kk-exec-num">1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- SECTION 3: Kesesuaian Waktu dan Tempat (15%) --}}
                        <div class="kk-acc-item">
                            <button type="button" class="kk-acc-header collapsible">
                                <div class="kk-acc-header-left">
                                    <span class="kk-acc-weight">15%</span>
                                    <span class="kk-acc-title-text">Kesesuaian Waktu &amp; Tempat</span>
                                </div>
                                <div class="kk-acc-header-right">
                                    <span class="kk-acc-score persentase nilai" id="sesuai_waktutempat">-</span>
                                    <i class="fas fa-chevron-down kk-acc-chevron"></i>
                                </div>
                            </button>
                            <div class="kk-acc-body collapcontent">
                                <div class="unsur waktutempat">

                                    {{-- Waktu --}}
                                    <div class="unsur waktu">
                                        <p class="kk-subsection-title">
                                            Waktu
                                            <span class="kk-inline-score nilai" id="sesuai_waktu">-</span>
                                        </p>

                                        {{-- Tanggal — class="tanggal" EXACT for JS --}}
                                        <div class="tanggal">
                                            <p class="kk-radio-label-p">
                                                Tanggal
                                                <span class="kk-inline-score nilai" id="sesuai_tanggal">-</span>
                                            </p>
                                            <div class="kk-radio-options-label">
                                                <span>Sesuai</span>
                                                <span>±1–7 hr</span>
                                                <span>±8–14 hr</span>
                                                <span>≥15 hr</span>
                                            </div>
                                            {{-- class="choices" EXACT for JS --}}
                                            <div class="choices">
                                                <label class="kk-radio-wrap">
                                                    <input type="radio" class="kk-radio-input" name="tanggal_1" id="sesuai" value="25" onchange="refreshValue()">
                                                </label>
                                                <label class="kk-radio-wrap">
                                                    <input type="radio" class="kk-radio-input" name="tanggal_1" id="telat1minggu" value="20" onchange="refreshValue()">
                                                </label>
                                                <label class="kk-radio-wrap">
                                                    <input type="radio" class="kk-radio-input" name="tanggal_1" id="telat2minggu" value="15" onchange="refreshValue()">
                                                </label>
                                                <label class="kk-radio-wrap">
                                                    <input type="radio" class="kk-radio-input" name="tanggal_1" id="telat3minggu" value="5" onchange="refreshValue()">
                                                </label>
                                            </div>

                                            {{-- Jam --}}
                                            <p class="kk-radio-label-p" style="margin-top:.85rem">
                                                Jam
                                                <span class="kk-inline-score nilai" id="sesuai_jam">-</span>
                                            </p>
                                            <div class="kk-radio-options-label">
                                                <span>Sesuai</span>
                                                <span>+1–15 m</span>
                                                <span>+16–30 m</span>
                                                <span>≥31 m</span>
                                            </div>
                                            {{-- class="jam" EXACT for JS (nested in tanggal div here) --}}
                                            <div class="jam">
                                                {{-- class="choices" EXACT for JS --}}
                                                <div class="choices">
                                                    <label class="kk-radio-wrap">
                                                        <input type="radio" class="kk-radio-input" name="jam_1" id="sesuai" value="25" onchange="refreshValue()">
                                                    </label>
                                                    <label class="kk-radio-wrap">
                                                        <input type="radio" class="kk-radio-input" name="jam_1" id="telatseperempat" value="20" onchange="refreshValue()">
                                                    </label>
                                                    <label class="kk-radio-wrap">
                                                        <input type="radio" class="kk-radio-input" name="jam_1" id="telatsetengah" value="15" onchange="refreshValue()">
                                                    </label>
                                                    <label class="kk-radio-wrap">
                                                        <input type="radio" class="kk-radio-input" name="jam_1" id="telatsejam" value="5" onchange="refreshValue()">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>{{-- /tanggal --}}
                                    </div>{{-- /waktu --}}

                                    {{-- Tempat --}}
                                    <div class="unsur tempat">
                                        <div class="kk-dyn-wrap add_element">
                                            <p class="kk-dyn-label">
                                                Tempat
                                                <span class="kk-inline-score nilai" id="sesuai_tempat">-</span>
                                            </p>
                                            <div class="kk-dyn-btns">
                                                <button type="button" class="kk-dyn-btn kk-dyn-add"
                                                        onclick="tambah_tempat(1), refreshValue()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="kk-dyn-btn kk-dyn-remove"
                                                        onclick="kurang_tempat(1), refreshValue()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="tempat_1">
                                            <div class="kk-check-row">
                                                <input type="text" class="kk-form-input"
                                                       name="target_1" placeholder="Ruang RK-09"
                                                       onchange="refreshValue()">
                                                <div class="kk-exec-area">
                                                    <span class="kk-exec-hint">Sesuai di pelaksanaan ke:</span>
                                                    {{-- class="tempat" EXACT for JS --}}
                                                    <div class="tempat">
                                                        <label class="kk-exec-item">
                                                            <input type="checkbox" class="kk-check"
                                                                   name="terlaksana" onchange="refreshValue()">
                                                            <span class="kk-exec-num">1</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- SECTION 4: Kesesuaian Parameter Keberhasilan (30%) --}}
                        <div class="kk-acc-item">
                            <button type="button" class="kk-acc-header collapsible">
                                <div class="kk-acc-header-left">
                                    <span class="kk-acc-weight">30%</span>
                                    <span class="kk-acc-title-text">Parameter Keberhasilan</span>
                                </div>
                                <div class="kk-acc-header-right">
                                    <span class="kk-acc-score persentase nilai" id="sesuai_parameter">-</span>
                                    <i class="fas fa-chevron-down kk-acc-chevron"></i>
                                </div>
                            </button>
                            <div class="kk-acc-body collapcontent">
                                <div class="unsur parameter">
                                    <div class="unsur">
                                        <div class="kk-dyn-wrap add_element">
                                            <p class="kk-dyn-label">Parameter</p>
                                            <div class="kk-dyn-btns">
                                                <button type="button" class="kk-dyn-btn kk-dyn-add"
                                                        onclick="tambah_parameter(1), refreshValue()">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                                <button type="button" class="kk-dyn-btn kk-dyn-remove"
                                                        onclick="kurang_parameter(1), refreshValue()">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="parameter_1">
                                            <span class="kk-inline-score nilai"></span>
                                            <div class="kk-param-row">
                                                <input type="number" class="kk-form-input" name="target_1"
                                                       id="estimasi_parameter" placeholder="Estimasi (10)"
                                                       min="1" oninput="refreshValue()">
                                                <input type="text" class="kk-form-input" name="parameter"
                                                       placeholder="Satuan (e.g. anggota)"
                                                       onchange="refreshValue()">
                                            </div>
                                            <p class="kk-form-label-sm kk-realisasi-heading">Realisasi per pelaksanaan</p>
                                            {{-- class="parameter" EXACT for JS --}}
                                            <div class="parameter">
                                                <div class="kk-realisasi-row">
                                                    <span class="kk-realisasi-label">Ke-1</span>
                                                    <input type="number" class="kk-form-input" name="terlaksana"
                                                           id="realisasi_parameter" placeholder="10"
                                                           min="1" oninput="refreshValue()">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 5: Akurasi Dana (10%) --}}
                        <div class="kk-acc-item">
                            <button type="button" class="kk-acc-header collapsible">
                                <div class="kk-acc-header-left">
                                    <span class="kk-acc-weight">10%</span>
                                    <span class="kk-acc-title-text">Akurasi Dana</span>
                                </div>
                                <div class="kk-acc-header-right">
                                    <span class="kk-acc-score persentase nilai" id="efisiensi_dana">-</span>
                                    <i class="fas fa-chevron-down kk-acc-chevron"></i>
                                </div>
                            </button>
                            <div class="kk-acc-body collapcontent">
                                {{-- class="efisiensi_dana" needed for external JS selectors --}}
                                <div class="unsur efisiensi_dana">
                                    <div class="kk-form-group kk-form-group--inner">
                                        <label class="kk-form-label-sm">Estimasi Dana (Rp)</label>
                                        <input type="number" class="kk-form-input" name="estimation"
                                               id="estimasi_dana" placeholder="1000000"
                                               min="0" oninput="refreshValue()" autocomplete="off">
                                    </div>
                                    <div class="kk-form-group kk-form-group--inner">
                                        <label class="kk-form-label-sm">Realisasi Dana (Rp)</label>
                                        {{-- class="akurasi" EXACT for JS --}}
                                        <div class="akurasi">
                                            <div class="kk-realisasi-row">
                                                <span class="kk-realisasi-label">Ke-1</span>
                                                <input type="number" class="kk-form-input" name="realization"
                                                       id="realisasi_dana" placeholder="0"
                                                       oninput="refreshValue()" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kk-form-group kk-form-group--inner">
                                        <label class="kk-form-label-sm">Skala Penurunan</label>
                                        <input type="text" class="kk-form-input kk-input-disabled"
                                               name="scale" id="skala_penurunan" placeholder="4" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>{{-- /kk-accordion --}}

                    {{-- ── RESULT TABLE (desktop) ── --}}
                    <div class="kk-result-section resultproker">
                        <div class="kk-proker-summary">
                            <div>
                                <p class="kk-proker-name-label">Program Kerja</p>
                                <p class="kk-proker-name-val">
                                    <span id="namaproker">—</span>
                                </p>
                            </div>
                            <div class="kk-proker-score-wrap">
                                <p class="kk-proker-score-label">Total Nilai</p>
                                <span class="kk-proker-total persentase" id="persen_proker">0</span>
                            </div>
                        </div>

                        <p class="kk-result-title">
                            <i class="fas fa-table"></i> Tabel Evaluasi
                        </p>
                        <div class="kk-table-wrap">
                            <table class="kk-table">
                                <thead>
                                    <tr>
                                        <th>Konten Evaluasi</th>
                                        <th>Bobot</th>
                                        <th style="text-align:right">Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Kesesuaian Rencana</td>
                                        <td>20%</td>
                                        <td class="konteneval" id="sesuai_rencana"></td>
                                    </tr>
                                    <tr>
                                        <td>Kesesuaian Tujuan &amp; Sasaran</td>
                                        <td>25%</td>
                                        <td class="konteneval" id="sesuai_tujuansasaran"></td>
                                    </tr>
                                    <tr>
                                        <td>Kesesuaian Waktu &amp; Tempat</td>
                                        <td>15%</td>
                                        <td class="konteneval" id="sesuai_waktutempat"></td>
                                    </tr>
                                    <tr>
                                        <td>Kesesuaian Parameter Keberhasilan</td>
                                        <td>30%</td>
                                        <td class="konteneval" id="sesuai_parameter"></td>
                                    </tr>
                                    <tr>
                                        <td>Akurasi Dana</td>
                                        <td>10%</td>
                                        <td class="konteneval" id="efisiensi_dana"></td>
                                    </tr>
                                    <tr class="kk-table-total">
                                        <td colspan="2"><strong>Total Nilai Program Kerja</strong></td>
                                        <td class="konteneval" id="persen_proker"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <p class="kk-credit">Kalkulator Kestari dibuat oleh Biro Kestari 25</p>
                    </div>{{-- /kk-result-section --}}

                    </div>{{-- /proker_1 --}}
                    </article>{{-- /proker --}}

                </div>{{-- /kk-form-card --}}
            </div>{{-- /kk-col-form --}}

        </div>{{-- /kk-layout --}}
    </div>{{-- /container --}}
</section>

{{-- ===== MOBILE BOTTOM SHEET: SCORE RESULTS ===== --}}
<div class="kk-bs-backdrop" id="kk-bs-backdrop"></div>
<div class="kk-bottom-sheet" id="kk-bottom-sheet" role="dialog" aria-modal="true" aria-label="Rekap Nilai">
    <button class="kk-bs-close" id="kk-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="kk-bs-content" id="kk-bs-content">
        {{-- Populated by JS --}}
    </div>
</div>

@endsection

@section('scripts')
@include('landing-page.service.proker-counter.components._index-scripts')
@endsection
