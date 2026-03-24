{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

{{-- ── Pagination shared styles ── --}}
@include('components.pagination-custom.styles')

{{-- ── Search-Filter-Bar component styles ── --}}
@include('components.search-filter-bar.styles')

{{-- ── Search-Filter-Bar modal styles ── --}}
@include('components.search-filter-bar.modal-styles')

{{-- ── Select2 CSS ── --}}
<link href="{{ asset('assets/external/css/select2.min.css') }}" rel="stylesheet" />

{{-- ── Skeleton cards shared styles ── --}}
@include('components.skeleton-cards.styles')

@verbatim
<style>
/* ================================================================
   VARIABLES
   ================================================================ */
:root {
    --cs-primary:     #00a79d;
    --cs-primary-dk:  #008a82;
    --cs-primary-lt:  #e0f7f5;
    --cs-dark:        #1a2332;
    --cs-gray:        #6b7280;
    --cs-gray-100:    #f8f9fa;
    --cs-gray-200:    #e9ecef;
    --cs-white:       #ffffff;
    --cs-cat:         #00a79d;

    --cs-radius:      14px;
    --cs-radius-lg:   20px;
    --cs-radius-xl:   24px;

    --cs-shadow:      0 4px 20px rgba(0,0,0,.07);
    --cs-shadow-hover:0 12px 36px rgba(0,0,0,.13);
    --cs-transition:  all .3s cubic-bezier(.4,0,.2,1);
}


/* ================================================================
   PAGE SECTION
   ================================================================ */
.cs-page-section { min-height: 100vh; position: relative; z-index: 1; }


/* ================================================================
   SECTION BADGE / HEADER
   ================================================================ */
.cs-section-badge {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: var(--cs-primary-lt);
    color: var(--cs-primary);
    padding: .4rem 1.1rem;
    border-radius: 30px;
    font-size: .82rem;
    font-weight: 700;
    letter-spacing: .02em;
    position: relative;
}
.cs-badge-pulse {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--cs-primary);
    animation: csBadgePulse 2s ease infinite;
}
@keyframes csBadgePulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}

.cs-section-title {
    font-size: 2rem; font-weight: 800;
    color: var(--cs-dark); line-height: 1.2;
}
.cs-section-sub {
    font-size: .95rem; color: var(--cs-gray); max-width: 520px; margin: 0 auto;
}

.cs-results-info {
    font-size: .85rem; color: var(--cs-gray);
}
.cs-results-info strong { color: var(--cs-dark); }


/* ================================================================
   INFO CARD (Ayat / About)
   ================================================================ */
.cs-info-card {
    background: var(--cs-white);
    border-radius: var(--cs-radius-xl);
    padding: 2rem 2.25rem;
    box-shadow: var(--cs-shadow);
    position: relative;
    overflow: hidden;
}

.cs-info-verse {
    font-size: 1rem;
    font-style: italic;
    color: var(--cs-dark);
    line-height: 1.75;
    margin: 0;
}
.cs-info-source {
    font-size: .82rem;
    color: var(--cs-primary);
    font-weight: 600;
    margin-top: .5rem;
}


/* ================================================================
   AJAX TRANSITION
   ================================================================ */
#cs-cards-wrap { transition: opacity .35s ease, transform .35s ease; }
#cs-cards-wrap.cs-cards-out {
    opacity: 0; transform: translateY(16px); pointer-events: none;
}


/* ================================================================
   DESKTOP CAMPAIGN GRID
   ================================================================ */
.cs-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}

/* ── Campaign Card ── */
.cs-campaign-card {
    background: var(--cs-white);
    border-radius: var(--cs-radius-xl);
    box-shadow: var(--cs-shadow);
    overflow: hidden;
    transition: var(--cs-transition);
    display: flex;
    flex-direction: column;
}
.cs-campaign-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--cs-shadow-hover);
}

/* Image */
.cs-card-img-wrap {
    display: block;
    position: relative;
    overflow: hidden;
    aspect-ratio: 4/3;
    flex-shrink: 0;
}
.cs-card-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .45s ease;
}
.cs-campaign-card:hover .cs-card-img { transform: scale(1.06); }

