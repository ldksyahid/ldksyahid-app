@extends('landing-page.template.body')

@section('content')
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1hDEx-QFNqCTduumn6IvJ6iOf8qmTp-P_" alt="Image" />
            </div>
        </div>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="row mb-5 justify-content-center wow fadeInUp" data-wow-delay="0.2s">
        <div class="col-lg-8">
            <form action="{{ url('/articles') }}" method="GET" id="search-form">
                <div class="d-flex shadow rounded-pill overflow-hidden position-relative" style="background: white;">
                    <input type="text" name="search"
                        id="search-input"
                        class="form-control border-0 ps-4 py-2 rounded-0"
                        placeholder="Cari artikel berdasarkan judul, tema, penulis, editor, atau tahun..."
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
    <div class="row">
        <div class="col-md-3 mb-5">
            <div class="card shadow rounded-4 p-3 wow fadeInUp sticky-filter" data-wow-delay="0.2s">
                <h5 class="mb-3" style="color: #6c757d">Filter Artikel</h5>
                <form method="GET" action="{{ url('/articles') }}" id="filter-form">
                    <div class="mb-3">
                        <label for="theme" class="form-label">Tema</label>
                       <select name="theme[]" id="theme" class="form-select" multiple>
                            @foreach($themes as $theme)
                                <option value="{{ $theme }}" {{ in_array($theme, (array) request('theme')) ? 'selected' : '' }}>{{ $theme }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="writer" class="form-label">Penulis</label>
                        <select name="writer[]" id="writer" class="form-select" multiple>
                            @foreach($writers as $writer)
                                <option value="{{ $writer }}" {{ in_array($writer, (array) request('writer')) ? 'selected' : '' }}>{{ $writer }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editor" class="form-label">Editor</label>
                        <select name="editor[]" id="editor" class="form-select" multiple>
                            @foreach($editors as $editor)
                                <option value="{{ $editor }}" {{ in_array($editor, (array) request('editor')) ? 'selected' : '' }}>{{ $editor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="created_year" class="form-label">Tahun</label>
                        <select name="created_year[]" id="created_year" class="form-select" multiple>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ in_array($year, (array) request('created_year')) ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>


                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Terapkan</button>
                    <a href="{{ url('/articles') }}" class="btn btn-outline-secondary w-100 mt-2 rounded-pill">Reset</a>
                </form>
            </div>
        </div>

        <div class="col-md-9">
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
                            <div class="card-body d-flex flex-column justify-content-between p-4" style="min-height: 300px;">
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

                                <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $postarticle->url(1) }}" aria-label="First">&laquo;</a>
                                </li>

                                <li class="page-item {{ $postarticle->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $postarticle->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                                </li>

                                @if ($start > 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                @for ($i = $start; $i <= $end; $i++)
                                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $postarticle->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($end < $lastPage)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif

                                <li class="page-item {{ !$postarticle->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $postarticle->nextPageUrl() }}" rel="next">&rsaquo;</a>
                                </li>

                                <li class="page-item {{ $currentPage >= $lastPage ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $postarticle->url($lastPage) }}" aria-label="Last">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    height: 300px;
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
.card.p-3 {
    background: #fff;
    border: 1px solid #ddd;
}
.form-select.rounded-pill {
    padding-left: 1rem;
    padding-right: 1rem;
}
.btn.rounded-pill {
    font-weight: 500;
    transition: all 0.3s ease;
}
.btn.btn-primary.rounded-pill:hover {
    background-color: #009b89;
}
.btn.btn-outline-secondary.rounded-pill:hover {
    background-color: #f2f2f2;
    color:  #6c757d;
}
.select2-container--default.select2-container--focus .select2-selection--multiple{
    border: 1px solid #00bfa6;
}
.select2-dropdown {
    border: 1px solid #00bfa6;
    border-radius: 12px;
    overflow: hidden;
    font-size: 0.95rem;
}
.select2-results__option {
    padding: 10px 14px;
    transition: all 0.2s ease;
    cursor: pointer;
    border-bottom: 1px solid #e0f2ef;
}
.select2-results__option:last-child {
    border-bottom: none;
}
.select2-results__option--highlighted {
    background-color: #00bfa6 !important;
    color: white !important;
}
.select2-results__option[aria-selected="true"] {
    background-color: #e6f9f6;
    color: #007f73;
}
.select2-results__options::-webkit-scrollbar {
    width: 6px;
}
.select2-results__options::-webkit-scrollbar-track {
    background: #f0f0f0;
    border-radius: 10px;
}
.select2-results__options::-webkit-scrollbar-thumb {
    background: #00bfa6;
    border-radius: 10px;
}
.select2-dropdown {
    animation: dropdownFadeIn 0.2s ease forwards;
    opacity: 1;
}
.select2-fade-out {
    animation: dropdownFadeOut 0.2s ease forwards;
}
.select2-selection .select2-selection--multiple{
    border-radius: 12px;
}
@keyframes dropdownFadeIn {
    from {
        opacity: 0;
        transform: translateY(-4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes dropdownFadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-4px);
    }
}
.select2-selection__clear {
    font-weight: bold;
    font-size: 1.1rem;
    color: #999;
    margin-right: 8px;
    transition: color 0.2s ease;
}
.select2-selection__clear:hover {
    color: #ccc;
}
.select2-search--dropdown .select2-search__field {
  border: none;
  box-shadow: none;
}
.select2-search__field {
    border: none;
    box-shadow: none;
    outline: none;
    background-color: transparent;
    color: #8d9297;
}
.select2-selection__choice{
    border: #00bfa6 !important;
    background-color: #00bfa6 !important;
    color: white;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: white;
    transition: all 0.2s ease;
    border-right: 1px solid white;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    color: white;
    background-color: #1ee8ce
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:focus {
    color: white;
    outline: none;
    background-color: #1ee8ce;
}
@media (min-width: 992px) {
    .sticky-filter {
        position: sticky;
        top: 90px;
        z-index: 900;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        const searchInput = $('#search-input');
        const clearBtn = $('#clear-search');

        $('#theme, #writer, #editor, #created_year').each(function () {
            $(this).select2({
                placeholder: "Semua",
                allowClear: true,
                width: '100%',
                dropdownPosition: 'below'
            });
        });

        searchInput.on('input', function () {
            clearBtn.toggle($(this).val().length > 0);
        });

        clearBtn.on('click', function () {
            searchInput.val('');
            $('#search-form').submit();
        });

        $(window).on('scroll', function () {
            $('#theme, #writer, #editor, #created_year').select2('close');
        });
    });
</script>
@endsection

