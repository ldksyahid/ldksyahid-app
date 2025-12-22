@extends('landing-page.template.body')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-0 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1RNWVLrXSyfS5kXXllib3HyGOyBZEW257" alt="Report Header Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Report Section Start -->
<div class="container-xxl" style="background-color: #f5f6fa">
    <div class="container py-5">
        <!-- Breadcrumbs Card -->
        <div class="card border-0 shadow-sm mb-4 wow fadeInUp" data-wow-delay="0.1s">
            <div class="card-body py-3 px-4">
                <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i> Beranda
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <i class="fas fa-file-alt me-1"></i> Laporan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- End Breadcrumbs Card -->

        <div class="card border-0 shadow-sm mb-5 wow fadeInUp" data-wow-delay="0.2s">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3 class="mb-3" style="color: #00a79d;">
                        <i class="fas fa-file-contract me-2"></i>Laporan LDK Syahid
                    </h3>
                    <div class="divider-custom mx-auto" style="width: 100px; height: 3px; background-color: #00a79d;"></div>
                </div>

                <div class="row">
                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-check-circle" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Akurat dan Terverifikasi</h6>
                                <p class="mb-0 text-muted small">Data yang disajikan telah melalui proses validasi ketat</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-eye" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Terbuka dan Transparan</h6>
                                <p class="mb-0 text-muted small">Dapat diakses publik tanpa batasan akses</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-history" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Tepat Waktu dan Teratur</h6>
                                <p class="mb-0 text-muted small">Diterbitkan sesuai jadwal yang telah ditetapkan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-balance-scale" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Komprehensif dan Lengkap</h6>
                                <p class="mb-0 text-muted small">Mencakup seluruh aspek yang diperlukan</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 mb-3 mb-lg-0">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-chart-line" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Analitis dan Informatif</h6>
                                <p class="mb-0 text-muted small">Disertai analisis mendalam untuk pengambilan keputusan</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background-color: rgba(0, 168, 204, 0.1);">
                                    <i class="fas fa-file-alt" style="color: #00a79d;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">Terstruktur dan Sistematis</h6>
                                <p class="mb-0 text-muted small">Format penyajian yang mudah dipahami</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-justify mt-4">
                    <p class="mb-0 text-justify" style="line-height: 1.6;">
                        UKM LDK Syahid menyajikan berbagai laporan dengan standar kualitas tinggi yang mencerminkan
                        integritas organisasi. Setiap laporan dirancang untuk memberikan gambaran utuh tentang kinerja,
                        keuangan, dan program kerja kepada seluruh anggota dan stakeholders.
                    </p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            @if($reports && $reports->count() > 0)
                @foreach($reports as $report)
                <div class="col-lg-4 col-md-6 mb-4 wow fadeInUp" data-wow-delay="{{ $loop->iteration * 0.1 }}s">
                    <div class="card report-card h-100 shadow-sm border-0 overflow-hidden">
                        <!-- Report Image -->
                        <div class="position-relative overflow-hidden" style="height: 200px;">
                            @if($report->iconGdriveID)
                                <img src="https://lh3.googleusercontent.com/d/{{ $report->iconGdriveID }}"
                                     class="card-img-top h-100 w-100 object-fit-cover"
                                     alt="{{ $report->reportName }}"
                                     loading="lazy">
                            @else
                                <div class="h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fas fa-file-alt text-white" style="font-size: 4rem;"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-3">
                                {{ $report->reportName }}
                            </h5>

                            @if($report->description)
                            <div class="card-text mb-3 flex-grow-1">
                                <p style="text-align: justify; font-size: 0.9rem; line-height: 1.5;">
                                    {{ $report->description }}
                                </p>
                            </div>
                            @endif

                            <!-- Action Button -->
                            <div class="mt-auto">
                                <a href="{{ $report->node ?? '#' }}"
                                   class="btn btn-primary w-100 py-2"
                                   target="_blank">
                                    <i class="fas fa-external-link-alt me-2"></i>
                                    Akses Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-file-alt display-1 text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">Belum ada laporan tersedia</h4>
                        <p class="text-muted mb-0">Silakan kembali lagi nanti</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Report Section End -->
@endsection

@section('scripts')
@include('landing-page.report.components._index._index-scripts')
@endsection

@section('styles')
@include('landing-page.report.components._index._index-styles')
@endsection
