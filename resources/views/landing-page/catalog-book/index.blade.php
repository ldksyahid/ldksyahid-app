{{-- resources/views/landing-page/catalog-book/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.catalog-book.components._index._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="cb-page-section py-5 wow fadeIn mt-5" data-wow-delay="0.1s">

    {{-- ── Hero Jumbotron (Hadith type) ──────────────────────────── --}}
    <x-hero-jumbotron type="hadith">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/15FZ7gsz6x_2uH90iPqi0OVZY-OMISAVf"
                 alt="Perpustakaan LDK Syahid" />
        </div>
    </x-hero-jumbotron>


    {{-- ── Book Section ────────────────────────────────────────── --}}
    <div class="container mt-5" id="cb-book-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="cb-section-badge">
                <span>📚</span>
                <span>Perpustakaan</span>
                <span class="cb-badge-pulse"></span>
            </div>
            <h2 class="cb-section-title mt-3">Koleksi Buku LDK Syahid</h2>
            <p class="cb-section-sub">Jelajahi koleksi buku islami terpilih untuk memperkaya wawasan dan iman</p>
        </div>

        {{-- ── Search + Filter Bar ─────────────────────────────── --}}
        <div class="mb-3 wow fadeInUp" data-wow-delay="0.15s">
            <x-search-filter-bar
                prefix="cb"
                placeholder="Cari buku berdasarkan judul, penulis, penerbit, ISBN, atau tahun…"
                :search-value="request('search')"
                filter-modal-id="cb-filter-modal"
                :sort-options="[
                    ['value' => 'newest',  'label' => 'Terbaru',    'icon' => 'far fa-clock'],
                    ['value' => 'popular', 'label' => 'Terpopuler', 'icon' => 'fas fa-heart'],
                    ['value' => 'title',   'label' => 'Judul A–Z',  'icon' => 'fas fa-sort-alpha-down'],
                ]"
                :current-sort="request('sort', 'newest')"
            >
                {{-- Server-rendered active filter pills --}}
                @foreach((array)request('category', []) as $val)
                    @php $cat = $categories->firstWhere('bookCategoryID', $val); @endphp
                    @if($cat)
                    <span class="sfb-pill" data-select-id="cb-category-select" data-value="{{ $val }}">
                        <span>Kategori: {{ $cat->bookCategoryName }}</span> <i class="fas fa-times"></i>
                    </span>
                    @endif
                @endforeach
                @foreach((array)request('author', []) as $val)
                    <span class="sfb-pill" data-select-id="cb-author-select" data-value="{{ $val }}">
                        <span>Penulis: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('publisher', []) as $val)
                    <span class="sfb-pill" data-select-id="cb-publisher-select" data-value="{{ $val }}">
                        <span>Penerbit: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('year', []) as $val)
                    <span class="sfb-pill" data-select-id="cb-year-select" data-value="{{ $val }}">
                        <span>Tahun: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('language', []) as $val)
                    @php $lang = $languages->firstWhere('languageID', $val); @endphp
                    @if($lang)
                    <span class="sfb-pill" data-select-id="cb-language-select" data-value="{{ $val }}">
                        <span>Bahasa: {{ $lang->languageName }}</span> <i class="fas fa-times"></i>
                    </span>
                    @endif
                @endforeach
                @foreach((array)request('author_type', []) as $val)
                    @php $at = $authorTypes->firstWhere('authorTypeID', $val); @endphp
                    @if($at)
                    <span class="sfb-pill" data-select-id="cb-author-type-select" data-value="{{ $val }}">
                        <span>Kat. Penulis: {{ $at->authorTypeName }}</span> <i class="fas fa-times"></i>
                    </span>
                    @endif
                @endforeach
                @foreach((array)request('availability', []) as $val)
                    @php $av = $availabilityTypes->firstWhere('availabilityTypeID', $val); @endphp
                    @if($av)
                    <span class="sfb-pill" data-select-id="cb-availability-select" data-value="{{ $val }}">
                        <span>Ketersediaan: {{ $av->availabilityTypeName }}</span> <i class="fas fa-times"></i>
                    </span>
                    @endif
                @endforeach
            </x-search-filter-bar>
        </div>

        {{-- Results info --}}
        <div id="cb-results-info" class="cb-results-info mb-3">
            @if($books->total() > 0)
                Menampilkan
                <strong>{{ $books->firstItem() }}–{{ $books->lastItem() }}</strong>
                dari <strong>{{ $books->total() }}</strong> buku
                @if(request('search'))
                    untuk "<em>{{ request('search') }}</em>"
                @endif
            @else
                Tidak ada buku yang ditemukan
            @endif
        </div>

        {{-- ── Cards Wrap (AJAX target) ────────────────────────── --}}
        <div id="cb-cards-wrap">
            @include('landing-page.catalog-book.components._index._catalog-cards')
        </div>

    </div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="cb-bs-backdrop" id="cb-bs-backdrop"></div>