.cs-card-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        180deg,
        rgba(0,0,0,0) 40%,
        rgba(0,0,0,.45) 100%
    );
}

.cs-cat-badge {
    position: absolute;
    top: .75rem; left: .75rem;
    background: var(--cs-cat);
    color: #fff;
    font-size: .72rem; font-weight: 700;
    padding: .25rem .7rem;
    border-radius: 20px;
    letter-spacing: .02em;
}
.cs-new-badge {
    position: absolute;
    top: .75rem; right: .75rem;
    background: #f59e0b;
    color: #fff;
    font-size: .7rem; font-weight: 700;
    padding: .2rem .6rem;
    border-radius: 20px;
}
.cs-percent-chip {
    position: absolute;
    bottom: .75rem; right: .75rem;
    background: rgba(255,255,255,.92);
    color: var(--cs-primary);
    font-size: .75rem; font-weight: 800;
    padding: .2rem .6rem;
    border-radius: 20px;
    backdrop-filter: blur(4px);
}

/* Body */
.cs-card-body {
    padding: 1.25rem 1.25rem 1rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: .625rem;
}

.cs-card-org {
    display: flex;
    align-items: center;
    gap: .5rem;
}
.cs-org-logo {
    width: 22px; height: 22px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}
.cs-org-name {
    font-size: .78rem;
    color: var(--cs-gray);
    text-decoration: none;
    font-weight: 500;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    transition: color .2s;
}
.cs-org-name:hover { color: var(--cs-primary); }

.cs-card-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--cs-dark);
    line-height: 1.35;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cs-card-title a {
    color: inherit; text-decoration: none;
    transition: color .2s;
}
.cs-card-title a:hover { color: var(--cs-primary); }

/* Progress */
.cs-progress-wrap { padding: .125rem 0; }
.cs-progress-track {
    height: 6px;
    background: var(--cs-gray-200);
    border-radius: 10px;
    overflow: hidden;
}
.cs-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--cs-primary) 0%, #00d4c8 100%);
    border-radius: 10px;
    transition: width .6s ease;
    min-width: 2px;
}

