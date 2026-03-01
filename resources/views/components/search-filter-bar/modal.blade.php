@props([
    'prefix'   => 'sfb',
    'title'    => 'Filter',
    'subtitle' => 'Pilih satu atau lebih filter untuk menyaring hasil',
    'emoji'    => '🔍',
])

<?php /*
    SEARCH-FILTER-BAR  Filter Modal Component
    ================================================================
    Props: prefix, title, subtitle, emoji
    Slot:  page-specific filter fields (sfb-fm-field-wrap, sfb-fm-label, etc.)

    IDs generated (prefix-based):
      {prefix}-fm-backdrop, {prefix}-filter-modal,
      {prefix}-filter-modal-label, {prefix}-reset-filter, {prefix}-apply-filter

    CSS: @include('components.search-filter-bar.modal-styles') in _index-styles
    JS : listen show.bs.modal / hidden.bs.modal on {prefix}-filter-modal
         touch-block selector: .sfb-fm-body

    IMPORTANT: wrap in @push('modals')...@endpush in the calling page.
*/ ?>

{{-- ── Custom blur backdrop (Bootstrap backdrop disabled via data-bs-backdrop="false") ── --}}
<div id="{{ $prefix }}-fm-backdrop" class="sfb-fm-backdrop"></div>

<div class="modal fade sfb-modal" id="{{ $prefix }}-filter-modal" tabindex="-1"
     data-bs-backdrop="false"
     aria-labelledby="{{ $prefix }}-filter-modal-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered sfb-fm-dialog">
        <div class="modal-content sfb-fm-content">

            {{-- Custom close button --}}
            <button type="button" class="sfb-fm-close" data-bs-dismiss="modal" aria-label="Tutup">
                <i class="fas fa-times"></i>
            </button>

            {{-- ── Header ────────────────────────────────────────── --}}
            <div class="sfb-fm-header">
                <div class="sfb-fm-badge">
                    <span>{{ $emoji }}</span>
                    <span>Cari &amp; Saring</span>
                    <span class="sfb-fm-pulse"></span>
                </div>
                <div class="sfb-fm-icon-wrap">
                    <div class="sfb-fm-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div class="sfb-fm-ring sfb-fm-ring-1"></div>
                    <div class="sfb-fm-ring sfb-fm-ring-2"></div>
                </div>
                <h5 class="sfb-fm-title" id="{{ $prefix }}-filter-modal-label">{{ $title }}</h5>
                <p class="sfb-fm-subtitle">{{ $subtitle }}</p>
            </div>

            {{-- ── Body — slot for page-specific filter fields ───── --}}
            <div class="sfb-fm-body">
                <div class="row g-3">
                    {{ $slot }}
                </div>
            </div>

            {{-- ── Footer ────────────────────────────────────────── --}}
            <div class="sfb-fm-footer">
                <button type="button" class="sfb-fm-btn-close" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    <span>Tutup</span>
                </button>
                <button type="button" id="{{ $prefix }}-reset-filter" class="sfb-fm-btn-reset">
                    <i class="fas fa-undo"></i>
                    <span>Reset</span>
                </button>
                <button type="button" id="{{ $prefix }}-apply-filter" class="sfb-fm-btn-apply">
                    <span class="sfb-fm-btn-icon"><i class="fas fa-check"></i></span>
                    <span>Terapkan Filter</span>
                    <div class="sfb-fm-btn-shine"></div>
                </button>
            </div>

        </div>
    </div>
</div>
