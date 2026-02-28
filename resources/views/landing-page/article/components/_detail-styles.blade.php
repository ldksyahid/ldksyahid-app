@verbatim
<style>
/* ================================================================
   ARTICLE DETAIL  —  prefix: ad-
   ================================================================ */
:root {
    --ad-primary:       #00a79d;
    --ad-primary-dark:  #008b82;
    --ad-primary-light: #e0f7f5;
    --ad-dark:          #2c3e50;
    --ad-gray:          #7f8c8d;
    --ad-gray-100:      #f3f4f6;
    --ad-gray-200:      #e5e7eb;
}


/* ── Hero ──────────────────────────────────────────────────────── */
.ad-hero {
    position: relative;
    padding: 7.5rem 0 5rem;
    background: linear-gradient(145deg, #f0fffe 0%, #ffffff 55%, #f5f0ff 100%);
    overflow: hidden;
}
.ad-hero-blob {
    position: absolute; border-radius: 50%;
    filter: blur(80px); opacity: .16; pointer-events: none;
}
.ad-hero-blob-1 {
    width: 480px; height: 480px;
    background: var(--ad-primary);
    top: -140px; left: -100px;
}
.ad-hero-blob-2 {
    width: 340px; height: 340px;
    background: #6366f1;
    bottom: -80px; right: 4%;
}
.ad-hero-blob-3 {
    width: 240px; height: 240px;
    background: #f59e0b;
    top: 50%; left: 38%;
}
.ad-hero-inner {
    display: flex; align-items: flex-start; gap: 2.5rem;
}

/* Top fade — blends navbar area into hero */
.ad-hero::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 130px;
    background: linear-gradient(to bottom, white 0%, transparent 100%);
    pointer-events: none; z-index: 2;
}

/* Bottom fade — blends hero into content below */
.ad-hero-fade {
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 130px;
    background: linear-gradient(to bottom, transparent 0%, white 100%);
    pointer-events: none; z-index: 2;
}


/* ── Date Card ─────────────────────────────────────────────────── */
.ad-date-card {
    flex-shrink: 0; width: 128px;
    background: white; border-radius: 24px;
    padding: 1.6rem .9rem 1.4rem; text-align: center;
    box-shadow: 0 10px 40px rgba(0,167,157,.14), 0 2px 10px rgba(0,0,0,.07);
    flex-direction: column; align-items: center;
    position: relative; overflow: hidden; z-index: 3;
}
.ad-date-deco {
    position: absolute; bottom: -24px; right: -24px;
    width: 90px; height: 90px; border-radius: 50%;
    background: linear-gradient(135deg, var(--ad-primary), #6366f1);
    opacity: .1;
}
.ad-date-day {
    font-size: .68rem; font-weight: 800; color: var(--ad-primary);
    text-transform: uppercase; letter-spacing: .7px; margin-bottom: .35rem;
}
.ad-date-num {
    font-size: 3.4rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, var(--ad-primary), var(--ad-primary-dark));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.ad-date-month {
    font-size: .72rem; font-weight: 700; color: var(--ad-gray);
    text-transform: uppercase; letter-spacing: .7px; margin-top: .3rem;
}
.ad-date-year {
    font-size: .68rem; color: var(--ad-gray); opacity: .55; margin-top: .12rem;
}

/* Mobile date chip */
.ad-date-chip {
    display: inline-flex; align-items: center; gap: .45rem;
    background: white; border: 1.5px solid var(--ad-gray-200);
    border-radius: 50px; padding: .4rem .9rem;
    font-size: .75rem; font-weight: 600; color: var(--ad-gray);
    margin-bottom: .75rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.ad-date-chip i { color: var(--ad-primary); font-size: .72rem; }


/* ── Hero Info ─────────────────────────────────────────────────── */
.ad-hero-info { flex: 1; min-width: 0; position: relative; z-index: 3; }

.ad-theme-badge {
    display: inline-flex; align-items: center; gap: .45rem;
    background: var(--ad-primary-light); color: var(--ad-primary);
    padding: .4rem 1.1rem .4rem .75rem; border-radius: 50px;
    font-size: .78rem; font-weight: 700; margin-bottom: .9rem; letter-spacing: .2px;
}
.ad-theme-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--ad-primary); flex-shrink: 0;
    animation: adThemeDot 2s ease-in-out infinite;
}
@keyframes adThemeDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .35; transform: scale(1.6); }
}
.ad-title {
    font-size: 2.1rem; font-weight: 800; line-height: 1.3;
    color: var(--ad-dark); margin: 0 0 1.2rem;
}
.ad-authors {
    display: flex; align-items: center; flex-wrap: wrap;
    gap: .5rem; margin-bottom: 1.25rem;
}
.ad-author-chip {
    display: flex; align-items: center; gap: .5rem;
    background: white; border: 1.5px solid var(--ad-gray-200);
    border-radius: 50px; padding: .38rem .85rem .38rem .5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.ad-author-icon {
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--ad-primary-light);
    display: flex; align-items: center; justify-content: center;
    color: var(--ad-primary); font-size: .62rem; flex-shrink: 0;
}
.ad-author-text { display: flex; flex-direction: column; line-height: 1.25; }
.ad-author-label {
    font-size: .55rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .5px; color: var(--ad-gray); opacity: .6;
}
.ad-author-name { font-size: .8rem; font-weight: 600; color: var(--ad-dark); }
.ad-author-divider { width: 1px; height: 26px; background: var(--ad-gray-200); }


