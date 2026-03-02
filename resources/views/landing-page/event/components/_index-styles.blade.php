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

@verbatim
<style>
/* ================================================================
   EVENT INDEX PAGE  —  prefix: ev-
   ================================================================ */

:root {
    --ev-primary:       #00a79d;
    --ev-primary-dark:  #008b82;
    --ev-primary-light: #e0f7f5;
    --ev-dark:          #1a1a2e;
    --ev-gray:          #6b7280;
    --ev-gray-100:      #f3f4f6;
    --ev-gray-200:      #e5e7eb;
    --ev-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --ev-shadow-hover:  0 14px 40px rgba(0,167,157,.15);
    --ev-radius:        20px;
    --ev-transition:    all .3s cubic-bezier(.4,0,.2,1);
}

/* ─── Section Header ────────────────────────────────────────── */
.ev-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--ev-primary-light);
    border: 1.5px solid rgba(0,167,157,.2);
    border-radius: 50px;
    padding: .35rem 1.1rem;
    font-size: .78rem; font-weight: 800; color: var(--ev-primary);
    letter-spacing: .4px; text-transform: uppercase;
    position: relative;
}
.ev-badge-pulse {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--ev-primary);
    animation: evBadgePulse 2s ease infinite;
}
@keyframes evBadgePulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.45); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.ev-section-title {
    font-size: clamp(1.5rem, 3vw, 2.2rem);
    font-weight: 900; color: var(--ev-dark);
    margin-bottom: .5rem;
}
.ev-section-sub {
    font-size: .95rem; color: var(--ev-gray);
    max-width: 560px; margin: 0 auto;
}

/* ─── Results Info ──────────────────────────────────────────── */
.ev-results-info {
    font-size: .83rem; color: var(--ev-gray);
    padding: .35rem .5rem;
}

/* ─── AJAX Transition ────────────────────────────────────────── */
.ev-page-transitioning { opacity: .45; pointer-events: none; transition: opacity .25s ease; }

/* ─── Desktop Grid ───────────────────────────────────────────── */
.ev-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}
@media (max-width: 1199.98px) { .ev-grid { grid-template-columns: repeat(2, 1fr); } }

/* ─── Event Card ─────────────────────────────────────────────── */
.ev-card {
    background: white;
    border-radius: var(--ev-radius);
    box-shadow: var(--ev-shadow-sm);
    border: 1.5px solid var(--ev-gray-100);
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: var(--ev-transition);
    position: relative;
    will-change: transform;
}
.ev-card:hover {
    transform: translateY(-8px) scale(1.01);
    box-shadow: var(--ev-shadow-hover), inset 0 0 0 2.5px var(--ev-accent, var(--ev-primary));
    border-color: transparent;
}

/* Poster image wrap */
.ev-card-img-wrap {
    display: block; position: relative;
    overflow: hidden; aspect-ratio: 4/3;
    background: var(--ev-gray-100);
    flex-shrink: 0;
}
.ev-card-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .5s ease;
}
.ev-card:hover .ev-card-img { transform: scale(1.06); }

/* Status badge */
.ev-card-status {
    position: absolute; top: .75rem; left: .75rem;
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .28rem .75rem;
    border-radius: 50px;
    font-size: .68rem; font-weight: 800;
    letter-spacing: .4px; text-transform: uppercase;
    backdrop-filter: blur(8px);
    z-index: 2;
}
.ev-status-upcoming { background: rgba(16,185,129,.9); color: white; }
.ev-status-ongoing  { background: rgba(245,158,11,.9);  color: white; }
.ev-status-past     { background: rgba(107,114,128,.82); color: white; }
.ev-status-sm { top: .5rem; left: .5rem; font-size: .6rem; padding: .2rem .55rem; }
.ev-status-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: white;
    animation: evStatusPulse 1.6s ease infinite;
    flex-shrink: 0;
}
@keyframes evStatusPulse {
    0%,100% { opacity: 1; transform: scale(1); }
    50%      { opacity: .4; transform: scale(.7); }
}

/* "Baru" badge */
.ev-card-new-badge {
    position: absolute; top: .75rem; right: .75rem;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    color: white; padding: .25rem .7rem;
    border-radius: 50px; font-size: .65rem; font-weight: 800;
    letter-spacing: .5px; text-transform: uppercase;
    z-index: 2;
}

