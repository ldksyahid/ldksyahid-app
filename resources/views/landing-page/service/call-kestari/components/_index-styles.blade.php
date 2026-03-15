{{-- ── Skeleton cards shared styles ── --}}
@include('components.skeleton-cards.styles')

{{-- ── Search-Filter-Bar component styles ── --}}
@include('components.search-filter-bar.styles')

{{-- ── Pagination shared styles ── --}}
@include('components.pagination-custom.styles')

@verbatim
<style>
/* ================================================================
   CALL KESTARI PAGE  —  styles prefix: ck-
   Primary: #00a79d
   ================================================================ */

:root {
    --ck-primary:       #00a79d;
    --ck-primary-dark:  #008f86;
    --ck-primary-light: #e0f7f5;
    --ck-dark:          #282d30;
    --ck-gray:          #8d9297;
    --ck-gray-100:      #f3f4f6;
    --ck-gray-200:      #e5e7eb;
}


/* ─── Page Section ────────────────────────────────────────────── */
.ck-page-section {
    padding-top: 6rem;
    min-height: 100vh;
}

/* ─── Section Header ──────────────────────────────────────────── */
.ck-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--ck-primary-light); color: var(--ck-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.ck-badge-pulse {
    width: 8px; height: 8px; background: var(--ck-primary);
    border-radius: 50%; flex-shrink: 0;
    animation: ckPulse 2s ease infinite;
}
@keyframes ckPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%       { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.ck-section-title { font-size: 2rem; font-weight: 700; color: var(--ck-dark); margin: 0; }
.ck-section-sub   { color: var(--ck-gray); font-size: 1rem; margin: .5rem 0 0; }


/* ─── Results Info ────────────────────────────────────────────── */
.ck-results-info { font-size: .86rem; color: var(--ck-gray); }
.ck-results-info strong { color: var(--ck-dark); font-weight: 600; }


/* ─── AJAX Transition ─────────────────────────────────────────── */
#ck-cards-wrap { transition: opacity .35s ease, transform .35s ease; }
#ck-cards-wrap.ck-cards-out {
    opacity: 0; transform: translateY(18px); pointer-events: none;
}


/* ─── Desktop Grid (hidden below md) ─────────────────────────── */
.ck-grid { display: none; margin-bottom: 1.5rem; }
@media (min-width: 768px) {
    .ck-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }
}


/* ─── Desktop Card ────────────────────────────────────────────── */
.ck-card {
    background: white; border-radius: 22px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    border: 1.5px solid var(--ck-gray-200);
    transition: all .35s cubic-bezier(.4,0,.2,1);
    display: flex; flex-direction: column;
    animation: ckCardIn .4s ease both;
}
@keyframes ckCardIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: none; }
}
.ck-card:hover {
    transform: translateY(-5px) scale(1.005);
    box-shadow: 0 16px 36px rgba(0,0,0,.08), 0 4px 16px rgba(0,167,157,.14);
    border-color: rgba(0,167,157,.28);
}

