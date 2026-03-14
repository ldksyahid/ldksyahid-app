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
   CATALOG BOOK PAGE  —  styles prefix: cb-
   Palette: --primary:#00a79d  --primary-dark:#008f86
            --primary-light:#e0f7f5  --dark:#282d30  --gray:#8d9297
   ================================================================ */

:root {
    --cb-primary:       #00a79d;
    --cb-primary-dark:  #008f86;
    --cb-primary-light: #e0f7f5;
    --cb-dark:          #282d30;
    --cb-gray:          #8d9297;
    --cb-gray-100:      #f3f4f6;
    --cb-gray-200:      #e5e7eb;
    --cb-spine:         #00a79d;
}


/* ─── Section Header ──────────────────────────────────────────── */
.cb-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--cb-primary-light); color: var(--cb-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.cb-badge-pulse {
    width: 8px; height: 8px; background: var(--cb-primary);
    border-radius: 50%; flex-shrink: 0;
    animation: cbPulse 2s ease infinite;
}
@keyframes cbPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.cb-section-title { font-size: 2rem; font-weight: 700; color: var(--cb-dark); margin: 0; }
.cb-section-sub   { color: var(--cb-gray); font-size: 1rem; margin: .5rem 0 0; }


/* ─── Results Info ────────────────────────────────────────────── */
.cb-results-info { font-size: .86rem; color: var(--cb-gray); }
.cb-results-info strong { color: var(--cb-dark); font-weight: 600; }


/* ─── AJAX Page Transition ────────────────────────────────────── */
#cb-cards-wrap { transition: opacity .35s ease, transform .35s ease; }
#cb-cards-wrap.cb-cards-out {
    opacity: 0; transform: translateY(18px); pointer-events: none;
}


/* ================================================================
   DESKTOP BOOK CARD  (horizontal: cover left, content right)
   Unique design: spine accent, portrait cover, tab-based info
   ================================================================ */

.cb-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.cb-book-card {
    position: relative;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(0,0,0,.07);
    transition: transform .32s cubic-bezier(.4,0,.2,1),
                box-shadow .32s cubic-bezier(.4,0,.2,1);
    display: flex;
    flex-direction: column;
}

.cb-book-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 52px rgba(0,0,0,.11),
                0 0 0 1.5px var(--cb-spine);
}


/* ── Horizontal body ── */
.cb-card-body {
    display: flex;
    flex: 1;
    min-height: 260px;
}


/* ── Cover column ── */
.cb-card-cover-col {
    width: 155px;
    flex-shrink: 0;
    padding: 14px 0 14px 14px;
    display: flex;
    flex-direction: column;
}

/* ── Decoration below cover ── */
.cb-cover-deco {
    flex: 1;
    min-height: 28px;
    margin-top: 8px;
    position: relative;
    overflow: hidden;
}

/* Floating sparkles rising from bottom */
.cb-cd-sp {
    position: absolute;
    bottom: 6px;
    color: var(--cb-spine);
    opacity: 0;
    font-style: normal;
    line-height: 1;
    animation: cbCdRise 4s ease-in-out infinite;
    pointer-events: none;
}
.cb-cd-sp1 { left: 14%; font-size: .58rem; animation-delay: 0s;   animation-duration: 3.6s; }
.cb-cd-sp2 { left: 36%; font-size: .52rem; animation-delay: 1.1s; animation-duration: 4.1s; }
.cb-cd-sp3 { left: 62%; font-size: .48rem; animation-delay: .55s; animation-duration: 3.3s; }
.cb-cd-sp4 { left: 80%; font-size: .55rem; animation-delay: 2s;   animation-duration: 4.4s; }

@keyframes cbCdRise {
    0%   { opacity: 0;    transform: translateY(0)     scale(.5) rotate(0deg); }
    20%  { opacity: .45; }
    70%  { opacity: .22; }
    100% { opacity: 0;    transform: translateY(-68px) scale(.9) rotate(180deg); }
}

