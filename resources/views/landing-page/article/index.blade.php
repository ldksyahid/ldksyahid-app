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

        {{-- ── Search + Filter Bar (reusable component) ───────── --}}
        <div class="mb-3 wow fadeInUp" data-wow-delay="0.15s">
            <x-search-filter-bar
                prefix="ar"
                placeholder="Cari artikel berdasarkan judul, tema, penulis…"
                :search-value="request('search')"
                filter-modal-id="ar-filter-modal"
                :sort-options="[
                    ['value' => 'newest', 'label' => 'Terbaru',   'icon' => 'far fa-clock'],
                    ['value' => 'title',  'label' => 'Judul A–Z', 'icon' => 'fas fa-sort-alpha-down'],
                ]"
                :current-sort="request('sort', 'newest')"
            >
                {{-- Server-rendered active filter pills --}}
                @foreach((array)request('theme', []) as $val)
                    <span class="sfb-pill" data-select-id="ar-theme-select" data-value="{{ $val }}">
                        <span>Tema: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('writer', []) as $val)
                    <span class="sfb-pill" data-select-id="ar-writer-select" data-value="{{ $val }}">
                        <span>Penulis: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('editor', []) as $val)
                    <span class="sfb-pill" data-select-id="ar-editor-select" data-value="{{ $val }}">
                        <span>Editor: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('created_year', []) as $val)
                    <span class="sfb-pill" data-select-id="ar-year-select" data-value="{{ $val }}">
                        <span>Tahun: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
            </x-search-filter-bar>
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
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="ar-bs-backdrop" id="ar-bs-backdrop"></div>
<div class="ar-bottom-sheet" id="ar-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Artikel">
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


{{-- ══════════════════════════════════════════════════
     FILTER MODAL — pushed outside #photo to avoid stacking context.
     (#photo has z-index:1 → Bootstrap backdrop at z-index:1040 would cover
     any modal inside it. @push('modals') renders at body level, after #photo.)
     ══════════════════════════════════════════════════ --}}
@push('modals')
{{-- Custom blur backdrop (Bootstrap backdrop disabled via data-bs-backdrop="false") --}}
<div id="ar-fm-backdrop" class="ar-fm-backdrop"></div>

<div class="modal fade ar-modal" id="ar-filter-modal" tabindex="-1"
     data-bs-backdrop="false"
     aria-labelledby="ar-filter-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ar-fm-dialog">
        <div class="modal-content ar-fm-content">

            {{-- Custom close button --}}
            <button type="button" class="ar-fm-close" data-bs-dismiss="modal" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>

            {{-- Header --}}
            <div class="ar-fm-header">
                <div class="ar-fm-badge">
                    <span>🔍</span>
                    <span>Cari & Saring</span>
                    <span class="ar-fm-pulse"></span>
                </div>
                <div class="ar-fm-icon-wrap">
                    <div class="ar-fm-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div class="ar-fm-ring ar-fm-ring-1"></div>
                    <div class="ar-fm-ring ar-fm-ring-2"></div>
                </div>
                <h5 class="ar-fm-title" id="ar-filter-modal-label">Filter Artikel</h5>
                <p class="ar-fm-subtitle">Pilih satu atau lebih filter untuk menyaring artikel</p>
            </div>

            {{-- Body --}}
            <div class="ar-fm-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="ar-fm-field-wrap">
                            <div class="ar-fm-field-label">
                                <div class="ar-fm-field-icon"><i class="fas fa-hashtag"></i></div>
                                <label for="ar-theme-select" class="ar-fm-label">Tema</label>
                            </div>
                            <select id="ar-theme-select" class="form-select" multiple>
                                @foreach($themes as $theme)
                                    <option value="{{ $theme }}" {{ in_array($theme, (array)request('theme')) ? 'selected' : '' }}>{{ $theme }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ar-fm-field-wrap">
                            <div class="ar-fm-field-label">
                                <div class="ar-fm-field-icon"><i class="fas fa-user-edit"></i></div>
                                <label for="ar-writer-select" class="ar-fm-label">Penulis</label>
                            </div>
                            <select id="ar-writer-select" class="form-select" multiple>
                                @foreach($writers as $writer)
                                    <option value="{{ $writer }}" {{ in_array($writer, (array)request('writer')) ? 'selected' : '' }}>{{ $writer }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ar-fm-field-wrap">
                            <div class="ar-fm-field-label">
                                <div class="ar-fm-field-icon"><i class="fas fa-pen"></i></div>
                                <label for="ar-editor-select" class="ar-fm-label">Editor</label>
                            </div>
                            <select id="ar-editor-select" class="form-select" multiple>
                                @foreach($editors as $editor)
                                    <option value="{{ $editor }}" {{ in_array($editor, (array)request('editor')) ? 'selected' : '' }}>{{ $editor }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="ar-fm-field-wrap">
                            <div class="ar-fm-field-label">
                                <div class="ar-fm-field-icon"><i class="fas fa-calendar-alt"></i></div>
                                <label for="ar-year-select" class="ar-fm-label">Tahun</label>
                            </div>
                            <select id="ar-year-select" class="form-select" multiple>
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ in_array($year, (array)request('created_year')) ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="ar-fm-footer">
                <button type="button" class="ar-fm-btn-close" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    <span>Tutup</span>
                </button>
                <button type="button" id="ar-reset-filter" class="ar-fm-btn-reset">
                    <i class="fas fa-undo"></i>
                    <span>Reset</span>
                </button>
                <button type="button" id="ar-apply-filter" class="ar-fm-btn-apply">
                    <span class="ar-fm-btn-icon"><i class="fas fa-check"></i></span>
                    <span>Terapkan Filter</span>
                    <div class="ar-fm-btn-shine"></div>
                </button>
            </div>

        </div>
    </div>
</div>
@endpush