/* Icon area */
.ck-card-icon-wrap {
    padding: 1.85rem 2rem;
    background: var(--ck-primary-light);
    display: flex; align-items: center; justify-content: center;
    transition: background .3s ease;
}
.ck-card:hover .ck-card-icon-wrap {
    background: linear-gradient(135deg, #c5f5f2, var(--ck-primary-light));
}
.ck-card-icon {
    width: 66px; height: 66px; border-radius: 18px;
    background: white;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 18px rgba(0,167,157,.22);
    transition: transform .3s ease, box-shadow .3s ease;
}
.ck-card:hover .ck-card-icon {
    transform: scale(1.1) rotate(-4deg);
    box-shadow: 0 8px 28px rgba(0,167,157,.32);
}
.ck-card-icon i { font-size: 1.5rem; color: var(--ck-primary); }

/* Card body */
.ck-card-body {
    padding: 1.2rem 1.4rem 1.4rem;
    display: flex; flex-direction: column; flex: 1;
}
.ck-card-name {
    font-size: 1rem; font-weight: 700; color: var(--ck-dark);
    margin: 0 0 .35rem; line-height: 1.35;
    background-image: linear-gradient(var(--ck-primary), var(--ck-primary));
    background-size: 0% 2px; background-repeat: no-repeat; background-position: left bottom;
    transition: background-size .3s ease, color .3s ease;
    padding-bottom: 1px; display: inline-block; max-width: 100%;
}
.ck-card:hover .ck-card-name { background-size: 100% 2px; color: var(--ck-primary); }
.ck-card-link {
    font-size: .73rem; color: var(--ck-gray); line-height: 1.4;
    margin: 0 0 1rem; flex: 1;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* Card footer */
.ck-card-footer {
    display: flex; align-items: center; gap: .6rem;
    border-top: 1px solid var(--ck-gray-200); padding-top: .85rem; margin-top: auto;
    flex-wrap: wrap;
}
.ck-card-share-row { display: flex; gap: .4rem; flex-shrink: 0; }
.ck-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .35rem;
    border: 1.5px solid transparent; border-radius: 50px;
    padding: 6px 11px; font-size: .72rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
    background: none;
}
.ck-share-btn i { font-size: .75rem; }
.ck-share-copy {
    background: rgba(0,167,157,.08);
    border-color: rgba(0,167,157,.22);
    color: var(--ck-primary);
}
.ck-share-copy:hover {
    background: var(--ck-primary); color: white; border-color: var(--ck-primary);
    box-shadow: 0 4px 14px rgba(0,167,157,.28); transform: translateY(-1px);
}
.ck-share-wa {
    background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28); color: #1da851;
}
.ck-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.28); transform: translateY(-1px);
}

/* CTA button */
.ck-cta-btn {
    display: inline-flex; align-items: center; gap: .45rem;
    background: var(--ck-primary); color: white;
    border-radius: 50px; padding: .52rem 1.1rem;
    font-size: .8rem; font-weight: 700; text-decoration: none;
    transition: all .3s ease; white-space: nowrap; border: none; cursor: pointer;
    box-shadow: 0 4px 14px rgba(0,167,157,.28);
    margin-left: auto; flex-shrink: 0;
}
.ck-cta-btn:hover {
    color: white; transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,167,157,.38);
}
.ck-cta-btn i { font-size: .72rem; transition: transform .2s ease; }
.ck-cta-btn:hover i { transform: translateX(3px); }


/* ─── Mobile List (hidden from md) ───────────────────────────── */
.ck-mobile-list { display: flex; flex-direction: column; gap: .7rem; }
@media (min-width: 768px) { .ck-mobile-list { display: none; } }

.ck-m-card {
    display: flex; align-items: center; gap: .8rem;
    background: white; border-radius: 18px;
    box-shadow: 0 3px 14px rgba(0,0,0,.07);
    border: 1.5px solid var(--ck-gray-200);
    cursor: pointer; padding: .85rem;
    transition: border-color .25s ease, box-shadow .25s ease, transform .2s ease;
    animation: ckCardIn .35s ease both;
}
.ck-m-card:active {
    transform: scale(.98);
    box-shadow: 0 6px 20px rgba(0,167,157,.18);
}
.ck-m-icon {
    width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0;
    background: var(--ck-primary-light);
    display: flex; align-items: center; justify-content: center;
}
.ck-m-icon i { font-size: 1.2rem; color: var(--ck-primary); }
.ck-m-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: .18rem; }
.ck-m-name {
    font-size: .9rem; font-weight: 700; color: var(--ck-dark);
    margin: 0; line-height: 1.3;
}
.ck-m-link {
    font-size: .72rem; color: var(--ck-gray); margin: 0;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.ck-m-hint {
    display: inline-flex; align-items: center; gap: .25rem;
    font-size: .67rem; color: var(--ck-primary); font-weight: 600; margin-top: .1rem;
}
.ck-m-hint i { font-size: .6rem; }
.ck-m-arrow {
    color: var(--ck-gray-200); font-size: .8rem; flex-shrink: 0;
    transition: color .2s ease, transform .2s ease;
}
.ck-m-card:hover .ck-m-arrow { color: var(--ck-primary); transform: translateX(3px); }


/* ─── Empty State ─────────────────────────────────────────────── */
.ck-empty-state {
    text-align: center; padding: 4rem 1.5rem;
    color: var(--ck-gray);
}
.ck-empty-icon {
    width: 80px; height: 80px; border-radius: 24px;
    background: var(--ck-primary-light);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    animation: ckFloat 3s ease-in-out infinite;
}
@keyframes ckFloat {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-8px); }
}
.ck-empty-icon i { font-size: 2rem; color: var(--ck-primary); opacity: .6; }
.ck-empty-title { font-size: 1.2rem; font-weight: 700; color: var(--ck-dark); margin: 0 0 .5rem; }
.ck-empty-sub   { font-size: .88rem; max-width: 300px; margin: 0 auto; line-height: 1.55; }


