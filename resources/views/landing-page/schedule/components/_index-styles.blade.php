{{-- ── Hero Jumbotron shared styles ── --}}
@include('components.hero-jumbotron.styles')

@verbatim
<style>
/* ============================================================
   SCH — Schedule Page Styles
   Palette dari global style-v1.0.0.css:
     --primary: #00a79d  --primary-dark: #008f86
     --primary-light: #e0f7f5  --warning: #ffc107
     --dark: #282d30  --secondary: #8d9297
   prefix: sch-
   ============================================================ */

/* ── Page shell ─────────────────────────────────────────── */
.sch-page-section {
    background: transparent;
    position: relative;
}

/* ── Desktop/Mobile toggle ──────────────────────────────── */
.sch-desktop-list { display: block; }
.sch-mobile-wrap  { display: none; }

/* ============================================================
   SECTION HEADER  (mengikuti style article)
   ============================================================ */
.sch-section-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #e0f7f5;
    color: #00a79d;
    border-radius: 50px;
    padding: 0.4rem 1.2rem;
    font-size: 0.85rem;
    font-weight: 600;
    position: relative;
}

/* Animated pulse dot — box-shadow ripple like article */
.sch-badge-pulse {
    width: 8px;
    height: 8px;
    background: #00a79d;
    border-radius: 50%;
    flex-shrink: 0;
    animation: schBadgePulse 2s ease infinite;
}
@keyframes schBadgePulse {
    0%,  100% { box-shadow: 0 0 0 0   rgba(0,167,157,0.4); }
    50%        { box-shadow: 0 0 0 6px rgba(0,167,157,0);   }
}

.sch-section-title {
    font-size: 2rem;
    font-weight: 700;
    color: #282d30;
    margin: 0;
}

.sch-section-sub {
    color: #8d9297;
    font-size: 1rem;
    margin: 0.5rem 0 0;
}

/* ============================================================
   DESKTOP CARDS (expand/collapse)
   ============================================================ */
.sch-card {
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 4px 24px rgba(0,167,157,0.08);
    margin-bottom: 1.25rem;
    overflow: hidden;
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}
.sch-card:hover {
    box-shadow: 0 14px 44px rgba(0,167,157,0.14);
    transform: translateY(-2px);
}

/* ── Card Header ── */
.sch-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1.35rem 1.75rem;
    cursor: pointer;
    transition: background 0.22s ease;
    user-select: none;
    outline: none;
}
.sch-card-header:hover {
    background: rgba(0,167,157,0.04);
}
.sch-card-header[aria-expanded="true"] {
    background: rgba(0,167,157,0.04);
}

.sch-card-meta { flex: 1; min-width: 0; }

.sch-meta-top {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 0.45rem;
    flex-wrap: wrap;
}

.sch-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    background: #e0f7f5;
    color: #00a79d;
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.03em;
    padding: 0.3rem 0.85rem;
    border-radius: 50rem;
}
.sch-date-badge i { font-size: 0.72rem; }

.sch-latest-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.38rem;
    background: rgba(255,193,7,0.12);
    color: #c68f00;
    font-size: 0.7rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 0.26rem 0.72rem;
    border-radius: 50rem;
}

/* Animated bullet for "Terbaru" */
.sch-latest-dot {
    width: 6px;
    height: 6px;
    background: #ffc107;
    border-radius: 50%;
    flex-shrink: 0;
    animation: schLatestPulse 2s ease-in-out infinite;
}
@keyframes schLatestPulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50%       { transform: scale(1.8); opacity: 0.55; }
}

.sch-card-title-text {
    font-size: 1.05rem;
    font-weight: 700;
    color: #282d30;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ── Toggle Button (right side) ── */
.sch-toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    background: #e0f7f5;
    color: #008f86;
    border-radius: 50rem;
    padding: 0.55rem 1.1rem;
    font-size: 0.8rem;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
    transition: background 0.22s ease, color 0.22s ease;
    pointer-events: none; /* header handles click */
}
.sch-card-header[aria-expanded="true"] .sch-toggle-btn {
    background: #00a79d;
    color: #fff;
}
.sch-toggle-icon {
    display: flex;
    align-items: center;
    transition: transform 0.35s ease;
}
.sch-card-header[aria-expanded="true"] .sch-toggle-icon {
    transform: rotate(180deg);
}

