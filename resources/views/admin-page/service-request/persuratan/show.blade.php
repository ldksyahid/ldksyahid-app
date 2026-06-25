@extends('admin-page.template.body')

@section('title', $title)

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <a href="{{ route('admin.persuratan.index') }}" class="btn btn-sm btn-outline-secondary rounded-3">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success rounded-3 d-flex align-items-center gap-2 mb-4">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">

        {{-- Detail Pengajuan --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-file-alt me-2 text-primary"></i>Detail Pengajuan
                    </h5>
                    <span class="badge rounded-pill bg-{{ $suratLog->statusBadgeClass() }} fs-6">
                        {{ $suratLog->statusLabel() }}
                    </span>
                </div>

                <table class="table table-borderless table-sm small">
                    <tr>
                        <td class="text-muted fw-semibold" style="width:160px">Jenis Surat</td>
                        <td>: {{ $suratLog->label }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Nomor Surat</td>
                        <td>: {{ $suratLog->nomor_surat !== '-' ? $suratLog->nomor_surat : '—' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Pengaju</td>
                        <td>: {{ $suratLog->user?->name ?? '-' }} ({{ $suratLog->user?->email ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Asal Bidang / LDKSF</td>
                        <td>
                            :
                            @if ($suratLog->kodeBidangPengaju())
                                <span class="badge bg-light text-secondary border me-1">{{ $suratLog->kodeBidangPengaju() }}</span>
                            @endif
                            {{ $suratLog->labelBidangPengaju() }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted fw-semibold">Tanggal Ajuan</td>
                        <td>: {{ $suratLog->created_at->locale('id')->translatedFormat('d F Y, H:i') }}</td>
                    </tr>
                    @if ($suratLog->approved_at)
                        <tr>
                            <td class="text-muted fw-semibold">
                                {{ $suratLog->isApproved() ? 'Disetujui' : 'Ditolak' }} Oleh
                            </td>
                            <td>: {{ $suratLog->approvedBy?->name ?? '-' }}
                                &bull; {{ $suratLog->approved_at->locale('id')->translatedFormat('d F Y, H:i') }}
                            </td>
                        </tr>
                    @endif
                    @if ($suratLog->catatan_admin)
                        <tr>
                            <td class="text-muted fw-semibold">Catatan Admin</td>
                            <td>: {{ $suratLog->catatan_admin }}</td>
                        </tr>
                    @endif
                </table>

                <hr class="my-3">

                <h6 class="fw-bold mb-3">Data Isian</h6>
                @php
                    $fieldLabels = [
                        'kode_bidang'       => 'Asal Bidang / LDKSF',
                        'jenis_undangan'    => 'Jenis Undangan',
                        'nama_acara'        => 'Nama Acara',
                        'tema_acara'        => 'Tema Acara',
                        'nama_ketua_pelaksana' => 'Nama Ketua Pelaksana',
                        'nim_ketua_pelaksana'  => 'NIM Ketua Pelaksana',
                        'hari_tanggal'      => 'Tanggal Acara',
                        'waktu'             => 'Waktu',
                        'tempat'            => 'Tempat',
                        'tempat_dipinjam'   => 'Tempat yang Dipinjam',
                        'alamat_tempat'     => 'Alamat Tempat',
                        'ditujukan_kepada'  => 'Ditujukan Kepada',
                        'daftar_alat'       => 'Daftar Alat',
                        'nama_program'      => 'Nama Program',
                        'keperluan'         => 'Keperluan',
                        'nama'              => 'Nama',
                        'nim'               => 'NIM',
                        'fakultas'          => 'Fakultas',
                        'jurusan'           => 'Jurusan',
                        'jabatan'           => 'Jabatan di LDK',
                        'program_rekomendasi' => 'Program Rekomendasi',
                        'pertimbangan'      => 'Pertimbangan',
                    ];
                @endphp
                <table class="table table-borderless table-sm small">
                    @foreach ($suratLog->data as $key => $value)
                        @continue(in_array($key, ['jenis_surat', 'kode_bidang']))
                        <tr>
                            <td class="text-muted fw-semibold" style="width:160px">
                                {{ $fieldLabels[$key] ?? ucwords(str_replace('_', ' ', $key)) }}
                            </td>
                            <td>: {!! nl2br(e($value)) !!}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        {{-- Panel Aksi --}}
        <div class="col-lg-5">

            {{-- Approve --}}
            @if ($suratLog->isPending())
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3">
                    <h6 class="fw-bold text-success mb-3">
                        <i class="fas fa-check-circle me-1"></i> Setujui Pengajuan
                    </h6>
                    <form action="{{ route('admin.persuratan.approve', $suratLog) }}" method="POST" id="form-approve">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-semibold d-block mb-2">Nomor Surat</label>

                            <div class="alert alert-info py-2 px-3 rounded-3 mb-3 border-0 bg-info bg-opacity-10 d-flex align-items-center gap-3">
                                <div class="text-info fs-4"><i class="fas fa-info-circle"></i></div>
                                <div>
                                    <span class="d-block small text-muted" style="font-size: 0.75rem;">Nomor surat terakhir diterbitkan:</span>
                                    <strong class="text-dark">{{ $lastNomor ?? 'null (Buat Baru)' }}</strong>
                                </div>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="nomor_mode"
                                       id="nomor-mode-auto" value="auto" checked>
                                <label class="form-check-label small" for="nomor-mode-auto">
                                    Generate otomatis (urutan berikutnya bulan ini)
                                </label>
                            </div>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="nomor_mode"
                                       id="nomor-mode-manual" value="manual">
                                <label class="form-check-label small" for="nomor-mode-manual">
                                    Input manual
                                </label>
                            </div>

                            <div id="nomor-manual-wrapper" class="d-none mt-2">
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" name="nomor_surat_manual" id="input_nomor_manual"
                                           class="form-control rounded-start-3 @error('nomor_surat_manual') is-invalid @enderror"
                                           placeholder="Cth: 047 atau 047.01"
                                           value="{{ old('nomor_surat_manual') }}">
                                    <span class="input-group-text bg-light text-muted rounded-end-3" style="font-size: 0.75rem;">
                                        / PREFIX / KODE / LDK SYAHID / ...
                                    </span>
                                </div>
                                @error('nomor_surat_manual')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <div class="form-text" style="font-size:.72rem">
                                    Cukup masukkan <strong>nomor urutnya saja</strong> (cth: <code>047</code> atau <code>047.01</code>).<br>
                                    Sistem akan otomatis merangkai sisa formatnya menjadi: <br>
                                    <span class="text-primary mt-1 d-inline-block">
                                        <em>Contoh: 047/Ph-e/KST/LDK SYAHID/6/2026</em>
                                    </span>
                                </div>
                            </div>

                        {{-- REFAKTOR: dropdown kode bidang sekarang loop dari $kodeBidangGroups
                             (single source of truth dari SuratLog::getKodeBidangGroups()),
                             tidak ada lagi daftar hardcoded duplikat di sini. --}}
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">
                                Kode Bidang / LDKSF <span class="text-danger">*</span>
                            </label>
                            <select name="kode_bidang" class="form-select form-select-sm rounded-3" required>
                                <option value="">-- Pilih Kode Pengaju --</option>
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
                            <div class="form-text" style="font-size:.72rem">
                                Wajib diisi untuk menyusun struktur penomoran surat.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Catatan (opsional)</label>
                            <textarea name="catatan_admin" class="form-control form-control-sm rounded-3"
                                      rows="3" placeholder="Catatan untuk pengaju...">{{ old('catatan_admin') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-success rounded-3 w-100 fw-semibold" id="btn-approve"
                                onclick="return confirm('Setujui pengajuan ini? Nomor surat akan diterbitkan.')">
                            <i class="fas fa-check me-2"></i> Setujui & Terbitkan Nomor Surat
                        </button>
                    </form>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3">
                    <h6 class="fw-bold text-danger mb-3">
                        <i class="fas fa-times-circle me-1"></i> Tolak Pengajuan
                    </h6>
                    <form action="{{ route('admin.persuratan.reject', $suratLog) }}" method="POST" id="form-reject">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">
                                Alasan Penolakan <span class="text-danger">*</span>
                            </label>
                            <textarea name="catatan_admin" class="form-control form-control-sm rounded-3"
                                      rows="3" placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger rounded-3 w-100 fw-semibold" id="btn-reject"
                                onclick="return confirm('Tolak pengajuan ini?')">
                            <i class="fas fa-times me-2"></i> Tolak Pengajuan
                        </button>
                    </form>
                </div>
            @endif

            {{-- Download (approved) --}}
            @if ($suratLog->isApproved())
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-3">
                    <h6 class="fw-bold mb-3">
                        <i class="fas fa-file-pdf me-1 text-danger"></i> Unduh PDF
                    </h6>
                    <a href="{{ route('admin.persuratan.download', $suratLog) }}"
                       class="btn btn-success rounded-3 w-100 fw-semibold">
                        <i class="fas fa-download me-2"></i> Download PDF Surat
                    </a>
                </div>
            @endif

            {{-- Kode Verifikasi --}}
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-qrcode me-1 text-primary"></i> Kode Verifikasi
                </h6>
                <div class="bg-light rounded-3 p-2 text-center mb-2">
                    <code class="small">{{ $suratLog->kode_verifikasi }}</code>
                </div>
                <a href="{{ route('persuratan.verifikasi', ['kode' => $suratLog->kode_verifikasi]) }}"
                   target="_blank" class="btn btn-outline-primary btn-sm rounded-3 w-100">
                    <i class="fas fa-external-link-alt me-1"></i> Buka Halaman Verifikasi
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
                    btnApprove.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Menyetujui...';
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
                    btnReject.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i>Menolak...';
                    btnReject.style.cursor = 'not-allowed';
                }, 10);
            }
        });
    }
});
</script>

@endsection
