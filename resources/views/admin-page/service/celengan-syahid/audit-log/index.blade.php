@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.service.celengan-syahid.audit-log.components._index-styles')
    @include('components.pagination-custom.styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Header --}}
        <div class="col-12 mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 page-header">
                <div>
                    <h1 class="page-title mb-0"><i class="fas fa-history me-2"></i>Audit Log</h1>
                    <p class="text-muted mb-0 mt-1 small d-none d-md-block">Admin activity on Celengan Syahid campaigns &amp; donations</p>
                </div>
                <button type="button" id="audit-refresh" class="btn btn-sm btn-outline-secondary btn-rounded">
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="col-12 mb-3">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-total"><i class="fas fa-layer-group"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="audit-stat-total">{{ number_format($stats['total']) }}</div>
                            <div class="stat-label">Total Actions</div>
                            <div class="stat-sub">all time</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-create"><i class="fas fa-plus-circle"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="audit-stat-create">{{ number_format($stats['create']) }}</div>
                            <div class="stat-label">Created</div>
                            <div class="stat-sub">new records</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-update"><i class="fas fa-pen"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="audit-stat-update">{{ number_format($stats['update']) }}</div>
                            <div class="stat-label">Updated</div>
                            <div class="stat-sub">edits</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-delete"><i class="fas fa-trash-alt"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="audit-stat-delete">{{ number_format($stats['delete']) }}</div>
                            <div class="stat-label">Deleted</div>
                            <div class="stat-sub">removals</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="col-12 mb-3">
            <form method="GET" class="filter-bar" id="audit-filter-form">
                <select name="action_type" id="audit-action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    <option value="create" {{ request('action_type') === 'create' ? 'selected' : '' }}>Create</option>
                    <option value="update" {{ request('action_type') === 'update' ? 'selected' : '' }}>Update</option>
                    <option value="delete" {{ request('action_type') === 'delete' ? 'selected' : '' }}>Delete</option>
                </select>
                <select name="entity_type" id="audit-entity" class="form-select form-select-sm">
                    <option value="">All Entities</option>
                    <option value="campaign" {{ request('entity_type') === 'campaign' ? 'selected' : '' }}>Campaign</option>
                    <option value="donation" {{ request('entity_type') === 'donation' ? 'selected' : '' }}>Donation</option>
                </select>
                <input type="text" name="search" id="audit-search" class="form-control form-control-sm filter-search"
                       placeholder="Search description..." value="{{ request('search') }}" autocomplete="off">
            </form>
        </div>

        {{-- Table --}}
        <div class="col-12 mb-3">
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0" id="audit-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Admin</th>
                                <th>Action</th>
                                <th>Entity</th>
                                <th>Description</th>
                                <th>IP</th>
                            </tr>
                        </thead>
                        <tbody id="audit-tbody">
                            @include('admin-page.service.celengan-syahid.audit-log.components._table-rows')
                        </tbody>
                    </table>
                </div>

                <div class="table-pagination" id="audit-pagination">
                    @if($logs->hasPages())
                        @include('components.pagination-custom.index', [
                            'paginator' => $logs,
                            'itemLabel' => 'log',
                        ])
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
@include('admin-page.service.celengan-syahid.audit-log.components._index-scripts')
@endsection
