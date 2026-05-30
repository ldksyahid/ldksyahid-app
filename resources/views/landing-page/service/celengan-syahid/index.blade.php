@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.celengan-syahid.components._index._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="cs-page-section py-5 wow fadeIn mt-5" data-wow-delay="0.1s">

    {{-- ── Hero Jumbotron (Hadith type) ──────────────────────────── --}}
    <x-hero-jumbotron type="hadith">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/13hUNUJ_oQhmBGMRx37dj380dOhlsKm7O"
                 alt="Celengan Syahid" />
        </div>
    </x-hero-jumbotron>


    {{-- ── Campaign Section ───────────────────────────────────────── --}}
    <div class="container mt-5" id="cs-campaign-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="cs-section-badge">
                <span>💝</span>
                <span>Celengan Syahid</span>
                <span class="cs-badge-pulse"></span>
            </div>
            <h2 class="cs-section-title mt-3">Mari Bantu Sesama</h2>
            <p class="cs-section-sub">Bersama kita wujudkan kebaikan dan kepedulian untuk mereka yang membutuhkan</p>
        </div>

        {{-- ── Info Card (Ayat) ────────────────────────────────── --}}
        <div class="cs-ayat-wrap wow fadeInUp mb-5" data-wow-delay="0.15s">
            <p class="cs-ayat-label">Landasan Kami</p>
            <div class="cs-ayat-bar"></div>
            <div class="cs-ayat-quote">
                <p>"Dan berbuat-baiklah kepada kedua orang tua, karib-kerabat, anak-anak yatim, orang-orang miskin,
                tetangga dekat dan tetangga jauh, teman sejawat, ibnu sabil dan hamba sahaya yang kamu miliki.
                Sungguh, Allah tidak menyukai orang yang sombong dan membanggakan diri,"</p>
                <span>&#9679; QS. An-Nisa 4: Ayat 36</span>
            </div>
        </div>

        {{-- ── Search + Filter Bar ─────────────────────────────── --}}
        <div class="mb-3 wow fadeInUp" data-wow-delay="0.2s">
            <x-search-filter-bar
                prefix="cs"
                placeholder="Cari campaign berdasarkan judul…"
                :search-value="request('search')"
                filter-modal-id="cs-filter-modal"
                :sort-options="[
                    ['value' => 'newest',   'label' => 'Terbaru',    'icon' => 'far fa-clock'],
                    ['value' => 'deadline', 'label' => 'Deadline',   'icon' => 'fas fa-hourglass-half'],
                    ['value' => 'title',    'label' => 'Judul A–Z',  'icon' => 'fas fa-sort-alpha-down'],
                ]"
                :current-sort="request('sort', 'newest')"
            >
                {{-- Active filter pills --}}
                @foreach((array)request('category', []) as $val)
                    <span class="sfb-pill" data-select-id="cs-category-select" data-value="{{ $val }}">
                        <span>Kategori: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('status', []) as $val)
                    <span class="sfb-pill" data-select-id="cs-status-select" data-value="{{ $val }}">
                        <span>Status: {{ $statuses[$val] ?? $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('organizer', []) as $val)
                    <span class="sfb-pill" data-select-id="cs-organizer-select" data-value="{{ $val }}">
                        <span>Penyelenggara: {{ $organizers[$val] ?? $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
            </x-search-filter-bar>
        </div>

        {{-- Results info --}}
        <div id="cs-results-info" class="cs-results-info mb-3 wow fadeInUp" data-wow-delay="0.25s">
            @if($campaigns->total() > 0)
                Menampilkan
                <strong>{{ $campaigns->firstItem() }}–{{ $campaigns->lastItem() }}</strong>
                dari <strong>{{ $campaigns->total() }}</strong> campaign
                @if(request('search'))
                    untuk "<em>{{ request('search') }}</em>"
                @endif
            @else
                Tidak ada campaign yang ditemukan
            @endif
        </div>

        {{-- ── Cards Wrap (AJAX target) ────────────────────────── --}}
        <div id="cs-cards-wrap">
            @include('landing-page.service.celengan-syahid.components._index._campaign-cards')
        </div>

    </div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="cs-bs-backdrop" id="cs-bs-backdrop"></div>
<div class="cs-bottom-sheet" id="cs-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Campaign">
    <button class="cs-bs-close" id="cs-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="cs-bs-content" id="cs-bs-content">
        {{-- Populated by JS via csOpenBottomSheet() --}}
    </div>
</div>


{{-- Hidden config --}}
<input type="hidden" id="cs-base-url"  value="{{ url('/celengansyahid') }}">
<input type="hidden" id="cs-sort-val"  value="{{ request('sort', 'newest') }}">

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.celengan-syahid.components._index._index-scripts')
@endsection


{{-- ══════════════════════════════════════════════════
     FILTER MODAL
     ══════════════════════════════════════════════════ --}}
@push('modals')
<x-search-filter-bar.modal
    prefix="cs"
    title="Filter Campaign"
    subtitle="Pilih satu atau lebih kategori untuk menyaring campaign"
    emoji="💝"
>
    <div class="col-12">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-tag"></i></div>
                <label for="cs-category-select" class="sfb-fm-label">Kategori Campaign</label>
            </div>
            <select id="cs-category-select" class="form-select" multiple>
                @foreach($categories as $val => $label)
                    <option value="{{ $val }}"
                        {{ in_array($val, (array)request('category')) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-toggle-on"></i></div>
                <label for="cs-status-select" class="sfb-fm-label">Status Campaign</label>
            </div>
            <select id="cs-status-select" class="form-select" multiple>
                @foreach($statuses as $val => $label)
                    <option value="{{ $val }}"
                        {{ in_array($val, (array)request('status')) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-building"></i></div>
                <label for="cs-organizer-select" class="sfb-fm-label">Penyelenggara</label>
            </div>
            <select id="cs-organizer-select" class="form-select" multiple>
                @foreach($organizers as $val => $label)
                    <option value="{{ $val }}"
                        {{ in_array($val, (array)request('organizer')) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</x-search-filter-bar.modal>
@endpush
