{{-- resources/views/landing-page/news/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.news.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="nw-info-section hero-fun py-5 wow fadeIn" data-wow-delay="0.1s">

    {{-- ── Hero / Jumbotron (Hadith type) ────────────────────────── --}}
    <x-hero-jumbotron type="hadith">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1OtOSZ4rX0-83a1zQbxP9dQG04DbWzQlJ"
                 alt="Berita LDK Syahid" />
        </div>
    </x-hero-jumbotron>


    {{-- ── News Section ──────────────────────────────────────────── --}}
    <div class="container mt-5" id="nw-news-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="nw-section-badge">
                <span>📰</span>
                <span>Berita</span>
                <span class="nw-badge-pulse"></span>
            </div>
            <h2 class="nw-section-title mt-3">Berita Terkini</h2>
            <p class="nw-section-sub">Informasi dan kabar terbaru seputar kegiatan LDK Syahid</p>
        </div>

        {{-- ── Search + Filter Bar ─────────────────────────────── --}}
        <div class="mb-3 wow fadeInUp" data-wow-delay="0.15s">
            <x-search-filter-bar
                prefix="nw"
                placeholder="Cari berita berdasarkan judul, penerbit, reporter…"
                :search-value="request('search')"
                filter-modal-id="nw-filter-modal"
                :sort-options="[
                    ['value' => 'newest', 'label' => 'Terbaru',   'icon' => 'far fa-clock'],
                    ['value' => 'title',  'label' => 'Judul A–Z', 'icon' => 'fas fa-sort-alpha-down'],
                ]"
                :current-sort="request('sort', 'newest')"
            >
                {{-- Server-rendered active filter pills --}}
                @foreach((array)request('publisher', []) as $val)
                    <span class="sfb-pill" data-select-id="nw-publisher-select" data-value="{{ $val }}">
                        <span>Penerbit: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('reporter', []) as $val)
                    <span class="sfb-pill" data-select-id="nw-reporter-select" data-value="{{ $val }}">
                        <span>Reporter: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('editor', []) as $val)
                    <span class="sfb-pill" data-select-id="nw-editor-select" data-value="{{ $val }}">
                        <span>Editor: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('year', []) as $val)
                    <span class="sfb-pill" data-select-id="nw-year-select" data-value="{{ $val }}">
                        <span>Tahun: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
            </x-search-filter-bar>
        </div>

        {{-- Results info --}}
        <div id="nw-results-info" class="nw-results-info mb-3">
            @if($postnews->total() > 0)
                Menampilkan
                <strong>{{ $postnews->firstItem() }}–{{ $postnews->lastItem() }}</strong>
                dari <strong>{{ $postnews->total() }}</strong> berita
                @if(request('search'))
                    untuk "<em>{{ request('search') }}</em>"
                @endif
            @else
                Tidak ada berita yang ditemukan
            @endif
        </div>

        {{-- ── Cards Wrap (AJAX target) ─────────────────────────── --}}
        <div id="nw-cards-wrap">
            @include('landing-page.news.components._news-cards')
        </div>

    </div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="nw-bs-backdrop" id="nw-bs-backdrop"></div>
<div class="nw-bottom-sheet" id="nw-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Berita">
    <button class="nw-bs-close" id="nw-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="nw-bs-content" id="nw-bs-content">
        {{-- Populated by JS via nwOpenBottomSheet() --}}
    </div>
</div>

{{-- Hidden config inputs (accessed by JS) --}}
<input type="hidden" id="nw-base-url" value="{{ url('/news') }}">
<input type="hidden" id="nw-sort-val" value="{{ request('sort', 'newest') }}">

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.news.components._index-scripts')
@endsection


{{-- ══════════════════════════════════════════════════
     FILTER MODAL — pushed outside section to avoid stacking context
     ══════════════════════════════════════════════════ --}}
