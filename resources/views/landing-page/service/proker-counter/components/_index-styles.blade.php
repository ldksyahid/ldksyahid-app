@verbatim
<style>
/* ============================================================
   KK — Kalkulator Kestari Styles
   Palette: #00a79d (teal) / #006D6D (dark teal)
   prefix: kk-
   ============================================================ */

/* ── Section Shell ───────────────────────────────────────── */
.kk-section {
    padding: 6.5rem 0 5rem;
    min-height: 100vh;
    background: transparent;
    position: relative;
}

/* ── Two-Column Layout (CSS grid, no Bootstrap .row) ─────── */
.kk-layout {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 2.5rem;
    align-items: start;
}

/* ============================================================
   LEFT — DECORATIVE COLUMN
   ============================================================ */
.kk-col-info {
    position: sticky;
    top: 7rem;
}

.kk-deco-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #00a79d;
    margin-bottom: 0.5rem;
}

.kk-deco-title {
    font-size: 2rem;
    font-weight: 800;
    color: #0d3d3c;
    line-height: 1.15;
    margin-bottom: 0;
}

.kk-deco-bar {
    width: 48px;
    height: 4px;
    background: linear-gradient(90deg, #00a79d 0%, #006D6D 100%);
    border-radius: 50rem;
    margin: 1.1rem 0 1.5rem;
}

.kk-deco-quote {
    background: linear-gradient(135deg, #f2fbfa 0%, #e8f8f6 100%);
    border-radius: 20px;
    padding: 1.5rem 1.75rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.kk-deco-quote::before {
    content: '\201C';
    position: absolute;
    top: -10px;
    left: 12px;
    font-size: 6rem;
    line-height: 1;
    color: rgba(0,167,157,0.12);
    font-family: Georgia, serif;
    pointer-events: none;
}
.kk-deco-quote p {
    font-size: 0.87rem;
    line-height: 1.8;
    color: #374151;
    text-align: justify;
    margin-bottom: 0.85rem;
    position: relative;
    z-index: 1;
}
.kk-deco-quote span {
    font-size: 0.75rem;
    font-weight: 700;
    color: #00a79d;
    display: block;
    text-align: right;
    position: relative;
    z-index: 1;
}

/* How-to card */
.kk-how-card {
    background: linear-gradient(135deg, rgba(0,167,157,0.05) 0%, rgba(255,255,255,0.8) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(0,167,157,0.15);
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
}
.kk-how-title {
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #00a79d;
    margin-bottom: 0.85rem;
}
.kk-how-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.55rem;
}
.kk-how-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    font-size: 0.83rem;
    color: #374151;
    line-height: 1.5;
}
.kk-how-bullet {
    width: 8px;
    height: 8px;
    min-width: 8px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00a79d 0%, #6dd5c7 100%);
    margin-top: 0.35rem;
    box-shadow: 0 0 0 2px rgba(0,167,157,0.2);
    animation: kkBulletGrow 2.4s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes kkBulletGrow {
    0%, 100% { transform: scale(1);   box-shadow: 0 0 0 2px rgba(0,167,157,0.2); }
    50%       { transform: scale(1.3); box-shadow: 0 0 0 4px rgba(0,167,157,0.1); }
}

/* Lihat Nilai button (mobile only) */
.kk-view-score-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    padding: 0.85rem 1.25rem;
    background: linear-gradient(135deg, #00a79d 0%, #006D6D 100%);
    color: #fff;
    border: none;
    border-radius: 50rem;
    font-size: 0.875rem;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(0,167,157,0.28);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    margin-top: 0.5rem;
}
.kk-view-score-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 28px rgba(0,167,157,0.38);
}

/* ============================================================
   RIGHT — FORM CARD (matches short-link style)
   ============================================================ */
.kk-form-card {
    background: linear-gradient(135deg, rgba(0,167,157,0.05) 0%, rgba(255,255,255,0.8) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(0,167,157,0.15);
    border-radius: 28px;
    padding: 2.25rem 2.5rem;
    box-shadow: 0 20px 60px rgba(0,167,157,0.08);
    transition: border-color 0.3s, box-shadow 0.3s;
}
.kk-form-card:hover {
    border-color: rgba(0,167,157,0.25);
    box-shadow: 0 25px 70px rgba(0,167,157,0.12);
}

/* ── Form Group (matches short-link .sl-form-group) ─────── */
.kk-form-group {
    margin-bottom: 1rem;
}
.kk-form-label {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.82rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}
.kk-form-label i { color: #00a79d; }

.kk-form-label-sm {
    display: block;
    font-size: 0.78rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.35rem;
}

.kk-form-group--inner {
    margin-bottom: 0.75rem;
}

/* ── Inputs (matches short-link .sl-form-input) ─────────── */
.kk-form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    background: rgba(255,255,255,0.9);
    border: 2px solid rgba(0,167,157,0.2);
    border-radius: 14px;
    font-size: 0.875rem;
    color: #1f2937;
    transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
    outline: none;
    box-sizing: border-box;
}
.kk-form-input:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 4px rgba(0,167,157,0.1);
    background: #fff;
    transform: translateY(-2px);
}
.kk-form-input::placeholder { color: #9ca3af; }
.kk-form-input:disabled,
.kk-input-disabled {
    background: rgba(240,240,240,0.8) !important;
    color: #9ca3af;
    cursor: not-allowed;
    border-color: rgba(0,167,157,0.1) !important;
}
.kk-input-flex { flex: 1; }

/* ── Jumlah Pelaksanaan Counter ──────────────────────────── */
.kk-counter-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    background: rgba(0,167,157,0.06);
    border: 2px solid rgba(0,167,157,0.12);
    border-radius: 16px;
    padding: 0.85rem 1.25rem;
    margin-bottom: 1.5rem;
}
.kk-counter-label {
    font-size: 0.83rem;
    font-weight: 600;
    color: #374151;
}
.kk-counter-label i { color: #00a79d; }
.kk-counter-controls {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.kk-counter-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: none;
    background: #00a79d;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
    flex-shrink: 0;
    padding: 0;
}
.kk-counter-btn:hover {
    background: #006D6D;
    transform: scale(1.1);
}
.kk-counter-val {
    font-size: 1.1rem;
    font-weight: 800;
    color: #0d3d3c;
    min-width: 24px;
    text-align: center;
    margin: 0;
}

/* ============================================================
   ACCORDION
   ============================================================ */
.kk-accordion {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 1.75rem;
}

.kk-acc-item {
    border: 2px solid rgba(0,167,157,0.15);
    border-radius: 18px;
    overflow: hidden;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
    background: rgba(255,255,255,0.6);
}
.kk-acc-item.kk-open {
    border-color: rgba(0,167,157,0.3);
    box-shadow: 0 8px 30px rgba(0,167,157,0.1);
}

/* Accordion Header Button */
.kk-acc-header {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.25rem;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    transition: background 0.25s ease;
}
.kk-acc-header:hover {
    background: rgba(0,167,157,0.05);
}
.kk-acc-item.kk-open .kk-acc-header {
    background: rgba(0,167,157,0.07);
}

.kk-acc-header-left {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex: 1;
}
.kk-acc-weight {
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    background: rgba(0,167,157,0.15);
    color: #00a79d;
    padding: 0.2rem 0.55rem;
    border-radius: 50rem;
    white-space: nowrap;
    flex-shrink: 0;
}
.kk-acc-title-text {
    font-size: 0.875rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.3;
}

.kk-acc-header-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
}
.kk-acc-score {
    font-size: 0.85rem;
    font-weight: 800;
    color: #00a79d;
    min-width: 42px;
    text-align: right;
}
.kk-acc-chevron {
    font-size: 0.75rem;
    color: #9ca3af;
    transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
    flex-shrink: 0;
}
.kk-acc-item.kk-open .kk-acc-chevron {
    transform: rotate(180deg);
    color: #00a79d;
}

/* Accordion Body — smooth height animation */
.kk-acc-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4,0,0.2,1), padding 0.3s ease;
    padding: 0 1.25rem;
}
.kk-acc-item.kk-open .kk-acc-body {
    max-height: 3000px;
    padding: 0.75rem 1.25rem 1.25rem;
}

