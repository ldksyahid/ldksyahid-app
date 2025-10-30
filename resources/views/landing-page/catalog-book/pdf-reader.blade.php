@extends('landing-page.template.body')

@section('content')
<div class="container-fluid py-4">
    <!-- Simplified Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="wow fadeIn" data-wow-delay="0.1s">
                <ol class="breadcrumb elegant-breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}" class="breadcrumb-link">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalog.books.show', $book->slug) }}" class="breadcrumb-link">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Buku
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-book-open me-2"></i>Membaca
                    </li>
                </ol>
            </nav>

            <!-- Compact Book Info -->
            <div class="book-header-compact wow fadeIn" data-wow-delay="0.15s">
                <div class="book-cover-mini">
                    @if($book->coverImageUrl())
                        <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}" class="cover-img">
                    @else
                        <div class="cover-placeholder">
                            <i class="fas fa-book"></i>
                        </div>
                    @endif
                </div>
                <div class="book-info-mini">
                    <h1 class="book-title">{{ Str::limit($book->titleBook, 50) }}</h1>
                    <p class="book-author">
                        <i class="fas fa-user-edit me-1"></i>{{ $book->authorName }}
                    </p>
                    <div class="book-meta-compact">
                        <span class="meta-badge">
                            <i class="fas fa-building me-1"></i>{{ Str::limit($book->publisherName, 20) }}
                        </span>
                        <span class="meta-badge">
                            <i class="fas fa-calendar me-1"></i>{{ $book->year }}
                        </span>
                        <span class="meta-badge">
                            <i class="fas fa-file-alt me-1"></i>{{ $book->pages }}hlm
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced FlipBook Container -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="flipbook-container-enhanced wow fadeIn" data-wow-delay="0.2s">
                <!-- Turn.js Container -->
                <div id="flipbook-container" class="flipbook-wrapper-enhanced">
                    <div id="flipbook" class="flipbook-viewer-enhanced"></div>

                    <!-- Enhanced Navigation Controls -->
                    <div class="flipbook-controls-enhanced">
                        <button class="control-btn-enhanced prev-btn" onclick="prevPage()" title="Halaman Sebelumnya">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div class="page-info-enhanced">
                            <div class="page-progress">
                                <div class="progress-bar" id="page-progress-bar"></div>
                            </div>
                            <span class="page-numbers">
                                <span id="current-page">0</span> / <span id="total-pages">0</span>
                            </span>
                        </div>

                        <button class="control-btn-enhanced next-btn" onclick="nextPage()" title="Halaman Berikutnya">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Enhanced Loading State -->
                <div id="pdf-loading" class="loading-state-enhanced">
                    <div class="flipbook-loader-enhanced">
                        <div class="book-spinner">
                            <div class="book">
                                <div class="page"></div>
                                <div class="page"></div>
                                <div class="page"></div>
                            </div>
                        </div>
                        <div class="loading-content">
                            <h4>Mempersiapkan Buku Digital</h4>
                            <p id="loading-text">Memuat konten buku...</p>
                            <div class="progress-container-enhanced">
                                <div class="progress-bar-enhanced" id="loading-progress"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Error State -->
                <div id="pdf-error" class="error-state-enhanced" style="display: none;">
                    <div class="error-content">
                        <div class="error-icon">
                            <i class="fas fa-book-skull"></i>
                        </div>
                        <h4>Buku Tidak Dapat Dimuat</h4>
                        <p id="error-message">Terjadi gangguan saat memuat buku digital</p>
                        <div class="error-actions">
                            <button class="btn-retry-enhanced" onclick="location.reload()">
                                <i class="fas fa-redo me-2"></i>Muat Ulang
                            </button>
                            <a href="{{ route('catalog.books.show', $book->slug) }}" class="btn-back-enhanced">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Reader Controls -->
    <div class="floating-controls">
        <div class="floating-controls-panel">
            <!-- Navigation -->
            <div class="control-section">
                <button class="floating-btn" onclick="prevPage()" title="Halaman Sebelumnya">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="page-display">
                    <span id="current-page-display">0</span>/<span id="total-pages-display">0</span>
                </div>
                <button class="floating-btn" onclick="nextPage()" title="Halaman Berikutnya">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Zoom -->
            <div class="control-section">
                <button class="floating-btn" onclick="zoomOut()" title="Perkecil">
                    <i class="fas fa-search-minus"></i>
                </button>
                <span class="zoom-display" id="zoom-level">100%</span>
                <button class="floating-btn" onclick="zoomIn()" title="Perbesar">
                    <i class="fas fa-search-plus"></i>
                </button>
            </div>

            <!-- View Mode -->
            <div class="control-section">
                <button class="floating-btn view-mode-btn" id="single-view-btn" onclick="setViewMode('single')" title="Satu Halaman">
                    <i class="fas fa-file"></i>
                </button>
                <button class="floating-btn view-mode-btn active" id="double-view-btn" onclick="setViewMode('double')" title="Dua Halaman">
                    <i class="fas fa-copy"></i>
                </button>
            </div>

            <!-- Quick Navigation -->
            <div class="control-section">
                <button class="floating-btn" onclick="goToPage(1)" title="Halaman Pertama">
                    <i class="fas fa-fast-backward"></i>
                </button>
                <button class="floating-btn" onclick="goToMiddlePage()" title="Halaman Tengah">
                    <i class="fas fa-pause"></i>
                </button>
                <button class="floating-btn" onclick="goToLastPage()" title="Halaman Terakhir">
                    <i class="fas fa-fast-forward"></i>
                </button>
            </div>

            <!-- Fullscreen -->
            <div class="control-section">
                <button class="floating-btn" onclick="toggleFullscreen()" title="Layar Penuh" id="fullscreen-btn">
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