/* ── Share ─────────────────────────────────────────────────────── */
.ad-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600; color: var(--ad-gray);
    letter-spacing: .3px; margin-bottom: .45rem;
    white-space: nowrap; opacity: .5;
}
.ad-share-label::before,
.ad-share-label::after {
    content: ''; flex: 1; height: 1px; background: var(--ad-gray-200);
}
.ad-share-row { display: flex; gap: .5rem; }
.ad-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    border: 1.5px solid transparent; border-radius: 50px;
    padding: 7px 16px; font-size: .78rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
}
.ad-share-btn i { font-size: .8rem; }
.ad-share-copy {
    background: color-mix(in srgb, var(--ad-primary) 8%, white);
    border-color: color-mix(in srgb, var(--ad-primary) 22%, transparent);
    color: var(--ad-primary);
}
.ad-share-copy:hover {
    background: var(--ad-primary); color: white; border-color: var(--ad-primary);
    box-shadow: 0 4px 14px color-mix(in srgb, var(--ad-primary) 30%, transparent);
    transform: translateY(-1px);
}
.ad-share-wa {
    background: rgba(37,211,102,.08);
    border-color: rgba(37,211,102,.28); color: #1da851;
}
.ad-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30);
    transform: translateY(-1px);
}
.ad-swal-below-nav { top: 76px !important; right: 1rem !important; }


/* ── Main layout ───────────────────────────────────────────────── */
.ad-main { padding-top: 2rem; padding-bottom: 4rem; }