/* ─── Mobile Bottom Sheet ─────────────────────────────────────── */
.ck-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity .3s ease, visibility .3s ease;
}
.ck-bs-backdrop.active { opacity: 1; visibility: visible; }

.ck-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: white; border-radius: 24px 24px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform .4s cubic-bezier(.4,0,.2,1);
    padding-bottom: env(safe-area-inset-bottom, 1rem);
}
.ck-bottom-sheet.active { transform: translateY(0); }

/* Close button */
.ck-bs-close {
    position: absolute; top: .75rem; right: 1rem;
    background: rgba(255,255,255,.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--ck-primary); font-size: .9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,.15);
    transition: background .2s, color .2s; z-index: 5;
}
.ck-bs-close:hover { background: var(--ck-primary); color: white; }
.ck-bs-content { position: relative; }

/* Sheet icon area */
.ck-bs-icon-wrap {
    width: 100%; padding: 3rem 2rem 2rem;
    background: var(--ck-primary-light);
    display: flex; align-items: center; justify-content: center;
    position: relative;
}
.ck-bs-drag-handle {
    position: absolute; top: 12px; left: 50%; transform: translateX(-50%);
    width: 40px; height: 4px; background: rgba(0,0,0,.12);
    border-radius: 2px; z-index: 2;
}
.ck-bs-icon {
    width: 80px; height: 80px; border-radius: 24px;
    background: white;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 8px 28px rgba(0,167,157,.28);
}
.ck-bs-icon i { font-size: 2rem; color: var(--ck-primary); }

/* Sheet info */
.ck-bs-info { padding: 1.25rem 1.4rem 2rem; }
.ck-bs-name {
    font-size: 1.2rem; font-weight: 800; color: var(--ck-dark);
    line-height: 1.35; margin: 0 0 .45rem;
}
.ck-bs-link {
    font-size: .78rem; color: var(--ck-gray); line-height: 1.5;
    margin: 0 0 1.25rem; word-break: break-all;
}
.ck-bs-cta {
    display: flex; align-items: center; justify-content: center; gap: .65rem;
    width: 100%; background: var(--ck-primary); color: white;
    border-radius: 50px; padding: .9rem; font-weight: 700; font-size: .95rem;
    text-decoration: none; border: none; cursor: pointer;
    box-shadow: 0 6px 24px rgba(0,167,157,.32);
    transition: all .3s ease; margin-bottom: .65rem;
}
.ck-bs-cta:hover { color: white; transform: scale(1.02); box-shadow: 0 8px 30px rgba(0,167,157,.40); }

/* Share in sheet */
.ck-bs-share-wrap { margin-top: .85rem; }
.ck-bs-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600;
    color: var(--ck-gray); letter-spacing: .3px;
    margin-bottom: .5rem; opacity: .6;
}
.ck-bs-share-label::before, .ck-bs-share-label::after {
    content: ''; flex: 1; height: 1px; background: var(--ck-gray-200);
}
.ck-bs-share-row { display: flex; gap: .5rem; }
.ck-bs-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    flex: 1; border: 1.5px solid transparent; border-radius: 50px;
    padding: 9px 12px; font-size: .78rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
    background: none;
}
.ck-bs-share-btn i { font-size: .8rem; }
.ck-bs-share-copy {
    background: rgba(0,167,157,.08); border-color: rgba(0,167,157,.22); color: var(--ck-primary);
}
.ck-bs-share-copy:hover {
    background: var(--ck-primary); color: white; border-color: var(--ck-primary);
    box-shadow: 0 4px 14px rgba(0,167,157,.28); transform: translateY(-1px);
}
.ck-bs-share-wa {
    background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28); color: #1da851;
}
.ck-bs-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.28); transform: translateY(-1px);
}