/* Central floating book icon */
.cb-cd-icon {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.1rem;
    color: var(--cb-spine);
    opacity: .28;
    animation: cbCdIconFloat 2.8s ease-in-out infinite;
    pointer-events: none;
}

@keyframes cbCdIconFloat {
    0%, 100% { transform: translate(-50%, -50%) rotate(-6deg) scale(1);    opacity: .25; }
    50%       { transform: translate(-50%, calc(-50% - 5px)) rotate(5deg) scale(1.12); opacity: .38; }
}
/* Fixed 2:3 portrait ratio with rounded corners */
.cb-card-cover-link {
    display: block;
    position: relative;
    aspect-ratio: 2 / 3;
    overflow: hidden;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,.18);
}
.cb-card-cover-img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.cb-book-card:hover .cb-card-cover-img { transform: scale(1.07); }

.cb-prem-badge {
    position: absolute; top: 8px; right: 8px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff; width: 28px; height: 28px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .68rem; box-shadow: 0 3px 10px rgba(245,158,11,.4);
}
.cb-new-badge {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; font-size: .62rem; font-weight: 700;
    padding: 4px 0; text-align: center; letter-spacing: .3px;
}


/* ── Content column ── */
.cb-card-content {
    flex: 1; min-width: 0;
    padding: 1.15rem 1.2rem 1.1rem;
    display: flex; flex-direction: column;
    /* no gap — use margin on children so margin-top: auto on actions works reliably */
}
.cb-card-header    { margin-bottom: .55rem; }
.cb-card-tabs      { flex: 1; display: flex; flex-direction: column; min-height: 0; margin-bottom: .6rem; }


/* ── Header: title + meta ── */
.cb-card-title {
    font-size: .97rem; font-weight: 700; margin: 0; line-height: 1.45;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}
.cb-card-title a {
    color: var(--cb-dark); text-decoration: none;
    transition: color .2s ease;
}
.cb-card-title a:hover { color: var(--cb-primary); }

.cb-card-meta-row {
    display: flex; align-items: center; flex-wrap: wrap;
    gap: .3rem .55rem;
}
.cb-meta-item {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .76rem; color: var(--cb-gray);
}
.cb-meta-item i { font-size: .7rem; }
.cb-meta-likes i { color: #ef4444; }
.cb-cat-badge {
    display: inline-flex; align-items: center;
    padding: .2rem .65rem; border-radius: 50px;
    font-size: .7rem; font-weight: 600; color: #fff; line-height: 1.4;
    white-space: nowrap; max-width: 130px;
    overflow: hidden; text-overflow: ellipsis;
}


/* ── Tabs ── */
.cb-tabs-nav {
    display: flex;
    border-bottom: 1.5px solid var(--cb-gray-200);
    margin-bottom: .6rem; gap: 0;
}
.cb-tab {
    background: none; border: none;
    padding: .35rem .9rem .45rem;
    font-size: .8rem; font-weight: 600;
    color: var(--cb-gray); cursor: pointer;
    position: relative; transition: color .2s;
    line-height: 1;
}
.cb-tab::after {
    content: '';
    position: absolute; bottom: -1.5px; left: 0; right: 0;
    height: 2px; background: var(--cb-spine);
    transform: scaleX(0);
    transition: transform .26s cubic-bezier(.4,0,.2,1);
    border-radius: 2px 2px 0 0;
}
.cb-tab.active { color: var(--cb-primary); }
.cb-tab.active::after { transform: scaleX(1); }
.cb-tab:hover:not(.active) { color: var(--cb-dark); }

.cb-tab-pane { display: none; }
.cb-tab-pane.active {
    display: block;
    animation: cbTabFadeIn .22s ease;
}
@keyframes cbTabFadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to   { opacity: 1; transform: translateY(0); }
}


