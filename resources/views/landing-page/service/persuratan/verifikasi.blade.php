@extends('landing-page.template.body')

@section('title', $title ?? 'Verifikasi Keaslian Dokumen')

@section('styles')
<style>
/* ── Modern Verification Page Styles ───────────────────────── */
.vfy-section {
    padding: 7rem 0 5rem;
    min-height: 100vh;
    background: radial-gradient(circle at 50% 10%, rgba(14, 165, 233, 0.08) 0%, rgba(248, 250, 252, 0.95) 70%);
    position: relative;
}

.vfy-card {
    background: #ffffff;
    border-radius: 28px;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.06);
    padding: 2.75rem 2.5rem;
    position: relative;
    overflow: hidden;
    animation: vfyFadeUp 0.45s ease both;
}

@media (max-width: 575.98px) {
    .vfy-card {
        padding: 2rem 1.35rem;
        border-radius: 22px;
    }
}

/* Security Ribbon / Seal */
.vfy-seal-wrap {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}
.vfy-seal-wrap.success {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    color: #10b981;
    box-shadow: 0 0 0 8px rgba(16, 185, 129, 0.12), 0 8px 24px rgba(16, 185, 129, 0.2);
}
.vfy-seal-wrap.warning {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    color: #f59e0b;
    box-shadow: 0 0 0 8px rgba(245, 158, 11, 0.12), 0 8px 24px rgba(245, 158, 11, 0.2);
}
.vfy-seal-wrap.danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #ef4444;
    box-shadow: 0 0 0 8px rgba(239, 68, 68, 0.12), 0 8px 24px rgba(239, 68, 68, 0.2);
}

.vfy-seal-icon {
    font-size: 2.5rem;
}

.vfy-title {
    font-size: 1.65rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.5rem;
    line-height: 1.25;
}
.vfy-sub {
    font-size: 0.92rem;
    color: #64748b;
    line-height: 1.6;
    max-width: 520px;
    margin: 0 auto 1.75rem;
}

/* Certificate Data Sheet */
.vfy-data-sheet {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 20px;
    padding: 1.5rem 1.65rem;
    margin-bottom: 1.75rem;
    text-align: left;
}

@media (max-width: 575.98px) {
    .vfy-data-sheet {
        padding: 1.2rem 1rem;
    }
}

.vfy-data-row {
    display: flex;
    flex-direction: column;
    padding: 0.65rem 0;
    border-bottom: 1px dashed #e2e8f0;
}
.vfy-data-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.vfy-data-row:first-child {
    padding-top: 0;
}

@media (min-width: 576px) {
    .vfy-data-row {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }
}

.vfy-data-label {
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-bottom: 0.2rem;
}
@media (min-width: 576px) {
    .vfy-data-label {
        margin-bottom: 0;
        min-width: 150px;
    }
}

.vfy-data-val {
    font-size: 0.92rem;
    font-weight: 700;
    color: #0f172a;
    text-align: left;
}
@media (min-width: 576px) {
    .vfy-data-val {
        text-align: right;
    }
}

.vfy-code-badge {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-size: 0.85rem;
    color: #0369a1;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

/* Security Notice Box */
.vfy-notice-box {
    background: linear-gradient(135deg, rgba(14, 165, 233, 0.06) 0%, rgba(224, 242, 254, 0.4) 100%);
    border: 1px solid #bae6fd;
    border-radius: 14px;
    padding: 0.9rem 1.15rem;
    font-size: 0.82rem;
    color: #0369a1;
    line-height: 1.5;
    margin-bottom: 1.75rem;
    display: flex;
    align-items: center;
    gap: 0.65rem;
    text-align: left;
}

/* Search Other Token */
.vfy-search-box {
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    border-radius: 16px;
    padding: 0.4rem 0.4rem 0.4rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
}
.vfy-search-input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 0.9rem;
    color: #0f172a;
    font-family: inherit;
}
.vfy-search-btn {
    background: #0ea5e9;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 0.65rem 1.25rem;
    font-size: 0.85rem;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    white-space: nowrap;
}
.vfy-search-btn:hover {
    background: #0284c7;
    color: #ffffff;
}

/* Action Buttons */
.vfy-btn-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    color: #ffffff;
    border: none;
    border-radius: 14px;
    padding: 0.85rem 1.5rem;
    font-size: 0.92rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(14, 165, 233, 0.3);
    transition: all 0.25s;
}
.vfy-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(14, 165, 233, 0.4);
    color: #ffffff;
}

.vfy-btn-outline {
    background: #ffffff;
    color: #475569;
    border: 1.5px solid #cbd5e1;
    border-radius: 14px;
    padding: 0.85rem 1.5rem;
    font-size: 0.92rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
    transition: all 0.2s;
}
.vfy-btn-outline:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}

@keyframes vfyFadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: none; }
}
</style>
@endsection

@section('content')

