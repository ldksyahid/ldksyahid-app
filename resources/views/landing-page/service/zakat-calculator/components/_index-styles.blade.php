@verbatim
<style>
/* ============================================================
   ZK — Kalkulator Zakat Styles
   Palette: #00a79d (teal) / #006D6D (dark teal)
   prefix: zk-
   ============================================================ */

/* ── Section Shell ───────────────────────────────────────── */
.zk-section {
    padding: 6.5rem 0 5rem;
    min-height: 100vh;
    background: transparent;
    position: relative;
}

/* ── Two-Column Layout (CSS grid) ────────────────────────── */
.zk-layout {
    display: grid;
    grid-template-columns: 5fr 7fr;
    gap: 2.5rem;
    align-items: start;
}

/* ============================================================
   LEFT — DECORATIVE COLUMN
   ============================================================ */
.zk-col-info {
    position: sticky;
    top: 7rem;
}

.zk-deco-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #00a79d;
    margin-bottom: 0.5rem;
}

.zk-deco-title {
    font-size: 2rem;
    font-weight: 800;
    color: #0d3d3c;
    line-height: 1.15;
    margin-bottom: 0;
}

.zk-deco-bar {
    width: 48px;
    height: 4px;
    background: linear-gradient(90deg, #00a79d 0%, #006D6D 100%);
    border-radius: 50rem;
    margin: 1.1rem 0 1.5rem;
}

/* Quote Box */
.zk-deco-quote {
    background: rgba(0,167,157,0.04);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    position: relative;
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.zk-deco-quote::before {
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
.zk-quran-arabic {
    font-size: 1.05rem;
    line-height: 2;
    text-align: right;
    direction: rtl;
    color: #0d3d3c;
    font-weight: 600;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}
.zk-deco-quote p {
    font-size: 0.87rem;
    line-height: 1.8;
    color: #374151;
    text-align: justify;
    margin-bottom: 0.6rem;
    position: relative;
    z-index: 1;
}
.zk-deco-quote p.zk-quran-arabic { margin-bottom: 0.5rem; }
.zk-deco-quote span {
    font-size: 0.75rem;
    font-weight: 700;
    color: #00a79d;
    display: block;
    text-align: right;
    position: relative;
    z-index: 1;
}

/* How-to card */
.zk-how-card {
    background: linear-gradient(135deg, rgba(0,167,157,0.05) 0%, rgba(255,255,255,0.8) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(0,167,157,0.15);
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.25rem;
}
.zk-how-title {
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #00a79d;
    margin-bottom: 0.85rem;
}
.zk-how-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.55rem;
}
.zk-how-list li {
    display: flex;
    align-items: flex-start;
    gap: 0.65rem;
    font-size: 0.83rem;
    color: #374151;
    line-height: 1.5;
}
.zk-how-bullet {
    width: 8px;
    height: 8px;
    min-width: 8px;
    border-radius: 50%;
    background: linear-gradient(135deg, #00a79d 0%, #6dd5c7 100%);
    margin-top: 0.35rem;
    box-shadow: 0 0 0 2px rgba(0,167,157,0.2);
    animation: zkBulletGrow 2.4s ease-in-out infinite;
    flex-shrink: 0;
}
@keyframes zkBulletGrow {
    0%, 100% { transform: scale(1);   box-shadow: 0 0 0 2px rgba(0,167,157,0.2); }
    50%       { transform: scale(1.3); box-shadow: 0 0 0 4px rgba(0,167,157,0.1); }
}

/* Method card */
.zk-method-card {
    background: rgba(245,158,11,0.05);
    border: 1.5px solid rgba(245,158,11,0.2);
    border-radius: 16px;
    padding: 1rem 1.25rem;
}
.zk-method-title {
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #92400e;
    margin-bottom: 0.5rem;
}
.zk-method-title i { color: #f59e0b; }
.zk-method-body {
    font-size: 0.82rem;
    line-height: 1.7;
    color: #374151;
    margin: 0;
}

/* ============================================================
   RIGHT — FORM COLUMN
   ============================================================ */
.zk-col-form {
    display: flex;
    flex-direction: column;
}

/* ── Form Card ──────────────────────────────────────────── */
.zk-form-card {
    background: linear-gradient(135deg, rgba(0,167,157,0.05) 0%, rgba(255,255,255,0.8) 100%);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(0,167,157,0.15);
    border-radius: 28px;
    padding: 2.25rem 2.5rem;
    box-shadow: 0 20px 60px rgba(0,167,157,0.08);
    transition: border-color 0.3s, box-shadow 0.3s;
}
.zk-form-card:hover {
    border-color: rgba(0,167,157,0.18);
    box-shadow: 0 8px 32px rgba(0,167,157,0.08);
}

/* Card Title (Panduan Nisab) */
.zk-card-title-wrap {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.zk-card-title-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: rgba(0,167,157,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #00a79d;
    font-size: 0.85rem;
    flex-shrink: 0;
}
.zk-card-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: #1f2937;
}

/* ── Gold Price Panel ───────────────────────────────────── */
.zk-gold-panel {
    background: #fffbeb;
    border: 1.5px solid #fde68a;
    border-radius: 16px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
}
.zk-gold-title {
    font-size: 0.73rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #92400e;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
.zk-gold-input-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 0.65rem;
}
.zk-gold-prefix,
.zk-gold-suffix {
    font-weight: 700;
    color: #92400e;
    font-size: 0.85rem;
    white-space: nowrap;
}
.zk-gold-input {
    width: 160px;
    height: 38px;
    padding: 0.45rem 0.75rem;
    border: 1.5px solid #fbbf24;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.9rem;
    color: #92400e;
    background: #fff;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.zk-gold-input:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(251,191,36,0.2);
}
.zk-gold-ref {
    font-size: 0.7rem;
    color: #b45309;
    line-height: 1.4;
}
.zk-gold-ref a { color: #b45309; text-decoration: underline; }

/* Badge harga aktif */
.zk-gold-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(0,167,157,0.08);
    border: 1px solid rgba(0,167,157,0.22);
    border-radius: 99px;
    padding: 0.3rem 0.9rem 0.3rem 0.65rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #007a73;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.zk-gold-badge-pulse {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #00a79d;
    animation: zkBadgePulse 2s infinite;
    flex-shrink: 0;
}
@keyframes zkBadgePulse {
    0%,100% { transform: scale(1);   opacity: 1; }
    50%      { transform: scale(1.5); opacity: 0.5; }
}

/* ── Form Group ─────────────────────────────────────────── */
.zk-form-group {
    margin-bottom: 1rem;
}
.zk-form-label {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    font-size: 0.82rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.5rem;
}
.zk-form-label i { color: #00a79d; }

/* ── Inputs ─────────────────────────────────────────────── */
.zk-form-input {
    width: 100%;
    padding: 0.7rem 1rem;
    background: rgba(255,255,255,0.8);
    border: 1.5px solid rgba(0,167,157,0.15);
    border-radius: 12px;
    font-size: 0.875rem;
    color: #1f2937;
    font-family: inherit;
    font-weight: 600;
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
    outline: none;
    box-sizing: border-box;
    display: block;
}
.zk-form-input:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 3px rgba(0,167,157,0.08);
    background: #fff;
}
.zk-form-input::placeholder { color: #9ca3af; font-weight: 400; }

/* Input group wrapper — border lives here, not on children */
.zk-input-group {
    display: flex;
    border: 1.5px solid rgba(0,167,157,0.15);
    border-radius: 12px;
    overflow: hidden;
    background: rgba(255,255,255,0.8);
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
}
.zk-input-group:focus-within {
    border-color: #00a79d;
    box-shadow: 0 0 0 3px rgba(0,167,157,0.08);
}

.zk-input-prefix {
    padding: 0.7rem 0.85rem;
    border: none;
    border-radius: 0;
    background: rgba(0,167,157,0.05);
    color: #007a73;
    font-weight: 700;
    display: flex;
    align-items: center;
    font-size: 0.875rem;
    flex-shrink: 0;
    white-space: nowrap;
}
.zk-input-with-prefix {
    border: none !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    background: transparent !important;
    flex: 1;
    min-width: 0;
}
.zk-input-with-prefix:focus {
    box-shadow: none !important;
    background: transparent !important;
}
.zk-input-prefix.hidden { display: none; }
.zk-form-input.no-prefix { border-radius: 12px !important; }

/* Select */
.zk-form-select {
    width: 100%;
    padding: 0.7rem 2.5rem 0.7rem 1rem;
    background: rgba(255,255,255,0.8);
    border: 1.5px solid rgba(0,167,157,0.15);
    border-radius: 12px;
    font-size: 0.875rem;
    color: #1f2937;
    font-family: inherit;
    font-weight: 600;
    outline: none;
    cursor: pointer;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2300a79d' stroke-width='2' fill='none'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    transition: border-color 0.25s ease;
    box-sizing: border-box;
}
.zk-form-select:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 3px rgba(0,167,157,0.08);
}

.zk-form-hint {
    font-size: 0.7rem;
    color: #9ca3af;
    margin-top: 0.3rem;
    display: block;
    line-height: 1.5;
}

/* ── Type Pills ─────────────────────────────────────────── */
.zk-pill-wrap {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    margin-bottom: 0;
}
.zk-pill {
    padding: 0.45rem 1rem;
    background: rgba(0,167,157,0.06);
    border: 1.5px solid rgba(0,167,157,0.14);
    border-radius: 50rem;
    cursor: pointer;
    white-space: nowrap;
    font-weight: 600;
    color: #475569;
    font-size: 0.82rem;
    transition: all 0.25s ease;
    user-select: none;
}
.zk-pill:hover {
    border-color: rgba(0,167,157,0.35);
    background: rgba(0,167,157,0.1);
    color: #00a79d;
}
.zk-pill.active {
    background: #00a79d;
    border-color: #00a79d;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,167,157,0.3);
}

/* ── Description box ────────────────────────────────────── */
.zk-desc-box {
    background: rgba(0,167,157,0.06);
    border-left: 3px solid #00a79d;
    border-radius: 0 10px 10px 0;
    padding: 0.6rem 1rem;
    margin-top: 0.75rem;
    margin-bottom: 1.25rem;
    font-size: 0.82rem;
    color: #374151;
    line-height: 1.6;
}

/* ── Perdagangan Summary ─────────────────────────────────── */
.zk-dagang-summary {
    background: rgba(0,167,157,0.05);
    border: 1.5px dashed rgba(0,167,157,0.3);
    border-radius: 12px;
    padding: 0.85rem 1rem;
    margin-bottom: 0.75rem;
}
.zk-dagang-summary-label {
    font-size: 0.72rem;
    color: #6b7280;
    margin-bottom: 0.2rem;
}
.zk-dagang-summary-val {
    font-weight: 700;
    font-size: 1.05rem;
    color: #00a79d;
}

/* ── Pertanian Tarif Toggle ─────────────────────────────── */
.zk-tarif-wrap {
    display: flex;
    gap: 10px;
    margin-bottom: 0;
    flex-wrap: wrap;
}
.zk-tarif-label {
    flex: 1;
    min-width: 140px;
    border: 1.5px solid rgba(0,167,157,0.2);
    border-radius: 12px;
    padding: 0.65rem 1rem;
    cursor: pointer;
    text-align: center;
    font-size: 0.82rem;
    font-weight: 600;
    color: #475569;
    transition: all 0.25s ease;
    user-select: none;
    line-height: 1.5;
}
.zk-tarif-label input { display: none; }
.zk-tarif-label:has(input:checked) {
    background: #00a79d;
    border-color: #00a79d;
    color: #fff;
}
.zk-tarif-label small {
    font-size: 0.72rem;
    font-weight: 400;
    opacity: 0.85;
}

/* ── Result Box ─────────────────────────────────────────── */
.zk-result-box {
    margin-top: 1.5rem;
    padding: 1.5rem;
    border-radius: 18px;
    text-align: center;
    background: rgba(0,167,157,0.05);
    border: 2px dashed rgba(0,167,157,0.35);
    display: none;
}
.zk-result-status {
    font-size: 0.73rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}
.zk-result-amount {
    font-size: 2.2rem;
    font-weight: 800;
    color: #00a79d;
    line-height: 1.2;
}

/* Pay button */
.zk-pay-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #00a79d 0%, #006D6D 100%);
    color: #fff !important;
    border-radius: 50rem;
    font-size: 0.875rem;
    font-weight: 700;
    box-shadow: 0 4px 16px rgba(0,167,157,0.3);
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.zk-pay-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,167,157,0.4);
}

/* ============================================================
   ACCORDION — Panduan Nisab
   ============================================================ */
.zk-accordion {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.zk-acc-item {
    border: 1px solid rgba(0,167,157,0.12);
    border-radius: 14px;
    overflow: hidden;
    transition: border-color 0.25s ease;
    background: transparent;
}
.zk-acc-item.zk-open {
    border-color: rgba(0,167,157,0.22);
}

.zk-acc-header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.9rem 1.1rem;
    background: none;
    border: none;
    cursor: pointer;
    text-align: left;
    transition: background 0.25s ease;
}
.zk-acc-header:hover {
    background: rgba(0,167,157,0.05);
}
.zk-acc-item.zk-open .zk-acc-header {
    background: rgba(0,167,157,0.07);
}
.zk-acc-title-text {
    font-size: 0.855rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.3;
    flex: 1;
}
.zk-acc-chevron {
    font-size: 0.72rem;
    color: #9ca3af;
    transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
    flex-shrink: 0;
    align-self: center;
}
.zk-acc-item.zk-open .zk-acc-chevron {
    transform: rotate(180deg);
    color: #00a79d;
}

/* Accordion Body */
.zk-acc-body {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4,0,0.2,1);
}
.zk-acc-item.zk-open .zk-acc-body {
    max-height: 3000px;
}
.zk-acc-content {
    padding: 0.75rem 1.1rem 1rem;
    font-size: 0.82rem;
    color: #475569;
    line-height: 1.7;
}

/* ── Nisab Tables ──────────────────────────────────────── */
.zk-nisab-table {
    width: 100%;
    font-size: 0.78rem;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
}
.zk-nisab-table th {
    background: rgba(0,167,157,0.1);
    color: #007a73;
    padding: 0.4rem 0.65rem;
    font-weight: 700;
    text-align: left;
}
.zk-nisab-table td {
    padding: 0.35rem 0.65rem;
    border-bottom: 1px solid rgba(0,167,157,0.08);
    color: #374151;
}
.zk-nisab-table tr:last-child td { border-bottom: none; }
.zk-table-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #9ca3af;
    letter-spacing: 0.05em;
    margin: 0.75rem 0 0.3rem;
}

/* ── Warning Card ──────────────────────────────────────── */
.zk-warning-card {
    background: #fffbeb;
    border: 1.5px solid #fde68a;
    border-radius: 20px;
    padding: 1.5rem 1.75rem;
}
.zk-warning-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.zk-warning-title i { color: #f59e0b; }
.zk-warning-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.zk-warning-list li {
    font-size: 0.8rem;
    color: #78350f;
    line-height: 1.6;
    padding-left: 1.1rem;
    position: relative;
}
.zk-warning-list li::before {
    content: '•';
    position: absolute;
    left: 0;
    color: #f59e0b;
    font-weight: 700;
}
.zk-warning-list a { color: #92400e; text-decoration: underline; }

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 991.98px) {
    .zk-section { padding: 5.5rem 0 4rem; }
    .zk-layout { grid-template-columns: 1fr; gap: 1.75rem; }
    .zk-col-info { position: static; }
    .zk-deco-title { font-size: 1.65rem; }
    .zk-form-card { padding: 1.75rem 1.5rem; }
}

@media (max-width: 767.98px) {
    .zk-section { padding: 4.5rem 0 3.5rem; }
    .zk-form-card { padding: 1.35rem 1.1rem; border-radius: 20px; }
    .zk-deco-title { font-size: 1.45rem; }
    .zk-result-amount { font-size: 1.7rem; }
    .zk-tarif-label { min-width: 100%; }
    .zk-warning-card { padding: 1.25rem; }
}

@media (max-width: 575.98px) {
    .zk-pill { font-size: 0.78rem; padding: 0.38rem 0.8rem; }
    .zk-gold-input { width: 130px; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .zk-deco-title      { color: #e2e8f0; }
[data-theme="dark"] .zk-deco-quote      { background: rgba(0,167,157,0.08); }
[data-theme="dark"] .zk-deco-quote p    { color: #cbd5e0; }
[data-theme="dark"] .zk-quran-arabic    { color: #e2e8f0; }
[data-theme="dark"] .zk-how-card        { background: #1a1f2e; border-color: rgba(0,167,157,0.2); }
[data-theme="dark"] .zk-how-list li     { color: #cbd5e0; }
[data-theme="dark"] .zk-method-card     { background: rgba(245,158,11,0.06); border-color: rgba(245,158,11,0.2); }
[data-theme="dark"] .zk-method-body     { color: #9ca3af; }
[data-theme="dark"] .zk-form-card       { background: #1a1f2e; border-color: rgba(0,167,157,0.2); }
[data-theme="dark"] .zk-card-title      { color: #e2e8f0; }
[data-theme="dark"] .zk-gold-panel      { background: rgba(245,158,11,0.05); border-color: rgba(245,158,11,0.2); }
[data-theme="dark"] .zk-gold-input      { background: #1e2535; color: #fbbf24; border-color: rgba(251,191,36,0.3); }
[data-theme="dark"] .zk-gold-badge      { background: rgba(0,167,157,0.1); border-color: rgba(0,167,157,0.25); }
[data-theme="dark"] .zk-form-label      { color: #e2e8f0; }
[data-theme="dark"] .zk-input-group      { background: #1e2535; border-color: rgba(0,167,157,0.25); }
[data-theme="dark"] .zk-input-group:focus-within { border-color: #00a79d; }
[data-theme="dark"] .zk-form-input,
[data-theme="dark"] .zk-form-select     { background: #1e2535; border-color: rgba(0,167,157,0.25); color: #e2e8f0; }
[data-theme="dark"] .zk-input-with-prefix { background: transparent !important; color: #e2e8f0; }
[data-theme="dark"] .zk-form-input:focus,
[data-theme="dark"] .zk-form-select:focus { background: #252b3b; border-color: #00a79d; }
[data-theme="dark"] .zk-input-with-prefix:focus { background: transparent !important; }
[data-theme="dark"] .zk-form-input::placeholder { color: rgba(226,232,240,0.35); }
[data-theme="dark"] .zk-input-prefix    { background: rgba(0,167,157,0.12); color: #4ade80; }
[data-theme="dark"] .zk-form-hint       { color: #6b7280; }
[data-theme="dark"] .zk-pill            { background: rgba(0,167,157,0.06); border-color: rgba(0,167,157,0.2); color: #9ca3af; }
[data-theme="dark"] .zk-pill.active     { background: #00a79d; color: #fff; }
[data-theme="dark"] .zk-desc-box        { background: rgba(0,167,157,0.08); color: #94a3b8; }
[data-theme="dark"] .zk-dagang-summary  { background: rgba(0,167,157,0.08); border-color: rgba(0,167,157,0.2); }
[data-theme="dark"] .zk-dagang-summary-label { color: #9ca3af; }
[data-theme="dark"] .zk-tarif-label     { border-color: rgba(0,167,157,0.25); color: #9ca3af; }
[data-theme="dark"] .zk-result-box      { background: rgba(0,167,157,0.08); border-color: rgba(0,167,157,0.3); }
[data-theme="dark"] .zk-acc-item        { border-color: rgba(0,167,157,0.2); }
[data-theme="dark"] .zk-acc-header:hover { background: rgba(0,167,157,0.08); }
[data-theme="dark"] .zk-acc-item.zk-open .zk-acc-header { background: rgba(0,167,157,0.1); }
[data-theme="dark"] .zk-acc-title-text  { color: #e2e8f0; }
[data-theme="dark"] .zk-acc-content     { color: #9ca3af; }
[data-theme="dark"] .zk-nisab-table th  { background: rgba(0,167,157,0.15); }
[data-theme="dark"] .zk-nisab-table td  { border-color: rgba(0,167,157,0.1); color: #9ca3af; }
[data-theme="dark"] .zk-warning-card    { background: rgba(245,158,11,0.05); border-color: rgba(245,158,11,0.2); }
[data-theme="dark"] .zk-warning-title   { color: #fbbf24; }
[data-theme="dark"] .zk-warning-list li { color: #9ca3af; }
[data-theme="dark"] .zk-warning-list a  { color: #fbbf24; }
</style>
@endverbatim