/* ── Spec list ── */
.cb-specs { display: flex; flex-direction: column; gap: 0; }
.cb-spec-row {
    display: flex; gap: .5rem; align-items: baseline;
    font-size: .78rem; padding: .27rem 0;
    border-bottom: 1px solid rgba(0,0,0,.04);
    line-height: 1.45;
}
.cb-spec-row:last-child { border-bottom: none; }
.cb-spec-label {
    color: var(--cb-gray); min-width: 108px; flex-shrink: 0;
    font-weight: 500;
}
.cb-spec-label::after { content: ':'; }
.cb-spec-value {
    color: var(--cb-dark); font-weight: 500;
    word-break: break-word; min-width: 0;
}


/* ── Synopsis ── */
.cb-synopsis-text {
    font-size: .79rem; color: #4b5563; line-height: 1.72; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 7;
    -webkit-box-orient: vertical; overflow: hidden;
}


/* ── Actions ── */
.cb-card-actions {
    display: flex; gap: .5rem; align-items: center;
    margin-top: auto; padding-top: .7rem;
    border-top: 1px solid var(--cb-gray-200);
}
.cb-btn-detail {
    flex: 1; display: inline-flex; align-items: center;
    justify-content: center; gap: .45rem;
    background: var(--cb-primary); color: #fff;
    text-decoration: none; font-size: .8rem; font-weight: 700;
    padding: .58rem 1rem; border-radius: 10px;
    transition: background .2s, transform .18s;
}
.cb-btn-detail:hover {
    background: var(--cb-primary-dark); color: #fff;
    transform: translateY(-1px);
}
.cb-btn-detail i { font-size: .7rem; transition: transform .2s; }
.cb-btn-detail:hover i { transform: translateX(3px); }

.cb-card-share-group { display: flex; gap: .35rem; flex-shrink: 0; }
.cb-share-icon-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 8px;
    border: 1.5px solid var(--cb-gray-200); background: none;
    cursor: pointer; font-size: .78rem; color: var(--cb-gray);
    transition: all .22s ease;
}
.cb-share-icon-btn.cb-share-copy:hover {
    border-color: var(--cb-primary); color: var(--cb-primary);
    background: var(--cb-primary-light);
}
.cb-share-icon-btn.cb-share-wa:hover {
    border-color: #25d366; color: #25d366; background: #f0fdf4;
}


/* ================================================================
   EMPTY STATE
   ================================================================ */