/* Stats */
.cs-stats-row {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .625rem .875rem;
    background: var(--cs-gray-100);
    border-radius: var(--cs-radius);
}
.cs-stat-item {
    display: flex; flex-direction: column; gap: .125rem;
    flex: 1;
}
.cs-stat-right { align-items: flex-end; }
.cs-stat-sep {
    width: 1px; height: 2rem;
    background: var(--cs-gray-200);
    flex-shrink: 0;
}
.cs-stat-label {
    font-size: .7rem; color: var(--cs-gray); font-weight: 500;
}
.cs-stat-value {
    font-size: .82rem; font-weight: 700; color: var(--cs-dark);
}
.cs-stat-primary { color: var(--cs-primary); }
.cs-stat-ended { color: #ef4444; }

/* Actions */
.cs-card-actions {
    display: flex;
    align-items: center;
    gap: .5rem;
    margin-top: auto;
}
.cs-btn-donate {
    flex: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .45rem;
    background: var(--cs-primary);
    color: #fff;
    font-size: .82rem; font-weight: 700;
    padding: .55rem 1rem;
    border-radius: 30px;
    text-decoration: none;
    transition: var(--cs-transition);
    box-shadow: 0 4px 14px rgba(0,167,157,.28);
}
.cs-btn-ended {
    background: #e5e7eb !important; color: #9ca3af !important;
    cursor: not-allowed; pointer-events: none;
    box-shadow: none !important; transform: none !important;
    filter: none !important;
}
.cs-btn-donate:hover {
    color: #fff;
    filter: brightness(.9);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(0,167,157,.4);
}
.cs-share-group { display: flex; gap: .375rem; }
.cs-share-btn {
    width: 34px; height: 34px;
    border-radius: 50%; border: 1.5px solid var(--cs-gray-200);
    background: var(--cs-white);
    color: var(--cs-gray);
    font-size: .78rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: var(--cs-transition);
    flex-shrink: 0;
}
.cs-share-btn:hover { background: var(--cs-primary-lt); color: var(--cs-primary); border-color: var(--cs-primary); }
.cs-share-wa:hover  { background: #dcfce7; color: #16a34a; border-color: #16a34a; }


/* ================================================================
   EMPTY STATE
   ================================================================ */
.cs-empty-state {
    text-align: center; padding: 4rem 1rem;
}
.cs-empty-visual {
    position: relative; width: 120px; height: 120px; margin: 0 auto 1.5rem;
}
.cs-empty-ring-1, .cs-empty-ring-2 {
    position: absolute; border-radius: 50%;
    border: 2px solid var(--cs-primary-lt);
    top: 50%; left: 50%;
    transform: translate(-50%,-50%) scale(.85);
    animation: csEmptyRing 2.4s ease-out infinite;
}
.cs-empty-ring-1 { width: 100px; height: 100px; }
.cs-empty-ring-2 { width: 130px; height: 130px; animation-delay: .8s; }
@keyframes csEmptyRing {
    0%   { opacity: .6; transform: translate(-50%,-50%) scale(.85); }
    100% { opacity: 0;  transform: translate(-50%,-50%) scale(1.3); }
}
.cs-empty-icon-wrap {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; color: var(--cs-primary);
}
.cs-empty-sparkle {
    position: absolute; font-size: .9rem;
    animation: csEmptySparkle 2.5s ease-in-out infinite;
}
.cs-empty-sparkle-1 { top: -6px; right: -8px; }
.cs-empty-sparkle-2 { bottom: -4px; left: -10px; animation-delay: 1.2s; }
.cs-empty-sparkle-3 { top: 8px; left: -12px; font-size: .7rem; animation-delay: 2s; }
@keyframes csEmptySparkle {
    0%,100% { transform: scale(1) rotate(0deg); opacity: .7; }
    50%      { transform: scale(1.3) rotate(15deg); opacity: 1; }
}
.cs-empty-title { font-size: 1.3rem; font-weight: 800; color: var(--cs-dark); margin: 0 0 .5rem; }
.cs-empty-sub { font-size: .88rem; color: var(--cs-gray); max-width: 300px; margin: 0 auto; }


/* ================================================================
   MOBILE CAROUSEL
   ================================================================ */
.cs-mobile-carousel {
    display: flex; overflow-x: auto;
    scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
    gap: 1rem;
    padding: 0 calc(50% - 140px) 1rem;
    scrollbar-width: none; -ms-overflow-style: none;
}
.cs-mobile-carousel::-webkit-scrollbar { display: none; }

.cs-mobile-card {
    flex: 0 0 280px;
    scroll-snap-align: center; cursor: pointer;
    background: var(--cs-white);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--cs-shadow);
    transition: transform .2s ease, box-shadow .2s ease;
    -webkit-tap-highlight-color: transparent;
}
.cs-mobile-card:active { transform: scale(.98); }

.cs-m-img-wrap {
    position: relative; overflow: hidden; aspect-ratio: 4/3;
}
.cs-m-img { width: 100%; height: 100%; object-fit: cover; }
.cs-m-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,.5) 100%);
}
.cs-m-cat-badge {
    position: absolute; top: .625rem; left: .625rem;
    background: var(--cs-cat); color: #fff;
    font-size: .65rem; font-weight: 700;
    padding: .2rem .55rem; border-radius: 20px;
}
.cs-m-new-badge {
    position: absolute; top: .625rem; right: .625rem;
    background: #f59e0b; color: #fff;
    font-size: .65rem; font-weight: 700;
    padding: .2rem .55rem; border-radius: 20px;
}

