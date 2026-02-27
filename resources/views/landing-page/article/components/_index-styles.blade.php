{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

{{-- ── Pagination shared styles ── --}}
@include('components.pagination-custom.styles')

{{-- ── Search-Filter-Bar component styles ── --}}
@include('components.search-filter-bar.styles')

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
    text-align: center; padding: 4rem 1rem; color: var(--ar-gray);
}
.ar-empty-icon { font-size: 4rem; margin-bottom: 1rem; opacity: .45; }
.ar-empty-state h4 { font-weight: 700; color: var(--ar-dark); margin-bottom: .5rem; }


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
    background: rgba(0,0,0,.52);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 1070;
    display: none; /* hidden entirely so backdrop-filter does NOT bleed onto Bootstrap modal */
}
.ar-bs-backdrop.active { display: block; animation: arBsIn .28s ease forwards; }
@keyframes arBsIn { from { opacity: 0; } to { opacity: 1; } }

.ar-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: #dff4f2;
    border-radius: 24px 24px 0 0;
    z-index: 1075; max-height: 88dvh;
    transform: translateY(100%);
    transition: transform .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column; overflow: hidden;
}
.ar-bottom-sheet.active { transform: translateY(0); }
.ar-bs-handle { display: none; }

.ar-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.72); border: none;
    width: 34px; height: 34px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--ar-primary-dark); font-size: .85rem;
    transition: background .2s, color .2s;
    backdrop-filter: blur(4px); z-index: 2;
}
.ar-bs-close:hover { background: #fecaca; color: #ef4444; }

.ar-bs-content {
    overflow-y: auto; flex: 1;
    padding: 0 1.15rem 2rem;
    scrollbar-width: thin;
    background: linear-gradient(to bottom, #dff4f2 0%, white 220px);
}
.ar-bs-content::before {
    content: ''; display: block;
    width: 40px; height: 4px;
    background: rgba(0,167,157,.4); border-radius: 2px;
    margin: .88rem auto .5rem;
    position: sticky; top: .88rem; z-index: 5;
}

/* Bottom sheet inner elements */
.ar-bs-img {
    border-radius: 16px; overflow: hidden;
    margin-bottom: 1rem; aspect-ratio: 16/8;
}
.ar-bs-img img {
    width: 100%; height: 100%; object-fit: cover;
    object-position: top; display: block;
}
.ar-bs-header {
    padding: .6rem 0 1rem;
    border-bottom: 2px solid var(--ar-primary-light);
    margin-bottom: 1rem;
}
.ar-bs-meta {
    display: flex; align-items: center; flex-wrap: wrap;
    gap: .5rem; margin-bottom: .45rem;
}
.ar-bs-tag {
    background: var(--ar-primary); color: white;
    border-radius: 50px; padding: .2rem .82rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .2px;
}
.ar-bs-date {
    font-size: .75rem; color: var(--ar-gray);
    display: flex; align-items: center; gap: .28rem;
}
.ar-bs-date i { color: var(--ar-primary); font-size: .68rem; }
.ar-bs-title {
    font-size: 1.1rem; font-weight: 700; color: var(--ar-dark);
    margin: 0 0 .55rem; line-height: 1.38;
}
.ar-bs-info {
    font-size: .8rem; color: var(--ar-gray);
    display: flex; flex-direction: column; gap: .22rem;
    margin-bottom: .85rem;
}
.ar-bs-info i { color: var(--ar-primary); width: 14px; }
.ar-bs-actions { display: flex; gap: .6rem; flex-wrap: wrap; }
.ar-bs-read-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    background: var(--ar-primary); color: white;
    font-size: .85rem; font-weight: 700; text-decoration: none;
    padding: .62rem 1.4rem; border-radius: 50px;
    transition: background .22s, transform .22s;
}
.ar-bs-read-btn:hover, .ar-bs-read-btn:active {
    background: var(--ar-primary-dark); transform: translateY(-1px); color: white;
}


/* ─── Custom blur backdrop (replaces Bootstrap's) ────────────── */
/* Bootstrap backdrop disabled via data-bs-backdrop="false".
   Custom div allows full-opacity backdrop-filter: blur to work.
   Using visibility (not display:none) so transitions still fire. */
.ar-fm-backdrop {
    position: fixed; inset: 0;
    background: rgba(0, 0, 0, 0.45);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 1040;
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity .3s ease, visibility .3s ease;
}
.ar-fm-backdrop.active {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

/* ─── Filter Modal (redesigned, vepm-inspired) ───────────────── */
.ar-fm-dialog { max-width: 580px; }

.ar-fm-content {
    border-radius: 28px !important;
    border: 1px solid rgba(0,167,157,.1) !important;
    box-shadow: 0 24px 80px rgba(0,0,0,.18), 0 8px 30px rgba(0,167,157,.12) !important;
    overflow: hidden;
    position: relative;
}
.ar-fm-content::before {
    content: '';
    position: absolute; top: 0; left: 10%; right: 10%;
    height: 2px;
    background: linear-gradient(90deg, transparent, rgba(0,167,157,.45) 30%, rgba(0,167,157,.45) 70%, transparent);
    filter: blur(1px); z-index: 1; pointer-events: none;
}

/* Custom close */
.ar-fm-close {
    position: absolute; top: 1rem; right: 1rem;
    width: 34px; height: 34px;
    background: #f5f5f5; border: none; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--ar-gray); font-size: .85rem;
    transition: background .25s, color .25s, transform .25s;
    z-index: 10;
}
.ar-fm-close:hover {
    background: var(--ar-primary-light); color: var(--ar-primary);
    transform: scale(1.1) rotate(90deg);
}

/* Header */
.ar-fm-header {
    padding: 2rem 2rem 1.35rem;
    text-align: center;
    background: linear-gradient(to bottom, #f0fefa, white);
    border-bottom: 1px solid rgba(0,167,157,.08);
}
.ar-fm-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--ar-primary-light);
    border: 1px solid rgba(0,167,157,.2);
    border-radius: 50px; padding: .35rem 1rem;
    margin-bottom: 1.25rem;
    font-size: .82rem; font-weight: 500; color: var(--ar-primary);
}
.ar-fm-pulse {
    width: 7px; height: 7px; background: var(--ar-primary);
    border-radius: 50%; animation: arPulse 2s ease infinite;
}
.ar-fm-icon-wrap {
    position: relative; display: inline-block;
    margin-bottom: 1rem;
}
.ar-fm-icon {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 1.6rem;
    box-shadow: 0 8px 24px rgba(0,167,157,.35);
    position: relative; z-index: 2;
    animation: arFmIconBounce 3s ease-in-out infinite;
}
@keyframes arFmIconBounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}
.ar-fm-ring {
    position: absolute; border-radius: 50%;
    border: 2px solid rgba(0,167,157,.12);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    animation: arFmRingExpand 3s ease-out infinite;
}
.ar-fm-ring-1 { width: 90px; height: 90px; animation-delay: 0s; }
.ar-fm-ring-2 { width: 120px; height: 120px; animation-delay: .9s; }
@keyframes arFmRingExpand {
    0%   { opacity: .6; transform: translate(-50%, -50%) scale(.8); }
    100% { opacity: 0;  transform: translate(-50%, -50%) scale(1.4); }
}
.ar-fm-title {
    font-size: 1.3rem; font-weight: 700; color: var(--ar-dark);
    margin: 0 0 .3rem;
}
.ar-fm-subtitle {
    font-size: .85rem; color: var(--ar-gray); margin: 0;
}

