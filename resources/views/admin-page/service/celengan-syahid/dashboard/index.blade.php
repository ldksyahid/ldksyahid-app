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

        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('admin-page.service.celengan-syahid.dashboard.components._dashboard-scripts')
@endsection
