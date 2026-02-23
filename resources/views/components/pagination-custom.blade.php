{{-- ================================================================
     Pagination Custom Component
     Usage:
       @include('components.pagination-custom', ['paginator' => $yourPaginator])

     Include styles in @section('styles'):
       @include('components.pagination-custom.styles')
     ================================================================ --}}

@if($paginator->hasPages())
@php
    $cp     = $paginator->currentPage();
    $lp     = $paginator->lastPage();
    $window = 2;
    $show   = [];
    for ($p = 1; $p <= $lp; $p++) {
        if ($p === 1 || $p === $lp || abs($p - $cp) <= $window) $show[] = $p;
    }
    $pItems = [];
    $pv = null;
    foreach ($show as $p) {
        if ($pv !== null && $p - $pv > 1) $pItems[] = null;
        $pItems[] = $p;
        $pv = $p;
    }
@endphp
<div class="pgn-wrap">
    <div class="pgn-info">
        Menampilkan <strong>{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</strong>
        dari <strong>{{ $paginator->total() }}</strong> {{ $itemLabel ?? 'item' }}
    </div>
    <div class="pgn-inner">

        {{-- First --}}
        @if($paginator->onFirstPage())
        <button class="pgn-nav pgn-edge" disabled title="Halaman pertama"><i class="fas fa-angle-double-left"></i></button>
        @else
        <a class="pgn-nav pgn-edge" href="{{ $paginator->url(1) }}" title="Halaman pertama"><i class="fas fa-angle-double-left"></i></a>
        @endif

        {{-- Prev --}}
        @if($paginator->onFirstPage())
        <button class="pgn-nav" disabled title="Sebelumnya"><i class="fas fa-angle-left"></i></button>
        @else
        <a class="pgn-nav" href="{{ $paginator->previousPageUrl() }}" title="Sebelumnya"><i class="fas fa-angle-left"></i></a>
        @endif

        {{-- Page numbers with ellipsis --}}
        <div class="pgn-pages">
            @foreach($pItems as $item)
            @if($item === null)
            <span class="pgn-ellipsis">···</span>
            @elseif($item == $cp)
            <button class="pgn-num active">{{ $item }}</button>
            @else
            <a class="pgn-num" href="{{ $paginator->url($item) }}">{{ $item }}</a>
            @endif
            @endforeach
        </div>

        {{-- Next --}}
        @if($paginator->hasMorePages())
        <a class="pgn-nav" href="{{ $paginator->nextPageUrl() }}" title="Berikutnya"><i class="fas fa-angle-right"></i></a>
        @else
        <button class="pgn-nav" disabled title="Berikutnya"><i class="fas fa-angle-right"></i></button>
        @endif

        {{-- Last --}}
        @if($cp === $lp)
        <button class="pgn-nav pgn-edge" disabled title="Halaman terakhir"><i class="fas fa-angle-double-right"></i></button>
        @else
        <a class="pgn-nav pgn-edge" href="{{ $paginator->url($lp) }}" title="Halaman terakhir"><i class="fas fa-angle-double-right"></i></a>
        @endif

    </div>
</div>
@endif
