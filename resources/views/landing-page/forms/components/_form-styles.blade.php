@verbatim
<style>
/* ================================================================
   FORM LANDING PAGE  —  prefix: gf-
   Primary: #00a79d  (follows global --primary)
   Style reference: Google Forms aesthetic, custom teal theme
   ================================================================ */

:root {
    --gf-primary:        #00a79d;
    --gf-primary-dark:   #008f86;
    --gf-primary-light:  #e0f7f5;
    --gf-danger:         #d93025;
    --gf-border:         #e0e0e0;
    --gf-bg:             #f0f4f8;
    --gf-card-bg:        #ffffff;
    --gf-text:           #202124;
    --gf-text-muted:     #5f6368;
    --gf-radius:         8px;
    --gf-shadow:         0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.04);
    --gf-transition:     all .18s ease;
}

/* ─── Page ─────────────────────────────────────────────────────── */
.gf-page {
    min-height: 100vh;
    padding: 5rem 0 4rem;
    position: relative;
    z-index: 2;
}

.gf-wrap {
    max-width: 640px;
    margin: 0 auto;
    padding: 0 1rem;
}

/* ─── Header Banner Image ──────────────────────────────────────── */
.gf-header-banner-wrap {
    width: 100%;
    overflow: hidden;
    border-radius: var(--gf-radius);
    margin-bottom: 12px;
    background: #000;
    box-shadow: var(--gf-shadow);
}
.gf-header-banner {
    width: 100%;
    height: auto;
    aspect-ratio: 4 / 1;
    object-fit: cover;
    display: block;
    opacity: .95;
}

/* ─── Header Card ──────────────────────────────────────────────── */
.gf-header-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    box-shadow: var(--gf-shadow);
    border: 1px solid var(--gf-border);
    border-top: 8px solid var(--gf-primary);
    padding: 24px;
    margin-bottom: 12px;
}

.gf-form-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gf-text);
    margin: 0 0 .5rem;
    line-height: 1.3;
}

.gf-form-desc {
    font-size: .9375rem;
    color: var(--gf-text-muted);
    line-height: 1.7;
    margin: 0;
    white-space: pre-line;
}

/* ─── Error Card ───────────────────────────────────────────────── */
.gf-error-card {
    background: #fff;
    border: 1px solid #fca5a5;
    border-left: 4px solid var(--gf-danger);
    border-radius: var(--gf-radius);
    padding: 16px 20px;
    margin-bottom: 12px;
    font-size: .875rem;
    color: #7f1d1d;
}

/* ─── Field Card ───────────────────────────────────────────────── */
.gf-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    box-shadow: var(--gf-shadow);
    padding: 24px;
    margin-bottom: 12px;
    transition: border-color .18s, box-shadow .18s;
}

.gf-card:focus-within {
    border-color: rgba(0,167,157,.45);
    box-shadow: var(--gf-shadow), 0 0 0 2px rgba(0,167,157,.08);
}

/* ─── Label ────────────────────────────────────────────────────── */
.gf-label {
    font-size: .9375rem;
    font-weight: 500;
    color: var(--gf-text);
    margin-bottom: 14px;
    display: block;
    line-height: 1.55;
}

.gf-required {
    color: var(--gf-danger);
    margin-left: 3px;
}

/* ─── Help text ────────────────────────────────────────────────── */
.gf-help {
    font-size: .72rem;
    color: var(--gf-text-muted);
    margin-top: 3px;
    margin-bottom: 8px;
    line-height: 1.5;
}

/* ─── Text inputs (underline style) ────────────────────────────── */
.gf-input,
.gf-textarea {
    display: block;
    width: 100%;
    background: var(--gf-card-bg);
    border: none;
    border-bottom: 1px solid #9aa0a6;
    border-radius: 0;
    padding: 8px 0 6px;
    font-size: .9375rem;
    color: var(--gf-text);
    transition: border-color .15s, box-shadow .15s;
    outline: none;
    -webkit-appearance: none;
    appearance: none;
    font-family: inherit;
}

.gf-input:focus,
.gf-textarea:focus {
    border-bottom: 2px solid var(--gf-primary);
    box-shadow: none;
    outline: none;
    padding-bottom: 5px;
}

.gf-input.is-invalid,
.gf-textarea.is-invalid {
    border-bottom-color: var(--gf-danger) !important;
}

.gf-input-readonly {
    background: transparent;
    cursor: default;
    color: var(--gf-text-muted);
    opacity: .85;
}

.gf-input::placeholder,
.gf-textarea::placeholder {
    color: #9aa0a6;
}

.gf-textarea {
    resize: vertical;
    min-height: 96px;
    line-height: 1.6;
}

/* ─── Custom Select Dropdown (.gf-csel-*) ─────────────────────── */
.gf-csel-wrap {
    position: relative;
}

.gf-csel-native {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    width: 1px;
    height: 1px;
    overflow: hidden;
}

.gf-csel-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 8px;
    cursor: pointer;
    transition: border-color .18s, box-shadow .18s;
    user-select: none;
    min-height: 44px;
}

.gf-csel-trigger:hover {
    border-color: rgba(0,167,157,.45);
}

.gf-csel-trigger:focus,
.gf-csel-trigger.open {
    border-color: var(--gf-primary);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0,167,157,.12);
}

.gf-csel-wrap.is-invalid .gf-csel-trigger {
    border-color: var(--gf-danger);
    box-shadow: 0 0 0 2px rgba(217,48,37,.08);
}

.gf-csel-current {
    flex: 1;
    font-size: .9375rem;
    color: var(--gf-text);
    line-height: 1.4;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.gf-csel-current.placeholder {
    color: #9aa0a6;
}

.gf-csel-arrow {
    color: var(--gf-text-muted);
    font-size: .72rem;
    flex-shrink: 0;
    transition: transform .2s ease;
    line-height: 1;
}

.gf-csel-trigger.open .gf-csel-arrow {
    transform: rotate(180deg);
}

.gf-csel-panel {
    display: none;
    position: absolute;
    top: calc(100% + 5px);
    left: 0;
    right: 0;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,.10), 0 2px 6px rgba(0,0,0,.06);
    z-index: 300;
    overflow: hidden;
    max-height: 260px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--gf-border) transparent;
}

.gf-csel-panel.open {
    display: block;
    animation: gfSlideDown .15s ease;
}

@keyframes gfSlideDown {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}

.gf-csel-panel::-webkit-scrollbar { width: 4px; }
.gf-csel-panel::-webkit-scrollbar-track { background: transparent; }
.gf-csel-panel::-webkit-scrollbar-thumb { background: var(--gf-border); border-radius: 2px; }

