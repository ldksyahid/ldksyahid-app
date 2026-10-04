<style>
/* ── Page Title ── */
.page-title {
    font-size: 1.65rem; font-weight: 600;
    color: #00a79d; margin: .75rem 0 .25rem; position: relative; display: inline-block;
}
.page-title::after {
    content: ''; display: block; height: 4px; width: 120px;
    margin: .35rem 0 0; border-radius: 3px;
    background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
}

.btn-rounded { border-radius: 8px !important; }

/* ── Alert banner (truncated file notice) ── */
.ll-alert {
    display: flex; align-items: center; gap: .6rem;
    background: linear-gradient(135deg, rgba(255,152,0,0.1) 0%, rgba(255,193,7,0.08) 100%);
    border: 1px solid rgba(255,152,0,0.3);
    border-radius: 10px; padding: 0.75rem 1rem;
    color: #e65100; font-size: 0.85rem;
}
.ll-alert i { font-size: 1.1rem; color: #ff9800; flex-shrink: 0; }

/* ── Stats Cards ── */
.stat-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    padding: 1rem 1.1rem; display: flex; align-items: center;
    gap: 1rem; height: 100%;
}
.stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
}
.stat-icon-total    { background: rgba(0,167,157,0.12); color: #00a79d; }
.stat-icon-critical { background: rgba(108,19,19,0.12); color: #7c1515; }
.stat-icon-error    { background: rgba(220,53,69,0.12); color: #dc3545; }
.stat-icon-warning  { background: rgba(255,193,7,0.15); color: #d39e00; }
.stat-icon-info     { background: rgba(0,123,255,0.12); color: #0063cc; }
.stat-info  { flex: 1; min-width: 0; }
.stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; color: #212529; }
.stat-label { font-size: 0.82rem; font-weight: 600; color: #495057; margin-top: 3px; }
.stat-sub   { font-size: 0.68rem; color: #adb5bd; }

/* ── Filter Bar ── */
.filter-bar {
    display: flex; align-items: center; gap: 0.5rem;
    flex-wrap: wrap; padding: 0.9rem 1.1rem;
    border-bottom: 1px solid #e9ecef;
}
.filter-control { max-width: 160px; }
.search-input-wrap { position: relative; flex: 1 1 260px; max-width: 360px; }
.search-input-wrap .search-input-icon {
    position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
    color: #adb5bd; font-size: 0.78rem; pointer-events: none;
}
.filter-search { width: 100%; padding-left: 28px !important; }
.filter-bar .form-control, .filter-bar .form-select {
    border-radius: 8px !important; border-color: #dee2e6; font-size: 0.875rem; height: 31px;
}
.filter-bar .form-control:focus, .filter-bar .form-select:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important;
}

/* ── Table Card ── */
.table-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07); overflow: hidden;
}
#log-table { font-size: 0.875rem; margin-bottom: 0; }
#log-table thead th {
    font-size: 0.8rem; font-weight: 600; color: #6c757d; background: #f8f9fa;
    border-bottom: 2px solid #e9ecef; white-space: nowrap; padding: 0.65rem 0.75rem;
}
#log-table tbody td { padding: 0.55rem 0.75rem; vertical-align: middle; }
#log-table .ll-message {
    max-width: 1px; width: 100%; overflow: hidden; text-overflow: ellipsis;
    white-space: nowrap; font-family: monospace; font-size: 0.82rem;
}

.table-pagination { padding: 0.65rem 1rem; border-top: 1px solid #e9ecef; background: #fff; }
#pagination-controls .btn { font-size: 0.78rem; padding: 3px 12px; }

/* ── Level Badges ── */
.badge-level {
    display: inline-block; font-size: 0.72rem; font-weight: 700;
    padding: 3px 10px; border-radius: 6px; letter-spacing: .02em;
}
.badge-level-emergency, .badge-level-alert, .badge-level-critical {
    background: rgba(108,19,19,0.12); color: #7c1515; border: 1px solid rgba(108,19,19,0.25);
}
.badge-level-error   { background: rgba(220,53,69,0.1);  color: #b02a37; border: 1px solid rgba(220,53,69,0.2); }
.badge-level-warning { background: rgba(255,193,7,0.15); color: #d39e00; border: 1px solid rgba(255,193,7,0.3); }
.badge-level-notice, .badge-level-info {
    background: rgba(0,123,255,0.1); color: #0056b3; border: 1px solid rgba(0,123,255,0.2);
}
.badge-level-debug { background: rgba(108,117,125,0.12); color: #495057; border: 1px solid rgba(108,117,125,0.25); }

/* ── Detail Modal ── */
.ll-modal-content { border: none; border-radius: 12px; overflow: hidden; }
.ll-modal-header {
    background: linear-gradient(135deg, #00a79d 0%, #007d75 100%);
    border-bottom: none; padding: 1rem 1.25rem;
}
.detail-group { margin-bottom: 0.9rem; }
.detail-label {
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: #adb5bd; margin-bottom: 4px;
}
.raw-payload {
    background: #1a1d21; color: #c9d1d9;
    border-radius: 10px; padding: 1rem;
    font-size: 0.78rem; line-height: 1.5;
    max-height: 420px; overflow-y: auto;
    border: 1px solid #373b3e;
    white-space: pre-wrap; word-break: break-word;
}

/* ── Mobile ── */
@media (max-width: 767px) {
    .page-title { font-size: 1.2rem; }
    .stat-card { padding: 0.7rem 0.75rem; gap: 0.6rem; border-radius: 10px; }
    .stat-icon { width: 36px; height: 36px; border-radius: 8px; font-size: 0.95rem; }
    .stat-value { font-size: 1.15rem; }
    .stat-label { font-size: 0.72rem; }
    .filter-bar { flex-direction: column; align-items: stretch; gap: 0.45rem; padding: 0.6rem 0.7rem; }
    .filter-bar .form-select, .search-input-wrap { max-width: 100% !important; width: 100% !important; }
    #log-table { font-size: 0.75rem; }
    #log-table thead th { font-size: 0.7rem; padding: 0.4rem 0.4rem; }
    #log-table tbody td { padding: 0.35rem 0.4rem; }
}

/* ── Dark Mode ── */
html.dark-mode .stat-card,
html.dark-mode .table-card,
html.dark-mode .table-pagination,
html.dark-mode .modal-content {
    background: #2b2f33 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3) !important;
}
html.dark-mode .ll-modal-content { background: #2b2f33 !important; }
html.dark-mode .filter-bar { border-bottom-color: #373b3e; }
html.dark-mode .table-pagination { border-top-color: #373b3e !important; }
html.dark-mode .filter-bar .form-control, html.dark-mode .filter-bar .form-select {
    background-color: #1a1d21; border-color: #373b3e; color: #e4e6eb;
}
html.dark-mode #log-table thead th { background: #1a1d21; color: #9ca3af; border-bottom-color: #373b3e; }
html.dark-mode #log-table tbody td { color: #e4e6eb; }
html.dark-mode #log-table tbody tr:hover > td { background: rgba(255,255,255,0.04); }
html.dark-mode .stat-value { color: #e4e6eb; }
html.dark-mode .stat-label { color: #9ca3af; }
html.dark-mode .bg-light { background: #23272b !important; }
html.dark-mode .detail-label { color: #6b7280; }
html.dark-mode .modal-footer { border-color: #373b3e; }
html.dark-mode .btn-outline-secondary { color: #9ca3af; border-color: #4b5563; }
html.dark-mode .btn-outline-secondary:hover { background: #374151; color: #e4e6eb; border-color: #6b7280; }
html.dark-mode .btn-secondary { background: #374151; border-color: #4b5563; color: #e4e6eb; }
html.dark-mode .btn-secondary:hover { background: #4b5563; }
html.dark-mode .ll-alert {
    background: linear-gradient(135deg, rgba(255,152,0,0.08) 0%, rgba(255,193,7,0.05) 100%);
    border-color: rgba(255,152,0,0.2); color: #ffb74d;
}
</style>
