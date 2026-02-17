{{-- Article Section - Revamped Clean & Modern --}}
<section class="article-section py-5" id="articleSection">
    <div class="container">
        {{-- Section Header --}}
        <div class="row mb-4 mb-lg-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.1s">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="art-badge">
                    <span class="art-badge__emoji">📝</span>
                    <span>Artikel</span>
                    <span class="art-badge__pulse"></span>
                </div>
                <h2 class="art-heading">
                    Karya Tulis <span class="art-heading__highlight">Kita</span>
                    <span class="art-heading__sparkle">✨</span>
                </h2>
                <p class="art-subtitle">
                    Hasil tulisan penuh semangat dari para anggota LDK Syahid. Yuk baca! 📚
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="/articles" class="art-btn-all">
                    <span>Lihat Semua</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Desktop Grid (hidden on mobile) --}}
        <div class="art-grid d-none d-md-grid wow fadeInUp" data-wow-delay="0.2s">
            @forelse($postarticle as $key => $article)
            @php
                $cardColors = ['#6366f1','#10b981','#f59e0b','#ef4444','#8b5cf6','#0ea5e9'];
                $accent = $cardColors[$key % count($cardColors)];
            @endphp
            <div class="art-card" style="--card-accent: {{ $accent }}">
                <div class="art-card__img-wrap">
                    <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                         alt="{{ $article->title }}"
                         class="art-card__img"
                         loading="lazy">
                    <div class="art-card__date">
                        <span class="art-card__date-num">{{ \Carbon\Carbon::parse($article->dateevent)->format('d') }}</span>
                        <span class="art-card__date-month">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('MMM') }}</span>
                    </div>
                </div>
                <div class="art-card__body">
                    <div class="art-card__theme-row">
                        <span class="art-card__theme" style="--theme-color: {{ $accent }}">{{ $article->theme ?? 'Artikel' }}</span>
                    </div>
                    <h5 class="art-card__title">
                        <a href="/articles/{{ $article->id }}">{{ $article->title }}</a>
                    </h5>
                    <div class="art-card__footer">
                        <div class="art-card__meta">
                            <div class="art-card__avatar" style="background: {{ $accent }}20; color: {{ $accent }}">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>{{ $article->writer }}</span>
                        </div>
                        <a href="/articles/{{ $article->id }}" class="art-card__read">
                            Baca <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="art-card__accent-line" style="background: {{ $accent }}"></div>
            </div>
            @empty
            <div class="art-empty">
                <div class="art-empty__icon">📭</div>
                <h4>Belum Ada Artikel</h4>
                <p>Artikel sedang dalam proses penulisan. Tunggu ya!</p>
            </div>
            @endforelse
        </div>

        {{-- Mobile Carousel (hidden on desktop) --}}
        <div class="d-md-none wow fadeInUp" data-wow-delay="0.2s">
            <div class="owl-carousel art-carousel">
                @forelse($postarticle as $key => $article)
                @php
                    $cardColors = ['#6366f1','#10b981','#f59e0b','#ef4444','#8b5cf6','#0ea5e9'];
                    $accent = $cardColors[$key % count($cardColors)];
                @endphp
                <div class="art-card art-card--mobile"
                     style="--card-accent: {{ $accent }}; --theme-color: {{ $accent }}"
                     data-article-id="{{ $article->id }}"
                     data-article-title="{{ $article->title }}"
                     data-article-theme="{{ $article->theme ?? 'Artikel' }}"
                     data-article-writer="{{ $article->writer }}"
                     data-article-date="{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('D MMMM YYYY') }}"
                     data-article-img="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                     data-article-url="/articles/{{ $article->id }}"
                     data-article-accent="{{ $accent }}">
                    <div class="art-card__img-wrap">
                        <img src="https://lh3.googleusercontent.com/d/{{ $article->gdrive_id }}"
                             alt="{{ $article->title }}"
                             class="art-card__img"
                             loading="lazy">
                        <div class="art-card__date">
                            <span class="art-card__date-num">{{ \Carbon\Carbon::parse($article->dateevent)->format('d') }}</span>
                            <span class="art-card__date-month">{{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('MMM') }}</span>
                        </div>
                        {{-- Tap hint --}}
                        <div class="art-card__tap-hint">
                            <i class="fas fa-hand-pointer"></i> Ketuk untuk detail
                        </div>
                    </div>
                    <div class="art-card__body">
                        <div class="art-card__theme-row">
                            <span class="art-card__theme" style="--theme-color: {{ $accent }}">{{ $article->theme ?? 'Artikel' }}</span>
                        </div>
                        <h5 class="art-card__title">{{ $article->title }}</h5>
                        <div class="art-card__meta">
                            <div class="art-card__avatar" style="background: {{ $accent }}20; color: {{ $accent }}">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>{{ $article->writer }}</span>
                        </div>
                    </div>
                    <div class="art-card__accent-line" style="background: {{ $accent }}"></div>
                </div>
                @empty
                <div class="art-empty">
                    <div class="art-empty__icon">📭</div>
                    <h4>Belum Ada Artikel</h4>
                    <p>Artikel sedang dalam proses penulisan. Tunggu ya!</p>
                </div>
                @endforelse
            </div>
            {{-- Carousel Indicators --}}
            @if(count($postarticle) > 1)
            <div class="art-carousel-dots"></div>
            @endif
        </div>
    </div>
