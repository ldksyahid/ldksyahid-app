{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

{{-- ── Pagination shared styles ── --}}
@include('components.pagination-custom.styles')

@verbatim
<style>
/* ================================================================
   REPORT PAGE  —  styles prefix: rp-
   Palette: --primary:#00a79d  --primary-dark:#008f86
            --primary-light:#e0f7f5  --dark:#282d30  --secondary:#8d9297
   ================================================================ */

:root {
    --rp-primary:       #00a79d;
    --rp-primary-dark:  #008f86;
    --rp-primary-light: #e0f7f5;
    --rp-dark:          #282d30;
    --rp-gray:          #8d9297;
    --rp-gray-100:      #f3f4f6;
    --rp-gray-200:      #e5e7eb;
    --rp-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --rp-shadow-hover:  0 14px 40px rgba(0,167,157,.15), 0 2px 8px rgba(0,0,0,.05);
}


/* ─── Section Header ──────────────────────────────────────────── */
.rp-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--rp-primary-light); color: var(--rp-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.rp-badge-pulse {
    width: 8px; height: 8px; background: var(--rp-primary);
    border-radius: 50%; flex-shrink: 0;
    animation: rpPulse 2s ease infinite;
}
@keyframes rpPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.rp-section-title { font-size: 2rem; font-weight: 700; color: var(--rp-dark); margin: 0; }
.rp-section-sub   { color: var(--rp-gray); font-size: 1rem; margin: .5rem 0 0; }


/* ─── Info Card (Features) ────────────────────────────────────── */
.rp-info-card {
    position: relative; z-index: 1;
    background: white; border-radius: 24px;
    padding: 2rem 2.25rem;
    box-shadow: 0 4px 24px rgba(0,0,0,.06);
    border: 1.5px solid var(--rp-gray-200);
}
.rp-info-desc {
    font-size: .9rem; color: var(--rp-gray); line-height: 1.7;
    margin: 0 0 1.5rem;
}
.rp-features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}
.rp-feature-item {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .85rem 1rem;
    background: var(--rp-gray-100); border-radius: 14px;
    border: 1px solid var(--rp-gray-200);
    transition: border-color .2s ease, box-shadow .2s ease;
}
.rp-feature-item:hover {
    border-color: color-mix(in srgb, var(--rp-primary) 30%, transparent);
    box-shadow: 0 4px 14px rgba(0,167,157,.08);
}
.rp-feature-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: var(--rp-primary-light);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.rp-feature-icon i { color: var(--rp-primary); font-size: .9rem; }
.rp-feature-text { display: flex; flex-direction: column; gap: .2rem; min-width: 0; }
.rp-feature-title {
    font-size: .82rem; font-weight: 700; color: var(--rp-dark); line-height: 1.3;
}
.rp-feature-sub {
    font-size: .73rem; color: var(--rp-gray); line-height: 1.4;
}


/* ─── Desktop Grid ────────────────────────────────────────────── */
.rp-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}


/* ─── Desktop Report Card ─────────────────────────────────────── */
.rp-card {
    --rp-accent: #00a79d;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    transition: all .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    cursor: pointer;
    z-index: 1;
}
.rp-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow:
        0 20px 40px rgba(0,0,0,.08),
        0 4px 20px color-mix(in srgb, var(--rp-accent) 25%, transparent);
}

/* Image */
.rp-card-img-wrap {
    display: block; position: relative;
    width: 100%; overflow: hidden;
    text-decoration: none;
    aspect-ratio: 4/3;
}
.rp-card-img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center top;
    display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.rp-card:hover .rp-card-img { transform: scale(1.06); }

