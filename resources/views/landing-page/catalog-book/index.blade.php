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
    <!-- Search Section with Filter Button -->
    <div class="row mb-5 justify-content-center wow fadeInUp" data-wow-delay="0.2s">
        <div class="col-lg-10">
            <div class="d-flex align-items-center gap-3">
                <!-- Search Form -->
                <form action="{{ url('/perpustakaan') }}" method="GET" id="search-form" class="flex-grow-1">
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

                <!-- Filter Button -->
                <button type="button" class="btn btn-outline-primary rounded-pill d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#filterModal"
                        style="min-width: 120px; border-color: #00bfa6; color: #00bfa6;">
                    <i class="fas fa-sliders-h"></i>
                    <span>Filter</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <!-- Modal Header -->
                <div class="modal-header" style="border-bottom: 1px solid #e9ecef; border-radius: 20px 20px 0 0; padding: 1.5rem;">
                    <h5 class="modal-title fw-bold text-primary" id="filterModalLabel">
                        <i class="fas fa-sliders-h me-2"></i>Filter Buku
                    </h5>
                </div>

                <!-- Modal Body -->
                <div class="modal-body p-4">
                    <form action="{{ url('/perpustakaan') }}" method="GET" id="filter-form">
                        <div class="row g-4">
                            <!-- Kategori -->
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-semibold text-primary mb-3">
                                    <i class="fas fa-tag me-2"></i>Kategori
                                </label>
                                <select class="form-select rounded-pill" id="category" name="category[]" multiple style="height: auto;">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->bookCategoryID }}"
                                            {{ in_array($category->bookCategoryID, (array)request('category')) ? 'selected' : '' }}>
                                            {{ $category->bookCategoryName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Penulis -->
                            <div class="col-md-6">
                                <label for="author" class="form-label fw-semibold text-primary mb-3">
                                    <i class="fas fa-user-edit me-2"></i>Penulis
                                </label>
                                <select class="form-select rounded-pill" id="author" name="author[]" multiple style="height: auto;">
                                    @foreach($authors as $author)
                                        <option value="{{ $author }}"
                                            {{ in_array($author, (array)request('author')) ? 'selected' : '' }}>
                                            {{ $author }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Penerbit -->
                            <div class="col-md-6">
                                <label for="publisher" class="form-label fw-semibold text-primary mb-3">
                                    <i class="fas fa-building me-2"></i>Penerbit
                                </label>
                                <select class="form-select rounded-pill" id="publisher" name="publisher[]" multiple style="height: auto;">
                                    @foreach($publishers as $publisher)
                                        <option value="{{ $publisher }}"
                                            {{ in_array($publisher, (array)request('publisher')) ? 'selected' : '' }}>
                                            {{ $publisher }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tahun -->
                            <div class="col-md-6">
                                <label for="year" class="form-label fw-semibold text-primary mb-3">
                                    <i class="fas fa-calendar-alt me-2"></i>Tahun
                                </label>
                                <select class="form-select rounded-pill" id="year" name="year[]" multiple style="height: auto;">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}"
                                            {{ in_array($year, (array)request('year')) ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Active Filters Badges -->
                        @if(request('category') || request('author') || request('publisher') || request('year'))
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="fw-semibold text-primary mb-3">Filter Aktif:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @if(request('category'))
                                        @php
                                            $selectedCategories = $categories->whereIn('bookCategoryID', (array)request('category'));
                                        @endphp
                                        @foreach($selectedCategories as $category)
                                            <span class="badge bg-primary rounded-pill d-flex align-items-center gap-1">
                                                <i class="fas fa-tag"></i>
                                                {{ $category->bookCategoryName }}
                                            </span>
                                        @endforeach
                                    @endif

                                    @if(request('author'))
                                        @foreach((array)request('author') as $author)
                                            <span class="badge bg-success rounded-pill d-flex align-items-center gap-1">
                                                <i class="fas fa-user-edit"></i>
                                                {{ $author }}
                                            </span>
                                        @endforeach
                                    @endif

                                    @if(request('publisher'))
                                        @foreach((array)request('publisher') as $publisher)
                                            <span class="badge bg-info rounded-pill d-flex align-items-center gap-1">
                                                <i class="fas fa-building"></i>
                                                {{ $publisher }}
                                            </span>
                                        @endforeach
                                    @endif

                                    @if(request('year'))
                                        @foreach((array)request('year') as $year)
                                            <span class="badge bg-warning rounded-pill d-flex align-items-center gap-1">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $year }}
                                            </span>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer" style="border-top: 1px solid #e9ecef; border-radius: 0 0 20px 20px; padding: 1.5rem;">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <a href="{{ url('/perpustakaan') }}" class="btn btn-outline-warning rounded-pill px-4">
                        <i class="fas fa-refresh me-2"></i>Reset
                    </a>
                    <button type="submit" form="filter-form" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-check me-2"></i>Terapkan Filter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="row mb-3 wow fadeInUp" data-wow-delay="0.4s">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-0">
                        @if($books->total() > 0)
                            @if(request('search'))
                                Hasil pencarian untuk "{{ request('search') }}"
                            @else
                                Semua buku perpustakaan
                            @endif
                        @else
                            @if(request('search'))
                                Tidak ditemukan buku dengan kata kunci "{{ request('search') }}"
                            @else
                                Tidak ada buku yang tersedia
                            @endif
                        @endif
                    </p>

                    <!-- Active Filters Summary -->
                    @if(request('category') || request('author') || request('publisher') || request('year'))
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-sliders-h me-1"></i>
                            Filter aktif:
                            @if(request('category'))
                                {{ count((array)request('category')) }} kategori
                            @endif
                            @if(request('author'))
                                {{ request('category') ? ', ' : '' }}{{ count((array)request('author')) }} penulis
                            @endif
                            @if(request('publisher'))
                                {{ request('category') || request('author') ? ', ' : '' }}{{ count((array)request('publisher')) }} penerbit
                            @endif
                            @if(request('year'))
                                {{ request('category') || request('author') || request('publisher') ? ', ' : '' }}{{ count((array)request('year')) }} tahun
                            @endif
                        </small>
                    </div>
                    @endif
                </div>

                <!-- Sort Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-primary btn-sm dropdown-toggle rounded-pill" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-1"></i> Urutkan
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ request('sort') == 'newest' || !request('sort') ? 'active' : '' }}"
                            href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">
                                <i class="fas fa-clock me-2"></i>Terbaru
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('sort') == 'popular' ? 'active' : '' }}"
                            href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">
                                <i class="fas fa-heart me-2"></i>Terpopuler
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('sort') == 'title' ? 'active' : '' }}"
                            href="{{ request()->fullUrlWithQuery(['sort' => 'title']) }}">
                                <i class="fas fa-sort-alpha-down me-2"></i>Judul A-Z
                            </a>
                        </li>
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
                                <div class="title-of-new">
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
                                        <a class="nav-link active" id="spesifikasi-tab-{{ $book->bookID }}" data-bs-toggle="tab" data-bs-target="#book-spesifikasi-tab-{{ $book->bookID }}" type="button" role="tab" aria-controls="spesifikasi-tab" aria-selected="true">
                                            <h6 class="mb-0 small-tab-text">Spesifikasi</h6>
                                        </a>
                                    </li>
                                    @if($book->synopsis)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="sinopsis-tab-{{ $book->bookID }}" data-bs-toggle="tab" data-bs-target="#book-sinopsis-tab-{{ $book->bookID }}" type="button" role="tab" aria-controls="sinopsis-tab" aria-selected="false" tabindex="-1">
                                                <h6 class="mb-0 small-tab-text">Sinopsis</h6>
                                            </a>
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
