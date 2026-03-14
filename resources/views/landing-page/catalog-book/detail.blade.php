@extends('landing-page.template.body')

@php
    $categoryColors = [
        1=>'#10b981',  2=>'#1e3a8a',  3=>'#0284c7',  4=>'#92400e',  5=>'#6d28d9',
        6=>'#0369a1',  7=>'#dc2626',  8=>'#7e22ce',  9=>'#059669',  10=>'#1e40af',
        11=>'#b45309', 12=>'#0f766e', 13=>'#c2410c', 14=>'#4f46e5', 15=>'#0891b2',
        16=>'#9333ea', 17=>'#16a34a', 18=>'#d97706', 19=>'#2563eb', 20=>'#db2777',
        21=>'#7c3aed', 22=>'#0d9488', 23=>'#ea580c', 24=>'#6366f1', 25=>'#0369a1',
        26=>'#be123c', 27=>'#047857', 28=>'#92400e', 29=>'#7c3aed', 30=>'#0f766e',
        31=>'#b91c1c', 32=>'#1d4ed8', 33=>'#065f46', 34=>'#4338ca', 35=>'#0369a1',
        36=>'#9d174d', 37=>'#064e3b', 38=>'#1e1b4b', 39=>'#7f1d1d', 40=>'#134e4a',
        41=>'#1c1917', 42=>'#3b0764', 43=>'#450a0a', 44=>'#052e16', 45=>'#0c4a6e',
        46=>'#4a1942', 47=>'#172554', 48=>'#f59e0b', 49=>'#06b6d4', 50=>'#6b7280',
    ];
    $catId  = $book->getBookCategory->bookCategoryID ?? 0;
    $accent = $categoryColors[$catId] ?? '#00bfa6';
@endphp

