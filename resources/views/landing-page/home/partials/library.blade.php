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

<style>
/* ═══════════════════════════════════════════════
   LIBRARY SECTION — Modern & Elegant
   ═══════════════════════════════════════════════ */
.library-section {
    background: transparent;
    position: relative;
}

/* ── Header ── */
.library-header-wrap {
    margin-bottom: 0;
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.library-header-wrap.is-visible {
    opacity: 1;
    transform: translateY(0);
}

.library-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border: 1px solid rgba(0, 167, 157, 0.2);
    border-radius: var(--radius-pill);
    padding: 0.5rem 1.25rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--primary);
}

.library-badge__emoji { font-size: 1.1rem; }

.library-badge__pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: libPulse 2s ease-in-out infinite;
}

@keyframes libPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.5); }
}

.library-heading {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.library-heading__highlight {
    color: var(--primary);
    position: relative;
}

.library-heading__highlight::after {
    content: '';
    position: absolute;
    bottom: 2px;
    left: 0;
    width: 100%;
    height: 8px;
    background: rgba(0, 167, 157, 0.15);
    border-radius: 4px;
    z-index: -1;
}

.library-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

/* ── Header Button ── */
.library-btn-view-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 0.9rem 2rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: var(--transition);
    border: 2px solid rgba(0, 167, 157, 0.2);
    white-space: nowrap;
}

.library-btn-view-all:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow-primary);
    border-color: transparent;
}

.library-btn-view-all i {
    transition: transform 0.3s ease;
}

.library-btn-view-all:hover i {
    transform: translateX(5px);
}

/* ── Animations ── */
.library-card-animate {
    opacity: 0;
    transform: translateY(40px) scale(0.97);
    transition: opacity 0.6s ease var(--anim-delay, 0s),
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) var(--anim-delay, 0s);
}

.library-card-animate.is-visible {
    opacity: 1;
    transform: translateY(0) scale(1);
}

/* ── Grid ── */
.library-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.75rem;
}

/* ═══════════════════════════════════════════════
   LIBRARY CARD — Modern Book Card
   ═══════════════════════════════════════════════ */
.library-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    border: 1px solid rgba(0, 0, 0, 0.04);
}

.library-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
    border-color: transparent;
}

/* ── Image ── */
.library-card__img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 3/4;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.library-card__img-wrap a {
    display: block;
    width: 100%;
    height: 100%;
}

.library-card__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.library-card__img--placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    color: rgba(0, 167, 157, 0.3);
}

.library-card:hover .library-card__img {
    transform: scale(1.05);
}

.library-card__overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(0, 167, 157, 0.8) 0%, rgba(0, 167, 157, 0.6) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.library-card:hover .library-card__overlay {
    opacity: 1;
}

.library-card__overlay i {
    color: white;
    font-size: 2rem;
    animation: libEyePulse 2s ease-in-out infinite;
}

@keyframes libEyePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

.library-card__year {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    color: white;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 2;
}

/* ── Content ── */
.library-card__content {
    flex: 1;
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
}

.library-card__title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 0.95rem;
    line-height: 1.4;
    margin-bottom: 0.75rem;
    min-height: 2.8rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.library-card__title a {
    color: var(--dark);
    text-decoration: none;
    background-image: linear-gradient(var(--primary), var(--primary));
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: left bottom;
    transition: background-size 0.35s ease, color 0.3s ease;
    padding-bottom: 2px;
}

.library-card:hover .library-card__title a {
    background-size: 100% 2px;
    color: var(--primary);
}

.library-card__author,
.library-card__publisher,
.library-card__pages {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    font-size: 0.8rem;
    margin-bottom: 0.5rem;
}

.library-card__author i,
.library-card__publisher i,
.library-card__pages i {
    color: var(--primary);
    font-size: 0.75rem;
}

.library-card__btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: white;
    background: var(--primary-gradient);
    font-weight: 700;
    font-size: 0.82rem;
    text-decoration: none;
    padding: 11px 22px;
    border-radius: 50px;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    width: fit-content;
    margin-top: auto;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
}

.library-card:hover .library-card__btn {
    transform: scale(1.05);
    color: white;
    box-shadow: 0 6px 20px rgba(0, 167, 157, 0.5);
}

.library-card__btn i {
    font-size: 0.7rem;
}

/* ═══════════════════════════════════════════════
   MOBILE CARD
   ═══════════════════════════════════════════════ */
.library-card-mobile {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    position: relative;
}

.library-card-mobile__img-wrap {
    position: relative;
    width: 100%;
    aspect-ratio: 3/4;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.library-card-mobile__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
}