.rp-card-img-fallback {
    width: 100%; height: 100%;
    background: linear-gradient(135deg,
        color-mix(in srgb, var(--rp-accent) 15%, #f8f9fa) 0%,
        color-mix(in srgb, var(--rp-accent) 8%, #f8f9fa) 100%);
    display: flex; align-items: center; justify-content: center;
}
.rp-card-img-fallback i {
    font-size: 3.5rem; color: var(--rp-accent); opacity: .45;
}

/* Body */
.rp-card-body {
    padding: 1.1rem 1.25rem 1.25rem;
    display: flex; flex-direction: column; flex: 1;
}

/* Title */
.rp-card-title {
    font-size: .95rem; font-weight: 700; line-height: 1.5;
    margin: 0 0 .55rem;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
}
.rp-card-title a {
    color: var(--rp-dark); text-decoration: none;
    background-image: linear-gradient(var(--rp-accent), var(--rp-accent));
    background-size: 0% 2px;
    background-repeat: no-repeat; background-position: left bottom;
    transition: background-size .3s ease, color .3s ease;
    padding-bottom: 1px;
}
.rp-card:hover .rp-card-title a {
    background-size: 100% 2px; color: var(--rp-accent);
}

/* Description */
.rp-card-desc {
    font-size: .82rem; color: var(--rp-gray); line-height: 1.6;
    margin: 0 0 .85rem; flex: 1;
}

/* Card share */
.rp-card-share { margin-top: .75rem; }
.rp-card-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600;
    color: var(--rp-gray); letter-spacing: .3px;
    margin-bottom: .5rem; opacity: .6;
}
.rp-card-share-label::before, .rp-card-share-label::after {
    content: ''; flex: 1; height: 1px; background: var(--rp-gray-200);
}
.rp-card-share-row { display: flex; gap: .5rem; }
.rp-card-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; border: 1.5px solid transparent; border-radius: 50px;
    padding: 7px 10px; font-size: .73rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
    background: none;
}
.rp-card-share-btn i { font-size: .8rem; }
.rp-card-share-copy {
    background: color-mix(in srgb, var(--rp-primary) 8%, white);
    border-color: color-mix(in srgb, var(--rp-primary) 22%, transparent);
    color: var(--rp-primary);
}
.rp-card-share-copy:hover {
    background: var(--rp-primary); color: white; border-color: var(--rp-primary);
    box-shadow: 0 4px 14px color-mix(in srgb, var(--rp-primary) 30%, transparent);
    transform: translateY(-1px);
}
.rp-card-share-wa {
    background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28); color: #1da851;
}
.rp-card-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30); transform: translateY(-1px);
}


/* Read button */
.rp-read-btn {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; color: var(--rp-accent);
    background: color-mix(in srgb, var(--rp-accent) 8%, transparent);
    font-weight: 700; font-size: .82rem; text-decoration: none;
    padding: 10px 18px; border-radius: 14px;
    transition: all .3s cubic-bezier(.4,0,.2,1);
    position: relative; overflow: hidden; margin-top: auto; border: none;
}
.rp-read-btn::before {
    content: ''; position: absolute; inset: 0;
    background: var(--rp-accent); border-radius: inherit;
    transform: scaleX(0); transform-origin: left;
    transition: transform .35s cubic-bezier(.4,0,.2,1); z-index: 0;
}
.rp-card:hover .rp-read-btn::before { transform: scaleX(1); }
.rp-read-btn span, .rp-read-btn i {
    position: relative; z-index: 1; transition: color .3s ease;
}
.rp-read-btn i { font-size: .72rem; }
.rp-card:hover .rp-read-btn { color: white; box-shadow: 0 6px 20px color-mix(in srgb, var(--rp-accent) 30%, transparent); }
.rp-card:hover .rp-read-btn i { transform: translateX(4px); }