.gf-csel-option {
    padding: 10px 14px;
    font-size: .9rem;
    color: var(--gf-text);
    cursor: pointer;
    transition: background .12s, color .12s;
    line-height: 1.45;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.gf-csel-opt-placeholder {
    color: var(--gf-text-muted);
    font-size: .85rem;
    border-bottom: 1px solid var(--gf-border);
    cursor: default;
}

.gf-csel-option:not(.gf-csel-opt-placeholder):hover,
.gf-csel-option:not(.gf-csel-opt-placeholder).focused {
    background: rgba(0,167,157,.07);
    color: var(--gf-primary);
}

.gf-csel-option.selected {
    color: var(--gf-primary);
    font-weight: 600;
}

.gf-csel-option.selected::after {
    content: '\f00c';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: .7rem;
    flex-shrink: 0;
}

/* ─── Date / Time / Datetime ───────────────────────────────────── */
.gf-date-wrap {
    position: relative;
    display: flex;
    align-items: center;
    border-bottom: 1px solid #9aa0a6;
    transition: border-color .15s;
}

.gf-date-wrap:focus-within {
    border-bottom: 2px solid var(--gf-primary);
}

.gf-date-wrap .gf-input {
    border: none;
    flex: 1;
    padding-right: 0;
}

.gf-date-wrap .gf-input:focus {
    border: none;
    box-shadow: none;
    padding-bottom: 6px;
}

.gf-date-icon {
    color: var(--gf-text-muted);
    font-size: .85rem;
    padding: 0 4px 6px;
    pointer-events: auto;
    flex-shrink: 0;
    cursor: pointer;
}

/* Hide native calendar/clock browser icon to avoid double icon */
.gf-input[type="date"]::-webkit-calendar-picker-indicator,
.gf-input[type="time"]::-webkit-calendar-picker-indicator,
.gf-input[type="datetime-local"]::-webkit-calendar-picker-indicator {
    display: none;
}

/* ─── Custom Date Picker (.gf-dp-*) ───────────────────────────── */
.gf-dp-wrap { position: relative; }

.gf-dp-native {
    position: absolute; opacity: 0; pointer-events: none;
    width: 1px; height: 1px; overflow: hidden;
}

/* Trigger */
.gf-dp-trigger {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 8px;
    cursor: pointer;
    transition: border-color .18s, box-shadow .18s;
    user-select: none; min-height: 44px;
}

.gf-dp-trigger:hover { border-color: rgba(0,167,157,.45); }

.gf-dp-trigger:focus,
.gf-dp-trigger.open {
    border-color: var(--gf-primary);
    outline: none;
    box-shadow: 0 0 0 3px rgba(0,167,157,.12);
}

.gf-dp-wrap.is-invalid .gf-dp-trigger {
    border-color: var(--gf-danger);
    box-shadow: 0 0 0 2px rgba(217,48,37,.08);
}

.gf-dp-text {
    flex: 1; font-size: .9375rem; color: var(--gf-text); line-height: 1.4;
}

.gf-dp-text.placeholder { color: #9aa0a6; }

.gf-dp-icon {
    color: var(--gf-text-muted); font-size: .85rem; flex-shrink: 0; line-height: 1;
}

/* Calendar panel */
.gf-dp-panel {
    display: none; position: absolute;
    top: calc(100% + 5px); left: 0;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.12), 0 2px 6px rgba(0,0,0,.06);
    z-index: 300; width: 280px; max-width: calc(100vw - 2rem); overflow: hidden;
}

.gf-dp-panel.open { display: block; animation: gfSlideDown .15s ease; }

/* Header */
.gf-dp-header {
    display: flex; align-items: center; gap: 2px;
    padding: 10px 8px 8px;
    border-bottom: 1px solid var(--gf-border);
}

.gf-dp-caption-btn {
    flex: 1; border: none; background: transparent; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    font-size: .88rem; font-weight: 700; color: var(--gf-text);
    padding: 4px 6px; border-radius: 6px;
    transition: background .12s; font-family: inherit; line-height: 1.2;
}

.gf-dp-caption-btn:hover { background: rgba(0,167,157,.08); }

.gf-dp-caption-arrow {
    font-size: .58rem; color: var(--gf-text-muted);
    transition: transform .2s; flex-shrink: 0;
}

.gf-dp-panel[data-mode="year"] .gf-dp-caption-arrow,
.gf-dp-panel[data-mode="month"] .gf-dp-caption-arrow { transform: rotate(180deg); }

.gf-dp-panel[data-mode="year"] .gf-dp-nav { opacity: 0; pointer-events: none; }

.gf-dp-nav {
    width: 30px; height: 30px; border: none; background: transparent;
    cursor: pointer; border-radius: 6px; color: var(--gf-text-muted);
    font-size: .72rem; display: flex; align-items: center;
    justify-content: center; transition: background .12s, color .12s;
    flex-shrink: 0; padding: 0;
}

.gf-dp-nav:hover { background: rgba(0,167,157,.1); color: var(--gf-primary); }

/* Weekday labels */
.gf-dp-weekdays {
    display: grid; grid-template-columns: repeat(7, 1fr); padding: 6px 8px 2px;
}

.gf-dp-weekdays span {
    text-align: center; font-size: .65rem; font-weight: 700;
    color: var(--gf-text-muted); text-transform: uppercase; letter-spacing: .03em;
}

/* Day grid */
.gf-dp-grid {
    display: grid; grid-template-columns: repeat(7, 1fr);
    gap: 1px; padding: 4px 8px 8px;
}

.gf-dp-cell {
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 500; border-radius: 6px;
    cursor: pointer; transition: background .12s, color .12s;
    color: var(--gf-text); user-select: none;
}

.gf-dp-cell:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-dp-cell.other-month { color: var(--gf-text-muted); opacity: .35; }
.gf-dp-cell.other-month:hover { opacity: .65; }
.gf-dp-cell.today { border: 1.5px solid var(--gf-primary); color: var(--gf-primary); font-weight: 700; }
.gf-dp-cell.selected { background: var(--gf-primary) !important; color: #fff !important; font-weight: 700; border: none; }

/* Month grid (3 cols × 4 rows) */
.gf-dp-month-grid {
    display: none; grid-template-columns: repeat(3, 1fr); gap: 3px; padding: 8px;
}

.gf-dp-panel[data-mode="month"] .gf-dp-month-grid { display: grid; }
.gf-dp-panel[data-mode="month"] .gf-dp-weekdays,
.gf-dp-panel[data-mode="month"] .gf-dp-grid { display: none; }

.gf-dp-month-cell {
    text-align: center; padding: 10px 4px; border-radius: 8px;
    cursor: pointer; font-size: .85rem; font-weight: 500;
    color: var(--gf-text); transition: background .12s, color .12s; user-select: none;
}

.gf-dp-month-cell:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-dp-month-cell.cur-month { color: var(--gf-primary); font-weight: 700; }
.gf-dp-month-cell.sel-month { background: var(--gf-primary); color: #fff; font-weight: 700; }

/* Year grid — scrollable list (4 cols) */
.gf-dp-year-grid {
    display: none; grid-template-columns: repeat(4, 1fr);
    gap: 3px; padding: 8px; max-height: 208px; overflow-y: auto;
    scrollbar-width: thin; scrollbar-color: var(--gf-border) transparent;
}

.gf-dp-panel[data-mode="year"] .gf-dp-year-grid { display: grid; }
.gf-dp-panel[data-mode="year"] .gf-dp-weekdays,
.gf-dp-panel[data-mode="year"] .gf-dp-grid { display: none; }

.gf-dp-year-grid::-webkit-scrollbar { width: 4px; }
.gf-dp-year-grid::-webkit-scrollbar-track { background: transparent; }
.gf-dp-year-grid::-webkit-scrollbar-thumb { background: var(--gf-border); border-radius: 2px; }

.gf-dp-year-cell {
    text-align: center; padding: 8px 2px; border-radius: 8px;
    cursor: pointer; font-size: .82rem; font-weight: 500;
    color: var(--gf-text); transition: background .12s, color .12s; user-select: none;
}

.gf-dp-year-cell:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-dp-year-cell.cur-year { color: var(--gf-primary); font-weight: 700; }
.gf-dp-year-cell.sel-year { background: var(--gf-primary); color: #fff; font-weight: 700; }

/* Footer */
.gf-dp-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 6px 12px 10px; border-top: 1px solid var(--gf-border);
}

.gf-dp-btn {
    border: none; background: transparent; cursor: pointer;
    font-size: .8rem; font-weight: 600; padding: 4px 10px;
    border-radius: 6px; transition: background .12s, color .12s; font-family: inherit;
}

.gf-dp-btn-clear { color: var(--gf-text-muted); }
.gf-dp-btn-clear:hover { background: rgba(0,0,0,.05); color: var(--gf-text); }
.gf-dp-btn-today { color: var(--gf-primary); }
.gf-dp-btn-today:hover { background: rgba(0,167,157,.1); }

/* ─── Custom Time Picker (.gf-tp-*) ───────────────────────────── */
.gf-tp-wrap { position: relative; }

.gf-tp-native {
    position: absolute; opacity: 0; pointer-events: none;
    width: 1px; height: 1px; overflow: hidden;
}

.gf-tp-trigger {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 8px; cursor: pointer;
    transition: border-color .18s, box-shadow .18s;
    user-select: none; min-height: 44px;
}

.gf-tp-trigger:hover { border-color: rgba(0,167,157,.45); }

.gf-tp-trigger:focus,
.gf-tp-trigger.open {
    border-color: var(--gf-primary); outline: none;
    box-shadow: 0 0 0 3px rgba(0,167,157,.12);
}

.gf-tp-wrap.is-invalid .gf-tp-trigger {
    border-color: var(--gf-danger);
    box-shadow: 0 0 0 2px rgba(217,48,37,.08);
}

.gf-tp-text {
    flex: 1; font-size: .9375rem; color: var(--gf-text);
    line-height: 1.4; letter-spacing: .06em; font-variant-numeric: tabular-nums;
}

.gf-tp-text.placeholder { color: #9aa0a6; letter-spacing: 0; }

.gf-tp-icon { color: var(--gf-text-muted); font-size: .85rem; flex-shrink: 0; }

/* Panel */
.gf-tp-panel {
    display: none; position: absolute;
    top: calc(100% + 5px); left: 0;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.12), 0 2px 6px rgba(0,0,0,.06);
    z-index: 300; width: 176px; overflow: hidden;
}

.gf-tp-panel.open { display: block; animation: gfSlideDown .15s ease; }

/* Two columns + separator */
.gf-tp-cols {
    display: flex; align-items: stretch; gap: 0;
    padding: 0 8px 4px;
}

.gf-tp-col-wrap { flex: 1; display: flex; flex-direction: column; min-width: 0; }

.gf-tp-col-label {
    text-align: center; font-size: .65rem; font-weight: 700;
    color: var(--gf-text-muted); text-transform: uppercase;
    letter-spacing: .05em; padding: 8px 0 4px;
}

.gf-tp-sep {
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; font-weight: 700; color: var(--gf-text-muted);
    padding: 0 3px; flex-shrink: 0; padding-top: 22px;
}

.gf-tp-col {
    max-height: 200px; overflow-y: auto;
    scrollbar-width: thin; scrollbar-color: var(--gf-border) transparent;
}

.gf-tp-col::-webkit-scrollbar { width: 3px; }
.gf-tp-col::-webkit-scrollbar-track { background: transparent; }
.gf-tp-col::-webkit-scrollbar-thumb { background: var(--gf-border); border-radius: 2px; }

.gf-tp-item {
    text-align: center; padding: 7px 4px;
    font-size: .9rem; font-weight: 500;
    color: var(--gf-text); cursor: pointer; border-radius: 6px;
    transition: background .12s, color .12s; user-select: none;
    font-variant-numeric: tabular-nums;
}

.gf-tp-item:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-tp-item.selected { background: var(--gf-primary); color: #fff; font-weight: 700; }

/* Footer */
.gf-tp-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 6px 12px 10px; border-top: 1px solid var(--gf-border);
}

.gf-tp-btn {
    border: none; background: transparent; cursor: pointer;
    font-size: .8rem; font-weight: 600; padding: 4px 10px;
    border-radius: 6px; transition: background .12s, color .12s; font-family: inherit;
}

.gf-tp-clear { color: var(--gf-text-muted); }
.gf-tp-clear:hover { background: rgba(0,0,0,.05); color: var(--gf-text); }
.gf-tp-now { color: var(--gf-primary); }
.gf-tp-now:hover { background: rgba(0,167,157,.1); }

/* ─── Custom DateTime Picker (.gf-dtp-*) ──────────────────────── */
.gf-dtp-wrap { position: relative; }

.gf-dtp-native {
    position: absolute; opacity: 0; pointer-events: none;
    width: 1px; height: 1px; overflow: hidden;
}

.gf-dtp-trigger {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 8px; cursor: pointer;
    transition: border-color .18s, box-shadow .18s;
    user-select: none; min-height: 44px;
}

.gf-dtp-trigger:hover { border-color: rgba(0,167,157,.45); }

.gf-dtp-trigger:focus,
.gf-dtp-trigger.open {
    border-color: var(--gf-primary); outline: none;
    box-shadow: 0 0 0 3px rgba(0,167,157,.12);
}

.gf-dtp-wrap.is-invalid .gf-dtp-trigger {
    border-color: var(--gf-danger);
    box-shadow: 0 0 0 2px rgba(217,48,37,.08);
}

.gf-dtp-text {
    flex: 1; font-size: .9375rem; color: var(--gf-text);
    line-height: 1.4; font-variant-numeric: tabular-nums;
}

.gf-dtp-text.placeholder { color: #9aa0a6; }

.gf-dtp-icon { color: var(--gf-text-muted); font-size: .85rem; flex-shrink: 0; }

/* Panel */
.gf-dtp-panel {
    display: none; position: absolute;
    top: calc(100% + 5px); left: 0;
    background: var(--gf-card-bg);
    border: 1px solid var(--gf-border);
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,.12), 0 2px 6px rgba(0,0,0,.06);
    z-index: 300; width: 280px; max-width: calc(100vw - 2rem); overflow: hidden;
}

.gf-dtp-panel.open { display: block; animation: gfSlideDown .15s ease; }

/* Calendar header */
.gf-dtp-cal-header {
    display: flex; align-items: center; gap: 2px;
    padding: 10px 8px 8px;
    border-bottom: 1px solid var(--gf-border);
}

.gf-dtp-caption-btn {
    flex: 1; border: none; background: transparent; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 5px;
    font-size: .88rem; font-weight: 700; color: var(--gf-text);
    padding: 4px 6px; border-radius: 6px;
    transition: background .12s; font-family: inherit; line-height: 1.2;
}

.gf-dtp-caption-btn:hover { background: rgba(0,167,157,.08); }

.gf-dtp-caption-arrow {
    font-size: .58rem; color: var(--gf-text-muted);
    transition: transform .2s; flex-shrink: 0;
}

.gf-dtp-panel[data-mode="year"] .gf-dtp-caption-arrow,
.gf-dtp-panel[data-mode="month"] .gf-dtp-caption-arrow { transform: rotate(180deg); }

.gf-dtp-panel[data-mode="year"] .gf-dtp-nav { opacity: 0; pointer-events: none; }

.gf-dtp-nav {
    width: 30px; height: 30px; border: none; background: transparent;
    cursor: pointer; border-radius: 6px; color: var(--gf-text-muted);
    font-size: .72rem; display: flex; align-items: center;
    justify-content: center; transition: background .12s, color .12s;
    flex-shrink: 0; padding: 0;
}

.gf-dtp-nav:hover { background: rgba(0,167,157,.1); color: var(--gf-primary); }

/* Weekday labels */
.gf-dtp-weekdays {
    display: grid; grid-template-columns: repeat(7, 1fr); padding: 6px 8px 2px;
}

.gf-dtp-weekdays span {
    text-align: center; font-size: .65rem; font-weight: 700;
    color: var(--gf-text-muted); text-transform: uppercase; letter-spacing: .03em;
}

/* Day grid */
.gf-dtp-grid {
    display: grid; grid-template-columns: repeat(7, 1fr);
    gap: 1px; padding: 4px 8px 8px;
}

.gf-dtp-cell {
    aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
    font-size: .82rem; font-weight: 500; border-radius: 6px;
    cursor: pointer; transition: background .12s, color .12s;
    color: var(--gf-text); user-select: none;
}

.gf-dtp-cell:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-dtp-cell.other-month { color: var(--gf-text-muted); opacity: .35; }
.gf-dtp-cell.other-month:hover { opacity: .65; }
.gf-dtp-cell.today { border: 1.5px solid var(--gf-primary); color: var(--gf-primary); font-weight: 700; }
.gf-dtp-cell.selected { background: var(--gf-primary) !important; color: #fff !important; font-weight: 700; border: none; }

/* Month grid */
.gf-dtp-month-grid {
    display: none; grid-template-columns: repeat(3, 1fr); gap: 3px; padding: 8px;
}

.gf-dtp-panel[data-mode="month"] .gf-dtp-month-grid { display: grid; }
.gf-dtp-panel[data-mode="month"] .gf-dtp-weekdays,
.gf-dtp-panel[data-mode="month"] .gf-dtp-grid { display: none; }

.gf-dtp-month-cell {
    text-align: center; padding: 10px 4px; border-radius: 8px;
    cursor: pointer; font-size: .85rem; font-weight: 500;
    color: var(--gf-text); transition: background .12s, color .12s; user-select: none;
}

.gf-dtp-month-cell:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-dtp-month-cell.cur-month { color: var(--gf-primary); font-weight: 700; }
.gf-dtp-month-cell.sel-month { background: var(--gf-primary); color: #fff; font-weight: 700; }

/* Year grid */
.gf-dtp-year-grid {
    display: none; grid-template-columns: repeat(4, 1fr);
    gap: 3px; padding: 8px; max-height: 208px; overflow-y: auto;
    scrollbar-width: thin; scrollbar-color: var(--gf-border) transparent;
}

.gf-dtp-panel[data-mode="year"] .gf-dtp-year-grid { display: grid; }
.gf-dtp-panel[data-mode="year"] .gf-dtp-weekdays,
.gf-dtp-panel[data-mode="year"] .gf-dtp-grid { display: none; }

.gf-dtp-year-grid::-webkit-scrollbar { width: 4px; }
.gf-dtp-year-grid::-webkit-scrollbar-track { background: transparent; }
.gf-dtp-year-grid::-webkit-scrollbar-thumb { background: var(--gf-border); border-radius: 2px; }

.gf-dtp-year-cell {
    text-align: center; padding: 8px 2px; border-radius: 8px;
    cursor: pointer; font-size: .82rem; font-weight: 500;
    color: var(--gf-text); transition: background .12s, color .12s; user-select: none;
}

.gf-dtp-year-cell:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-dtp-year-cell.cur-year { color: var(--gf-primary); font-weight: 700; }
.gf-dtp-year-cell.sel-year { background: var(--gf-primary); color: #fff; font-weight: 700; }

/* Time section (below calendar) */
.gf-dtp-time-section {
    border-top: 1px solid var(--gf-border); padding: 0 8px 4px;
}

.gf-dtp-time-label {
    font-size: .65rem; font-weight: 700; color: var(--gf-text-muted);
    text-transform: uppercase; letter-spacing: .05em; padding: 6px 0 3px;
}

.gf-dtp-time-cols { display: flex; align-items: stretch; }

.gf-dtp-col-wrap { flex: 1; display: flex; flex-direction: column; min-width: 0; }

.gf-dtp-col-label {
    text-align: center; font-size: .6rem; font-weight: 700;
    color: var(--gf-text-muted); text-transform: uppercase;
    letter-spacing: .04em; padding: 2px 0 3px;
}

.gf-dtp-time-sep {
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; font-weight: 700; color: var(--gf-text-muted);
    padding: 16px 3px 0; flex-shrink: 0;
}

.gf-dtp-col {
    max-height: 112px; overflow-y: auto;
    scrollbar-width: thin; scrollbar-color: var(--gf-border) transparent;
}

.gf-dtp-col::-webkit-scrollbar { width: 3px; }
.gf-dtp-col::-webkit-scrollbar-track { background: transparent; }
.gf-dtp-col::-webkit-scrollbar-thumb { background: var(--gf-border); border-radius: 2px; }

.gf-dtp-time-item {
    text-align: center; padding: 6px 4px;
    font-size: .88rem; font-weight: 500;
    color: var(--gf-text); cursor: pointer; border-radius: 6px;
    transition: background .12s, color .12s; user-select: none;
    font-variant-numeric: tabular-nums;
}

.gf-dtp-time-item:hover { background: rgba(0,167,157,.09); color: var(--gf-primary); }
.gf-dtp-time-item.selected { background: var(--gf-primary); color: #fff; font-weight: 700; }

/* Footer */
.gf-dtp-footer {
    display: flex; align-items: center; justify-content: space-between;
    padding: 6px 12px 10px; border-top: 1px solid var(--gf-border);
}

.gf-dtp-btn {
    border: none; background: transparent; cursor: pointer;
    font-size: .8rem; font-weight: 600; padding: 4px 10px;
    border-radius: 6px; transition: background .12s, color .12s; font-family: inherit;
}

.gf-dtp-btn-clear { color: var(--gf-text-muted); }
.gf-dtp-btn-clear:hover { background: rgba(0,0,0,.05); color: var(--gf-text); }
.gf-dtp-btn-now { color: var(--gf-primary); }
.gf-dtp-btn-now:hover { background: rgba(0,167,157,.1); }

/* ─── Radio / Checkbox ─────────────────────────────────────────── */
.gf-options {
    display: flex;
    flex-direction: column;
    gap: 3px;
    margin-top: 4px;
}

.gf-option {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    border-radius: 8px;
    cursor: pointer;
    transition: background .15s, border-color .15s;
    position: relative;
    margin: 0;
    border: 1px solid transparent;
}

.gf-option:hover {
    background: rgba(0,167,157,.06);
    border-color: rgba(0,167,157,.2);
}

/* Custom radio & checkbox — fully custom appearance */
.gf-option-input[type="radio"],
.gf-option-input[type="checkbox"] {
    appearance: none;
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    min-width: 20px;
    cursor: pointer;
    margin: 0;
    position: relative;
    flex-shrink: 0;
    transition: border-color .15s, background .15s, box-shadow .15s;
}

/* Radio: circle */
.gf-option-input[type="radio"] {
    border: 2px solid #b0b7bf;
    border-radius: 50%;
    background: #fff;
}
.gf-option-input[type="radio"]:checked {
    border-color: var(--gf-primary);
    background: var(--gf-primary);
    box-shadow: inset 0 0 0 3px #fff;
}
.gf-option-input[type="radio"]:focus-visible {
    outline: 2px solid var(--gf-primary);
    outline-offset: 2px;
}

/* Checkbox: rounded square with checkmark */
.gf-option-input[type="checkbox"] {
    border: 2px solid #b0b7bf;
    border-radius: 4px;
    background: #fff;
}
.gf-option-input[type="checkbox"]:checked {
    border-color: var(--gf-primary);
    background: var(--gf-primary);
}
.gf-option-input[type="checkbox"]:checked::after {
    content: '';
    position: absolute;
    left: 5px;
    top: 2px;
    width: 6px;
    height: 10px;
    border: 2px solid #fff;
    border-top: none;
    border-left: none;
    transform: rotate(45deg);
}
.gf-option-input[type="checkbox"]:focus-visible {
    outline: 2px solid var(--gf-primary);
    outline-offset: 2px;
}

.gf-option-label {
    font-size: .9375rem;
    color: var(--gf-text);
    cursor: pointer;
    user-select: none;
    flex: 1;
    line-height: 1.45;
}

/* ─── Linear Scale ─────────────────────────────────────────────── */
.gf-linear-scale {
    overflow-x: auto;
    padding-bottom: 4px;
}
.gf-scale-row {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: max-content;
}
.gf-scale-options {
    display: flex;
    gap: 6px;
}
.gf-scale-option {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    min-width: 36px;
}
.gf-scale-number {
    font-size: .82rem;
    font-weight: 500;
    color: var(--gf-text-secondary);
    line-height: 1;
}
.gf-scale-radio {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: var(--gf-primary);
    margin: 0;
}
.gf-scale-edge-label {
    font-size: .78rem;
    color: var(--gf-text-secondary);
    white-space: nowrap;
    font-weight: 500;
    padding-top: 22px; /* align with radio row */
}
[data-theme="dark"] .gf-scale-number,
[data-theme="dark"] .gf-scale-edge-label {
    color: var(--gf-text-secondary);
}

/* ─── Rating (Star) ────────────────────────────────────────────── */
.gf-rating-wrap {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.gf-rating-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    user-select: none;
}
.gf-rating-input {
    display: none; /* hide native radio; selection tracked via JS */
}
.gf-rating-num {
    font-size: .78rem;
    font-weight: 500;
    color: var(--gf-text-secondary);
    line-height: 1;
}
.gf-star {
    font-size: 1.6rem;
    color: #d1d5db;
    transition: color .12s, transform .1s;
    line-height: 1;
}
.gf-rating-item:hover .gf-star,
.gf-star.filled {
    color: #f59e0b;
}
.gf-rating-item:active .gf-star {
    transform: scale(.9);
}
[data-theme="dark"] .gf-star {
    color: #4b5563;
}
[data-theme="dark"] .gf-rating-item:hover .gf-star,
[data-theme="dark"] .gf-star.filled {
    color: #fbbf24;
}

/* ─── File Upload ──────────────────────────────────────────────── */
.gf-file-drop {
    border: 2px dashed var(--gf-border);
    border-radius: 10px;
    padding: 2rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: var(--gf-transition);
    background: #fafafa;
    margin-top: 4px;
}

.gf-file-drop:hover,
.gf-file-drop.dragover {
    border-color: var(--gf-primary);
    background: var(--gf-primary-light);
}

.gf-file-drop input[type="file"] {
    display: none;
}

.gf-file-upload-icon {
    font-size: 1.85rem;
    color: var(--gf-primary);
    margin-bottom: .5rem;
    display: block;
}

.gf-file-hint {
    font-size: .875rem;
    font-weight: 600;
    color: var(--gf-text);
    margin-bottom: .25rem;
}

.gf-file-meta {
    font-size: .75rem;
    color: var(--gf-text-muted);
    line-height: 1.6;
}

.gf-file-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    margin-top: .85rem;
    font-size: .8rem;
    color: var(--gf-primary);
    font-weight: 600;
    background: var(--gf-primary-light);
    padding: .28rem .85rem;
    border-radius: 20px;
    transition: var(--gf-transition);
}

/* ─── Section Break Card ───────────────────────────────────────── */
.gf-section-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    border-left: 5px solid var(--gf-primary);
    box-shadow: var(--gf-shadow);
    padding: 18px 22px;
    margin-bottom: 12px;
}

.gf-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gf-text);
    margin: 0 0 .3rem;
}

.gf-section-desc {
    font-size: .875rem;
    color: var(--gf-text-muted);
    margin: 0;
    line-height: 1.6;
}

/* ─── Paragraph Card ───────────────────────────────────────────── */
.gf-para-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    box-shadow: var(--gf-shadow);
    padding: 20px 24px;
    margin-bottom: 12px;
}

.gf-para-text {
    font-size: .9375rem;
    color: var(--gf-text);
    margin: 0;
    line-height: 1.7;
    white-space: pre-line;
}

/* ─── Image Display Card ───────────────────────────────────────── */
.gf-image-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    box-shadow: var(--gf-shadow);
    padding: 16px 24px;
    margin-bottom: 12px;
    text-align: center;
}

.gf-embedded-image {
    max-width: 100%;
    max-height: 400px;
    border-radius: 6px;
    object-fit: contain;
}

.gf-image-caption {
    margin-top: 8px;
    margin-bottom: 0;
    font-size: .875rem;
    color: var(--gf-text-muted);
}

/* ─── Submit Area ──────────────────────────────────────────────── */
.gf-submit-area {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: .85rem;
    margin-top: 4px;
    padding: 4px 0;
}

.gf-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    padding: .7rem 2rem;
    background: var(--gf-primary);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: .9rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--gf-transition);
    box-shadow: 0 2px 10px rgba(0,167,157,.28);
    letter-spacing: .01em;
}