/* Date badge */
.ev-card-date {
    position: absolute; bottom: .75rem; right: .75rem;
    background: rgba(255,255,255,.92);
    backdrop-filter: blur(8px);
    border-radius: 12px; padding: .35rem .6rem;
    display: flex; flex-direction: column; align-items: center;
    line-height: 1.1; z-index: 2;
    box-shadow: 0 2px 10px rgba(0,0,0,.12);
}
.ev-card-date-num   { font-size: 1.1rem; font-weight: 900; color: var(--ev-dark); }
.ev-card-date-month { font-size: .6rem; font-weight: 700; color: var(--ev-primary); text-transform: uppercase; }

/* Card Body */
.ev-card-body {
    padding: 1.25rem 1.35rem 1.35rem;
    display: flex; flex-direction: column; flex: 1;
}

/* Division badge */
.ev-card-division {
    display: inline-flex; align-items: center; gap: .38rem;
    font-size: .68rem; font-weight: 800; color: var(--ev-primary);
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: .55rem;
}
.ev-division-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--ev-accent, var(--ev-primary));
    flex-shrink: 0;
}

/* Title */
.ev-card-title {
    font-size: .98rem; font-weight: 800; color: var(--ev-dark);
    line-height: 1.4; margin: 0 0 .6rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.ev-card-title a { color: inherit; text-decoration: none; transition: color .2s ease; }
.ev-card-title a:hover { color: var(--ev-primary); }

/* Excerpt */
.ev-card-excerpt {
    font-size: .82rem; color: var(--ev-gray);
    line-height: 1.6; margin: 0 0 .85rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Meta rows (date, location) */
.ev-card-meta { display: flex; flex-direction: column; gap: .3rem; margin-bottom: 1rem; }
.ev-card-meta-row {
    display: flex; align-items: center; gap: .45rem;
    font-size: .75rem; color: var(--ev-gray);
}
.ev-card-meta-row i { color: var(--ev-primary); font-size: .7rem; flex-shrink: 0; }
.ev-card-meta-row span {
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* Read button */
.ev-read-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    padding: .52rem 1.1rem; border-radius: 50px;
    background: var(--ev-accent, var(--ev-primary));
    color: white; font-size: .78rem; font-weight: 700;
    text-decoration: none;
    transition: var(--ev-transition);
    align-self: flex-start;
    margin-bottom: 1rem; margin-top: auto;
    border: none; cursor: pointer;
}
.ev-read-btn:hover {
    background: var(--ev-primary-dark);
    box-shadow: 0 4px 18px rgba(0,167,157,.35);
    transform: translateX(3px);
    color: white;
}
.ev-read-btn i { font-size: .7rem; transition: transform .25s ease; }
.ev-read-btn:hover i { transform: translateX(3px); }

/* Share buttons */
.ev-card-share {
    display: flex; align-items: center; gap: .5rem;
    padding-top: .75rem; border-top: 1.5px solid var(--ev-gray-100);
}
.ev-card-share-label {
    font-size: .68rem; font-weight: 700; color: var(--ev-gray);
    text-transform: uppercase; letter-spacing: .4px; flex-shrink: 0;
}
.ev-card-share-btns { display: flex; gap: .35rem; margin-left: auto; }
.ev-card-share-btn {
    width: 34px; height: 34px; border-radius: 10px;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem;
    transition: transform .2s ease, box-shadow .2s ease;
}
.ev-card-share-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.12); }
.ev-card-share-btn--copy { background: linear-gradient(135deg,#e0f7f5,#b2ede9); color: #00a79d; }
.ev-card-share-btn--wa   { background: linear-gradient(135deg,#dcfce7,#bbf7d0); color: #16a34a; }
.ev-card-share-btn--tw   { background: #1a1a2e; color: white; }
.xi { font-weight: 900; font-size: .95em; font-family: 'Arial Black', Arial, sans-serif; line-height: 1; }

/* ─── Empty State ─────────────────────────────────────────────── */
.ev-empty-state {
    text-align: center; padding: 4rem 1rem;
    max-width: 480px; margin: 0 auto;
}
.ev-empty-visual {
    position: relative; width: 120px; height: 120px;
    margin: 0 auto 2rem;
}
.ev-empty-deco {
    position: absolute; border-radius: 50%;
    background: var(--ev-primary-light);
    animation: evEmptyFloat 4s ease-in-out infinite;
}
.ev-empty-deco-1 { width: 50px; height: 50px; top: 0; left: -10px; animation-delay: 0s; }
.ev-empty-deco-2 { width: 35px; height: 35px; bottom: 5px; right: -5px; animation-delay: .8s; }
.ev-empty-deco-3 { width: 25px; height: 25px; top: 25px; right: 10px; animation-delay: 1.6s; }
@keyframes evEmptyFloat {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-8px); }
}
.ev-empty-ring {
    position: absolute; border-radius: 50%;
    border: 2px dashed rgba(0,167,157,.25);
    animation: evEmptyRotate 8s linear infinite;
}
.ev-empty-ring-1 { width: 100px; height: 100px; top: 10px; left: 10px; }
.ev-empty-ring-2 { width: 75px; height: 75px; top: 22px; left: 22px; animation-direction: reverse; animation-duration: 6s; }
@keyframes evEmptyRotate { to { transform: rotate(360deg); } }
.ev-empty-icon-wrap {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: var(--ev-primary);
}
.ev-empty-sparkle { position: absolute; font-size: .9rem; animation: evEmptyFloat 3s ease-in-out infinite; }
.ev-empty-sparkle-1 { top: 5px; right: 15px; animation-delay: .3s; }
.ev-empty-sparkle-2 { bottom: 10px; left: 15px; animation-delay: 1s; }
.ev-empty-sparkle-3 { top: 45px; left: 5px; animation-delay: 1.8s; }
.ev-empty-title { font-size: 1.1rem; font-weight: 800; color: var(--ev-dark); margin-bottom: .5rem; }
.ev-empty-sub   { font-size: .88rem; color: var(--ev-gray); margin-bottom: 1rem; }
.ev-empty-tips  { display: flex; flex-wrap: wrap; gap: .4rem; justify-content: center; }
.ev-empty-tip   {
    background: var(--ev-gray-100); border-radius: 50px;
    padding: .3rem .85rem; font-size: .75rem; color: var(--ev-gray);
}

/* ─── Pagination wrap ─────────────────────────────────────────── */
.ev-pagination-wrap { margin-top: 2.5rem; }

/* ─── Mobile Carousel ────────────────────────────────────────── */
.ev-mobile-carousel {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    padding: .5rem .25rem 1rem;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.ev-mobile-carousel::-webkit-scrollbar { display: none; }

.ev-mobile-card {
    flex: 0 0 82vw;
    max-width: 340px;
    background: white;
    border-radius: var(--ev-radius);
    box-shadow: var(--ev-shadow-sm);
    border: 1.5px solid var(--ev-gray-100);
    overflow: hidden;
    scroll-snap-align: center;
    cursor: pointer;
    transition: transform .22s ease, box-shadow .22s ease;
}
.ev-mobile-card:active { transform: scale(.98); }

.ev-m-thumb {
    position: relative; overflow: hidden; aspect-ratio: 16/9;
    background: var(--ev-gray-100);
}
.ev-m-thumb img { width: 100%; height: 100%; object-fit: cover; }

.ev-m-tap-hint {
    position: absolute; bottom: .5rem; left: 50%; transform: translateX(-50%);
    background: rgba(0,0,0,.55); color: white;
    padding: .2rem .7rem; border-radius: 50px;
    font-size: .65rem; white-space: nowrap;
    backdrop-filter: blur(4px);
}
.ev-m-body {
    padding: 1rem 1.1rem 1.1rem;
}
.ev-m-division {
    font-size: .65rem; font-weight: 800; color: var(--ev-primary);
    text-transform: uppercase; letter-spacing: .5px;
    display: block; margin-bottom: .4rem;
}
.ev-m-title {
    font-size: .92rem; font-weight: 800; color: var(--ev-dark);
    line-height: 1.4; margin: 0 0 .4rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.ev-m-date {
    font-size: .72rem; color: var(--ev-gray);
    display: flex; align-items: center; gap: .35rem;
    margin-bottom: .3rem;
}
.ev-m-date i { color: var(--ev-primary); font-size: .65rem; }

/* ─── Carousel Dots ──────────────────────────────────────────── */
.ev-carousel-dots {
    display: flex; justify-content: center; align-items: center;
    gap: .45rem; padding: .75rem 0 .25rem;
}
.ev-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--ev-gray-200);
    transition: all .25s ease; cursor: pointer;
    border: none; padding: 0;
}
.ev-dot.active {
    background: var(--ev-primary);
    transform: scale(1.3);
    box-shadow: 0 2px 6px rgba(0,167,157,.35);
}

/* ─── Bottom Sheet ───────────────────────────────────────────── */
.ev-bs-backdrop {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(3px);
    z-index: 1040;
    transition: opacity .3s ease;
}
.ev-bs-backdrop.active { display: block; }

.ev-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white;
    border-radius: 24px 24px 0 0;
    z-index: 1090;
    max-height: 92vh;
    overflow-y: auto;
    transform: translateY(100%);
    transition: transform .35s cubic-bezier(.32,1.08,.36,1);
    will-change: transform;
}
.ev-bottom-sheet.open { transform: translateY(0); }
.ev-bottom-sheet::before {
    content: '';
    display: block; width: 44px; height: 4px;
    background: var(--ev-gray-200);
    border-radius: 2px;
    margin: .85rem auto 0;
}

.ev-bs-close {
    position: absolute; top: .75rem; right: .85rem;
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ev-dark); font-size: .85rem;
    transition: var(--ev-transition); z-index: 2;
}
.ev-bs-close:hover { background: var(--ev-gray-100); transform: scale(1.1); }

.ev-bs-content { padding: 1.25rem 1.25rem 2rem; }

/* Bottom sheet inner layout */
.ev-bs-poster {
    width: 100%; border-radius: 16px;
    object-fit: cover; max-height: 220px;
    box-shadow: 0 4px 18px rgba(0,0,0,.1);
    margin-bottom: .85rem;
}
.ev-bs-status-row { display: flex; align-items: center; gap: .5rem; margin-bottom: .6rem; }
.ev-bs-division {
    font-size: .7rem; font-weight: 800; color: var(--ev-primary);
    text-transform: uppercase; letter-spacing: .4px;
}
.ev-bs-title {
    font-size: 1.05rem; font-weight: 800; color: var(--ev-dark);
    line-height: 1.4; margin-bottom: .75rem;
}
.ev-bs-meta { display: flex; flex-direction: column; gap: .35rem; margin-bottom: 1rem; }
.ev-bs-meta-row {
    display: flex; align-items: flex-start; gap: .5rem;
    font-size: .8rem; color: var(--ev-gray);
}
.ev-bs-meta-row i { color: var(--ev-primary); font-size: .72rem; margin-top: .15rem; flex-shrink: 0; }
.ev-bs-excerpt {
    font-size: .82rem; color: #374151; line-height: 1.65;
    margin-bottom: 1rem;
    display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;
    overflow: hidden;
}
.ev-bs-detail-btn {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    width: 100%; padding: .75rem;
    background: var(--ev-primary); color: white;
    border-radius: 14px; text-decoration: none;
    font-size: .88rem; font-weight: 700;
    transition: var(--ev-transition); margin-bottom: 1rem;
}
.ev-bs-detail-btn:hover { background: var(--ev-primary-dark); color: white; }

/* Bottom sheet share */
.ev-bs-share { padding-top: 1rem; border-top: 2px solid var(--ev-gray-100); }
.ev-bs-share-title {
    font-size: .7rem; font-weight: 800; color: var(--ev-gray);
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: .75rem;
}
.ev-bs-share-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: .5rem; }
.ev-bs-share-btn {
    display: flex; flex-direction: column; align-items: center; gap: .4rem;
    padding: .75rem .5rem;
    border-radius: 14px; border: none; cursor: pointer;
    background: var(--ev-gray-100);
    transition: var(--ev-transition);
}
.ev-bs-share-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.1); }
.ev-bs-share-btn--copy { }
.ev-bs-share-btn--wa   { }
.ev-bs-share-btn--tw   { }
.ev-bs-share-btn--copy .ev-bs-share-icon { background: linear-gradient(135deg,#e0f7f5,#b2ede9); color: #00a79d; }
.ev-bs-share-btn--wa   .ev-bs-share-icon { background: linear-gradient(135deg,#dcfce7,#bbf7d0); color: #16a34a; }
.ev-bs-share-btn--tw   .ev-bs-share-icon { background: #1a1a2e; color: white; }
.ev-bs-share-btn.ev-bs-copied .ev-bs-share-icon { background: linear-gradient(135deg,#dcfce7,#bbf7d0); color: #16a34a; }
.ev-bs-share-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem;
}
.ev-bs-share-lbl { font-size: .68rem; font-weight: 700; color: var(--ev-dark); }

/* SweetAlert fix */
.ev-swal-below-nav { top: 76px !important; right: 1rem !important; z-index: 1100 !important; }

/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .ev-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 767.98px) {
    .ev-grid { grid-template-columns: 1fr; }
}
</style>
@endverbatim
