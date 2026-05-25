<style>
/* ===== BUILDER LAYOUT ===== */
.builder-wrap {
    display: grid;
    grid-template-columns: 260px 1fr 280px;
    gap: 1.25rem;
    align-items: start;
}
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
    height: 110px;
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
</style>
