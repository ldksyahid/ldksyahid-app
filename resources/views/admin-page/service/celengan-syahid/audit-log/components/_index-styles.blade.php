<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
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

/* ── Stat Cards ── */
.stat-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    padding: 1rem 1.1rem; display: flex; align-items: center;
    gap: 1rem; position: relative; overflow: hidden;
    transition: box-shadow 0.2s ease;
}
.stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
.stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; flex-shrink: 0;
}
.stat-icon-total  { background: rgba(0,167,157,0.12); color: #00a79d; }
.stat-icon-create { background: rgba(40,167,69,0.12);  color: #28a745; }
.stat-icon-update { background: rgba(255,193,7,0.15);  color: #d39e00; }
.stat-icon-delete { background: rgba(220,53,69,0.12);  color: #dc3545; }
.stat-info  { flex: 1; min-width: 0; }
.stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; color: #212529; }
.stat-label { font-size: 0.82rem; font-weight: 600; color: #495057; margin-top: 3px; }
.stat-sub   { font-size: 0.72rem; color: #adb5bd; }

/* ── Filter Bar ── */
.filter-bar {
    display: flex; align-items: center; gap: 0.5rem;
    flex-wrap: wrap; background: #fff;
    border-radius: 12px; padding: 0.65rem 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
}
.filter-control { max-width: 200px; }
.filter-search  { max-width: 220px; }
.filter-bar .form-control, .filter-bar .form-select {
    border-radius: 8px !important;
    border-color: #dee2e6; font-size: 0.875rem; height: 31px; padding-top: 0; padding-bottom: 0;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.filter-bar .form-control:focus, .filter-bar .form-select:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important;
}

/* ── Select2 in Filter Bar (match Job Queue Log) ── */
.filter-bar .select2-container .select2-selection--single {
    height: 31px; border: 1px solid #dee2e6;
    border-radius: 8px !important; background-color: #fff;
    font-size: 0.875rem;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.filter-bar .select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 29px; padding-left: 14px; padding-right: 28px;
    font-size: 0.875rem; color: #495057;
}
.filter-bar .select2-container .select2-selection--single .select2-selection__arrow { height: 29px; right: 10px; }
.filter-bar .select2-container--open .select2-selection--single,
.filter-bar .select2-container--focus .select2-selection--single {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important; outline: none;
}
.select2-container--default .select2-results__option {
    padding: 8px 14px; font-size: 0.875rem; color: #333;
    transition: background-color 0.15s ease;
}
.select2-container--default .select2-results__option--highlighted[aria-selected],
.select2-container--default .select2-results__option--highlighted {
    background-color: #00a79d !important; color: #fff !important;
}
.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #e0f7f5 !important; color: #008b84 !important; font-weight: 600;
}
.select2-container--default .select2-selection__arrow b {
    border-color: #00a79d transparent transparent transparent;
}
.select2-dropdown {
    border-radius: 8px !important; border: 1px solid #00bfa6 !important;
    overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}
.select2-results__option { border-bottom: 1px solid #f0fffe; cursor: pointer; }
.select2-results__option:last-child { border-bottom: none; }

/* ── Table Card ── */
.table-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07); overflow: hidden;
}
#audit-table { font-size: 0.875rem; margin-bottom: 0; }
#audit-table thead th {
    font-size: 0.8rem; font-weight: 600;
    color: #6c757d; background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    white-space: nowrap; padding: 0.65rem 0.9rem;
}
#audit-table tbody td { padding: 0.6rem 0.9rem; vertical-align: middle; }
#audit-table tbody tr { transition: background 0.15s ease; }

/* ── Pagination inside card ── */
.table-pagination {
    padding: 0.65rem 1rem; border-top: 1px solid #e9ecef; background: #fff;
}

/* ── Badges ── */
.badge-status {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.73rem; font-weight: 600; padding: 3px 10px;
    border-radius: 6px; white-space: nowrap;
}
.badge-create { background: rgba(40,167,69,0.12); color: #1e7e34; border: 1px solid rgba(40,167,69,0.25); }
.badge-update { background: rgba(255,193,7,0.15); color: #d39e00; border: 1px solid rgba(255,193,7,0.3); }
.badge-delete { background: rgba(220,53,69,0.1);  color: #b02a37; border: 1px solid rgba(220,53,69,0.2); }
.badge-other  { background: rgba(108,117,125,0.12); color: #495057; border: 1px solid rgba(108,117,125,0.25); }
.status-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
.badge-create .status-dot { background: #28a745; }
.badge-update .status-dot { background: #d39e00; }
.badge-delete .status-dot { background: #dc3545; }
.badge-other  .status-dot { background: #6c757d; }
.badge-entity {
    display: inline-block; font-size: 0.72rem; font-weight: 600;
    padding: 2px 9px; border-radius: 6px;
    background: rgba(0,167,157,0.1); color: #008b84; border: 1px solid rgba(0,167,157,0.2);
}
.entity-id { font-size: 0.7rem; color: #adb5bd; margin-top: 2px; font-family: monospace; }

/* ── Empty State ── */
.audit-empty { padding: 3rem 1rem; text-align: center; color: #adb5bd; }
.audit-empty i { font-size: 2.5rem; margin-bottom: .6rem; display: block; opacity: .6; }

/* ── Mobile ── */
@media (max-width: 767px) {
    .container-fluid.pt-4.px-4 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; padding-top: 0.75rem !important; }
    .row.p-2.bg-light { padding: 0.5rem !important; }
    .page-title { font-size: 1.2rem; }
    .page-title::after { width: 70px; height: 3px; }
    .stat-card { padding: 0.7rem 0.75rem; gap: 0.6rem; border-radius: 10px; }
    .stat-icon { width: 36px; height: 36px; border-radius: 8px; font-size: 0.95rem; }
    .stat-value { font-size: 1.15rem; }
    .filter-bar { flex-direction: column; align-items: stretch; gap: 0.45rem; padding: 0.6rem 0.7rem; }
    .filter-bar .form-control, .filter-bar .form-select, .filter-control, .filter-search { max-width: 100% !important; width: 100% !important; }
    #audit-table { font-size: 0.78rem; }
    #audit-table thead th { font-size: 0.7rem; padding: 0.45rem 0.5rem; }
    #audit-table tbody td { padding: 0.45rem 0.5rem; }
}

/* ── Dark Mode ── */
html.dark-mode .stat-card,
html.dark-mode .filter-bar,
html.dark-mode .table-card,
html.dark-mode .table-pagination {
    background: #2b2f33 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3) !important;
}
html.dark-mode .table-pagination { border-top-color: #373b3e !important; }
html.dark-mode .stat-value { color: #e4e6eb; }
html.dark-mode .stat-label { color: #9ca3af; }
html.dark-mode .filter-bar .form-control,
html.dark-mode .filter-bar .form-select {
    background-color: #1a1d21; border-color: #373b3e; color: #e4e6eb;
}
html.dark-mode #audit-table thead th { background: #1a1d21; color: #9ca3af; border-bottom-color: #373b3e; }
html.dark-mode #audit-table tbody td { color: #e4e6eb; }
html.dark-mode #audit-table tbody tr:hover > td { background: rgba(255,255,255,0.04); }
html.dark-mode .table { --bs-table-hover-bg: rgba(255,255,255,0.04); }
html.dark-mode .bg-light { background: #23272b !important; }
html.dark-mode .badge-other { background: rgba(108,117,125,0.15); border-color: rgba(108,117,125,0.25); color: #9ca3af; }
html.dark-mode .entity-id { color: #6b7280; }

/* Select2 dark mode (filter bar) */
html.dark-mode .filter-bar .select2-container .select2-selection--single {
    background-color: #1a1d21 !important; border-color: #373b3e !important;
}
html.dark-mode .filter-bar .select2-container .select2-selection--single .select2-selection__rendered {
    color: #e4e6eb !important;
}
html.dark-mode .filter-bar .select2-container--open .select2-selection--single,
html.dark-mode .filter-bar .select2-container--focus .select2-selection--single {
    border-color: #00a79d !important; box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important;
}
html.dark-mode .select2-dropdown { background-color: #2b2f33 !important; border-color: #373b3e !important; }
html.dark-mode .select2-container--default .select2-results__option { color: #e4e6eb !important; }
html.dark-mode .select2-results__option { border-bottom-color: #373b3e !important; }
</style>
