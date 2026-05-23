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

/* ===== PAGE TITLE ===== */
.page-title {
    font-size: 1.65rem;
    font-weight: 600;
    text-align: center;
    color: #00a79d;
    margin: .75rem 0 1.5rem;
    position: relative;
    display: inline-block;
}
.page-title .highlighted-text { color: #008b84; font-weight: 700; }
.page-title small { font-size: .75rem; color: #6c757d; font-weight: 400; }
.page-title::after {
    content: '';
    display: block;
    height: 4px;
    width: 120px;
    margin: .35rem auto 0;
    border-radius: 3px;
    background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
}

/* ===== PANEL CARD ===== */
.panel-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    overflow: hidden;
}
.panel-header {
    padding: .85rem 1.1rem;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 700;
    font-size: .85rem;
    color: #374151;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.panel-body { padding: .85rem; }

/* ===== FIELD TYPE PALETTE ===== */
.field-type-group { margin-bottom: .85rem; }
.field-type-group-label {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #9ca3af;
    padding: 0 .35rem .4rem;
    border-bottom: 1px solid #f3f4f6;
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
    border-color: #86efac;
    color: #166534;
}
.field-type-btn i { width: 18px; text-align: center; color: #6b7280; }
.field-type-btn:hover i { color: #166534; }

/* ===== DROP ZONE ===== */
.drop-zone { min-height: 300px; padding: .5rem; }
.drop-zone-empty {
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    padding: 3rem 2rem;
    text-align: center;
    color: #9ca3af;
    background: #fafafa;
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
.field-card:hover { border-color: #86efac; box-shadow: 0 2px 8px rgba(22,101,52,.08); }
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
.field-card-actions button:hover { color: #374151; background: #f3f4f6; }
.field-card-actions button.btn-del:hover { color: #ef4444; background: #fee2e2; }

/* ===== GDrive rows ===== */
.gdrive-link-row {
    display: flex; align-items: center; gap: .65rem;
    padding: .75rem 1rem; text-decoration: none;
    font-size: .82rem; font-weight: 600;
    color: #374151; transition: background .15s;
    border-bottom: 1px solid #f3f4f6;
}
.gdrive-link-row:last-child { border-bottom: none; }
.gdrive-link-row:hover { background: #f9fafb; color: #374151; text-decoration: none; }
.gdrive-link-row i:first-child { font-size: 1rem; flex-shrink: 0; width: 20px; text-align: center; }
.gdrive-link-row .glr-text { flex: 1; }
.gdrive-link-row .glr-text strong { display: block; font-size: .82rem; }
.gdrive-link-row .glr-text small { font-size: .72rem; color: #6b7280; font-weight: 400; }
.glr-ext { font-size: .65rem; opacity: .45; }
.gdrive-link-row-disabled { opacity: .55; pointer-events: none; cursor: default; }
.gdrive-link-row-disabled .glr-ext { color: #6b7280; opacity: .6; }

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
    border-top: 1px solid #e5e7eb;
    margin-top: .75rem;
}

/* ===== BUILDER MODAL ===== */
.bm-card { border: none; border-radius: 14px; overflow: hidden; box-shadow: 0 8px 40px rgba(0,0,0,.15); }
.bm-header {
    display: flex; align-items: center; gap: .9rem;
    padding: 1.1rem 1.3rem; border-bottom: none;
}
.bm-header--add { background: linear-gradient(135deg, #00a79d 0%, #00756e 100%); }
.bm-header--edit { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
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
    padding: .9rem 1.3rem; background: #f9fafb;
    border-top: 1px solid #e5e7eb;
}
.bm-required-toggle {
    display: flex; align-items: center; gap: .5rem;
    padding: .65rem .85rem;
    background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px;
}
.bm-required-toggle label { font-size: .85rem; font-weight: 500; color: #166534; margin: 0; cursor: pointer; }
.bm-btn-submit {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .5rem 1.15rem; border: none; border-radius: 8px;
    font-size: .85rem; font-weight: 600; cursor: pointer;
    transition: all .15s;
}
.bm-btn-submit--add { background: #00a79d; color: #fff; box-shadow: 0 2px 8px rgba(0,167,157,.3); }
.bm-btn-submit--add:hover { background: #00958c; box-shadow: 0 4px 12px rgba(0,167,157,.4); }
.bm-btn-submit--edit { background: #f59e0b; color: #fff; box-shadow: 0 2px 8px rgba(245,158,11,.3); }
.bm-btn-submit--edit:hover { background: #d97706; box-shadow: 0 4px 12px rgba(245,158,11,.4); }
.field-modal-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; margin-bottom: .3rem; display: block; }
.options-list .option-row { display: flex; gap: .5rem; margin-bottom: .4rem; align-items: center; }
.options-list .option-row input { flex: 1; }

/* ===== SORTABLE GHOST ===== */
.sortable-ghost { opacity: .4; background: #f0fdf4 !important; border: 2px dashed #86efac !important; }
.sortable-chosen { box-shadow: 0 4px 16px rgba(0,0,0,.1); }

/* ===== DARK MODE ===== */
html.dark-mode .panel-card { background: #1a1d23; box-shadow: 0 2px 12px rgba(0,0,0,.25); }
html.dark-mode .panel-header { background: #22252d; border-bottom-color: #2d3139; color: #e4e6eb; }
html.dark-mode .field-type-btn { background: #22252d; border-color: #2d3139; color: #c8cdd3; }
html.dark-mode .field-type-btn:hover { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .field-type-btn:hover i { color: #86efac; }
html.dark-mode .field-type-group-label { color: #6b7280; border-bottom-color: #2d3139; }
html.dark-mode .field-card { background: #22252d; border-color: #2d3139; }
html.dark-mode .field-card:hover { border-color: #2d4a30; box-shadow: 0 2px 8px rgba(0,0,0,.2); }
html.dark-mode .field-card.is-system { background: #22252d; border-color: #2d4a30; }
html.dark-mode .field-card-system-badge { background: rgba(251,191,36,.15); color: #fbbf24; border-color: rgba(251,191,36,.3); }
html.dark-mode .field-card-label { color: #e4e6eb; }
html.dark-mode .field-card-type { color: #6b7280; }
html.dark-mode .field-card-actions button { color: #6b7280; }
html.dark-mode .field-card-actions button:hover { color: #c8cdd3; background: #2d3139; }
html.dark-mode .field-card-actions button.btn-del:hover { color: #f87171; background: rgba(239,68,68,.15); }
html.dark-mode .drop-zone-empty { background: #22252d; border-color: #374151; color: #6b7280; }
html.dark-mode .gdrive-link-row { color: #c8cdd3; border-bottom-color: #2d3139; }
html.dark-mode .gdrive-link-row:hover { background: #22252d; color: #e4e6eb; }
html.dark-mode .gdrive-link-row .glr-text small { color: #6b7280; }
/* Dark mode — builder card */
html.dark-mode .card { background: #1a1d23; border-color: #2d3139 !important; }
html.dark-mode .builder-card-header { border-bottom-color: #2d4a30; }
/* Dark mode — builder bottom bar */
html.dark-mode .builder-bottom-bar { border-top-color: #2d3139; }
/* Dark mode — modals */
html.dark-mode .bm-card { background: #1a1d23; }
html.dark-mode .bm-body { background: #1a1d23; }
html.dark-mode .bm-footer { background: #22252d; border-top-color: #2d3139; }
html.dark-mode .bm-required-toggle { background: #1a2d1e; border-color: #2d4a30; }
html.dark-mode .bm-required-toggle label { color: #86efac; }
html.dark-mode .bm-card .form-control { background: #2d3139; color: #e4e6eb; border-color: #374151; }
html.dark-mode .bm-card .form-control::placeholder { color: #6b7280; }
html.dark-mode .field-modal-label { color: #9ca3af; }
</style>
