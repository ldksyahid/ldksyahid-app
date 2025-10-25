<!-- resources\views\landing-page\catalog-book\index.blade.php -->
@extends('landing-page.template.body')

@section('content')
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/15FZ7gsz6x_2uH90iPqi0OVZY-OMISAVf" alt="Image" />
            </div>
        </div>
    </div>
</div>

<div class="container-xxl py-5">
    <!-- Search Section -->
    <div class="row mb-5 justify-content-center wow fadeInUp" data-wow-delay="0.2s">
        <div class="col-lg-8">
            <form action="{{ url('/perpustakaan') }}" method="GET" id="search-form">
                <div class="d-flex shadow rounded-pill overflow-hidden position-relative" style="background: white;">
                    <input type="text" name="search"
                        id="search-input"
                        class="form-control border-0 ps-4 py-2 rounded-0"
                        placeholder="Cari buku berdasarkan judul, penulis, penerbit, atau tahun..."
                        value="{{ request('search') }}"
                        style="flex: 1 1 auto; box-shadow: none; padding-right: 2.5rem;">

                    <span id="clear-search"
                        class="position-absolute top-50 translate-middle-y"
                        style="right: 120px; cursor: pointer; z-index: 10; display: {{ request('search') ? 'block' : 'none' }};">
                        <span style="font-size: 1.5rem; color: #999;">&times;</span>
                    </span>

                    <button type="submit"
                            class="btn search-btn d-flex align-items-center justify-content-center rounded-0 px-4"
                            style="background-color: #00bfa6; color: white; z-index: 1;">
                        <i class="fas fa-search me-2"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4 wow fadeInUp" data-wow-delay="0.3s">
        <div class="col-12">
            <div class="card p-3 shadow-sm border-0 rounded-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="category" class="form-label fw-semibold text-primary">Kategori</label>
                        <select class="form-select rounded-pill" id="category" name="category[]" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->bookCategoryID }}"
                                    {{ in_array($category->bookCategoryID, (array)request('category')) ? 'selected' : '' }}>
                                    {{ $category->bookCategoryName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="author" class="form-label fw-semibold text-primary">Penulis</label>
                        <select class="form-select rounded-pill" id="author" name="author[]" multiple>
                            @foreach($authors as $author)
                                <option value="{{ $author }}"
                                    {{ in_array($author, (array)request('author')) ? 'selected' : '' }}>
                                    {{ $author }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="publisher" class="form-label fw-semibold text-primary">Penerbit</label>
                        <select class="form-select rounded-pill" id="publisher" name="publisher[]" multiple>
                            @foreach($publishers as $publisher)
                                <option value="{{ $publisher }}"
                                    {{ in_array($publisher, (array)request('publisher')) ? 'selected' : '' }}>
                                    {{ $publisher }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="year" class="form-label fw-semibold text-primary">Tahun</label>
                        <select class="form-select rounded-pill" id="year" name="year[]" multiple>
                            @foreach($years as $year)
                                <option value="{{ $year }}"
                                    {{ in_array($year, (array)request('year')) ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="d-flex gap-2 w-100">
                            <button type="submit" form="search-form" class="btn btn-primary rounded-pill flex-fill">
                                <i class="fas fa-filter me-1"></i> Terapkan
                            </button>
                            <a href="{{ url('/perpustakaan') }}" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-refresh me-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="row mb-3 wow fadeInUp" data-wow-delay="0.4s">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-muted mb-0">
                    @if($books->total() > 0)
                        Menampilkan {{ $books->firstItem() }}–{{ $books->lastItem() }} dari {{ $books->total() }} buku
                    @else
                        Tidak ada buku yang ditemukan
                    @endif
                </p>
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-1"></i> Urutkan
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Terbaru</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">Terpopuler</a></li>
                        <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'title']) }}">Judul A-Z</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Grid - 2 Cards per Row -->
    <div class="row g-4">
        @forelse($books as $book)
            <div class="col-lg-6 col-md-12 mb-4">
                <div class="item-new-book h-100 wow fadeInUp" data-wow-delay="0.{{ $loop->index % 2 + 1 }}s">
                    <div class="row g-0 h-100">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="wrp-cover-book-new h-100">
                                <!-- INI TITLE BOOK MOBILENYA YA A -->
                                <div class="title-book-mb d-lg-none d-md-none d-sm-flex d-flex">
                                    <div class="title-of-new">
                                       <div class="d-flex justify-content-between align-items-start">
                                            <h2>{{ $book->titleBook }}</h2>
                                            <!-- Crown Icon -->
                                            @if($book->authorTypeID == 1 || $book->authorTypeID == 2)
                                                <div class="crown-icon {{ $book->authorTypeID == 1 ? 'crown-premium' : 'crown-gold' }}">
                                                    <i class="fas fa-crown"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="date-publish-book">
                                            <div class="icon-date-publish">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-publish-date">
                                                <p>{{ \Carbon\Carbon::parse($book->createdDate)->format('d M Y') }}</p>
                                            </div>
                                            <div class="favorite-section ms-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-date-publish">
                                                        <i class="fas fa-heart"></i>
                                                    </div>
                                                    <span class="favorite-count">{{ $book->favoriteCount ?? 0 }}</span>
                                                </div>
                                            </div>
                                            @if($book->getBookCategory)
                                                <div class="category-badge">
                                                    <span class="badge bg-primary rounded-pill">{{ $book->getBookCategory->bookCategoryName }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- INI TITLE BOOK MOBILENYA YA A -->
                                @if($book->coverImageUrl())
                                    <a href="{{ route('catalog.books.show', $book->slug) }}">
                                        <div class="centered-cover-frame h-100">
                                            <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}">
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ route('catalog.books.show', $book->slug) }}">
                                        <div class="centered-cover-frame h-100">
                                            <img src="https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd" alt="{{ $book->titleBook }}">
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="right-new-catalog h-100">
                                <div class="title-of-new d-none d-lg-block d-md-block">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h2 class="book-title-truncate">{{ $book->titleBook }}</h2>
                                        <!-- Crown Icon -->
                                        @if($book->authorTypeID == 1 || $book->authorTypeID == 2)
                                            <div class="crown-icon {{ $book->authorTypeID == 1 ? 'crown-premium' : 'crown-gold' }}">
                                                <i class="fas fa-crown"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="date-publish-book">
                                        <div class="icon-date-publish">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-publish-date">
                                            <p>{{ \Carbon\Carbon::parse($book->createdDate)->format('d M Y') }}</p>
                                        </div>
                                        <div class="favorite-section ms-3">
                                            <div class="d-flex align-items-center">
                                                <div class="icon-date-publish">
                                                    <i class="fas fa-heart"></i>
                                                </div>
                                                <span class="favorite-count">{{ $book->favoriteCount ?? 0 }}</span>
                                            </div>
                                        </div>
                                        @if($book->getBookCategory)
                                        <div class="category-badge">
                                            <span class="badge bg-primary rounded-pill">{{ $book->getBookCategory->bookCategoryName }}</span>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                <ul class="nav nav-tabs" id="tab-newbook-{{ $book->bookID }}" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="spesifikasi-tab-{{ $book->bookID }}" data-bs-toggle="tab" data-bs-target="#book-spesifikasi-tab-{{ $book->bookID }}" type="button" role="tab" aria-controls="spesifikasi-tab" aria-selected="true">Spesifikasi</a>
                                    </li>
                                    @if($book->synopsis)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="sinopsis-tab-{{ $book->bookID }}" data-bs-toggle="tab" data-bs-target="#book-sinopsis-tab-{{ $book->bookID }}" type="button" role="tab" aria-controls="sinopsis-tab" aria-selected="false" tabindex="-1">Sinopsis</a>
                                        </li>
                                    @endif
                                </ul>
                                <div class="tab-content tab-content-new" id="newbook-{{ $book->bookID }}">
                                    <div class="tab-pane fade show active" id="book-spesifikasi-tab-{{ $book->bookID }}" role="tabpanel" aria-labelledby="spesifikasi-tab" tabindex="0">
                                        <div class="desc-of-new">
                                            <ul>
                                                <li><p>Judul: {{ $book->titleBook }}</p></li>

                                                @if($book->authorName)
                                                    <li><p>Penulis: {{ $book->authorName }}</p></li>
                                                @endif

                                                @if($book->publisherName)
                                                    <li><p>Penerbit: {{ $book->publisherName }}</p></li>
                                                @endif

                                                @if($book->year)
                                                    <li><p>Tahun Terbit: {{ $book->year }}</p></li>
                                                @endif

                                                @if($book->edition)
                                                    <li><p>Edisi: {{ $book->edition }}</p></li>
                                                @endif

                                                @if($book->isbn)
                                                    <li><p>ISBN: {{ $book->isbn }}</p></li>
                                                @endif

                                                @if($book->getLanguage)
                                                    <li><p>Bahasa: {{ $book->getLanguage->languageName }}</p></li>
                                                @endif

                                                @if($book->pages)
                                                    <li><p>Jumlah Halaman: {{ $book->pages }}</p></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                    @if($book->synopsis)
                                        <div class="tab-pane fade" id="book-sinopsis-tab-{{ $book->bookID }}" role="tabpanel" aria-labelledby="sinopsis-tab" tabindex="0">
                                            <div class="desc-of-new">
                                                <p class="synopsis-text">{{ $book->synopsis }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="act-new-book mt-auto">
                                    <div class="row align-items-center g-2">
                                        <div class="col-8">
                                            <a href="{{ route('catalog.books.show', $book->slug) }}" class="btn btn-detail-catalog">
                                                <div class="text-button">
                                                    <p>Lihat Detail</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-4">
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary btn-share w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-share-alt"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item copy-link" href="#" data-link="{{ route('catalog.books.show', $book->slug) }}">
                                                            <i class="fas fa-copy me-2"></i> Copy Link
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item share-wa" href="#" data-link="{{ route('catalog.books.show', $book->slug) }}" data-title="{{ $book->titleBook }}">
                                                            <i class="fab fa-whatsapp me-2"></i> Bagikan via WhatsApp
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clearfix for every 2 items -->
            @if($loop->iteration % 2 == 0)
                <div class="w-100 d-none d-lg-block"></div>
            @endif
        @empty
            <div class="col-12 text-center py-5 wow fadeIn" data-wow-delay="0.3s">
                <div class="mb-4">
                    <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">Buku Belum Tersedia</h3>
                    <p class="text-muted">Maaf, saat ini tidak ada buku yang sesuai dengan kriteria pencarian Anda.</p>
                    <a href="{{ url('/perpustakaan') }}" class="btn btn-primary rounded-pill mt-2">
                        <i class="fas fa-refresh me-2"></i> Tampilkan Semua Buku
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($books->total() > 0)
        <div class="row mt-5 wow fadeInUp" data-wow-delay="0.4s">
            <div class="col-12 text-center">
                <p class="text-muted mb-3">
                    Menampilkan {{ $books->firstItem() }}–{{ $books->lastItem() }} dari {{ $books->total() }} buku
                </p>

                @php
                    $currentPage = $books->currentPage();
                    $lastPage = $books->lastPage();
                    $start = max($currentPage - 4, 1);
                    $end = min($start + 9, $lastPage);
                    if ($end - $start < 9) {
                        $start = max($end - 9, 1);
                    }
                @endphp

                <nav>
                    <ul class="pagination custom-pagination justify-content-center">
                        <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $books->url(1) }}" aria-label="First">&laquo;</a>
                        </li>

                        <li class="page-item {{ $books->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $books->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                        </li>

                        @if ($start > 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                <a class="page-link" href="{{ $books->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($end < $lastPage)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif

                        <li class="page-item {{ !$books->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $books->nextPageUrl() }}" rel="next">&rsaquo;</a>
                        </li>

                        <li class="page-item {{ $currentPage >= $lastPage ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $books->url($lastPage) }}" aria-label="Last">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    @endif
</div>
@endsection

@section('styles')
    @include('landing-page.catalog-book.components._index._index-styles')
@endsection

@section('scripts')
    @include('landing-page.catalog-book.components._index._index-scripts')
@endsection
