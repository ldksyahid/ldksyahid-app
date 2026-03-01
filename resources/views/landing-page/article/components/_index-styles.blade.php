{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

{{-- ── Pagination shared styles ── --}}
@include('components.pagination-custom.styles')

{{-- ── Search-Filter-Bar component styles ── --}}
@include('components.search-filter-bar.styles')

{{-- ── Search-Filter-Bar modal styles (shared) ── --}}
@include('components.search-filter-bar.modal-styles')

{{-- ── Select2 CSS ── --}}
<link href="{{ asset('assets/external/css/select2.min.css') }}" rel="stylesheet" />

@verbatim
<style>
/* ================================================================
   ARTICLE PAGE  —  styles prefix: ar-
   ================================================================ */

:root {
    --ar-primary:       #00a79d;
    --ar-primary-dark:  #008b82;
    --ar-primary-light: #e0f7f5;
    --ar-dark:          #2c3e50;
    --ar-gray:          #7f8c8d;
    --ar-gray-100:      #f3f4f6;
    --ar-gray-200:      #e5e7eb;
    --ar-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --ar-shadow-hover:  0 14px 40px rgba(0,167,157,.15), 0 2px 8px rgba(0,0,0,.05);
}


/* ─── Section Header ──────────────────────────────────────────── */
.ar-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--ar-primary-light); color: var(--ar-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600; position: relative;
}
.ar-badge-pulse {
    width: 8px; height: 8px; background: var(--ar-primary);
    border-radius: 50%; position: relative; flex-shrink: 0;
    animation: arPulse 2s ease infinite;
}
@keyframes arPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.ar-section-title { font-size: 2rem; font-weight: 700; color: var(--ar-dark); margin: 0; }
.ar-section-sub   { color: var(--ar-gray); font-size: 1rem; margin: .5rem 0 0; }


{{-- Search/Filter/Sort/Pills styles are in components.search-filter-bar.styles --}}

/* ─── Results Info ────────────────────────────────────────────── */
.ar-results-info {
    font-size: .86rem; color: var(--ar-gray);
}
.ar-results-info strong { color: var(--ar-dark); font-weight: 600; }


/* ─── AJAX Page Transition ────────────────────────────────────── */
#ar-cards-wrap {
    transition: opacity .35s ease, transform .35s ease;
}
#ar-cards-wrap.ar-cards-out {
    opacity: 0; transform: translateY(18px); pointer-events: none;
}


/* ─── Desktop Grid ────────────────────────────────────────────── */
.ar-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}


/* ─── Desktop Article Card ────────────────────────────────────── */
.ar-card {
    --ar-accent: #00a79d;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    transition: all .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    cursor: pointer;
}
.ar-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow:
        0 20px 40px rgba(0,0,0,.08),
        0 4px 20px color-mix(in srgb, var(--ar-accent) 25%, transparent);
}