</section>

{{-- Mobile Bottom Sheet --}}
<div class="art-sheet-overlay" id="artSheetOverlay"></div>
<div class="art-sheet" id="artSheet">
    <div class="art-sheet__header">
        <div class="art-sheet__handle"></div>
        <button class="art-sheet__close" id="artSheetClose" aria-label="Tutup">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="art-sheet__content">
        <div class="art-sheet__img-wrap">
            <img src="" alt="" class="art-sheet__img" id="artSheetImg">
            <div class="art-sheet__img-gradient"></div>
        </div>
        <div class="art-sheet__info">
            <span class="art-card__theme" id="artSheetTheme" style="--theme-color: var(--primary)"></span>
            <h3 class="art-sheet__title" id="artSheetTitle"></h3>
            <div class="art-sheet__meta">
                <div class="art-sheet__meta-item">
                    <div class="art-sheet__meta-icon"><i class="fas fa-user"></i></div>
                    <span id="artSheetWriter"></span>
                </div>
                <div class="art-sheet__meta-item">
                    <div class="art-sheet__meta-icon"><i class="fas fa-calendar-alt"></i></div>
                    <span id="artSheetDate"></span>
                </div>
            </div>
            <a href="#" class="art-sheet__btn" id="artSheetBtn">
                <span>Baca Artikel Lengkap</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<style>
/* ═══════════════════════════════════════════════
   ARTICLE SECTION — Clean Modern Fun Design
   ═══════════════════════════════════════════════ */

.article-section {
    background: transparent;
    position: relative;
    overflow: hidden;
}

/* ── Section Header ── */
.art-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--primary-light);
    border-radius: var(--radius-pill);
    padding: 0.5rem 1.25rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--primary);
    position: relative;
}

.art-badge__pulse {
    width: 8px;
    height: 8px;
    background: var(--primary);
    border-radius: 50%;
    animation: artBadgePulse 2s ease-in-out infinite;
}

@keyframes artBadgePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.5; transform: scale(1.5); }
}

.art-heading {
    font-family: var(--font-primary);
    font-size: 2.2rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.art-heading__highlight {
    color: var(--primary);
    position: relative;
}

.art-heading__highlight::after {
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

.art-heading__sparkle {
    display: inline-block;
    animation: artSparkle 2s ease-in-out infinite;
}

@keyframes artSparkle {
    0%, 100% { transform: rotate(0deg) scale(1); }
    50% { transform: rotate(15deg) scale(1.2); }
}

.art-subtitle {
    color: var(--secondary);
    font-size: 1rem;
    margin-bottom: 0;
}

/* ── View All Button ── */
.art-btn-all {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    background: white;
    color: var(--primary);
    padding: 0.875rem 1.5rem;
    border-radius: var(--radius-pill);
    font-weight: 600;
    text-decoration: none;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: var(--transition);
    border: none;
}

.art-btn-all:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-primary);
}

.art-btn-all i { transition: transform 0.3s ease; }
.art-btn-all:hover i { transform: translateX(5px); }

/* ── Desktop Grid ── */
.art-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.75rem;
}

/* ═══════════════════════════════════════════════
   ARTICLE CARD — Fun & Colorful
   ═══════════════════════════════════════════════ */
