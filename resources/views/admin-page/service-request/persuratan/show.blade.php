@extends('admin-page.template.body')
{{-- Path: resources/views/admin-page/service-request/persuratan/show.blade.php --}}

@section('title', $title)

@section('head')
@include('admin-page.service-request.persuratan.components._show-styles')
@endsection

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">

            {{-- ── 1. Page Title ─────────────────────────────────────── --}}
            <div class="col-12 text-center">
                <h1 class="page-title">
                    <i class="fas fa-envelope-open-text me-2"></i>
                    <span>Letter Request</span>
                    <span class="highlighted-text ms-1">Detail</span>
                    <small class="text-muted d-block mt-2">{{ $suratLog->label }} &bull; <code>#{{ $suratLog->id }}</code></small>
                </h1>
            </div>

            {{-- ── 2. Top Navigation & Action Header ─────────────────── --}}
            <div class="col-12 mb-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                <a href="{{ route('admin.persuratan.index') }}" class="btn btn-custom-primary btn-sm rounded-pill px-3 shadow-sm font-weight-bold">
                    <i class="fas fa-arrow-left me-1"></i> Back to Letter List
                </a>
                <div>
                    @if ($suratLog->status === 'approved')
                        <span class="adm-badge adm-badge-success fs-6 px-3 py-1">
                            <i class="fas fa-check-circle me-1"></i> Approved
                        </span>
                    @elseif ($suratLog->status === 'rejected')
                        <span class="adm-badge adm-badge-danger fs-6 px-3 py-1">
                            <i class="fas fa-times-circle me-1"></i> Rejected
                        </span>
                    @else
                        <span class="adm-badge adm-badge-warning fs-6 px-3 py-1">
                            <i class="fas fa-clock me-1"></i> Pending Review
                        </span>
                    @endif
                </div>
            </div>

            {{-- ── 3. Flash Feedback Alert ───────────────────────────────── --}}
            @if (session('success'))
                <div class="col-12 mb-3">
                    <div class="alert alert-success adm-alert-success border-0 shadow-sm rounded-4 d-flex align-items-center gap-3 py-3 px-4 mb-0">
                        <div class="adm-header-icon success">
                            <i class="fas fa-check-circle fs-5"></i>
                        </div>
                        <div>
                            <strong class="d-block text-success">Success!</strong>
                            <span class="small">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="col-12 mb-3">
                    <div class="alert alert-danger adm-alert-danger border-0 shadow-sm rounded-4 py-3 px-4 mb-0">
                        <strong class="d-flex align-items-center gap-2 mb-1 text-danger">
                            <i class="fas fa-exclamation-triangle"></i> Please check the form errors below:
                        </strong>
                        <ul class="mb-0 ps-3 small text-danger">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="col-12">
                <div class="row">

                    {{-- ── LEFT COLUMN: Requester & Form Details ─────────────── --}}
                    <div class="col-12 col-lg-7 col-xl-8 mb-4 mb-lg-0">

                        {{-- Card 1: Requester & Document Overview --}}
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-user-check me-2"></i>Requester &amp; Document Overview
                                </h5>

                                <div class="table-responsive">
                                    <table class="adm-detail-table">
                                        <tbody>
                                            <tr>
                                                <td class="adm-detail-label">Requester Name</td>
                                                <td class="adm-detail-val">
                                                    <strong>{{ $suratLog->user?->name ?? 'Anonymous User' }}</strong>
                                                    <div class="text-muted small">{{ $suratLog->user?->email ?? '-' }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="adm-detail-label">Department / Division</td>
                                                <td>
                                                    <span class="adm-badge adm-badge-neutral">
                                                        <i class="fas fa-users me-1 text-custom"></i>
                                                        {{ $suratLog->kodeBidangPengaju() ? $suratLog->kodeBidangPengaju() . ' · ' : '' }}{{ $suratLog->labelBidangPengaju() }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="adm-detail-label">Letter Classification</td>
                                                <td>
                                                    <strong class="text-dark">{{ $suratLog->label }}</strong>
                                                    <div class="text-muted font-monospace small">{{ $suratLog->jenis_surat }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="adm-detail-label">Official Letter Number</td>
                                                <td>
                                                    @if ($suratLog->nomor_surat !== '-')
                                                        <span class="adm-badge adm-badge-neutral font-monospace font-weight-bold" style="font-size:0.85rem;">
                                                            {{ $suratLog->nomor_surat }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted small fst-italic">— Not Issued (Pending Approval) —</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="adm-detail-label">Submission Date</td>
                                                <td class="adm-detail-val">
                                                    {{ $suratLog->created_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB
                                                    <span class="text-muted small">({{ $suratLog->created_at->diffForHumans() }})</span>
                                                </td>
                                            </tr>
                                            @if ($suratLog->approved_at)
                                                <tr>
                                                    <td class="adm-detail-label">Approved At</td>
                                                    <td class="adm-detail-val text-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        {{ $suratLog->approved_at->locale('id')->translatedFormat('d F Y, H:i') }} WIB
                                                        @if ($suratLog->approvedBy)
                                                            <span class="text-muted small">&bull; by {{ $suratLog->approvedBy->name }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            @if ($suratLog->catatan_admin)
                                                <tr>
                                                    <td class="adm-detail-label">Admin Notes</td>
                                                    <td>
                                                        <div class="adm-action-box small">
                                                            <i class="fas fa-comment-alt text-custom me-1"></i>
                                                            {{ $suratLog->catatan_admin }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Card 2: Submitted Dynamic Fields --}}
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-list-check me-2"></i>Form Submission Details
                                </h5>

                                @php
                                    $fieldLabels = [
                                        'kode_bidang'          => 'Department / Division',
                                        'jenis_undangan'       => 'Invitation Type',
                                        'jenis_peminjaman'     => 'Borrowing Type',
                                        'nama_acara'           => 'Event / Activity Name',
                                        'nama_kegiatan'        => 'Activity Name',
                                        'tema_acara'           => 'Event Theme',
                                        'nama_ketua_pelaksana' => 'Chief Committee Name',
                                        'nim_ketua_pelaksana'  => 'Chief Committee NIM',
                                        'hari_tanggal'         => 'Event Date',
                                        'waktu'                => 'Event Time / Duration',
                                        'tempat'               => 'Location / Venue',
                                        'tempat_dipinjam'      => 'Reserved Facility / Venue',
                                        'alamat_tempat'        => 'Full Venue Address',
                                        'ditujukan_kepada'     => 'Addressed To',
                                        'daftar_alat'          => 'Equipment List',
                                        'nama_program'         => 'Program Name',
                                        'keperluan'            => 'Purpose / Needs Description',
                                        'nama'                 => 'Member Full Name',
                                        'nim'                  => 'NIM',
                                        'fakultas'             => 'Faculty',
                                        'jurusan'              => 'Major / Study Program',
                                        'jabatan'              => 'Position in LDK Syahid',
                                        'ttl'                  => 'Place & Date of Birth',
                                        'program_rekomendasi'  => 'Recommended Program',
                                        'pertimbangan'         => 'Recommendation Points',
                                        'materi'               => 'Specific Topic / Material',
                                        'bentuk_kerjasama'     => 'Partnership Proposal Summary',
                                        'penyelenggara'        => 'Organizer / Institution',
                                        'nama_kendaraan'       => 'Vehicle Requested',
                                        'jumlah_peserta'       => 'Total Participants',
                                        'narahubung'           => 'Contact Person (WhatsApp)',
                                        'no_hp_ketua_pelaksana'=> 'Chief Committee Phone/WA',
                                        'fakultas_ketua_pelaksana' => 'Chief Committee Faculty',
                                        'jurusan_ketua_pelaksana'  => 'Chief Committee Major',
                                        'opsi_sponsor'         => 'Sponsorship Status',
                                    ];
                                @endphp

                                <div class="table-responsive">
                                    <table class="adm-detail-table">
                                        <tbody>
                                            @foreach ($suratLog->data as $key => $value)
                                                @continue(in_array($key, ['jenis_surat', 'kode_bidang']))
                                                <tr>
                                                    <td class="adm-detail-label">
                                                        {{ $fieldLabels[$key] ?? ucwords(str_replace('_', ' ', $key)) }}
                                                    </td>
                                                    <td>
                                                        @if ($key === 'daftar_alat' || $key === 'pertimbangan' || $key === 'bentuk_kerjasama' || $key === 'keperluan')
                                                            <div class="adm-action-box font-monospace small" style="white-space: pre-wrap;">{{ $value }}</div>
                                                        @elseif ($key === 'hari_tanggal')
                                                            <span class="adm-badge adm-badge-neutral" style="font-size:0.8rem;">
                                                                <i class="fas fa-calendar-alt me-1 text-custom"></i> {{ $value }}
                                                            </span>
                                                        @elseif ($key === 'waktu')
                                                            <span class="adm-badge adm-badge-neutral" style="font-size:0.8rem;">
                                                                <i class="fas fa-clock me-1 text-secondary"></i> {{ $value }}
                                                            </span>
                                                        @else
                                                            <span class="adm-detail-val">{{ $value }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- ── RIGHT COLUMN: Action & Verification Panel ──────────── --}}
                    <div class="col-12 col-lg-5 col-xl-4">

                        {{-- ── Action 1: Approval Form (Pending Status) ── --}}
                        @if ($suratLog->isPending())
                            <div class="card border-0 shadow-sm mb-4" style="border-top: 4px solid #10b981 !important;">
                                <div class="card-body">
                                    <h5 class="section-title mb-3 text-success">
                                        <i class="fas fa-check-circle me-2"></i>Approve &amp; Issue Letter
                                    </h5>

                                    <form action="{{ route('admin.persuratan.approve', $suratLog) }}" method="POST" id="form-approve">
                                        @csrf

                                        {{-- Last Issued Number Indicator --}}
                                        <div class="adm-action-box mb-3">
                                            <div class="small font-weight-bold text-muted" style="font-size: 0.72rem; text-transform: uppercase;">Last Issued Letter Number:</div>
                                            <strong class="font-monospace small text-dark d-block mt-1">{{ $lastNomor ?? 'None (Start New Sequence)' }}</strong>
                                        </div>

                                        {{-- Numbering Options --}}
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold text-muted mb-2 d-block">Numbering Mode</label>
                                            
                                            <div class="custom-control custom-radio mb-2">
                                                <input type="radio" id="nomor-mode-auto" name="mode_penomoran" class="custom-control-input" value="otomatis" checked>
                                                <label class="custom-control-label small font-weight-bold text-dark" for="nomor-mode-auto">
                                                    Automatic Generation (Next sequence this month)
                                                </label>
                                            </div>

                                            <div class="custom-control custom-radio mb-2">
                                                <input type="radio" id="nomor-mode-manual" name="mode_penomoran" class="custom-control-input" value="manual" {{ old('mode_penomoran') === 'manual' ? 'checked' : '' }}>
                                                <label class="custom-control-label small font-weight-bold text-dark" for="nomor-mode-manual">
                                                    Manual Sequence Input
                                                </label>
                                            </div>

                                            <div id="nomor-manual-wrapper" class="{{ old('mode_penomoran') === 'manual' ? '' : 'd-none' }} mt-2 adm-action-box">
                                                <div class="input-group input-group-sm mb-1">
                                                    <input type="text" name="nomor_manual" id="input_nomor_manual"
                                                           class="form-control @error('nomor_manual') is-invalid @enderror"
                                                           placeholder="e.g. 047 or 047.01"
                                                           value="{{ old('nomor_manual') }}">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text text-muted small">
                                                            / PREFIX / ...
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="small text-muted" style="font-size: 0.72rem;">
                                                    Enter the sequence number only (e.g. <code>047</code>). The system will automatically build the division code, month, and year.
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Division / Faculty Modern Picker --}}
                                        @php
                                            $currentBidangCode = old('kode_bidang', $suratLog->kodeBidangPengaju());
                                            $currentBidangInfo = \App\Support\DepartmentRegistry::get($currentBidangCode);
                                            $currentBidangGroup = ($currentBidangInfo['group'] ?? '') === 'pusat' ? 'Pengurus Pusat' : 'LDKS Fakultas';
                                        @endphp

                                        <div class="form-group mb-3">
                                            <div class="d-flex align-items-center justify-content-between mb-1.5">
                                                <label class="small font-weight-bold text-dark mb-0">
                                                    Department / Division Code <span class="text-danger">*</span>
                                                </label>
                                                <button type="button" class="btn btn-outline-teal btn-sm rounded-pill py-0.5 px-2.5 font-weight-bold d-inline-flex align-items-center gap-1"
                                                        data-toggle="modal" data-target="#modalAdminChooseDept" style="font-size: 0.72rem; line-height: 1.5;">
                                                    <i class="fas fa-edit" style="font-size: 0.65rem;"></i>
                                                    <span>Ubah Bidang</span>
                                                </button>
                                            </div>
                                            <input type="hidden" name="kode_bidang" id="admin_kode_bidang" value="{{ $currentBidangCode }}" required>

                                            <div class="adm-dept-trigger-card" id="admDeptPickerTrigger"
                                                 data-toggle="modal" data-target="#modalAdminChooseDept" role="button" title="Klik untuk mengubah bidang">
                                                <div class="adm-dept-trigger-icon" id="admDeptPickerIcon">
                                                    <i class="fas {{ $currentBidangInfo['icon'] ?? 'fa-sitemap' }}"></i>
                                                </div>
                                                <div class="adm-dept-card-text-wrap">
                                                    <div class="d-flex align-items-center gap-1 mb-1">
                                                        <span class="adm-dept-code-tag" id="admDeptPickerCode">{{ $currentBidangCode }}</span>
                                                        <span class="adm-dept-group-tag" id="admDeptPickerGroup">{{ $currentBidangGroup }}</span>
                                                    </div>
                                                    <div class="adm-dept-picker-title" id="admDeptPickerTitle">
                                                        {{ $currentBidangInfo['name'] ?? \App\Support\DepartmentRegistry::label($currentBidangCode) }}
                                                    </div>
                                                    <div class="adm-dept-picker-desc text-muted" id="admDeptPickerDesc">
                                                        {{ $currentBidangInfo['desc'] ?? 'Klik untuk memilih bidang / fakultas' }}
                                                    </div>
                                                </div>
                                                <div class="adm-dept-arrow ms-auto">
                                                    <i class="fas fa-chevron-right"></i>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Admin Notes --}}
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold text-dark">Admin Notes (Optional)</label>
                                            <textarea name="catatan_admin" class="form-control form-control-sm rounded-3"
                                                      rows="2" placeholder="Message or notes for the requester...">{{ old('catatan_admin') }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-block w-100 rounded-3 font-weight-bold shadow-sm py-2" id="btn-approve"
                                                onclick="return confirm('Are you sure you want to approve this letter request? An official letter number will be generated.')">
                                            <i class="fas fa-check-circle me-1"></i> Approve &amp; Issue Letter
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- ── Action 2: Reject Form ── --}}
                            <div class="card border-0 shadow-sm mb-4" style="border-top: 4px solid #ef4444 !important;">
                                <div class="card-body">
                                    <h5 class="section-title mb-3 text-danger">
                                        <i class="fas fa-times-circle me-2"></i>Reject Letter Request
                                    </h5>

                                    <form action="{{ route('admin.persuratan.reject', $suratLog) }}" method="POST" id="form-reject">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label class="small font-weight-bold text-dark">
                                                Reason for Rejection <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="catatan_admin" class="form-control form-control-sm rounded-3"
                                                      rows="3" placeholder="Explain the reason for rejecting this request..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-outline-danger btn-block w-100 rounded-3 font-weight-bold py-2" id="btn-reject"
                                                onclick="return confirm('Are you sure you want to reject this letter request?')">
                                            <i class="fas fa-times-circle me-1"></i> Reject Request
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- ── Action 3: Download PDF (Approved) ── --}}
                        @if ($suratLog->isApproved())
                            <div class="card border-0 shadow-sm mb-4" style="border-top: 4px solid #10b981 !important;">
                                <div class="card-body">
                                    <h5 class="section-title mb-3 text-success">
                                        <i class="fas fa-file-pdf me-2"></i>Official PDF Document
                                    </h5>
                                    <p class="small text-muted mb-3">The letter has been approved and issued with an official QR verification code. You can download the PDF document below.</p>
                                    <a href="{{ route('admin.persuratan.download', $suratLog) }}"
                                       class="btn btn-success btn-block w-100 rounded-3 font-weight-bold shadow-sm py-2">
                                        <i class="fas fa-download me-2"></i> Download PDF Letter
                                    </a>
                                </div>
                            </div>
                        @endif

                        {{-- ── Action 4: QR Code & Verification ── --}}
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-qrcode me-2"></i>QR Verification &amp; Authenticity
                                </h5>

                                <div class="adm-verify-token-box text-center mb-3">
                                    <div class="text-muted small mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em;">Document Verification Token</div>
                                    <code class="font-weight-bold fs-6 text-custom p-2 d-inline-block rounded-3" style="letter-spacing: 0.05em;">{{ $suratLog->kode_verifikasi }}</code>
                                </div>

                                <a href="{{ route('persuratan.verifikasi', ['kode' => $suratLog->kode_verifikasi]) }}"
                                   target="_blank" class="btn btn-outline-secondary btn-sm btn-block w-100 rounded-3 py-2 font-weight-bold">
                                    <i class="fas fa-external-link-alt me-1"></i> Open Public Verification Page
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modals --}}
@include('admin-page.service-request.persuratan.components._modal-choose-dept')

