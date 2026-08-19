@extends('admin-page.template.body')
{{-- Path: resources/views/admin-page/service-request/persuratan/show.blade.php --}}

@section('title', $title)

@section('head')
<style>
/* ── High-Contrast Admin Styles for Letter Details ──────────────────── */
.adm-letter-container {
    padding: 1.5rem 0.5rem;
}
.adm-card {
    background: #ffffff !important;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
.adm-card-header {
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 1rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.adm-card-header h5, .adm-card-header h6 {
    margin: 0;
    font-weight: 700;
    color: #0f172a;
}
.adm-info-box {
    background-color: #f8fafc !important;
    border: 1px solid #e2e8f0 !important;
    border-radius: 12px;
    padding: 1rem 1.15rem;
    height: 100%;
}
.adm-info-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.25rem;
}
.adm-info-val {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
}

/* Status Badges */
.adm-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.45rem 1rem;
    border-radius: 50rem;
    font-size: 0.82rem;
    font-weight: 700;
    line-height: 1.3;
}
.adm-badge-success {
    background-color: #dcfce7 !important;
    color: #15803d !important;
    border: 1px solid #86efac !important;
}
.adm-badge-warning {
    background-color: #fef3c7 !important;
    color: #b45309 !important;
    border: 1px solid #fcd34d !important;
}
.adm-badge-danger {
    background-color: #fee2e2 !important;
    color: #b91c1c !important;
    border: 1px solid #fca5a5 !important;
}
.adm-badge-neutral {
    background-color: #f1f5f9 !important;
    color: #334155 !important;
    border: 1px solid #cbd5e1 !important;
}

/* Detail Table */
.adm-detail-table {
    width: 100%;
    margin-bottom: 0;
}
.adm-detail-table td {
    padding: 0.85rem 0.75rem;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
    font-size: 0.88rem;
}
.adm-detail-label {
    width: 220px;
    font-weight: 600;
    color: #64748b;
}
.adm-detail-val {
    font-weight: 600;
    color: #0f172a;
}
</style>
@endsection

@section('content')

