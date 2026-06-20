<style>
/* ===== BUILDER LAYOUT ===== */
.builder-wrap {
    display: grid;
    grid-template-columns: 260px 1fr 280px;
    gap: 1.25rem;
    align-items: start;
}
.builder-wrap > div { min-width: 0; }
@media (max-width: 1199px) {
    .builder-wrap { grid-template-columns: 1fr; }
    .builder-sidebar-right { order: -1; }
}

/* ===== FIELD TYPE PALETTE ===== */
.field-type-group { margin-bottom: .85rem; }
.field-type-group-label {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #9ca3af;
    padding: 0 .35rem .4rem;
    border-bottom: 1px solid #e0f7f5;
    margin-bottom: .4rem;
}
.field-type-btn {
    display: flex;
    align-items: center;
    gap: .6rem;
    width: 100%;
    padding: .5rem .75rem;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: .82rem;
    color: #374151;
    cursor: pointer;
    transition: all .15s;
    margin-bottom: .3rem;
    text-align: left;
}
.field-type-btn:hover {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #166534;
}
.field-type-btn i { width: 18px; text-align: center; color: #6b7280; }
.field-type-btn:hover i { color: #166534; }

/* ===== DROP ZONE ===== */
.drop-zone { min-height: 300px; padding: .5rem; }
.drop-zone-empty {
    border: 2px dashed #bbf7d0;
    border-radius: 10px;
    padding: 3rem 2rem;
    text-align: center;
    color: #9ca3af;
    background: #f0fdf4;
}

/* ===== FIELD CARDS ===== */
.field-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: .85rem 1rem;
    margin-bottom: .5rem;
    display: flex;
    align-items: flex-start;
    gap: .75rem;
    transition: all .15s;
    cursor: default;
}
.field-card:hover { border-color: #bbf7d0; box-shadow: 0 2px 8px rgba(0, 167, 157, 0.08); }
.field-card.is-system { background: #fffbeb; border-color: #fde68a; }
.drag-handle {
    color: #d1d5db;
    cursor: grab;
    padding-top: .2rem;
    font-size: 1rem;
}
.drag-handle:active { cursor: grabbing; }
.field-card-body { flex: 1; min-width: 0; }
.field-card-label { font-weight: 600; font-size: .875rem; color: #111827; margin-bottom: .15rem; }
.field-card-type { font-size: .75rem; color: #9ca3af; }
.field-card-required { color: #ef4444; margin-left: .25rem; }
.field-card-system-badge {
    font-size: .65rem; background: #fef3c7; color: #92400e;
    border: 1px solid #fde68a; border-radius: 4px; padding: 1px 6px;
    vertical-align: middle; margin-left: .35rem;
}

.field-card-routing-badge {
    font-size: .62rem; background: #ede9fe; color: #6d28d9;
    border: 1px solid #c4b5fd; border-radius: 4px; padding: 1px 6px;
    vertical-align: middle; margin-left: .35rem; white-space: nowrap;
}
.field-card-actions { display: flex; gap: .3rem; }
.field-card-actions button {
    border: none; background: none; cursor: pointer;
    color: #9ca3af; font-size: .85rem; padding: .2rem .35rem;
    border-radius: 4px; transition: all .15s;
}
.field-card-actions button:hover { color: #00a79d; background: #f0fdf4; }
.field-card-actions button.btn-del:hover { color: #ef4444; background: #fee2e2; }

/* ===== BUILDER CARD HEADER (breadcrumb separator) ===== */
.builder-card-header {
    padding-bottom: 1rem;
    border-bottom: 2px solid #e0f7f5;
}

/* ===== PREVIEW FORM BUTTON ===== */
.btn-preview-form {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .45rem 1.1rem;
    background: linear-gradient(135deg, #0ea5e9 0%, #00a79d 100%);
    color: #fff !important; border: none; border-radius: 8px;
    font-size: .82rem; font-weight: 600;
    text-decoration: none !important;
    transition: all .2s;
    box-shadow: 0 2px 10px rgba(0,167,157,.28);
    letter-spacing: .01em;
}
.btn-preview-form:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 18px rgba(0,167,157,.42);
    background: linear-gradient(135deg, #0891b2 0%, #00958c 100%);
    color: #fff !important;
}
.btn-preview-form:active { transform: translateY(0); box-shadow: none; }
.btn-preview-ext { font-size: .6rem; opacity: .7; }

/* ===== BUILDER BOTTOM BAR ===== */
.builder-bottom-bar {
    padding: 1rem 0 .5rem;
    border-top: 2px solid #e0f7f5;
    margin-top: .75rem;
}

/* ===== BUILDER MODAL ===== */
.bm-card { border: none; border-radius: 14px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.15); }
.bm-header {
    display: flex; align-items: center; gap: .9rem;
    padding: 1.1rem 1.3rem; border-bottom: none;
}
.bm-header--add { background: linear-gradient(135deg, #00a79d 0%, #00756e 100%); }
.bm-header--edit { background: linear-gradient(135deg, #00a79d 0%, #00756e 100%); }
.bm-header-icon {
    width: 44px; height: 44px; flex-shrink: 0; border-radius: 11px;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; color: #fff;
}
.bm-header-text { flex: 1; }
.bm-header-title { font-size: .95rem; font-weight: 700; color: #fff; line-height: 1.2; }
.bm-header-sub { font-size: .78rem; color: rgba(255,255,255,.8); margin-top: .1rem; font-weight: 500; }
.bm-btn-close { filter: invert(1); opacity: .8; flex-shrink: 0; }
.bm-btn-close:hover { opacity: 1; }
.bm-body { padding: 1.4rem 1.5rem; background: #f8fafc; }
.bm-footer {
    display: flex; align-items: center; justify-content: flex-end; gap: .6rem;
    padding: .9rem 1.3rem; background: #fff;
    border-top: 2px solid #e0f7f5;
}
.bm-required-toggle {
    display: flex; align-items: center; gap: .5rem;
    padding: .65rem .85rem;
    background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;
}
.bm-required-toggle .form-check-input { margin: 0; flex-shrink: 0; }
.bm-required-toggle label { font-size: .85rem; font-weight: 500; color: #166534; margin: 0; cursor: pointer; line-height: 1; }
.bm-btn-submit {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1.15rem; border: none; border-radius: 8px;
    font-size: .85rem; font-weight: 600; cursor: pointer;
    transition: all .15s;
}
.bm-btn-submit--add { background: #00a79d; color: #fff; box-shadow: 0 2px 8px rgba(0,167,157,.3); }
.bm-btn-submit--add:hover { background: #00958c; box-shadow: 0 4px 12px rgba(0,167,157,.4); }
.bm-btn-submit--edit { background: #00a79d; color: #fff; box-shadow: 0 2px 8px rgba(0,167,157,.3); }
.bm-btn-submit--edit:hover { background: #00958c; box-shadow: 0 4px 12px rgba(0,167,157,.4); }
.field-modal-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; margin-bottom: .3rem; display: block; }
.options-list .option-row { display: flex; gap: .5rem; margin-bottom: .4rem; align-items: center; }
.options-list .option-row input { flex: 1; }

/* ===== FILE TYPE PICKER ===== */
.file-type-picker { display: flex; flex-direction: column; gap: .5rem; }
.file-type-picker-group { display: flex; flex-wrap: wrap; align-items: center; gap: .3rem; }
.file-type-picker-cat {
    font-size: .68rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .05em; color: #9ca3af; min-width: 68px;
}
.file-type-pill {
    display: inline-flex; align-items: center;
    padding: .18rem .5rem; background: #f3f4f6; border: 1px solid #d1d5db;
    border-radius: 20px; font-size: .72rem; cursor: pointer;
    transition: all .15s; user-select: none; color: #374151;
}
.file-type-pill:hover { border-color: #00a79d; color: #00a79d; }
.file-type-pill:has(input:checked) { background: #00a79d; border-color: #00a79d; color: #fff; }
.file-type-pill input[type="checkbox"] { display: none; }
html.dark-mode .file-type-picker-cat { color: #6b7280; }
html.dark-mode .file-type-pill { background: #2d3139; border-color: #374151; color: #c8cdd3; }
html.dark-mode .file-type-pill:hover { border-color: #2dd4bf; color: #2dd4bf; }
html.dark-mode .file-type-pill:has(input:checked) { background: #00a79d; border-color: #00a79d; color: #fff; }

/* ===== DELETING STATE ===== */
.field-card--deleting {
    opacity: .45;
    pointer-events: none;
    border-color: #ef4444 !important;
    transition: opacity .2s;
}

/* ===== SAVING STATE ===== */
.field-card--saving {
    opacity: .45;
    pointer-events: none;
    border-color: #00a79d !important;
    transition: opacity .2s;
}

/* ===== SORTABLE GHOST ===== */
.sortable-ghost { opacity: .4; background: #f0fdf4 !important; border: 2px dashed #86efac !important; }
.sortable-chosen { box-shadow: 0 4px 16px rgba(0,0,0,.1); }

/* ===== ACTIVE FIELDS HEADER ===== */
.builder-fields-header {
    padding-bottom: .85rem;
    border-bottom: 2px solid #e0f7f5;
    margin-bottom: .75rem;
}
html.dark-mode .builder-fields-header { border-bottom-color: #2d3139; }

/* ===== ADD HEADER IMAGE BUTTON ===== */
.btn-add-header-image {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem;
    background: transparent;
    border: 1.5px dashed #6366f1;
    border-radius: 7px;
    font-size: .78rem; font-weight: 600;
    color: #6366f1;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.btn-add-header-image:hover {
    background: #eef2ff;
    border-style: solid;
    box-shadow: 0 2px 8px rgba(99,102,241,.15);
}

/* ===== ADD SECTION BUTTON ===== */
.btn-add-section {
    display: inline-flex; align-items: center; gap: .35rem;
    padding: .3rem .75rem;
    background: transparent;
    border: 1.5px dashed #00a79d;
    border-radius: 7px;
    font-size: .78rem; font-weight: 600;
    color: #00a79d;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.btn-add-section:hover {
    background: #f0fdf4;
    border-style: solid;
    box-shadow: 0 2px 8px rgba(0,167,157,.15);
}

/* ===== HEADER IMAGE CARD ===== */
.field-card--header-image {
    background: #f8f7ff;
    border: 1.5px solid #c7d2fe;
    border-radius: 10px;
    padding: 0;
    flex-direction: column;
    align-items: stretch;
    gap: 0;
    overflow: hidden;
    cursor: default;
}
.field-card--header-image:hover { border-color: #6366f1; box-shadow: 0 2px 10px rgba(99,102,241,.12); }
.header-img-card-inner {
    position: relative;
    width: 100%;
}
.header-img-thumb {
    width: 100%;
    height: auto;
    aspect-ratio: 4 / 1;
    object-fit: cover;
    display: block;
}
.header-img-placeholder {
    width: 100%;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e0e7ff;
    color: #6366f1;
    font-size: .82rem;
    font-weight: 600;
}
.header-img-badge {
    position: absolute;
    bottom: 0; left: 0;
    background: rgba(0,0,0,.52);
    color: #fff;
    font-size: .7rem;
    font-weight: 600;
    padding: .2rem .55rem;
    border-radius: 0 6px 0 0;
    backdrop-filter: blur(2px);
    letter-spacing: .02em;
}
.field-card--header-image .field-card-actions {
    padding: .4rem .75rem;
    justify-content: flex-end;
    border-top: 1px solid #e0e7ff;
}

/* ===== SECTION BREAK CARD ===== */
.field-card--section-break {
    background: linear-gradient(135deg, #f0fdf9 0%, #f0f9ff 100%);
    border: 1.5px solid #a7f3e8;
    border-radius: 10px;
    padding: .6rem 1rem;
    align-items: center;
    gap: .75rem;
}
.field-card--section-break:hover {
    border-color: #00a79d;
    box-shadow: 0 2px 10px rgba(0,167,157,.12);
}
.section-break-body {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex: 1;
    min-width: 0;
}
.section-break-rule {
    flex: 1;
    height: 1.5px;
    background: linear-gradient(90deg, transparent, #a7f3e8, transparent);
    border-radius: 2px;
}
.section-break-label {
    font-size: .8rem;
    font-weight: 700;
    color: #00756e;
    letter-spacing: .03em;
    white-space: nowrap;
    text-transform: uppercase;
    flex-shrink: 0;
}
.section-break-label i { color: #00a79d; }

/* ===== DARK MODE ===== */
/* card base — neutral dark, teal accent on section-title border only */
html.dark-mode .card { background: #1a1d23; border-color: #2d3139 !important; }
html.dark-mode .section-title { border-bottom-color: #2d4a30; }
html.dark-mode .builder-card-header { border-bottom-color: #2d3139; }
html.dark-mode .builder-bottom-bar { border-top-color: #2d3139; }
/* field type buttons — neutral default, green only on hover */
html.dark-mode .field-type-btn { background: #22252d; border-color: #2d3139; color: #c8cdd3; }
html.dark-mode .field-type-btn:hover { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .field-type-btn:hover i { color: #86efac; }
html.dark-mode .field-type-group-label { color: #6b7280; border-bottom-color: #2d3139; }
/* field cards — neutral dark default */
html.dark-mode .field-card { background: #22252d; border-color: #2d3139; }
html.dark-mode .field-card:hover { border-color: #2d4a30; box-shadow: 0 2px 8px rgba(0,0,0,.2); }
html.dark-mode .field-card.is-system { background: #2d2510; border-color: #4a3a1a; }
html.dark-mode .field-card-system-badge { background: rgba(251,191,36,.15); color: #fbbf24; border-color: rgba(251,191,36,.3); }
html.dark-mode .field-card-label { color: #e4e6eb; }
html.dark-mode .field-card-type { color: #6b7280; }
html.dark-mode .field-card-actions button { color: #6b7280; }
html.dark-mode .field-card-actions button:hover { color: #86efac; background: #1f3524; }
html.dark-mode .field-card-actions button.btn-del:hover { color: #f87171; background: rgba(239,68,68,.15); }
html.dark-mode .drop-zone-empty { background: #22252d; border-color: #374151; color: #6b7280; }
html.dark-mode .btn-add-header-image { color: #a5b4fc; border-color: #a5b4fc; }
html.dark-mode .btn-add-header-image:hover { background: #1e1e3a; border-color: #a5b4fc; }
html.dark-mode .field-card--header-image { background: #1e1e2e; border-color: #3730a3; }
html.dark-mode .field-card--header-image:hover { border-color: #a5b4fc; }
html.dark-mode .header-img-placeholder { background: #2d2d5e; color: #a5b4fc; }
html.dark-mode .field-card--header-image .field-card-actions { border-top-color: #3730a3; }
html.dark-mode .btn-add-section { color: #2dd4bf; border-color: #2dd4bf; }
html.dark-mode .btn-add-section:hover { background: #1a2d1e; border-color: #2dd4bf; }
html.dark-mode .field-card--section-break { background: linear-gradient(135deg, #1a2d2a 0%, #1a2430 100%); border-color: #1e4a44; }
html.dark-mode .field-card--section-break:hover { border-color: #2dd4bf; box-shadow: 0 2px 10px rgba(45,212,191,.12); }
html.dark-mode .section-break-rule { background: linear-gradient(90deg, transparent, #1e4a44, transparent); }
html.dark-mode .section-break-label { color: #2dd4bf; }
html.dark-mode .section-break-label i { color: #2dd4bf; }
/* modals */
html.dark-mode .bm-card { background: #1a1d23; }
html.dark-mode .bm-body { background: #22252d; }
html.dark-mode .bm-footer { background: #1a1d23; border-top-color: #2d3139; }
html.dark-mode .bm-required-toggle { background: #1a2d1e; border-color: #2d4a30; }
html.dark-mode .bm-required-toggle label { color: #86efac; }
html.dark-mode .bm-card .form-control { background: #2d3139; color: #e4e6eb; border-color: #374151; }
html.dark-mode .bm-card .form-control::placeholder { color: #6b7280; }
html.dark-mode .field-modal-label { color: #9ca3af; }
/* modal outline buttons */
html.dark-mode .bm-body .btn-outline-secondary,
html.dark-mode .bm-footer .btn-outline-secondary {
    color: #c8cdd3; border-color: #374151; background: transparent;
}
html.dark-mode .bm-body .btn-outline-secondary:hover,
html.dark-mode .bm-footer .btn-outline-secondary:hover {
    color: #e4e6eb; border-color: #6b7280; background: #2d3139;
}
html.dark-mode .bm-body .btn-outline-danger {
    color: #f87171; border-color: #4b1c1c; background: transparent;
}
html.dark-mode .bm-body .btn-outline-danger:hover {
    color: #fff; border-color: #ef4444; background: #7f1d1d;
}

/* ===== MODAL LIVE PREVIEW PANEL ===== */
.bmp-config-col {
    flex: 1; min-width: 0;
    padding: 1.4rem 1.5rem;
    background: #f8fafc;
    overflow-y: auto;
    max-height: calc(90vh - 140px);
}

.bmp-preview-col {
    width: 272px; flex-shrink: 0;
    border-left: 1px solid #e0f7f5;
    padding: 1rem 1.1rem;
    background: #f8fafc;
    overflow-y: auto;
    max-height: calc(90vh - 140px);
    display: flex; flex-direction: column; gap: 8px;
}

.bmp-preview-header {
    font-size: .65rem; font-weight: 700; color: #9ca3af;
    text-transform: uppercase; letter-spacing: .07em;
    display: flex; align-items: center; gap: 4px;
    padding-bottom: 6px; border-bottom: 1px solid #e5e7eb;
    justify-content: space-between;
}

.bmp-preview-header-left { display: flex; align-items: center; gap: 4px; }

.bmp-preview-tabs { display: flex; gap: 3px; flex-shrink: 0; }

.bmp-preview-tab {
    width: 24px; height: 20px;
    border: 1px solid #e5e7eb; border-radius: 4px;
    background: #fff; color: #9ca3af;
    font-size: .72rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: all .15s; text-transform: none; letter-spacing: 0;
    font-weight: 400; padding: 0;
}

.bmp-preview-tab:hover { color: #00a79d; border-color: #00a79d; }
.bmp-preview-tab.active { background: #00a79d; border-color: #00a79d; color: #fff; }

/* Phone frame */
.bmp-phone-frame {
    width: 158px;
    margin: 4px auto 0;
    background: #1a1d23;
    border-radius: 22px;
    border: 3px solid #374151;
    padding: 10px 6px 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,.2);
}

.bmp-phone-notch {
    width: 44px; height: 7px;
    background: #374151; border-radius: 4px;
    margin: 0 auto 8px;
}

.bmp-phone-screen {
    background: #fff;
    border-radius: 10px;
    padding: 10px 8px;
    min-height: 100px;
    overflow: hidden;
}

.bmp-phone-home {
    width: 36px; height: 4px;
    background: #374151; border-radius: 2px;
    margin: 9px auto 0;
}

.bmp-preview-field--phone {
    border: none !important; box-shadow: none !important;
    padding: 0 !important; background: transparent !important;
}

.bmp-preview-field--phone .bmp-field-label { font-size: .75rem; }
.bmp-preview-field--phone .bmp-field-help  { font-size: .68rem; }
.bmp-preview-field--phone .bmp-field-input,
.bmp-preview-field--phone .bmp-field-textarea { font-size: .72rem; }
.bmp-preview-field--phone .bmp-opt-row span { font-size: .72rem; }
.bmp-preview-field--phone .bmp-checkbox,
.bmp-preview-field--phone .bmp-radio { width: 13px; height: 13px; }
.bmp-preview-field--phone .bmp-checkbox--on::after {
    left: 2px; top: 0px; width: 4px; height: 7px;
}
.bmp-preview-field--phone .bmp-field-trigger { font-size: .7rem; padding: 5px 8px; }
.bmp-preview-field--phone .bmp-para { font-size: .78rem; }
.bmp-preview-field--phone .bmp-dd-opt { font-size: .7rem; }
.bmp-preview-field--phone .bmp-star { font-size: .9rem; }

.bmp-preview-field {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 14px 13px;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}

/* Legend bar */
.bmp-legend {
    display: flex; flex-wrap: wrap; gap: 5px;
    padding: 7px 10px; background: #fff;
    border: 1px solid #e5e7eb; border-radius: 8px;
    margin-top: 2px;
}

.bmp-legend-item {
    display: flex; align-items: center; gap: 4px;
    font-size: .62rem; color: #6b7280;
}

.bmp-legend-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
}

/* ─── Field element rows ─────────────────────────────── */
.bmp-row {
    display: flex; align-items: flex-start;
    gap: 6px; margin-bottom: 8px;
}

.bmp-row:last-child { margin-bottom: 0; }

/* Annotation badge */
.bmp-ann {
    font-size: .58rem; font-weight: 700; color: #fff;
    padding: 2px 5px; border-radius: 4px;
    white-space: nowrap; flex-shrink: 0; margin-top: 2px;
    letter-spacing: .02em; line-height: 1.4;
}

.bmp-ann-spc { width: 46px; flex-shrink: 0; }

/* Label */
.bmp-field-label {
    font-size: .875rem; font-weight: 500; color: #202124;
    line-height: 1.45; flex: 1;
}

.bmp-req { color: #d93025; margin-left: 2px; }

/* Help text */
.bmp-field-help {
    font-size: .73rem; color: #5f6368; line-height: 1.5; flex: 1;
}

/* Underline input */
.bmp-field-input {
    border-bottom: 1.5px solid #9aa0a6; padding: 4px 0;
    font-size: .83rem; color: #b0b7bf; flex: 1; line-height: 1.4;
}

.bmp-field-textarea {
    border-bottom: 1.5px solid #9aa0a6; padding: 4px 0;
    font-size: .83rem; color: #b0b7bf; flex: 1; min-height: 44px; line-height: 1.55;
}

/* Box trigger (date/time) */
.bmp-field-trigger {
    display: flex; align-items: center; gap: 8px;
    border: 1px solid #e0e0e0; border-radius: 7px;
    padding: 8px 10px; font-size: .83rem; color: #9aa0a6;
    background: #fff; margin-top: 2px;
}

.bmp-field-trigger.bmp-dd-trigger { justify-content: space-between; }
.bmp-field-trigger i, .bmp-field-trigger .fa-chevron-down { font-size: .7rem; }

/* Dropdown list */
.bmp-dd-list {
    border: 1px solid #e5e7eb; border-radius: 8px;
    margin-top: 5px; overflow: hidden;
    box-shadow: 0 4px 14px rgba(0,0,0,.08);
}

.bmp-dd-opt {
    display: flex; align-items: center; gap: 7px;
    padding: 7px 10px; font-size: .82rem; color: #374151;
    border-bottom: 1px solid #f3f4f6;
}

.bmp-dd-opt:last-child { border-bottom: none; }
.bmp-dd-opt--sel { color: #00a79d; font-weight: 600; background: rgba(0,167,157,.06); }
.bmp-dd-opt--ph { color: #9aa0a6; font-style: italic; }
.bmp-dd-opt--empty { color: #9aa0a6; font-style: italic; }
.bmp-dd-check { font-size: .62rem; color: #00a79d; width: 12px; flex-shrink: 0; }
.bmp-dd-spc { width: 12px; flex-shrink: 0; display: inline-block; }
.bmp-dd-more { padding: 5px 10px; font-size: .7rem; color: #9aa0a6; background: #fafafa; }

/* Radio / Checkbox options */
.bmp-opt-row {
    display: flex; align-items: center; gap: 10px;
    padding: 6px 8px; border-radius: 7px; margin-bottom: 2px;
}

.bmp-opt-row--sel { background: rgba(0,167,157,.06); }
.bmp-opt-row span { font-size: .83rem; color: #374151; flex: 1; }

.bmp-radio {
    width: 16px; height: 16px; border-radius: 50%;
    border: 2px solid #c0c7cf; flex-shrink: 0; background: #fff;
}

.bmp-radio--on {
    border-color: #00a79d; background: #00a79d;
    box-shadow: inset 0 0 0 3px #fff;
}

.bmp-checkbox {
    width: 16px; height: 16px; border-radius: 4px;
    border: 2px solid #c0c7cf; flex-shrink: 0; background: #fff;
    position: relative;
}

.bmp-checkbox--on { border-color: #00a79d; background: #00a79d; }
.bmp-checkbox--on::after {
    content: '';
    position: absolute;
    left: 3px; top: 0px;
    width: 5px; height: 9px;
    border: 2px solid #fff;
    border-top: none; border-left: none;
    transform: rotate(45deg);
}

/* Linear scale */
.bmp-scale-row {
    display: flex; align-items: center; gap: 5px;
    padding: 5px 0; flex-wrap: wrap; margin-top: 2px;
}

.bmp-scale-item { display: flex; flex-direction: column; align-items: center; gap: 4px; }
.bmp-scale-n { font-size: .63rem; color: #9aa0a6; }
.bmp-scale-dot {
    width: 16px; height: 16px; border-radius: 50%;
    border: 2px solid #c0c7cf; background: #fff;
}
.bmp-scale-dot--on { border-color: #00a79d; background: #00a79d; }
.bmp-scale-edge { font-size: .67rem; color: #5f6368; white-space: nowrap; flex-shrink: 0; }

/* Stars */
.bmp-stars { display: flex; gap: 3px; padding: 4px 0; flex-wrap: wrap; }
.bmp-star { font-size: 1.1rem; color: #f59e0b; }

/* Upload zone */
.bmp-upload {
    border: 2px dashed #e0e0e0; border-radius: 9px;
    padding: 14px 10px; text-align: center;
    background: #fafafa; margin-top: 4px;
}

.bmp-upload-icon { font-size: 1.3rem; color: #00a79d; display: block; margin-bottom: 5px; }
.bmp-upload-text { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: 2px; }
.bmp-upload-hint { font-size: .7rem; color: #9aa0a6; }

/* Paragraph / section */
.bmp-para { font-size: .85rem; color: #374151; line-height: 1.65; margin-top: 5px; }
.bmp-img-mock {
    background: #e5e7eb; border-radius: 7px; height: 68px;
    display: flex; align-items: center; justify-content: center;
    color: #9aa0a6; gap: 7px; font-size: .8rem;
}
.bmp-img-caption { font-size: .75rem; color: #9aa0a6; margin-top: 5px; }
.bmp-section { border-left: 4px solid #6366f1; padding: 10px 12px; background: rgba(99,102,241,.05); border-radius: 4px; }
.bmp-section-title { font-size: .9rem; font-weight: 700; color: #374151; margin-bottom: 4px; }
.bmp-section-desc { font-size: .8rem; color: #6b7280; }
.bmp-empty { font-size: .76rem; color: #9ca3af; font-style: italic; padding: 3px 0; }

/* Mini calendar preview */
.bmp-cal {
    border: 1px solid #e5e7eb; border-radius: 9px;
    overflow: hidden; margin-top: 6px;
    font-size: .72rem;
}

.bmp-cal-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 6px 9px; border-bottom: 1px solid #f3f4f6;
    background: #fafafa;
}

.bmp-cal-month { font-size: .75rem; font-weight: 700; color: #374151; }

.bmp-cal-nav {
    width: 18px; height: 18px; border-radius: 4px;
    display: flex; align-items: center; justify-content: center;
    color: #9aa0a6; cursor: default; font-size: .55rem;
}

.bmp-cal-wd {
    display: grid; grid-template-columns: repeat(7, 1fr);
    padding: 4px 6px 2px; gap: 1px;
}

.bmp-cal-wd span {
    text-align: center; font-size: .6rem; font-weight: 700;
    color: #9aa0a6; padding: 2px 0;
}

.bmp-cal-grid {
    display: grid; grid-template-columns: repeat(7, 1fr);
    padding: 2px 6px 6px; gap: 1px;
}

.bmp-cal-cell {
    text-align: center; padding: 3px 1px;
    font-size: .68rem; border-radius: 4px;
    color: #374151; line-height: 1.4;
}

.bmp-cal-cell.other { color: #d1d5db; }
.bmp-cal-cell.today { border: 1.5px solid #00a79d; color: #00a79d; font-weight: 700; }
.bmp-cal-cell.sel   { background: #00a79d; color: #fff; font-weight: 700; border-radius: 4px; }

/* Mini time preview */
.bmp-tp {
    display: flex; align-items: stretch; gap: 0;
    border: 1px solid #e5e7eb; border-radius: 9px;
    overflow: hidden; margin-top: 6px;
}

.bmp-tp-col-wrap { flex: 1; display: flex; flex-direction: column; min-width: 0; }

.bmp-tp-lbl {
    text-align: center; font-size: .6rem; font-weight: 700;
    color: #9aa0a6; text-transform: uppercase; padding: 4px 0;
    background: #fafafa; border-bottom: 1px solid #f3f4f6;
}

.bmp-tp-col { display: flex; flex-direction: column; align-items: center; padding: 4px 0; gap: 0; }

.bmp-tp-item {
    font-size: .7rem; color: #9aa0a6; padding: 3px 8px;
    border-radius: 5px; line-height: 1.3; width: 100%; text-align: center;
}

.bmp-tp-item.sel { background: #00a79d; color: #fff; font-weight: 700; }
.bmp-tp-item.near { color: #374151; }

.bmp-tp-sep {
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem; font-weight: 700; color: #9aa0a6;
    padding: 0 3px; padding-top: 22px; flex-shrink: 0;
}

/* Dark mode mini pickers */
html.dark-mode .bmp-cal { border-color: #2d3139; }
html.dark-mode .bmp-cal-head { background: #22252d; border-bottom-color: #2d3139; }
html.dark-mode .bmp-cal-month { color: #e4e6eb; }
html.dark-mode .bmp-cal-cell { color: #c8cdd3; }
html.dark-mode .bmp-cal-cell.other { color: #4b5563; }
html.dark-mode .bmp-tp { border-color: #2d3139; }
html.dark-mode .bmp-tp-lbl { background: #22252d; border-bottom-color: #2d3139; }
html.dark-mode .bmp-tp-item.near { color: #c8cdd3; }

/* ─── Section Routing Panel ────────────────────────────── */
.sr-panel {
    border: 1px solid #e0f7f5; border-radius: 8px;
    overflow: hidden;
}

.sr-panel-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 9px 12px;
    background: linear-gradient(135deg, #f0fdfb 0%, #f8fafc 100%);
    border-bottom: 1px solid transparent;
    cursor: default;
}

.sr-panel-title {
    font-size: .78rem; font-weight: 700; color: #00857c;
    display: flex; align-items: center; gap: 5px;
}

/* Custom toggle switch */
.sr-toggle-label { display: flex; align-items: center; cursor: pointer; margin: 0; }
.sr-toggle-label input { display: none; }
.sr-toggle-track {
    width: 32px; height: 18px; border-radius: 9px;
    background: #d1d5db; position: relative; transition: background .2s;
    display: flex; align-items: center;
}
.sr-toggle-label input:checked ~ .sr-toggle-track { background: #00a79d; }
.sr-toggle-thumb {
    width: 12px; height: 12px; border-radius: 50%; background: #fff;
    position: absolute; left: 3px; transition: left .2s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.sr-toggle-label input:checked ~ .sr-toggle-track .sr-toggle-thumb { left: 17px; }

.sr-panel-header:has(input:checked) { border-bottom-color: #e0f7f5; }

#editRoutingBody { padding: 10px 12px; background: #fafcfb; }

.sr-hint {
    font-size: .72rem; color: #6b7280; margin-bottom: 10px; line-height: 1.4;
}

.sr-no-sections {
    font-size: .75rem; color: #9ca3af; text-align: center; padding: 8px 0;
    font-style: italic;
}

.sr-row {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 7px; flex-wrap: wrap;
}
.sr-row:last-child { margin-bottom: 0; }

.sr-row-label {
    font-size: .75rem; color: #374151; font-weight: 600;
    min-width: 80px; max-width: 120px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis; flex-shrink: 0;
}

.sr-arrow { color: #9ca3af; font-size: .7rem; flex-shrink: 0; }

.sr-route-select { flex: 1; font-size: .75rem; min-width: 120px; }

html.dark-mode .sr-panel { border-color: #2d3139; }
html.dark-mode .sr-panel-header { background: #1a2d2a; }
html.dark-mode .sr-panel-title { color: #2dd4bf; }
html.dark-mode .sr-toggle-track { background: #374151; }
html.dark-mode #editRoutingBody { background: #1e2229; }
html.dark-mode .sr-hint { color: #9ca3af; }
html.dark-mode .sr-row-label { color: #c8cdd3; }
html.dark-mode .sr-route-select { background: #22252d; border-color: #374151; color: #c8cdd3; }

/* Responsive */
@media (max-width: 767px) {
    /* Stack config + preview vertically */
    .bm-body > .d-flex { flex-direction: column !important; }
    .bm-body { overflow-y: auto !important; }

    .bmp-config-col {
        max-height: none;
        overflow-y: visible;
    }

    .bmp-preview-col {
        width: 100%;
        border-left: none;
        border-top: 1px solid #e0f7f5;
        max-height: none;
        overflow-y: visible;
        padding: .85rem 1rem;
    }
}

/* Dark mode */
html.dark-mode .bmp-config-col { background: #22252d; }
html.dark-mode .bmp-preview-col { background: #1a1d23; border-left-color: #2d3139; border-top-color: #2d3139; }
html.dark-mode .bmp-preview-header { border-bottom-color: #2d3139; }
html.dark-mode .bmp-preview-field { background: #22252d; border-color: #2d3139; }
html.dark-mode .bmp-preview-tab { background: #22252d; border-color: #2d3139; color: #6b7280; }
html.dark-mode .bmp-preview-tab:hover { color: #00a79d; border-color: #00a79d; }
html.dark-mode .bmp-preview-tab.active { background: #00a79d; border-color: #00a79d; color: #fff; }
html.dark-mode .bmp-phone-screen { background: #22252d; }
html.dark-mode .bmp-preview-field--phone { background: transparent !important; }
html.dark-mode .bmp-legend { background: #22252d; border-color: #2d3139; }
html.dark-mode .bmp-legend-item { color: #9ca3af; }
html.dark-mode .bmp-field-label { color: #e4e6eb; }
html.dark-mode .bmp-field-help { color: #9ca3af; }
html.dark-mode .bmp-field-input,
html.dark-mode .bmp-field-textarea { color: #6b7280; border-bottom-color: #4b5563; }
html.dark-mode .bmp-field-trigger { background: #22252d; border-color: #374151; color: #6b7280; }
html.dark-mode .bmp-dd-list { border-color: #2d3139; }
html.dark-mode .bmp-dd-opt { color: #c8cdd3; border-bottom-color: #2d3139; }
html.dark-mode .bmp-dd-opt--sel { color: #2dd4bf; background: rgba(0,167,157,.08); }
html.dark-mode .bmp-dd-more { background: #1a1d23; }
html.dark-mode .bmp-opt-row span { color: #c8cdd3; }
html.dark-mode .bmp-upload { background: #22252d; border-color: #374151; }
html.dark-mode .bmp-upload-text { color: #e4e6eb; }
html.dark-mode .bmp-img-mock { background: #2d3139; }
html.dark-mode .bmp-section { background: rgba(99,102,241,.08); }
html.dark-mode .bmp-section-title { color: #e4e6eb; }
html.dark-mode .bmp-section-desc { color: #9ca3af; }
html.dark-mode .bmp-para { color: #c8cdd3; }


</style>