<section class="vfy-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7 text-center">

                {{-- ── CARD UTAMA VERIFIKASI ────────────────────────── --}}
                <div class="vfy-card">

                    {{-- ── CASE 1: DOKUMEN RESMI TERVERIFIKASI (APPROVED) ── --}}
                    @if ($suratLog && $suratLog->status === 'approved')

                        <div class="vfy-seal-wrap success">
                            <i class="fas fa-shield-check vfy-seal-icon"></i>
                        </div>

                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background:#dcfce7; color:#15803d; font-size:0.78rem; font-weight:700; border:1px solid #86efac;">
                            <i class="fas fa-certificate"></i>
                            <span>DOKUMEN RESMI SAH</span>
                        </div>

                        <h1 class="vfy-title">Dokumen Resmi Terverifikasi</h1>
                        <p class="vfy-sub">
                            Surat ini dinyatakan <strong>ASLI</strong> dan sah terdaftar dalam basis data arsip administrasi digital UKM LDK Syahid UIN Syarif Hidayatullah Jakarta.
                        </p>

                        <div class="vfy-data-sheet">
                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Nomor Surat Resmi</span>
                                <span class="vfy-data-val font-monospace" style="color:#0284c7; font-size:1rem;">
                                    {{ $suratLog->nomor_surat }}
                                </span>
                            </div>

                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Jenis Dokumen</span>
                                <span class="vfy-data-val">{{ $suratLog->label }}</span>
                            </div>

                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Atas Nama / Pengaju</span>
                                <span class="vfy-data-val">{{ $suratLog->user?->name ?? '-' }}</span>
                            </div>

                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Asal Bidang / LDKSF</span>
                                <span class="vfy-data-val">
                                    @if ($suratLog->kodeBidangPengaju())
                                        <span class="badge bg-light text-dark border me-1">{{ $suratLog->kodeBidangPengaju() }}</span>
                                    @endif
                                    {{ $suratLog->labelBidangPengaju() }}
                                </span>
                            </div>

                            @php
                                $namaKegiatan = $suratLog->data['nama_acara'] 
                                    ?? $suratLog->data['nama_kegiatan'] 
                                    ?? $suratLog->data['nama_program'] 
                                    ?? null;
                            @endphp
                            @if ($namaKegiatan)
                                <div class="vfy-data-row">
                                    <span class="vfy-data-label">Perihal / Kegiatan</span>
                                    <span class="vfy-data-val">{{ $namaKegiatan }}</span>
                                </div>
                            @endif

                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Tanggal Penerbitan</span>
                                <span class="vfy-data-val">
                                    <i class="fas fa-calendar-check me-1 text-success"></i>
                                    {{ $suratLog->approved_at ? $suratLog->approved_at->locale('id')->translatedFormat('d F Y') : '-' }}
                                </span>
                            </div>

                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Token Keaslian</span>
                                <span class="vfy-data-val">
                                    <code class="vfy-code-badge">{{ $kode }}</code>
                                </span>
                            </div>
                        </div>

                        <div class="vfy-notice-box">
                            <i class="fas fa-lock fs-5 flex-shrink-0"></i>
                            <div>
                                Dokumen ini dilindungi integritasnya dengan tanda tangan digital resmi dan QR Code verifikasi real-time dari UKM LDK Syahid.
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            <a href="{{ route('service.persuratan.download', $suratLog) }}" class="vfy-btn-primary">
                                <i class="fas fa-download"></i> Unduh Berkas PDF
                            </a>
                            <a href="{{ route('service.persuratan.index') }}" class="vfy-btn-outline">
                                <i class="fas fa-feather-alt"></i> Layanan Persuratan
                            </a>
                        </div>


                    {{-- ── CASE 2: DOKUMEN DALAM PENINJAUAN (PENDING) ─────── --}}
                    @elseif ($suratLog && $suratLog->status === 'pending')

                        <div class="vfy-seal-wrap warning">
                            <i class="fas fa-clock-rotate-left vfy-seal-icon"></i>
                        </div>

                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background:#fef3c7; color:#b45309; font-size:0.78rem; font-weight:700; border:1px solid #fcd34d;">
                            <i class="fas fa-hourglass-half"></i>
                            <span>DALAM PROSES PENINJAUAN</span>
                        </div>

                        <h1 class="vfy-title">Dokumen Sedang Diproses</h1>
                        <p class="vfy-sub">
                            Dokumen dengan kode ini telah terdaftar di sistem, namun masih menunggu verifikasi dan penerbitan nomor resmi dari Biro Kesekretariatan LDK Syahid.
                        </p>

                        <div class="vfy-data-sheet">
                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Jenis Surat</span>
                                <span class="vfy-data-val">{{ $suratLog->label }}</span>
                            </div>
                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Nama Pengaju</span>
                                <span class="vfy-data-val">{{ $suratLog->user?->name ?? '-' }}</span>
                            </div>
                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Tanggal Pengajuan</span>
                                <span class="vfy-data-val">{{ $suratLog->created_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB</span>
                            </div>
                            <div class="vfy-data-row">
                                <span class="vfy-data-label">Kode Verifikasi</span>
                                <span class="vfy-data-val"><code>{{ $kode }}</code></span>
                            </div>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            <a href="{{ route('service.persuratan.index') }}" class="vfy-btn-primary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Persuratan
                            </a>
                            <a href="{{ route('home') }}" class="vfy-btn-outline">
                                <i class="fas fa-home"></i> Beranda
                            </a>
                        </div>


                    {{-- ── CASE 3: DOKUMEN DITOLAK (REJECTED) ────────────── --}}
                    @elseif ($suratLog && $suratLog->status === 'rejected')

                        <div class="vfy-seal-wrap danger">
                            <i class="fas fa-circle-xmark vfy-seal-icon"></i>
                        </div>

                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background:#fee2e2; color:#b91c1c; font-size:0.78rem; font-weight:700; border:1px solid #fca5a5;">
                            <i class="fas fa-ban"></i>
                            <span>DOKUMEN DITOLAK / TIDAK BERLAKU</span>
                        </div>

                        <h1 class="vfy-title">Dokumen Tidak Berlaku</h1>
                        <p class="vfy-sub">
                            Pengajuan surat untuk kode ini telah <strong>DITOLAK</strong> oleh administrator dan tidak berlaku sebagai dokumen resmi LDK Syahid.
                        </p>

                        @if ($suratLog->catatan_admin)
                            <div class="alert alert-danger border-0 rounded-4 text-start small mb-4 py-3 px-4" style="background:#fef2f2; color:#991b1b; border:1px solid #fecaca !important;">
                                <strong class="d-block mb-1"><i class="fas fa-info-circle me-1"></i> Catatan Penolakan:</strong>
                                {{ $suratLog->catatan_admin }}
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            <a href="{{ route('service.persuratan.index') }}" class="vfy-btn-primary">
                                <i class="fas fa-feather-alt"></i> Buat Pengajuan Baru
                            </a>
                            <a href="{{ route('home') }}" class="vfy-btn-outline">
                                <i class="fas fa-home"></i> Beranda
                            </a>
                        </div>


                    {{-- ── CASE 4: KODE TIDAK DITEMUKAN / INVALID ────────── --}}
                    @else

                        <div class="vfy-seal-wrap danger">
                            <i class="fas fa-triangle-exclamation vfy-seal-icon"></i>
                        </div>

                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-2" style="background:#fee2e2; color:#b91c1c; font-size:0.78rem; font-weight:700; border:1px solid #fca5a5;">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>TIDAK TERDAFTAR</span>
                        </div>

                        <h1 class="vfy-title">Dokumen Tidak Ditemukan</h1>
                        <p class="vfy-sub">
                            Kode verifikasi <code class="px-2 py-1 bg-light rounded text-danger fw-bold">{{ $kode }}</code> tidak terdaftar dalam basis data resmi LDK Syahid. Harap waspada terhadap indikasi pemalsuan dokumen.
                        </p>

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            <a href="{{ route('service.persuratan.index') }}" class="vfy-btn-primary">
                                <i class="fas fa-feather-alt"></i> Layanan Persuratan
                            </a>
                            <a href="{{ route('home') }}" class="vfy-btn-outline">
                                <i class="fas fa-home"></i> Kembali ke Beranda
                            </a>
                        </div>

                    @endif


                    {{-- ── FORM PENCARIAN TOKEN LAIN ─────────────────────── --}}
                    <hr class="my-4" style="border-color:#f1f5f9;">

                    <div class="text-start">
                        <label class="small font-weight-bold text-muted mb-1" for="inputVerifikasiLain">
                            <i class="fas fa-search me-1 text-primary"></i> Periksa Kode Verifikasi Lain
                        </label>
                        <form onsubmit="event.preventDefault(); verifikasiKodeLain();" class="vfy-search-box">
                            <input type="text" id="inputVerifikasiLain" class="vfy-search-input"
                                   placeholder="Masukkan kode token surat (cth: a1b2c3d4e5...)" required>
                            <button type="submit" class="vfy-search-btn">
                                <i class="fas fa-magnifying-glass me-1"></i> Periksa
                            </button>
                        </form>
                    </div>

                </div>{{-- /vfy-card --}}

                <p class="text-muted small mt-4">
                    &copy; {{ date('Y') }} UKM LDK Syahid UIN Syarif Hidayatullah Jakarta &bull; Sistem Arsip &amp; Verifikasi Digital
                </p>

            </div>
        </div>
    </div>
</section>

<script>
function verifikasiKodeLain() {
    var input = document.getElementById('inputVerifikasiLain');
    if (!input || !input.value.trim()) return;
    var kode = encodeURIComponent(input.value.trim());
    window.location.href = '/verifikasi-surat/' + kode;
}
</script>

@endsection