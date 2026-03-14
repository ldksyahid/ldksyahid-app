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
   EVENT INDEX PAGE  —  prefix: ev-
   Primary: #00a79d  (follows global --primary)
   ================================================================ */

:root {
    --ev-primary:       #00a79d;
    --ev-primary-dark:  #008f86;
    --ev-primary-light: #e0f7f5;
    --ev-dark:          #1a2c2a;
    --ev-gray:          #6b7280;
    --ev-gray-100:      #f3f4f6;
    --ev-gray-200:      #e5e7eb;
    --ev-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --ev-shadow-hover:  0 20px 50px rgba(0,167,157,.2);
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
#ev-cards-wrap { transition: opacity .35s ease, transform .35s ease; }
#ev-cards-wrap.ev-cards-out { opacity: 0; transform: translateY(16px); pointer-events: none; }

/* ─── Desktop Grid ───────────────────────────────────────────── */
.ev-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
}
@media (max-width: 1199.98px) { .ev-grid { grid-template-columns: repeat(2, 1fr); } }

/* ═══════════════════════════════════════════════════════════════
   EVENT CARD — "Layered Ticket" Design
   ✦ 16:10 image with dark-bottom gradient (top to bottom image)
   ✦ White card body slides UP 24px over image (rounded + teal border)
   ✦ Date = teal calendar sticker at top-LEFT of image
   ✦ Status = color pill at top-RIGHT of image
   ✦ Hover: gentle tilt + teal glow — feels fun & alive
   ✦ Per-card --ev-accent color = division badge + top border accent
   ═══════════════════════════════════════════════════════════════ */
.ev-card {
    background: white;
    border-radius: var(--ev-radius);
    box-shadow: var(--ev-shadow-sm);
    overflow: hidden;
    display: flex; flex-direction: column;
    transition: var(--ev-transition);
    position: relative;
    will-change: transform;
    isolation: isolate;
}
.ev-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--ev-shadow-hover);
}

/* Image area — portrait 3/4 (atas→bawah, poster style) */
.ev-card-img-wrap {
    display: block; position: relative;
    overflow: hidden; aspect-ratio: 3/4;
    background: var(--ev-gray-100);
    flex-shrink: 0;
}
/* Dark gradient at bottom for badge + body transition visibility */
.ev-card-img-wrap::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 40%;
    background: linear-gradient(to bottom, transparent, rgba(0,20,18,.65));
    z-index: 2; pointer-events: none;
}
.ev-card-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .55s ease;
    display: block;
}
.ev-card:hover .ev-card-img { transform: scale(1.07); }

/* Status badge — top-RIGHT */
.ev-card-status {
    position: absolute; top: .75rem; right: .85rem;
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .28rem .75rem;
    border-radius: 50px;
    font-size: .68rem; font-weight: 800;
    letter-spacing: .4px; text-transform: uppercase;
    backdrop-filter: blur(8px);
    z-index: 3;
}
.ev-status-upcoming { background: rgba(16,185,129,.92); color: white; }
.ev-status-ongoing  { background: rgba(245,158,11,.92);  color: white; }
.ev-status-past     { background: rgba(107,114,128,.85); color: white; }
.ev-status-sm { top: .5rem; right: .75rem; font-size: .6rem; padding: .2rem .55rem; }
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

/* "Baru" badge — stacked below status at top-right */
.ev-card-new-badge {
    position: absolute; top: 2.85rem; right: .75rem;
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    color: white; padding: .22rem .65rem;
    border-radius: 50px; font-size: .62rem; font-weight: 800;
    letter-spacing: .5px; text-transform: uppercase;
    z-index: 3;
}

/* Date badge — teal calendar sticker, TOP-LEFT (key fun element) */
.ev-card-date {
    position: absolute; top: .75rem; left: .85rem;
    background: linear-gradient(135deg, var(--ev-primary), var(--ev-primary-dark));
    border-radius: 14px; padding: .4rem .7rem;
    display: flex; flex-direction: column; align-items: center;
    line-height: 1.15; z-index: 3;
    box-shadow: 0 4px 14px rgba(0,167,157,.4);
    border: 2px solid rgba(255,255,255,.8);
    min-width: 42px;
}
.ev-card-date-num   { font-size: 1.2rem; font-weight: 900; color: white; }
.ev-card-date-month { font-size: .58rem; font-weight: 700; color: rgba(255,255,255,.85); text-transform: uppercase; }

/* Card Body — white, slides UP 24px over image with colored top border */
.ev-card-body {
    padding: 1.15rem 1.3rem 1.25rem;
    display: flex; flex-direction: column; flex: 1;
    background: white;
    border-radius: 20px 20px 0 0;
    margin-top: -24px;
    position: relative; z-index: 3;
    border-top: 3px solid var(--ev-accent, var(--ev-primary));
}

