{{-- Library Section - Modern & Elegant --}}
<section class="library-section py-5" id="librarySection">
    <div class="container">
        {{-- Section Header (Right Aligned with Button on Left) --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between library-header-wrap">
            <div class="col-lg-4 text-lg-start d-none d-md-block order-lg-1">
                <a href="/perpustakaan" class="library-btn-view-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-book-open"></i>
                </a>
            </div>
            <div class="col-lg-8 mb-3 mb-lg-0 text-lg-end order-lg-2">
                <div class="library-badge">
                    <span class="library-badge__emoji">📚</span>
                    <span>Perpustakaan</span>
                    <span class="library-badge__pulse"></span>
                </div>
                <h2 class="library-heading">
                    Koleksi <span class="library-heading__highlight">Buku</span>
                </h2>
                <p class="library-subtitle">
                    Temukan berbagai buku menarik untuk menambah wawasan!
                </p>
            </div>
        </div>

        {{-- Desktop Grid Layout --}}
        <div class="d-none d-md-block">
            <div class="library-grid">
                @forelse($postlibrary as $key => $book)
                <div class="library-card library-card-animate" style="--anim-delay: {{ $key * 0.1 }}s">
                    <div class="library-card__img-wrap">
                        <a href="/perpustakaan/buku/{{ $book->slug }}">
                            @if($book->coverImageGdriveID)
                            <img src="https://lh3.googleusercontent.com/d/{{ $book->coverImageGdriveID }}"
                                 alt="{{ $book->titleBook }}"
                                 class="library-card__img"
                                 loading="lazy">
                            @else
                            <div class="library-card__img library-card__img--placeholder">
                                <i class="fas fa-book"></i>
                            </div>
                            @endif
                            <div class="library-card__overlay">
                                <i class="fas fa-eye"></i>
                            </div>
                        </a>
                        @if($book->year)
                        <div class="library-card__year">{{ $book->year }}</div>
                        @endif
                    </div>

                    <div class="library-card__content">
                        <h4 class="library-card__title">
                            <a href="/perpustakaan/buku/{{ $book->slug }}">{{ $book->titleBook }}</a>
                        </h4>
                        <div class="library-card__author">
                            <i class="fas fa-user-edit"></i>
                            <span>{{ $book->authorName }}</span>
                        </div>
                        @if($book->publisherName)
                        <div class="library-card__publisher">
                            <i class="fas fa-building"></i>
                            <span>{{ $book->publisherName }}</span>
                        </div>
                        @endif
                        @if($book->pages)
                        <div class="library-card__pages">
                            <i class="fas fa-file-alt"></i>
                            <span>{{ $book->pages }} halaman</span>
                        </div>
                        @endif
                        <a href="/perpustakaan/buku/{{ $book->slug }}" class="library-card__btn">
                            <span>Lihat Detail</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="library-empty">
                    <div class="library-empty__icon">📚</div>
                    <h4>Belum Ada Koleksi Buku</h4>
                    <p>Koleksi buku akan segera hadir. Pantau terus ya!</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Mobile Carousel --}}
        <div class="d-md-none">
            <div class="owl-carousel library-carousel">
                @forelse($postlibrary as $key => $book)
                <div class="library-card-mobile"
                     data-book-id="{{ $book->bookID }}"
                     data-book-title="{{ $book->titleBook }}"
                     data-book-author="{{ $book->authorName }}"
                     data-book-publisher="{{ $book->publisherName ?? '' }}"
                     data-book-year="{{ $book->year ?? '' }}"
                     data-book-pages="{{ $book->pages ?? '' }}"
                     data-book-img="{{ $book->coverImageGdriveID ? 'https://lh3.googleusercontent.com/d/' . $book->coverImageGdriveID : '' }}"
                     data-book-url="/perpustakaan/buku/{{ $book->slug }}">

                    <div class="library-card-mobile__img-wrap">
                        @if($book->coverImageGdriveID)
                        <img src="https://lh3.googleusercontent.com/d/{{ $book->coverImageGdriveID }}"
                             alt="{{ $book->titleBook }}"
                             class="library-card-mobile__img">
                        @else
                        <div class="library-card-mobile__img library-card-mobile__img--placeholder">
                            <i class="fas fa-book"></i>
                        </div>
                        @endif

                        @if($book->year)
                        <div class="library-card-mobile__year">{{ $book->year }}</div>
                        @endif

                        <div class="library-card-mobile__tap">
                            Tap untuk info! 📖
                        </div>
                    </div>

                    <div class="library-card-mobile__content">
                        <h5 class="library-card-mobile__title">{{ $book->titleBook }}</h5>
                        <div class="library-card-mobile__author">
                            <i class="fas fa-user-edit"></i>
                            {{ $book->authorName }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="library-empty">
                    <div class="library-empty__icon">📚</div>
                    <h4>Belum Ada Koleksi Buku</h4>
                    <p>Koleksi buku akan segera hadir!</p>
                </div>
                @endforelse
            </div>

            @if(count($postlibrary) > 1)
            <div class="library-carousel-dots"></div>
            @endif

            @if(count($postlibrary) > 0)
            <div class="text-center mt-3">
                <a href="/perpustakaan" class="library-btn-all library-btn-all--mobile">
                    <span>Semua Koleksi</span>
                    <i class="fas fa-book-open"></i>
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- Mobile Bottom Sheet --}}
<div class="library-sheet-overlay" id="librarySheetOverlay"></div>
<div class="library-sheet" id="librarySheet">
    <div class="library-sheet__header">
        <div class="library-sheet__handle"></div>
        <button class="library-sheet__close" id="librarySheetClose">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="library-sheet__content">
        <div class="library-sheet__img-wrap">
            <img src="" alt="" class="library-sheet__img" id="librarySheetImg">
            <div class="library-sheet__year" id="librarySheetYear"></div>
        </div>
        <div class="library-sheet__info">
            <h3 class="library-sheet__title" id="librarySheetTitle"></h3>
            <div class="library-sheet__meta">
                <i class="fas fa-user-edit"></i>
                <span id="librarySheetAuthor"></span>
            </div>
            <div class="library-sheet__meta" id="librarySheetPublisherWrap">
                <i class="fas fa-building"></i>
                <span id="librarySheetPublisher"></span>
            </div>
            <div class="library-sheet__meta" id="librarySheetPagesWrap">
                <i class="fas fa-file-alt"></i>
                <span id="librarySheetPages"></span>
            </div>
            <a href="#" class="library-sheet__btn" id="librarySheetBtn">
                <span>Lihat Detail Lengkap</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@include('landing-page.home.partials.library.components._index-styles')
@include('landing-page.home.partials.library.components._index-scripts')
