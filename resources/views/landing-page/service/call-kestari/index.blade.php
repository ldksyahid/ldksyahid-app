@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.call-kestari.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="ck-page-section wow fadeIn" data-wow-delay="0.05s" id="ck-main-section">
    <div class="container">

        {{-- ── Section Header ──────────────────────────────────── --}}
        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.12s">
            <div class="ck-section-badge">
                <span>📞</span>
                <span>Layanan</span>
                <span class="ck-badge-pulse"></span>
            </div>
            <h1 class="ck-section-title mt-3">Call Kestari</h1>
            <p class="ck-section-sub">
                Tautan panggilan untuk komunikasi dan informasi Kesekretariatan LDK Syahid.
                Hubungi kami melalui berbagai saluran yang tersedia di bawah ini.
            </p>
        </div>


        {{-- ── Search + Sort Bar ───────────────────────────────── --}}
        <div class="mb-3 wow fadeInUp" data-wow-delay="0.15s">
            <x-search-filter-bar
                prefix="ck"
                placeholder="Cari tautan berdasarkan nama…"
                :search-value="request('search')"
                :sort-options="[
                    ['value' => 'newest', 'label' => 'Terbaru',   'icon' => 'far fa-clock'],
                    ['value' => 'az',     'label' => 'Nama A–Z',  'icon' => 'fas fa-sort-alpha-down'],
                    ['value' => 'za',     'label' => 'Nama Z–A',  'icon' => 'fas fa-sort-alpha-up'],
                ]"
                :current-sort="request('sort', 'newest')"
            >
            </x-search-filter-bar>
        </div>

        {{-- Results info --}}
        <div id="ck-results-info" class="ck-results-info mb-3">
            @if($data->total() > 0)
                Menampilkan
                <strong>{{ $data->firstItem() }}–{{ $data->lastItem() }}</strong>
                dari <strong>{{ $data->total() }}</strong> tautan
                @if(request('search'))
                    untuk "<em>{{ request('search') }}</em>"
                @endif
            @else
                Tidak ada tautan yang ditemukan
            @endif
        </div>


        {{-- ── Cards Wrap (AJAX target) ───────────────────────── --}}
        <div id="ck-cards-wrap">
            @include('landing-page.service.call-kestari.components._ck-cards')
        </div>

        {{-- ── Pagination ──────────────────────────────────────── --}}
        <div class="ck-pagination-wrap" id="ck-pagination-wrap">
            @include('components.pagination-custom.index', [
                'paginator' => $data,
                'itemLabel' => 'tautan',
            ])
        </div>

    </div>{{-- /container --}}
</section>


{{-- ══════════════════════════════════════════════════
     MOBILE BOTTOM SHEET
     ══════════════════════════════════════════════════ --}}
<div class="ck-bs-backdrop" id="ck-bs-backdrop"></div>
<div class="ck-bottom-sheet" id="ck-bottom-sheet"
     role="dialog" aria-modal="true" aria-label="Detail Tautan">
    <button class="ck-bs-close" id="ck-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="ck-bs-content" id="ck-bs-content">
        {{-- Populated by JS via ckOpenSheet() --}}
    </div>
</div>

{{-- Hidden config (read by JS) --}}
<input type="hidden" id="ck-base-url" value="{{ url('/callkestari') }}">

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.call-kestari.components._index-scripts')
@endsection
