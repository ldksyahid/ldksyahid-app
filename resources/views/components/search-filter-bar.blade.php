@props([
    'prefix'        => 'sfb',
    'placeholder'   => 'Cari…',
    'searchValue'   => '',
    'filterModalId' => null,
    'sortOptions'   => [],
    'currentSort'   => '',
])

{{-- ================================================================
     SEARCH-FILTER-BAR  Component
     ================================================================
     Usage:

       @include('components.search-filter-bar.styles')  <- in styles section

       <x-search-filter-bar
           prefix="ar"
           placeholder="Cari artikel..."
           :search-value="request('search')"
           filter-modal-id="ar-filter-modal"
           :sort-options="[
               ['value' => 'newest', 'label' => 'Terbaru',   'icon' => 'far fa-clock'],
               ['value' => 'title',  'label' => 'Judul A-Z', 'icon' => 'fas fa-sort-alpha-down'],
           ]"
           :current-sort="request('sort', 'newest')"
       >
           (slot: server-rendered sfb-pill spans go here)
       </x-search-filter-bar>

     IDs generated (all prefixed with $prefix):
       {prefix}-search-input   search input
       {prefix}-search-clear   clear button
       {prefix}-filter-count   badge on filter button
       {prefix}-sort-val       hidden input for current sort value
       {prefix}-active-pills   container for pill slot

     Sort items emit: data-sort="{value}"  data-sort-prefix="{prefix}"

     Include styles in @section('styles'):
       @include('components.search-filter-bar.styles')
     ================================================================ --}}

{{-- ── Search + Filter + Sort row ────────────────────────────── --}}
<div class="sfb-wrap">

    {{-- Search field --}}
    <div class="sfb-field">
        <i class="fas fa-search sfb-search-icon"></i>
        <input  type="text"
                id="{{ $prefix }}-search-input"
                class="sfb-input"
                placeholder="{{ $placeholder }}"
                value="{{ $searchValue }}"
                autocomplete="off">
        <button id="{{ $prefix }}-search-clear"
                class="sfb-clear"
                aria-label="Hapus pencarian"
                style="display: {{ $searchValue ? 'block' : 'none' }};">
            &times;
        </button>
    </div>

    {{-- Filter button (only when filterModalId is provided) --}}
    @if($filterModalId)
    <button type="button"
            class="sfb-filter-btn"
            data-bs-toggle="modal"
            data-bs-target="#{{ $filterModalId }}"
            aria-label="Buka filter">
        <i class="fas fa-sliders-h"></i>
        <span>Filter</span>
        <span id="{{ $prefix }}-filter-count" class="sfb-badge" style="display:none;">0</span>
    </button>
    @endif

    {{-- Sort dropdown (only when sortOptions is not empty) --}}
    @if(!empty($sortOptions))
    <div class="dropdown">
        <button class="sfb-sort-btn dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            <i class="fas fa-sort me-1"></i>Urutkan
        </button>
        <ul class="dropdown-menu" style="z-index:1060; min-width:180px;">
            @foreach($sortOptions as $option)
            <li>
                <a  class="dropdown-item {{ $currentSort == $option['value'] ? 'active' : '' }}"
                    href="#"
                    data-sort="{{ $option['value'] }}"
                    data-sort-prefix="{{ $prefix }}">
                    <i class="{{ $option['icon'] ?? 'fas fa-sort' }} me-2"></i>
                    {{ $option['label'] }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Hidden: current sort value (read by page-specific JS) --}}
    <input type="hidden" id="{{ $prefix }}-sort-val" value="{{ $currentSort }}">

</div>{{-- /sfb-wrap --}}

{{-- ── Active filter pills container ─────────────────────────── --}}
<div id="{{ $prefix }}-active-pills" class="sfb-pills mt-2">
    {{ $slot }}
</div>
