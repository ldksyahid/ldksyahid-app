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

{{-- ── Skeleton cards shared styles ── --}}
@include('components.skeleton-cards.styles')

@verbatim
<style>
/* ================================================================
   NEWS INDEX PAGE  —  prefix: nw-
   ================================================================ */

:root {
    --nw-primary:       #00a79d;
    --nw-primary-dark:  #008b82;
    --nw-primary-light: #e0f7f5;
    --nw-dark:          #1a1a2e;
    --nw-gray:          #6b7280;
    --nw-gray-100:      #f3f4f6;
    --nw-gray-200:      #e5e7eb;
    --nw-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --nw-shadow-hover:  0 14px 40px rgba(0,167,157,.15), 0 2px 8px rgba(0,0,0,.05);
    --nw-radius:        20px;
    --nw-radius-sm:     12px;
    --nw-transition:    all .3s cubic-bezier(.4,0,.2,1);
}

/* ─── Section Header ──────────────────────────────────────────── */
.nw-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--nw-primary-light); color: var(--nw-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600; position: relative;
}
.nw-badge-pulse {
    width: 8px; height: 8px; background: var(--nw-primary);
    border-radius: 50%; position: relative; flex-shrink: 0;
    animation: nwPulse 2s ease infinite;
}
@keyframes nwPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 7px rgba(0,167,157,0); }
}
.nw-section-title { font-size: 2rem; font-weight: 800; color: var(--nw-dark); margin: 0; }
.nw-section-sub   { color: var(--nw-gray); font-size: 1rem; margin: .5rem 0 0; }

/* ─── Results Info ─────────────────────────────────────────────── */
.nw-results-info {
    font-size: .85rem; color: var(--nw-gray);
    padding: .3rem 0;
}
.nw-results-info strong { color: var(--nw-dark); font-weight: 700; }

/* ─── Cards Grid Wrapper (transition) ─────────────────────────── */
#nw-cards-wrap {
    transition: opacity .35s ease, transform .35s ease;
}
#nw-cards-wrap.nw-cards-out {
    opacity: 0;
    transform: translateY(10px);
    pointer-events: none;
}

/* ─── Desktop Grid ─────────────────────────────────────────────── */
.nw-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.75rem;
}

/* ─── News Card ────────────────────────────────────────────────── */
.nw-card {
    background: #fff;
    border-radius: var(--nw-radius);
    overflow: hidden;
    box-shadow: var(--nw-shadow-sm);
    border: 1px solid rgba(0,0,0,.05);
    display: flex;
    flex-direction: column;
    transition: var(--nw-transition);
    position: relative;
}
.nw-card:hover {
    transform: translateY(-8px) scale(1.01);
    box-shadow: var(--nw-shadow-hover), inset 0 0 0 2.5px var(--nw-accent, var(--nw-primary));
    border-color: transparent;
}

/* ── Card Image ── */
.nw-card-img-wrap {
    display: block;
    position: relative;
    overflow: hidden;
    aspect-ratio: 16/9;
    background: var(--nw-gray-100);
    text-decoration: none;
    flex-shrink: 0;
}
.nw-card-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .55s cubic-bezier(.4,0,.2,1);
}
.nw-card:hover .nw-card-img { transform: scale(1.06); }
.nw-card-img-wrap::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,.35) 100%);
    pointer-events: none;
}

/* Date badge on image */
.nw-card-date {
    position: absolute; bottom: 12px; right: 12px;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(6px);
    border-radius: 10px;
    padding: .3rem .55rem;
    display: flex; flex-direction: column; align-items: center;
    z-index: 2; line-height: 1;
}
.nw-card-date-num {
    font-size: 1.1rem; font-weight: 800; color: #fff; line-height: 1;
}
.nw-card-date-month {
    font-size: .62rem; font-weight: 600; color: rgba(255,255,255,.8);
    text-transform: uppercase; letter-spacing: .5px;
}