/* SweetAlert above sheet */
.ck-swal-above-sheet {
    top: 76px !important; right: 1rem !important; z-index: 1100 !important;
}

/* Scroll lock */
body.ck-sheet-open { overflow: hidden !important; touch-action: none; }
body.ck-sheet-open .back-to-top {
    opacity: 0 !important; visibility: hidden !important; pointer-events: none !important;
    transition: opacity .3s ease, visibility .3s ease !important;
}

/* Tablet: center sheet */
@media (min-width: 768px) {
    .ck-bottom-sheet { max-width: 480px; left: 50%; transform: translate(-50%, 100%); }
    .ck-bottom-sheet.active { transform: translate(-50%, 0); }
}

/* Pagination wrap */
.ck-pagination-wrap { padding: .5rem 0 1rem; }


/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .ck-grid { grid-template-columns: repeat(2, 1fr); }
    .ck-section-title { font-size: 1.75rem; }
    .ck-card-footer { flex-wrap: wrap; }
}
@media (max-width: 767.98px) {
    .ck-page-section { padding-top: 5rem; }
    .ck-section-title { font-size: 1.6rem; }
}
@media (max-width: 575.98px) {
    .ck-section-title { font-size: 1.4rem; }
    .ck-m-icon { width: 44px; height: 44px; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .ck-section-title  { color: #e2e8f0; }
[data-theme="dark"] .ck-section-sub    { color: #9ca3af; }
[data-theme="dark"] .ck-results-info   { color: #9ca3af; }
[data-theme="dark"] .ck-results-info strong { color: #e2e8f0; }
[data-theme="dark"] .ck-card           { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ck-card-icon      { background: #252b3b; }
[data-theme="dark"] .ck-card-name      { color: #e2e8f0; }
[data-theme="dark"] .ck-card-link      { color: #9ca3af; }
[data-theme="dark"] .ck-card-footer    { border-top-color: rgba(0,167,157,.12); }
[data-theme="dark"] .ck-m-card         { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ck-m-name         { color: #e2e8f0; }
[data-theme="dark"] .ck-m-link         { color: #9ca3af; }
[data-theme="dark"] .ck-m-arrow        { color: rgba(255,255,255,.2); }
[data-theme="dark"] .ck-empty-title    { color: #e2e8f0; }
[data-theme="dark"] .ck-empty-sub      { color: #9ca3af; }
[data-theme="dark"] .ck-bottom-sheet   { background: #1a1f2e; }
[data-theme="dark"] .ck-bs-close       { background: #252b3b; color: #4dd9cf; box-shadow: none; }
[data-theme="dark"] .ck-bs-drag-handle { background: rgba(255,255,255,.15); }
[data-theme="dark"] .ck-bs-name        { color: #e2e8f0; }
[data-theme="dark"] .ck-bs-link        { color: #9ca3af; }
[data-theme="dark"] .ck-bs-share-label { color: #9ca3af; }
[data-theme="dark"] .ck-bs-share-label::before,
[data-theme="dark"] .ck-bs-share-label::after { background: rgba(255,255,255,.1); }
[data-theme="dark"] .ck-bs-share-btn   { background: #252b3b; border-color: rgba(0,167,157,.2); color: #9ca3af; }
[data-theme="dark"] .ck-section-badge  { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .ck-card-icon-wrap { background: rgba(0,167,157,.1); }
[data-theme="dark"] .ck-card:hover .ck-card-icon-wrap { background: linear-gradient(135deg, rgba(0,167,157,.2), rgba(0,167,157,.08)); }
[data-theme="dark"] .ck-m-icon         { background: rgba(0,167,157,.15); }
[data-theme="dark"] .ck-m-hint         { color: #4dd9cf; }
[data-theme="dark"] .ck-empty-icon     { background: rgba(0,167,157,.15); }
[data-theme="dark"] .ck-bs-icon-wrap   { background: rgba(0,167,157,.1); }
[data-theme="dark"] .ck-bs-icon        { background: #252b3b; }
</style>
@endverbatim
