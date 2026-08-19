@extends('admin-page.template.body')
{{-- Path: resources/views/admin-page/service-request/persuratan/index.blade.php --}}

@section('title', $title)

@section('head')
@include('admin-page.service-request.persuratan.components._index-styles')
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
    <div class="row mb-3">
        <div class="col-sm-6 col-xl mb-3 mb-xl-0">
            <a href="{{ route('admin.persuratan.index', request()->except('status', 'page')) }}" class="adm-kpi-link">
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
            <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}" class="adm-kpi-link">
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
            <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'approved'])) }}" class="adm-kpi-link">
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
            <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'rejected'])) }}" class="adm-kpi-link">
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
            <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'expired'])) }}" class="adm-kpi-link">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-icon secondary">
                        <i class="fas fa-hourglass-end"></i>
                    </div>
                    <div>
                        <div class="adm-kpi-title">Expired</div>
                        <div class="adm-kpi-number text-muted">{{ $expiredCount ?? 0 }}</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- ── 4. Quick Status Filter Pills ─────────────────────────── --}}
    <div class="adm-status-pills-wrap">
        <a href="{{ route('admin.persuratan.index', request()->except('status', 'page')) }}"
           class="adm-status-pill {{ !request('status') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> All Status ({{ $totalCount ?? $suratLogs->total() }})
        </a>
        <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'pending'])) }}"
           class="adm-status-pill pending {{ request('status') === 'pending' ? 'active' : '' }}">
            <i class="fas fa-clock"></i> ⏳ Pending ({{ $pendingCount ?? 0 }})
        </a>
        <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'approved'])) }}"
           class="adm-status-pill approved {{ request('status') === 'approved' ? 'active' : '' }}">
            <i class="fas fa-check-circle"></i> ✅ Approved ({{ $approvedCount ?? 0 }})
        </a>
        <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'rejected'])) }}"
           class="adm-status-pill rejected {{ request('status') === 'rejected' ? 'active' : '' }}">
            <i class="fas fa-times-circle"></i> ❌ Rejected ({{ $rejectedCount ?? 0 }})
        </a>
        <a href="{{ route('admin.persuratan.index', array_merge(request()->except('page'), ['status' => 'expired'])) }}"
           class="adm-status-pill expired {{ request('status') === 'expired' ? 'active' : '' }}">
            <i class="fas fa-hourglass-end"></i> ⌛ Expired ({{ $expiredCount ?? 0 }})
        </a>
    </div>

    {{-- ── 5. Advanced Filter & Keyword Search Bar ───────────────── --}}
    @php
        $selectedJenis = request('jenis');
        $selectedJenisInfo = $selectedJenis && isset($suratTypes[$selectedJenis]) ? $suratTypes[$selectedJenis] : null;
    @endphp

    <div class="adm-filter-card">
        <form method="GET" action="{{ route('admin.persuratan.index') }}" class="row g-2 align-items-center" id="filter-form">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="hidden" name="jenis" id="admin_filter_jenis" value="{{ request('jenis', '') }}">

            {{-- 1. Keyword Search Input --}}
            <div class="col-lg-5 col-md-12">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                    </div>
                    <input type="text" name="q" class="form-control form-control-sm border-start-0"
                           placeholder="Search requester name, email, letter number..."
                           value="{{ request('q') }}">
                </div>
            </div>

            {{-- 2. Letter Type Picker Trigger Button (No long native scroll!) --}}
            <div class="col-lg-4 col-md-7 col-12">
                <div class="adm-type-picker-btn {{ $selectedJenisInfo ? 'has-filter' : '' }}"
                     data-toggle="modal" data-target="#modalAdminChooseLetter" role="button">
                    <i class="fas {{ $selectedJenisInfo['icon'] ?? 'fa-file-signature' }} text-primary"></i>
                    <span class="text-truncate">
                        {{ $selectedJenisInfo['label'] ?? 'All Letter Types (18 Types)' }}
                    </span>
                    @if ($selectedJenis)
                        <a href="{{ route('admin.persuratan.index', request()->except('jenis', 'page')) }}"
                           class="adm-clear-filter-btn" title="Reset Letter Type"
                           onclick="event.stopPropagation();">
                            <i class="fas fa-times"></i>
                        </a>
                    @else
                        <i class="fas fa-chevron-down text-muted small ms-auto"></i>
                    @endif
                </div>
            </div>

            {{-- 3. Action Buttons --}}
            <div class="col-lg-3 col-md-5 col-12 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-3 px-3 flex-grow-1 font-weight-bold shadow-sm">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('admin.persuratan.index') }}" class="btn btn-light btn-sm rounded-3 px-3 text-secondary border">
                    <i class="fas fa-undo me-1"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ── 6. Main Table ─────────────────────────────────────────── --}}
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

{{-- Modals --}}
@include('admin-page.service-request.persuratan.components._modal-choose-letter')

@endsection