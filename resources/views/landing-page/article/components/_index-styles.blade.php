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
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--ar-shadow-sm);
    transition: transform .3s ease, box-shadow .3s ease;
    display: flex; flex-direction: column;
}
.ar-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--ar-shadow-hover);
}

/* Image */
.ar-card-img-link { display: block; text-decoration: none; }
.ar-card-img-wrap {
    position: relative; aspect-ratio: 16/9; overflow: hidden;
}
.ar-card-img {
    width: 100%; height: 100%; object-fit: cover; object-position: top;
    display: block; transition: transform .45s ease;
}
.ar-card:hover .ar-card-img { transform: scale(1.05); }
.ar-card-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 55%, rgba(0,0,0,.07) 100%);
    pointer-events: none;
}

/* "Terbaru" badge */
.ar-card-badge-new {
    position: absolute; top: .75rem; left: .75rem; z-index: 2;
    background: linear-gradient(135deg, var(--ar-primary) 0%, #00d9bb 100%);
    color: white; font-size: .67rem; font-weight: 700;
    padding: .22rem .75rem; border-radius: 50px;
    letter-spacing: .4px; text-transform: uppercase;
    box-shadow: 0 3px 10px rgba(0,167,157,.45);
}

/* Body */
.ar-card-body {
    padding: 1.1rem 1.35rem 1.35rem;
    display: flex; flex-direction: column; flex: 1;
}
.ar-card-meta { margin-bottom: .55rem; }
.ar-card-date {
    font-size: .76rem; color: var(--ar-gray);
    display: inline-flex; align-items: center; gap: .3rem;
}
.ar-card-date i { color: var(--ar-primary); font-size: .7rem; }

/* Theme badge */
.ar-card-theme {
    display: inline-block;
    background: var(--ar-primary-light); color: var(--ar-primary);
    font-size: .7rem; font-weight: 700;
    padding: .18rem .75rem; border-radius: 50px;
    text-transform: uppercase; letter-spacing: .3px;
    margin-bottom: .6rem;
    transition: background .22s, color .22s;
}
.ar-card:hover .ar-card-theme { background: var(--ar-primary); color: white; }

/* Title with animated underline */
.ar-card-title {
    font-size: 1rem; font-weight: 700; color: var(--ar-dark);
    margin: 0 0 .7rem; line-height: 1.5;
    position: relative; padding-bottom: .65rem;
}
.ar-card-title::after {
    content: ''; position: absolute; bottom: 0; left: 0;
    width: 28px; height: 2.5px;
    background: linear-gradient(90deg, var(--ar-primary), #00d9bb);
    border-radius: 2px; transition: width .35s ease;
}
.ar-card:hover .ar-card-title::after { width: 55%; }
.ar-card-title a { color: inherit; text-decoration: none; transition: color .22s; }
.ar-card:hover .ar-card-title a { color: var(--ar-primary); }

/* Animated bullet info items */
.ar-card-info {
    display: flex; flex-direction: column; gap: .3rem;
    margin-bottom: .9rem; flex: 1;
}
.ar-card-info-item {
    display: flex; align-items: center; gap: .5rem;
    font-size: .8rem; color: var(--ar-gray);
}
.ar-card-info-item strong { color: #5d6d7e; font-weight: 600; }
.ar-bullet {
    display: inline-block; width: 6px; height: 6px; border-radius: 50%;
    background: #b2dfdb; flex-shrink: 0;
    transition: background .25s ease, transform .25s ease;
}
.ar-card:hover .ar-bullet { background: var(--ar-primary); transform: scale(1.6); }

/* CTA — fill-on-hover */
.ar-card-cta { margin-top: auto; }
.ar-read-btn {
    display: inline-flex; align-items: center; gap: .4rem;
    color: var(--ar-primary); font-size: .82rem; font-weight: 700;
    text-decoration: none;
    padding: .46rem 1.05rem;
    border: 1.5px solid var(--ar-primary); border-radius: 50px;
    transition: all .25s ease; overflow: hidden; position: relative;
}
.ar-read-btn::before {
    content: ''; position: absolute; inset: 0;
    background: var(--ar-primary); transform: scaleX(0); transform-origin: left;
    transition: transform .25s ease; z-index: 0;
}
.ar-read-btn span, .ar-read-btn i {
    position: relative; z-index: 1; transition: color .25s ease;
}
.ar-read-btn i { font-size: .78rem; }
.ar-read-btn:hover::before { transform: scaleX(1); }
.ar-read-btn:hover span, .ar-read-btn:hover i { color: white; }


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
    flex: 0 0 82vw; max-width: 300px;
    scroll-snap-align: start;
    background: white; border-radius: 18px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.09);
    cursor: pointer;
    transition: transform .28s ease, box-shadow .28s ease;
}
.ar-mobile-card:active {
    transform: scale(.98);
    box-shadow: 0 10px 30px rgba(0,167,157,.18);
}

/* Thumb */
.ar-m-thumb {
    position: relative; aspect-ratio: 16/10; overflow: hidden;
}
.ar-m-thumb img {
    width: 100%; height: 100%; object-fit: cover; object-position: top;
    display: block; transition: transform .4s ease;
}
.ar-mobile-card:active .ar-m-thumb img { transform: scale(1.04); }
.ar-m-thumb-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,.52) 100%);
    pointer-events: none; z-index: 1;
}
.ar-m-badge-new {
    position: absolute; top: .6rem; left: .6rem; z-index: 2;
    background: linear-gradient(135deg, var(--ar-primary), #00d9bb);
    color: white; font-size: .62rem; font-weight: 700;
    padding: .18rem .65rem; border-radius: 50px;
    letter-spacing: .4px; text-transform: uppercase;
}

/* Body */
.ar-m-body { padding: .85rem 1rem 1rem; }
.ar-m-theme {
    display: inline-block;
    background: var(--ar-primary-light); color: var(--ar-primary);
    font-size: .68rem; font-weight: 700;
    padding: .15rem .65rem; border-radius: 50px;
    text-transform: uppercase; margin-bottom: .38rem;
}
.ar-m-title {
    font-size: .92rem; font-weight: 700; color: var(--ar-dark);
    margin: 0 0 .3rem; line-height: 1.42;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.ar-m-meta {
    font-size: .73rem; color: var(--ar-gray);
    margin: 0 0 .65rem;
    display: flex; align-items: center; gap: .3rem;
}
.ar-m-meta i { color: var(--ar-primary); font-size: .68rem; }
.ar-m-tap-hint {
    display: inline-flex; align-items: center; gap: .35rem;
    background: var(--ar-primary-light); color: var(--ar-primary);
    font-size: .72rem; font-weight: 700;
    padding: .3rem .85rem; border-radius: 50px;
    transition: background .2s, color .2s;
}
.ar-mobile-card:active .ar-m-tap-hint { background: var(--ar-primary); color: white; }
.ar-m-tap-hint i { font-size: .62rem; }

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
    z-index: 1070; opacity: 0; pointer-events: none;
    transition: opacity .3s ease;
}
.ar-bs-backdrop.active { opacity: 1; pointer-events: all; }

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


/* ─── Filter Modal ────────────────────────────────────────────── */
.ar-modal .modal-content {
    border-radius: 20px; border: none;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
}
.ar-modal .modal-header {
    border-bottom: 1px solid var(--ar-gray-200);
    border-radius: 20px 20px 0 0; padding: 1.4rem 1.5rem;
}
.ar-modal .modal-footer {
    border-top: 1px solid var(--ar-gray-200);
    border-radius: 0 0 20px 20px; padding: 1.15rem 1.5rem;
}

/* Select2 inside modal */
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid var(--ar-primary);
}
.select2-dropdown {
    border: 1px solid var(--ar-primary);
    border-radius: 12px; overflow: hidden; font-size: .9rem;
    animation: arDropIn .18s ease forwards;
}
@keyframes arDropIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}
.select2-results__option {
    padding: 9px 14px; cursor: pointer;
    border-bottom: 1px solid #e0f2ef;
    transition: background .15s;
}
.select2-results__option:last-child { border-bottom: none; }
.select2-results__option--highlighted {
    background-color: var(--ar-primary) !important; color: white !important;
}
.select2-results__option[aria-selected="true"] {
    background-color: var(--ar-primary-light); color: #007f73;
}
.select2-selection__choice {
    background-color: var(--ar-primary) !important; color: white !important;
    border-color: var(--ar-primary) !important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: rgba(255,255,255,.85);
    border-right: 1px solid rgba(255,255,255,.3);
}
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    background-color: var(--ar-primary-dark) !important; color: white !important;
}
.select2-results__options::-webkit-scrollbar { width: 5px; }
.select2-results__options::-webkit-scrollbar-thumb {
    background: var(--ar-primary); border-radius: 10px;
}
.select2-search--dropdown .select2-search__field {
    border: none; box-shadow: none;
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
