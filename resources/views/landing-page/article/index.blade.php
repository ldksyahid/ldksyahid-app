@extends('landing-page.template.body')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1hDEx-QFNqCTduumn6IvJ6iOf8qmTp-P_" alt="Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->

<div class="container-xxl py-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            <form action="{{ url('/articles') }}" method="GET">
                <div class="d-flex shadow rounded-pill overflow-hidden" style="background: white;">
                    <input type="text" name="search"
                        class="form-control border-0 ps-4 py-2 rounded-0"
                        placeholder="Cari artikel berdasarkan judul, tema, penulis, atau editor..."
                        value="{{ request('search') }}"
                        style="flex: 1 1 auto; box-shadow: none;">
                    <button type="submit"
                            class="btn search-btn d-flex align-items-center justify-content-center rounded-0 px-4"
                            style="background-color: #00bfa6; color: white;">
                        <i class="fas fa-search me-2"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 justify-content-start">
            @forelse($postarticle as $key => $article)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 border-0 shadow rounded-4 overflow-hidden article-card wow fadeInUp" data-wow-delay="0.2s">
                        <a href="/articles/{{ $article->id }}">
                            <div class="ratio ratio-16x9">
                                <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                                     alt="{{ $article->title }}"
                                     class="w-100 h-100 object-fit-cover">
                            </div>
                        </a>
                        <div class="card-body d-flex flex-column justify-content-between p-4" style="min-height: 350px;">
                            <p class="text-muted small text-end mb-1">
                                {{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('dddd, D MMMM Y') }}
                            </p>
                            <h6 class="text-uppercase text-primary mb-1">{{ $article->theme }}</h6>
                            <h5 class="fw-bold mb-2">
                                <a href="/articles/{{ $article->id }}" class="text-dark text-decoration-none">
                                    {{ $article->title }}
                                </a>
                            </h5>
                            <p class="text-muted small mb-0">Penulis: {{ $article->writer }}</p>
                            <p class="text-muted small">Editor: {{ $article->editor }}</p>
                            <div class="text-end mt-auto">
                                <a href="/articles/{{ $article->id }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                    Baca Selengkapnya <i class="fa fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-lg-12 text-center">
                    <h1>Artikel Belum Tersedia</h1>
                </div>
            @endforelse

            @if($postarticle->total() > 0)
                <div class="col-12 text-center mt-4">
                    <p class="text-muted">
                        Menampilkan {{ $postarticle->firstItem() }}–{{ $postarticle->lastItem() }} dari {{ $postarticle->total() }} artikel
                    </p>

                    {{-- Custom Pagination --}}
                    @php
                        $currentPage = $postarticle->currentPage();
                        $lastPage = $postarticle->lastPage();
                        $start = max($currentPage - 4, 1);
                        $end = min($start + 9, $lastPage);
                        if ($end - $start < 9) {
                            $start = max($end - 9, 1);
                        }
                    @endphp

                    <nav>
                        <ul class="pagination custom-pagination justify-content-center">
                            {{-- First Page --}}
                            @if ($currentPage > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $postarticle->url(1) }}" aria-label="First">&laquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="First">&laquo;</span>
                                </li>
                            @endif

                            {{-- Previous Page --}}
                            @if ($postarticle->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $postarticle->previousPageUrl() }}" rel="prev">&lsaquo;</a></li>
                            @endif

                            {{-- Numbered Pagination --}}
                            @if ($start > 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            @for ($i = $start; $i <= $end; $i++)
                                @if ($i == $currentPage)
                                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $postarticle->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endfor

                            @if ($end < $lastPage)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif

                            {{-- Next Page --}}
                            @if ($postarticle->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $postarticle->nextPageUrl() }}" rel="next">&rsaquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                            @endif

                            {{-- Last Page --}}
                            @if ($currentPage < $lastPage)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $postarticle->url($lastPage) }}" aria-label="Last">&raquo;</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link" aria-label="Last">&raquo;</span> {{-- tambahkan ini --}}
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- Article End -->
@endsection

@section('styles')
<style>
.object-fit-cover {
    object-fit: cover;
    object-position: top;
}

.article-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.article-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
}

.ratio.ratio-16x9 {
    height: 400px;
}

input.form-control:focus {
    box-shadow: none;
}

.search-btn {
    background-color: #00bfa6;
    color: white;
    transition: all 0.3s ease;
}

.search-btn:hover {
    background-color: #00d9bb !important;
    color: white;
    box-shadow: 0 4px 12px rgba(0, 217, 187, 0.4)
}

/* Pagination Styling */
.custom-pagination {
    display: flex;
    flex-direction: row; /* Fix: horizontal layout */
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    padding-left: 0;
    list-style: none;
    margin: 1rem 0;
}

.custom-pagination .page-link {
    color: #00a79d;
    background-color: #fff;
    border: 1px solid #00a79d;
    border-radius: 50px;
    transition: all 0.3s ease;
    padding: 6px 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    font-weight: 500;
}

.custom-pagination .page-item.active .page-link {
    background-color: #00a79d;
    border-color: #00a79d;
    color: #fff;
    font-weight: bold;
}

.custom-pagination .page-link:hover:not(.disabled):not(.active) {
    background-color: #00a79d;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
}

/* DISABLED - FIRST */
.custom-pagination .page-item.disabled .page-link {
    color: #ccc !important;
    background-color: #f9f9f9 !important;
    border-color: #eee !important;
    cursor: not-allowed;
    pointer-events: none;
}

.custom-pagination .page-item.disabled .page-link[aria-label="First"] {
    border-top-left-radius: 50px;
    border-bottom-left-radius: 50px;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
}

.custom-pagination .page-item.disabled .page-link[aria-label="Last"] {
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
}


.custom-pagination .page-link[aria-label="First"] {
    border-top-left-radius: 50px;
    border-bottom-left-radius: 50px;
    border-top-right-radius: 14px;
    border-bottom-right-radius: 14px;
}

.custom-pagination .page-link[aria-label="Last"] {
    border-top-right-radius: 50px;
    border-bottom-right-radius: 50px;
    border-top-left-radius: 14px;
    border-bottom-left-radius: 14px;
}
/* Responsive Pagination - prevent wrapping on smaller screens */
.custom-pagination {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 0.4rem;
    padding-left: 0;
    list-style: none;
    margin: 1rem 0;
    row-gap: 0.5rem;
    flex-shrink: 1;
    flex-grow: 1;
}

.custom-pagination .page-link {
    color: #00a79d;
    background-color: #fff;
    border: 1px solid #00a79d;
    border-radius: 50px;
    transition: all 0.3s ease;
    padding: 6px 14px;
    font-size: 0.9rem;
    white-space: nowrap;
    min-width: 36px;
    text-align: center;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

/* Responsive behavior */
@media (max-width: 576px) {
    .custom-pagination {
        gap: 0.25rem;
    }

    .custom-pagination .page-link {
        font-size: 0.75rem;
        padding: 4px 10px;
        min-width: 28px;
    }
}

@media (max-width: 400px) {
    .custom-pagination {
        flex-wrap: nowrap;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .custom-pagination .page-link {
        font-size: 0.7rem;
        padding: 4px 8px;
    }
}
</style>
@endsection

@section('scripts')
<script>
    // Optional custom JS
</script>
@endsection