<div class="container-fluid adm-letter-container">

    {{-- ── 1. Top Navigation & Action Header ─────────────────────── --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.persuratan.index') }}" class="btn btn-outline-secondary rounded-3 btn-sm shadow-sm px-3 font-weight-bold">
                <i class="fas fa-arrow-left me-1"></i> Back to Letter List
            </a>
            <div>
                <h4 class="font-weight-bold mb-0 text-dark">
                    {{ $suratLog->label }}
                </h4>
                <div class="text-muted small">
                    Request ID: <code>#{{ $suratLog->id }}</code> &bull; Verification Code: <code>{{ $suratLog->kode_verifikasi }}</code>
                </div>
            </div>
        </div>

        <div>
            @if ($suratLog->status === 'approved')
                <span class="adm-badge adm-badge-success">
                    <i class="fas fa-check-circle me-1"></i> Approved
                </span>
            @elseif ($suratLog->status === 'rejected')
                <span class="adm-badge adm-badge-danger">
                    <i class="fas fa-times-circle me-1"></i> Rejected
                </span>
            @else
                <span class="adm-badge adm-badge-warning">
                    <i class="fas fa-clock me-1"></i> Pending Review
                </span>
            @endif
        </div>
    </div>

    {{-- ── 2. Flash Feedback Alert ───────────────────────────────── --}}
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 d-flex align-items-center gap-3 mb-4 py-3 px-4" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0 !important;">
            <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:36px;height:36px; background-color: #d1fae5; color: #059669;">
                <i class="fas fa-check-circle fs-5"></i>
            </div>
            <div>
                <strong class="d-block" style="color: #065f46;">Success!</strong>
                <span class="small" style="color: #047857;">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 py-3 px-4" style="background-color: #fef2f2; color: #991b1b; border: 1px solid #fecaca !important;">
            <strong class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-exclamation-triangle"></i> Please check the form errors below:
            </strong>
            <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">

        {{-- ── 3. LEFT COLUMN: Requester & Form Details ─────────────── --}}
        <div class="col-lg-7 col-xl-8">

            {{-- Card 1: Requester & Document Overview --}}
            <div class="adm-card">
                <div class="adm-card-header">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:34px;height:34px; background-color:#e0f2fe; color:#0284c7;">
                        <i class="fas fa-id-card"></i>
                    </div>
                    <h5>Requester &amp; Document Overview</h5>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="adm-info-box">
                            <div class="adm-info-label">Requester Name</div>
                            <div class="adm-info-val">{{ $suratLog->user?->name ?? 'Anonymous User' }}</div>
                            <div class="text-muted small">{{ $suratLog->user?->email ?? '-' }}</div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="adm-info-box">
                            <div class="adm-info-label">Department / Division</div>
                            <div class="adm-info-val">
                                @if ($suratLog->kodeBidangPengaju())
                                    <span class="adm-badge adm-badge-neutral me-1" style="font-size:0.75rem; padding:0.2rem 0.5rem;">
                                        {{ $suratLog->kodeBidangPengaju() }}
                                    </span>
                                @endif
                                {{ $suratLog->labelBidangPengaju() }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="adm-info-box">
                            <div class="adm-info-label">Submission Date</div>
                            <div class="adm-info-val">
                                <i class="fas fa-calendar-alt me-1 text-primary"></i>
                                {{ $suratLog->created_at->locale('en')->translatedFormat('d F Y, H:i') }} WIB
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="adm-info-box">
                            <div class="adm-info-label">Official Letter Number</div>
                            <div class="adm-info-val">
                                @if ($suratLog->nomor_surat !== '-')
                                    <span class="adm-badge adm-badge-neutral font-monospace font-weight-bold" style="font-size:0.82rem;">
                                        {{ $suratLog->nomor_surat }}
                                    </span>
                                @else
                                    <span class="text-muted small fst-italic">— Not Issued Yet —</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($suratLog->approved_at)
                        <div class="col-12">
                            <div class="p-3 rounded-3" style="background-color: {{ $suratLog->isApproved() ? '#ecfdf5' : '#fef2f2' }}; border: 1px solid {{ $suratLog->isApproved() ? '#a7f3d0' : '#fecaca' }};">
                                <div class="font-weight-bold mb-1" style="color: {{ $suratLog->isApproved() ? '#065f46' : '#991b1b' }};">
                                    <i class="fas {{ $suratLog->isApproved() ? 'fa-check-circle' : 'fa-times-circle' }} me-1"></i>
                                    {{ $suratLog->isApproved() ? 'Approved' : 'Rejected' }} by: {{ $suratLog->approvedBy?->name ?? 'Admin' }}
                                </div>
                                <div class="small" style="color: {{ $suratLog->isApproved() ? '#047857' : '#b91c1c' }};">
                                    On: {{ $suratLog->approved_at->locale('en')->translatedFormat('d F Y, H:i') }} WIB
                                </div>
                                @if ($suratLog->catatan_admin)
                                    <div class="mt-2 pt-2 border-top small" style="border-color: rgba(0,0,0,0.08) !important; color: #334155;">
                                        <strong>Admin Notes:</strong> {{ $suratLog->catatan_admin }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card 2: Form Submission Data --}}
            <div class="adm-card">
                <div class="adm-card-header">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:34px;height:34px; background-color:#e0f2fe; color:#0284c7;">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <h5>Form Submission Details</h5>
                </div>

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
                                            <div class="p-3 rounded-3 font-monospace small" style="background-color: #f8fafc; border: 1px solid #e2e8f0; white-space: pre-wrap; color: #1e293b;">{{ $value }}</div>
                                        @elseif ($key === 'hari_tanggal')
                                            <span class="adm-badge adm-badge-neutral" style="font-size:0.8rem;">
                                                <i class="fas fa-calendar-alt me-1 text-primary"></i> {{ $value }}
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


        {{-- ── 4. RIGHT COLUMN: Action & Verification Panel ──────────── --}}
        <div class="col-lg-5 col-xl-4">

            {{-- ── Action 1: Approval Form (Pending Status) ── --}}
            @if ($suratLog->isPending())
                <div class="adm-card" style="border-top: 4px solid #10b981 !important;">
                    <div class="adm-card-header">
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:34px;height:34px; background-color:#d1fae5; color:#059669;">
                            <i class="fas fa-check"></i>
                        </div>
                        <h6 style="color: #065f46;">Approve &amp; Issue Letter</h6>
                    </div>

                    <form action="{{ route('admin.persuratan.approve', $suratLog) }}" method="POST" id="form-approve">
                        @csrf

                        {{-- Last Issued Number Indicator --}}
                        <div class="p-3 rounded-3 mb-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="small font-weight-bold text-muted" style="font-size: 0.72rem; text-transform: uppercase;">Last Issued Letter Number:</div>
                            <strong class="font-monospace small text-dark d-block mt-1">{{ $lastNomor ?? 'None (Start New Sequence)' }}</strong>
                        </div>

                        {{-- Numbering Options --}}
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-muted mb-2 d-block">Numbering Mode</label>
                            
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="nomor-mode-auto" name="nomor_mode" class="custom-control-input" value="auto" checked>
                                <label class="custom-control-label small font-weight-bold text-dark" for="nomor-mode-auto">
                                    Automatic Generation (Next sequence this month)
                                </label>
                            </div>

                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="nomor-mode-manual" name="nomor_mode" class="custom-control-input" value="manual">
                                <label class="custom-control-label small font-weight-bold text-dark" for="nomor-mode-manual">
                                    Manual Sequence Input
                                </label>
                            </div>

                            <div id="nomor-manual-wrapper" class="d-none mt-2 p-2 rounded-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" name="nomor_surat_manual" id="input_nomor_manual"
                                           class="form-control @error('nomor_surat_manual') is-invalid @enderror"
                                           placeholder="e.g. 047 or 047.01"
                                           value="{{ old('nomor_surat_manual') }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-white text-muted small">
                                            / PREFIX / ...
                                        </span>
                                    </div>
                                </div>
                                <div class="small text-muted" style="font-size: 0.72rem;">
                                    Enter the sequence number only (e.g. <code>047</code>). The system will automatically build the division code, month, and year.
                                </div>
                            </div>
                        </div>

                        {{-- Division Dropdown --}}
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">
                                Department / Division Code <span class="text-danger">*</span>
                            </label>
                            <select name="kode_bidang" class="form-control form-control-sm rounded-3" required>
                                <option value="">-- Select Division Code --</option>
                                @foreach ($kodeBidangGroups as $groupLabel => $options)
                                    <optgroup label="{{ $groupLabel }}">
                                        @foreach ($options as $value => $optionLabel)
                                            <option value="{{ $value }}" {{ old('kode_bidang', $suratLog->kodeBidangPengaju()) === $value ? 'selected' : '' }}>
                                                {{ $optionLabel }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        {{-- Admin Notes --}}
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">Admin Notes (Optional)</label>
                            <textarea name="catatan_admin" class="form-control form-control-sm rounded-3"
                                      rows="2" placeholder="Message or notes for the requester...">{{ old('catatan_admin') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-block rounded-3 font-weight-bold shadow-sm py-2" id="btn-approve"
                                onclick="return confirm('Are you sure you want to approve this letter request? An official letter number will be generated.')">
                            <i class="fas fa-check-circle me-1"></i> Approve &amp; Issue Letter
                        </button>
                    </form>
                </div>

                {{-- ── Action 2: Reject Form ── --}}
                <div class="adm-card" style="border-top: 4px solid #ef4444 !important;">
                    <div class="adm-card-header">
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:34px;height:34px; background-color:#fee2e2; color:#dc2626;">
                            <i class="fas fa-times"></i>
                        </div>
                        <h6 style="color: #991b1b;">Reject Letter Request</h6>
                    </div>

                    <form action="{{ route('admin.persuratan.reject', $suratLog) }}" method="POST" id="form-reject">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="small font-weight-bold text-dark">
                                Reason for Rejection <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_admin" class="form-control form-control-sm rounded-3"
                                      rows="3" placeholder="Explain the reason for rejecting this request..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-danger btn-block rounded-3 font-weight-bold py-2" id="btn-reject"
                                onclick="return confirm('Are you sure you want to reject this letter request?')">
                            <i class="fas fa-times-circle me-1"></i> Reject Request
                        </button>
                    </form>
                </div>
            @endif

            {{-- ── Action 3: Download PDF (Approved) ── --}}
            @if ($suratLog->isApproved())
                <div class="adm-card" style="border-top: 4px solid #10b981 !important;">
                    <div class="adm-card-header">
                        <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:34px;height:34px; background-color:#d1fae5; color:#059669;">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h6>Official PDF Document</h6>
                    </div>
                    <p class="small text-muted mb-3">The letter has been approved and issued with an official QR verification code. You can download the PDF document below.</p>
                    <a href="{{ route('admin.persuratan.download', $suratLog) }}"
                       class="btn btn-success btn-block rounded-3 font-weight-bold shadow-sm py-2">
                        <i class="fas fa-download me-2"></i> Download PDF Letter
                    </a>
                </div>
            @endif

            {{-- ── Action 4: QR Code & Verification ── --}}
            <div class="adm-card">
                <div class="adm-card-header">
                    <div class="rounded-circle p-2 d-flex align-items-center justify-content-center" style="width:34px;height:34px; background-color:#e0f2fe; color:#0284c7;">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <h6>QR Verification &amp; Authenticity</h6>
                </div>

                <div class="p-3 rounded-3 text-center mb-3" style="background-color: #f8fafc; border: 1px solid #e2e8f0;">
                    <div class="text-muted small mb-1" style="font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.05em;">Document Verification Token</div>
                    <code class="font-weight-bold fs-6 text-primary">{{ $suratLog->kode_verifikasi }}</code>
                </div>

                <a href="{{ route('persuratan.verifikasi', ['kode' => $suratLog->kode_verifikasi]) }}"
                   target="_blank" class="btn btn-outline-primary btn-sm btn-block rounded-3 py-2 font-weight-bold">
                    <i class="fas fa-external-link-alt me-1"></i> Open Public Verification Page
                </a>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var radios  = document.querySelectorAll('input[name="nomor_mode"]');
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

        @error('nomor_surat_manual')
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