.cs-m-body { padding: 1rem; }
.cs-m-org {
    display: flex; align-items: center; gap: .4rem; margin-bottom: .4rem;
}
.cs-m-org-logo {
    width: 18px; height: 18px; border-radius: 50%; object-fit: cover;
}
.cs-m-org-name {
    font-size: .72rem; color: var(--cs-gray); font-weight: 500;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.cs-m-title {
    font-size: .88rem; font-weight: 700; color: var(--cs-dark);
    line-height: 1.35; margin: 0 0 .625rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.cs-m-progress-track {
    height: 5px; background: var(--cs-gray-200);
    border-radius: 10px; overflow: hidden; margin-bottom: .5rem;
}
.cs-m-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--cs-primary) 0%, #00d4c8 100%);
    border-radius: 10px;
}
.cs-m-stats {
    display: flex; justify-content: space-between;
    margin-bottom: .4rem;
}
.cs-m-collected { font-size: .78rem; font-weight: 700; color: var(--cs-primary); }
.cs-m-days      { font-size: .72rem; color: var(--cs-gray); font-weight: 600; }
.cs-m-ended     { color: #ef4444; }
.cs-m-hint {
    font-size: .7rem; color: var(--cs-gray);
    display: flex; align-items: center; gap: .25rem;
}
.cs-m-hint i { color: var(--cs-primary); }

/* Carousel dots */
.cs-carousel-dots {
    display: flex; justify-content: center;
    gap: 6px; margin: .75rem 0 .25rem;
}
.cs-dot {
    width: 7px; height: 7px; border-radius: 50%; border: none;
    background: var(--cs-gray-200); cursor: pointer;
    transition: background .2s ease, width .2s ease; padding: 0;
}
.cs-dot.active { background: var(--cs-primary); width: 18px; border-radius: 4px; }


/* ================================================================
   MOBILE BOTTOM SHEET
   ================================================================ */
.cs-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.cs-bs-backdrop.active { opacity: 1; visibility: visible; }

.cs-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--cs-white);
    border-radius: 24px 24px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    padding-bottom: env(safe-area-inset-bottom, 1rem);
}
.cs-bottom-sheet.active { transform: translateY(0); }

.cs-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--cs-primary); font-size: .9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.cs-bs-close:hover { background: var(--cs-primary); color: #fff; }

/* BS Cover */
.cs-bs-cover-wrap {
    position: relative; width: 100%; overflow: hidden;
    aspect-ratio: 16/9; max-height: 52vw;
}
.cs-bs-cover-img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.cs-bs-cover-fallback {
    width: 100%; height: 100%;
    background: var(--cs-primary-lt);
    display: flex; align-items: center; justify-content: center;
    color: var(--cs-primary); font-size: 3rem;
}
.cs-bs-cover-gradient {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 50%;
    background: linear-gradient(transparent, rgba(0,0,0,.5));
}
.cs-bs-drag-handle {
    position: absolute; top: .625rem; left: 50%;
    transform: translateX(-50%);
    width: 36px; height: 4px;
    background: rgba(255,255,255,.6); border-radius: 2px;
    z-index: 2;
}

/* BS Info */
.cs-bs-info { padding: 1.25rem 1.25rem 1.5rem; }
.cs-bs-cat-badge {
    display: inline-flex; align-items: center; gap: .3rem;
    background: var(--cs-primary-lt); color: var(--cs-primary);
    font-size: .72rem; font-weight: 700;
    padding: .22rem .7rem; border-radius: 20px;
    margin-bottom: .625rem;
}
.cs-bs-title {
    font-size: 1.1rem; font-weight: 800;
    color: var(--cs-dark); line-height: 1.3;
    margin: 0 0 .625rem;
}
.cs-bs-org {
    display: flex; align-items: center; gap: .5rem; margin-bottom: 1rem;
}
.cs-bs-org-logo {
    width: 24px; height: 24px; border-radius: 50%; object-fit: cover;
}
.cs-bs-org-name {
    font-size: .8rem; color: var(--cs-gray); font-weight: 500;
    text-decoration: none;
}
.cs-bs-org-name:hover { color: var(--cs-primary); }

/* BS Progress */
.cs-bs-progress-wrap { margin-bottom: 1rem; }
.cs-bs-progress-head {
    display: flex; justify-content: space-between; margin-bottom: .375rem;
}
.cs-bs-progress-pct {
    font-size: .78rem; font-weight: 700; color: var(--cs-primary);
}
.cs-bs-progress-days {
    font-size: .72rem; color: var(--cs-gray);
}
.cs-bs-progress-days.ended { color: #ef4444; }
.cs-bs-progress-track {
    height: 8px; background: var(--cs-gray-200);
    border-radius: 10px; overflow: hidden;
}
.cs-bs-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--cs-primary) 0%, #00d4c8 100%);
    border-radius: 10px; transition: width .6s ease;
}

