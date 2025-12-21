@extends('landing-page.template.body')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-0 wow fadeIn" data-wow-delay="0.25s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1wOvUz3jq66UwdPduMGiW4RUML9JMV-nC" alt="Finance Report Header Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Finance Report Section Start -->
<div class="container-xxl" style="background-color: #f5f6fa">
    <div class="container py-5">
        <!-- Breadcrumbs Card -->
        <div class="card border-0 shadow-sm mb-4 wow fadeInUp" data-wow-delay="0.25s">
            <div class="card-body py-3 px-4">
                <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i> Beranda
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('report.index') }}" class="text-decoration-none">
                                <i class="fas fa-file-alt me-1"></i> Laporan
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-chart-pie me-1"></i> Laporan Keuangan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumbs Card -->

        <!-- Introduction Card -->
        <div class="card border-0 shadow-sm mb-5 wow fadeInUp" data-wow-delay="0.25s">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="mb-3" style="color: #00a79d;">
                        <i class="fas fa-chart-pie me-2"></i>Laporan Keuangan LDK Syahid
                    </h3>
                    <div class="divider-custom mx-auto" style="width: 100px; height: 3px; background-color: #00a79d;"></div>
                </div>

                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-hand-holding-usd" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Transparansi Keuangan</h6>
                                <p class="mb-0 text-muted small">Seluruh laporan keuangan diungkapkan secara terbuka dan transparan</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-balance-scale" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Akuntabilitas Publik</h6>
                                <p class="mb-0 text-muted small">Pertanggungjawaban penggunaan dana organisasi kepada anggota</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-calendar-alt" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Periodik dan Teratur</h6>
                                <p class="mb-0 text-muted small">Diterbitkan secara berkala sesuai periode anggaran</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 mb-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-file-invoice-dollar" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Standar Akuntansi</h6>
                                <p class="mb-0 text-muted small">Mengikuti standar akuntansi yang berlaku dan dapat dipertanggungjawabkan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-justify mt-4">
                    <p class="mb-0" style="line-height: 1.6;">
                        Laporan keuangan UKM LDK Syahid merupakan bentuk pertanggungjawaban publik atas pengelolaan dana organisasi.
                        Setiap laporan mencakup realisasi anggaran, arus kas, dan posisi keuangan yang telah melalui proses audit internal
                        untuk memastikan keakuratan dan kredibilitas informasi.
                    </p>
                </div>
            </div>
        </div>

        <!-- LDK Accordion -->
        <div class="finance-accordion-container wow fadeInUp" data-wow-delay="0.25s">
            @php
                $groupedReports = $reports->groupBy('ldkID');

                // Create sorted array of LDKs with their reports
                $sortedLdks = [];
                foreach ($groupedReports as $ldkID => $ldkReports) {
                    if ($ldkReports->first() && $ldkReports->first()->ldk) {
                        $ldkName = $ldkReports->first()->ldk->ldkName;
                    } else {
                        $ldkName = 'LDK Tidak Diketahui';
                    }

                    $sortedLdks[$ldkID] = [
                        'name' => $ldkName,
                        'reports' => $ldkReports,
                        'count' => $ldkReports->count()
                    ];
                }

                // Sort by LDK name
                uasort($sortedLdks, function($a, $b) {
                    return strcmp($a['name'], $b['name']);
                });
            @endphp

            @if($reports && $reports->count() > 0)
                <div class="accordion" id="ldkAccordion">
                    @foreach($sortedLdks as $ldkID => $ldkData)
                        @php
                            $accordionId = 'ldkAccordion_' . $ldkID;
                            $collapseId = 'collapse_' . $ldkID;
                        @endphp

                        <!-- LDK Accordion Item -->
                        <div class="accordion-item border-0 mb-3">
                            <div class="accordion-header" id="heading_{{ $ldkID }}">
                                <button class="accordion-button collapsed d-flex justify-content-between align-items-center p-4"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="false"
                                        aria-controls="{{ $collapseId }}"
                                        style="background-color: #fff; border-left: 4px solid #00a79d;">

                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                 style="width: 50px; height: 50px; background-color: rgba(0, 167, 157, 0.1);">
                                                <i class="fas fa-university" style="color: #00a79d; font-size: 1.2rem;"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 text-start">
                                            <h5 class="mb-1" style="color: #00a79d; font-weight: 600;">
                                                {{ $ldkData['name'] }}
                                            </h5>
                                            <p class="text-muted mb-0 small">
                                                <i class="fas fa-file-pdf me-1"></i>
                                                {{ $ldkData['count'] }} laporan keuangan
                                            </p>
                                        </div>
                                    </div>

                                    <div class="ms-3">
                                        <i class="fas fa-chevron-down accordion-icon"></i>
                                    </div>
                                </button>
                            </div>

                            <div id="{{ $collapseId }}"
                                 class="accordion-collapse collapse"
                                 aria-labelledby="heading_{{ $ldkID }}">

                                <div class="accordion-body p-0">
                                    <div class="report-list">
                                        @foreach($ldkData['reports'] as $report)
                                        <div class="report-item d-flex align-items-center justify-content-between p-3 border-bottom">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                                         style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                                        <i class="fas fa-file-pdf" style="color: #e74c3c;"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $report->fileName }}</h6>
                                                    <small class="text-muted">
                                                        <i class="far fa-clock me-1"></i>
                                                        Diunggah: {{ $report->createdDate->format('d M Y') }}
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="action-buttons">
                                                <div class="btn-group" role="group">
                                                    <!-- View Button -->
                                                    <a href="{{ $report->fileViewUrl() }}"
                                                       class="btn btn-outline-primary"
                                                       target="_blank"
                                                       data-bs-toggle="tooltip">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <!-- Download Button -->
                                                    <a href="{{ $report->fileUrl() }}"
                                                       class="btn btn-outline-primary ms-2"
                                                       download
                                                       data-bs-toggle="tooltip">
                                                        <i class="fas fa-download"></i>
                                                    </a>

                                                    <!-- Share Button -->
                                                    <button type="button"
                                                            class="btn btn-outline-primary ms-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#shareModal"
                                                            data-report-name="{{ $report->fileName }}"
                                                            data-report-url="{{ $report->fileUrl() }}"
                                                            data-report-view-url="{{ $report->fileViewUrl() }}">
                                                        <i class="fas fa-share-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-file-invoice-dollar display-1 text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">Belum ada laporan keuangan tersedia</h4>
                        <p class="text-muted mb-0">Laporan keuangan akan diunggah sesuai periode yang ditentukan</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Finance Report Section End -->

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">
                    <i class="fas fa-share-alt me-2"></i>Bagikan Laporan
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Laporan</label>
                    <input type="text" class="form-control" id="shareReportName" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Link Laporan</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="shareReportUrl" readonly>
                        <button class="btn btn-outline-secondary" type="button" onclick="copyShareUrl()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                <div class="text-center">
                    <p class="mb-2">Bagikan melalui:</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="#" class="btn btn-success btn-share-whatsapp" target="_blank">
                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                        </a>
                        <a href="#" class="btn btn-primary btn-share-telegram" target="_blank">
                            <i class="fab fa-telegram me-1"></i> Telegram
                        </a>
                        <button class="btn btn-outline-dark" onclick="copyShareUrl()">
                            <i class="fas fa-link me-1"></i> Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('landing-page.report.finance-report.components._index._index-scripts')
@endsection

@section('styles')
@include('landing-page.report.finance-report.components._index._index-styles')
@endsection