.library-card-mobile__img--placeholder {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: rgba(0, 167, 157, 0.3);
}

.library-card-mobile__year {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    color: white;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 2;
}

.library-card-mobile__tap {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(6px);
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--dark);
    z-index: 2;
    animation: libTapPulse 2.5s ease-in-out infinite;
}

@keyframes libTapPulse {
    0%, 100% { opacity: 0.9; }
    50% { opacity: 0.5; }
}

.library-card-mobile__content {
    padding: 1rem;
    background: white;
}

.library-card-mobile__title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 0.95rem;
    line-height: 1.4;
    color: var(--dark);
    margin: 0 0 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.library-card-mobile__author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    font-size: 0.8rem;
}

.library-card-mobile__author i {
    color: var(--primary);
    font-size: 0.75rem;
}

/* ── View All Button ── */
.library-btn-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 1rem 2.5rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    text-decoration: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: var(--transition);
    border: 2px solid rgba(0, 167, 157, 0.2);
}

.library-btn-all:hover {
    background: var(--primary-gradient);
    color: white;
    transform: translateY(-3px);
    box-shadow: var(--shadow-primary);
    border-color: transparent;
}

.library-btn-all i { transition: transform 0.3s ease; }
.library-btn-all:hover i { transform: translateX(5px); }

.library-btn-all--mobile {
    width: 100%;
    justify-content: center;
}

/* ── Empty ── */
.library-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 5rem 2rem;
    background: white;
    border-radius: 24px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.06);
}

.library-empty__icon { font-size: 4rem; margin-bottom: 1.5rem; }
.library-empty h4 { color: var(--dark); margin-bottom: 0.5rem; }
.library-empty p { color: var(--secondary); margin-bottom: 0; }

/* ═══════════════════════════════════════════════
   CAROUSEL
   ═══════════════════════════════════════════════ */
.library-carousel.owl-carousel .owl-stage-outer {
    padding: 8px 0 16px;
    overflow: hidden;
}

.library-carousel.owl-carousel .owl-stage {
    display: flex !important;
}

.library-carousel.owl-carousel .owl-item {
    float: none !important;
    display: flex;
}

.library-carousel .library-card-mobile {
    width: 100%;
}

.library-carousel-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 1.5rem;
}

.library-carousel-dots .library-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 167, 157, 0.2);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.library-carousel-dots .library-dot.active {
    width: 32px;
    border-radius: 4px;
    background: var(--primary);
}

.library-carousel .owl-dots,
.library-carousel .owl-nav {
    display: none !important;
}

/* ═══════════════════════════════════════════════
   BOTTOM SHEET
   ═══════════════════════════════════════════════ */
.library-sheet-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.library-sheet-overlay.active {
    opacity: 1;
    visibility: visible;
}

.library-sheet {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 10001;
    max-height: 90vh;
    overflow-y: auto;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.library-sheet.active {
    transform: translateY(0);
}

.library-sheet__header {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px;
    z-index: 10;
    background: transparent;
}

.library-sheet__handle {
    width: 40px;
    height: 4px;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 2px;
}

.library-sheet__close {
    position: absolute;
    right: 16px;
    top: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: white;
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
}

.library-sheet__close:hover {
    background: var(--primary);
    color: white;
}

.library-sheet__content {
    padding: 2.5rem 0 2rem;
}

.library-sheet__img-wrap {
    position: relative;
    width: 60%;
    max-width: 250px;
    margin: 0 auto 1.5rem;
    aspect-ratio: 3/4;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
}

.library-sheet__img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top center;
}

.library-sheet__year {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    color: white;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 2;
}

.library-sheet__info {
    padding: 0 1.5rem;
}

.library-sheet__title {
    font-family: var(--font-primary);
    font-weight: 800;
    font-size: 1.3rem;
    color: var(--dark);
    line-height: 1.4;
    margin: 0 0 1rem;
    text-align: center;
}

.library-sheet__meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--secondary);
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 0.75rem;
    justify-content: center;
}

.library-sheet__meta i {
    color: var(--primary);
}

.library-sheet__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    padding: 1.1rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(0, 167, 157, 0.35);
    transition: var(--transition);
    margin-top: 1.5rem;
}

.library-sheet__btn:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0, 167, 157, 0.45);
}

body.library-sheet-open {
    overflow: hidden !important;
}

body.library-sheet-open .back-to-top {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */
@media (max-width: 1199.98px) {
    .library-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }
}

@media (max-width: 991.98px) {
    .library-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .library-heading { font-size: 1.6rem; }
}

@media (max-width: 767.98px) {
    .library-heading { font-size: 1.4rem; }
}

