@verbatim
<style>
/* ================================================================
   PERSURATAN LANDING PAGE  —  styles prefix: prs-
   Accent: #0ea5e9 (sky blue, matched with /service card)
   Pattern inspired by Call Kestari (ck-)
   ================================================================ */

:root {
    --prs-accent:       #0ea5e9;
    --prs-accent-dark:  #0284c7;
    --prs-accent-light: #e0f2fe;
    --prs-dark:         #282d30;
    --prs-gray:         #8d9297;
    --prs-gray-100:     #f3f4f6;
    --prs-gray-200:     #e5e7eb;
}

.prs-page-section { position: relative; z-index: 1; padding-top: 1rem; }

@keyframes prsCardIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: none; }
}


/* ─── Hero ─────────────────────────────────────────────────────── */
.prs-hero {
    text-align: center; max-width: 640px; margin: 0 auto 2.5rem;
    animation: prsCardIn .4s ease both;
}

.prs-hero-badge {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--prs-accent-light); color: var(--prs-accent-dark);
    border-radius: 50px; padding: .4rem 1.2rem;
    font-size: .85rem; font-weight: 600;
}
.prs-badge-pulse {
    width: 8px; height: 8px; background: var(--prs-accent);
    border-radius: 50%; flex-shrink: 0;
    animation: prsPulse 2s ease infinite;
}
@keyframes prsPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(14,165,233,.4); }
    50%       { box-shadow: 0 0 0 6px rgba(14,165,233,0); }
}

.prs-hero-title {
    font-size: 2.1rem; font-weight: 800; color: var(--prs-dark);
    margin: 1rem 0 .75rem; line-height: 1.25;
}
.prs-hero-sub { color: var(--prs-gray); font-size: 1rem; line-height: 1.65; margin: 0 0 1.5rem; }

.prs-hero-stats { display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap; }
.prs-stat {
    display: inline-flex; align-items: center; gap: .4rem;
    font-size: .82rem; font-weight: 600; color: var(--prs-accent-dark);
}
.prs-stat i { font-size: .85rem; }


