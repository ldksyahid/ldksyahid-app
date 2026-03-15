{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

@verbatim
<style>
/* ================================================================
   SERVICE PAGE  —  styles prefix: sv-
   Accent colors per service:
     Call Kestari:       #00a79d
     Kalkulator Kestari: #6366f1
     Perpendek URL:      #f59e0b
     Celengan Syahid:    #10b981 (disabled)
   ================================================================ */

:root {
    --sv-dark:     #282d30;
    --sv-gray:     #8d9297;
    --sv-gray-100: #f3f4f6;
    --sv-gray-200: #e5e7eb;
}

/* ─── Page Section (cover hero jumbotron decorations) ─────────── */
.sv-page-section { position: relative; z-index: 1; }
#sv-section      { position: relative; z-index: 1; }


/* ─── Section Header ──────────────────────────────────────────── */
.sv-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: #e0f7f5; color: #00a79d;
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.sv-badge-pulse {
    width: 8px; height: 8px; background: #00a79d;
    border-radius: 50%; flex-shrink: 0;
    animation: svPulse 2s ease infinite;
}
@keyframes svPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%       { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.sv-section-title { font-size: 2rem; font-weight: 700; color: var(--sv-dark); margin: 0; }
.sv-section-sub   { color: var(--sv-gray); font-size: 1rem; margin: .5rem 0 0; }


/* ─── Desktop Grid ────────────────────────────────────────────── */
.sv-grid { display: none; }
@media (min-width: 768px) {
    .sv-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
}


/* ─── Desktop Service Card ────────────────────────────────────── */
.sv-card {
    --sv-accent: #00a79d;
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    transition: all .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    border: 1.5px solid var(--sv-gray-200);
}
.sv-card:hover {
    transform: translateY(-6px) scale(1.005);
    box-shadow:
        0 20px 40px rgba(0,0,0,.08),
        0 4px 20px color-mix(in srgb, var(--sv-accent) 25%, transparent);
    border-color: color-mix(in srgb, var(--sv-accent) 30%, transparent);
}
.sv-card.sv-card-disabled { pointer-events: none; }
.sv-card.sv-card-disabled .sv-card-img-wrap,
.sv-card.sv-card-disabled .sv-card-body { opacity: .7; }

/* Image area */
.sv-card-img-wrap {
    width: 100%; padding: 2.25rem;
    background: color-mix(in srgb, var(--sv-accent) 8%, #f8f9fa);
    display: flex; align-items: center; justify-content: center;
    min-height: 185px;
    transition: background .3s ease;
}
.sv-card:hover .sv-card-img-wrap {
    background: color-mix(in srgb, var(--sv-accent) 14%, #f8f9fa);
}
.sv-card-img {
    width: 100%; max-height: 145px;
    object-fit: contain; display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.sv-card:hover .sv-card-img { transform: scale(1.07); }

/* Card body */
.sv-card-body {
    padding: 1.4rem 1.5rem 1.5rem;
    display: flex; flex-direction: column; flex: 1;
}

/* Accent dot + title row */
.sv-card-title-row {
    display: flex; align-items: center; gap: .6rem; margin-bottom: .7rem; flex-wrap: wrap;
}
.sv-card-dot {
    width: 10px; height: 10px; border-radius: 50%;
    background: var(--sv-accent); flex-shrink: 0;
    box-shadow: 0 0 0 3px color-mix(in srgb, var(--sv-accent) 20%, transparent);
}
.sv-card-title {
    font-size: 1.05rem; font-weight: 700; color: var(--sv-dark); margin: 0; line-height: 1.3;
}

/* Coming soon badge */
.sv-badge-coming {
    display: inline-flex; align-items: center; gap: .35rem;
    background: #fef3c7; color: #d97706;
    border-radius: 50px; padding: .25rem .75rem;
    font-size: .7rem; font-weight: 700; letter-spacing: .4px;
    margin-left: auto;
}
.sv-badge-coming i { font-size: .65rem; }

/* Description */
.sv-card-desc {
    font-size: .86rem; color: var(--sv-gray); line-height: 1.65;
    margin: 0 0 1.1rem; flex: 1;
}

/* Footer: share + CTA */
.sv-card-footer {
    display: flex; align-items: center; justify-content: space-between; gap: .75rem;
    border-top: 1px solid var(--sv-gray-200); padding-top: .9rem; margin-top: auto;
}
.sv-card-share-row { display: flex; gap: .45rem; }
.sv-card-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
    border: 1.5px solid transparent; border-radius: 50px;
    padding: 6px 12px; font-size: .72rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
    background: none;
}
.sv-card-share-btn i { font-size: .75rem; }
.sv-share-copy {
    background: color-mix(in srgb, var(--sv-accent) 8%, white);
    border-color: color-mix(in srgb, var(--sv-accent) 22%, transparent);
    color: var(--sv-accent);
}
.sv-share-copy:hover {
    background: var(--sv-accent); color: white; border-color: var(--sv-accent);
    box-shadow: 0 4px 14px color-mix(in srgb, var(--sv-accent) 30%, transparent);
    transform: translateY(-1px);
}
.sv-share-wa {
    background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28); color: #1da851;
}
.sv-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30); transform: translateY(-1px);
}

/* CTA button */
.sv-card-cta {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--sv-accent); color: white;
    border-radius: 50px; padding: .55rem 1.25rem;
    font-size: .82rem; font-weight: 700; text-decoration: none;
    transition: all .3s ease; white-space: nowrap; border: none; cursor: pointer;
    box-shadow: 0 4px 14px color-mix(in srgb, var(--sv-accent) 30%, transparent);
    flex-shrink: 0;
}
.sv-card-cta:hover {
    color: white; transform: translateY(-2px);
    box-shadow: 0 8px 24px color-mix(in srgb, var(--sv-accent) 40%, transparent);
}
.sv-card-cta i { font-size: .75rem; transition: transform .2s ease; }
.sv-card-cta:hover i { transform: translateX(3px); }
.sv-card-cta-disabled {
    background: var(--sv-gray-100); color: var(--sv-gray);
    border: 1.5px solid var(--sv-gray-200);
    box-shadow: none; cursor: default;
}
.sv-card-cta-disabled:hover {
    color: var(--sv-gray); transform: none; box-shadow: none;
}