@media (min-width: 768px) {
    .library-sheet {
        max-width: 500px;
        left: 50%;
        transform: translate(-50%, 100%);
    }

    .library-sheet.active {
        transform: translate(-50%, 0);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Viewport animations
    var animEls = document.querySelectorAll('.library-header-wrap, .library-card-animate');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) {
                    e.target.classList.add('is-visible');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.15 });
        animEls.forEach(function(el) { obs.observe(el); });
    } else {
        animEls.forEach(function(el) { el.classList.add('is-visible'); });
    }

    // Carousel
    var $carousel = jQuery('.library-carousel');
    if ($carousel.length) {
        $carousel.owlCarousel({
            items: 1,
            margin: 14,
            stagePadding: 24,
            loop: false,
            dots: false,
            nav: false,
            autoplay: false,
            smartSpeed: 350,
            touchDrag: true,
            mouseDrag: true,
        });

        var $dots = jQuery('.library-carousel-dots');
        var count = $carousel.find('.owl-item:not(.cloned)').length;
        if (count > 1 && $dots.length) {
            for (var i = 0; i < count; i++) {
                var $d = jQuery('<button class="library-dot" aria-label="Slide ' + (i + 1) + '"></button>');
                if (i === 0) $d.addClass('active');
                $d.data('index', i);
                $dots.append($d);
            }
            $dots.on('click', '.library-dot', function() {
                $carousel.trigger('to.owl.carousel', [jQuery(this).data('index'), 300]);
            });
            $carousel.on('changed.owl.carousel', function(e) {
                $dots.find('.library-dot').removeClass('active').eq(e.item.index).addClass('active');
            });
        }
    }

    // Bottom Sheet
    var $overlay = jQuery('#librarySheetOverlay');
    var $sheet = jQuery('#librarySheet');
    var $body = jQuery('body');

    function openSheet(d) {
        if (d.img) {
            jQuery('#librarySheetImg').attr('src', d.img).attr('alt', d.title);
        }
        if (d.year) {
            jQuery('#librarySheetYear').text(d.year).show();
        } else {
            jQuery('#librarySheetYear').hide();
        }
        jQuery('#librarySheetTitle').text(d.title);
        jQuery('#librarySheetAuthor').text(d.author);

        if (d.publisher) {
            jQuery('#librarySheetPublisher').text(d.publisher);
            jQuery('#librarySheetPublisherWrap').show();
        } else {
            jQuery('#librarySheetPublisherWrap').hide();
        }

        if (d.pages) {
            jQuery('#librarySheetPages').text(d.pages + ' halaman');
            jQuery('#librarySheetPagesWrap').show();
        } else {
            jQuery('#librarySheetPagesWrap').hide();
        }

        jQuery('#librarySheetBtn').attr('href', d.url);

        $body.addClass('library-sheet-open');
        $overlay.addClass('active');
        setTimeout(function() { $sheet.addClass('active'); }, 10);
        $sheet[0].scrollTop = 0;
    }

    function closeSheet() {
        $sheet.removeClass('active');
        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('library-sheet-open');
            if (jQuery(window).scrollTop() > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    jQuery(document).on('click', '.library-card-mobile', function(e) {
        e.preventDefault();
        var $el = jQuery(this);
        openSheet({
            title: $el.data('book-title'),
            author: $el.data('book-author'),
            publisher: $el.data('book-publisher'),
            year: $el.data('book-year'),
            pages: $el.data('book-pages'),
            img: $el.data('book-img'),
            url: $el.data('book-url')
        });
    });

    jQuery('#librarySheetClose').on('click', closeSheet);
    $overlay.on('click', closeSheet);
    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) closeSheet();
    });

    // Swipe down
    var startY = 0, currentY = 0, el = $sheet[0];
    if (el) {
        el.addEventListener('touchstart', function(e) {
            startY = this.scrollTop <= 0 ? e.touches[0].clientY : 0;
        }, { passive: true });
        el.addEventListener('touchmove', function(e) {
            if (!startY) return;
            currentY = e.touches[0].clientY;
            var diff = currentY - startY;
            if (diff > 0 && this.scrollTop <= 0) {
                var val = Math.min(diff * 0.6, 200);
                this.style.transform = window.innerWidth >= 768 ?
                    'translate(-50%, ' + val + 'px)' : 'translateY(' + val + 'px)';
            }
        }, { passive: true });
        el.addEventListener('touchend', function() {
            if (currentY - startY > 80) closeSheet();
            var self = this;
            setTimeout(function() { self.style.transform = ''; }, 380);
            startY = 0;
            currentY = 0;
        }, { passive: true });
    }
});
</script>
