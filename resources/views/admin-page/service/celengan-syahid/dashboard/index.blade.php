@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.dashboard.components._dashboard-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="cs-page-title">
                <i class="fa fa-donate me-2"></i>
                <span>Celengan Syahid</span>
                <span class="highlighted-text ms-1">Analytics Dashboard</span>
            </h1>

            <!-- Info Cards -->
            <div class="col-md-12 mb-4">
                <div class="row g-3">
                    <div class="col-6 col-md-4">
                        <div class="cs-info-card p-3 d-flex align-items-center gap-3">
                            <div class="cs-info-icon" style="background: linear-gradient(135deg, #00a79d, #008b84);">
                                <i class="fa fa-chart-bar"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-muted" style="font-size: 0.8rem;">Chart 1</div>
                                <div class="fw-semibold" style="color: #00a79d;">Donation Class</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="cs-info-card p-3 d-flex align-items-center gap-3">
                            <div class="cs-info-icon" style="background: linear-gradient(135deg, #008b84, #006b63);">
                                <i class="fa fa-chart-pie"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-muted" style="font-size: 0.8rem;">Chart 2</div>
                                <div class="fw-semibold" style="color: #008b84;">Age Category</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="cs-info-card p-3 d-flex align-items-center gap-3">
                            <div class="cs-info-icon" style="background: linear-gradient(135deg, #00c9bd, #00a79d);">
                                <i class="fa fa-chart-area"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-muted" style="font-size: 0.8rem;">Chart 3</div>
                                <div class="fw-semibold" style="color: #006b63;">Age × Donation</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 1: Bar + Pie -->
            <div class="col-md-12 mb-4">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card cs-card h-100">
                            <div class="card-body">
                                <h5 class="cs-section-title mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>Donation Class Distribution
                                </h5>
                                <div class="cs-chart-container position-relative">
                                    <div class="cs-loading-overlay" id="barLoading">
                                        <div class="cs-loading-spinner"></div>
                                    </div>
                                    <div id="bar-plot"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card cs-card h-100">
                            <div class="card-body">
                                <h5 class="cs-section-title mb-3">
                                    <i class="fas fa-chart-pie me-2"></i>Donors by Age Category
                                </h5>
                                <div class="cs-chart-container position-relative">
                                    <div class="cs-loading-overlay" id="pieLoading">
                                        <div class="cs-loading-spinner"></div>
                                    </div>
                                    <div id="age-pie-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 2: Grouped Bar -->
            <div class="col-md-12 mb-4">
                <div class="card cs-card">
                    <div class="card-body">
                        <h5 class="cs-section-title mb-3">
                            <i class="fas fa-chart-area me-2"></i>Donor Counts by Age & Donation Category
                        </h5>
                        <div class="cs-chart-container position-relative">
                            <div class="cs-loading-overlay" id="bar2Loading">
                                <div class="cs-loading-spinner"></div>
                            </div>
                            <div id="bar-plot-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Progress List -->
            <div class="col-md-12 mb-4">
                <div class="card cs-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="cs-section-title mb-0">
                                <i class="fas fa-hand-holding-heart me-2"></i>Campaign Progress
                            </h5>
                            <a href="{{ route('admin.service.index.celsyahid.dashboard') }}" class="cs-btn-all">
                                <i class="fas fa-list me-1"></i>All Campaigns
                            </a>
                        </div>

                        @if($campaigns->isEmpty())
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-hand-holding-heart fa-2x mb-2 d-block"></i>
                            No campaigns found.
                        </div>
                        @else
                        <div class="table-responsive">
                            <table class="table cs-campaign-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Campaign</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-end">Target</th>
                                        <th class="text-end">Collected</th>
                                        <th style="min-width:140px;">Progress</th>
                                        <th class="text-end">Available</th>
                                        <th class="text-center">Deadline</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaigns as $i => $c)
                                    @php
                                        $pct        = $c['pct'];
                                        $barClass   = $pct >= 100 ? 'cs-bar-full' : ($pct >= 60 ? 'cs-bar-good' : ($pct >= 30 ? 'cs-bar-mid' : 'cs-bar-low'));
                                        $isExpired  = $c['deadline'] && \Carbon\Carbon::parse($c['deadline'])->isPast();
                                    @endphp
                                    <tr>
                                        <td class="text-muted small">{{ $i + 1 }}</td>
                                        <td>
                                            <div class="cs-campaign-name" title="{{ $c['judul'] }}">{{ $c['judul'] }}</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="cs-category-badge">{{ $c['kategori'] }}</span>
                                        </td>
                                        <td class="text-end small fw-semibold">
                                            Rp {{ number_format($c['target'], 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <span class="cs-amount-collected">Rp {{ number_format($c['total_paid'], 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            <div class="cs-progress-wrap">
                                                <div class="cs-progress-bar-bg">
                                                    <div class="cs-progress-bar-fill {{ $barClass }}" style="width: {{ $pct }}%;"></div>
                                                </div>
                                                <span class="cs-pct-label">{{ $pct }}%</span>
                                            </div>
                                        </td>
                                        <td class="text-end">
                                            <span class="{{ $c['available'] > 0 ? 'cs-amount-available' : 'text-muted' }}">
                                                Rp {{ number_format($c['available'], 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="text-center small {{ $isExpired ? 'text-danger' : 'text-muted' }}">
                                            @if($c['deadline'])
                                                {{ \Carbon\Carbon::parse($c['deadline'])->format('d M Y') }}
                                                @if($isExpired) <span class="cs-expired-tag">Expired</span> @endif
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.celsyahid.campaign.finance', $c['id']) }}"
                                               class="btn btn-sm cs-btn-finance" title="Finance">
                                                <i class="fas fa-wallet"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="fw-bold text-end small pt-3">Total across all campaigns</td>
                                        <td class="text-end fw-bold small pt-3">
                                            Rp {{ number_format($campaigns->sum('target'), 0, ',', '.') }}
                                        </td>
                                        <td class="text-end pt-3">
                                            <span class="cs-amount-collected fw-bold">
                                                Rp {{ number_format($campaigns->sum('total_paid'), 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td colspan="2" class="text-end pt-3">
                                            <span class="cs-amount-available fw-bold">
                                                Rp {{ number_format($campaigns->sum('available'), 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('admin-page.service.celengan-syahid.dashboard.components._dashboard-scripts')
@endsection