.gf-submit-btn:hover {
    background: var(--gf-primary-dark);
    box-shadow: 0 4px 16px rgba(0,167,157,.38);
    transform: translateY(-1px);
}

.gf-submit-btn:disabled {
    opacity: .65;
    cursor: default;
    transform: none;
    box-shadow: none;
}

.gf-privacy-note {
    font-size: .75rem;
    color: var(--gf-text-muted);
    margin: 0;
}

/* ─── Meta Footer ──────────────────────────────────────────────── */
.gf-meta-footer {
    text-align: center;
    margin-top: 1rem;
    font-size: .75rem;
    color: #9ca3af;
    padding-bottom: .5rem;
}

/* ─── Invalid message ──────────────────────────────────────────── */
.gf-invalid {
    font-size: .8rem;
    color: var(--gf-danger);
    margin-top: 5px;
    display: block;
}

/* ─── Card-per-field state (required border highlight) ─────────── */
.gf-card.has-error {
    border-color: rgba(217,48,37,.35);
    box-shadow: var(--gf-shadow), 0 0 0 2px rgba(217,48,37,.06);
}

/* ─── Thank You / Closed State Cards ──────────────────────────── */
.gf-state-page {
    min-height: 100vh;
    display: flex;
    align-items: flex-start;
    padding: 5rem 0 3rem;
    position: relative;
    z-index: 2;
}