@section('content')
<div class="container-xxl py-5 mt-5" style="--bd-accent: {{ $accent }}">

    {{-- Main Content --}}
    <div class="row g-4">

        {{-- ── Left Column ────────────────────────────────────────── --}}
        <div class="col-lg-4 col-md-5">

            {{-- Book Cover --}}
            <div class="book-cover-elegant wow fadeInUp" data-wow-delay="0.1s">
                <div class="cover-container">
                    @if($book->coverImageUrl())
                        <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}" class="cover-image">
                    @else
                        <img src="https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd" alt="{{ $book->titleBook }}" class="cover-image">
                    @endif
                    <div class="cover-overlay">
                        @if(($book->authorTypeID == 1 || $book->authorTypeID == 2) && $book->availabilityTypeID == 2)
                            <div class="{{ $book->authorTypeID == 1 ? 'crown-premium premium-badge' : 'crown-gold premium-badge-gold' }}">
                                <i class="fas fa-crown me-1"></i>
                                <span>Premium</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="quick-actions wow fadeInUp" data-wow-delay="0.2s">
                <div class="action-buttons">

                    @if($book->getReaderLink())
                        <a href="{{ route('catalog.books.reader', $book->slug) }}" class="btn btn-primary btn-read w-100" target="_blank">
                            <i class="fas fa-book-open me-2"></i>Baca Buku
                        </a>
                    @endif

                    @if($book->availabilityTypeID == 2 && $book->purchaseLink)
                        <a href="{{ $book->purchaseLink }}" target="_blank" class="btn btn-success btn-purchase w-100">
                            <i class="fas fa-shopping-cart me-2"></i>Beli Buku
                        </a>
                    @endif

                    @if($book->availabilityTypeID == 3 && $book->borrowLink)
                        <a href="{{ $book->borrowLink }}" target="_blank" class="btn btn-warning btn-borrow w-100">
                            <i class="fas fa-hand-holding-usd me-2"></i>Pinjam Buku
                        </a>
                    @endif

                    <div class="action-group">
                        {{-- Like Button --}}
                        <button class="btn btn-outline btn-like" id="likeButton" data-book-id="{{ $book->bookID }}">
                            <div class="button-content">
                                <i class="far fa-heart like-icon" id="likeIcon"></i>
                                <span class="button-text">
                                    <span id="likeText">Suka</span>
                                    <span class="like-count" id="likeCount">({{ $book->favoriteCount ?? 0 }})</span>
                                </span>
                            </div>
                        </button>

                        {{-- Share Button --}}
                        <div class="share-button-container">
                            <button class="btn btn-outline btn-share" onclick="toggleShareOptions()">
                                <div class="button-content">
                                    <i class="fas fa-share-alt"></i>
                                    <span class="button-text">Bagikan</span>
                                </div>
                            </button>
                            <div class="share-options-floating" id="shareOptions">
                                <div class="share-options-content">
                                    <button class="share-option-btn" onclick="copyBookLink()" title="Salin Link">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <button class="share-option-btn" onclick="shareOnWhatsApp()" title="Bagikan via WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tags --}}
                @if($book->tags)
                <div class="tags-section wow fadeInUp" data-wow-delay="0.3s">
                    <h5 class="tags-title"><i class="fas fa-tags me-2"></i>Tags</h5>
                    <div class="tags-container">
                        @php $tags = explode(',', $book->tags); @endphp
                        @foreach($tags as $tag)
                            <span class="tag-elegant">
                                <i class="fas fa-hashtag me-1"></i>{{ trim($tag) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Back to Library --}}
                <div class="bd-back-wrap wow fadeInUp" data-wow-delay="0.35s">
                    <a href="{{ route('catalog.books.index') }}" class="bd-back-bottom-btn">
                        <i class="fas fa-arrow-left"></i>Kembali ke Perpustakaan
                    </a>
                </div>
            </div>
        </div>

        {{-- ── Right Column ─────────────────────────────────────── --}}
        <div class="col-lg-8 col-md-7">

            {{-- Book Header --}}
            <div class="book-header-elegant wow fadeInUp" data-wow-delay="0.1s">
                <div class="bd-cat-badge">
                    <i class="fas fa-tag"></i>
                    {{ $book->getBookCategory->bookCategoryName ?? 'Umum' }}
                </div>
                <h1 class="book-title-elegant">{{ $book->titleBook }}</h1>
                <p class="book-subtitle">
                    {{ $book->authorName }}&nbsp;&nbsp;·&nbsp;&nbsp;{{ $book->getAuthorType->authorTypeName ?? 'Penulis' }}
                </p>
                <div class="bd-stats-bar">
                    <div class="bd-stat">
                        <i class="fas fa-file-alt"></i>
                        <strong>{{ $book->pages ?? 0 }}</strong>
                        <span>halaman</span>
                    </div>
                    <div class="bd-stat">
                        <i class="fas fa-calendar-alt"></i>
                        <strong>{{ $book->year }}</strong>
                    </div>
                    <div class="bd-stat">
                        <i class="fas fa-heart"></i>
                        <strong>{{ $book->favoriteCount ?? 0 }}</strong>
                        <span>suka</span>
                    </div>
                    <div class="bd-stat">
                        <i class="fas fa-bookmark"></i>
                        <strong>{{ $book->getAvailabilityType->availabilityTypeName ?? 'Tersedia' }}</strong>
                    </div>
                </div>
            </div>

            {{-- Book Detail Tabs --}}
            <div class="book-tabs-elegant wow fadeInUp" data-wow-delay="0.2s">
                <div class="tabs-navigation">
                    <div class="nav-tabs-elegant">
                        <button class="nav-tab active" data-tab="details">
                            <i class="fas fa-info-circle me-2"></i>Detail
                        </button>
                        <button class="nav-tab" data-tab="description">
                            <i class="fas fa-file-alt me-2"></i>Deskripsi
                        </button>
                        @if($book->synopsis)
                        <button class="nav-tab" data-tab="synopsis">
                            <i class="fas fa-book me-2"></i>Sinopsis
                        </button>
                        @endif
                        <button class="nav-tab" data-tab="comments">
                            <i class="fas fa-comments me-2"></i>Diskusi
                        </button>
                    </div>
                </div>

                <div class="tabs-content">

                    {{-- Details Tab --}}
                    <div class="tab-pane active" id="details-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-info-circle"></i>Informasi Buku
                            </h3>
                            <div class="details-grid">
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-user-edit"></i><span>Penulis</span></div>
                                    <div class="detail-value">{{ $book->authorName }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-users"></i><span>Kategori Penulis</span></div>
                                    <div class="detail-value">{{ $book->getAuthorType->authorTypeName ?? 'Penulis' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-tag"></i><span>Kategori Buku</span></div>
                                    <div class="detail-value">{{ $book->getBookCategory->bookCategoryName ?? 'Umum' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-building"></i><span>Penerbit</span></div>
                                    <div class="detail-value">{{ $book->publisherName }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-calendar-alt"></i><span>Tahun Terbit</span></div>
                                    <div class="detail-value">{{ $book->year }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-language"></i><span>Bahasa</span></div>
                                    <div class="detail-value">{{ $book->getLanguage->languageName ?? 'Indonesia' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-barcode"></i><span>ISBN</span></div>
                                    <div class="detail-value">{{ $book->isbn ?? '-' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-layer-group"></i><span>Edisi</span></div>
                                    <div class="detail-value">{{ $book->edition ?? 'Edisi Standar' }}</div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-bookmark"></i><span>Ketersediaan</span></div>
                                    <div class="detail-value availability available">
                                        {{ $book->getAvailabilityType->availabilityTypeName ?? 'Tersedia' }}
                                    </div>
                                </div>
                                <div class="detail-item">
                                    <div class="detail-label"><i class="fas fa-file-alt"></i><span>Jumlah Halaman</span></div>
                                    <div class="detail-value">{{ $book->pages ?? 0 }} halaman</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description Tab --}}
                    <div class="tab-pane" id="description-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-file-alt"></i>Deskripsi Buku
                            </h3>
                            <div class="content-text">
                                {!! nl2br(e($book->description)) !!}
                            </div>
                        </div>
                    </div>

                    {{-- Synopsis Tab --}}
                    @if($book->synopsis)
                    <div class="tab-pane" id="synopsis-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-book"></i>Sinopsis
                            </h3>
                            <div class="content-text">
                                {!! nl2br(e($book->synopsis)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Comments Tab --}}
                    <div class="tab-pane" id="comments-tab">
                        <div class="content-card">
                            <h3 class="content-title">
                                <i class="fas fa-comments"></i>Diskusi Buku
                            </h3>
                            <p class="comments-description">
                                Bagikan pendapat, review, atau diskusikan buku ini dengan pembaca lainnya.
                            </p>
                            <div class="disqus-container">
                                <div id="disqus_thread"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Related Books --}}
            @if($relatedBooks->count() > 0)
            <div class="related-books-elegant wow fadeInUp" data-wow-delay="0.3s">
                <div class="section-header">
                    <h3 class="section-title">
                        <i class="fas fa-bookmark"></i>Buku Terkait
                    </h3>
                    <a href="{{ route('catalog.books.index') }}" class="view-all-link">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="related-books-grid">
                    @foreach($relatedBooks as $relatedBook)
                    <div class="related-book-card">
                        @if(($relatedBook->authorTypeID == 1 || $relatedBook->authorTypeID == 2) && $relatedBook->availabilityTypeID == 2)
                            <div class="related-book-crown {{ $relatedBook->authorTypeID == 1 ? 'crown-premium' : 'crown-gold' }}">
                                <i class="fas fa-crown"></i>
                            </div>
                        @endif
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
                                <span class="meta-item"><i class="fas fa-calendar me-1"></i>{{ $relatedBook->year }}</span>
                                <span class="meta-item"><i class="fas fa-heart me-1"></i>{{ $relatedBook->favoriteCount ?? 0 }}</span>
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
@endsection

@section('styles')
    @include('landing-page.catalog-book.components._detail._detail-styles')
@endsection

@section('scripts')
    @include('landing-page.catalog-book.components._detail._detail-scripts')
@endsection
