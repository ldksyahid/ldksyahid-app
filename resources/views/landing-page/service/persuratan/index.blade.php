@extends('landing-page.template.body')

@section('styles')
@include('landing-page.service.persuratan.components._index-styles')
@endsection

@section('content')

<section class="prs-page-section py-5">
    <div class="container mt-4">

        {{-- ── Hero Header ──────────────────────────────────────── --}}
        <div class="prs-hero">
            <div class="prs-hero-badge">
                <i class="fas fa-feather-alt"></i>
                <span>Layanan Persuratan</span>
                <span class="prs-badge-pulse"></span>
            </div>
            <h1 class="prs-hero-title">Buat Surat Resmi<br>LDK Syahid</h1>
            <p class="prs-hero-sub">Ajukan surat sesuai kebutuhanmu. Admin akan memverifikasi dan menerbitkan nomor surat resmi lengkap dengan QR code keaslian dokumen.</p>

            <div class="prs-hero-stats">
                <div class="prs-stat">
                    <i class="fas fa-bolt"></i>
                    <span>Proses cepat</span>
                </div>
                <div class="prs-stat">
                    <i class="fas fa-qrcode"></i>
                    <span>QR terverifikasi</span>
                </div>
                <div class="prs-stat">
                    <i class="fas fa-file-pdf"></i>
                    <span>Format PDF</span>
                </div>
            </div>
        </div>

        {{-- ── Layout Form & Sidebar Kontak ─────────────────────── --}}
        <div class="row g-4 mt-1">
            
            {{-- KOLOM KIRI (Form, Info, & Riwayat) --}}
            <div class="col-lg-7 col-xl-8">

                @if (session('success'))
                    <div class="prs-alert prs-alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="prs-alert prs-alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Card Form Pengajuan --}}
                <div class="prs-card">
                    <div class="prs-card-head">
                        <div class="prs-card-icon-wrap">
                            <div class="prs-card-icon"><i class="fas fa-pen-nib"></i></div>
                        </div>
                        <div>
                            <h5 class="prs-card-title">Form Pengajuan Surat</h5>
                            <p class="prs-card-sub">Lengkapi data di bawah dengan teliti</p>
                        </div>
                    </div>

                    <form action="{{ route('service.persuratan.submit') }}" method="POST" id="form-persuratan" class="prs-form">
                        @csrf

                        <div class="prs-field mb-4">
                            <label class="prs-label" for="jenis_surat">
                                <i class="fas fa-list-ul"></i> Jenis Surat
                            </label>
                            <select name="jenis_surat" id="jenis_surat"
                                class="prs-select @error('jenis_surat') is-invalid @enderror">
                                <option value="" disabled selected>-- Pilih jenis surat --</option>
                                @foreach ($suratTypes as $key => $surat)
                                    <option value="{{ $key }}" {{ old('jenis_surat') === $key ? 'selected' : '' }}>
                                        {{ $surat['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_surat')
                                <div class="prs-error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="dynamic-fields"></div>

                        <div class="d-grid mt-4" id="btn-submit-wrapper" style="display:none!important">
                            <button type="submit" class="prs-btn-submit" id="btn-submit">
                                <i class="fas fa-paper-plane"></i> Kirim Pengajuan Surat
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Info Box Alur --}}
                <div class="prs-info-box mt-4">
                    <div class="prs-info-icon"><i class="fas fa-route"></i></div>
                    <div class="prs-info-text">
                        <strong>Alur Pengajuan</strong>
                        <p>Kirim pengajuan &rarr; Admin mereview &amp; menerbitkan nomor surat &rarr; Kamu mendapat notifikasi &amp; bisa mengunduh PDF di riwayat surat.</p>
                    </div>
                </div>

                {{-- Riwayat Singkat (Hanya Muncul Jika Login) --}}
                @auth
                <div class="prs-card mt-4">
                    <div class="prs-card-head">
                        <div class="prs-card-icon-wrap">
                            <div class="prs-card-icon"><i class="fas fa-history"></i></div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="prs-card-title">Riwayat Terakhir</h5>
                            <p class="prs-card-sub">5 pengajuan terbaru kamu</p>
                        </div>
                        <a href="{{ route('service.persuratan.riwayat') }}" class="prs-link-all">
                            Lihat Semua <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    @if ($riwayat->isEmpty())
                        <div class="prs-empty">
                            <div class="prs-empty-visual">
                                <div class="prs-empty-ring prs-empty-ring-1"></div>
                                <div class="prs-empty-ring prs-empty-ring-2"></div>
                                <div class="prs-empty-icon-wrap">
                                    <i class="fas fa-inbox"></i>
                                </div>
                            </div>
                            <p>Belum ada pengajuan surat.</p>
                        </div>
                    @else
                        <div class="prs-history-list">
                            @foreach ($riwayat as $log)
                                <div class="prs-history-item" style="animation-delay: {{ number_format($loop->index * 0.06, 2) }}s">
                                    <div class="prs-history-dot prs-status-{{ $log->status }}"></div>
                                    <div class="prs-history-content">
                                        <div class="prs-history-title">{{ $log->label }}</div>
                                        <div class="prs-history-meta">
                                            {{ $log->created_at->locale('id')->translatedFormat('d M Y') }}
                                            @if ($log->nomor_surat !== '-')
                                                &bull; {{ $log->nomor_surat }}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="prs-history-action">
                                        <span class="prs-badge prs-badge-{{ $log->statusBadgeClass() }}">
                                            {{ $log->statusLabel() }}
                                        </span>
                                        @if ($log->isApproved())
                                            <a href="{{ route('service.persuratan.download', $log) }}"
                                               class="prs-btn-download" title="Download PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endauth
            </div>

            {{-- KOLOM KANAN (Sidebar Logo, SLA, & Kontak) --}}