.gf-state-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    border: 1px solid var(--gf-border);
    border-top: 10px solid var(--gf-primary);
    box-shadow: 0 2px 6px rgba(0,0,0,.06);
    padding: 1.75rem 1.75rem 2rem;
    text-align: left;
    max-width: 640px;
    margin: 0 auto;
}

.gf-state-icon {
    font-size: 2.75rem;
    margin: .25rem 0 1rem;
    line-height: 1;
}
.gf-state-icon.c-success { color: #00a79d; }
.gf-state-icon.c-indigo  { color: #6366f1; }
.gf-state-icon.c-gray    { color: #6b7280; }
.gf-state-icon.c-amber   { color: #f59e0b; }
.gf-state-icon.c-red     { color: #ef4444; }
.gf-state-icon.c-blue    { color: #3b82f6; }

.gf-state-form-title {
    font-size: 1.75rem;
    font-weight: 400;
    color: var(--gf-text);
    margin: 0 0 1rem;
    padding-bottom: .85rem;
    border-bottom: 1px solid var(--gf-border);
}

.gf-state-body {
    font-size: .9375rem;
    color: var(--gf-text);
    line-height: 1.65;
    margin-bottom: .5rem;
}

.gf-state-link {
    display: inline-block;
    margin-top: .75rem;
    font-size: .875rem;
    color: var(--gf-primary);
    font-weight: 500;
    text-decoration: none;
}

.gf-state-link:hover {
    text-decoration: underline;
    color: var(--gf-primary-dark);
}

.gf-state-link + .gf-state-link {
    margin-left: 1.25rem;
}

/* Keep legacy alias so JS-generated cards still work */
.gf-again-link {
    display: inline-block;
    margin-top: .75rem;
    font-size: .875rem;
    color: var(--gf-primary);
    font-weight: 500;
    text-decoration: none;
}

.gf-again-link:hover {
    text-decoration: underline;
    color: var(--gf-primary-dark);
}

/* ─── Responsive ───────────────────────────────────────────────── */
@media (max-width: 575.98px) {
    .gf-page { padding: 4.5rem 0 3rem; }
    .gf-header-card,
    .gf-card,
    .gf-section-card,
    .gf-para-card { padding: 18px 16px; }
    .gf-form-title { font-size: 1.35rem; }
    .gf-submit-area { flex-direction: column; align-items: flex-start; }
    .gf-submit-btn { width: 100%; justify-content: center; }
    .gf-state-card { padding: 2rem 1.25rem; }
}

/* ─── Multi-step: Section chip (inside header card, Google Forms style) */
.gf-section-chip {
    display: inline-flex;
    align-items: center;
    background: var(--gf-primary);
    color: #fff;
    font-size: .72rem;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 20px;
    margin-bottom: 14px;
    letter-spacing: .03em;
    line-height: 1.6;
}

/* Progress bar/dots when inside the header card */
.gf-progress-track--hdr {
    margin-top: 14px;
    margin-bottom: 0;
}

/* ─── Autofill override (suppress browser blue/yellow tint) ─── */
.gf-input:-webkit-autofill,
.gf-input:-webkit-autofill:hover,
.gf-input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 30px #ffffff inset !important;
    -webkit-text-fill-color: #202124 !important;
    transition: background-color 5000s ease-in-out 0s;
    caret-color: #202124;
}

/* ─── Dark Mode ────────────────────────────────────────────────── */
[data-theme="dark"] {
    --gf-bg:         #111317;
    --gf-card-bg:    #1e2025;
    --gf-text:       #e4e6eb;
    --gf-text-muted: #9ca3af;
    --gf-border:     #2d3139;
}

[data-theme="dark"] .gf-input,
[data-theme="dark"] .gf-textarea {
    color: var(--gf-text);
    background: var(--gf-card-bg);
    border-bottom-color: #4b5563;
}

[data-theme="dark"] .gf-input:-webkit-autofill,
[data-theme="dark"] .gf-input:-webkit-autofill:hover,
[data-theme="dark"] .gf-input:-webkit-autofill:focus {
    -webkit-box-shadow: 0 0 0 30px #1e2025 inset !important;
    -webkit-text-fill-color: #e4e6eb !important;
    caret-color: #e4e6eb;
}

[data-theme="dark"] .gf-section-chip {
    background: var(--gf-primary);
    color: #fff;
}

[data-theme="dark"] .gf-input::placeholder,
[data-theme="dark"] .gf-textarea::placeholder {
    color: #6b7280;
}

/* Fix: email placeholder in dark mode hidden to avoid collision */
[data-theme="dark"] .gf-input[type="email"]::placeholder {
    color: transparent;
}

[data-theme="dark"] .gf-input:focus,
[data-theme="dark"] .gf-textarea:focus {
    border-bottom-color: var(--gf-primary);
}

[data-theme="dark"] .gf-date-wrap {
    border-bottom-color: #4b5563;
}
[data-theme="dark"] .gf-date-wrap:focus-within {
    border-bottom-color: var(--gf-primary);
}

[data-theme="dark"] .gf-dp-trigger { border-color: #374151; }
[data-theme="dark"] .gf-dp-trigger:hover { border-color: rgba(0,167,157,.45); }
[data-theme="dark"] .gf-dp-trigger:focus,
[data-theme="dark"] .gf-dp-trigger.open {
    border-color: var(--gf-primary);
    box-shadow: 0 0 0 3px rgba(0,167,157,.15);
}
[data-theme="dark"] .gf-dp-text.placeholder { color: #6b7280; }
[data-theme="dark"] .gf-dp-panel {
    background: #1e2025; border-color: #2d3139;
    box-shadow: 0 12px 40px rgba(0,0,0,.4), 0 2px 8px rgba(0,0,0,.3);
}
[data-theme="dark"] .gf-dp-header,
[data-theme="dark"] .gf-dp-footer { border-color: #2d3139; }
[data-theme="dark"] .gf-dp-caption-btn:hover { background: rgba(0,167,157,.12); }
[data-theme="dark"] .gf-dp-nav:hover { background: rgba(0,167,157,.15); color: #2dd4bf; }
[data-theme="dark"] .gf-dp-cell:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-dp-cell.today { border-color: #2dd4bf; color: #2dd4bf; }
[data-theme="dark"] .gf-dp-month-cell:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-dp-month-cell.cur-month { color: #2dd4bf; }
[data-theme="dark"] .gf-dp-year-cell:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-dp-year-cell.cur-year { color: #2dd4bf; }
[data-theme="dark"] .gf-dp-year-grid::-webkit-scrollbar-thumb { background: #374151; }
[data-theme="dark"] .gf-dp-btn-clear:hover { background: rgba(255,255,255,.06); }
[data-theme="dark"] .gf-dp-btn-today:hover { background: rgba(0,167,157,.12); }

[data-theme="dark"] .gf-tp-trigger { border-color: #374151; }
[data-theme="dark"] .gf-tp-trigger:hover { border-color: rgba(0,167,157,.45); }
[data-theme="dark"] .gf-tp-trigger:focus,
[data-theme="dark"] .gf-tp-trigger.open {
    border-color: var(--gf-primary); box-shadow: 0 0 0 3px rgba(0,167,157,.15);
}
[data-theme="dark"] .gf-tp-text.placeholder { color: #6b7280; }
[data-theme="dark"] .gf-tp-panel {
    background: #1e2025; border-color: #2d3139;
    box-shadow: 0 12px 40px rgba(0,0,0,.4), 0 2px 8px rgba(0,0,0,.3);
}
[data-theme="dark"] .gf-tp-footer { border-top-color: #2d3139; }
[data-theme="dark"] .gf-tp-item:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-tp-col::-webkit-scrollbar-thumb { background: #374151; }
[data-theme="dark"] .gf-tp-clear:hover { background: rgba(255,255,255,.06); }
[data-theme="dark"] .gf-tp-now:hover { background: rgba(0,167,157,.12); }

[data-theme="dark"] .gf-dtp-trigger { border-color: #374151; }
[data-theme="dark"] .gf-dtp-trigger:hover { border-color: rgba(0,167,157,.45); }
[data-theme="dark"] .gf-dtp-trigger:focus,
[data-theme="dark"] .gf-dtp-trigger.open {
    border-color: var(--gf-primary); box-shadow: 0 0 0 3px rgba(0,167,157,.15);
}
[data-theme="dark"] .gf-dtp-text.placeholder { color: #6b7280; }
[data-theme="dark"] .gf-dtp-panel {
    background: #1e2025; border-color: #2d3139;
    box-shadow: 0 12px 40px rgba(0,0,0,.4), 0 2px 8px rgba(0,0,0,.3);
}
[data-theme="dark"] .gf-dtp-cal-header,
[data-theme="dark"] .gf-dtp-time-section,
[data-theme="dark"] .gf-dtp-footer { border-color: #2d3139; }
[data-theme="dark"] .gf-dtp-caption-btn:hover { background: rgba(0,167,157,.12); }
[data-theme="dark"] .gf-dtp-nav:hover { background: rgba(0,167,157,.15); color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-cell:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-cell.today { border-color: #2dd4bf; color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-month-cell:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-month-cell.cur-month { color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-year-cell:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-year-cell.cur-year { color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-year-grid::-webkit-scrollbar-thumb { background: #374151; }
[data-theme="dark"] .gf-dtp-time-item:hover { background: rgba(0,167,157,.12); color: #2dd4bf; }
[data-theme="dark"] .gf-dtp-col::-webkit-scrollbar-thumb { background: #374151; }
[data-theme="dark"] .gf-dtp-btn-clear:hover { background: rgba(255,255,255,.06); }
[data-theme="dark"] .gf-dtp-btn-now:hover { background: rgba(0,167,157,.12); }

[data-theme="dark"] .gf-csel-trigger {
    border-color: #374151;
}
[data-theme="dark"] .gf-csel-trigger:hover {
    border-color: rgba(0,167,157,.45);
}
[data-theme="dark"] .gf-csel-trigger:focus,
[data-theme="dark"] .gf-csel-trigger.open {
    border-color: var(--gf-primary);
    box-shadow: 0 0 0 3px rgba(0,167,157,.15);
}
[data-theme="dark"] .gf-csel-current.placeholder {
    color: #6b7280;
}
[data-theme="dark"] .gf-csel-panel {
    background: #1e2025;
    border-color: #2d3139;
    box-shadow: 0 12px 40px rgba(0,0,0,.4), 0 2px 8px rgba(0,0,0,.3);
}
[data-theme="dark"] .gf-csel-opt-placeholder {
    border-bottom-color: #2d3139;
}
[data-theme="dark"] .gf-csel-option:not(.gf-csel-opt-placeholder):hover,
[data-theme="dark"] .gf-csel-option:not(.gf-csel-opt-placeholder).focused {
    background: rgba(0,167,157,.1);
    color: #2dd4bf;
}
[data-theme="dark"] .gf-csel-option.selected {
    color: #2dd4bf;
}
[data-theme="dark"] .gf-csel-panel::-webkit-scrollbar-thumb {
    background: #374151;
}

/* Date/time native picker dark */
[data-theme="dark"] .gf-input[type="date"],
[data-theme="dark"] .gf-input[type="time"],
[data-theme="dark"] .gf-input[type="datetime-local"] {
    color-scheme: dark;
    color: var(--gf-text);
}

[data-theme="dark"] .gf-option:hover {
    background: rgba(0,167,157,.08);
    border-color: rgba(0,167,157,.28);
}
[data-theme="dark"] .gf-option-label { color: var(--gf-text); }

/* Dark mode custom radio/checkbox */
[data-theme="dark"] .gf-option-input[type="radio"] {
    border-color: #4b5563;
    background: #252830;
}
[data-theme="dark"] .gf-option-input[type="radio"]:checked {
    border-color: var(--gf-primary);
    background: var(--gf-primary);
    box-shadow: inset 0 0 0 3px #1e2025;
}
[data-theme="dark"] .gf-option-input[type="checkbox"] {
    border-color: #4b5563;
    background: #252830;
}

[data-theme="dark"] .gf-file-drop {
    background: #252830;
    border-color: #374151;
}
[data-theme="dark"] .gf-file-drop:hover,
[data-theme="dark"] .gf-file-drop.dragover {
    background: rgba(0,167,157,.07);
    border-color: var(--gf-primary);
}
[data-theme="dark"] .gf-file-hint { color: var(--gf-text); }
[data-theme="dark"] .gf-select-icon  { color: #6b7280; }

[data-theme="dark"] .gf-error-card {
    background: #2a1a1a;
    border-color: #4b1c1c;
    border-left-color: var(--gf-danger);
    color: #f87171;
}

/* ─── Multi-step: Progress bar ─────────────────────────────────── */
.gf-progress-wrap {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    box-shadow: var(--gf-shadow);
    border: 1px solid var(--gf-border);
    border-top: 8px solid var(--gf-primary);
    padding: 20px 24px 16px;
    margin-bottom: 12px;
}

.gf-progress-header {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 10px;
}

.gf-form-title-small {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--gf-text);
    line-height: 1.3;
}

.gf-progress-label {
    font-size: .78rem;
    color: var(--gf-text-muted);
    white-space: nowrap;
    margin-left: 8px;
}

.gf-progress-track {
    height: 4px;
    background: var(--gf-border);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 10px;
}

.gf-progress-bar {
    height: 100%;
    background: var(--gf-primary);
    border-radius: 2px;
    transition: width .3s ease;
}

.gf-progress-dots {
    display: flex;
    gap: 6px;
}

.gf-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--gf-border);
    border: 2px solid var(--gf-border);
    transition: background .2s, border-color .2s;
    display: inline-block;
}

.gf-dot.done {
    background: var(--gf-primary);
    border-color: var(--gf-primary);
}

.gf-dot.active {
    background: #fff;
    border-color: var(--gf-primary);
    box-shadow: 0 0 0 2px rgba(0,167,157,.25);
}

/* ─── Multi-step: Section wrapper ──────────────────────────────── */
.gf-form-section {
    display: none;
}

.gf-form-section.active {
    display: block;
}

/* ─── Multi-step: Section header card ──────────────────────────── */
.gf-section-header-card {
    background: var(--gf-card-bg);
    border-radius: var(--gf-radius);
    box-shadow: var(--gf-shadow);
    border: 1px solid var(--gf-border);
    border-top: 4px solid var(--gf-primary);
    padding: 20px 24px;
    margin-bottom: 12px;
}

.gf-section-header-card .gf-section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--gf-text);
    margin: 0 0 .35rem;
}

.gf-section-header-card .gf-section-desc {
    font-size: .875rem;
    color: var(--gf-text-muted);
    margin: 0;
    line-height: 1.65;
    white-space: pre-line;
}

/* ─── Multi-step: Navigation buttons ───────────────────────────── */
.gf-section-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 8px;
    margin-bottom: 4px;
    gap: 8px;
}

.gf-nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 22px;
    border-radius: 4px;
    font-size: .9rem;
    font-weight: 500;
    cursor: pointer;
    border: none;
    transition: var(--gf-transition);
}

.gf-nav-prev {
    background: transparent;
    color: var(--gf-primary);
    border: 1px solid var(--gf-primary);
}

.gf-nav-prev:hover {
    background: var(--gf-primary-light);
}

.gf-nav-next {
    background: var(--gf-primary);
    color: #fff;
    margin-left: auto;
}

.gf-nav-next:hover {
    background: var(--gf-primary-dark);
}

/* privacy note for multi-step */
.gf-privacy-note--multistep {
    text-align: center;
    margin-top: 4px;
    margin-bottom: 8px;
}

/* ─── Multi-step dark mode ──────────────────────────────────────── */
[data-theme="dark"] .gf-progress-wrap,
[data-theme="dark"] .gf-section-header-card {
    background: #1e2028;
    border-color: #374151;
    border-top-color: var(--gf-primary);
}

[data-theme="dark"] .gf-form-title-small,
[data-theme="dark"] .gf-section-header-card .gf-section-title {
    color: #f3f4f6;
}

[data-theme="dark"] .gf-progress-track {
    background: #374151;
}

[data-theme="dark"] .gf-dot {
    background: #374151;
    border-color: #374151;
}

[data-theme="dark"] .gf-dot.active {
    background: #1e2028;
    border-color: var(--gf-primary);
}

[data-theme="dark"] .gf-nav-prev {
    color: var(--gf-primary);
    border-color: var(--gf-primary);
}

[data-theme="dark"] .gf-nav-prev:hover {
    background: rgba(0,167,157,.1);
}
</style>
@endverbatim