/* ─── Empty State ─────────────────────────────────────────────── */
.rp-empty-state {
    text-align: center; padding: 3.5rem 1.5rem 4rem;
    color: var(--rp-gray);
}
.rp-empty-visual {
    position: relative; display: inline-flex;
    align-items: center; justify-content: center;
    width: 160px; height: 160px; margin: 0 auto 2rem;
}
.rp-empty-icon-wrap {
    position: relative; z-index: 3;
    width: 88px; height: 88px; border-radius: 28px;
    background: linear-gradient(135deg, #00c4b8, #00a79d);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 2rem;
    box-shadow: 0 12px 36px rgba(0,167,157,.38), 0 4px 12px rgba(0,0,0,.06);
    animation: rpEmptyFloat 3.2s ease-in-out infinite;
}
@keyframes rpEmptyFloat {
    0%, 100% { transform: translateY(0) rotate(-2deg); }
    50%       { transform: translateY(-10px) rotate(2deg); }
}
.rp-empty-ring {
    position: absolute; border-radius: 50%;
    border: 2px solid rgba(0,167,157,.14);
    top: 50%; left: 50%; transform: translate(-50%, -50%);
    animation: rpEmptyRing 3s ease-out infinite;
}
.rp-empty-ring-1 { width: 116px; height: 116px; animation-delay: 0s; }
.rp-empty-ring-2 { width: 150px; height: 150px; animation-delay: .85s; }
@keyframes rpEmptyRing {
    0%   { opacity: .55; transform: translate(-50%, -50%) scale(.85); }
    100% { opacity: 0;   transform: translate(-50%, -50%) scale(1.35); }
}
.rp-empty-deco {
    position: absolute; border-radius: 50%; opacity: .72;
    animation: rpEmptyDeco 4s ease-in-out infinite;
}
.rp-empty-deco-1 { width: 14px; height: 14px; background: #6366f1; top: 10px; right: 16px; animation-delay: 0s; }
.rp-empty-deco-2 { width: 10px; height: 10px; background: #f59e0b; bottom: 18px; left: 10px; animation-delay: 1.1s; }
.rp-empty-deco-3 { width: 8px; height: 8px; background: #ef4444; top: 32px; left: 20px; animation-delay: .55s; }
@keyframes rpEmptyDeco {
    0%, 100% { transform: translateY(0) scale(1); }
    50%       { transform: translateY(-7px) scale(1.15); }
}
.rp-empty-sparkle {
    position: absolute; font-size: .85rem;
    animation: rpEmptySparkle 3.5s ease-in-out infinite;
    pointer-events: none; user-select: none;
}
.rp-empty-sparkle-1 { top: -8px; right: -10px; animation-delay: 0s; }
.rp-empty-sparkle-2 { bottom: -6px; left: -12px; animation-delay: 1.2s; }
.rp-empty-sparkle-3 { top: 6px; left: -14px; animation-delay: 2.1s; font-size: .7rem; }
@keyframes rpEmptySparkle {
    0%, 100% { transform: scale(1) rotate(0deg); opacity: .7; }
    50%       { transform: scale(1.3) rotate(15deg); opacity: 1; }
}
.rp-empty-title { font-size: 1.35rem; font-weight: 800; color: var(--rp-dark); margin: 0 0 .5rem; }
.rp-empty-sub { font-size: .88rem; color: var(--rp-gray); margin: 0 auto .85rem; max-width: 320px; line-height: 1.55; }


/* ─── Mobile List ─────────────────────────────────────────────── */
.rp-mobile-list {
    display: flex; flex-direction: column; gap: .75rem;
    margin-bottom: 1.5rem;
}
.rp-m-list-card {
    --rp-accent: #00a79d;
    display: flex; align-items: center; gap: .9rem;
    background: white; border-radius: 16px; overflow: hidden;
    box-shadow: 0 3px 14px rgba(0,0,0,.07);
    border: 1.5px solid var(--rp-gray-200);
    cursor: pointer; padding: .75rem;
    transition: border-color .25s ease, box-shadow .25s ease, transform .2s ease;
    z-index: 1;
}
.rp-m-list-card:active {
    transform: scale(.98);
    box-shadow: 0 6px 20px color-mix(in srgb, var(--rp-accent) 20%, transparent);
}
.rp-m-thumb {
    width: 68px; height: 68px; border-radius: 12px; overflow: hidden; flex-shrink: 0;
    background: color-mix(in srgb, var(--rp-accent) 12%, #f8f9fa);
}
.rp-m-thumb img {
    width: 100%; height: 100%; object-fit: cover; object-position: center top; display: block;
}
.rp-m-thumb-fallback {
    width: 100%; height: 100%;
    background: linear-gradient(135deg,
        color-mix(in srgb, var(--rp-accent) 15%, #f8f9fa) 0%,
        color-mix(in srgb, var(--rp-accent) 8%, #f8f9fa) 100%);
    display: flex; align-items: center; justify-content: center;
}
.rp-m-thumb-fallback i { font-size: 1.8rem; color: var(--rp-accent); opacity: .5; }
.rp-m-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: .2rem; }
.rp-m-title {
    font-size: .88rem; font-weight: 700; color: var(--rp-dark);
    margin: 0; line-height: 1.4;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.rp-m-desc {
    font-size: .73rem; color: var(--rp-gray); line-height: 1.45; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.rp-m-hint {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .68rem; color: var(--rp-primary); font-weight: 600; margin-top: .15rem;
}
.rp-m-hint i { font-size: .62rem; }
.rp-m-arrow {
    color: var(--rp-gray-200); font-size: .8rem; flex-shrink: 0;
    transition: color .2s ease, transform .2s ease;
}
.rp-m-list-card:hover .rp-m-arrow { color: var(--rp-primary); transform: translateX(3px); }


/* ─── Pagination Wrap ─────────────────────────────────────────── */
.rp-pagination-wrap { padding: .5rem 0 1rem; }


/* ─── Mobile Bottom Sheet ─────────────────────────────────────── */
.rp-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.rp-bs-backdrop.active { opacity: 1; visibility: visible; }

.rp-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white; border-radius: 24px 24px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    padding-bottom: env(safe-area-inset-bottom, 1rem);
}
.rp-bottom-sheet.active { transform: translateY(0); }

/* Close button */
.rp-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--rp-primary); font-size: .9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.rp-bs-close:hover { background: var(--rp-primary); color: white; }

.rp-bs-content { position: relative; }

/* Image area */
.rp-bs-img-wrap { position: relative; width: 100%; overflow: hidden; aspect-ratio: 4/3; max-height: 260px; }
.rp-bs-img-photo {
    width: 100%; height: 100%; object-fit: cover; object-position: center top; display: block;
}
.rp-bs-img-fallback {
    width: 100%; height: 100%; min-height: 200px;
    background: linear-gradient(135deg, var(--rp-primary-light), #d4f3f0);
    display: flex; align-items: center; justify-content: center;
}
.rp-bs-img-fallback i { font-size: 4rem; color: var(--rp-primary); opacity: .4; }
.rp-bs-drag-handle {
    position: absolute; top: 12px; left: 50%; transform: translateX(-50%);
    width: 40px; height: 4px; background: rgba(255,255,255,.82);
    border-radius: 2px; box-shadow: 0 2px 8px rgba(0,0,0,.18); z-index: 2;
}
.rp-bs-img-gradient {
    position: absolute; bottom: 0; left: 0; right: 0; height: 110px;
    background: linear-gradient(to top, white 0%, transparent 100%);
    pointer-events: none; z-index: 1;
}

/* Info section */
.rp-bs-info { padding: .6rem 1.4rem 2rem; }
.rp-bs-title {
    font-size: 1.15rem; font-weight: 800; color: var(--rp-dark);
    line-height: 1.4; margin: 0 0 .75rem;
}
.rp-bs-desc {
    font-size: .85rem; color: var(--rp-gray); line-height: 1.65;
    margin: 0 0 1.25rem;
}

/* Buttons */
.rp-bs-btns { display: flex; flex-direction: column; gap: .65rem; }
.rp-bs-btn-primary {
    display: flex; align-items: center; justify-content: center; gap: .65rem;
    background: linear-gradient(135deg, #00c4b8, var(--rp-primary));
    color: white; text-decoration: none; padding: .9rem;
    border-radius: 50px; font-weight: 700; font-size: .95rem;
    box-shadow: 0 6px 24px rgba(0,167,157,.35); transition: all .3s ease; border: none;
    cursor: pointer;
}
.rp-bs-btn-primary:hover { color: white; transform: scale(1.02); box-shadow: 0 8px 30px rgba(0,167,157,.45); }

/* Share in sheet */
.rp-bs-share-wrap { margin-top: .85rem; }
.rp-bs-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600;
    color: var(--rp-gray); letter-spacing: .3px;
    margin-bottom: .5rem; opacity: .6;
}
.rp-bs-share-label::before, .rp-bs-share-label::after {
    content: ''; flex: 1; height: 1px; background: var(--rp-gray-200);
}
.rp-bs-share-row { display: flex; gap: .5rem; }
.rp-bs-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; border: 1.5px solid transparent; border-radius: 50px;
    padding: 9px 12px; font-size: .78rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
    background: none;
}
.rp-bs-share-btn i { font-size: .8rem; }
.rp-bs-share-copy {
    background: color-mix(in srgb, var(--rp-primary) 8%, white);
    border-color: color-mix(in srgb, var(--rp-primary) 22%, transparent);
    color: var(--rp-primary);
}
.rp-bs-share-copy:hover {
    background: var(--rp-primary); color: white; border-color: var(--rp-primary);
    box-shadow: 0 4px 14px color-mix(in srgb, var(--rp-primary) 30%, transparent);
    transform: translateY(-1px);
}
.rp-bs-share-wa {
    background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28); color: #1da851;
}
.rp-bs-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30); transform: translateY(-1px);
}

/* SweetAlert above sheet */
.rp-swal-above-sheet {
    top: 76px !important; right: 1rem !important; z-index: 1100 !important;
}

/* Scroll lock */
body.rp-sheet-open { overflow: hidden !important; touch-action: none; }
body.rp-sheet-open .back-to-top {
    opacity: 0 !important; visibility: hidden !important; pointer-events: none !important;
    transition: opacity .3s ease, visibility .3s ease !important;
}
/* Naikkan navbar di atas backdrop saat sheet terbuka */
body.rp-sheet-open #mainNavbar {
    z-index: 1080 !important;
}

/* Tablet: center sheet */
@media (min-width: 768px) {
    .rp-bottom-sheet { max-width: 480px; left: 50%; transform: translate(-50%, 100%); }
    .rp-bottom-sheet.active { transform: translate(-50%, 0); }
}


/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 1199.98px) {
    .rp-grid { grid-template-columns: repeat(2, 1fr); }
    .rp-section-title { font-size: 1.75rem; }
    .rp-features-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 991.98px) {
    .rp-section-title { font-size: 1.5rem; }
    .rp-info-card { padding: 1.5rem; }
}
@media (max-width: 767.98px) {
    .rp-info-card { padding: 1.25rem 1rem; }
    .rp-features-grid { grid-template-columns: 1fr; gap: .65rem; }
    .rp-info-desc { margin-bottom: 1rem; }
}
@media (max-width: 575.98px) {
    .rp-section-title { font-size: 1.4rem; }
    .rp-m-thumb { width: 58px; height: 58px; }
}
</style>
@endverbatim