/* Image — full-width, natural height */
.ar-card-img-wrap {
    display: block;
    position: relative;
    width: 100%;
    overflow: hidden;
    text-decoration: none;
}
.ar-card-img {
    width: 100%; height: auto;
    display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.ar-card:hover .ar-card-img { transform: scale(1.08); }

/* Date badge overlay */
.ar-card-date {
    position: absolute;
    top: 12px; left: 12px;
    background: rgba(255,255,255,.95);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 14px;
    padding: 6px 10px;
    text-align: center;
    box-shadow: 0 2px 12px rgba(0,0,0,.08);
    line-height: 1; z-index: 2;
    transition: transform .3s cubic-bezier(.4,0,.2,1);
}
.ar-card:hover .ar-card-date,
.ar-mobile-card:active .ar-card-date { transform: rotate(-3deg) scale(1.05); }
.ar-card-date-num {
    display: block;
    font-size: 1.15rem; font-weight: 800;
    color: var(--ar-accent);
}
.ar-card-date-month {
    display: block;
    font-size: .6rem; font-weight: 700;
    color: var(--ar-gray); text-transform: uppercase;
    letter-spacing: .5px; margin-top: 1px;
}

/* "Terbaru" badge */
.ar-card-badge-new {
    position: absolute; top: .75rem; right: .75rem; z-index: 2;
    background: linear-gradient(135deg, var(--ar-primary) 0%, #00d9bb 100%);
    color: white; font-size: .67rem; font-weight: 700;
    padding: .22rem .75rem; border-radius: 50px;
    letter-spacing: .4px; text-transform: uppercase;
    box-shadow: 0 3px 10px rgba(0,167,157,.45);
}

/* Body */
.ar-card-body {
    padding: 1.1rem 1.25rem 1.25rem;
    display: flex; flex-direction: column; flex: 1;
}

/* Theme badge */
.ar-card-theme {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(0,167,157,.1);
    background: color-mix(in srgb, var(--ar-accent) 10%, white);
    color: var(--ar-accent);
    padding: 5px 14px 5px 10px; border-radius: 10px;
    font-size: .72rem; font-weight: 700; letter-spacing: .2px;
    box-shadow: 0 2px 8px color-mix(in srgb, var(--ar-accent) 15%, transparent);
    transition: all .3s ease;
    margin-bottom: .6rem;
}
.ar-card-theme::before {
    content: '';
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--ar-accent); flex-shrink: 0;
    animation: arThemeDot 2s ease-in-out infinite;
}
@keyframes arThemeDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: .5; transform: scale(1.4); }
}
.ar-card:hover .ar-card-theme {
    background: var(--ar-accent); color: white;
    box-shadow: 0 4px 14px color-mix(in srgb, var(--ar-accent) 30%, transparent);
}
.ar-card:hover .ar-card-theme::before { background: white; }

