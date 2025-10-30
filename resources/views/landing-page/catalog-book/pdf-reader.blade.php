@extends('landing-page.template.body')

@section('content')
<div class="container-fluid py-4">
    <!-- Elegant Header -->
    <div class="row mb-4">
        <div class="col-12">
            <!-- Enhanced Breadcrumb -->
            <nav aria-label="breadcrumb" class="wow fadeIn" data-wow-delay="0.1s">
                <ol class="breadcrumb elegant-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="breadcrumb-link">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalog.books.show', $book->slug) }}" class="breadcrumb-link">
                            <i class="fas fa-book me-2"></i>{{ Str::limit($book->titleBook, 25) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-book-reader me-2"></i>Membaca
                    </li>
                </ol>
            </nav>

            <!-- Minimalist Book Info -->
            <div class="book-header-minimalist wow fadeIn" data-wow-delay="0.15s">
                <div class="book-cover-elegant">
                    @if($book->coverImageUrl())
                        <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}" class="cover-img-elegant">
                    @else
                        <div class="cover-placeholder-elegant">
                            <i class="fas fa-book-open"></i>
                        </div>
                    @endif
                </div>
                <div class="book-info-elegant">
                    <h1 class="book-title-elegant">{{ $book->titleBook }}</h1>
                    <p class="book-author-elegant">
                        <i class="fas fa-pen-nib me-2"></i>{{ $book->authorName }}
                    </p>
                    <div class="book-meta-elegant">
                        <div class="meta-item">
                            <i class="fas fa-building me-1"></i>
                            <span>{{ Str::limit($book->publisherName, 25) }}</span>
                        </div>
                        <div class="meta-divider"></div>
                        <div class="meta-item">
                            <i class="fas fa-calendar me-1"></i>
                            <span>{{ $book->year }}</span>
                        </div>
                        <div class="meta-divider"></div>
                        <div class="meta-item">
                            <i class="fas fa-file-alt me-1"></i>
                            <span>{{ $book->pages }} halaman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium FlipBook Container -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="flipbook-container-premium wow fadeIn" data-wow-delay="0.2s">
                <!-- Turn.js Container -->
                <div id="flipbook-container" class="flipbook-wrapper-premium">
                    <div id="flipbook" class="flipbook-viewer-premium"></div>

                    <!-- Premium Navigation Controls -->
                    <div class="flipbook-controls-premium">
                        <button class="control-btn-premium prev-btn" onclick="prevPage()" title="Halaman Sebelumnya">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div class="page-info-premium">
                            <div class="page-progress-premium">
                                <div class="progress-bar-premium" id="page-progress-bar"></div>
                            </div>
                            <span class="page-numbers-premium">
                                <span id="current-page">0</span> / <span id="total-pages">0</span>
                            </span>
                        </div>

                        <button class="control-btn-premium next-btn" onclick="nextPage()" title="Halaman Berikutnya">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Premium Loading State -->
                <div id="pdf-loading" class="loading-state-premium">
                    <div class="flipbook-loader-premium">
                        <div class="book-spinner-premium">
                            <div class="book-premium">
                                <div class="page-premium"></div>
                                <div class="page-premium"></div>
                                <div class="page-premium"></div>
                            </div>
                        </div>
                        <div class="loading-content-premium">
                            <h4 class="loading-title">Mempersiapkan Buku Digital</h4>
                            <p class="loading-text" id="loading-text">Memuat konten buku...</p>
                            <div class="progress-container-premium">
                                <div class="progress-bar-premium" id="loading-progress"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Premium Error State -->
                <div id="pdf-error" class="error-state-premium" style="display: none;">
                    <div class="error-content-premium">
                        <div class="error-icon-premium">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h4 class="error-title">Buku Tidak Dapat Dimuat</h4>
                        <p class="error-message" id="error-message">Terjadi gangguan saat memuat buku digital</p>
                        <div class="error-actions-premium">
                            <button class="btn-retry-premium" onclick="location.reload()">
                                <i class="fas fa-redo me-2"></i>Muat Ulang
                            </button>
                            <a href="{{ route('catalog.books.show', $book->slug) }}" class="btn-back-premium">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Floating Reader Controls -->
    <div class="floating-controls-elegant">
        <div class="floating-controls-panel-elegant">
            <!-- Navigation -->
            <div class="control-section-elegant">
                <button class="floating-btn-elegant" onclick="prevPage()" title="Halaman Sebelumnya">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="page-display-elegant">
                    <span id="current-page-display">0</span>/<span id="total-pages-display">0</span>
                </div>
                <button class="floating-btn-elegant" onclick="nextPage()" title="Halaman Berikutnya">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Zoom -->
            <div class="control-section-elegant">
                <button class="floating-btn-elegant" onclick="zoomOut()" title="Perkecil">
                    <i class="fas fa-search-minus"></i>
                </button>
                <span class="zoom-display-elegant" id="zoom-level">100%</span>
                <button class="floating-btn-elegant" onclick="zoomIn()" title="Perbesar">
                    <i class="fas fa-search-plus"></i>
                </button>
            </div>

            <!-- View Mode -->
            <div class="control-section-elegant">
                <button class="floating-btn-elegant view-mode-btn" id="single-view-btn" onclick="setViewMode('single')" title="Satu Halaman">
                    <i class="fas fa-file"></i>
                </button>
                <button class="floating-btn-elegant view-mode-btn active" id="double-view-btn" onclick="setViewMode('double')" title="Dua Halaman">
                    <i class="fas fa-copy"></i>
                </button>
            </div>

            <!-- Quick Navigation -->
            <div class="control-section-elegant">
                <button class="floating-btn-elegant" onclick="goToPage(1)" title="Halaman Pertama">
                    <i class="fas fa-step-backward"></i>
                </button>
                <button class="floating-btn-elegant" onclick="goToMiddlePage()" title="Halaman Tengah">
                    <i class="fas fa-pause"></i>
                </button>
                <button class="floating-btn-elegant" onclick="goToLastPage()" title="Halaman Terakhir">
                    <i class="fas fa-step-forward"></i>
                </button>
            </div>

            <!-- Fullscreen -->
            <div class="control-section-elegant">
                <button class="floating-btn-elegant" onclick="toggleFullscreen()" title="Layar Penuh" id="fullscreen-btn">
                    <i class="fas fa-expand"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    @include('landing-page.catalog-book.components._pdf-reader._pdf-reader-styles')
@endsection

@section('scripts')
    @include('landing-page.catalog-book.components._pdf-reader._pdf-reader-scripts')
@endsection