.cb-empty-state { text-align: center; padding: 3.5rem 1.5rem 4rem; color: var(--cb-gray); }
.cb-empty-visual {
    position: relative; display: inline-flex;
    align-items: center; justify-content: center;
    width: 160px; height: 160px; margin: 0 auto 2rem;
}
.cb-empty-icon-wrap {
    position: relative; z-index: 3; width: 88px; height: 88px; border-radius: 28px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 2rem;
    box-shadow: 0 12px 36px rgba(0,167,157,.38);
    animation: cbEmptyFloat 3.2s ease-in-out infinite;
}
@keyframes cbEmptyFloat {
    0%,100% { transform: translateY(0) rotate(-2deg); }
    50%      { transform: translateY(-10px) rotate(2deg); }
}
.cb-empty-ring {
    position: absolute; border-radius: 50%;
    border: 2px solid rgba(0,167,157,.14);
    top: 50%; left: 50%; transform: translate(-50%,-50%);
    animation: cbEmptyRing 3s ease-out infinite;
}
.cb-empty-ring-1 { width: 116px; height: 116px; animation-delay: 0s; }
.cb-empty-ring-2 { width: 150px; height: 150px; animation-delay: .85s; }
@keyframes cbEmptyRing {
    0%   { opacity: .55; transform: translate(-50%,-50%) scale(.85); }
    100% { opacity: 0;   transform: translate(-50%,-50%) scale(1.35); }
}
.cb-empty-deco {
    position: absolute; border-radius: 50%; opacity: .72;
    animation: cbEmptyDeco 4s ease-in-out infinite;
}
.cb-empty-deco-1 { width: 14px; height: 14px; background: #6366f1; top: 10px; right: 16px; animation-delay: 0s; }
.cb-empty-deco-2 { width: 10px; height: 10px; background: #f59e0b; bottom: 18px; left: 10px; animation-delay: 1.1s; }
.cb-empty-deco-3 { width: 8px; height: 8px; background: #ef4444; top: 32px; left: 20px; animation-delay: .55s; }
@keyframes cbEmptyDeco {
    0%,100% { transform: translateY(0) scale(1); }
    50%      { transform: translateY(-7px) scale(1.15); }
}
.cb-empty-sparkle {
    position: absolute; font-size: .85rem;
    animation: cbEmptySparkle 3.5s ease-in-out infinite; pointer-events: none;
}
.cb-empty-sparkle-1 { top: -8px; right: -10px; animation-delay: 0s; }
.cb-empty-sparkle-2 { bottom: -6px; left: -12px; animation-delay: 1.2s; }
.cb-empty-sparkle-3 { top: 6px; left: -14px; animation-delay: 2.1s; font-size: .7rem; }
@keyframes cbEmptySparkle {
    0%,100% { transform: scale(1) rotate(0deg); opacity: .7; }
    50%      { transform: scale(1.3) rotate(15deg); opacity: 1; }
}
.cb-empty-title { font-size: 1.35rem; font-weight: 800; color: var(--cb-dark); margin: 0 0 .5rem; }
.cb-empty-sub { font-size: .88rem; color: var(--cb-gray); margin: 0 auto; max-width: 320px; line-height: 1.55; }


/* ================================================================
   MOBILE CAROUSEL
   ================================================================ */
.cb-mobile-carousel {
    display: flex; overflow-x: auto;
    scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;
    gap: 1rem;
    padding: 0 calc(50% - 130px) 1rem;
    scrollbar-width: none; -ms-overflow-style: none;
}
.cb-mobile-carousel::-webkit-scrollbar { display: none; }

.cb-mobile-card {
    flex: 0 0 260px;
    scroll-snap-align: center; cursor: pointer;
    background: white; border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(0,0,0,.08);
    transition: transform .2s ease, box-shadow .2s ease;
    -webkit-tap-highlight-color: transparent;
}
.cb-mobile-card:active { transform: scale(.97); box-shadow: 0 2px 10px rgba(0,0,0,.1); }

.cb-m-cover-wrap { position: relative; aspect-ratio: 3 / 4; overflow: hidden; }
.cb-m-cover-img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top; display: block;
}
.cb-m-cover-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,.32) 100%);
    pointer-events: none;
}
.cb-m-cat-badge {
    position: absolute; top: 8px; left: 8px;
    color: white; font-size: .62rem; font-weight: 700;
    padding: 2px 8px; border-radius: 50px;
    white-space: nowrap; max-width: 100px; overflow: hidden; text-overflow: ellipsis;
}
.cb-m-new-badge {
    position: absolute; top: 8px; right: 8px;
    background: #10b981; color: white;
    font-size: .6rem; font-weight: 700; padding: 2px 7px; border-radius: 50px;
}
.cb-m-prem-badge {
    position: absolute; bottom: 8px; right: 8px;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white; width: 24px; height: 24px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .6rem; box-shadow: 0 2px 8px rgba(245,158,11,.4);
}
.cb-m-info { padding: .75rem .85rem .9rem; display: flex; flex-direction: column; gap: .2rem; }
.cb-m-title {
    font-size: .82rem; font-weight: 700; color: var(--cb-dark);
    margin: 0; line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.cb-m-author {
    font-size: .7rem; color: var(--cb-gray); margin: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.cb-m-hint {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .65rem; color: var(--cb-primary); font-weight: 600; margin-top: .1rem;
}
.cb-m-hint i { font-size: .6rem; }

/* Carousel Dots */
.cb-carousel-dots {
    display: flex; justify-content: center; align-items: center;
    gap: 6px; margin: .75rem 0 .25rem;
}
.cb-dot {
    width: 7px; height: 7px; border-radius: 50%; border: none;
    background: var(--cb-gray-200); cursor: pointer;
    transition: background .2s ease, width .2s ease; padding: 0;
}
.cb-dot.active { background: var(--cb-primary); width: 18px; border-radius: 4px; }


/* ================================================================
   MOBILE BOTTOM SHEET
   ================================================================ */
.cb-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.cb-bs-backdrop.active { opacity: 1; visibility: visible; }

.cb-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white; border-radius: 24px 24px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    padding-bottom: env(safe-area-inset-bottom, 1rem);
}
.cb-bottom-sheet.active { transform: translateY(0); }

.cb-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--cb-primary); font-size: .9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.cb-bs-close:hover { background: var(--cb-primary); color: white; }
.cb-bs-content { position: relative; }