/* ── Collapsible Body ── */
.sch-card-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.55s cubic-bezier(0.4, 0, 0.2, 1);
}
.sch-card-body.is-open {
    max-height: 3500px;
}

.sch-img-wrap {
    padding: 0 1.75rem 1.75rem;
}
.sch-img {
    width: 100%;
    display: block;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
}

/* ── Empty State ── */
.sch-empty-state {
    text-align: center;
    padding: 4.5rem 2rem;
    background: #fff;
    border-radius: 24px;
    box-shadow: 0 4px 24px rgba(0,167,157,0.08);
}
.sch-empty-icon {
    font-size: 4rem;
    margin-bottom: 1.25rem;
    display: block;
    animation: schEmptyFloat 3s ease-in-out infinite;
}
@keyframes schEmptyFloat {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-12px); }
}
.sch-empty-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: #282d30;
    margin-bottom: 0.65rem;
}
.sch-empty-desc {
    color: #8d9297;
    font-size: 0.95rem;
    margin: 0;
}

/* ============================================================
   MOBILE CAROUSEL
   ============================================================ */
.sch-mob-card {
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 6px 28px rgba(0,167,157,0.1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.sch-mob-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.9rem 1.1rem 0.6rem;
    gap: 0.55rem;
    flex-wrap: wrap;
}

.sch-mob-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: #e0f7f5;
    color: #00a79d;
    font-size: 0.74rem;
    font-weight: 700;
    padding: 0.28rem 0.78rem;
    border-radius: 50rem;
}
.sch-mob-date-badge i { font-size: 0.68rem; }

.sch-mob-latest-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: rgba(255,193,7,0.12);
    color: #c68f00;
    font-size: 0.66rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.22rem 0.65rem;
    border-radius: 50rem;
}

.sch-mob-card-title {
    font-size: 0.88rem;
    font-weight: 700;
    color: #282d30;
    margin: 0 0 0.55rem;
    padding: 0 1.1rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sch-mob-img-wrap {
    width: 100%;
    aspect-ratio: 3/4;
    overflow: hidden;
}
.sch-mob-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    display: block;
    transition: transform 0.4s ease;
}
.sch-mob-card:hover .sch-mob-img-wrap img {
    transform: scale(1.03);
}

.sch-mob-expand-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.55rem;
    margin: 0.85rem 1.1rem 1.1rem;
    padding: 0.7rem 1rem;
    background: linear-gradient(135deg, #00a79d, #008f86);
    color: #fff;
    border: none;
    border-radius: 50rem;
    font-size: 0.83rem;
    font-weight: 700;
    cursor: pointer;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    box-shadow: 0 4px 16px rgba(0,167,157,0.28);
}
.sch-mob-expand-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,167,157,0.38);
}

/* Mobile empty card */
.sch-mob-empty {
    text-align: center;
    padding: 3rem 1.5rem;
    background: #fff;
    border-radius: 22px;
    box-shadow: 0 4px 20px rgba(0,167,157,0.08);
}

/* ── Carousel nav (prev/next + counter) ── */
.sch-mob-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    margin-top: 1.25rem;
}
.sch-mob-nav-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #e0f7f5;
    color: #00a79d;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    cursor: pointer;
    transition: background 0.22s ease, color 0.22s ease, transform 0.2s ease;
    flex-shrink: 0;
}
.sch-mob-nav-btn:hover {
    background: #00a79d;
    color: #fff;
    transform: scale(1.08);
}
.sch-mob-nav-btn:disabled {
    background: #f3f4f6;
    color: #c0c0c0;
    cursor: not-allowed;
    transform: none;
}
.sch-mob-counter {
    font-size: 0.85rem;
    font-weight: 700;
    color: #282d30;
    min-width: 48px;
    text-align: center;
    letter-spacing: 0.03em;
}