/* ─── Mobile List ─────────────────────────────────────────────── */
.sv-mobile-list {
    display: flex; flex-direction: column; gap: .75rem;
}
@media (min-width: 768px) {
    .sv-mobile-list { display: none; }
}

.sv-m-card {
    --sv-accent: #00a79d;
    display: flex; align-items: center; gap: .85rem;
    background: white; border-radius: 18px; overflow: hidden;
    box-shadow: 0 3px 14px rgba(0,0,0,.07);
    border: 1.5px solid var(--sv-gray-200);
    cursor: pointer; padding: .9rem;
    transition: border-color .25s ease, box-shadow .25s ease, transform .2s ease;
}
.sv-m-card:active {
    transform: scale(.98);
    box-shadow: 0 6px 20px color-mix(in srgb, var(--sv-accent) 20%, transparent);
}
.sv-m-card.sv-m-card-disabled { cursor: default; pointer-events: none; }
.sv-m-card.sv-m-card-disabled .sv-m-thumb,
.sv-m-card.sv-m-card-disabled .sv-m-info { opacity: .65; }

.sv-m-thumb {
    width: 72px; height: 72px; border-radius: 14px; flex-shrink: 0;
    background: color-mix(in srgb, var(--sv-accent) 10%, #f8f9fa);
    display: flex; align-items: center; justify-content: center;
    padding: .6rem; overflow: hidden;
}
.sv-m-thumb img { width: 100%; height: 100%; object-fit: contain; display: block; }

.sv-m-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: .2rem; }
.sv-m-title {
    font-size: .9rem; font-weight: 700; color: var(--sv-dark);
    margin: 0; line-height: 1.35;
}
.sv-m-desc {
    font-size: .73rem; color: var(--sv-gray); line-height: 1.45; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
}
.sv-m-hint {
    display: inline-flex; align-items: center; gap: .3rem;
    font-size: .68rem; color: var(--sv-accent); font-weight: 600; margin-top: .15rem;
}
.sv-m-hint-disabled { color: var(--sv-gray); }
.sv-m-hint i { font-size: .62rem; }
.sv-m-arrow {
    color: var(--sv-gray-200); font-size: .8rem; flex-shrink: 0;
    transition: color .2s ease, transform .2s ease;
}
.sv-m-card:hover .sv-m-arrow { color: var(--sv-accent); transform: translateX(3px); }


