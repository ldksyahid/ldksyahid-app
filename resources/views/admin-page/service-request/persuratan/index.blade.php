@extends('admin-page.template.body')
{{-- Path: resources/views/admin-page/service-request/persuratan/index.blade.php --}}

@section('title', $title)

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Persuratan</h4>
            <p class="text-muted small mb-0">Daftar pengajuan surat dari kader LDK Syahid.</p>
        </div>
    </div>

    {{-- Alert --}}
    @if (session('success'))
        <div class="alert alert-success rounded-3 d-flex align-items-center gap-2 mb-4">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Filter --}}
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form method="GET" action="{{ route('admin.persuratan.index') }}" class="row g-2 align-items-end" id="filter-form">
            <div class="col-md-4">
                <label class="form-label small fw-semibold mb-1">Status</label>
                <select name="status" class="form-select form-select-sm rounded-3">
                    <option value="">Semua Status</option>
                    <option value="pending"  {{ request('status') === 'pending'   ? 'selected' : '' }}>Menunggu</option>
                    <option value="approved" {{ request('status') === 'approved'  ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-5">
                <label class="form-label small fw-semibold mb-1">Jenis Surat</label>
                <select name="jenis" class="form-select form-select-sm rounded-3">
                    <option value="">Semua Jenis</option>
                    @foreach ($suratTypes as $key => $surat)
                        <option value="{{ $key }}" {{ request('jenis') === $key ? 'selected' : '' }}>
                            {{ $surat['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 flex-grow-1">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.persuratan.index') }}" class="btn btn-outline-secondary btn-sm rounded-3">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Pengaju</th>
                        <th>Jenis Surat</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal Ajuan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suratLogs as $log)
                        @php
                            $kodeBidang = $log->kodeBidangPengaju();
                        @endphp
                        <tr>
                            <td class="ps-4 text-muted small">{{ $suratLogs->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="fw-semibold small">{{ $log->user?->name ?? '-' }}</div>
                                <div class="text-muted mb-1" style="font-size:.7rem">{{ $log->user?->email ?? '-' }}</div>
                                <span class="badge bg-light text-secondary border" style="font-size: 0.65rem;">
                                    <i class="fas fa-users me-1"></i>
                                    {{ $kodeBidang ? $kodeBidang . ' - ' : '' }}{{ $log->labelBidangPengaju() }}
                                </span>
                            </td>
                            <td class="small">{{ $log->label }}</td>
                            <td class="small text-muted">
                                {{ $log->nomor_surat !== '-' ? $log->nomor_surat : '—' }}
                            </td>
                            <td class="small text-muted">
                                {{ $log->created_at->locale('id')->translatedFormat('d M Y') }}
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $log->statusBadgeClass() }}">
                                    {{ $log->statusLabel() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.persuratan.show', $log) }}"
                                   class="btn btn-sm btn-outline-primary rounded-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if ($log->isApproved())
                                    <a href="{{ route('admin.persuratan.download', $log) }}"
                                       class="btn btn-sm btn-success rounded-3">
                                        <i class="fas fa-download"></i>
                                    </a>
                                @endif
                                @hasrole('Superadmin')
                                    <form action="{{ route('admin.persuratan.destroy', $log) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus pengajuan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger rounded-3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endhasrole
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                Belum ada pengajuan surat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($suratLogs->hasPages())
            <div class="p-3 border-top">
                {{ $suratLogs->withQueryString()->links() }}
            </div>
        @endif
    </div>

</div>

@endsection