/* Cover area */
.cb-bs-cover-wrap {
    position: relative; width: 100%; overflow: hidden;
    aspect-ratio: 3 / 2; max-height: 56vw;
}
.cb-bs-cover-img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top; display: block;
}
.cb-bs-cover-fallback {
    width: 100%; height: 100%; min-height: 180px;
    background: linear-gradient(135deg, var(--cb-primary-light), #d4f3f0);
    display: flex; align-items: center; justify-content: center;
}
.cb-bs-cover-fallback i { font-size: 4rem; color: var(--cb-primary); opacity: .4; }
.cb-bs-drag-handle {
    position: absolute; top: 12px; left: 50%; transform: translateX(-50%);
    width: 40px; height: 4px; background: rgba(255,255,255,.82);
    border-radius: 2px; box-shadow: 0 2px 8px rgba(0,0,0,.18); z-index: 2;
}
.cb-bs-cover-gradient {
    position: absolute; bottom: 0; left: 0; right: 0; height: 110px;
    background: linear-gradient(to top, white 0%, transparent 100%);
    pointer-events: none; z-index: 1;
}

/* Info section */
.cb-bs-info { padding: .6rem 1.4rem 1.8rem; }

/* Top row: category badge + meta */
.cb-bs-top-row {
    display: flex; align-items: center; flex-wrap: wrap;
    gap: .4rem; margin-bottom: .6rem;
}
.cb-bs-meta-row {
    display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; margin-left: auto;
}
.cb-bs-meta-item {
    display: inline-flex; align-items: center; gap: .28rem;
    font-size: .72rem; color: var(--cb-gray);
}
.cb-bs-meta-item i { font-size: .62rem; }
.cb-bs-meta-likes i { color: #ef4444; }

.cb-bs-cat {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .72rem; font-weight: 700;
    border-radius: 50px; padding: .25rem .8rem;
}
.cb-bs-title {
    font-size: 1.15rem; font-weight: 800; color: var(--cb-dark);
    line-height: 1.4; margin: 0 0 .3rem;
}
.cb-bs-author {
    font-size: .82rem; color: var(--cb-gray); margin: 0 0 .9rem;
    display: flex; align-items: center; gap: .4rem;
}
.cb-bs-author-type { opacity: .7; }

/* ── Sheet tabs ── */
.cb-bs-tabs { margin-bottom: .9rem; }
.cb-bs-tabs-nav {
    display: flex;
    border-bottom: 1.5px solid var(--cb-gray-200);
    margin-bottom: .65rem;
}
.cb-bs-tab {
    background: none; border: none;
    padding: .38rem 1rem .48rem;
    font-size: .82rem; font-weight: 600;
    color: var(--cb-gray); cursor: pointer;
    position: relative; transition: color .2s; line-height: 1;
}
.cb-bs-tab::after {
    content: '';
    position: absolute; bottom: -1.5px; left: 0; right: 0;
    height: 2px; background: var(--cb-primary);
    transform: scaleX(0);
    transition: transform .26s cubic-bezier(.4,0,.2,1);
    border-radius: 2px 2px 0 0;
}
.cb-bs-tab.active { color: var(--cb-primary); }
.cb-bs-tab.active::after { transform: scaleX(1); }
.cb-bs-tab-pane { display: none; }
.cb-bs-tab-pane.active { display: block; animation: cbTabFadeIn .22s ease; }

/* ── Sheet spec list (row-based, matches desktop) ── */
.cb-bs-spec-list { display: flex; flex-direction: column; }
.cb-bs-spec-row {
    display: flex; gap: .5rem; align-items: baseline;
    font-size: .8rem; padding: .3rem 0;
    border-bottom: 1px solid rgba(0,0,0,.05); line-height: 1.45;
}
.cb-bs-spec-row:last-child { border-bottom: none; }
.cb-bs-spec-lbl {
    color: var(--cb-gray); min-width: 118px; flex-shrink: 0;
    font-weight: 500; font-size: .76rem;
}
.cb-bs-spec-lbl::after { content: ':'; }
.cb-bs-spec-val { color: var(--cb-dark); font-weight: 500; word-break: break-word; min-width: 0; }

/* ── Synopsis ── */
.cb-bs-synopsis {
    font-size: .82rem; color: #4b5563; line-height: 1.75; margin: 0;
}

/* ── Badges on cover ── */
.cb-bs-prem-badge {
    position: absolute; bottom: 52px; right: 1rem;
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: #fff; display: inline-flex; align-items: center; gap: .3rem;
    padding: .25rem .75rem; border-radius: 50px;
    font-size: .72rem; font-weight: 700;
    box-shadow: 0 3px 10px rgba(245,158,11,.4); z-index: 3;
}
.cb-bs-new-badge-cover {
    position: absolute; top: 1rem; right: 1rem;
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff; font-size: .68rem; font-weight: 700;
    padding: .25rem .75rem; border-radius: 50px; z-index: 3;
    box-shadow: 0 3px 10px rgba(16,185,129,.4);
}

.cb-bs-btn-primary {
    display: flex; align-items: center; justify-content: center; gap: .65rem;
    background: linear-gradient(135deg, #00c4b8, var(--cb-primary));
    color: white; text-decoration: none; padding: .9rem;
    border-radius: 50px; font-weight: 700; font-size: .95rem;
    box-shadow: 0 6px 24px rgba(0,167,157,.35);
    transition: all .3s ease; border: none; cursor: pointer; width: 100%;
}
.cb-bs-btn-primary:hover { color: white; transform: scale(1.02); }

/* Share in sheet */
.cb-bs-share-wrap { margin-top: .85rem; }
.cb-bs-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600; color: var(--cb-gray);
    letter-spacing: .3px; margin-bottom: .5rem; opacity: .6;
}
.cb-bs-share-label::before, .cb-bs-share-label::after {
    content: ''; flex: 1; height: 1px; background: var(--cb-gray-200);
}
.cb-bs-share-row { display: flex; gap: .5rem; }
.cb-bs-share-btn {
    display: inline-flex; align-items: center; justify-content: center;
    gap: .4rem; flex: 1; border: 1.5px solid transparent;
    border-radius: 50px; padding: 9px 12px;
    font-size: .78rem; font-weight: 600; cursor: pointer;
    transition: all .22s ease; white-space: nowrap; line-height: 1; background: none;
}
.cb-bs-share-btn i { font-size: .8rem; }
.cb-bs-share-copy {
    background: color-mix(in srgb, var(--cb-primary) 8%, white);
    border-color: color-mix(in srgb, var(--cb-primary) 22%, transparent); color: var(--cb-primary);
}
.cb-bs-share-copy:hover {
    background: var(--cb-primary); color: white; border-color: var(--cb-primary);
    box-shadow: 0 4px 14px color-mix(in srgb, var(--cb-primary) 30%, transparent);
}
.cb-bs-share-wa { background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28); color: #1da851; }
.cb-bs-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30);
}

