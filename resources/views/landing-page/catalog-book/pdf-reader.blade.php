@extends('landing-page.template.body')

@php
    $categoryColors = [
        1=>'#10b981',  2=>'#1e3a8a',  3=>'#0284c7',  4=>'#92400e',  5=>'#6d28d9',
        6=>'#0369a1',  7=>'#dc2626',  8=>'#7e22ce',  9=>'#059669',  10=>'#1e40af',
        11=>'#b45309', 12=>'#0f766e', 13=>'#c2410c', 14=>'#4f46e5', 15=>'#0891b2',
        16=>'#9333ea', 17=>'#16a34a', 18=>'#d97706', 19=>'#2563eb', 20=>'#db2777',
        21=>'#7c3aed', 22=>'#0d9488', 23=>'#ea580c', 24=>'#6366f1', 25=>'#0369a1',
        26=>'#be123c', 27=>'#047857', 28=>'#92400e', 29=>'#7c3aed', 30=>'#0f766e',
        31=>'#b91c1c', 32=>'#1d4ed8', 33=>'#065f46', 34=>'#4338ca', 35=>'#0369a1',
        36=>'#9d174d', 37=>'#064e3b', 38=>'#1e1b4b', 39=>'#7f1d1d', 40=>'#134e4a',
        41=>'#1c1917', 42=>'#3b0764', 43=>'#450a0a', 44=>'#052e16', 45=>'#0c4a6e',
        46=>'#4a1942', 47=>'#172554', 48=>'#f59e0b', 49=>'#06b6d4', 50=>'#6b7280',
    ];
    $catId  = $book->getBookCategory->bookCategoryID ?? 0;
    $accent = $categoryColors[$catId] ?? '#00bfa6';
@endphp

@section('content')
<div class="container-xxl py-5 mt-5" style="--bd-accent: {{ $accent }}">

    {{-- Book Info Header --}}
    <div class="pr-header wow fadeIn" data-wow-delay="0.05s">

        {{-- Cover --}}
        <div class="pr-cover">
            @if($book->coverImageUrl())
                <img src="{{ $book->coverImageUrl() }}" alt="{{ $book->titleBook }}" class="pr-cover-img">
            @else
                <div class="pr-cover-placeholder">
                    <i class="fas fa-book-open"></i>
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="pr-info">
            <div class="pr-cat-badge">
                <i class="fas fa-tag"></i>
                {{ $book->getBookCategory->bookCategoryName ?? 'Umum' }}
            </div>
            <h1 class="pr-title">{{ $book->titleBook }}</h1>
            <p class="pr-author">
                <i class="fas fa-pen-nib me-2"></i>{{ $book->authorName }}
                <span class="pr-author-type">· {{ $book->getAuthorType->authorTypeName ?? 'Penulis' }}</span>
            </p>
            <div class="pr-meta-bar">
                <span class="pr-meta-item">
                    <i class="fas fa-building"></i>{{ $book->publisherName }}
                </span>
                <span class="pr-meta-item">
                    <i class="fas fa-calendar-alt"></i>{{ $book->year }}
                </span>
                <span class="pr-meta-item">
                    <i class="fas fa-file-alt"></i>{{ $book->pages ?? 0 }} halaman
                </span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="pr-actions">
            <a href="{{ route('catalog.books.show', $book->slug) }}" class="pr-btn pr-btn-back">
                <i class="fas fa-arrow-left"></i>Detail Buku
            </a>
            <button class="pr-btn pr-btn-full" id="fullscreen-btn">
                <i class="fas fa-expand"></i>Layar Penuh
            </button>
        </div>

    </div>

    {{-- Reader Frame --}}
    <div class="pr-frame-wrap wow fadeIn" data-wow-delay="0.1s">
        <div class="pr-reader-bar">
            <div class="pr-reader-dots">
                <span class="pr-rd pr-rd-r"></span>
                <span class="pr-rd pr-rd-y"></span>
                <span class="pr-rd pr-rd-g"></span>
            </div>
            <div class="pr-reader-url-pill">
                <i class="fas fa-lock"></i>
                <span>anyflip.com</span>
            </div>
            <a href="{{ $book->getReaderLink() }}" target="_blank" class="pr-reader-open" title="Buka di tab baru">
                <i class="fas fa-external-link-alt"></i>
            </a>
        </div>
        <div class="pr-reader-body">
            <iframe
                src="{{ $book->getFormattedReaderLink() }}"
                class="pr-frame"
                id="reader-frame"
                allowfullscreen
                loading="lazy"
            ></iframe>
        </div>
    </div>

    {{-- Controls --}}
    <div class="pr-controls wow fadeIn" data-wow-delay="0.15s">
        <div class="pr-controls-left">
            <button class="pr-ctrl-btn" onclick="reloadReader()" title="Muat Ulang">
                <i class="fas fa-redo"></i>
            </button>
            <button class="pr-ctrl-btn" onclick="openInNewTab()" title="Buka di Tab Baru">
                <i class="fas fa-external-link-alt"></i>
            </button>
            <button class="pr-ctrl-btn" id="fullscreen-control" title="Layar Penuh">
                <i class="fas fa-expand"></i>
            </button>
        </div>
        <div class="pr-controls-right">
            <span class="pr-status" id="pr-status">Memuat buku…</span>
        </div>
    </div>

</div>
@endsection

@section('styles')
    @include('landing-page.catalog-book.components._pdf-reader._pdf-reader-styles')
@endsection

@section('scripts')
    @include('landing-page.catalog-book.components._pdf-reader._pdf-reader-scripts')
@endsection
