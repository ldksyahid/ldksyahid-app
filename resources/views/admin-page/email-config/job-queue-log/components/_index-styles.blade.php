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

/* ── Live Indicator ── */
.live-indicator {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(0, 200, 83, 0.1); border: 1px solid rgba(0, 200, 83, 0.3);
    border-radius: 20px; padding: 4px 12px;
}
.live-indicator.paused {
    background: rgba(108, 117, 125, 0.1); border-color: rgba(108, 117, 125, 0.3);
}
.live-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #00c853; display: inline-block;
    animation: livePulse 1.5s ease-in-out infinite;
}
.live-indicator.paused .live-dot {
    background: #6c757d; animation: none;
}
.live-label {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em;
    color: #00c853;
}
.live-indicator.paused .live-label { color: #6c757d; }
@keyframes livePulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: 0.5; transform: scale(0.85); }
}

/* ── Stats Cards ── */
.stat-card {
    background: #fff; border-radius: 12px;
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
.stat-icon-total     { background: rgba(0,167,157,0.12); color: #00a79d; }
.stat-icon-pending   { background: rgba(255,193,7,0.15);  color: #d39e00; }
.stat-icon-processing{ background: rgba(40,167,69,0.12);  color: #28a745; }
.stat-icon-delayed   { background: rgba(0,123,255,0.12);  color: #0063cc; }
.stat-info { flex: 1; min-width: 0; }
.stat-value {
    font-size: 1.6rem; font-weight: 700; line-height: 1;
    color: #212529;
}
.stat-label { font-size: 0.82rem; font-weight: 600; color: #495057; margin-top: 3px; }
.stat-sub   { font-size: 0.72rem; color: #adb5bd; }
.stat-change {
    position: absolute; top: 8px; right: 10px;
    font-size: 0.72rem; font-weight: 600;
}
.stat-change.up   { color: #28a745; }
.stat-change.down { color: #dc3545; }

/* ── Filter Bar ── */
.filter-bar {
    display: flex; align-items: center; gap: 0.5rem;
    flex-wrap: wrap; background: #fff;
    border-radius: 10px; padding: 0.6rem 0.9rem;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
}
.filter-control { max-width: 180px; }

/* Search input in filter bar */
.filter-bar .form-control {
    border-radius: 8px !important;
    border-color: #dee2e6;
    font-size: 0.875rem;
    height: 31px;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.filter-bar .form-control:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important;
}

/* ── Select2 in Filter Bar ── */
.filter-bar .select2-container .select2-selection--single {
    height: 31px;
    border: 1px solid #dee2e6;
    border-radius: 8px !important;
    background-color: #fff;
    font-size: 0.875rem;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.filter-bar .select2-container .select2-selection--single .select2-selection__rendered {
    line-height: 29px;
    padding-left: 10px;
    padding-right: 28px;
    font-size: 0.875rem;
    color: #495057;
}
.filter-bar .select2-container .select2-selection--single .select2-selection__arrow {
    height: 29px;
    right: 8px;
}
.filter-bar .select2-container--open .select2-selection--single,
.filter-bar .select2-container--focus .select2-selection--single {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important;
    outline: none;
}

/* ── Select2 Global (Dropdown List) ── */
.select2-container--default .select2-results__option {
    padding: 8px 12px;
    font-size: 0.875rem;
    color: #333;
    transition: background-color 0.15s ease;
}
.select2-container--default .select2-results__option--highlighted[aria-selected],
.select2-container--default .select2-results__option--highlighted {
    background-color: #00a79d !important;
    color: #fff !important;
}
.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #e0f7f5 !important;
    color: #008b84 !important;
    font-weight: 600;
}
.select2-container--default .select2-selection__arrow b {
    border-color: #00a79d transparent transparent transparent;
}
.select2-dropdown {
    border-radius: 10px !important;
    border: 1px solid #00bfa6 !important;
    font-size: 0.875rem;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    animation: select2FadeIn 0.15s ease forwards;
}
.select2-results__option { border-bottom: 1px solid #f0fffe; cursor: pointer; }
.select2-results__option:last-child { border-bottom: none; }
@keyframes select2FadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Table Card ── */
.table-card {
    background: #fff; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
    overflow: hidden;
}
.table-card .table-responsive { margin-bottom: 0; }

/* ── Table ── */
#jobs-table { font-size: 0.875rem; margin-bottom: 0; }
#jobs-table thead th {
    font-size: 0.78rem; font-weight: 600; text-transform: uppercase;
    letter-spacing: 0.04em; color: #6c757d;
    background: #f8f9fa; border-bottom: 2px solid #e9ecef;
    white-space: nowrap; padding: 0.6rem 0.75rem;
}
#jobs-table tbody td { padding: 0.55rem 0.75rem; vertical-align: middle; }
#jobs-table tbody tr { transition: background 0.15s ease; }

/* ── Pagination inside card ── */
.table-pagination {
    padding: 0.65rem 1rem; border-top: 1px solid #e9ecef;
    background: #fff;
}

.tooltip-icon {
    color: #adb5bd; font-size: 0.7rem; cursor: help;
    margin-left: 3px; vertical-align: middle;
}
.tooltip-icon:hover { color: #00a79d; }

/* ── Status Badges ── */
.badge-status {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 0.73rem; font-weight: 600; padding: 3px 9px;
    border-radius: 20px; white-space: nowrap;
}
.badge-pending    { background: rgba(255,193,7,0.15);  color: #d39e00;  border: 1px solid rgba(255,193,7,0.3); }
.badge-processing { background: rgba(40,167,69,0.12);  color: #1e7e34;  border: 1px solid rgba(40,167,69,0.25); }
.badge-delayed    { background: rgba(0,123,255,0.1);   color: #0056b3;  border: 1px solid rgba(0,123,255,0.2); }
.badge-stuck      { background: rgba(220,53,69,0.1);   color: #b02a37;  border: 1px solid rgba(220,53,69,0.2); }
.status-dot {
    width: 6px; height: 6px; border-radius: 50%; display: inline-block; flex-shrink: 0;
}
.badge-pending    .status-dot { background: #d39e00; }
.badge-processing .status-dot { background: #28a745; animation: livePulse 1.5s ease-in-out infinite; }
.badge-delayed    .status-dot { background: #0063cc; }
.badge-stuck      .status-dot { background: #dc3545; }

/* ── Row Flash Animation ── */
@keyframes rowFlash {
    0%   { background-color: rgba(0,167,157,0.18); }
    100% { background-color: transparent; }
}
.row-flash { animation: rowFlash 1.2s ease-out forwards; }

/* ── Pagination ── */
#pagination-controls .btn { font-size: 0.78rem; padding: 3px 10px; }

/* ── Activity Feed ── */
.activity-feed-wrapper {
    background: #fff; border-radius: 10px;
    box-shadow: 0 1px 6px rgba(0,0,0,0.07);
    overflow: hidden;
}
.activity-feed-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0.65rem 1rem; border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
}
.activity-feed-body {
    max-height: 200px; overflow-y: auto;
    padding: 0.5rem 0;
}
.feed-empty {
    text-align: center; color: #adb5bd;
    font-size: 0.82rem; padding: 1.5rem 1rem;
}
.feed-entry {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 0.35rem 1rem; font-size: 0.8rem;
    border-bottom: 1px solid #f0f0f0;
    animation: feedSlideIn 0.3s ease-out;
}
.feed-entry:last-child { border-bottom: none; }
@keyframes feedSlideIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
.feed-time  { color: #adb5bd; font-size: 0.73rem; white-space: nowrap; flex-shrink: 0; padding-top: 1px; }
.feed-icon  { flex-shrink: 0; width: 16px; text-align: center; padding-top: 1px; }
.feed-icon.new       { color: #00a79d; }
.feed-icon.removed   { color: #6c757d; }
.feed-icon.status    { color: #fd7e14; }
.feed-icon.attempts  { color: #dc3545; }
.feed-icon.stats-up  { color: #28a745; }
.feed-icon.stats-down{ color: #6c757d; }
.feed-msg { flex: 1; color: #495057; }
.feed-type { color: #adb5bd; font-size: 0.72rem; }

/* ── Btn XS ── */
.btn-xs { padding: 2px 8px; font-size: 0.72rem; }

/* ── Detail Modal ── */
.detail-group { margin-bottom: 0.9rem; }
.detail-label {
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.05em; color: #adb5bd; margin-bottom: 2px;
}
.detail-value { font-size: 0.9rem; color: #212529; }
.detail-section-title {
    font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; color: #00a79d;
    border-bottom: 2px solid #e0f7f5;
    padding-bottom: 4px; margin-bottom: 0.75rem;
}
.detail-infobox {
    background: #f8f9fa; border: 1px solid #e9ecef;
    border-radius: 8px; padding: 0.65rem 0.9rem; font-size: 0.85rem;
}
.detail-infobox .info-row {
    display: flex; gap: 8px; margin-bottom: 4px; align-items: flex-start;
}
.detail-infobox .info-row:last-child { margin-bottom: 0; }
.detail-infobox .info-key {
    font-size: 0.75rem; font-weight: 600; color: #6c757d;
    width: 65px; flex-shrink: 0;
}
.detail-infobox .info-val { color: #212529; word-break: break-all; }
.raw-payload {
    background: #1a1d21; color: #c9d1d9;
    border-radius: 8px; padding: 1rem;
    font-size: 0.78rem; line-height: 1.5;
    max-height: 300px; overflow-y: auto;
    border: 1px solid #373b3e;
}

/* ── Dark Mode ── */
html.dark-mode .stat-card,
html.dark-mode .filter-bar,
html.dark-mode .table-card,
html.dark-mode .table-pagination,
html.dark-mode .activity-feed-wrapper,
html.dark-mode .modal-content {
    background: #2b2f33 !important;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3) !important;
}
html.dark-mode .table-pagination { border-top-color: #373b3e !important; }
html.dark-mode .filter-bar .form-control {
    background-color: #1a1d21; border-color: #373b3e; color: #e4e6eb;
}
html.dark-mode .filter-bar .form-control:focus {
    background-color: #1a1d21; border-color: #00a79d !important; color: #e4e6eb;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important;
}
html.dark-mode .filter-bar .select2-container .select2-selection--single {
    background-color: #1a1d21 !important; border-color: #373b3e !important;
}
html.dark-mode .filter-bar .select2-container .select2-selection--single .select2-selection__rendered {
    color: #e4e6eb !important;
}
html.dark-mode .filter-bar .select2-container--open .select2-selection--single,
html.dark-mode .filter-bar .select2-container--focus .select2-selection--single {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25) !important;
}
html.dark-mode .select2-dropdown {
    background-color: #2b2f33 !important; border-color: #373b3e !important;
}
html.dark-mode .select2-container--default .select2-results__option { color: #e4e6eb !important; }
html.dark-mode .select2-results__option { border-bottom-color: #373b3e !important; }
html.dark-mode #jobs-table thead th {
    background: #1a1d21; color: #9ca3af; border-bottom-color: #373b3e;
}
html.dark-mode #jobs-table tbody td { color: #e4e6eb; }
html.dark-mode #jobs-table tbody tr:hover > td { background: rgba(255,255,255,0.04); }
html.dark-mode .stat-value { color: #e4e6eb; }
html.dark-mode .stat-label { color: #9ca3af; }
html.dark-mode .activity-feed-header { background: #1a1d21; border-bottom-color: #373b3e; }
html.dark-mode .feed-entry { border-bottom-color: #373b3e; }
html.dark-mode .feed-msg { color: #9ca3af; }
html.dark-mode .form-select,
html.dark-mode .form-control {
    background-color: #1a1d21; border-color: #373b3e; color: #e4e6eb;
}
html.dark-mode .form-select:focus,
html.dark-mode .form-control:focus {
    border-color: #00a79d; background-color: #1a1d21; color: #e4e6eb;
    box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25);
}
html.dark-mode .detail-infobox {
    background: #1a1d21; border-color: #373b3e;
}
html.dark-mode .detail-infobox .info-val { color: #e4e6eb; }
html.dark-mode .detail-value { color: #e4e6eb; }
html.dark-mode .modal-header,
html.dark-mode .modal-footer { border-color: #373b3e; }
html.dark-mode .detail-section-title { border-bottom-color: #373b3e; }
html.dark-mode .table { --bs-table-hover-bg: rgba(255,255,255,0.04); }
html.dark-mode .bg-light { background: #23272b !important; }
html.dark-mode .live-indicator {
    background: rgba(0,200,83,0.08); border-color: rgba(0,200,83,0.2);
}
html.dark-mode .activity-feed-wrapper { border-color: #373b3e; }
</style>
