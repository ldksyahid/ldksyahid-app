{{-- ===========================================================
     CATALOG BOOK CARDS PARTIAL
     Variables: $books (LengthAwarePaginator)
     =========================================================== --}}

@php
    $categoryColors = [
        1  => '#10b981', // Agama
        2  => '#1e3a8a', // Pendidikan
        3  => '#0284c7', // Sains
        4  => '#92400e', // Sejarah
        5  => '#6d28d9', // Sastra
        6  => '#0369a1', // Teknologi
        7  => '#dc2626', // Kesehatan
        8  => '#7e22ce', // Psikologi
        9  => '#059669', // Ekonomi
        10 => '#1e40af', // Bisnis & Manajemen
        11 => '#2563eb', // Komputer & Informatika
        12 => '#b91c1c', // Hukum
        13 => '#9f1239', // Politik & Pemerintahan
        14 => '#4c1d95', // Filsafat
        15 => '#db2777', // Seni & Desain
        16 => '#2563eb', // Bahasa & Linguistik
        17 => '#9333ea', // Komunikasi & Media
        18 => '#65a30d', // Pertanian
        19 => '#84704d', // Peternakan
        20 => '#57534e', // Teknik Sipil
        21 => '#64748b', // Teknik Mesin
        22 => '#1d4ed8', // Teknik Elektro
        23 => '#475569', // Teknik Industri
        24 => '#d97706', // Teknik Kimia
        25 => '#15803d', // Teknik Lingkungan
        26 => '#1d4ed8', // Matematika
        27 => '#0ea5e9', // Fisika
        28 => '#c2410c', // Kimia
        29 => '#16a34a', // Biologi
        30 => '#4338ca', // Astronomi
        31 => '#15803d', // Geografi
        32 => '#78716c', // Arsitektur
        33 => '#c2410c', // Sosial & Budaya
        34 => '#ea580c', // Keluarga & Parenting
        35 => '#eab308', // Motivasi & Pengembangan Diri
        36 => '#0891b2', // Travel & Pariwisata
        37 => '#f97316', // Kuliner
        38 => '#8b5cf6', // Fiksi
        39 => '#00a79d', // Non-Fiksi
        40 => '#ec4899', // Puisi
        41 => '#7c3aed', // Cerpen
        42 => '#a855f7', // Novel
        43 => '#ef4444', // Komik & Manga
        44 => '#0284c7', // Ensiklopedia
        45 => '#3b82f6', // Majalah & Jurnal
        46 => '#d97706', // Biografi
        47 => '#b45309', // Autobiografi
        48 => '#f59e0b', // Anak-anak
        49 => '#06b6d4', // Remaja
        50 => '#6b7280', // Umum
    ];
@endphp


