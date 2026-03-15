{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

@verbatim
<style>
/* ================================================================
   FINANCE REPORT PAGE  —  prefix: fr-
   Palette: #00a79d (primary), #008f86 (primary-dark),
            #e0f7f5 (primary-light), #282d30 (dark), #8d9297 (gray)
   ================================================================ */

:root {
    --fr-primary:       #00a79d;
    --fr-primary-dark:  #008f86;
    --fr-primary-light: #e0f7f5;
    --fr-dark:          #282d30;
    --fr-gray:          #8d9297;
    --fr-gray-100:      #f3f4f6;
    --fr-gray-200:      #e5e7eb;
}


/* ── Section Header ──────────────────────────────────────────── */
.fr-section-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--fr-primary-light); color: var(--fr-primary);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.fr-badge-pulse {
    width: 8px; height: 8px; background: var(--fr-primary);
    border-radius: 50%; flex-shrink: 0;
    animation: frPulse 2s ease infinite;
}
@keyframes frPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,167,157,.4); }
    50%      { box-shadow: 0 0 0 6px rgba(0,167,157,0); }
}
.fr-section-title { font-size: 2rem; font-weight: 700; color: var(--fr-dark); margin: 0; }
.fr-section-sub   { color: var(--fr-gray); font-size: 1rem; margin: .5rem 0 0; }


/* ── Info Card ───────────────────────────────────────────────── */
.fr-info-card {
    background: white;
    border-radius: 20px;
    border: 1.5px solid var(--fr-gray-200);
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    padding: 2rem;
    position: relative; z-index: 1;
}

.fr-features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem 2rem;
    margin-bottom: 1.5rem;
}

.fr-feature-item {
    display: flex; align-items: flex-start; gap: .9rem;
}