/* ============================================================
   MOBILE BOTTOM SHEET
   ============================================================ */
.sch-bottom-sheet {
    position: fixed;
    inset: 0;
    z-index: 1200;
    visibility: hidden;
    pointer-events: none;
}
.sch-bottom-sheet.is-open,
.sch-bottom-sheet.is-closing {
    visibility: visible;
    pointer-events: none;
}
.sch-bottom-sheet.is-open { pointer-events: all; }

.sch-bs-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.sch-bottom-sheet.is-open .sch-bs-backdrop { opacity: 1; }

.sch-bs-panel {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-radius: 28px 28px 0 0;
    max-height: 92vh;
    overflow-y: auto;
    overflow-x: hidden;
    transform: translateY(100%);
    transition: transform 0.38s cubic-bezier(0.4, 0, 0.2, 1);
}
.sch-bottom-sheet.is-open .sch-bs-panel { transform: translateY(0); }

.sch-bs-handle {
    width: 44px;
    height: 5px;
    background: #e9ecef;
    border-radius: 50rem;
    margin: 0.85rem auto 0;
}

.sch-bs-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 1rem;
    padding: 1.1rem 1.35rem 0.85rem;
}
.sch-bs-header-info { flex: 1; }

.sch-bs-month {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #00a79d;
    margin-bottom: 0.2rem;
}
.sch-bs-title {
    font-size: 1rem;
    font-weight: 800;
    color: #282d30;
    margin: 0;
    line-height: 1.3;
}

.sch-bs-close {
    width: 34px;
    height: 34px;
    min-width: 34px;
    background: #f3f4f6;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    color: #6b7280;
    cursor: pointer;
    transition: background 0.2s ease;
    flex-shrink: 0;
}
.sch-bs-close:hover { background: #e5e7eb; }

.sch-bs-body {
    padding: 0 1.1rem 2.5rem;
}
.sch-bs-img {
    width: 100%;
    border-radius: 18px;
    display: block;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

/* ── Scroll lock when sheet is open ── */
body.sch-modal-open { overflow: hidden; }

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 767.98px) {
    .sch-desktop-list { display: none; }
    .sch-mobile-wrap  { display: block; }
    .sch-section-title { font-size: 1.7rem; }
    .sch-section-sub { font-size: 0.9rem; }
}

@media (min-width: 768px) {
    .sch-mobile-wrap { display: none !important; }
    .sch-bottom-sheet { display: none !important; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .sch-section-badge   { background: rgba(0,167,157,.15); color: #4dd9cf; }
[data-theme="dark"] .sch-section-title   { color: #e2e8f0; }
[data-theme="dark"] .sch-section-sub     { color: #9ca3af; }
[data-theme="dark"] .sch-card            { background: #1a1f2e; }
[data-theme="dark"] .sch-card-header:hover,
[data-theme="dark"] .sch-card-header[aria-expanded="true"] { background: rgba(0,167,157,.08); }
[data-theme="dark"] .sch-card-title-text { color: #e2e8f0; }
[data-theme="dark"] .sch-toggle-btn      { background: #252b3b; color: #4dd9cf; }
[data-theme="dark"] .sch-card-header[aria-expanded="true"] .sch-toggle-btn { background: #00a79d; color: #fff; }
[data-theme="dark"] .sch-empty-state     { background: #1a1f2e; }
[data-theme="dark"] .sch-empty-title     { color: #e2e8f0; }
[data-theme="dark"] .sch-empty-desc      { color: #9ca3af; }
[data-theme="dark"] .sch-mob-card        { background: #1a1f2e; }
[data-theme="dark"] .sch-mob-card-title  { color: #e2e8f0; }
[data-theme="dark"] .sch-mob-empty       { background: #1a1f2e; }
[data-theme="dark"] .sch-bs-panel        { background: #1a1f2e; }
[data-theme="dark"] .sch-bs-title        { color: #e2e8f0; }
[data-theme="dark"] .sch-bs-close        { background: #252b3b; color: #9ca3af; }
</style>
@endverbatim
