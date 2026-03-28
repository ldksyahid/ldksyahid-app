@extends('landing-page.template.body')

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@include('admin-page.analytics.visitors.components._styles')
@endsection

@section('content')
<div class="container-fluid py-4 px-3 px-md-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h4 class="fw-bold mb-0"><i class="fas fa-chart-line me-2" style="color:#00a79d;"></i>Visitor Analytics</h4>
            <p class="text-muted small mb-0">Public page visitor statistics — tracks visitors, page hits, and device types</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left fa-xs me-1"></i>Dashboard
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-3">
        <div class="col-6 col-md">
            <div class="va-stat-card" style="background:rgba(0,167,157,.08);">
                <div class="va-value" style="color:#00a79d;" id="va-today">—</div>
                <div class="va-label"><i class="fas fa-sun fa-xs me-1"></i>Today</div>
                <div class="va-sublabel">visitors today</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="va-stat-card" style="background:rgba(99,102,241,.08);">
                <div class="va-value" style="color:#6366f1;" id="va-month">—</div>
                <div class="va-label"><i class="fas fa-calendar-alt fa-xs me-1"></i>This Month</div>
                <div class="va-sublabel">visitors this month</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="va-stat-card" style="background:rgba(234,179,8,.08);">
                <div class="va-value" style="color:#ca8a04;" id="va-year">—</div>
                <div class="va-label"><i class="fas fa-calendar fa-xs me-1"></i>This Year</div>
                <div class="va-sublabel">visitors this year</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="va-stat-card" style="background:rgba(245,158,11,.08);">
                <div class="va-value" style="color:#f59e0b;" id="va-alltime">—</div>
                <div class="va-label"><i class="fas fa-history fa-xs me-1"></i>All-Time</div>
                <div class="va-sublabel">since first recorded</div>
            </div>
        </div>
        <div class="col-6 col-md">
            <div class="va-stat-card" style="background:rgba(16,185,129,.08);"
                data-bs-toggle="tooltip" data-bs-placement="bottom"
                title="Visitors (distinct IPs) who loaded a page within the last 30 minutes. Does not mean they are online right now.">
                <div class="va-value" style="color:#10b981;" id="va-activenow">—</div>
                <div class="va-label"><i class="fas fa-circle fa-xs me-1" style="color:#10b981;"></i>Active Now</div>
                <div class="va-sublabel">active in last 30 min</div>
            </div>
        </div>
    </div>

    {{-- Date Range + Countdown Bar --}}
    <div class="d-flex align-items-center gap-2 flex-wrap py-2 mb-4 va-range-bar">
        <i class="fas fa-calendar-alt fa-xs text-muted"></i>
        <input type="text" id="va-daterange" class="form-control form-control-sm"
            style="max-width:280px;flex:1;font-size:.8rem;cursor:pointer;"
            placeholder="Select date range" autocomplete="off">
        <span class="text-muted small ms-auto" style="white-space:nowrap;">
            Auto-refresh in
            <span id="va-countdown" class="fw-semibold" style="color:#00a79d;">60</span>s
        </span>
        <button id="va-refresh" type="button"
            style="background:transparent;color:#00a79d;border:1px solid #00a79d;border-radius:6px;padding:2px 9px;cursor:pointer;line-height:1.5;"
            data-bs-toggle="tooltip" title="Refresh now">
            <i class="fas fa-sync-alt fa-xs"></i>
        </button>
    </div>

    {{-- Charts Row --}}
    <div class="row g-3 mb-4">

        {{-- Line Chart --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="va-section-title mb-1"><i class="fas fa-chart-area me-2"></i>Daily Visitor Trend</h6>
                    <p class="text-muted mb-3" style="font-size:.75rem;">Number of visitors per day in the selected period</p>
                    <div class="va-chart-container">
                        <canvas id="va-line-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Device Breakdown --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h6 class="va-section-title mb-1"><i class="fas fa-mobile-alt me-2"></i>Device Breakdown</h6>
                    <p class="text-muted mb-3" style="font-size:.75rem;">What devices visitors used to access the site</p>
                    <div class="va-chart-container flex-grow-1">
                        <canvas id="va-device-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Top Pages --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            {{-- Header row: title + search --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <div>
                    <h6 class="va-section-title mb-0"><i class="fas fa-file-alt me-2"></i>Top Pages</h6>
                    <p class="text-muted mb-0" style="font-size:.72rem;">Most visited pages in the selected period</p>
                </div>
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="text-muted small" id="va-tp-info"></span>
                    <div class="va-search-wrap">
                        <i class="fas fa-search va-search-icon"></i>
                        <input type="text" id="va-tp-search" class="form-control form-control-sm va-search-input"
                            placeholder="Search path..." autocomplete="off">
                        <button class="va-search-clear d-none" id="va-tp-clear" type="button">
                            <i class="fas fa-times fa-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover va-table mb-0">
                    <thead>
                        <tr>
                            <th style="width:40px;">#</th>
                            <th>
                                Path
                                <i class="fas fa-question-circle fa-xs ms-1 text-muted" style="cursor:default;"
                                    data-bs-toggle="tooltip" title="The URL path of the visited page (e.g. /about, /news/5)"></i>
                            </th>
                            <th class="text-end va-sort-th" data-sort="hits" style="cursor:pointer; white-space:nowrap;">
                                Hits
                                <i class="fas fa-question-circle fa-xs ms-1 text-muted" style="cursor:default;"
                                    data-bs-toggle="tooltip" title="Total page loads. Repeat visits from the same person are counted separately."></i>
                                <span class="va-sort-arrow ms-1" id="va-arrow-hits">↓</span>
                            </th>
                            <th class="text-end va-sort-th" data-sort="uniques" style="cursor:pointer; white-space:nowrap;">
                                Visitors
                                <i class="fas fa-question-circle fa-xs ms-1 text-muted" style="cursor:default;"
                                    data-bs-toggle="tooltip" title="Number of distinct visitors (different people) who opened this page."></i>
                                <span class="va-sort-arrow ms-1" id="va-arrow-uniques"></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="va-top-pages">
                        <tr><td colspan="4" class="text-center text-muted py-3">Loading...</td></tr>
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-3" id="va-tp-pagination"></div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
@include('admin-page.analytics.visitors.components._scripts')
@endsection