/* Division — filled per-card accent pill */
.ev-card-division {
    display: inline-flex; align-items: center; gap: .4rem;
    background: var(--ev-accent, var(--ev-primary));
    color: white;
    font-size: .64rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .5px;
    padding: .24rem .8rem;
    border-radius: 8px;
    margin-bottom: .55rem;
    align-self: flex-start;
    transition: filter .22s ease;
}
.ev-card:hover .ev-card-division { filter: brightness(1.1); }
.ev-division-dot {
    width: 5px; height: 5px; border-radius: 50%;
    background: rgba(255,255,255,.6);
    flex-shrink: 0;
}

/* Title */
.ev-card-title {
    font-size: .97rem; font-weight: 800; color: var(--ev-dark);
    line-height: 1.42; margin: 0 0 .5rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.ev-card-title a { color: inherit; text-decoration: none; transition: color .2s ease; }
.ev-card-title a:hover { color: var(--ev-primary); }

/* Excerpt */
.ev-card-excerpt {
    font-size: .79rem; color: var(--ev-gray);
    line-height: 1.6; margin: 0 0 .7rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Meta rows */
.ev-card-meta { display: flex; flex-direction: column; gap: .22rem; margin-bottom: .85rem; }
.ev-card-meta-row {
    display: flex; align-items: center; gap: .42rem;
    font-size: .74rem; color: var(--ev-gray);
}
.ev-card-meta-row i { color: var(--ev-primary); font-size: .67rem; flex-shrink: 0; }
.ev-card-meta-row span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* Read button — full-width teal gradient */
.ev-read-btn {
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    width: 100%;
    padding: .65rem 1rem;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--ev-primary), var(--ev-primary-dark));
    color: white; font-size: .8rem; font-weight: 700;
    text-decoration: none;
    transition: all .28s ease;
    margin-bottom: .8rem; margin-top: auto;
    border: none; cursor: pointer;
    box-shadow: 0 3px 12px rgba(0,167,157,.28);
}
.ev-read-btn:hover {
    filter: brightness(1.06);
    box-shadow: 0 8px 24px rgba(0,167,157,.45);
    transform: translateY(-1px);
    color: white;
}
.ev-read-btn i { font-size: .7rem; transition: transform .25s ease; }
.ev-read-btn:hover i { transform: translateX(3px); }