/* ─── Mobile Bottom Sheet ─────────────────────────────────────── */
.sv-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.sv-bs-backdrop.active { opacity: 1; visibility: visible; }

.sv-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white; border-radius: 24px 24px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    padding-bottom: env(safe-area-inset-bottom, 1rem);
}
.sv-bottom-sheet.active { transform: translateY(0); }

/* Close button */
.sv-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #00a79d; font-size: .9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.sv-bs-close:hover { background: #00a79d; color: white; }
.sv-bs-content { position: relative; }

/* Image area in sheet */
.sv-bs-img-wrap {
    width: 100%; min-height: 200px;
    display: flex; align-items: center; justify-content: center;
    padding: 2.5rem 2rem;
    position: relative;
}
.sv-bs-img-photo {
    max-width: 200px; max-height: 170px; object-fit: contain; display: block;
}
.sv-bs-drag-handle {
    position: absolute; top: 12px; left: 50%; transform: translateX(-50%);
    width: 40px; height: 4px; background: rgba(0,0,0,.12);
    border-radius: 2px; z-index: 2;
}

/* Info section */
.sv-bs-info { padding: .25rem 1.4rem 2rem; }
.sv-bs-title {
    font-size: 1.2rem; font-weight: 800; color: var(--sv-dark);
    line-height: 1.4; margin: 0 0 .65rem;
}
.sv-bs-desc {
    font-size: .875rem; color: var(--sv-gray); line-height: 1.65;
    margin: 0 0 1.25rem;
}

/* CTA in sheet */
.sv-bs-cta {
    display: flex; align-items: center; justify-content: center; gap: .65rem;
    width: 100%; border-radius: 50px; padding: .9rem;
    font-weight: 700; font-size: .95rem;
    text-decoration: none; border: none; cursor: pointer;
    transition: all .3s ease; margin-bottom: .65rem;
}
.sv-bs-cta:hover { transform: scale(1.02); }
.sv-bs-cta-disabled {
    background: var(--sv-gray-100); color: var(--sv-gray);
    box-shadow: none; cursor: default;
}
.sv-bs-cta-disabled:hover { transform: none; color: var(--sv-gray); }

/* Share in sheet */
.sv-bs-share-wrap { margin-top: .85rem; }
.sv-bs-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600;
    color: var(--sv-gray); letter-spacing: .3px;
    margin-bottom: .5rem; opacity: .6;
}
.sv-bs-share-label::before, .sv-bs-share-label::after {
    content: ''; flex: 1; height: 1px; background: var(--sv-gray-200);
}
.sv-bs-share-row { display: flex; gap: .5rem; }
.sv-bs-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; border: 1.5px solid transparent; border-radius: 50px;
    padding: 9px 12px; font-size: .78rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
    background: none;
}
.sv-bs-share-btn i { font-size: .8rem; }
.sv-bs-share-copy {
    background: rgba(0,167,157,.08); border-color: rgba(0,167,157,.22); color: #00a79d;
}
.sv-bs-share-copy:hover {
    background: #00a79d; color: white; border-color: #00a79d;
    box-shadow: 0 4px 14px rgba(0,167,157,.30); transform: translateY(-1px);
}
.sv-bs-share-wa {
    background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28); color: #1da851;
}
.sv-bs-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30); transform: translateY(-1px);
}