/* Body */
.ar-fm-body { padding: 1.5rem 1.75rem; }
.ar-fm-field-label {
    display: flex; align-items: center; gap: .55rem;
    margin-bottom: .55rem;
}
.ar-fm-field-icon {
    width: 28px; height: 28px;
    background: var(--ar-primary-light);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.ar-fm-field-icon i { color: var(--ar-primary); font-size: .72rem; }
.ar-fm-label {
    font-size: .85rem; font-weight: 600; color: var(--ar-dark); margin: 0;
}

/* Footer */
.ar-fm-footer {
    padding: 1.1rem 1.75rem 1.5rem;
    display: flex; align-items: center; gap: .65rem;
    border-top: 1px solid rgba(0,167,157,.08);
    background: linear-gradient(to top, #f0fefa, white);
}
.ar-fm-btn-close {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.15rem; border-radius: 50px;
    border: 1.5px solid var(--ar-gray-200); background: white;
    color: var(--ar-gray); font-size: .83rem; font-weight: 600;
    cursor: pointer; transition: border-color .2s, color .2s;
}
.ar-fm-btn-close:hover { border-color: rgba(0,167,157,.3); color: var(--ar-primary); background: var(--ar-primary-light); }
.ar-fm-btn-reset {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .6rem 1.15rem; border-radius: 50px;
    border: 1.5px solid rgba(245,158,11,.4); background: white;
    color: #d97706; font-size: .83rem; font-weight: 600;
    cursor: pointer; transition: background .2s, border-color .2s;
}
.ar-fm-btn-reset:hover { background: #fffbeb; border-color: #d97706; }
.ar-fm-btn-apply {
    flex: 1;
    display: inline-flex; align-items: center; justify-content: center; gap: .55rem;
    padding: .7rem 1.5rem; border-radius: 50px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    color: white; font-size: .88rem; font-weight: 700;
    border: none; cursor: pointer;
    box-shadow: 0 4px 16px rgba(0,167,157,.35);
    transition: filter .22s, box-shadow .22s, transform .18s;
    position: relative; overflow: hidden;
}
.ar-fm-btn-apply:hover {
    filter: brightness(1.08);
    box-shadow: 0 6px 22px rgba(0,167,157,.52);
    transform: translateY(-1px);
}
.ar-fm-btn-apply:active { transform: translateY(0); }
.ar-fm-btn-icon {
    width: 24px; height: 24px;
    background: rgba(255,255,255,.2); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem;
}
.ar-fm-btn-shine {
    position: absolute; top: 0; left: -100%;
    width: 100%; height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,.22), transparent);
    transition: left .6s ease;
}
.ar-fm-btn-apply:hover .ar-fm-btn-shine { left: 100%; }

@media (max-width: 575.98px) {
    .ar-fm-header { padding: 1.75rem 1.5rem 1.1rem; }
    .ar-fm-body { padding: 1rem 1.25rem; }
    .ar-fm-footer { padding: .85rem 1.25rem 1.25rem; flex-wrap: wrap; }
    .ar-fm-btn-apply { order: -1; width: 100%; }
    .ar-fm-title { font-size: 1.15rem; }
    .ar-fm-icon { width: 54px; height: 54px; font-size: 1.35rem; }
    .ar-fm-ring-1 { width: 76px; height: 76px; }
    .ar-fm-ring-2 { width: 104px; height: 104px; }
}

/* Select2 inside modal — selection box */
/* After JS moves .select2-search--inline into ul, the ul contains:
   [pill...] [search textarea]  — all flowing as one horizontal flex row */
.select2-container--default .select2-selection--multiple {
    border: 1.5px solid #d1ece9 !important;
    border-radius: 12px !important;
    padding: 6px 10px !important;
    min-height: 48px !important;
    background: #fafffe !important;
    transition: border-color .2s, box-shadow .2s;
    display: flex !important;
    align-items: center !important;
    position: relative;
    overflow: visible !important;
}
/* Extra right padding when "clear all" button is visible */
.select2-container--default .select2-selection--multiple.select2-selection--clearable {
    padding-right: 28px !important;
}
.select2-container--default.select2-container--focus .select2-selection--multiple,
.select2-container--default.select2-container--open .select2-selection--multiple {
    border-color: var(--ar-primary) !important;
    box-shadow: 0 0 0 3px rgba(0,167,157,.1) !important;
    outline: none !important;
}
/* "Clear all" × — absolute, removed from flex flow */
.select2-container--default .select2-selection--multiple .select2-selection__clear {
    position: absolute !important;
    right: 8px; top: 50%;
    transform: translateY(-50%);
    float: none !important;
    margin: 0 !important;
    padding: 0 3px !important;
    font-size: 1rem; line-height: 1;
    color: var(--ar-gray) !important;
    background: transparent !important;
    border: none !important;
    cursor: pointer;
}
.select2-container--default .select2-selection--multiple .select2-selection__clear:hover {
    color: #ef4444 !important;
}
/* ul is the single flex child — outer container's align-items:center centers the ul */
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    gap: 4px !important;
    flex: 1 !important;
    padding: 0 !important;
    margin: 0 !important;
    list-style: none !important;
    overflow: visible !important;
}
/* Tags/choices — × on RIGHT via flex-direction:row-reverse */
.select2-selection__choice {
    display: inline-flex !important;
    align-items: center;
    flex-direction: row-reverse;   /* × appears after text visually */
    gap: 5px;
    background: linear-gradient(135deg, var(--ar-primary), #00bfb3) !important;
    color: white !important;
    border: none !important;
    border-radius: 50px !important;
    padding: 3px 5px 3px 10px !important;  /* left: text-side, right: ×-side */
    font-size: .78rem !important;
    font-weight: 600 !important;
    margin: 0 !important;
    max-width: calc(100% - 8px);
    flex-shrink: 0;
}
.select2-selection__choice__display {
    white-space: normal;
    word-break: break-word;
    line-height: 1.4;
}
/* Pill × button — solid white circle with teal × for clear visibility */
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 16px;
    height: 16px;
    border-radius: 50% !important;
    border: none !important;
    background: rgba(255,255,255,.92) !important;
    color: var(--ar-primary) !important;
    padding: 0 !important;
    margin: 0 !important;
    font-size: .65rem !important;
    font-weight: 700 !important;
    line-height: 1 !important;
    cursor: pointer;
    transition: background .15s, color .15s;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    background: white !important;
    color: #ef4444 !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove span {
    display: block; line-height: 1;
}
/* Inline search (inside ul via JS) — fills remaining space after pills */
.select2-container--default .select2-selection--multiple .select2-search--inline {
    display: flex !important;
    align-items: center !important;
    flex: 1 !important;
    min-width: 60px !important;
}
.select2-container--default .select2-selection--multiple .select2-search__field {
    width: 100% !important;
    border: none !important;
    outline: none !important;
    background: transparent !important;
    font-size: .875rem !important;
    color: var(--ar-dark) !important;
    resize: none !important;
    padding: 0 !important;
    margin: 0 !important;
    line-height: 1 !important;
    height: 1em !important;
    min-height: unset !important;
}
.select2-container--default .select2-selection--multiple .select2-search__field::placeholder {
    color: #a8c5c3 !important;
}
/* Dropdown */
.select2-dropdown {
    border: 1.5px solid rgba(0,167,157,.25) !important;
    border-radius: 14px !important;
    overflow: hidden;
    font-size: .875rem;
    box-shadow: 0 8px 28px rgba(0,0,0,.1) !important;
    animation: arDropIn .18s ease forwards;
    margin-top: 6px !important;  /* Fix 3: breathing room from input */
}
@keyframes arDropIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}
.select2-search--dropdown { padding: 8px 10px !important; }
.select2-search--dropdown .select2-search__field {
    border: 1.5px solid #e0f2ef !important;
    border-radius: 8px !important;
    padding: 7px 10px !important;
    font-size: .85rem !important;
    outline: none !important;
    transition: border-color .2s;
}
.select2-search--dropdown .select2-search__field:focus {
    border-color: var(--ar-primary) !important;
    box-shadow: 0 0 0 3px rgba(0,167,157,.1);
}
.select2-results__option {
    padding: 11px 16px;  /* Fix 3: more breathing room per option */
    cursor: pointer;
    border-bottom: 1px solid #f0f9f8;
    transition: background .15s, color .15s;
    font-size: .875rem;
    line-height: 1.4;
}
.select2-results__option:last-child { border-bottom: none; }
/* Fix 5: Soft teal hover (no harsh gradient) */
.select2-results__option--highlighted {
    background: var(--ar-primary-light) !important;
    color: #006b63 !important;
}
/* Fix 5: Selected state */
.select2-results__option[aria-selected="true"] {
    background: #e8f8f7 !important;
    color: #007f73 !important;
    font-weight: 600;
}
/* Fix 5: Hover on already-selected option */
.select2-results__option--highlighted[aria-selected="true"] {
    background: #c8edea !important;
    color: #006b63 !important;
}
.select2-results__option[aria-selected="true"]::before {
    content: '✓ '; font-weight: 700; color: var(--ar-primary);
}
.select2-results__options::-webkit-scrollbar { width: 5px; }
.select2-results__options::-webkit-scrollbar-thumb {
    background: var(--ar-primary); border-radius: 10px;
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
