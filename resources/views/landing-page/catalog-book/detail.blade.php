@extends('landing-page.template.body')

@section('content')
<div class="container-xxl py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-5 wow fadeIn" data-wow-delay="0.1s">
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
            <li class="breadcrumb-item active" aria-current="page">
                <i class="fas fa-chevron-right me-2"></i>{{ Str::limit($book->titleBook, 30) }}
            </li>
        </ol>
    </nav>

    <!-- Main Content -->
    <div class="row g-5">
        <!-- Left Column - Book Cover & Author -->
        <div class="col-lg-4 col-md-5">
            <!-- Book Cover -->
            <div class="book-cover-elegant wow fadeInUp" data-wow-delay="0.2s">
                <div class="cover-container">
                    @if($book->coverImageUrl())
                        <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}" class="cover-image">
                    @else
                        <img src="https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd" alt="{{ $book->titleBook }}" class="cover-image">
                    @endif
                    <div class="cover-overlay">
                        <div class="premium-badge">
                            <i class="fas fa-crown me-1"></i>
                            <span>Premium</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Author Profile -->
            <div class="author-profile wow fadeInUp" data-wow-delay="0.3s">
                <div class="profile-header">
                    <div class="author-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="author-info">
                        <h4 class="author-name">{{ $book->authorName }}</h4>
                        <p class="author-type">{{ $book->getAuthorType->authorTypeName ?? 'Penulis' }}</p>
                    </div>
                </div>
                <div class="profile-stats">
                    <div class="stat">
                        <div class="stat-number">24</div>
                        <div class="stat-label">Buku</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">1.2K</div>
                        <div class="stat-label">Pembaca</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">4.8</div>
                        <div class="stat-label">Rating</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions wow fadeInUp" data-wow-delay="0.4s">
                <div class="action-buttons">
                    @if($book->pdfFileUrl())
                        <button class="btn btn-primary btn-read w-100" onclick="openPdfReader()">
                            <i class="fas fa-book-open me-2"></i>Baca Buku
                        </button>
                    @endif

                    <div class="action-group">
                        <button class="btn btn-outline btn-favorite" onclick="addToFavorites()">
                            <i class="far fa-heart"></i>
                            <span>Favorit</span>
                        </button>
                        <button class="btn btn-outline btn-share" onclick="copyBookLink()">
                            <i class="fas fa-share-alt"></i>
                            <span>Share</span>
                        </button>
                        <button class="btn btn-outline btn-download" onclick="downloadBook()">
                            <i class="fas fa-download"></i>
                            <span>Download</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Book Information -->
        <div class="col-lg-8 col-md-7">
            <!-- Book Header -->
            <div class="book-header-elegant wow fadeInUp" data-wow-delay="0.2s">
                <div class="header-content">
                    <div class="book-meta-badges">
                        <span class="badge category-badge">
                            <i class="fas fa-tag me-1"></i>{{ $book->getBookCategory->bookCategoryName ?? 'Umum' }}
                        </span>
                        <span class="badge rating-badge">
                            <i class="fas fa-star me-1"></i>{{ number_format($book->rating ?? 0, 1) }}
                        </span>
                        <span class="badge year-badge">
                            <i class="fas fa-calendar me-1"></i>{{ $book->year }}
                        </span>
                    </div>
                    <h1 class="book-title-elegant">{{ $book->titleBook }}</h1>
                    <p class="book-subtitle">Sebuah Karya Menakjubkan oleh {{ $book->authorName }}</p>

                    <div class="publication-info">
                        <div class="info-item">
                            <i class="fas fa-building"></i>
                            <span>{{ $book->publisherName }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-language"></i>
                            <span>{{ $book->getLanguage->languageName ?? 'Indonesia' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <span>Terbit: {{ \Carbon\Carbon::parse($book->createdDate)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Stats -->
            <div class="book-stats-elegant wow fadeInUp" data-wow-delay="0.3s">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon readers">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $book->readCount ?? 0 }}</div>
                            <div class="stat-label">Pembaca</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon favorites">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $book->favoriteCount ?? 0 }}</div>
                            <div class="stat-label">Favorit</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon downloads">
                            <i class="fas fa-download"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $book->downloadCount ?? 0 }}</div>
                            <div class="stat-label">Download</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon pages">
                            <i class="fas fa-file"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $book->pages ?? 0 }}</div>
                            <div class="stat-label">Halaman</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Details Tabs -->
            <div class="book-tabs-elegant wow fadeInUp" data-wow-delay="0.4s">
                <div class="tabs-navigation">
                    <div class="nav-tabs-elegant">
                        <button class="nav-tab active" data-tab="description">
                            <i class="fas fa-file-alt me-2"></i>Deskripsi
                        </button>
                        <button class="nav-tab" data-tab="details">
                            <i class="fas fa-info-circle me-2"></i>Detail Buku
                        </button>
                        @if($book->synopsis)
                        <button class="nav-tab" data-tab="synopsis">
                            <i class="fas fa-book me-2"></i>Sinopsis
                        </button>
                        @endif
                        @if($book->tags)
                        <button class="nav-tab" data-tab="tags">
                            <i class="fas fa-tags me-2"></i>Tags
                        </button>
                        @endif
                    </div>
                </div>

                <div class="tabs-content">
                    <!-- Description Tab -->
                    <div class="tab-pane active" id="description-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-file-alt me-2"></i>Tentang Buku Ini
                            </h3>
                            <div class="content-text">
                                {!! nl2br(e($book->description)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Details Tab -->
                    <div class="tab-pane" id="details-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi Detail
                            </h3>
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-barcode"></i>
                                        <span>ISBN</span>
                                    </div>
                                    <div class="detail-value">{{ $book->isbn ?? '-' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-layer-group"></i>
                                        <span>Edisi</span>
                                    </div>
                                    <div class="detail-value">{{ $book->edition ?? 'Edisi Standar' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-bookmark"></i>
                                        <span>Ketersediaan</span>
                                    </div>
                                    <div class="detail-value availability available">
                                        {{ $book->getAvailabilityType->availabilityTypeName ?? 'Tersedia' }}
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-file-alt"></i>
                                        <span>Jumlah Halaman</span>
                                    </div>
                                    <div class="detail-value">{{ $book->pages ?? 0 }} halaman</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>Tahun Terbit</span>
                                    </div>
                                    <div class="detail-value">{{ $book->year }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label">
                                        <i class="fas fa-language"></i>
                                        <span>Bahasa</span>
                                    </div>
                                    <div class="detail-value">{{ $book->getLanguage->languageName ?? 'Indonesia' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Synopsis Tab -->
                    @if($book->synopsis)
                    <div class="tab-pane" id="synopsis-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-book me-2"></i>Sinopsis
                            </h3>
                            <div class="content-text">
                                {!! nl2br(e($book->synopsis)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Tags Tab -->
                    @if($book->tags)
                    <div class="tab-pane" id="tags-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-tags me-2"></i>Kategori & Tags
                            </h3>
                            <div class="tags-container">
                                @php
                                    $tags = explode(',', $book->tags);
                                @endphp
                                @foreach($tags as $tag)
                                    <span class="tag-elegant">
                                        <i class="fas fa-hashtag me-1"></i>{{ trim($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Related Books -->
            @if($relatedBooks->count() > 0)
            <div class="related-books-elegant wow fadeInUp" data-wow-delay="0.5s">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-bookmark me-2"></i>Buku Terkait Lainnya
                    </h3>
                    <a href="{{ route('catalog.books.index') }}" class="view-all-link">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="related-books-grid">
                    @foreach($relatedBooks as $relatedBook)
                    <div class="related-book-card">
                        <div class="book-cover-small">
                            @if($relatedBook->coverImageUrl())
                                <img src="{{ $relatedBook->coverImageUrl() }}" alt="{{ $relatedBook->titleBook }}">
                            @else
                                <img src="https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd" alt="{{ $relatedBook->titleBook }}">
                            @endif
                        </div>
                        <div class="book-info-small">
                            <h6 class="book-title-small">{{ Str::limit($relatedBook->titleBook, 35) }}</h6>
                            <p class="book-author-small">{{ $relatedBook->authorName }}</p>
                            <div class="book-meta-small">
                                <span class="meta-item">
                                    <i class="fas fa-calendar me-1"></i>{{ $relatedBook->year }}
                                </span>
                                <span class="meta-item">
                                    <i class="fas fa-heart me-1"></i>{{ $relatedBook->favoriteCount ?? 0 }}
                                </span>
                            </div>
                            <a href="{{ route('catalog.books.show', $relatedBook->slug) }}" class="view-detail-btn">
                                Lihat Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Success Message Template -->
<div id="success-message" class="success-message" style="display: none;">
    <i class="fas fa-check-circle me-2"></i>
    <span class="message-text"></span>
</div>
@endsection

@section('styles')
    @include('landing-page.catalog-book.components._detail._detail-styles')
@endsection

@section('scripts')
    @include('landing-page.catalog-book.components._detail._detail-scripts')
@endsection