<div class="col-lg-5 col-xl-4">
    <div class="position-sticky" style="top: 100px; display: flex; flex-direction: column; gap: 1.25rem;">

        {{-- 1. CARD LOGO & IDENTITAS --}}
        <div class="prs-card text-center p-4">
            <img src="https://drive.google.com/uc?export=view&id=ID_FILE_GAMBAR_AA" alt="Logo LDK Syahid" class="img-fluid mb-3 d-none prs-logo-img">
            
            <div id="logo-placeholder" class="prs-sidebar-logo">
                <i class="fas fa-image fa-2x"></i>
            </div>
            
            <h5 class="fw-bold mb-1" style="color: var(--prs-dark);">Layanan Administrasi</h5>
            <p class="text-muted small mb-0" style="color: var(--prs-gray);">LDK Syahid UIN Syarif Hidayatullah</p>
        </div>

        {{-- 2. CARD INFORMASI LAYANAN / SLA --}}
        <div class="prs-card p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="prs-card-icon-wrap" style="width: 40px; height: 40px; padding: 0;">
                    <div class="prs-card-icon shadow-none prs-info-icon-box">
                        <i class="fas fa-info-circle fs-6"></i>
                    </div>
                </div>
                <h6 class="fw-bold mb-0" style="color: var(--prs-dark);">Informasi Layanan</h6>
            </div>
            
            <ul class="prs-sla-list">
                <li class="prs-sla-item">
                    <i class="fas fa-clock"></i>
                    <span><strong>Waktu Proses:</strong> Maksimal 1x24 jam (hari kerja) setelah pengajuan dikirim.</span>
                </li>
                <li class="prs-sla-item">
                    <i class="fas fa-file-pdf"></i>
                    <span><strong>Output Dokumen:</strong> Surat akan di-generate dalam format PDF ber-QR Code yang sah.</span>
                </li>
                <li class="prs-sla-item">
                    <i class="fas fa-bell"></i>
                    <span><strong>Notifikasi:</strong> Cek menu <em>Riwayat Surat</em> secara berkala untuk melihat status persetujuan.</span>
                </li>
            </ul>
        </div>

        {{-- 3. CARD BUTUH BANTUAN (Call Kestari) --}}
        <div class="prs-card p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="prs-card-icon-wrap" style="width: 48px; height: 48px; padding: 0; background: transparent;">
                    <div class="prs-card-icon shadow-none prs-help-icon-box">
                        <i class="fas fa-headset fs-5"></i>
                    </div>
                </div>
                <div>
                    <h5 class="fw-bold mb-1" style="font-size: 1.1rem; color: var(--prs-dark);">Butuh Bantuan?</h5>
                    <p class="mt-0 mb-0" style="font-size: 0.8rem; color: var(--prs-gray);">Hubungi narahubung Kestari</p>
                </div>
            </div>

            <div class="prs-history-list">
                <a href="https://wa.me/6285819353387" target="_blank" rel="noopener" class="prs-history-item text-decoration-none border shadow-none">
                    <div class="prs-wa-icon"><i class="fab fa-whatsapp"></i></div>
                    <div class="prs-history-content">
                        <div class="prs-history-title">M. Fiqhan Fajar</div>
                        <div class="prs-history-meta">Admin Kestari</div>
                    </div>
                    <i class="fas fa-chevron-right prs-chevron-icon"></i>
                </a>

                <a href="https://wa.me/6285776923137" target="_blank" rel="noopener" class="prs-history-item text-decoration-none border shadow-none">
                    <div class="prs-wa-icon"><i class="fab fa-whatsapp"></i></div>
                    <div class="prs-history-content">
                        <div class="prs-history-title">M. Zhaffar Rabbany</div>
                        <div class="prs-history-meta">Sekjen LDK</div>
                    </div>
                    <i class="fas fa-chevron-right prs-chevron-icon"></i>
                </a>

                <a href="https://wa.me/6281317209305" target="_blank" rel="noopener" class="prs-history-item text-decoration-none border shadow-none">
                    <div class="prs-wa-icon"><i class="fab fa-whatsapp"></i></div>
                    <div class="prs-history-content">
                        <div class="prs-history-title">M. Fakhri Alfarisi</div>
                        <div class="prs-history-meta">Admin & Web Dev</div>
                    </div>
                    <i class="fas fa-chevron-right prs-chevron-icon"></i>
                </a>
            </div>
        </div>

    </div>
</div>

        </div>
    </div>
</section>

@include('landing-page.service.persuratan.components._index-scripts')

@endsection