/* ── Reader Card ───────────────────────────────────────────────── */
.ad-reader-card {
    background: white; border-radius: 22px; overflow: hidden;
    box-shadow: 0 10px 48px rgba(0,0,0,.1), 0 2px 10px rgba(0,0,0,.05);
    border: 1px solid var(--ad-gray-200);
}
.ad-reader-bar {
    display: flex; align-items: center; gap: .75rem;
    padding: .7rem 1rem;
    background: var(--ad-gray-100); border-bottom: 1px solid var(--ad-gray-200);
}
.ad-reader-dots { display: flex; gap: .38rem; flex-shrink: 0; }
.ad-rd { width: 12px; height: 12px; border-radius: 50%; }
.ad-rd-r { background: #ff5f57; }
.ad-rd-y { background: #ffbd2e; }
.ad-rd-g { background: #28c840; }
.ad-reader-url-pill {
    flex: 1; display: flex; align-items: center; gap: .4rem;
    background: white; border: 1px solid var(--ad-gray-200);
    border-radius: 50px; padding: .26rem .85rem;
    font-size: .7rem; color: var(--ad-gray); min-width: 0;
    box-shadow: inset 0 1px 3px rgba(0,0,0,.04);
}
.ad-reader-url-pill i { font-size: .62rem; color: #28c840; flex-shrink: 0; }
.ad-reader-open {
    flex-shrink: 0; width: 28px; height: 28px; border-radius: 8px;
    border: 1.5px solid var(--ad-gray-200); background: white;
    color: var(--ad-gray); display: flex; align-items: center;
    justify-content: center; font-size: .62rem; text-decoration: none;
    transition: all .2s ease;
}
.ad-reader-open:hover { background: var(--ad-primary); color: white; border-color: var(--ad-primary); }
.ad-reader-body iframe { width: 100%; min-height: 640px; border: none; display: block; }


/* ── Sidebar (desktop) ─────────────────────────────────────────── */
.ad-sidebar {
    background: white; border-radius: 24px; padding: 1.25rem;
    box-shadow: 0 6px 30px rgba(0,0,0,.08), 0 1px 6px rgba(0,0,0,.04);
    border: 1px solid var(--ad-gray-200);
    position: sticky; top: 88px;
}
.ad-sidebar-header {
    display: flex; align-items: center; gap: .75rem;
    margin-bottom: 1.1rem; padding-bottom: .9rem;
    border-bottom: 1.5px solid var(--ad-gray-200);
}
.ad-sidebar-icon-wrap {
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.ad-sidebar-icon-wrap i {
    font-size: 1.4rem;
    background: linear-gradient(135deg, var(--ad-primary) 0%, #6366f1 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(0 2px 10px rgba(0,167,157,.5));
    animation: adIconPulse 2.8s ease-in-out infinite;
}
@keyframes adIconPulse {
    0%, 100% { transform: scale(1); filter: drop-shadow(0 2px 10px rgba(0,167,157,.45)); }
    50%       { transform: scale(1.18); filter: drop-shadow(0 3px 16px rgba(0,167,157,.65)); }
}
.ad-sidebar-title { font-size: .92rem; font-weight: 800; color: var(--ad-dark); margin: 0; }
.ad-sidebar-sub { font-size: .68rem; color: var(--ad-gray); margin: 0; opacity: .65; }

/* Horizontal list cards */
.ad-related-list { display: flex; flex-direction: column; gap: .5rem; }
.ad-related-card {
    display: flex; align-items: stretch;
    border-radius: 14px; overflow: hidden;
    text-decoration: none; background: white;
    border: 1.5px solid var(--ad-gray-200);
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    transition: all .3s cubic-bezier(.4,0,.2,1);
}
.ad-related-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,167,157,.15);
    border-color: var(--ad-primary);
}

/* Image — left side */
.ad-related-img-wrap {
    position: relative; width: 72px; flex-shrink: 0; overflow: hidden;
}
.ad-related-img-wrap img {
    width: 100%; height: 100%; object-fit: cover; object-position: top; display: block;
    transition: transform .4s ease;
}
.ad-related-card:hover .ad-related-img-wrap img { transform: scale(1.06); }
.ad-related-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to right, rgba(0,0,0,.25) 0%, transparent 80%);
}

/* Info — right side */
.ad-related-body {
    flex: 1; min-width: 0;
    padding: .55rem .7rem; display: flex; flex-direction: column; justify-content: center;
}
.ad-related-title {
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; line-height: 1.38;
    font-size: .75rem; font-weight: 700; color: var(--ad-dark);
    margin-bottom: .2rem;
}
.ad-related-date {
    font-size: .6rem; color: var(--ad-gray); opacity: .6;
    display: flex; align-items: center; gap: .25rem;
}
.ad-related-date i { font-size: .55rem; }


/* ── Bottom actions (Artikel Lainnya only) ──────────────────────── */
.ad-actions {
    margin-top: 2rem; padding: 1rem 0;
}
.ad-back-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--ad-primary-light);
    border: 1.5px solid color-mix(in srgb, var(--ad-primary) 25%, transparent);
    color: var(--ad-primary); text-decoration: none;
    border-radius: 50px; padding: .6rem 1.4rem;
    font-size: .85rem; font-weight: 700; transition: all .22s ease;
}
.ad-back-btn:hover {
    background: var(--ad-primary); color: white;
    box-shadow: 0 4px 14px rgba(0,167,157,.28);
    transform: translateX(-3px);
}
.ad-back-btn i { font-size: .75rem; }


/* ── Section divider ─────────────────────────────────────────────── */
.ad-section-divider {
    display: flex; align-items: center; gap: .75rem;
    margin: 2rem 0 1.25rem;
}
.ad-section-divider::before,
.ad-section-divider::after {
    content: ''; flex: 1; height: 3px; border-radius: 2px;
    background: linear-gradient(to right, transparent, var(--ad-primary), transparent);
    opacity: .35;
}
.ad-section-divider-icon {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg, var(--ad-primary-light), #d4f3f0);
    border: 2px solid color-mix(in srgb, var(--ad-primary) 25%, transparent);
    display: flex; align-items: center; justify-content: center;
    color: var(--ad-primary); font-size: .9rem;
    box-shadow: 0 4px 14px rgba(0,167,157,.18);
}


/* ── Back-to-top: hide smoothly when sheet open ─────────────────── */
.back-to-top { transition: opacity .35s ease, visibility .35s ease !important; }
body.ad-rj-open .back-to-top { opacity: 0 !important; visibility: hidden !important; pointer-events: none !important; }


/* ── Hide AnyFlip & prebid ads ──────────────────────────────────── */
.fh5---banner---container { display: none !important; }
[id^="prebid-modal-host-div-"] { display: none !important; }


/* ── Disqus ─────────────────────────────────────────────────────── */
.ad-disqus-wrap {
    background: white; border-radius: 22px;
    padding: 2rem; border: 1px solid var(--ad-gray-200);
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    margin-bottom: 2rem;
}