.art-card {
    --card-accent: var(--primary);
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    display: flex;
    flex-direction: column;
}

.art-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
}

/* Accent bottom glow */
.art-card__accent-line {
    height: 3px;
    width: 100%;
    background: linear-gradient(90deg, transparent, var(--card-accent), transparent);
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.art-card:hover .art-card__accent-line {
    opacity: 1;
}

/* ── Image ── */
.art-card__img-wrap {
    position: relative;
    width: 100%;
    padding-top: 100%; /* 550x400 image ratio */
    overflow: hidden;
}

.art-card__img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.art-card:hover .art-card__img {
    transform: scale(1.08);
}

/* Date Badge */
.art-card__date {
    position: absolute;
    top: 12px;
    left: 12px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 14px;
    padding: 6px 10px;
    text-align: center;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    line-height: 1;
    z-index: 2;
}

.art-card__date-num {
    display: block;
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--card-accent);
}

.art-card__date-month {
    display: block;
    font-size: 0.6rem;
    font-weight: 700;
    color: var(--secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 1px;
}

/* Tap hint on mobile */
.art-card__tap-hint {
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--dark);
    z-index: 2;
    opacity: 0.9;
    animation: artPulse 2s ease-in-out infinite;
}

.art-card__tap-hint i {
    color: var(--card-accent);
    margin-right: 2px;
}

@keyframes artPulse {
    0%, 100% { opacity: 0.9; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(0.97); }
}

/* ── Body ── */
.art-card__body {
    padding: 1rem 1.25rem 1.15rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.art-card__theme-row {
    margin-bottom: 0.5rem;
}

.art-card__theme {
    --theme-color: var(--primary);
    display: inline-block;
    background: color-mix(in srgb, var(--theme-color) 12%, transparent);
    color: var(--theme-color);
    padding: 4px 12px;
    border-radius: var(--radius-pill);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.2px;
}

.art-card__title {
    font-family: var(--font-primary);
    font-weight: 700;
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex: 1;
}

.art-card__title a {
    color: var(--dark);
    text-decoration: none;
    transition: color 0.3s ease;
    background-image: linear-gradient(var(--card-accent), var(--card-accent));
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: left bottom;
    transition: background-size 0.3s ease, color 0.3s ease;
    padding-bottom: 1px;
}

.art-card:hover .art-card__title a {
    background-size: 100% 2px;
    color: var(--card-accent);
}

/* Footer row */
.art-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    padding-top: 0.75rem;
    margin-top: auto;
}

/* Meta */
.art-card__meta {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    color: var(--secondary);
    font-size: 0.8rem;
    font-weight: 500;
    min-width: 0;
}

/* In mobile card without footer, add margin */
.art-card--mobile .art-card__meta {
    margin-bottom: 0;
}

.art-card__avatar {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    flex-shrink: 0;
}

.art-card__meta span {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Read Button */
.art-card__read {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: white;
    background: var(--card-accent);
    font-weight: 600;
    font-size: 0.78rem;
    text-decoration: none;
    padding: 6px 14px;
    border-radius: var(--radius-pill);
    transition: all 0.3s ease;
    white-space: nowrap;
    flex-shrink: 0;
}

.art-card__read:hover {
    color: white;
    filter: brightness(1.1);
    transform: scale(1.05);
    box-shadow: 0 4px 15px color-mix(in srgb, var(--card-accent) 40%, transparent);
}

.art-card__read i {
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.art-card:hover .art-card__read i {
    transform: translateX(3px);
}

/* ── Empty State ── */
.art-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.05);
}

.art-empty__icon { font-size: 3.5rem; margin-bottom: 1rem; }
.art-empty h4 { color: var(--dark); margin-bottom: 0.5rem; }
.art-empty p { color: var(--secondary); margin-bottom: 0; }

/* ═══════════════════════════════════════════════
   OWL CAROUSEL — Mobile
   ═══════════════════════════════════════════════ */
.art-carousel.owl-carousel .owl-stage-outer {
    overflow: hidden;
    padding: 8px 0 16px;
}

.art-carousel.owl-carousel .owl-stage {
    display: flex !important;
    align-items: stretch;
}

.art-carousel.owl-carousel .owl-item {
    float: none !important;
    display: flex;
}

