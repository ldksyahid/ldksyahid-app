{{-- resources/views/landing-page/article/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.article.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="hero-fun py-5 wow fadeIn" data-wow-delay="0.1s">

    {{-- ── Hero Jumbotron (Quran type) ──────────────────────────── --}}
    <x-hero-jumbotron type="quran">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1hDEx-QFNqCTduumn6IvJ6iOf8qmTp-P_"
                 alt="Artikel LDK Syahid" />
        </div>
    </x-hero-jumbotron>


    {{-- ── Article Section ──────────────────────────────────────── --}}
    <div class="container mt-5" id="ar-article-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="ar-section-badge">
                <span>📝</span>
                <span>Artikel</span>
                <span class="ar-badge-pulse"></span>
            </div>
            <h2 class="ar-section-title mt-3">Kumpulan Artikel</h2>
            <p class="ar-section-sub">Karya tulis terbaik dari para penulis dan editor LDK Syahid</p>
        </div>

        {{-- ── Search + Filter Bar ─────────────────────────────── --}}
        <div class="mb-3 wow fadeInUp" data-wow-delay="0.15s">
            <div class="ar-search-wrap">

                {{-- Search field --}}
                <div class="ar-search-field">
                    <input  type="text"
                            id="ar-search-input"
                            class="ar-search-input"
                            placeholder="Cari artikel berdasarkan judul, tema, penulis…"
                            value="{{ request('search') }}"
                            autocomplete="off">
                    <button id="ar-search-clear" class="ar-search-clear" aria-label="Hapus pencarian">
                        &times;
                    </button>
                </div>

                {{-- Filter button --}}
                <button type="button" class="ar-filter-btn"
                        data-bs-toggle="modal" data-bs-target="#ar-filter-modal"
                        aria-label="Buka filter">
                    <i class="fas fa-sliders-h"></i>
                    <span>Filter</span>
                    <span id="ar-filter-count" class="ar-filter-badge" style="display:none;">0</span>
                </button>

                {{-- Sort dropdown --}}
                <div class="dropdown">
                    <button class="ar-sort-btn dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-sort me-1"></i>Urutkan
                    </button>
                    <ul class="dropdown-menu" style="z-index:1060; min-width:180px;">
                        <li>
                            <a class="dropdown-item {{ !request('sort') || request('sort') == 'newest' ? 'active' : '' }}"
                               href="#" data-ar-sort="newest">
                                <i class="far fa-clock me-2"></i>Terbaru
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('sort') == 'title' ? 'active' : '' }}"
                               href="#" data-ar-sort="title">
                                <i class="fas fa-sort-alpha-down me-2"></i>Judul A–Z
                            </a>
                        </li>
                    </ul>
                </div>

            </div>{{-- /ar-search-wrap --}}

            {{-- Active Filter Pills (server-rendered initial state) --}}
            <div id="ar-active-pills" class="ar-active-pills mt-2">
                @foreach((array)request('theme', []) as $val)
                    <span class="ar-active-pill" data-select-id="ar-theme-select" data-value="{{ $val }}">
                        <span>Tema: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('writer', []) as $val)
                    <span class="ar-active-pill" data-select-id="ar-writer-select" data-value="{{ $val }}">
                        <span>Penulis: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('editor', []) as $val)
                    <span class="ar-active-pill" data-select-id="ar-editor-select" data-value="{{ $val }}">
                        <span>Editor: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('created_year', []) as $val)
                    <span class="ar-active-pill" data-select-id="ar-year-select" data-value="{{ $val }}">
                        <span>Tahun: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Results info --}}
        <div id="ar-results-info" class="ar-results-info mb-3">
            @if($postarticle->total() > 0)
                Menampilkan
                <strong>{{ $postarticle->firstItem() }}–{{ $postarticle->lastItem() }}</strong>
                dari <strong>{{ $postarticle->total() }}</strong> artikel
                @if(request('search'))
                    untuk "<em>{{ request('search') }}</em>"
                @endif
            @else
                Tidak ada artikel yang ditemukan
            @endif
        </div>

        {{-- ── Cards Wrap (AJAX target) ────────────────────────── --}}
        <div id="ar-cards-wrap">
            @include('landing-page.article.components._article-cards')
        </div>

    </div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     FILTER MODAL
     ══════════════════════════════════════════════════ --}}
<div class="modal fade ar-modal" id="ar-filter-modal" tabindex="-1"
     aria-labelledby="ar-filter-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="ar-filter-modal-label"
                    style="color: #00a79d;">
                    <i class="fas fa-sliders-h me-2"></i>Filter Artikel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body p-4">
                <div class="row g-4">

                    <div class="col-md-6">
                        <label for="ar-theme-select" class="form-label fw-semibold mb-2"
                               style="color:#00a79d; font-size:.88rem;">
                            <i class="fas fa-hashtag me-1"></i>Tema
                        </label>
                        <select id="ar-theme-select" class="form-select" multiple>
                            @foreach($themes as $theme)
                                <option value="{{ $theme }}"
                                    {{ in_array($theme, (array)request('theme')) ? 'selected' : '' }}>
                                    {{ $theme }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="ar-writer-select" class="form-label fw-semibold mb-2"
                               style="color:#00a79d; font-size:.88rem;">
                            <i class="fas fa-user-edit me-1"></i>Penulis
                        </label>
                        <select id="ar-writer-select" class="form-select" multiple>
                            @foreach($writers as $writer)
                                <option value="{{ $writer }}"
                                    {{ in_array($writer, (array)request('writer')) ? 'selected' : '' }}>
                                    {{ $writer }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="ar-editor-select" class="form-label fw-semibold mb-2"
                               style="color:#00a79d; font-size:.88rem;">
                            <i class="fas fa-pen me-1"></i>Editor
                        </label>
                        <select id="ar-editor-select" class="form-select" multiple>
                            @foreach($editors as $editor)
                                <option value="{{ $editor }}"
                                    {{ in_array($editor, (array)request('editor')) ? 'selected' : '' }}>
                                    {{ $editor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="ar-year-select" class="form-label fw-semibold mb-2"
                               style="color:#00a79d; font-size:.88rem;">
                            <i class="fas fa-calendar-alt me-1"></i>Tahun
                        </label>
                        <select id="ar-year-select" class="form-select" multiple>
                            @foreach($years as $year)
                                <option value="{{ $year }}"
                                    {{ in_array($year, (array)request('created_year')) ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="button" id="ar-reset-filter"
                        class="btn btn-outline-warning rounded-pill px-4">
                    <i class="fas fa-undo me-1"></i>Reset
                </button>
                <button type="button" id="ar-apply-filter"
                        class="btn btn-primary rounded-pill px-4"
                        style="background:#00a79d; border-color:#00a79d;">
                    <i class="fas fa-check me-1"></i>Terapkan
                </button>
            </div>

        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="ar-bs-backdrop" id="ar-bs-backdrop"></div>
<div class="ar-bottom-sheet" id="ar-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Artikel">
    <div class="ar-bs-handle"></div>
    <button class="ar-bs-close" id="ar-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="ar-bs-content" id="ar-bs-content">
        {{-- Populated by JS via arOpenBottomSheet() --}}
    </div>
</div>


{{-- Hidden config inputs (accessed by JS) --}}
<input type="hidden" id="ar-base-url"  value="{{ url('/articles') }}">
<input type="hidden" id="ar-sort-val"  value="{{ request('sort', 'newest') }}">

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.article.components._index-scripts')
@endsection