/* ─── Alerts ───────────────────────────────────────────────────── */
.prs-alert {
    display: flex; align-items: flex-start; gap: .65rem;
    border-radius: 16px; padding: .9rem 1.1rem; margin-bottom: 1.25rem;
    font-size: .87rem; animation: prsCardIn .35s ease both;
}
.prs-alert i { font-size: 1rem; margin-top: .1rem; flex-shrink: 0; }
.prs-alert-success { background: #ecfdf5; color: #047857; }
.prs-alert-danger  { background: #fef2f2; color: #b91c1c; }


/* ─── Card ─────────────────────────────────────────────────────── */
.prs-card {
    background: white;
    border-radius: 24px;
    border: 1.5px solid var(--prs-gray-200);
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    padding: 1.6rem 1.75rem;
    margin-bottom: 1rem;
    transition: all .35s cubic-bezier(.4,0,.2,1);
    animation: prsCardIn .4s ease both;
}
.prs-card:hover {
    box-shadow: 0 16px 36px rgba(0,0,0,.08), 0 4px 16px rgba(14,165,233,.12);
    border-color: rgba(14,165,233,.25);
}

.prs-card-head { display: flex; align-items: center; gap: .9rem; margin-bottom: 1.4rem; }

/* Icon wrap — round, with inner white circle (ck-style) */
.prs-card-icon-wrap {
    width: 58px; height: 58px; border-radius: 50%; flex-shrink: 0;
    background: var(--prs-accent-light);
    display: flex; align-items: center; justify-content: center;
    transition: background .3s ease;
}
.prs-card:hover .prs-card-icon-wrap {
    background: linear-gradient(135deg, #c5ebfc, var(--prs-accent-light));
}
.prs-card-icon {
    width: 42px; height: 42px; border-radius: 50%;
    background: white;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 14px rgba(14,165,233,.22);
    transition: transform .3s ease, box-shadow .3s ease;
    color: var(--prs-accent-dark); font-size: 1.05rem;
}
.prs-card:hover .prs-card-icon {
    transform: scale(1.08) rotate(-4deg);
    box-shadow: 0 8px 22px rgba(14,165,233,.3);
}

.prs-card-title { font-size: 1.05rem; font-weight: 700; color: var(--prs-dark); margin: 0; }
.prs-card-sub   { font-size: .8rem; color: var(--prs-gray); margin: .15rem 0 0; }

.prs-link-all {
    font-size: .8rem; font-weight: 600; color: var(--prs-accent-dark);
    text-decoration: none; display: inline-flex; align-items: center; gap: .35rem;
    white-space: nowrap; transition: gap .2s ease; margin-left: auto;
}
.prs-link-all:hover { gap: .55rem; color: var(--prs-accent-dark); }
.prs-link-all i { font-size: .7rem; }


/* ─── Form ─────────────────────────────────────────────────────── */
.prs-field { margin-bottom: 1.1rem; animation: prsCardIn .3s ease both; }
.prs-label {
    display: flex; align-items: center; gap: .45rem;
    font-size: .85rem; font-weight: 600; color: var(--prs-dark);
    margin-bottom: .5rem;
}
.prs-label i { color: var(--prs-accent); font-size: .8rem; width: 14px; text-align: center; }

.prs-select, .prs-input, .prs-textarea {
    width: 100%; border: 1.5px solid var(--prs-gray-200); border-radius: 14px;
    padding: .7rem .9rem; font-size: .9rem; color: var(--prs-dark);
    background: white; transition: border-color .2s, box-shadow .2s;
    font-family: inherit;
}
.prs-select:focus, .prs-input:focus, .prs-textarea:focus {
    outline: none; border-color: var(--prs-accent);
    box-shadow: 0 0 0 3px rgba(14,165,233,.15);
}
.prs-textarea { resize: vertical; min-height: 90px; }
.prs-select.is-invalid, .prs-input.is-invalid { border-color: #e24b4a; }
.prs-error-text { color: #b91c1c; font-size: .78rem; margin-top: .4rem; }

.prs-divider {
    border: none; border-top: 1.5px dashed var(--prs-gray-200);
    margin: 1.1rem 0;
}
.prs-hint-text {
    display: flex; align-items: center; gap: .4rem;
    font-size: .78rem; color: var(--prs-gray); margin-bottom: 1rem;
}

.prs-btn-submit {
    display: flex; align-items: center; justify-content: center; gap: .55rem;
    background: var(--prs-accent);
    color: white; border: none; border-radius: 50px;
    padding: .85rem 1.5rem; font-size: .92rem; font-weight: 700;
    cursor: pointer; transition: all .3s ease;
    box-shadow: 0 4px 14px rgba(14,165,233,.28);
}
.prs-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(14,165,233,.38); }
.prs-btn-submit:active { transform: scale(.98); }
.prs-btn-submit i { font-size: .85rem; transition: transform .2s ease; }
.prs-btn-submit:hover i { transform: translateX(3px); }


/* ─── Info box ─────────────────────────────────────────────────── */
.prs-info-box {
    display: flex; gap: .9rem; align-items: flex-start;
    background: rgba(14,165,233,.06);
    border: 1.5px solid rgba(14,165,233,.18);
    border-radius: 18px; padding: 1.1rem 1.3rem;
    animation: prsCardIn .4s ease both;
}
.prs-info-icon {
    width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
    background: rgba(14,165,233,.15);
    color: var(--prs-accent-dark);
    display: flex; align-items: center; justify-content: center; font-size: .9rem;
}
.prs-info-text strong { font-size: .85rem; color: var(--prs-accent-dark); display: block; margin-bottom: .25rem; }
.prs-info-text p { font-size: .82rem; color: var(--prs-gray); line-height: 1.6; margin: 0; }


/* ─── Empty state (ck-style) ──────────────────────────────────── */
.prs-empty { text-align: center; padding: 2.5rem 1.5rem; }
.prs-empty-visual {
    position: relative; display: inline-flex; align-items: center; justify-content: center;
    width: 110px; height: 110px; margin: 0 auto 1.25rem;
}
.prs-empty-icon-wrap {
    position: relative; z-index: 3; width: 64px; height: 64px; border-radius: 22px;
    background: linear-gradient(135deg, #38bdf8, var(--prs-accent));
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 1.5rem;
    box-shadow: 0 10px 28px rgba(14,165,233,.32);
    animation: prsEmptyFloat 3.2s ease-in-out infinite;
}
@keyframes prsEmptyFloat {
    0%, 100% { transform: translateY(0) rotate(-2deg); }
    50%       { transform: translateY(-8px) rotate(2deg); }
}
.prs-empty-ring {
    position: absolute; border-radius: 50%;
    border: 2px solid rgba(14,165,233,.14);
    top: 50%; left: 50%; transform: translate(-50%, -50%);
    animation: prsEmptyRing 3s ease-out infinite;
}
.prs-empty-ring-1 { width: 86px; height: 86px; animation-delay: 0s; }
.prs-empty-ring-2 { width: 110px; height: 110px; animation-delay: .85s; }
@keyframes prsEmptyRing {
    0%   { opacity: .55; transform: translate(-50%, -50%) scale(.85); }
    100% { opacity: 0;   transform: translate(-50%, -50%) scale(1.3); }
}
.prs-empty p { color: var(--prs-gray); font-size: .85rem; margin: 0; }


/* ─── History list ─────────────────────────────────────────────── */
.prs-history-list { display: flex; flex-direction: column; gap: .65rem; }
.prs-history-item {
    display: flex; align-items: center; gap: .8rem;
    background: var(--prs-gray-100); border-radius: 14px; padding: .8rem 1rem;
    transition: background .2s ease, transform .2s ease;
    animation: prsCardIn .35s ease both;
}
.prs-history-item:hover {
    background: rgba(14,165,233,.07);
    transform: translateX(2px);
}

.prs-history-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.prs-status-pending  { background: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.18); }
.prs-status-approved { background: #10b981; box-shadow: 0 0 0 3px rgba(16,185,129,.18); }
.prs-status-rejected { background: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.18); }

.prs-history-content { flex: 1; min-width: 0; }
.prs-history-title { font-size: .87rem; font-weight: 600; color: var(--prs-dark); }
.prs-history-meta  { font-size: .73rem; color: var(--prs-gray); margin-top: .1rem; }

.prs-history-action { display: flex; align-items: center; gap: .5rem; flex-shrink: 0; }

.prs-badge {
    display: inline-flex; align-items: center;
    border-radius: 50px; padding: .25rem .75rem;
    font-size: .68rem; font-weight: 700;
}
.prs-badge-warning { background: #fef3c7; color: #92400e; }
.prs-badge-success { background: #d1fae5; color: #065f46; }
.prs-badge-danger  { background: #fee2e2; color: #991b1b; }

.prs-btn-download {
    width: 32px; height: 32px; border-radius: 50%;
    background: var(--prs-accent-light);
    color: var(--prs-accent-dark);
    display: flex; align-items: center; justify-content: center;
    font-size: .78rem; text-decoration: none;
    transition: all .22s ease;
}
.prs-btn-download:hover { background: var(--prs-accent); color: white; transform: scale(1.08); }


/* ─── Responsive ──────────────────────────────────────────────── */
@media (max-width: 767.98px) {
    .prs-hero-title { font-size: 1.65rem; }
    .prs-hero-sub   { font-size: .9rem; }
    .prs-hero-stats { gap: 1rem; }
    .prs-card { padding: 1.3rem 1.2rem; border-radius: 20px; }
    .prs-card-head { flex-wrap: wrap; }
    .prs-link-all { width: 100%; justify-content: flex-end; margin-top: .25rem; margin-left: 0; }
}
@media (max-width: 575.98px) {
    .prs-hero-title { font-size: 1.4rem; }
    .prs-history-item { flex-wrap: wrap; }
    .prs-card-icon-wrap { width: 50px; height: 50px; }
    .prs-card-icon { width: 36px; height: 36px; font-size: .9rem; }
}


/* ─── Dark Mode ───────────────────────────────────────────────── */
[data-theme="dark"] .prs-hero-title  { color: #e2e8f0; }
[data-theme="dark"] .prs-hero-sub    { color: #9ca3af; }
[data-theme="dark"] .prs-hero-badge  { background: rgba(14,165,233,.15); color: #38bdf8; }
[data-theme="dark"] .prs-stat        { color: #38bdf8; }

[data-theme="dark"] .prs-alert-success { background: rgba(16,185,129,.12); color: #6ee7b7; }
[data-theme="dark"] .prs-alert-danger  { background: rgba(239,68,68,.12); color: #fca5a5; }

[data-theme="dark"] .prs-card        { background: #1a1f2e; border-color: rgba(14,165,233,.2); }
[data-theme="dark"] .prs-card-icon-wrap { background: rgba(14,165,233,.1); }
[data-theme="dark"] .prs-card:hover .prs-card-icon-wrap { background: linear-gradient(135deg, rgba(14,165,233,.2), rgba(14,165,233,.08)); }
[data-theme="dark"] .prs-card-icon   { background: #252b3b; }
[data-theme="dark"] .prs-card-title  { color: #e2e8f0; }
[data-theme="dark"] .prs-card-sub    { color: #9ca3af; }
[data-theme="dark"] .prs-link-all    { color: #38bdf8; }

[data-theme="dark"] .prs-label       { color: #d1d5db; }
[data-theme="dark"] .prs-label i     { color: #38bdf8; }
[data-theme="dark"] .prs-select,
[data-theme="dark"] .prs-input,
[data-theme="dark"] .prs-textarea {
    background: #111827; border-color: rgba(255,255,255,.12); color: #e5e7eb;
}
[data-theme="dark"] .prs-select:focus,
[data-theme="dark"] .prs-input:focus,
[data-theme="dark"] .prs-textarea:focus {
    border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,.18);
}
[data-theme="dark"] .prs-divider     { border-top-color: rgba(255,255,255,.1); }
[data-theme="dark"] .prs-hint-text   { color: #9ca3af; }

[data-theme="dark"] .prs-info-box    { background: rgba(14,165,233,.08); border-color: rgba(14,165,233,.22); }
[data-theme="dark"] .prs-info-icon   { background: rgba(14,165,233,.18); color: #38bdf8; }
[data-theme="dark"] .prs-info-text strong { color: #38bdf8; }
[data-theme="dark"] .prs-info-text p { color: #9ca3af; }

[data-theme="dark"] .prs-empty p     { color: #9ca3af; }

[data-theme="dark"] .prs-history-item { background: #111827; }
[data-theme="dark"] .prs-history-item:hover { background: rgba(14,165,233,.1); }
[data-theme="dark"] .prs-history-title { color: #e2e8f0; }
[data-theme="dark"] .prs-history-meta  { color: #9ca3af; }

[data-theme="dark"] .prs-badge-warning { background: rgba(245,158,11,.18); color: #fbbf24; }
[data-theme="dark"] .prs-badge-success { background: rgba(16,185,129,.18); color: #6ee7b7; }
[data-theme="dark"] .prs-badge-danger  { background: rgba(239,68,68,.18); color: #fca5a5; }

[data-theme="dark"] .prs-btn-download  { background: rgba(14,165,233,.15); color: #38bdf8; }

/* ================================================================
   SIDEBAR WIDGETS (LOGO, SLA, CONTACT)
   ================================================================ */
.prs-sidebar-logo {
    width: 80px; height: 80px; margin: 0 auto 1rem;
    background: rgba(var(--bs-primary-rgb), .1);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--prs-primary);
}
.prs-logo-img { max-height: 90px; object-fit: contain; }

/* Wrapper Icon Spesifik */
.prs-info-icon-box {
    width: 100%; height: 100%;
    background: rgba(245, 158, 11, 0.15); color: #f59e0b;
}
.prs-help-icon-box {
    width: 100%; height: 100%; 
    background: rgba(var(--bs-primary-rgb), .15); color: var(--prs-primary);
}

/* SLA List */
.prs-sla-list {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 1rem;
}
.prs-sla-item {
    display: flex; align-items: flex-start; gap: .75rem;
    font-size: .85rem; color: #6c757d; line-height: 1.5;
}
.prs-sla-item i { color: var(--prs-primary); margin-top: .2rem; }

/* WhatsApp Icon Box */
.prs-wa-icon {
    display: flex; align-items: center; justify-content: center;
    width: 42px; height: 42px; border-radius: 12px;
    background: rgba(37,211,102,.15); color: #1da851;
    flex-shrink: 0; font-size: 1.25rem; transition: all 0.3s ease;
}
.prs-history-item:hover .prs-wa-icon {
    background: #25d366; color: #fff; transform: scale(1.05);
}

/* Chevron Icon */
.prs-chevron-icon { 
    font-size: 0.8rem; margin-left: auto; color: #adb5bd; transition: color 0.3s; 
}
.prs-history-item:hover .prs-chevron-icon { color: var(--prs-primary); }

/* ================================================================
   DARK MODE OVERRIDES UNTUK SIDEBAR
   ================================================================ */
[data-theme="dark"] .prs-sidebar-logo { background: rgba(var(--bs-primary-rgb), .15); }
[data-theme="dark"] .prs-info-icon-box { background: rgba(245, 158, 11, 0.1); color: #fbbf24; }
[data-theme="dark"] .prs-help-icon-box { background: rgba(var(--bs-primary-rgb), .1); color: #4dd9cf; }
[data-theme="dark"] .prs-sla-item { color: #9ca3af; }

/* WhatsApp Dark Mode */
[data-theme="dark"] .prs-wa-icon { background: rgba(37,211,102,.1); color: #25d366; }
[data-theme="dark"] .prs-history-item:hover .prs-wa-icon { background: #25d366; color: #111827; }
[data-theme="dark"] .prs-chevron-icon { color: #4b5563; }
</style>
@endverbatim