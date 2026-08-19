@extends('admin-page.template.body')
{{-- Path: resources/views/admin-page/service-request/persuratan/index.blade.php --}}

@section('title', $title)

@section('head')
<style>
/* ── High-Contrast Admin Styles for Letter Management ──────────────── */
.adm-letter-container {
    padding: 1.5rem 0.5rem;
}
.adm-card {
    background: #ffffff !important;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}
.adm-kpi-link {
    text-decoration: none !important;
    color: inherit !important;
    display: block;
}
.adm-kpi-card {
    background: #ffffff !important;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 1.25rem 1.35rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
}
.adm-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}
.adm-kpi-icon {
    width: 52px;
    height: 52px;
    min-width: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
}
.adm-kpi-icon.primary { background: #e0f2fe !important; color: #0284c7 !important; }
.adm-kpi-icon.warning { background: #fef3c7 !important; color: #d97706 !important; }
.adm-kpi-icon.success { background: #d1fae5 !important; color: #059669 !important; }
.adm-kpi-icon.danger  { background: #fee2e2 !important; color: #dc2626 !important; }

.adm-kpi-title {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #64748b;
    margin-bottom: 0.2rem;
}
.adm-kpi-number {
    font-size: 1.55rem;
    font-weight: 800;
    line-height: 1;
    color: #0f172a;
    margin: 0;
}
.adm-kpi-number.warning { color: #d97706 !important; }
.adm-kpi-number.success { color: #059669 !important; }
.adm-kpi-number.danger  { color: #dc2626 !important; }

/* Status Badges */
.adm-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50rem;
    font-size: 0.75rem;
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

/* User Avatar */
.adm-user-avatar {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    background-color: #e0f2fe;
    color: #0284c7;
    font-weight: 700;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Table Style */
.adm-table-wrap {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    overflow: hidden;
}
.adm-table {
    width: 100%;
    margin-bottom: 0;
}
.adm-table th {
    background-color: #f8fafc !important;
    color: #475569 !important;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 0.9rem 1rem;
    border-bottom: 2px solid #e2e8f0;
    border-top: none;
}
.adm-table td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    font-size: 0.85rem;
}
.adm-table tbody tr:hover {
    background-color: #f8fafc;
}
</style>
@endsection

@section('content')

<div class="container-fluid adm-letter-container">

    {{-- ── 1. Header ─────────────────────────────────────────────── --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark d-flex align-items-center gap-2">
                <i class="fas fa-file-signature text-primary"></i>
                Letter Management
            </h4>
            <p class="text-muted small mb-0">Manage official letter requests, approve document submissions, and issue official letter numbers.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.persuratan.download-examples') }}" class="btn btn-outline-primary rounded-3 btn-sm px-3 shadow-sm font-weight-bold">
                <i class="fas fa-file-archive me-1"></i> Download Sample Templates (ZIP)
            </a>
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

    {{-- ── 3. KPI Stat Cards ─────────────────────────────────────── --}}
    <div class="row mb-4">
        <div class="col-sm-6 col-xl mb-3 mb-xl-0">
            <a href="{{ route('admin.persuratan.index') }}" class="adm-kpi-link">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-icon primary">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <div>
                        <div class="adm-kpi-title">Total Requests</div>
                        <div class="adm-kpi-number">{{ $totalCount ?? $suratLogs->total() }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl mb-3 mb-xl-0">
            <a href="{{ route('admin.persuratan.index', ['status' => 'pending']) }}" class="adm-kpi-link">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-icon warning">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="adm-kpi-title">Pending Review</div>
                        <div class="adm-kpi-number warning">{{ $pendingCount ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl mb-3 mb-xl-0">
            <a href="{{ route('admin.persuratan.index', ['status' => 'approved']) }}" class="adm-kpi-link">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <div class="adm-kpi-title">Approved</div>
                        <div class="adm-kpi-number success">{{ $approvedCount ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl mb-3 mb-xl-0">
            <a href="{{ route('admin.persuratan.index', ['status' => 'rejected']) }}" class="adm-kpi-link">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-icon danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div>
                        <div class="adm-kpi-title">Rejected</div>
                        <div class="adm-kpi-number danger">{{ $rejectedCount ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl mb-3 mb-xl-0">
            <a href="{{ route('admin.persuratan.index', ['status' => 'expired']) }}" class="adm-kpi-link">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-icon secondary" style="background: rgba(108, 117, 125, 0.12); color: #6c757d;">
                        <i class="fas fa-hourglass-end"></i>
                    </div>
                    <div>
                        <div class="adm-kpi-title">Expired</div>
                        <div class="adm-kpi-number" style="color: #6c757d;">{{ $expiredCount ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- ── 4. Filter Card ────────────────────────────────────────── --}}
    <div class="adm-card p-3 mb-4">
        <form method="GET" action="{{ route('admin.persuratan.index') }}" class="form-row align-items-end" id="filter-form">
            <div class="col-md-3 mb-2 mb-md-0">
                <label class="small font-weight-bold text-muted mb-1">Request Status</label>
                <select name="status" class="form-control form-control-sm rounded-3">
                    <option value="">All Status</option>
                    <option value="pending"  {{ request('status') === 'pending'   ? 'selected' : '' }}>⏳ Pending Review</option>
                    <option value="approved" {{ request('status') === 'approved'  ? 'selected' : '' }}>✅ Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected'  ? 'selected' : '' }}>❌ Rejected</option>
                    <option value="expired"  {{ request('status') === 'expired'   ? 'selected' : '' }}>⌛ Expired</option>
                </select>
            </div>
            <div class="col-md-5 mb-2 mb-md-0">
                <label class="small font-weight-bold text-muted mb-1">Letter Type</label>
                <select name="jenis" class="form-control form-control-sm rounded-3">
                    <option value="">All Letter Types</option>
                    @foreach ($suratTypes as $key => $surat)
                        <option value="{{ $key }}" {{ request('jenis') === $key ? 'selected' : '' }}>
                            {{ $surat['label'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 px-3 flex-grow-1 font-weight-bold shadow-sm">
                    <i class="fas fa-filter me-1"></i> Apply Filter
                </button>
                <a href="{{ route('admin.persuratan.index') }}" class="btn btn-light btn-sm rounded-3 px-3 text-secondary border">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ── 5. Main Table ─────────────────────────────────────────── --}}
    <div class="adm-table-wrap">
        <div class="table-responsive">
            <table class="table adm-table">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>Requester &amp; Division</th>
                        <th>Letter Type</th>
                        <th>Letter Number</th>
                        <th>Submitted Date</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suratLogs as $log)
                        @php
                            $kodeBidang = $log->kodeBidangPengaju();
                            $initial = strtoupper(substr($log->user?->name ?? 'U', 0, 1));
                        @endphp
                        <tr>
                            <td class="ps-4 text-muted small">{{ $suratLogs->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="adm-user-avatar">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold small text-dark">{{ $log->user?->name ?? 'Anonymous User' }}</div>
                                        <div class="text-muted small" style="font-size: 0.75rem;">{{ $log->user?->email ?? '-' }}</div>
                                        <div class="mt-1">
                                            <span class="adm-badge adm-badge-neutral" style="font-size: 0.68rem; padding: 0.2rem 0.55rem;">
                                                <i class="fas fa-users me-1 text-primary"></i>
                                                {{ $kodeBidang ? $kodeBidang . ' · ' : '' }}{{ $log->labelBidangPengaju() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-weight-bold small text-dark">{{ $log->label }}</div>
                                <code class="text-muted" style="font-size: 0.72rem;">{{ $log->jenis_surat }}</code>
                            </td>
                            <td>
                                @if ($log->nomor_surat !== '-')
                                    <span class="adm-badge adm-badge-neutral font-monospace font-weight-bold" style="font-size: 0.75rem;">
                                        {{ $log->nomor_surat }}
                                    </span>
                                @else
                                    <span class="text-muted small fst-italic">— Not Issued —</span>
                                @endif
                            </td>
                            <td class="small text-muted">
                                <div><i class="fas fa-calendar-alt me-1 text-secondary"></i> {{ $log->created_at->locale('en')->translatedFormat('d M Y') }}</div>
                                <div style="font-size: 0.72rem;"><i class="fas fa-clock me-1 text-secondary"></i> {{ $log->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                @if ($log->status === 'approved')
                                    <span class="adm-badge adm-badge-success">
                                        <i class="fas fa-check-circle me-1"></i> Approved
                                    </span>
                                @elseif ($log->status === 'rejected')
                                    <span class="adm-badge adm-badge-danger">
                                        <i class="fas fa-times-circle me-1"></i> Rejected
                                    </span>
                                @else
                                    <span class="adm-badge adm-badge-warning">
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm shadow-sm rounded-3 overflow-hidden">
                                    <a href="{{ route('admin.persuratan.show', $log) }}"
                                       class="btn btn-light text-primary border" title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if ($log->isApproved())
                                        <a href="{{ route('admin.persuratan.download', $log) }}"
                                           class="btn btn-light text-success border" title="Download PDF Letter">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @endif
                                    @hasrole('Superadmin')
                                        <form action="{{ route('admin.persuratan.destroy', $log) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this letter request record?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-light text-danger border" title="Delete Record">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endhasrole
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <div class="p-4">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3" style="width:64px;height:64px; background-color: #f1f5f9; color: #94a3b8;">
                                        <i class="fas fa-inbox fa-2x"></i>
                                    </div>
                                    <h6 class="font-weight-bold text-dark">No letter requests found</h6>
                                    <p class="small text-muted mb-0">No records match the selected filter criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($suratLogs->hasPages())
            <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span class="small text-muted">
                    Showing {{ $suratLogs->firstItem() }} to {{ $suratLogs->lastItem() }} of {{ $suratLogs->total() }} entries
                </span>
                <div>
                    {{ $suratLogs->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>

</div>

@endsection