@extends('landing-page.template.body')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-0 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1GmgV8Pussl5orvOXnVfVePWxXjH866_x" alt="Report Header Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Report Section Start -->
<div class="container-xxl" style="background-color: #f5f6fa">
    <div class="container py-5">
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
                            <h5 class="card-title mb-3" style="color: #2c3e50;">
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
<script>
    document.body.style.backgroundColor = "#f5f6fa";
</script>
@include('landing-page.report.components._index._index-scripts')
@endsection

@section('styles')
@include('landing-page.report.components._index._index-styles')
@endsection