/* Override external collapcontent display:none */
.kk-acc-body.collapcontent,
.collapcontent {
    display: block !important;
}

/* ── Dynamic Add/Remove rows ─────────────────────────────── */
.kk-dyn-wrap {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.5rem;
    margin-bottom: 0.65rem;
    padding: 0.5rem 0.75rem;
    background: rgba(0,167,157,0.05);
    border-radius: 10px;
}
.kk-dyn-label {
    font-size: 0.78rem;
    font-weight: 600;
    color: #374151;
    margin: 0;
    flex: 1;
}
.kk-dyn-btns {
    display: flex;
    gap: 0.4rem;
}
.kk-dyn-btn {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    border: none;
    font-size: 0.8rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s, transform 0.2s;
    padding: 0;
}
.kk-dyn-add  { background: rgba(0,167,157,0.12); color: #00a79d; }
.kk-dyn-remove { background: rgba(220,53,69,0.1); color: #dc3545; }
.kk-dyn-add:hover    { background: #00a79d; color: #fff; transform: scale(1.1); }
.kk-dyn-remove:hover { background: #dc3545; color: #fff; transform: scale(1.1); }

/* ── Check row (text + checkbox together) ────────────────── */
.kk-check-row {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    margin-bottom: 0.5rem;
}
.kk-check-row .kk-form-input {
    flex: 1;
    margin-bottom: 0;
}

/* Custom checkbox */
.kk-check {
    width: 18px;
    height: 18px;
    min-width: 18px;
    accent-color: #00a79d;
    cursor: pointer;
    border-radius: 4px;
}

/* Terlaksana label */
.kk-terlaksana-label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    white-space: nowrap;
    cursor: pointer;
}

/* ── Subsection titles ───────────────────────────────────── */
.kk-subsection-title {
    font-size: 0.78rem;
    font-weight: 700;
    color: #374151;
    margin: 0.85rem 0 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.kk-radio-label-p {
    font-size: 0.78rem;
    font-weight: 600;
    color: #374151;
    margin: 0.65rem 0 0.3rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.kk-inline-score {
    font-size: 0.75rem;
    font-weight: 700;
    color: #00a79d;
    background: rgba(0,167,157,0.1);
    padding: 0.1rem 0.45rem;
    border-radius: 50rem;
    white-space: nowrap;
}

/* ── Radio options ───────────────────────────────────────── */
.kk-radio-options-label {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.35rem;
}
.kk-radio-options-label span {
    flex: 1;
    text-align: center;
    font-size: 0.62rem;
    color: #9ca3af;
    font-weight: 600;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* The choices div must remain exactly class="choices" for JS */
.choices {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    flex-wrap: nowrap;
}

/* Radio label item inside .choices */
.kk-radio-wrap {
    flex: 1;
    display: flex;
    justify-content: center;
}
.kk-radio-input {
    width: 18px;
    height: 18px;
    accent-color: #00a79d;
    cursor: pointer;
}

/* ── Parameter row ───────────────────────────────────────── */
.kk-param-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.65rem;
    margin-top: 0.35rem;
}
.kk-param-row .kk-form-input { margin-bottom: 0; }
.kk-param-row > div { grid-column: 1 / -1; }

/* ── Unsur sections override (external CSS removes sharp borders) */
.unsur {
    border: 1.5px solid rgba(0,167,157,0.12) !important;
    border-radius: 14px !important;
    margin: 0.65rem 0 !important;
    padding: 0.75rem !important;
    background: rgba(255,255,255,0.5);
}

/* Nested unsur */
.unsur .unsur {
    border-color: rgba(0,167,157,0.08) !important;
    background: rgba(255,255,255,0.3);
    margin: 0.4rem 0 !important;
}

/* ============================================================
   RESULT TABLE
   ============================================================ */
.kk-result-section {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid rgba(0,167,157,0.12);
}

.kk-proker-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 0.75rem 1rem;
    background: rgba(0,167,157,0.06);
    border-radius: 14px;
}
.kk-proker-name-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #9ca3af;
    margin-bottom: 0.1rem;
}
.kk-proker-name-val {
    font-size: 0.9rem;
    font-weight: 700;
    color: #1f2937;
}
.kk-proker-score-wrap {
    text-align: right;
    flex-shrink: 0;
}
.kk-proker-score-label {
    font-size: 0.68rem;
    font-weight: 700;
    color: #9ca3af;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.kk-proker-total {
    font-size: 1.35rem;
    font-weight: 800;
    color: #00a79d;
    display: block;
    line-height: 1;
    margin-top: 0.1rem;
}

.kk-result-title {
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #00a79d;
    margin-bottom: 0.85rem;
}

.kk-table-wrap {
    overflow-x: auto;
    border-radius: 16px;
    border: 2px solid rgba(0,167,157,0.12);
}
.kk-table {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
    font-size: 0.83rem;
}
.kk-table thead th {
    background: rgba(0,167,157,0.08);
    padding: 0.75rem 1rem;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    color: #00a79d;
    border-bottom: 2px solid rgba(0,167,157,0.12);
}
.kk-table tbody td {
    padding: 0.7rem 1rem;
    color: #374151;
    border-bottom: 1px solid rgba(0,167,157,0.07);
    vertical-align: middle;
}
.kk-table tbody tr:last-child td { border-bottom: none; }
.kk-table tbody tr:nth-child(even) td {
    background: rgba(0,167,157,0.03);
}
.kk-table tbody tr.kk-table-total td {
    background: rgba(0,167,157,0.08);
    font-weight: 700;
    color: #0d3d3c;
    border-top: 2px solid rgba(0,167,157,0.2);
}
.kk-table td.konteneval {
    font-weight: 700;
    color: #00a79d;
    text-align: right;
}

.kk-credit {
    font-size: 0.72rem;
    color: #9ca3af;
    text-align: center;
    margin: 1rem 0 0;
}

/* ============================================================
   MOBILE BOTTOM SHEET (Score Results)
   ============================================================ */
.kk-bs-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px);
    z-index: 1070; opacity: 0; visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.kk-bs-backdrop.active { opacity: 1; visibility: visible; }

.kk-bottom-sheet {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: #fff; border-radius: 24px 24px 0 0;
    z-index: 1090; max-height: 88dvh;
    overflow-y: auto; overscroll-behavior: contain;
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
    padding-bottom: env(safe-area-inset-bottom, 1rem);
}
.kk-bottom-sheet.active { transform: translateY(0); }

.kk-bs-close {
    position: absolute; top: 0.75rem; right: 1rem;
    background: rgba(255,255,255,0.95); border: none;
    width: 36px; height: 36px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: #00a79d; font-size: 0.9rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
    transition: background 0.2s, color 0.2s; z-index: 5;
}
.kk-bs-close:hover { background: #00a79d; color: #fff; }

.kk-bs-content { padding: 1.5rem 1.25rem 1rem; }

/* Scroll lock */
body.kk-sheet-open { overflow: hidden !important; touch-action: none; }
body.kk-sheet-open .back-to-top {
    opacity: 0 !important; visibility: hidden !important; pointer-events: none !important;
    transition: opacity 0.3s ease, visibility 0.3s ease !important;
}

/* SweetAlert above sheet */
.kk-swal-above { top: 76px !important; right: 1rem !important; z-index: 1100 !important; }

/* Tablet: center sheet */
@media (min-width: 768px) {
    .kk-bottom-sheet { max-width: 480px; left: 50%; transform: translate(-50%, 100%); }
    .kk-bottom-sheet.active { transform: translate(-50%, 0); }
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 991.98px) {
    .kk-section { padding: 5.5rem 0 4rem; }
    .kk-layout { grid-template-columns: 1fr; gap: 1.75rem; }
    .kk-col-info { position: static; }
    .kk-deco-title { font-size: 1.65rem; }
    .kk-form-card { padding: 1.75rem 1.5rem; }
}

@media (max-width: 767.98px) {
    .kk-section { padding: 4.5rem 0 3.5rem; }
    .kk-form-card { padding: 1.35rem 1.1rem; border-radius: 20px; }
    .kk-deco-title { font-size: 1.45rem; }
    .kk-result-section { display: none; } /* shown via bottom sheet on mobile */
    .kk-param-row { grid-template-columns: 1fr; }
    .kk-param-row > div { grid-column: auto; }
    .kk-radio-options-label span { font-size: 0.55rem; }
}

@media (max-width: 575.98px) {
    .kk-acc-title-text { font-size: 0.8rem; }
    .kk-counter-wrap { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
}
</style>
@endverbatim