{{-- ── Desktop Grid (d-none d-lg-block) ────────────────────── --}}
<div class="d-none d-lg-block">
    @if($books->isEmpty())
        <div class="cb-empty-state">
            <div class="cb-empty-visual">
                <div class="cb-empty-deco cb-empty-deco-1"></div>
                <div class="cb-empty-deco cb-empty-deco-2"></div>
                <div class="cb-empty-deco cb-empty-deco-3"></div>
                <div class="cb-empty-ring cb-empty-ring-1"></div>
                <div class="cb-empty-ring cb-empty-ring-2"></div>
                <div class="cb-empty-icon-wrap">
                    <i class="fas fa-book-open"></i>
                    <span class="cb-empty-sparkle cb-empty-sparkle-1">📚</span>
                    <span class="cb-empty-sparkle cb-empty-sparkle-2">✨</span>
                    <span class="cb-empty-sparkle cb-empty-sparkle-3">🔍</span>
                </div>
            </div>
            <h4 class="cb-empty-title">Belum Ada Buku</h4>
            <p class="cb-empty-sub">Coba ubah kata kunci pencarian atau reset filter</p>
        </div>
    @else
        <div class="cb-grid">
            @foreach($books as $book)
            @php
                $catId  = $book->getBookCategory->bookCategoryID ?? 0;
                $spine  = $categoryColors[$catId] ?? '#00a79d';
                $isNew  = \Carbon\Carbon::parse($book->createdDate)->diffInDays(now()) <= 30;
                $isPrem = (($book->authorTypeID == 1 || $book->authorTypeID == 2) && $book->availabilityTypeID == 2);
                $cover  = $book->coverImageUrl()
                    ? $book->coverImageUrl()
                    : 'https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';
            @endphp
            <div class="cb-book-card wow fadeInUp" style="--cb-spine: {{ $spine }}"
                 data-wow-delay="0.{{ ($loop->index % 4 + 1) }}s">

                {{-- Horizontal body: cover left + content right --}}
                <div class="cb-card-body">

                    {{-- ── Cover Column ──────────────────────────── --}}
                    <div class="cb-card-cover-col">
                        <a href="{{ route('catalog.books.show', $book->slug) }}" class="cb-card-cover-link">
                            <img src="{{ $cover }}"
                                 alt="{{ $book->titleBook }}"
                                 class="cb-card-cover-img"
                                 loading="lazy">
                            @if($isPrem)
                            <span class="cb-prem-badge" title="Premium">
                                <i class="fas fa-crown"></i>
                            </span>
                            @endif
                            @if($isNew)
                            <span class="cb-new-badge">Baru</span>
                            @endif
                        </a>
                        {{-- Decoration below cover --}}
                        <div class="cb-cover-deco">
                            <span class="cb-cd-sp cb-cd-sp1">✦</span>
                            <span class="cb-cd-sp cb-cd-sp2">✦</span>
                            <span class="cb-cd-sp cb-cd-sp3">◆</span>
                            <span class="cb-cd-sp cb-cd-sp4">✦</span>
                            <i class="fas fa-book-open cb-cd-icon"></i>
                        </div>
                    </div>

                    {{-- ── Content Column ────────────────────────── --}}
                    <div class="cb-card-content">

                        {{-- Title + meta row --}}
                        <div class="cb-card-header">
                            <h3 class="cb-card-title">
                                <a href="{{ route('catalog.books.show', $book->slug) }}">{{ $book->titleBook }}</a>
                            </h3>
                            <div class="cb-card-meta-row">
                                @if($book->createdDate)
                                <span class="cb-meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($book->createdDate)->format('d M Y') }}
                                </span>
                                @endif
                                <span class="cb-meta-item cb-meta-likes">
                                    <i class="fas fa-heart"></i>
                                    {{ $book->favoriteCount ?? 0 }}
                                </span>
                                @if($book->getBookCategory)
                                <span class="cb-cat-badge" style="background: {{ $spine }}">
                                    {{ $book->getBookCategory->bookCategoryName }}
                                </span>
                                @endif
                            </div>
                        </div>

                        {{-- Tabs: Spesifikasi | Sinopsis --}}
                        <div class="cb-card-tabs">
                            <div class="cb-tabs-nav">
                                <button class="cb-tab active"
                                        data-target="cb-spec-{{ $loop->index }}">Spesifikasi</button>
                                <button class="cb-tab"
                                        data-target="cb-syn-{{ $loop->index }}">Sinopsis</button>
                            </div>

                            {{-- Spesifikasi pane --}}
                            <div class="cb-tab-pane active" id="cb-spec-{{ $loop->index }}">
                                <div class="cb-specs">
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">Judul</span>
                                        <span class="cb-spec-value">{{ Str::limit($book->titleBook, 60) }}</span>
                                    </div>
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">Penulis</span>
                                        <span class="cb-spec-value">{{ $book->authorName }}</span>
                                    </div>
                                    @if($book->publisherName)
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">Penerbit</span>
                                        <span class="cb-spec-value">{{ $book->publisherName }}</span>
                                    </div>
                                    @endif
                                    @if($book->year)
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">Tahun Terbit</span>
                                        <span class="cb-spec-value">{{ $book->year }}</span>
                                    </div>
                                    @endif
                                    @if($book->edition)
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">Edisi</span>
                                        <span class="cb-spec-value">{{ $book->edition }}</span>
                                    </div>
                                    @endif
                                    @if($book->isbn)
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">ISBN</span>
                                        <span class="cb-spec-value">{{ $book->isbn }}</span>
                                    </div>
                                    @endif
                                    @if($book->getLanguage)
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">Bahasa</span>
                                        <span class="cb-spec-value">{{ $book->getLanguage->languageName }}</span>
                                    </div>
                                    @endif
                                    @if($book->pages)
                                    <div class="cb-spec-row">
                                        <span class="cb-spec-label">Jumlah Halaman</span>
                                        <span class="cb-spec-value">{{ $book->pages }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Sinopsis pane --}}
                            <div class="cb-tab-pane" id="cb-syn-{{ $loop->index }}">
                                <p class="cb-synopsis-text">
                                    {{ $book->synopsis
                                        ? Str::limit($book->synopsis, 230)
                                        : ($book->description
                                            ? Str::limit($book->description, 230)
                                            : 'Tidak ada sinopsis tersedia untuk buku ini.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="cb-card-actions">
                            <a href="{{ route('catalog.books.show', $book->slug) }}" class="cb-btn-detail">
                                <span>Lihat Detail</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <div class="cb-card-share-group">
                                <button class="cb-share-icon-btn cb-share-copy"
                                        onclick="cbCopyUrl('{{ route('catalog.books.show', $book->slug) }}', event)"
                                        title="Salin URL">
                                    <i class="fas fa-link"></i>
                                </button>
                                <button class="cb-share-icon-btn cb-share-wa"
                                        onclick="cbShareWa('{{ route('catalog.books.show', $book->slug) }}', '{{ e($book->titleBook) }}', event)"
                                        title="Bagikan via WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </button>
                            </div>
                        </div>

                    </div>{{-- /cb-card-content --}}
                </div>{{-- /cb-card-body --}}
            </div>{{-- /cb-book-card --}}
            @endforeach
        </div>{{-- /cb-grid --}}
    @endif
</div>{{-- /d-none d-lg-block --}}


{{-- ── Mobile Carousel (d-lg-none) ─────────────────────────── --}}
<div class="d-lg-none">
    @if($books->isEmpty())
        <div class="cb-empty-state">
            <div class="cb-empty-visual">
                <div class="cb-empty-ring cb-empty-ring-1"></div>
                <div class="cb-empty-ring cb-empty-ring-2"></div>
                <div class="cb-empty-icon-wrap">
                    <i class="fas fa-book-open"></i>
                    <span class="cb-empty-sparkle cb-empty-sparkle-1">📚</span>
                    <span class="cb-empty-sparkle cb-empty-sparkle-2">✨</span>
                </div>
            </div>
            <h4 class="cb-empty-title">Belum Ada Buku</h4>
            <p class="cb-empty-sub">Coba ubah kata kunci atau reset filter</p>
        </div>
    @else
        <div class="cb-mobile-carousel" id="cb-mobile-carousel">
            @foreach($books as $book)
            @php
                $catId  = $book->getBookCategory->bookCategoryID ?? 0;
                $spine  = $categoryColors[$catId] ?? '#00a79d';
                $isNew  = \Carbon\Carbon::parse($book->createdDate)->diffInDays(now()) <= 30;
                $isPrem = (($book->authorTypeID == 1 || $book->authorTypeID == 2) && $book->availabilityTypeID == 2);
                $cover  = $book->coverImageUrl()
                    ? $book->coverImageUrl()
                    : 'https://lh3.googleusercontent.com/d/11uThObxFLEhUURq0ggI5ncJDdlPYkKyd';
            @endphp
            <div class="cb-mobile-card"
                 data-title="{{ e($book->titleBook) }}"
                 data-author="{{ e($book->authorName ?? '') }}"
                 data-author-type="{{ e($book->getAuthorType->authorTypeName ?? '') }}"
                 data-publisher="{{ e($book->publisherName ?? '') }}"
                 data-year="{{ $book->year ?? '' }}"
                 data-edition="{{ e($book->edition ?? '') }}"
                 data-isbn="{{ e($book->isbn ?? '') }}"
                 data-pages="{{ $book->pages ?? '' }}"
                 data-likes="{{ $book->favoriteCount ?? 0 }}"
                 data-date="{{ $book->createdDate ? \Carbon\Carbon::parse($book->createdDate)->format('d M Y') : '' }}"
                 data-category="{{ e($book->getBookCategory->bookCategoryName ?? '') }}"
                 data-language="{{ e($book->getLanguage->languageName ?? '') }}"
                 data-availability="{{ e($book->getAvailabilityType->availabilityTypeName ?? '') }}"
                 data-synopsis="{{ e($book->synopsis ? Str::limit($book->synopsis, 600) : ($book->description ? Str::limit($book->description, 600) : '')) }}"
                 data-cover="{{ $cover }}"
                 data-url="{{ route('catalog.books.show', $book->slug) }}"
                 data-spine="{{ $spine }}"
                 data-prem="{{ $isPrem ? '1' : '0' }}"
                 data-new="{{ $isNew ? '1' : '0' }}"
                 onclick="cbOpenBottomSheet(this)">

                <div class="cb-m-cover-wrap" style="--cb-spine: {{ $spine }}">
                    <img src="{{ $cover }}"
                         alt="{{ $book->titleBook }}"
                         class="cb-m-cover-img"
                         loading="lazy">
                    <div class="cb-m-cover-overlay"></div>

                    @if($book->getBookCategory)
                    <span class="cb-m-cat-badge" style="background: {{ $spine }};">
                        {{ $book->getBookCategory->bookCategoryName }}
                    </span>
                    @endif

                    @if($isNew)
                    <span class="cb-m-new-badge">Baru</span>
                    @endif

                    @if($isPrem)
                    <span class="cb-m-prem-badge"><i class="fas fa-crown"></i></span>
                    @endif
                </div>

                <div class="cb-m-info">
                    <h4 class="cb-m-title">{{ Str::limit($book->titleBook, 45) }}</h4>
                    <p class="cb-m-author">{{ $book->authorName }}</p>
                    <span class="cb-m-hint"><i class="fas fa-hand-pointer"></i> Lihat detail</span>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Carousel Dots --}}
        <div class="cb-carousel-dots" id="cb-carousel-dots"></div>
    @endif
</div>{{-- /d-lg-none --}}


{{-- ── Pagination ─────────────────────────────────────────── --}}
<div class="cb-pagination-wrap mt-4">
    @include('components.pagination-custom.index', [
        'paginator' => $books,
        'itemLabel' => 'buku',
    ])
</div>