/* Share section */
.ev-card-share {
    display: flex; align-items: center; gap: .5rem;
    padding-top: .6rem; border-top: 1.5px solid var(--ev-gray-100);
}
.ev-card-share-label {
    font-size: .64rem; font-weight: 700; color: var(--ev-gray);
    text-transform: uppercase; letter-spacing: .4px; flex-shrink: 0;
}
.ev-card-share-btns { display: flex; gap: .3rem; margin-left: auto; }
.ev-card-share-btn {
    width: 32px; height: 32px; border-radius: 9px;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem;
    transition: transform .2s ease, box-shadow .2s ease;
}
.ev-card-share-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,.15); }
.ev-card-share-btn--copy { background: var(--ev-primary-light); color: var(--ev-primary); }
.ev-card-share-btn--copy:hover { background: var(--ev-primary); color: white; }
.ev-card-share-btn--wa   { background: #dcfce7; color: #16a34a; }
.ev-card-share-btn--wa:hover { background: #25d366; color: white; }
.ev-card-share-btn--tw   { background: #1a1a2e; color: white; }
.ev-card-share-btn--tw:hover { background: #000; }
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
    overflow: hidden;
    scroll-snap-align: center;
    cursor: pointer;
    transition: transform .22s ease, box-shadow .22s ease;
}
.ev-mobile-card:active { transform: scale(.98); }

.ev-m-thumb {
    position: relative; overflow: hidden; aspect-ratio: 3/4;
    background: var(--ev-gray-100);
}
.ev-m-thumb img { width: 100%; height: 100%; object-fit: cover; }
.ev-m-thumb::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 40%;
    background: linear-gradient(to bottom, transparent, rgba(0,20,18,.5));
    z-index: 2; pointer-events: none;
}

.ev-m-tap-hint {
    position: absolute; bottom: .5rem; left: 50%; transform: translateX(-50%);
    background: rgba(0,0,0,.5); color: white;
    padding: .2rem .7rem; border-radius: 50px;
    font-size: .65rem; white-space: nowrap;
    backdrop-filter: blur(4px); z-index: 3;
}
.ev-m-body {
    padding: 1rem 1.1rem 1.1rem;
    background: white;
    border-top: 3px solid var(--ev-accent, var(--ev-primary));
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

.ev-bs-close {
    position: absolute; top: .75rem; right: .85rem;
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 8px rgba(0,0,0,.2);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--ev-dark); font-size: .85rem;
    transition: var(--ev-transition); z-index: 10;
}
.ev-bs-close:hover { background: white; transform: scale(1.1); }

/* Content wrapper — no padding; image is edge-to-edge at top */
.ev-bs-content { position: relative; }

/* ── Image area (like article sheet) ── */
.ev-bs-img-wrap {
    position: relative;
    width: 100%; height: 46vh;
    overflow: hidden;
    /* no border-radius — sheet's overflow-y:auto + border-radius clips corners */
}
.ev-bs-img-photo {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    display: block;
    cursor: zoom-in;
    transition: transform .4s ease;
}
.ev-bs-img-photo:active { transform: scale(1.03); }

/* Drag handle overlaid on image */
.ev-bs-drag-handle {
    position: absolute; top: 12px; left: 50%;
    transform: translateX(-50%);
    width: 40px; height: 4px;
    background: rgba(255,255,255,.82); border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0,0,0,.2);
    z-index: 3;
    pointer-events: none;
}

/* White gradient: image → body */
.ev-bs-img-gradient {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 100px;
    background: linear-gradient(to top, white 0%, transparent 100%);
    pointer-events: none; z-index: 2;
}

/* Expand to fullscreen button */
.ev-bs-img-expand-btn {
    position: absolute; bottom: 1rem; right: 1rem;
    width: 38px; height: 38px; border-radius: 50%;
    background: var(--ev-primary);
    backdrop-filter: blur(6px);
    border: 2px solid rgba(255,255,255,.6);
    cursor: pointer; z-index: 4;
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: .85rem;
    box-shadow: 0 3px 12px rgba(0,167,157,.45);
    transition: var(--ev-transition);
}
.ev-bs-img-expand-btn:hover { background: var(--ev-primary-dark); transform: scale(1.12); }

/* Fallback handle when no image */
.ev-bs-no-img-handle {
    width: 44px; height: 4px;
    background: var(--ev-gray-200); border-radius: 2px;
    margin: .85rem auto 0;
}

/* ── Body — content with padding ── */
.ev-bs-body { padding: .75rem 1.25rem 2rem; }

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
    background: linear-gradient(135deg, var(--ev-primary), var(--ev-primary-dark));
    color: white;
    border-radius: 14px; text-decoration: none;
    font-size: .88rem; font-weight: 700;
    transition: var(--ev-transition); margin-bottom: 1rem;
    box-shadow: 0 4px 14px rgba(0,167,157,.28);
}
.ev-bs-detail-btn:hover { filter: brightness(1.06); color: white; box-shadow: 0 8px 24px rgba(0,167,157,.4); }

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
.ev-bs-share-btn--copy .ev-bs-share-icon { background: linear-gradient(135deg,#e0f7f5,#b2ede9); color: #00a79d; }
.ev-bs-share-btn--wa   .ev-bs-share-icon { background: linear-gradient(135deg,#dcfce7,#bbf7d0); color: #16a34a; }
.ev-bs-share-btn--tw   .ev-bs-share-icon { background: #1a1a2e; color: white; }
.ev-bs-share-btn.ev-bs-copied {
    background: linear-gradient(135deg, #00a79d, #00c4b8);
    box-shadow: 0 4px 14px rgba(0,167,157,.4);
}
.ev-bs-share-btn.ev-bs-copied .ev-bs-share-icon { background: rgba(255,255,255,.22); color: white; }
.ev-bs-share-btn.ev-bs-copied .ev-bs-share-lbl { color: white; }
.ev-bs-share-icon {
    width: 48px; height: 48px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem;
}
.ev-bs-share-lbl { font-size: .68rem; font-weight: 700; color: var(--ev-dark); }

/* ── Lightbox — fullscreen image ── */
.ev-bs-lightbox {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.95);
    z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.ev-bs-lightbox.active { opacity: 1; visibility: visible; }
.ev-bs-lightbox-img {
    max-width: 100%; max-height: 100%;
    object-fit: contain;
    transform: scale(.9);
    transition: transform .3s cubic-bezier(.4,0,.2,1);
}
.ev-bs-lightbox.active .ev-bs-lightbox-img { transform: scale(1); }
.ev-bs-lightbox-close {
    position: absolute; top: 1rem; right: 1rem;
    width: 44px; height: 44px; border-radius: 50%;
    background: rgba(255,255,255,.15); backdrop-filter: blur(6px);
    border: none; cursor: pointer; color: white; font-size: 1.1rem;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s ease;
}
.ev-bs-lightbox-close:hover { background: rgba(255,255,255,.3); }

/* ─── Navbar blur when bottom sheet is open ───────────────── */
.ev-navbar-sheet-active {
    filter: blur(3px) brightness(.9);
    pointer-events: none;
    transition: filter .3s ease;
}

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
