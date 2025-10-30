@extends('landing-page.template.body')

@section('content')
<div class="container-xxl py-5">
    <!-- Elegant Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-5">
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
                    <i class="fas fa-book-open me-2"></i>{{ Str::limit($book->titleBook, 25) }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-external-link-alt me-2"></i>Baca Buku
            </li>
        </ol>
    </nav>

    <!-- Book Info Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="book-reader-header">
                <div class="book-cover-reader">
                    @if($book->coverImageUrl())
                        <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}" class="cover-image-reader">
                    @else
                        <div class="cover-placeholder-reader">
                            <i class="fas fa-book-open"></i>
                        </div>
                    @endif
                </div>
                <div class="book-info-reader">
                    <h1 class="book-title-reader">{{ $book->titleBook }}</h1>
                    <p class="book-author-reader">
                        <i class="fas fa-pen-nib me-2"></i>{{ $book->authorName }}
                    </p>
                    <div class="book-meta-reader">
                        <div class="meta-item-reader">
                            <i class="fas fa-building me-1"></i>
                            <span>{{ $book->publisherName }}</span>
                        </div>
                        <div class="meta-divider-reader"></div>
                        <div class="meta-item-reader">
                            <i class="fas fa-calendar me-1"></i>
                            <span>{{ $book->year }}</span>
                        </div>
                        <div class="meta-divider-reader"></div>
                        <div class="meta-item-reader">
                            <i class="fas fa-file-alt me-1"></i>
                            <span>{{ $book->pages }} halaman</span>
                        </div>
                    </div>
                </div>
                <div class="reader-actions">
                    <a href="{{ route('catalog.books.show', $book->slug) }}" class="btn btn-outline-primary btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail
                    </a>
                    <button class="btn btn-primary btn-fullscreen" id="fullscreen-btn">
                        <i class="fas fa-expand me-2"></i>Layar Penuh
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reader Container -->
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="reader-container-premium">
                <!-- Reader Content -->
                <div class="reader-content">
                    <div class="reader-frame-container">
                        <iframe
                            src="{{ $book->getFormattedReaderLink() }}"
                            class="reader-frame"
                            id="reader-frame"
                            allowfullscreen
                            loading="lazy"
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reader Controls -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="reader-controls-panel">
                <div class="controls-section">
                    <button class="btn btn-outline-primary btn-control" onclick="reloadReader()" title="Muat Ulang">
                        <i class="fas fa-redo"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-control" onclick="openInNewTab()" title="Buka di Tab Baru">
                        <i class="fas fa-external-link-alt"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-control" id="fullscreen-control" title="Layar Penuh">
                        <i class="fas fa-expand"></i>
                    </button>
                </div>

                <div class="controls-info">
                    <span class="reader-status">Siap membaca</span>
                </div>
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