/* Title */
.ar-card-title {
    font-size: .95rem; font-weight: 700; line-height: 1.5;
    margin: 0 0 .75rem; flex: 1;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.ar-card-title a {
    color: var(--ar-dark); text-decoration: none;
    background-image: linear-gradient(var(--ar-accent), var(--ar-accent));
    background-size: 0% 2px;
    background-repeat: no-repeat; background-position: left bottom;
    transition: background-size .3s ease, color .3s ease;
    padding-bottom: 1px;
}
.ar-card:hover .ar-card-title a {
    background-size: 100% 2px;
    color: var(--ar-accent);
}

/* People card */
.ar-card-people {
    background: #f8f9fa;
    background: color-mix(in srgb, var(--ar-accent) 5%, #f8f9fa);
    border-radius: 14px;
    padding: .7rem .85rem;
    margin-bottom: .85rem;
    display: flex; flex-direction: column; gap: 0;
    transition: background .3s ease;
}
.ar-card:hover .ar-card-people {
    background: color-mix(in srgb, var(--ar-accent) 8%, #f8f9fa);
}
.ar-card-people-divider {
    height: 1px;
    background: color-mix(in srgb, var(--ar-accent) 12%, transparent);
    margin: .45rem 0; border-radius: 1px;
}
.ar-card-meta-row {
    display: flex; align-items: center; gap: .5rem;
    color: var(--ar-gray); font-size: .8rem; font-weight: 500;
    min-width: 0;
}
.ar-card-avatar {
    width: 28px; height: 28px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; flex-shrink: 0;
    background: rgba(0,167,157,.15);
    background: color-mix(in srgb, var(--ar-accent) 15%, white);
    color: var(--ar-accent);
    transition: transform .3s cubic-bezier(.175,.885,.32,1.275);
}
.ar-card:hover .ar-card-avatar { transform: scale(1.1) rotate(-3deg); }
.ar-card-meta-info {
    display: flex; flex-direction: column;
    min-width: 0; line-height: 1.25;
}
.ar-card-meta-label {
    font-size: .6rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .5px;
    color: var(--ar-gray); opacity: .6;
}
.ar-card-meta-name {
    font-size: .8rem; font-weight: 600; color: var(--ar-dark);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* Read button — full width, fill-on-hover */
.ar-read-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%;
    color: var(--ar-accent);
    background: rgba(0,167,157,.08);
    background: color-mix(in srgb, var(--ar-accent) 8%, transparent);
    font-weight: 700; font-size: .82rem;
    text-decoration: none;
    padding: 10px 18px; border-radius: 14px;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    position: relative; overflow: hidden;
    margin-top: auto;
    border: none;
}
.ar-read-btn::before {
    content: ''; position: absolute; inset: 0;
    background: var(--ar-accent); border-radius: inherit;
    transform: scaleX(0); transform-origin: left;
    transition: transform .35s cubic-bezier(.4,0,.2,1); z-index: 0;
}
.ar-card:hover .ar-read-btn::before { transform: scaleX(1); }
.ar-read-btn span, .ar-read-btn i {
    position: relative; z-index: 1; transition: color .3s ease;
}
.ar-read-btn i { font-size: .72rem; }
.ar-card:hover .ar-read-btn { color: white; box-shadow: 0 6px 20px color-mix(in srgb, var(--ar-accent) 30%, transparent); }
.ar-card:hover .ar-read-btn i { transform: translateX(4px); }


/* ─── Empty State ─────────────────────────────────────────────── */
.ar-empty-state {
    text-align: center;
    padding: 3.5rem 1.5rem 4rem;
    color: var(--ar-gray);
}

/* Visual / illustration area */
.ar-empty-visual {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 160px; height: 160px;
    margin: 0 auto 2rem;
}

/* Central icon bubble */
.ar-empty-icon-wrap {
    position: relative; z-index: 3;
    width: 88px; height: 88px;
    border-radius: 28px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 2rem;
    box-shadow: 0 12px 36px rgba(0,167,157,.38), 0 4px 12px rgba(0,0,0,.06);
    animation: arEmptyFloat 3.2s ease-in-out infinite;
}
@keyframes arEmptyFloat {
    0%, 100% { transform: translateY(0) rotate(-2deg); }
    50%       { transform: translateY(-10px) rotate(2deg); }
}

/* Expanding rings */
.ar-empty-ring {
    position: absolute;
    border-radius: 50%;
    border: 2px solid rgba(0,167,157,.14);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    animation: arEmptyRing 3s ease-out infinite;
}
.ar-empty-ring-1 { width: 116px; height: 116px; animation-delay: 0s; }
.ar-empty-ring-2 { width: 150px; height: 150px; animation-delay: .85s; }
@keyframes arEmptyRing {
    0%   { opacity: .55; transform: translate(-50%, -50%) scale(.85); }
    100% { opacity: 0;   transform: translate(-50%, -50%) scale(1.35); }
}

/* Floating deco dots */
.ar-empty-deco {
    position: absolute;
    border-radius: 50%;
    opacity: .72;
    animation: arEmptyDeco 4s ease-in-out infinite;
}
.ar-empty-deco-1 {
    width: 14px; height: 14px;
    background: #6366f1;
    top: 10px; right: 16px;
    animation-delay: 0s;
}
.ar-empty-deco-2 {
    width: 10px; height: 10px;
    background: #f59e0b;
    bottom: 18px; left: 10px;
    animation-delay: 1.1s;
}
.ar-empty-deco-3 {
    width: 8px; height: 8px;
    background: #ef4444;
    top: 32px; left: 20px;
    animation-delay: .55s;
}
@keyframes arEmptyDeco {
    0%, 100% { transform: translateY(0) scale(1); }
    50%       { transform: translateY(-7px) scale(1.15); }
}

/* Sparkle emoji floating around icon */
.ar-empty-sparkle {
    position: absolute; font-size: .85rem;
    animation: arEmptySparkle 3.5s ease-in-out infinite;
    pointer-events: none; user-select: none;
}
.ar-empty-sparkle-1 { top: -8px;  right: -10px; animation-delay: 0s; }
.ar-empty-sparkle-2 { bottom: -6px; left: -12px; animation-delay: 1.2s; }
.ar-empty-sparkle-3 { top: 6px;  left: -14px;  animation-delay: 2.1s; font-size: .7rem; }
@keyframes arEmptySparkle {
    0%, 100% { transform: scale(1) rotate(0deg); opacity: .7; }
    50%       { transform: scale(1.3) rotate(15deg); opacity: 1; }
}

/* Text */
.ar-empty-title {
    font-size: 1.35rem; font-weight: 800;
    color: var(--ar-dark); margin: 0 0 .5rem;
    letter-spacing: -.2px;
}
.ar-empty-sub {
    font-size: .88rem; color: var(--ar-gray);
    margin: 0 auto .85rem; max-width: 320px; line-height: 1.55;
}

/* Tip pills */
.ar-empty-tips {
    display: flex; flex-wrap: wrap;
    justify-content: center; gap: .45rem;
    margin-top: .5rem;
}
.ar-empty-tip {
    display: inline-flex; align-items: center; gap: .3rem;
    background: #f0fefa;
    border: 1.5px solid rgba(0,167,157,.18);
    border-radius: 50px;
    padding: .32rem 1rem;
    font-size: .78rem; font-weight: 600;
    color: #007d76;
    box-shadow: 0 2px 8px rgba(0,167,157,.07);
}


/* ─── Mobile Carousel ─────────────────────────────────────────── */
.ar-mobile-carousel {
    display: flex;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    gap: 1rem;
    padding: .25rem 1.25rem 1rem;
    scroll-behavior: smooth;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.ar-mobile-carousel::-webkit-scrollbar { display: none; }

.ar-mobile-card {
    --ar-accent: #00a79d;
    flex: 0 0 82vw; max-width: 300px;
    scroll-snap-align: start;
    background: white; border-radius: 18px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.09);
    cursor: pointer;
    transition: transform .28s ease, box-shadow .28s ease;
}
.ar-mobile-card:active {
    transform: scale(.98);
    box-shadow: 0 10px 30px color-mix(in srgb, var(--ar-accent) 25%, transparent);
}

/* Thumb */
.ar-m-thumb {
    position: relative; overflow: hidden;
}
.ar-m-thumb img {
    width: 100%; height: auto;
    display: block; transition: transform .4s ease;
}
.ar-mobile-card:active .ar-m-thumb img { transform: scale(1.04); }

.ar-m-badge-new {
    position: absolute; top: .6rem; right: .6rem; z-index: 2;
    background: linear-gradient(135deg, var(--ar-primary), #00d9bb);
    color: white; font-size: .62rem; font-weight: 700;
    padding: .18rem .65rem; border-radius: 50px;
    letter-spacing: .4px; text-transform: uppercase;
}

/* Tap hint */
.ar-m-tap-hint {
    position: absolute; bottom: 10px; right: 10px;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
    border-radius: 20px; padding: 5px 12px;
    font-size: .7rem; font-weight: 600; color: var(--ar-dark);
    z-index: 2;
    animation: arMTapPulse 2s ease-in-out infinite;
}
@keyframes arMTapPulse {
    0%, 100% { opacity: .9; transform: scale(1); }
    50% { opacity: .6; transform: scale(.97); }
}

/* Body */
.ar-m-body { padding: .85rem 1rem 1rem; }
.ar-m-theme {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(0,167,157,.1);
    background: color-mix(in srgb, var(--ar-accent) 10%, white);
    color: var(--ar-accent);
    font-size: .7rem; font-weight: 700;
    padding: 4px 12px 4px 8px; border-radius: 8px;
    margin-bottom: .45rem;
}
.ar-m-theme::before {
    content: '';
    width: 5px; height: 5px; border-radius: 50%;
    background: var(--ar-accent); flex-shrink: 0;
}
.ar-m-title {
    font-size: .92rem; font-weight: 700; color: var(--ar-dark);
    margin: 0 0 .45rem; line-height: 1.42;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}

/* People card compact — mobile */
.ar-card-people--sm {
    background: rgba(0,167,157,.06);
    background: color-mix(in srgb, var(--ar-accent) 6%, #f8f9fa);
    border-radius: 10px; padding: .5rem .7rem;
    margin-top: .4rem;
}
.ar-card-people--sm .ar-card-avatar {
    width: 24px; height: 24px; border-radius: 8px; font-size: .6rem;
}

/* Carousel dots */
.ar-carousel-dots {
    display: flex; justify-content: center; align-items: center;
    gap: .4rem; padding: .35rem .5rem;
}
.ar-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--ar-gray-200);
    transition: all .3s ease; cursor: pointer;
    flex-shrink: 0;
}
.ar-dot.active {
    width: 20px; border-radius: 3px;
    background: var(--ar-primary);
}


/* ─── Pagination Wrap ─────────────────────────────────────────── */
.ar-pagination-wrap { padding: .5rem 0 1rem; }


/* ─── Mobile Bottom Sheet ─────────────────────────────────────── */
.ar-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 1070;
    opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.ar-bs-backdrop.active { opacity: 1; visibility: visible; }

.ar-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 1075; max-height: 88dvh;
    overflow-y: auto;
    overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
}
.ar-bottom-sheet.active { transform: translateY(0); }

/* Close button — floats over the image */
.ar-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--ar-primary); font-size: .9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.ar-bs-close:hover { background: var(--ar-primary); color: white; }

/* Content — no padding-top; image touches the top */
.ar-bs-content { position: relative; }

/* ── Image area ── */
.ar-bs-img-wrap {
    position: relative;
    width: 100%; height: 280px;
    overflow: hidden;
}
.ar-bs-img-photo {
    width: 100%; height: 500px;
    object-fit: cover; object-position: center top;
    display: block;
}
/* Drag handle bar overlaid on image */
.ar-bs-drag-handle {
    position: absolute; top: 12px; left: 50%;
    transform: translateX(-50%);
    width: 40px; height: 4px;
    background: rgba(255,255,255,.82); border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0,0,0,.18);
    z-index: 2;
}
/* White gradient fade: image → info */
.ar-bs-img-gradient {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 110px;
    background: linear-gradient(to top, white 0%, transparent 100%);
    pointer-events: none; z-index: 1;
}