<script>
document.addEventListener('DOMContentLoaded', function () {
    var radios  = document.querySelectorAll('input[name="mode_penomoran"]');
    var wrapper = document.getElementById('nomor-manual-wrapper');
    var input   = document.getElementById('input_nomor_manual');

    if (radios.length && wrapper) {
        function sync() {
            var manual = document.getElementById('nomor-mode-manual').checked;
            wrapper.classList.toggle('d-none', !manual);
            if (input) input.required = manual;
            if (!manual && input) input.value = '';
        }

        radios.forEach(function (r) { r.addEventListener('change', sync); });

        @error('nomor_manual')
            document.getElementById('nomor-mode-manual').checked = true;
        @enderror

        sync();
    }

    var formApprove = document.getElementById('form-approve');
    var btnApprove  = document.getElementById('btn-approve');
    if (formApprove && btnApprove) {
        formApprove.addEventListener('submit', function (e) {
            if (this.checkValidity()) {
                setTimeout(function() {
                    btnApprove.disabled = true;
                    btnApprove.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Approving...';
                    btnApprove.style.cursor = 'not-allowed';
                }, 10);
            }
        });
    }

    var formReject = document.getElementById('form-reject');
    var btnReject  = document.getElementById('btn-reject');
    if (formReject && btnReject) {
        formReject.addEventListener('submit', function (e) {
            if (this.checkValidity()) {
                setTimeout(function() {
                    btnReject.disabled = true;
                    btnReject.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Rejecting...';
                    btnReject.style.cursor = 'not-allowed';
                }, 10);
            }
        });
    }
});
</script>

@endsection