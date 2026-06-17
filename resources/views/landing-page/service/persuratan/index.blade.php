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

        <div class="row justify-content-center g-4 mt-1">

            {{-- ── Form Pengajuan ───────────────────────────────── --}}
            <div class="col-lg-7">

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

                <div class="prs-card">
                    <div class="prs-card-head">
                        <div class="prs-card-icon"><i class="fas fa-pen-nib"></i></div>
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

                <div class="prs-info-box">
                    <div class="prs-info-icon"><i class="fas fa-route"></i></div>
                    <div class="prs-info-text">
                        <strong>Alur Pengajuan</strong>
                        <p>Kirim pengajuan &rarr; Admin mereview &amp; menerbitkan nomor surat &rarr; Kamu mendapat notifikasi &amp; bisa mengunduh PDF di riwayat surat.</p>
                    </div>
                </div>
            </div>

            {{-- ── Riwayat Singkat ──────────────────────────────── --}}
            @auth
            <div class="col-lg-7">
                <div class="prs-card">
                    <div class="prs-card-head">
                        <div class="prs-card-icon"><i class="fas fa-history"></i></div>
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
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada pengajuan surat.</p>
                        </div>
                    @else
                        <div class="prs-history-list">
                            @foreach ($riwayat as $log)
                                <div class="prs-history-item">
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
            </div>
            @endauth

        </div>
    </div>
</section>

@include('landing-page.service.persuratan.components._index-scripts')

@endsection