@push('modals')
{{-- Custom blur backdrop (Bootstrap backdrop disabled via data-bs-backdrop="false") --}}
<div id="nw-fm-backdrop" class="nw-fm-backdrop"></div>

<div class="modal fade nw-modal" id="nw-filter-modal" tabindex="-1"
     data-bs-backdrop="false"
     aria-labelledby="nw-filter-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered nw-fm-dialog">
        <div class="modal-content nw-fm-content">

            {{-- Custom close button --}}
            <button type="button" class="nw-fm-close" data-bs-dismiss="modal" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>

            {{-- Header --}}
            <div class="nw-fm-header">
                <div class="nw-fm-badge">
                    <span>📰</span>
                    <span>Cari & Saring</span>
                    <span class="nw-fm-pulse"></span>
                </div>
                <div class="nw-fm-icon-wrap">
                    <div class="nw-fm-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div class="nw-fm-ring nw-fm-ring-1"></div>
                    <div class="nw-fm-ring nw-fm-ring-2"></div>
                </div>
                <h5 class="nw-fm-title" id="nw-filter-modal-label">Filter Berita</h5>
                <p class="nw-fm-subtitle">Pilih satu atau lebih filter untuk menyaring berita</p>
            </div>

            {{-- Body --}}
            <div class="nw-fm-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="nw-fm-field-wrap">
                            <div class="nw-fm-field-label">
                                <div class="nw-fm-field-icon"><i class="fas fa-building"></i></div>
                                <label for="nw-publisher-select" class="nw-fm-label">Penerbit</label>
                            </div>
                            <select id="nw-publisher-select" class="form-select" multiple>
                                @foreach($publishers as $pub)
                                    <option value="{{ $pub }}" {{ in_array($pub, (array)request('publisher')) ? 'selected' : '' }}>{{ $pub }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="nw-fm-field-wrap">
                            <div class="nw-fm-field-label">
                                <div class="nw-fm-field-icon"><i class="fas fa-user-edit"></i></div>
                                <label for="nw-reporter-select" class="nw-fm-label">Reporter</label>
                            </div>
                            <select id="nw-reporter-select" class="form-select" multiple>
                                @foreach($reporters as $rep)
                                    <option value="{{ $rep }}" {{ in_array($rep, (array)request('reporter')) ? 'selected' : '' }}>{{ $rep }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="nw-fm-field-wrap">
                            <div class="nw-fm-field-label">
                                <div class="nw-fm-field-icon"><i class="fas fa-pen"></i></div>
                                <label for="nw-editor-select" class="nw-fm-label">Editor</label>
                            </div>
                            <select id="nw-editor-select" class="form-select" multiple>
                                @foreach($editors as $ed)
                                    <option value="{{ $ed }}" {{ in_array($ed, (array)request('editor')) ? 'selected' : '' }}>{{ $ed }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="nw-fm-field-wrap">
                            <div class="nw-fm-field-label">
                                <div class="nw-fm-field-icon"><i class="fas fa-calendar-alt"></i></div>
                                <label for="nw-year-select" class="nw-fm-label">Tahun Terbit</label>
                            </div>
                            <select id="nw-year-select" class="form-select" multiple>
                                @foreach($years as $yr)
                                    <option value="{{ $yr }}" {{ in_array($yr, (array)request('year')) ? 'selected' : '' }}>{{ $yr }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="nw-fm-footer">
                <button type="button" class="nw-fm-btn-close" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    <span>Tutup</span>
                </button>
                <button type="button" id="nw-reset-filter" class="nw-fm-btn-reset">
                    <i class="fas fa-undo"></i>
                    <span>Reset</span>
                </button>
                <button type="button" id="nw-apply-filter" class="nw-fm-btn-apply">
                    <span class="nw-fm-btn-icon"><i class="fas fa-check"></i></span>
                    <span>Terapkan Filter</span>
                    <div class="nw-fm-btn-shine"></div>
                </button>
            </div>

        </div>
    </div>
</div>
@endpush