/* SweetAlert above backdrop */
.cb-swal-above-sheet { top: 76px !important; right: 1rem !important; z-index: 1100 !important; }

/* Scroll lock */
body.cb-sheet-open { overflow: hidden !important; touch-action: none; }
body.cb-sheet-open .back-to-top {
    opacity: 0 !important; visibility: hidden !important; pointer-events: none !important;
    transition: opacity .3s ease, visibility .3s ease !important;
}

/* Tablet: center sheet */
@media (min-width: 768px) {
    .cb-bottom-sheet { max-width: 480px; left: 50%; transform: translate(-50%, 100%); }
    .cb-bottom-sheet.active { transform: translate(-50%, 0); }
}


/* ================================================================
   PAGINATION WRAP
   ================================================================ */
.cb-pagination-wrap { padding: .5rem 0 1rem; }


/* ================================================================
   RESPONSIVE
   ================================================================ */
@media (max-width: 1199.98px) {
    .cb-grid { grid-template-columns: repeat(2, 1fr); }
    .cb-section-title { font-size: 1.75rem; }
}
@media (max-width: 991.98px) {
    .cb-grid { grid-template-columns: 1fr; }
    .cb-card-cover-col { width: 115px; }
    .cb-card-cover-link { min-height: 200px; }
    .cb-section-title { font-size: 1.5rem; }
}
@media (max-width: 575.98px) {
    .cb-section-title { font-size: 1.4rem; }
    .cb-mobile-card { flex: 0 0 75vw; }
    .cb-mobile-carousel { padding: 0 calc(50% - 37.5vw) 1rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .cb-section-title  { color: #e2e8f0; }
[data-theme="dark"] .cb-section-sub    { color: #9ca3af; }
[data-theme="dark"] .cb-results-info   { color: #9ca3af; }
[data-theme="dark"] .cb-results-info strong { color: #e2e8f0; }
[data-theme="dark"] .cb-book-card      { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .cb-card-title     { color: #e2e8f0; }
[data-theme="dark"] .cb-card-title a   { color: #e2e8f0; }
[data-theme="dark"] .cb-card-meta-row  { color: #9ca3af; }
[data-theme="dark"] .cb-spec-row       { border-bottom-color: rgba(0,167,157,.1); }
[data-theme="dark"] .cb-spec-label     { color: #9ca3af; }
[data-theme="dark"] .cb-spec-value     { color: #e2e8f0; }
[data-theme="dark"] .cb-mobile-card    { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .cb-m-title        { color: #e2e8f0; }
[data-theme="dark"] .cb-m-author       { color: #9ca3af; }
[data-theme="dark"] .cb-bottom-sheet   { background: #1a1f2e; border-color: rgba(0,167,157,.25); }
[data-theme="dark"] .cb-bs-title       { color: #e2e8f0; }
[data-theme="dark"] .cb-bs-meta-row    { color: #9ca3af; }
[data-theme="dark"] .cb-bs-img-gradient { background: linear-gradient(to bottom, transparent, #1a1f2e); }
[data-theme="dark"] .cb-bs-close       { background: #252b3b; color: #9ca3af; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .cb-bs-author      { color: #9ca3af; }
[data-theme="dark"] .cb-bs-tabs-nav    { border-bottom-color: rgba(0,167,157,.15); }
[data-theme="dark"] .cb-bs-tab         { color: #9ca3af; }
[data-theme="dark"] .cb-bs-tab.active  { color: #00c4b8; }
[data-theme="dark"] .cb-bs-spec-row    { border-bottom-color: rgba(0,167,157,.1); }
[data-theme="dark"] .cb-bs-spec-lbl    { color: #9ca3af; }
[data-theme="dark"] .cb-bs-spec-val    { color: #e2e8f0; }
[data-theme="dark"] .cb-bs-synopsis    { color: #cbd5e0; }
[data-theme="dark"] .cb-bs-share-label { color: #9ca3af; }
[data-theme="dark"] .cb-bs-share-btn   { background: #252b3b; border-color: rgba(0,167,157,.2); color: #9ca3af; }

</style>
@endverbatim
