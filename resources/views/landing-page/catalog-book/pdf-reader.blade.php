@extends('landing-page.template.body')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
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
                        <a href="{{ route('catalog.books.index') }}" class="breadcrumb-link">
                            <i class="fas fa-book me-2"></i>Perpustakaan
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalog.books.show', $book->slug) }}" class="breadcrumb-link">
                            <i class="fas fa-chevron-right me-2"></i>{{ Str::limit($book->titleBook, 20) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-book-open me-2"></i>Membaca
                    </li>
                </ol>
            </nav>

            <div class="reader-header text-center">
                <h1 class="book-title-reader">{{ $book->titleBook }}</h1>
                <p class="book-author-reader">Oleh {{ $book->authorName }}</p>
            </div>
        </div>
    </div>

    <!-- PDF Reader Container -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="flipbook-container wow fadeIn" data-wow-delay="0.2s">
                <div id="pdf-flipbook" class="flipbook-viewer"></div>

                <!-- Loading State -->
                <div id="pdf-loading" class="loading-state">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Memuat buku...</span>
                    </div>
                    <p class="mt-3">Sedang memuat buku, harap tunggu...</p>
                </div>

                <!-- Error State -->
                <div id="pdf-error" class="error-state" style="display: none;">
                    <div class="error-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h4>Gagal Memuat Buku</h4>
                    <p>Maaf, terjadi kesalahan saat memuat buku. Silakan coba lagi.</p>
                    <button class="btn btn-primary btn-retry mt-3" onclick="location.reload()">
                        <i class="fas fa-redo me-2"></i>Coba Lagi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reader Controls -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="reader-controls">
                <div class="controls-container">
                    <!-- Navigation -->
                    <div class="control-group">
                        <button class="btn-control" onclick="prevPage()" title="Halaman Sebelumnya">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span class="page-info">
                            Halaman <span id="current-page">1</span> dari <span id="total-pages">0</span>
                        </span>
                        <button class="btn-control" onclick="nextPage()" title="Halaman Berikutnya">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Zoom -->
                    <div class="control-group">
                        <button class="btn-control" onclick="zoomOut()" title="Perkecil">
                            <i class="fas fa-search-minus"></i>
                        </button>
                        <span class="zoom-info">
                            <span id="zoom-level">100%</span>
                        </span>
                        <button class="btn-control" onclick="zoomIn()" title="Perbesar">
                            <i class="fas fa-search-plus"></i>
                        </button>
                    </div>

                    <!-- View Mode -->
                    <div class="control-group">
                        <button class="btn-control" onclick="setViewMode('single')" title="Satu Halaman">
                            <i class="fas fa-file"></i>
                        </button>
                        <button class="btn-control" onclick="setViewMode('double')" title="Dua Halaman" id="double-view-btn">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>

                    <!-- Fullscreen -->
                    <div class="control-group">
                        <button class="btn-control" onclick="toggleFullscreen()" title="Layar Penuh" id="fullscreen-btn">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Book Info Footer -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="book-info-footer">
                <div class="info-container">
                    <div class="info-item">
                        <strong>Judul:</strong> {{ $book->titleBook }}
                    </div>
                    <div class="info-item">
                        <strong>Penulis:</strong> {{ $book->authorName }}
                    </div>
                    <div class="info-item">
                        <strong>Penerbit:</strong> {{ $book->publisherName }}
                    </div>
                    <div class="info-item">
                        <strong>Tahun:</strong> {{ $book->year }}
                    </div>
                </div>
                <div class="action-container">
                    <a href="{{ route('catalog.books.show', $book->slug) }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail Buku
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    @include('landing-page.catalog-book.components._detail._pdf-reader-styles')
@endsection

@section('scripts')
    @include('landing-page.catalog-book.components._detail._pdf-reader-scripts')
@endsection
