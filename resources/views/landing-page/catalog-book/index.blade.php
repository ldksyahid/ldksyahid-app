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

    <!-- Books Grid -->
    <div class="row g-4 justify-content-start">
        @forelse($books as $book)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 border-0 shadow rounded-4 overflow-hidden book-card wow fadeInUp" data-wow-delay="0.{{ $loop->index % 3 + 1 }}s">
                    <div class="position-relative">
                        @if($book->coverImageUrl())
                            <a href="{{ route('catalog.books.show', $book->slug) }}">
                                <div class="ratio ratio-16x9">
                                    <img src="{{ $book->coverImageUrl() }}"
                                         alt="{{ $book->titleBook }}"
                                         class="w-100 h-100 object-fit-cover">
                                </div>
                            </a>
                        @else
                            <div class="ratio ratio-16x9 bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-book fa-4x text-muted"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary rounded-pill">{{ $book->year }}</span>
                        </div>
                        @if($book->favoriteCount > 0)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-warning text-dark rounded-pill">
                                    <i class="fas fa-star me-1"></i> {{ $book->favoriteCount }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="mb-2">
                            <span class="badge bg-light text-primary rounded-pill small">{{ $book->getBookCategory->bookCategoryName ?? 'Umum' }}</span>
                        </div>

                        <h5 class="fw-bold mb-2 line-clamp-2" style="min-height: 3rem;">
                            <a href="{{ route('catalog.books.show', $book->slug) }}" class="text-dark text-decoration-none">
                                {{ $book->titleBook }}
                            </a>
                        </h5>

                        <div class="mb-2">
                            <small class="text-muted">
                                <i class="fas fa-user-edit me-1"></i> {{ $book->authorName }}
                            </small>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">
                                <i class="fas fa-building me-1"></i> {{ $book->publisherName }}
                            </small>
                        </div>

                        <p class="text-muted small line-clamp-3 mb-3 flex-grow-1">
                            {{ Str::limit($book->description, 120) }}
                        </p>

                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="d-flex gap-2">
                                @if($book->pdfFileUrl())
                                    <span class="badge bg-success rounded-pill">
                                        <i class="fas fa-file-pdf me-1"></i> PDF
                                    </span>
                                @endif
                                <span class="badge bg-info text-dark rounded-pill">
                                    <i class="fas fa-language me-1"></i> {{ $book->getLanguage->languageName ?? 'Indonesia' }}
                                </span>
                            </div>
                            <a href="{{ route('catalog.books.show', $book->slug) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                Detail <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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