.art-carousel .art-card {
    width: 100%;
    margin: 0;
}

.art-carousel .art-card__img-wrap {
    padding-top: 100%; /* match desktop square ratio */
}

/* Custom dots */
.art-carousel-dots {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 1.25rem;
}

.art-carousel-dots .art-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: rgba(0, 167, 157, 0.2);
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all 0.3s ease;
}

.art-carousel-dots .art-dot.active {
    width: 28px;
    border-radius: 4px;
    background: var(--primary);
}

/* Hide default owl dots/nav */
.art-carousel .owl-dots,
.art-carousel .owl-nav {
    display: none !important;
}

/* ═══════════════════════════════════════════════
   MOBILE BOTTOM SHEET
   ═══════════════════════════════════════════════ */

.art-sheet-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 10000;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.art-sheet-overlay.active {
    opacity: 1;
    visibility: visible;
}

.art-sheet {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 10001;
    max-height: 85vh;
    overflow-y: auto;
    overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 -10px 40px rgba(0, 0, 0, 0.15);
}

.art-sheet.active {
    transform: translateY(0);
}

.art-sheet__header {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px 16px 4px;
    position: sticky;
    top: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 2;
}

.art-sheet__handle {
    width: 40px;
    height: 4px;
    background: #ddd;
    border-radius: 2px;
}

.art-sheet__close {
    position: absolute;
    right: 16px;
    top: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: none;
    background: var(--primary-light);
    color: var(--primary);
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
}

.art-sheet__close:hover {
    background: var(--primary);
    color: white;
}

.art-sheet__content {
    padding: 0 0 2rem;
}

.art-sheet__img-wrap {
    position: relative;
    width: 100%;
}

.art-sheet__img {
    width: 100%;
    height: 240px;
    object-fit: cover;
    display: block;
}

.art-sheet__img-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(to top, white, transparent);
    pointer-events: none;
}

.art-sheet__info {
    padding: 0.75rem 1.5rem 0;
}

.art-sheet__title {
    font-family: var(--font-primary);
    font-weight: 800;
    font-size: 1.3rem;
    color: var(--dark);
    line-height: 1.4;
    margin-bottom: 1rem;
    margin-top: 0.5rem;
}

.art-sheet__meta {
    display: flex;
    flex-direction: column;
    gap: 0.65rem;
    margin-bottom: 1.5rem;
}

.art-sheet__meta-item {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    color: var(--secondary);
    font-size: 0.9rem;
    font-weight: 500;
}

.art-sheet__meta-icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    background: var(--primary-light);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.art-sheet__meta-icon i {
    color: var(--primary);
    font-size: 0.8rem;
}

.art-sheet__btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    width: 100%;
    background: var(--primary-gradient);
    color: white;
    padding: 1rem;
    border-radius: var(--radius-pill);
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: var(--transition);
    box-shadow: 0 6px 24px rgba(0, 167, 157, 0.35);
}

.art-sheet__btn:hover {
    color: white;
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(0, 167, 157, 0.4);
}

/* ── Scroll lock ── */
body.art-sheet-open {
    overflow: hidden !important;
    touch-action: none;
}

/* ── Back-to-top smooth hide ── */
body.art-sheet-open .back-to-top {
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
    transition: opacity 0.3s ease, visibility 0.3s ease !important;
}

/* ═══════════════════════════════════════════════
   RESPONSIVE
   ═══════════════════════════════════════════════ */

@media (max-width: 991.98px) {
    .art-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .art-heading { font-size: 1.6rem; }
}

@media (max-width: 767.98px) {
    .art-card__body {
        padding: 0.9rem 1.1rem 1rem;
    }
}

@media (max-width: 575.98px) {
    .art-btn-all {
        width: 100%;
        justify-content: center;
    }
}