/* ── Info section ── */
.ar-bs-info { padding: .6rem 1.4rem 2rem; }

/* Theme badge */
.ar-bs-theme {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 14px 5px 10px; border-radius: 10px;
    font-size: .72rem; font-weight: 700;
    margin-bottom: .65rem;
    background: color-mix(in srgb, var(--ar-primary) 10%, white);
    color: var(--ar-primary);
    box-shadow: 0 2px 8px rgba(0,167,157,.12);
    transition: background .3s, color .3s;
}
.ar-bs-theme-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: currentColor; flex-shrink: 0;
    animation: arBsThemeDot 2s ease-in-out infinite;
}
@keyframes arBsThemeDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .5; transform: scale(1.5); }
}

/* Title */
.ar-bs-title {
    font-size: 1.25rem; font-weight: 800;
    color: var(--ar-dark); line-height: 1.4;
    margin: 0 0 1rem;
}

/* Meta items */
.ar-bs-metas {
    display: flex; flex-direction: column; gap: .6rem;
    margin-bottom: 1.5rem;
}
.ar-bs-meta-item {
    display: flex; align-items: center; gap: .65rem;
    color: var(--ar-gray); font-size: .88rem; font-weight: 500;
}
.ar-bs-meta-icon {
    width: 32px; height: 32px; border-radius: 10px;
    background: var(--ar-primary-light);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ar-bs-meta-icon i { color: var(--ar-primary); font-size: .8rem; }
.ar-bs-meta-text { display: flex; flex-direction: column; line-height: 1.3; }
.ar-bs-meta-label {
    font-size: .62rem; font-weight: 600;
    text-transform: uppercase; letter-spacing: .5px;
    color: var(--ar-gray); opacity: .7;
}
.ar-bs-meta-name { font-weight: 600; color: var(--ar-dark); }

/* Read button — full width */
.ar-bs-btn {
    display: flex; align-items: center; justify-content: center; gap: .75rem;
    width: 100%;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    color: white; text-decoration: none;
    padding: 1rem; border-radius: 50px;
    font-weight: 700; font-size: 1rem;
    box-shadow: 0 6px 24px rgba(0,167,157,.35);
    transition: all .3s ease;
}
.ar-bs-btn:hover { color: white; transform: scale(1.02); box-shadow: 0 8px 30px rgba(0,167,157,.45); }


/* ─── Share Section ───────────────────────────────────────────── */
.ar-share-wrap {
    margin-top: .75rem;
}
.ar-bs-share-row { margin-top: .85rem; }

/* Divider with centered "Bagikan" text */
.ar-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600;
    color: var(--ar-gray); letter-spacing: .3px;
    margin-bottom: .5rem; white-space: nowrap;
    opacity: .55;
}
.ar-share-label::before,
.ar-share-label::after {
    content: ''; flex: 1; height: 1px;
    background: var(--ar-gray-200);
}