@keyframes nwBadgePop {
    0% { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

/* ── Card Body ── */
.nw-card-body {
    padding: 1.25rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: .65rem;
}

/* Publisher badge */
.nw-card-publisher {
    display: inline-block;
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .4px;
    color: var(--nw-accent, var(--nw-primary));
    background: color-mix(in srgb, var(--nw-accent, var(--nw-primary)) 12%, white);
    padding: .22rem .75rem; border-radius: 50px;
    align-self: flex-start;
    border: 1px solid color-mix(in srgb, var(--nw-accent, var(--nw-primary)) 22%, white);
}

/* Title with animated underline */
.nw-card-title {
    font-size: 1rem; font-weight: 800;
    color: var(--nw-dark); margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; line-height: 1.45;
}
.nw-card-title a {
    color: inherit; text-decoration: none;
    background-image: linear-gradient(var(--nw-accent, var(--nw-primary)), var(--nw-accent, var(--nw-primary)));
    background-size: 0% 2px; background-repeat: no-repeat;
    background-position: left bottom;
    transition: background-size .35s ease, color .25s ease;
}
.nw-card:hover .nw-card-title a {
    background-size: 100% 2px;
    color: var(--nw-accent, var(--nw-primary));
}

/* Excerpt */
.nw-card-excerpt {
    font-size: .85rem; color: var(--nw-gray);
    line-height: 1.65; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}

/* People row (reporter / editor) */
.nw-card-people {
    display: flex; flex-wrap: wrap; gap: .5rem .75rem;
    padding: .65rem 0;
    border-top: 1px solid var(--nw-gray-100);
    border-bottom: 1px solid var(--nw-gray-100);
    margin: auto 0 0;
}
.nw-card-people--sm { margin: .25rem 0 0; }

.nw-card-people-divider {
    width: 1px; background: var(--nw-gray-200);
    align-self: stretch;
}

.nw-card-meta-row {
    display: flex; align-items: center; gap: .5rem; min-width: 0;
}
.nw-card-avatar {
    width: 28px; height: 28px; border-radius: 8px;
    background: var(--nw-primary-light);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.nw-card-avatar i { color: var(--nw-primary); font-size: .7rem; }
.nw-card-meta-info { display: flex; flex-direction: column; min-width: 0; }
.nw-card-meta-label {
    font-size: .6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .4px; color: var(--nw-gray); opacity: .75; line-height: 1;
}
.nw-card-meta-name {
    font-size: .78rem; font-weight: 700; color: var(--nw-dark);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    max-width: 120px;
}

/* Read button */
.nw-read-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    font-size: .82rem; font-weight: 700;
    color: var(--nw-accent, var(--nw-primary));
    text-decoration: none;
    padding: .55rem 1.1rem;
    background: color-mix(in srgb, var(--nw-accent, var(--nw-primary)) 10%, white);
    border-radius: 50px;
    align-self: flex-start;
    border: 1.5px solid color-mix(in srgb, var(--nw-accent, var(--nw-primary)) 25%, white);
    transition: var(--nw-transition);
    overflow: hidden;
    position: relative;
}
.nw-read-btn::before {
    content: '';
    position: absolute; inset: 0;
    background: var(--nw-accent, var(--nw-primary));
    transform: scaleX(0); transform-origin: left;
    transition: transform .3s ease;
    z-index: 0;
}
.nw-read-btn:hover::before { transform: scaleX(1); }
.nw-read-btn span, .nw-read-btn i {
    position: relative; z-index: 1; transition: color .3s ease;
}
.nw-read-btn:hover span, .nw-read-btn:hover i { color: white; }
.nw-read-btn i { font-size: .72rem; transition: transform .3s ease, color .3s ease; }
.nw-read-btn:hover i { transform: translateX(3px); }

/* ─── Card Share Section ─────────────────────────────────────────── */
.nw-card-share {
    display: flex; align-items: center; gap: .5rem;
    padding-top: .75rem;
    border-top: 1.5px solid #f1f3f5;
    margin-top: auto;
}
.nw-card-share-label {
    font-size: .6rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .5px;
    color: #adb5bd; flex-shrink: 0;
}
.nw-card-share-btns { display: flex; gap: .35rem; margin-left: auto; }
.nw-card-share-btn {
    width: 34px; height: 34px; border-radius: 10px;
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    font-size: .82rem;
    transition: transform .15s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
    -webkit-tap-highlight-color: transparent;
}
.nw-card-share-btn:hover  { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.12); }
.nw-card-share-btn:active { transform: scale(.88); }
.nw-card-share-btn--copy { background: linear-gradient(135deg, #e0f7f5, #b2ede9); color: #00a79d; }
.nw-card-share-btn--wa   { background: linear-gradient(135deg, #dcfce7, #bbf7d0); color: #16a34a; }
.nw-card-share-btn--tw   { background: #1a1a2e; color: white; }
.nw-card-share-btn--copy:hover { background: linear-gradient(135deg, #00a79d, #008b82); color: white; }
.nw-card-share-btn--wa:hover   { background: linear-gradient(135deg, #25d366, #128c7e); color: white; }
.nw-card-share-btn--tw:hover   { background: #000; color: white; }
.xi { font-weight: 900; font-size: .95em; font-family: 'Arial Black', Arial, sans-serif; line-height: 1; }


/* ─── Empty State ──────────────────────────────────────────────── */
.nw-empty-state {
    text-align: center; padding: 3.5rem 1.5rem;
}
.nw-empty-visual {
    position: relative; width: 120px; height: 120px;
    margin: 0 auto 1.5rem;
}
.nw-empty-deco, .nw-empty-ring {
    position: absolute; border-radius: 50%;
}
.nw-empty-deco { opacity: .35; }
.nw-empty-deco-1 { width: 80px; height: 80px; background: var(--nw-primary-light); top: 10px; left: 20px; animation: nwFloat 3s ease-in-out infinite; }
.nw-empty-deco-2 { width: 50px; height: 50px; background: rgba(99,102,241,.15); top: 0; right: 10px; animation: nwFloat 4s ease-in-out infinite reverse; }
.nw-empty-deco-3 { width: 30px; height: 30px; background: rgba(245,158,11,.15); bottom: 10px; left: 10px; animation: nwFloat 2.5s ease-in-out infinite; }
.nw-empty-ring { border: 2px solid; }
.nw-empty-ring-1 { width: 100px; height: 100px; border-color: rgba(0,167,157,.15); top: 10px; left: 10px; animation: nwSpin 8s linear infinite; }
.nw-empty-ring-2 { width: 70px; height: 70px; border-color: rgba(0,167,157,.1); top: 25px; left: 25px; animation: nwSpin 5s linear infinite reverse; }
.nw-empty-icon-wrap {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
}
.nw-empty-icon-wrap i { font-size: 2.2rem; color: var(--nw-primary); opacity: .7; }
.nw-empty-sparkle { position: absolute; font-size: 1.1rem; animation: nwFloat 3s ease-in-out infinite; }
.nw-empty-sparkle-1 { top: -8px; right: 12px; animation-delay: 0s; }
.nw-empty-sparkle-2 { bottom: -4px; right: 4px; animation-delay: .8s; }
.nw-empty-sparkle-3 { top: 4px; left: 4px; animation-delay: 1.6s; }
@keyframes nwFloat {
    0%,100% { transform: translateY(0); }
    50%      { transform: translateY(-8px); }
}
@keyframes nwSpin { to { transform: rotate(360deg); } }
.nw-empty-title {
    font-size: 1.25rem; font-weight: 800; color: var(--nw-dark); margin: 0 0 .5rem;
}
.nw-empty-sub { font-size: .9rem; color: var(--nw-gray); margin: 0 0 1.25rem; }
.nw-empty-tips { display: flex; flex-wrap: wrap; justify-content: center; gap: .5rem; }
.nw-empty-tip {
    display: inline-block;
    background: var(--nw-gray-100); color: var(--nw-gray);
    border-radius: 50px; padding: .3rem .85rem;
    font-size: .78rem; font-weight: 500;
}


/* ─── Mobile Carousel ──────────────────────────────────────────── */
.nw-mobile-carousel {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    padding: .25rem .5rem 1rem;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.nw-mobile-carousel::-webkit-scrollbar { display: none; }

.nw-mobile-card {
    flex: 0 0 calc(85vw);
    max-width: 340px;
    background: white;
    border-radius: var(--nw-radius);
    overflow: hidden;
    box-shadow: var(--nw-shadow-sm);
    scroll-snap-align: start;
    display: flex; flex-direction: column;
    cursor: pointer;
    transition: transform .2s ease, box-shadow .2s ease;
    position: relative;
    border: 1px solid rgba(0,0,0,.05);
}
.nw-mobile-card:active { transform: scale(.98); }

/* Thumbnail */
.nw-m-thumb {
    position: relative; overflow: hidden;
    aspect-ratio: 16/9; background: var(--nw-gray-100); flex-shrink: 0;
}
.nw-m-thumb img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
    transition: transform .4s ease;
}
.nw-mobile-card:hover .nw-m-thumb img { transform: scale(1.04); }
.nw-m-thumb::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,.5) 100%);
}
.nw-m-tap-hint {
    position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);
    background: rgba(0,0,0,.55); backdrop-filter: blur(6px);
    color: white; font-size: .7rem; font-weight: 600;
    padding: .25rem .75rem; border-radius: 50px; z-index: 3;
    white-space: nowrap; animation: nwTapPulse 2.5s ease infinite;
}
@keyframes nwTapPulse {
    0%,100% { opacity: .85; }
    50%      { opacity: .4; }
}

/* Mobile card body */
.nw-m-body {
    padding: 1rem; display: flex; flex-direction: column; gap: .5rem; flex: 1;
}
.nw-m-publisher {
    font-size: .65rem; font-weight: 800; text-transform: uppercase; letter-spacing: .5px;
    color: var(--nw-accent, var(--nw-primary));
    background: color-mix(in srgb, var(--nw-accent, var(--nw-primary)) 10%, white);
    padding: .18rem .65rem; border-radius: 50px; align-self: flex-start;
    border: 1px solid color-mix(in srgb, var(--nw-accent, var(--nw-primary)) 20%, white);
}
.nw-m-title {
    font-size: .92rem; font-weight: 800; color: var(--nw-dark); margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; line-height: 1.4;
}

/* Carousel dots */
.nw-carousel-dots {
    display: flex; justify-content: center; gap: .5rem;
    padding: .5rem 0 .25rem;
}
.nw-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: var(--nw-gray-200); cursor: pointer;
    transition: width .3s ease, background .3s ease;
}
.nw-dot.active {
    width: 22px; border-radius: 4px; background: var(--nw-primary);
}

/* Pagination wrapper */
.nw-pagination-wrap { margin-top: 1.5rem; }


/* ─── Mobile Bottom Sheet ──────────────────────────────────────── */
.nw-bs-backdrop {
    position: fixed; inset: 0; z-index: 1070;
    background: rgba(26,26,46,.5);
    backdrop-filter: blur(6px);
    opacity: 0; pointer-events: none;
    transition: opacity .35s ease;
}
.nw-bs-backdrop.active { opacity: 1; pointer-events: all; }

.nw-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0; z-index: 1090;
    background: white;
    border-radius: 28px 28px 0 0;
    max-height: 90dvh; overflow-y: auto;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    scrollbar-width: none;
}
.nw-bottom-sheet::-webkit-scrollbar { display: none; }
.nw-bottom-sheet.active { transform: translateY(0); }

/* body scroll lock handled by lockScroll() / unlockScroll() in JS */

.nw-bs-close {
    position: absolute; top: 1rem; right: 1rem; z-index: 10;
    width: 36px; height: 36px; border-radius: 50%; border: none;
    background: rgba(255,255,255,.9);
    backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    font-size: .85rem; color: var(--nw-dark); cursor: pointer;
    transition: var(--nw-transition);
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.nw-bs-close:hover { background: #fff; transform: rotate(90deg); }

/* Sheet image header */
.nw-bs-img-wrap {
    position: relative; width: 100%; height: 200px; overflow: hidden;
    border-radius: 28px 28px 0 0; flex-shrink: 0;
}
.nw-bs-drag-handle {
    position: absolute; top: 10px; left: 50%; transform: translateX(-50%);
    width: 40px; height: 4px; background: rgba(255,255,255,.55);
    border-radius: 2px; z-index: 4;
}
.nw-bs-img-photo {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.nw-bs-img-gradient {
    position: absolute; inset: 0;
    background: linear-gradient(to bottom, transparent 30%, rgba(0,0,0,.6) 100%);
}

/* Sheet info */
.nw-bs-info { padding: 1.25rem 1.5rem 2rem; }
.nw-bs-publisher {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: .4px;
    color: var(--nw-primary);
    background: var(--nw-primary-light);
    padding: .22rem .75rem; border-radius: 50px; margin-bottom: .65rem;
}
.nw-bs-publisher-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--nw-primary); flex-shrink: 0;
    animation: nwPulse 2s infinite;
}
.nw-bs-title {
    font-size: 1.05rem; font-weight: 800; color: var(--nw-dark);
    line-height: 1.4; margin: 0 0 1rem;
}
.nw-bs-metas { display: flex; flex-direction: column; gap: .55rem; margin-bottom: 1.25rem; }
.nw-bs-meta-item { display: flex; align-items: flex-start; gap: .65rem; }
.nw-bs-meta-icon {
    width: 30px; height: 30px; border-radius: 9px;
    background: var(--nw-primary-light);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.nw-bs-meta-icon i { color: var(--nw-primary); font-size: .72rem; }
.nw-bs-meta-text { display: flex; flex-direction: column; }
.nw-bs-meta-label {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .4px; color: var(--nw-gray); opacity: .7; line-height: 1;
}
.nw-bs-meta-name { font-size: .88rem; font-weight: 700; color: var(--nw-dark); line-height: 1.4; }

.nw-bs-btn {
    display: flex; align-items: center; justify-content: center; gap: .55rem;
    width: 100%; padding: .85rem;
    background: linear-gradient(135deg, var(--nw-primary), var(--nw-primary-dark));
    color: white; font-size: .9rem; font-weight: 700;
    border-radius: 16px; text-decoration: none;
    box-shadow: 0 4px 18px rgba(0,167,157,.3);
    transition: var(--nw-transition); margin-bottom: 1rem;
}
.nw-bs-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(0,167,157,.4); color: white; }

/* ─── Bottom Sheet: Share Section ───────────────────────────────── */
.nw-bs-share {
    padding-top: 1.25rem;
    margin-top: 1rem;
    border-top: 2px solid #f1f3f5;
}
.nw-bs-share-title {
    font-size: .68rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .7px;
    color: #adb5bd; margin: 0 0 1rem;
}
.nw-bs-share-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .25rem;
}
.nw-bs-share-btn {
    display: flex; flex-direction: column;
    align-items: center; gap: .45rem;
    padding: .7rem .4rem;
    background: none; border: none;
    cursor: pointer; border-radius: 14px;
    transition: background .18s ease, transform .15s ease;
    -webkit-tap-highlight-color: transparent;
}
.nw-bs-share-btn:hover  { background: #f8f9fa; }
.nw-bs-share-btn:active { transform: scale(.91); }
.nw-bs-share-icon {
    width: 56px; height: 56px; border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem;
    transition: transform .2s ease, box-shadow .2s ease, background .25s ease, color .25s ease;
}
.nw-bs-share-btn:hover .nw-bs-share-icon {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,.1);
}
/* Copy link */
.nw-bs-share-btn--copy .nw-bs-share-icon {
    background: linear-gradient(135deg, #e0f7f5, #b2ede9);
    color: #00a79d;
}
.nw-bs-share-btn--copy.nw-bs-copied .nw-bs-share-icon {
    background: linear-gradient(135deg, #00a79d, #008b82);
    color: white;
}
/* WhatsApp */
.nw-bs-share-btn--wa .nw-bs-share-icon {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #16a34a;
}
.nw-bs-share-btn--wa:hover .nw-bs-share-icon {
    background: linear-gradient(135deg, #25d366, #128c7e);
    color: white;
}
/* X */
.nw-bs-share-btn--tw .nw-bs-share-icon {
    background: #1a1a2e;
    color: white;
}
.nw-bs-share-btn--tw:hover .nw-bs-share-icon {
    background: #000;
    color: white;
}
.nw-bs-share-lbl {
    font-size: .7rem; font-weight: 700;
    color: var(--nw-gray); line-height: 1;
    transition: color .2s ease;
}
.nw-bs-share-btn--copy.nw-bs-copied .nw-bs-share-lbl { color: #00a79d; }

/* SweetAlert z-index fix — must be above backdrop (1040) and sheet (1090) */
.nw-swal-below-nav { top: 76px !important; right: 1rem !important; z-index: 1100 !important; }

/* ─── Responsive adjustments ──────────────────────────────────── */
@media (max-width: 1199.98px) {
    .nw-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 767.98px) {
    .nw-section-title { font-size: 1.55rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
/* Section header */
[data-theme="dark"] .nw-section-badge  { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .nw-section-title  { color: #e2e8f0; }
[data-theme="dark"] .nw-section-sub    { color: #9ca3af; }
[data-theme="dark"] .nw-results-info   { color: #9ca3af; }
[data-theme="dark"] .nw-results-info strong { color: #e2e8f0; }
/* Desktop card */
[data-theme="dark"] .nw-card           { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nw-card-title a   { color: #e2e8f0; }
[data-theme="dark"] .nw-card-excerpt   { color: #9ca3af; }
[data-theme="dark"] .nw-card-meta-name { color: #e2e8f0; }
[data-theme="dark"] .nw-card-meta-label { color: #9ca3af; }
[data-theme="dark"] .nw-card-people    { border-top-color: rgba(0,167,157,.15); border-bottom-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nw-card-people-divider { background: rgba(0,167,157,.2); }
[data-theme="dark"] .nw-card-share     { border-top-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nw-card-share-label { color: #6b7280; }
/* Mobile card */
[data-theme="dark"] .nw-mobile-card    { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nw-m-title        { color: #e2e8f0; }
/* Bottom sheet */
[data-theme="dark"] .nw-bottom-sheet   { background: #1a1f2e; }
[data-theme="dark"] .nw-bs-close       { background: #252b3b; color: #9ca3af; }
[data-theme="dark"] .nw-bs-img-gradient { background: linear-gradient(to bottom, transparent, #1a1f2e); }
[data-theme="dark"] .nw-bs-title       { color: #e2e8f0; }
[data-theme="dark"] .nw-bs-meta-name   { color: #e2e8f0; }
[data-theme="dark"] .nw-card-meta-label   { color: #e2e8f0; }
[data-theme="dark"] .nw-bs-meta-label  { color: #e2e8f0; }
[data-theme="dark"] .nw-bs-share       { border-top-color: rgba(0,167,157,.2); }
[data-theme="dark"] .nw-bs-share-title { color: #6b7280; }
[data-theme="dark"] .nw-bs-share-btn:hover { background: #252b3b; }
[data-theme="dark"] .nw-bs-share-lbl   { color: #9ca3af; }
</style>
@endverbatim