.fr-feature-icon {
    width: 40px; height: 40px; border-radius: 12px;
    background: var(--fr-primary-light);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.fr-feature-icon i { color: var(--fr-primary); font-size: 1rem; }

.fr-feature-text { display: flex; flex-direction: column; gap: .2rem; }
.fr-feature-title { font-size: .9rem; font-weight: 700; color: var(--fr-dark); }
.fr-feature-sub   { font-size: .8rem; color: var(--fr-gray); line-height: 1.4; }

.fr-info-desc {
    font-size: .88rem; color: var(--fr-gray);
    line-height: 1.7; margin: 0;
    border-top: 1px solid var(--fr-gray-200);
    padding-top: 1.25rem;
}

@media (max-width: 767.98px) {
    .fr-features-grid { grid-template-columns: 1fr; gap: 1rem; }
    .fr-info-card { padding: 1.5rem; }
}


/* ── Accordion Container ─────────────────────────────────────── */
.fr-accordion {
    display: flex; flex-direction: column;
    gap: 1rem; margin-bottom: 3rem;
}


/* ── Accordion Item ──────────────────────────────────────────── */
.fr-acc-item {
    background: white; border-radius: 20px; overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    border: 1.5px solid var(--fr-gray-200);
    transition: box-shadow .3s ease, border-color .3s ease;
    z-index: 1;
}
.fr-acc-item:has(.fr-acc-btn:not(.collapsed)) {
    border-color: color-mix(in srgb, var(--fr-primary) 35%, transparent);
    box-shadow: 0 8px 32px rgba(0,167,157,.12);
}


/* ── Accordion Button ────────────────────────────────────────── */
.fr-acc-btn {
    width: 100%; display: flex; align-items: center;
    justify-content: space-between; gap: 1rem;
    padding: 1.1rem 1.4rem;
    background: transparent; border: none; cursor: pointer;
    text-align: left; transition: background .2s ease;
}
.fr-acc-btn:hover { background: var(--fr-gray-100); }
.fr-acc-btn:not(.collapsed) { background: var(--fr-primary-light); }
.fr-acc-btn:focus { outline: none; box-shadow: none; }

.fr-acc-left {
    display: flex; align-items: center; gap: .9rem;
    min-width: 0; flex: 1;
}

.fr-acc-logo {
    width: 48px; height: 48px; border-radius: 50%;
    background: var(--fr-primary-light);
    border: 2px solid color-mix(in srgb, var(--fr-primary) 20%, transparent);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden;
}
.fr-acc-logo img { width: 36px; height: 36px; object-fit: contain; display: block; }
.fr-acc-logo i   { color: var(--fr-primary); font-size: 1.2rem; }

.fr-acc-info { display: flex; flex-direction: column; gap: .15rem; min-width: 0; }
.fr-acc-name {
    font-size: .95rem; font-weight: 700; color: var(--fr-dark);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.fr-acc-count {
    font-size: .72rem; color: var(--fr-gray);
    display: flex; align-items: center; gap: .3rem;
}
.fr-acc-count i { color: #e74c3c; font-size: .65rem; }

.fr-acc-chevron {
    font-size: .72rem; color: var(--fr-gray); flex-shrink: 0;
    transition: transform .3s ease;
}
.fr-acc-btn:not(.collapsed) .fr-acc-chevron {
    transform: rotate(180deg); color: var(--fr-primary);
}


/* ── Report List ─────────────────────────────────────────────── */
.fr-report-list {
    border-top: 1px solid var(--fr-gray-200);
    display: flex; flex-direction: column;
}


/* ── Report Item ─────────────────────────────────────────────── */
.fr-report-item {
    display: flex; align-items: center;
    justify-content: space-between; gap: 1rem;
    padding: .9rem 1.4rem;
    border-bottom: 1px solid var(--fr-gray-200);
    transition: background .2s ease;
}
.fr-report-item:last-child { border-bottom: none; }
.fr-report-item:hover { background: var(--fr-gray-100); }

.fr-report-left {
    display: flex; align-items: center; gap: .75rem;
    min-width: 0; flex: 1;
}

.fr-report-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: rgba(231,76,60,.1);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    transition: transform .25s ease;
}
.fr-report-item:hover .fr-report-icon { transform: scale(1.08); }
.fr-report-icon i { color: #e74c3c; font-size: 1rem; }

.fr-report-info { display: flex; flex-direction: column; gap: .15rem; min-width: 0; }
.fr-report-name {
    font-size: .88rem; font-weight: 600; color: var(--fr-dark);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.fr-report-date {
    font-size: .7rem; color: var(--fr-gray);
    display: flex; align-items: center; gap: .3rem;
}
.fr-report-date i { font-size: .62rem; }


/* ── Report Right (actions) ──────────────────────────────────── */
.fr-report-right {
    display: flex; align-items: center;
    flex-shrink: 0;
}
.fr-report-btns { display: flex; align-items: center; gap: .4rem; }


/* ── Action Buttons (Lihat, Unduh) ───────────────────────────── */
.fr-action-btn {
    display: inline-flex; align-items: center; gap: .35rem;
    border-radius: 50px; padding: .38rem .9rem;
    font-size: .78rem; font-weight: 600; line-height: 1;
    text-decoration: none; border: 1.5px solid transparent;
    cursor: pointer; transition: all .22s ease; white-space: nowrap;
}
.fr-action-btn i { font-size: .75rem; }

.fr-action-view {
    background: var(--fr-primary-light);
    border-color: color-mix(in srgb, var(--fr-primary) 25%, transparent);
    color: var(--fr-primary);
}
.fr-action-view:hover {
    background: var(--fr-primary); color: white;
    box-shadow: 0 4px 14px rgba(0,167,157,.30);
    transform: translateY(-1px);
}

.fr-action-download {
    background: rgba(99,102,241,.08);
    border-color: rgba(99,102,241,.28); color: #6366f1;
}
.fr-action-download:hover {
    background: #6366f1; color: white;
    box-shadow: 0 4px 14px rgba(99,102,241,.30);
    transform: translateY(-1px);
}


/* ── Share Copy Button ───────────────────────────────────────── */
.fr-share-copy {
    background: color-mix(in srgb, var(--fr-primary) 8%, white);
    border-color: color-mix(in srgb, var(--fr-primary) 22%, transparent);
    color: var(--fr-primary);
}
.fr-share-copy:hover {
    background: var(--fr-primary); color: white; border-color: var(--fr-primary);
    box-shadow: 0 4px 14px rgba(0,167,157,.30); transform: translateY(-1px);
}

/* SweetAlert position */
.fr-swal-below-nav { top: 76px !important; right: 1rem !important; }


/* ── Empty State ─────────────────────────────────────────────── */
.fr-empty {
    text-align: center; padding: 4rem 1rem;
    background: white; border-radius: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    border: 1.5px dashed var(--fr-gray-200);
}
.fr-empty-icon {
    width: 80px; height: 80px; border-radius: 50%;
    background: var(--fr-primary-light);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.25rem;
}
.fr-empty-icon i { font-size: 2rem; color: var(--fr-primary); }
.fr-empty-title { font-size: 1.2rem; font-weight: 700; color: var(--fr-dark); margin: 0 0 .5rem; }
.fr-empty-sub   { font-size: .9rem; color: var(--fr-gray); margin: 0; }


/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .fr-report-right { align-items: flex-start; }
}

@media (max-width: 767.98px) {
    .fr-report-item {
        flex-direction: column;
        align-items: flex-start;
        gap: .75rem;
    }
    .fr-report-right { width: 100%; }
    .fr-report-btns  { flex-wrap: wrap; }
    .fr-report-name  { white-space: normal; }
    .fr-section-title { font-size: 1.65rem; }
}

@media (max-width: 575.98px) {
    .fr-acc-btn     { padding: .9rem 1rem; }
    .fr-report-item { padding: .75rem 1rem; }
    .fr-action-btn span { display: none; }
    .fr-action-btn  { width: 34px; height: 34px; padding: 0; justify-content: center; }
    .fr-section-title { font-size: 1.4rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .fr-section-badge  { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .fr-section-title  { color: #e2e8f0; }
[data-theme="dark"] .fr-section-sub    { color: #9ca3af; }
[data-theme="dark"] .fr-info-card      { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .fr-feature-title  { color: #e2e8f0; }
[data-theme="dark"] .fr-feature-sub    { color: #9ca3af; }
[data-theme="dark"] .fr-info-desc      { color: #9ca3af; border-top-color: rgba(0,167,157,.12); }
[data-theme="dark"] .fr-acc-item       { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .fr-acc-btn        { background: transparent; color: #e2e8f0; }
[data-theme="dark"] .fr-acc-btn:hover  { background: rgba(0,167,157,.06); }
[data-theme="dark"] .fr-acc-btn:not(.collapsed) { background: rgba(0,167,157,.1); }
[data-theme="dark"] .fr-acc-name       { color: #e2e8f0; }
[data-theme="dark"] .fr-acc-count      { color: #9ca3af; }
[data-theme="dark"] .fr-report-list    { border-top-color: rgba(0,167,157,.12); }
[data-theme="dark"] .fr-report-item    { border-bottom-color: rgba(0,167,157,.1); }
[data-theme="dark"] .fr-report-item:hover { background: rgba(0,167,157,.05); }
[data-theme="dark"] .fr-report-name    { color: #e2e8f0; }
[data-theme="dark"] .fr-report-date    { color: #9ca3af; }
[data-theme="dark"] .fr-empty          { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .fr-empty-title    { color: #e2e8f0; }
[data-theme="dark"] .fr-empty-sub      { color: #9ca3af; }
</style>
@endverbatim