/* SweetAlert above sheet */
.sv-swal-above-sheet {
    top: 76px !important; right: 1rem !important; z-index: 1100 !important;
}

/* Scroll lock */
body.sv-sheet-open { overflow: hidden !important; touch-action: none; }
body.sv-sheet-open .back-to-top {
    opacity: 0 !important; visibility: hidden !important; pointer-events: none !important;
    transition: opacity .3s ease, visibility .3s ease !important;
}

/* Tablet: center sheet */
@media (min-width: 768px) {
    .sv-bottom-sheet { max-width: 480px; left: 50%; transform: translate(-50%, 100%); }
    .sv-bottom-sheet.active { transform: translate(-50%, 0); }
}


/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .sv-section-title { font-size: 1.75rem; }
    .sv-card-footer { flex-direction: column; align-items: stretch; gap: .65rem; }
    .sv-card-share-row { justify-content: flex-start; }
    .sv-card-cta { justify-content: center; }
}
@media (max-width: 767.98px) {
    .sv-section-title { font-size: 1.6rem; }
}
@media (max-width: 575.98px) {
    .sv-section-title { font-size: 1.4rem; }
    .sv-m-thumb { width: 62px; height: 62px; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
/* Section header */
[data-theme="dark"] .sv-section-title  { color: #e2e8f0; }
[data-theme="dark"] .sv-section-sub    { color: #9ca3af; }
[data-theme="dark"] .sv-section-badge  { background: rgba(0,167,157,.15); color: #4dd9cf; }
/* Desktop card */
[data-theme="dark"] .sv-card           { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .sv-card-img-wrap  { background: rgba(0,167,157,.08); }
[data-theme="dark"] .sv-card:hover .sv-card-img-wrap { background: rgba(0,167,157,.14); }
[data-theme="dark"] .sv-card-title     { color: #e2e8f0; }
[data-theme="dark"] .sv-card-desc      { color: #9ca3af; }
[data-theme="dark"] .sv-card-footer    { border-top-color: rgba(0,167,157,.15); }
[data-theme="dark"] .sv-badge-coming   { background: rgba(245,158,11,.15); color: #f59e0b; }
[data-theme="dark"] .sv-card-cta-disabled { background: #252b3b; color: #9ca3af; border-color: rgba(0,167,157,.15); }
/* Mobile list card (.sv-m-card — NOT .sv-mobile-card) */
[data-theme="dark"] .sv-m-card         { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .sv-m-thumb        { background: rgba(0,167,157,.1); }
[data-theme="dark"] .sv-m-title        { color: #e2e8f0; }
[data-theme="dark"] .sv-m-desc         { color: #9ca3af; }
[data-theme="dark"] .sv-m-hint         { color: #4dd9cf; }
[data-theme="dark"] .sv-m-arrow        { color: rgba(255,255,255,.15); }
/* Bottom sheet */
[data-theme="dark"] .sv-bottom-sheet   { background: #1a1f2e; }
[data-theme="dark"] .sv-bs-close       { background: #252b3b; color: #4dd9cf; box-shadow: none; }
[data-theme="dark"] .sv-bs-drag-handle { background: rgba(255,255,255,.15); }
[data-theme="dark"] .sv-bs-img-wrap    { background: rgba(0,167,157,.08); }
[data-theme="dark"] .sv-bs-title       { color: #e2e8f0; }
[data-theme="dark"] .sv-bs-desc        { color: #9ca3af; }
[data-theme="dark"] .sv-bs-share-label { color: #9ca3af; }
[data-theme="dark"] .sv-bs-share-label::before,
[data-theme="dark"] .sv-bs-share-label::after { background: rgba(255,255,255,.1); }
[data-theme="dark"] .sv-bs-cta-disabled { background: #252b3b; color: #9ca3af; }
</style>
@endverbatim
