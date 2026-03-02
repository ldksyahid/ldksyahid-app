{{-- resources/views/landing-page/event/index.blade.php --}}
@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.event.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="ev-info-section hero-fun py-5 wow fadeIn" data-wow-delay="0.1s">

    {{-- ── Hero / Jumbotron ────────────────────────────────────── --}}
    <x-hero-jumbotron type="quran">
        <div class="hero-slide">
            <img class="hero-image"
                 src="https://lh3.googleusercontent.com/d/1RGwNt7vN1cUTUOlD4DeDdceeQdRmhFAG"
                 alt="Kegiatan LDK Syahid" />
        </div>
    </x-hero-jumbotron>


    {{-- ── Event Section ──────────────────────────────────────── --}}
    <div class="container mt-5" id="ev-event-section">

        {{-- Section Header --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="ev-section-badge">
                <span>🎪</span>
                <span>Kegiatan</span>
                <span class="ev-badge-pulse"></span>
            </div>
            <h2 class="ev-section-title mt-3">Kegiatan Kami</h2>
            <p class="ev-section-sub">Jelajahi berbagai kegiatan dan program yang diselenggarakan LDK Syahid</p>
        </div>

        {{-- ── Search + Filter Bar ──────────────────────────── --}}
        <div class="mb-3 wow fadeInUp" data-wow-delay="0.15s">
            <x-search-filter-bar
                prefix="ev"
                placeholder="Cari kegiatan berdasarkan judul atau divisi…"
                :search-value="request('search')"
                filter-modal-id="ev-filter-modal"
                :sort-options="[
                    ['value' => 'newest', 'label' => 'Terbaru',   'icon' => 'far fa-clock'],
                    ['value' => 'title',  'label' => 'Judul A–Z', 'icon' => 'fas fa-sort-alpha-down'],
                ]"
                :current-sort="request('sort', 'newest')"
            >
                {{-- Server-rendered active filter pills --}}
                @foreach((array)request('division', []) as $val)
                    <span class="sfb-pill" data-select-id="ev-division-select" data-value="{{ $val }}">
                        <span>Divisi: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
                @foreach((array)request('year', []) as $val)
                    <span class="sfb-pill" data-select-id="ev-year-select" data-value="{{ $val }}">
                        <span>Tahun: {{ $val }}</span> <i class="fas fa-times"></i>
                    </span>
                @endforeach
            </x-search-filter-bar>
        </div>

        {{-- Results info --}}
        <div id="ev-results-info" class="ev-results-info mb-3">
            @if($postevent->total() > 0)
                Menampilkan
                <strong>{{ $postevent->firstItem() }}–{{ $postevent->lastItem() }}</strong>
                dari <strong>{{ $postevent->total() }}</strong> kegiatan
                @if(request('search'))
                    untuk "<em>{{ request('search') }}</em>"
                @endif
            @else
                Tidak ada kegiatan yang ditemukan
            @endif
        </div>

        {{-- ── Cards Wrap (AJAX target) ─────────────────────── --}}
        <div id="ev-cards-wrap">
            @include('landing-page.event.components._event-cards')
        </div>

    </div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="ev-bs-backdrop" id="ev-bs-backdrop"></div>
<div class="ev-bottom-sheet" id="ev-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Kegiatan">
    <button class="ev-bs-close" id="ev-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="ev-bs-content" id="ev-bs-content">
        {{-- Populated by JS via evOpenBottomSheet() --}}
    </div>
</div>

{{-- Hidden config inputs --}}
<input type="hidden" id="ev-base-url" value="{{ url('/events') }}">
<input type="hidden" id="ev-sort-val" value="{{ request('sort', 'newest') }}">

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.event.components._index-scripts')
@endsection


{{-- ══════════════════════════════════════════════════
     FILTER MODAL — rendered at body level via @push('modals')
     ══════════════════════════════════════════════════ --}}
@push('modals')
<x-search-filter-bar.modal
    prefix="ev"
    title="Filter Kegiatan"
    subtitle="Pilih satu atau lebih filter untuk menyaring kegiatan"
    emoji="🎪"
>
    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-layer-group"></i></div>
                <label for="ev-division-select" class="sfb-fm-label">Divisi / Penyelenggara</label>
            </div>
            <select id="ev-division-select" class="form-select" multiple>
                @foreach($divisions as $div)
                    <option value="{{ $div }}" {{ in_array($div, (array)request('division')) ? 'selected' : '' }}>{{ $div }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="sfb-fm-field-wrap">
            <div class="sfb-fm-field-label">
                <div class="sfb-fm-field-icon"><i class="fas fa-calendar-alt"></i></div>
                <label for="ev-year-select" class="sfb-fm-label">Tahun Kegiatan</label>
            </div>
            <select id="ev-year-select" class="form-select" multiple>
                @foreach($years as $yr)
                    <option value="{{ $yr }}" {{ in_array($yr, (array)request('year')) ? 'selected' : '' }}>{{ $yr }}</option>
                @endforeach
            </select>
        </div>
    </div>
</x-search-filter-bar.modal>
@endpush