/* ── Mobile: Floating Baca Juga button ──────────────────────────── */
.ad-rj-float {
    position: fixed; bottom: 1.75rem; left: 50%;
    transform: translateX(-50%);
    z-index: 1060;
    animation: adRjFloatBounce 2.8s ease-in-out infinite;
}
@keyframes adRjFloatBounce {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50%       { transform: translateX(-50%) translateY(-5px); }
}
.ad-rj-float-btn {
    display: flex; align-items: center; gap: .48rem;
    background: linear-gradient(135deg, var(--ad-primary) 0%, var(--ad-primary-dark) 100%);
    color: white; border: none; border-radius: 50px;
    padding: .6rem 1.2rem; font-size: .8rem; font-weight: 700;
    box-shadow: 0 6px 22px rgba(0,167,157,.40);
    cursor: pointer; transition: box-shadow .25s ease; white-space: nowrap;
}
.ad-rj-float-btn:hover { box-shadow: 0 10px 30px rgba(0,167,157,.52); }
.ad-rj-float-icon {
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    font-size: .9rem; color: rgba(255,255,255,.9);
}
.ad-rj-badge {
    background: rgba(0,0,0,.18); border-radius: 50px;
    padding: .1rem .5rem; font-size: .72rem; font-weight: 800;
}


/* ── Mobile: Baca Juga Bottom Sheet ─────────────────────────────── */
.ad-rj-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.5);
    backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.ad-rj-backdrop.active { opacity: 1; visibility: visible; }

.ad-rj-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: #f8f9fa; border-radius: 28px 28px 0 0;
    z-index: 1075; max-height: 85dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    padding-bottom: env(safe-area-inset-bottom, 1.5rem);
}
.ad-rj-sheet.active { transform: translateY(0); }
body.ad-rj-open { overflow: hidden !important; touch-action: none; }

.ad-rj-header {
    padding: 0 0 1rem;
    border-bottom: 1px solid var(--ad-gray-200);
    margin-bottom: .1rem;
}
.ad-rj-header::before {
    content: '';
    display: block;
    width: 44px; height: 4px; border-radius: 2px;
    background: #ccc;
    margin: .85rem auto .5rem;
}
.ad-rj-header-row {
    display: flex; align-items: center; gap: .7rem;
    padding: 0 1.2rem;
}
.ad-rj-header-icon {
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.ad-rj-header-icon i {
    font-size: 1.25rem;
    background: linear-gradient(135deg, var(--ad-primary) 0%, #6366f1 100%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(0 2px 10px rgba(0,167,157,.5));
    animation: adIconPulse 2.8s ease-in-out infinite;
}
.ad-rj-header-title {
    font-size: .92rem; font-weight: 800; color: var(--ad-dark); margin: 0;
}
.ad-rj-header-sub {
    font-size: .65rem; color: var(--ad-gray); margin: 0; opacity: .65;
}
.ad-rj-close {
    margin-left: auto;
    width: 32px; height: 32px; border-radius: 50%; border: none;
    background: var(--ad-gray-200);
    display: flex; align-items: center; justify-content: center;
    color: var(--ad-gray); font-size: .72rem; cursor: pointer;
    transition: background .2s ease; flex-shrink: 0;
}
.ad-rj-close:hover { background: #d1d5db; }

/* Horizontal list — mobile sheet */
.ad-rj-grid {
    display: flex; flex-direction: column;
    gap: .45rem; padding: .7rem .9rem 1.25rem;
}
.ad-rj-item {
    display: flex; align-items: stretch;
    border-radius: 12px; overflow: hidden;
    text-decoration: none; background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,.07);
    border: 1.5px solid var(--ad-gray-200);
    transition: transform .2s ease;
}
.ad-rj-item:active { transform: scale(.98); }

.ad-rj-item-img {
    position: relative; width: 68px; flex-shrink: 0; overflow: hidden;
}
.ad-rj-item-img img {
    width: 100%; height: 100%; object-fit: cover; object-position: top; display: block;
}
.ad-rj-item-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to right, rgba(0,0,0,.22) 0%, transparent 80%);
}
.ad-rj-item-body {
    flex: 1; min-width: 0;
    padding: .45rem .6rem; display: flex; flex-direction: column; justify-content: center;
}
.ad-rj-item-title {
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; line-height: 1.38;
    font-size: .7rem; font-weight: 700; color: var(--ad-dark);
    margin-bottom: .18rem;
}
.ad-rj-item-date {
    font-size: .58rem; color: var(--ad-gray); opacity: .6;
    display: flex; align-items: center; gap: .22rem;
}
.ad-rj-item-date i { font-size: .52rem; }


/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .ad-reader-body iframe { min-height: 520px; }
}
@media (max-width: 767.98px) {
    .ad-hero { padding: 6.5rem 0 4.5rem; }
    .ad-title { font-size: 1.65rem; }
    .ad-reader-body iframe { min-height: 460px; }
}
@media (max-width: 575.98px) {
    .ad-title { font-size: 1.4rem; }
    .ad-share-btn span { display: none; }
    .ad-share-btn { padding: 8px 13px; }
    .ad-disqus-wrap { padding: 1.25rem; }
}
</style>
@endverbatim
