@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.laravel-log.components._index-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Header --}}
        <div class="col-12 mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 page-header">
                <div>
                    <h1 class="page-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>Laravel Log
                    </h1>
                    <p class="text-muted mb-0 mt-1 small d-none d-md-block">Read and manage <code>storage/logs/laravel.log</code></p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap header-controls">
                    <span class="text-muted small" id="file-meta">—</span>
                    <a href="{{ route('admin.laravel-log.download') }}" class="btn btn-sm btn-outline-secondary btn-rounded">
                        <i class="fas fa-download me-1"></i>Download
                    </a>
                    <button class="btn btn-sm btn-outline-danger btn-rounded" id="btn-clear-log">
                        <i class="fas fa-trash-alt me-1"></i>Clear Log
                    </button>
                </div>
            </div>
        </div>

        {{-- Truncated-file notice --}}
        <div class="col-12 mb-3" id="truncated-banner" style="display:none;">
            <div class="ll-alert">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    The log file is large — only the most recent portion is shown. Clear it periodically to keep this page fast.
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="col-12 mb-3">
            <div class="row g-3">
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-total"><i class="fas fa-layer-group"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-total">—</div>
                            <div class="stat-label">Total Entries</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-critical"><i class="fas fa-skull-crossbones"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-critical">—</div>
                            <div class="stat-label">Critical</div>
                            <div class="stat-sub">emergency / alert / critical</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-error"><i class="fas fa-times-circle"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-error">—</div>
                            <div class="stat-label">Error</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-warning"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-warning">—</div>
                            <div class="stat-label">Warning</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-info"><i class="fas fa-info-circle"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-info">—</div>
                            <div class="stat-label">Info / Debug</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Bar + Table --}}
        <div class="col-12 mb-3">
            <div class="table-card">
                <div class="filter-bar">
                    <select id="filter-level" class="form-select form-select-sm filter-control">
                        <option value="all">All Levels</option>
                        <option value="emergency">Emergency</option>
                        <option value="alert">Alert</option>
                        <option value="critical">Critical</option>
                        <option value="error">Error</option>
                        <option value="warning">Warning</option>
                        <option value="notice">Notice</option>
                        <option value="info">Info</option>
                        <option value="debug">Debug</option>
                    </select>
                    <div class="search-input-wrap">
                        <i class="fas fa-search search-input-icon"></i>
                        <input type="text" class="form-control form-control-sm filter-search" id="filter-search"
                            placeholder="Search message or stack trace...">
                    </div>
                    <div class="d-flex gap-1 ms-auto">
                        <button class="btn btn-sm btn-outline-secondary btn-rounded" id="btn-refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0" id="log-table">
                        <thead>
                            <tr>
                                <th style="width:160px">Time</th>
                                <th class="text-center" style="width:110px">Level</th>
                                <th>Message</th>
                                <th class="text-center" style="width:80px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="log-tbody">
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="table-pagination d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <span class="text-muted small" id="pagination-info"></span>
                    <div class="d-flex gap-1 flex-wrap" id="pagination-controls"></div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Entry Detail Modal --}}
<div class="modal fade" id="log-detail-modal" tabindex="-1" aria-labelledby="logDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content ll-modal-content">
            <div class="modal-header ll-modal-header">
                <h5 class="modal-title text-white" id="logDetailModalLabel">
                    <i class="fas fa-file-alt me-2"></i>
                    Log Entry &mdash; <span id="modal-log-time">—</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="detail-group">
                    <div class="detail-label">Level</div>
                    <div id="modal-log-level">—</div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Full Message / Stack Trace</div>
                    <pre class="raw-payload" id="modal-log-body"></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary btn-rounded" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('admin-page.laravel-log.components._index-scripts')
@endsection