<div class="cb-bottom-sheet" id="cb-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Buku">
    <button class="cb-bs-close" id="cb-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="cb-bs-content" id="cb-bs-content">
        {{-- Populated by JS via cbOpenBottomSheet() --}}
    </div>
</div>


{{-- Hidden config inputs --}}
<input type="hidden" id="cb-base-url" value="{{ url('/perpustakaan') }}">
<input type="hidden" id="cb-sort-val" value="{{ request('sort', 'newest') }}">

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.catalog-book.components._index._index-scripts')
@endsection


{{-- ══════════════════════════════════════════════════
     FILTER MODAL — rendered at body level via @push('modals')
     ══════════════════════════════════════════════════ --}}
@push('modals')
<x-search-filter-bar.modal
    prefix="cb"
    title="Filter Buku"
    subtitle="Pilih satu atau lebih filter untuk menyaring koleksi buku"
    emoji="📚"
>
    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-tag"></i></div>
                <label for="cb-category-select" class="sfb-fm-label">Kategori Buku</label>
            </div>
            <select id="cb-category-select" class="form-select" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->bookCategoryID }}"
                        {{ in_array($category->bookCategoryID, (array)request('category')) ? 'selected' : '' }}>
                        {{ $category->bookCategoryName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-user-edit"></i></div>
                <label for="cb-author-select" class="sfb-fm-label">Penulis</label>
            </div>
            <select id="cb-author-select" class="form-select" multiple>
                @foreach($authors as $author)
                    <option value="{{ $author }}"
                        {{ in_array($author, (array)request('author')) ? 'selected' : '' }}>
                        {{ $author }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-building"></i></div>
                <label for="cb-publisher-select" class="sfb-fm-label">Penerbit</label>
            </div>
            <select id="cb-publisher-select" class="form-select" multiple>
                @foreach($publishers as $publisher)
                    <option value="{{ $publisher }}"
                        {{ in_array($publisher, (array)request('publisher')) ? 'selected' : '' }}>
                        {{ $publisher }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-calendar-alt"></i></div>
                <label for="cb-year-select" class="sfb-fm-label">Tahun</label>
            </div>
            <select id="cb-year-select" class="form-select" multiple>
                @foreach($years as $year)
                    <option value="{{ $year }}"
                        {{ in_array($year, (array)request('year')) ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-language"></i></div>
                <label for="cb-language-select" class="sfb-fm-label">Bahasa</label>
            </div>
            <select id="cb-language-select" class="form-select" multiple>
                @foreach($languages as $language)
                    <option value="{{ $language->languageID }}"
                        {{ in_array($language->languageID, (array)request('language')) ? 'selected' : '' }}>
                        {{ $language->languageName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-users"></i></div>
                <label for="cb-author-type-select" class="sfb-fm-label">Kategori Penulis</label>
            </div>
            <select id="cb-author-type-select" class="form-select" multiple>
                @foreach($authorTypes as $authorType)
                    <option value="{{ $authorType->authorTypeID }}"
                        {{ in_array($authorType->authorTypeID, (array)request('author_type')) ? 'selected' : '' }}>
                        {{ $authorType->authorTypeName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-bookmark"></i></div>
                <label for="cb-availability-select" class="sfb-fm-label">Ketersediaan</label>
            </div>
            <select id="cb-availability-select" class="form-select" multiple>
                @foreach($availabilityTypes as $availabilityType)
                    <option value="{{ $availabilityType->availabilityTypeID }}"
                        {{ in_array($availabilityType->availabilityTypeID, (array)request('availability')) ? 'selected' : '' }}>
                        {{ $availabilityType->availabilityTypeName }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

</x-search-filter-bar.modal>
@endpush