/* Buttons row */
.ar-share-row {
    display: flex; gap: .5rem;
}
.ar-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1;
    border: 1.5px solid transparent;
    border-radius: 50px;
    padding: 7px 14px;
    font-size: .76rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease;
    white-space: nowrap; line-height: 1;
}
.ar-share-btn i { font-size: .8rem; }

/* Copy — primary tint */
.ar-share-copy {
    background: color-mix(in srgb, var(--ar-primary) 8%, white);
    border-color: color-mix(in srgb, var(--ar-primary) 22%, transparent);
    color: var(--ar-primary);
}
.ar-share-copy:hover {
    background: var(--ar-primary); color: white;
    border-color: var(--ar-primary);
    box-shadow: 0 4px 14px color-mix(in srgb, var(--ar-primary) 30%, transparent);
    transform: translateY(-1px);
}

/* WhatsApp — green tint */
.ar-share-wa {
    background: rgba(37,211,102,.08);
    border-color: rgba(37,211,102,.28);
    color: #1da851;
}
.ar-share-wa:hover {
    background: #25d366; color: white;
    border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30);
    transform: translateY(-1px);
}

/* Mobile card: compact */
.ar-share-wrap--sm .ar-share-label { font-size: .62rem; margin-bottom: .38rem; }
.ar-share-row--sm .ar-share-btn    { padding: 6px 11px; font-size: .72rem; }

/* SweetAlert toast below navbar — top-end position, clear of sticky nav */
.ar-swal-below-nav {
    top: 76px !important;   /* push below sticky navbar (~70px) */
    right: 1rem !important;
}


/* Scroll lock via class (no position:fixed → navbar aman) */
body.ar-sheet-open { overflow: hidden !important; touch-action: none; }
body.ar-sheet-open .back-to-top {
    opacity: 0 !important; visibility: hidden !important; pointer-events: none !important;
}

/* Tablet: center sheet */
@media (min-width: 768px) {
    .ar-bottom-sheet {
        max-width: 480px; left: 50%;
        transform: translate(-50%, 100%);
    }
    .ar-bottom-sheet.active { transform: translate(-50%, 0); }
}


/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1199.98px) {
    .ar-grid { grid-template-columns: repeat(2, 1fr); }
    .ar-section-title { font-size: 1.75rem; }
}
@media (max-width: 991.98px) {
    .ar-section-title { font-size: 1.5rem; }
    .ar-mobile-card { flex: 0 0 78vw; }
}
@media (max-width: 576px) {
    .ar-mobile-card { flex: 0 0 86vw; }
}
</style>
@endverbatim