/* Tablet bottom sheet */
@media (min-width: 768px) {
    .art-sheet {
        max-width: 480px;
        left: 50%;
        transform: translate(-50%, 100%);
        border-radius: 24px 24px 0 0;
    }

    .art-sheet.active {
        transform: translate(-50%, 0);
    }

    .art-card__tap-hint {
        display: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ── Owl Carousel for mobile ──
    var $artCarousel = jQuery('.art-carousel');

    if ($artCarousel.length) {
        $artCarousel.owlCarousel({
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
            autoWidth: false,
        });

        // Custom dots
        var $dotsContainer = jQuery('.art-carousel-dots');
        var itemCount = $artCarousel.find('.owl-item:not(.cloned)').length;

        if (itemCount > 1 && $dotsContainer.length) {
            for (var i = 0; i < itemCount; i++) {
                var $dot = jQuery('<button class="art-dot" aria-label="Slide ' + (i + 1) + '"></button>');
                if (i === 0) $dot.addClass('active');
                $dot.data('index', i);
                $dotsContainer.append($dot);
            }

            $dotsContainer.on('click', '.art-dot', function() {
                $artCarousel.trigger('to.owl.carousel', [jQuery(this).data('index'), 300]);
            });

            $artCarousel.on('changed.owl.carousel', function(e) {
                var idx = e.item.index;
                $dotsContainer.find('.art-dot').removeClass('active');
                $dotsContainer.find('.art-dot').eq(idx).addClass('active');
            });
        }
    }

    // ── Bottom Sheet Logic ──
    var $overlay = jQuery('#artSheetOverlay');
    var $sheet   = jQuery('#artSheet');
    var $body    = jQuery('body');

    function openSheet(data) {
        jQuery('#artSheetImg').attr('src', data.img).attr('alt', data.title);
        jQuery('#artSheetTheme').text(data.theme).css({
            '--theme-color': data.accent || 'var(--primary)',
            'background': 'color-mix(in srgb, ' + (data.accent || '#00a79d') + ' 12%, transparent)',
            'color': data.accent || 'var(--primary)'
        });
        jQuery('#artSheetTitle').text(data.title);
        jQuery('#artSheetWriter').text(data.writer);
        jQuery('#artSheetDate').text(data.date);
        jQuery('#artSheetBtn').attr('href', data.url);

        $body.addClass('art-sheet-open');
        $overlay.addClass('active');

        setTimeout(function() {
            $sheet.addClass('active');
        }, 10);

        $sheet[0].scrollTop = 0;
    }

    function closeSheet() {
        $sheet.removeClass('active');

        setTimeout(function() {
            $overlay.removeClass('active');
            $body.removeClass('art-sheet-open');

            if (jQuery(window).scrollTop() > 300) {
                jQuery('.back-to-top').stop(true).fadeIn(300);
            }
        }, 380);
    }

    // Click on mobile carousel card → open sheet
    jQuery(document).on('click', '.art-card--mobile', function(e) {
        e.preventDefault();
        var $el = jQuery(this);
        openSheet({
            title:  $el.data('article-title'),
            theme:  $el.data('article-theme'),
            writer: $el.data('article-writer'),
            date:   $el.data('article-date'),
            img:    $el.data('article-img'),
            url:    $el.data('article-url'),
            accent: $el.data('article-accent')
        });
    });

    // Close sheet
    jQuery('#artSheetClose').on('click', closeSheet);
    $overlay.on('click', closeSheet);

    // Close with Escape key
    jQuery(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $sheet.hasClass('active')) {
            closeSheet();
        }
    });

    // Swipe down to close (touch)
    var touchStartY = 0;
    var touchCurrentY = 0;
    var sheetEl = $sheet[0];

    sheetEl.addEventListener('touchstart', function(e) {
        if (this.scrollTop <= 0) {
            touchStartY = e.touches[0].clientY;
        } else {
            touchStartY = 0;
        }
    }, { passive: true });

    sheetEl.addEventListener('touchmove', function(e) {
        if (touchStartY === 0) return;
        touchCurrentY = e.touches[0].clientY;
        var diff = touchCurrentY - touchStartY;
        if (diff > 0 && this.scrollTop <= 0) {
            var translateVal = Math.min(diff * 0.6, 200);
            if (window.innerWidth >= 768) {
                this.style.transform = 'translate(-50%, ' + translateVal + 'px)';
            } else {
                this.style.transform = 'translateY(' + translateVal + 'px)';
            }
        }
    }, { passive: true });

    sheetEl.addEventListener('touchend', function() {
        var diff = touchCurrentY - touchStartY;
        if (diff > 80) {
            closeSheet();
        }
        var self = this;
        setTimeout(function() {
            self.style.transform = '';
        }, 380);
        touchStartY = 0;
        touchCurrentY = 0;
    }, { passive: true });
});
</script>