.cs-bs-stats {
    display: grid; grid-template-columns: 1fr 1px 1fr;
    gap: .5rem; align-items: center;
    background: var(--cs-gray-100);
    border-radius: var(--cs-radius); padding: .875rem 1rem;
    margin-bottom: 1rem;
}
.cs-bs-stat { display: flex; flex-direction: column; gap: .125rem; }
.cs-bs-stat:last-child { align-items: flex-end; }
.cs-bs-stat-label { font-size: .7rem; color: var(--cs-gray); font-weight: 500; }
.cs-bs-stat-val { font-size: .88rem; font-weight: 700; color: var(--cs-dark); }
.cs-bs-stat-val.primary { color: var(--cs-primary); }
.cs-bs-stat-sep { width: 1px; height: 2rem; background: var(--cs-gray-200); }

.cs-bs-excerpt {
    font-size: .82rem; color: var(--cs-gray);
    line-height: 1.65; margin-bottom: 1rem;
    display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
}

/* BS Buttons */
.cs-bs-btns { display: flex; flex-direction: column; gap: .625rem; margin-bottom: 1rem; }
.cs-bs-btn-donate {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    background: var(--cs-primary); color: #fff;
    font-size: .9rem; font-weight: 700;
    padding: .75rem 1.5rem; border-radius: 30px;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(0,167,157,.3);
    transition: var(--cs-transition);
}
.cs-bs-btn-donate:hover { color: #fff; filter: brightness(.9); }
.cs-bs-btn-detail {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    background: var(--cs-gray-100); color: var(--cs-dark);
    font-size: .9rem; font-weight: 600;
    padding: .75rem 1.5rem; border-radius: 30px;
    text-decoration: none;
    transition: var(--cs-transition);
}
.cs-bs-btn-detail:hover { background: var(--cs-primary-lt); color: var(--cs-primary); }

/* BS Share */
.cs-bs-share-wrap { border-top: 1px solid var(--cs-gray-200); padding-top: 1rem; }
.cs-bs-share-label { font-size: .8rem; color: var(--cs-gray); font-weight: 600; display: block; margin-bottom: .5rem; }
.cs-bs-share-row { display: flex; gap: .625rem; }
.cs-bs-share-btn {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: .4rem;
    font-size: .8rem; font-weight: 600;
    padding: .55rem .75rem; border-radius: 10px;
    border: 1.5px solid var(--cs-gray-200); background: var(--cs-white);
    color: var(--cs-dark); cursor: pointer; transition: var(--cs-transition);
}
.cs-bs-share-copy:hover { background: var(--cs-primary-lt); color: var(--cs-primary); border-color: var(--cs-primary); }
.cs-bs-share-wa:hover   { background: #dcfce7; color: #16a34a; border-color: #16a34a; }

/* SweetAlert above sheet */
.cs-swal-above-sheet { z-index: 1200 !important; }

/* SweetAlert toast below navbar */
.swal2-container.swal2-top-end,
.swal2-container.swal2-top-start,
.swal2-container.swal2-top {
    top: 80px !important;
    padding-top: 0 !important;
}

/* Body lock when sheet open */
body.cs-sheet-open { overflow: hidden; }


/* ================================================================
   PAGINATION WRAP
   ================================================================ */
.cs-pagination-wrap { padding-bottom: 1rem; }


/* ================================================================
   RESPONSIVE
   ================================================================ */
@media (max-width: 1199.98px) {
    .cs-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 991.98px) {
    .cs-section-title { font-size: 1.6rem; }
}
@media (max-width: 767.98px) {
    .cs-section-title { font-size: 1.4rem; }
    .cs-info-card { padding: 1.25rem 1.5rem; }
}
@media (max-width: 575.98px) {
    .cs-mobile-card { flex: 0 0 80vw; }
    .cs-mobile-carousel { padding: 0 calc(50% - 40vw) 1rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
/* Section header */
[data-theme="dark"] .cs-section-title  { color: #e2e8f0; }
[data-theme="dark"] .cs-section-sub    { color: #9ca3af; }
[data-theme="dark"] .cs-section-badge  { background: rgba(0,167,157,.15); color: #4dd9cf; }
/* Results info */
[data-theme="dark"] .cs-results-info        { color: #9ca3af; }
[data-theme="dark"] .cs-results-info strong { color: #e2e8f0; }
/* Info card (Ayat / About) */
[data-theme="dark"] .cs-info-card   { background: #1a1f2e; }
[data-theme="dark"] .cs-info-verse  { color: #9ca3af; }
/* Desktop campaign card — correct class */
[data-theme="dark"] .cs-campaign-card { background: #1a1f2e; }
[data-theme="dark"] .cs-card-title    { color: #e2e8f0; }
[data-theme="dark"] .cs-org-name      { color: #9ca3af; }
[data-theme="dark"] .cs-progress-track { background: #252b3b; }
[data-theme="dark"] .cs-stats-row     { background: #252b3b; }
[data-theme="dark"] .cs-stat-value    { color: #e2e8f0; }
[data-theme="dark"] .cs-stat-sep      { background: rgba(255,255,255,.1); }
[data-theme="dark"] .cs-percent-chip  { background: rgba(20,27,45,.9); color: #4dd9cf; }
[data-theme="dark"] .cs-share-btn     { background: #1e2535; border-color: rgba(0,167,157,.25); color: #9ca3af; }
/* Empty state */
[data-theme="dark"] .cs-empty-title   { color: #e2e8f0; }
[data-theme="dark"] .cs-empty-sub     { color: #9ca3af; }
/* Mobile carousel */
[data-theme="dark"] .cs-mobile-card       { background: #1a1f2e; }
[data-theme="dark"] .cs-m-title           { color: #e2e8f0; }
[data-theme="dark"] .cs-m-org-name        { color: #9ca3af; }
[data-theme="dark"] .cs-m-progress-track  { background: #252b3b; }
[data-theme="dark"] .cs-dot               { background: rgba(255,255,255,.2); }
[data-theme="dark"] .cs-dot.active        { background: #00a79d; }
/* Bottom sheet */
[data-theme="dark"] .cs-bottom-sheet      { background: #1a1f2e; }
[data-theme="dark"] .cs-bs-close          { background: #252b3b; color: #4dd9cf; box-shadow: none; }
[data-theme="dark"] .cs-bs-cover-fallback { background: rgba(0,167,157,.1); }
[data-theme="dark"] .cs-bs-cat-badge      { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .cs-bs-title          { color: #e2e8f0; }
[data-theme="dark"] .cs-bs-org-name       { color: #9ca3af; }
[data-theme="dark"] .cs-bs-progress-track { background: #252b3b; }
[data-theme="dark"] .cs-bs-stats          { background: #252b3b; }
[data-theme="dark"] .cs-bs-stat-val       { color: #e2e8f0; }
[data-theme="dark"] .cs-bs-stat-sep       { background: rgba(255,255,255,.1); }
[data-theme="dark"] .cs-bs-excerpt        { color: #9ca3af; }
[data-theme="dark"] .cs-bs-btn-detail     { background: #252b3b; color: #e2e8f0; }
[data-theme="dark"] .cs-bs-share-wrap     { border-top-color: rgba(0,167,157,.15); }
[data-theme="dark"] .cs-bs-share-btn      { background: #1e2535; border-color: rgba(0,167,157,.2); color: #e2e8f0; }
</style>
@endverbatim
