{{-- Path: resources/views/admin-page/service-request/persuratan/components/_index-styles.blade.php --}}
<style>
/* ================================================================
   ADMIN PERSURATAN — Modern Layout & Comprehensive Dark Mode
   ================================================================ */
.adm-letter-container {
    padding: 1.5rem 0.5rem;
}

.adm-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    transition: all 0.2s ease;
}

/* ── KPI Stat Cards ──────────────────────────────────────── */
.adm-kpi-link {
    text-decoration: none !important;
    color: inherit !important;
    display: block;
}
.adm-kpi-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1.5px solid #e2e8f0;
    padding: 1.1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.95rem;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
}
.adm-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
}
.adm-kpi-icon {
    width: 46px;
    height: 46px;
    min-width: 46px;
    border-radius: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}
.adm-kpi-icon.primary   { background: #e0f2fe; color: #0284c7; }
.adm-kpi-icon.warning   { background: #fef3c7; color: #d97706; }
.adm-kpi-icon.success   { background: #d1fae5; color: #059669; }
.adm-kpi-icon.danger    { background: #fee2e2; color: #dc2626; }
.adm-kpi-icon.secondary { background: #f1f5f9; color: #64748b; }

.adm-kpi-title {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #64748b;
    margin-bottom: 0.15rem;
}
.adm-kpi-number {
    font-size: 1.45rem;
    font-weight: 800;
    line-height: 1;
    color: #0f172a;
    margin: 0;
}
.adm-kpi-number.warning { color: #d97706 !important; }
.adm-kpi-number.success { color: #059669 !important; }
.adm-kpi-number.danger  { color: #dc2626 !important; }

/* ── Status Filter Pills ─────────────────────────────────── */
.adm-status-pills-wrap {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    padding-bottom: 0.35rem;
    scrollbar-width: thin;
    margin-bottom: 1rem;
}
.adm-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.5rem 0.95rem;
    border-radius: 50rem;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none !important;
    background: #ffffff;
    color: #475569 !important;
    border: 1.5px solid #e2e8f0;
    white-space: nowrap;
    transition: all 0.2s cubic-bezier(.4,0,.2,1);
}
.adm-status-pill:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #0f172a !important;
    transform: translateY(-1px);
}
.adm-status-pill.active {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    border-color: #0ea5e9;
    color: #ffffff !important;
    box-shadow: 0 4px 14px rgba(14, 165, 233, 0.35);
}
.adm-status-pill.pending.active  { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-color: #f59e0b; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35); }
.adm-status-pill.approved.active { background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-color: #10b981; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35); }
.adm-status-pill.rejected.active { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-color: #ef4444; box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35); }
.adm-status-pill.expired.active  { background: linear-gradient(135deg, #64748b 0%, #475569 100%); border-color: #64748b; box-shadow: 0 4px 14px rgba(100, 116, 139, 0.35); }

/* ── Filter Card & Type Selector Trigger ─────────────────── */
.adm-filter-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1.5px solid #e2e8f0;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
}

.adm-type-picker-btn {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    min-height: 40px;
    padding: 0.45rem 0.95rem;
    background: #f8fafc;
    border: 1.5px solid #cbd5e1;
    border-radius: 12px;
    cursor: pointer;
    font-size: 0.84rem;
    color: #1e293b;
    transition: all 0.2s;
    user-select: none;
    width: 100%;
}
.adm-type-picker-btn:hover {
    border-color: #0ea5e9;
    background: #f0f9ff;
}
.adm-type-picker-btn.has-filter {
    background: #f0f9ff;
    border-color: #0ea5e9;
    font-weight: 700;
    color: #0369a1;
}

.adm-clear-filter-btn {
    margin-left: auto;
    color: #ef4444;
    padding: 0.15rem 0.45rem;
    border-radius: 6px;
    font-size: 0.75rem;
    transition: all 0.2s;
    text-decoration: none !important;
}
.adm-clear-filter-btn:hover {
    background: #fee2e2;
    color: #b91c1c;
}

/* ── Status Badges ───────────────────────────────────────── */
.adm-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50rem;
    font-size: 0.75rem;
    font-weight: 700;
    line-height: 1.3;
}
.adm-badge-success { background-color: #dcfce7 !important; color: #15803d !important; border: 1px solid #86efac !important; }
.adm-badge-warning { background-color: #fef3c7 !important; color: #b45309 !important; border: 1px solid #fcd34d !important; }
.adm-badge-danger  { background-color: #fee2e2 !important; color: #b91c1c !important; border: 1px solid #fca5a5 !important; }
.adm-badge-neutral { background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; }

/* ── User Avatar ─────────────────────────────────────────── */
.adm-user-avatar {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 50%;
    background-color: #e0f2fe;
    color: #0284c7;
    font-weight: 700;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* ── Table Style ─────────────────────────────────────────── */
.adm-table-wrap {
    background: #ffffff;
    border-radius: 16px;
    border: 1.5px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    overflow: hidden;
}
.adm-table {
    width: 100%;
    margin-bottom: 0;
}
.adm-table th {
    background-color: #f8fafc !important;
    color: #475569 !important;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 0.95rem 1rem;
    border-bottom: 2px solid #e2e8f0;
    border-top: none;
}
.adm-table td {
    padding: 0.95rem 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    font-size: 0.85rem;
}
.adm-table tbody tr:hover {
    background-color: #f8fafc;
}

/* ── Action Buttons ──────────────────────────────────────── */
.adm-action-btn {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    text-decoration: none !important;
    transition: all 0.2s;
    border: none;
}
.adm-action-btn.view { background: #e0f2fe; color: #0284c7; }
.adm-action-btn.view:hover { background: #0284c7; color: #fff; transform: scale(1.08); }
.adm-action-btn.download { background: #d1fae5; color: #059669; }
.adm-action-btn.download:hover { background: #059669; color: #fff; transform: scale(1.08); }
.adm-action-btn.delete { background: #fee2e2; color: #dc2626; }
.adm-action-btn.delete:hover { background: #dc2626; color: #fff; transform: scale(1.08); }

/* ── Modal Letter Selector Styles (Admin) ────────────────── */
.adm-modal-cat-pills {
    display: flex;
    gap: 0.45rem;
    overflow-x: auto;
    padding-bottom: 0.25rem;
    scrollbar-width: thin;
}
.adm-modal-cat-pill {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    border-radius: 50rem;
    padding: 0.3rem 0.8rem;
    font-size: 0.76rem;
    font-weight: 700;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s;
}
.adm-modal-cat-pill:hover {
    background: #f1f5f9;
    color: #0f172a;
}
.adm-modal-cat-pill.active {
    background: #0ea5e9;
    border-color: #0ea5e9;
    color: #ffffff !important;
}

.adm-letter-filter-item {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.85rem 1rem;
    border: 1.5px solid #e2e8f0;
    border-radius: 14px;
    background: #ffffff;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none !important;
    color: #1e293b !important;
    height: 100%;
}
.adm-letter-filter-item:hover {
    border-color: #0ea5e9;
    background: #f0f9ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.1);
}
.adm-letter-filter-item.active {
    border-color: #0ea5e9;
    background: #e0f2fe;
    font-weight: 700;
}

/* ============================================================
   GLOBAL DARK MODE OVERRIDES (HTML.DARK-MODE / BODY.DARK-MODE)
   ============================================================ */
html.dark-mode,
body.dark-mode,
[data-theme="dark"],
.dark-mode {
    --adm-bg:       #161b26;
    --adm-card-bg:  #1e2535;
    --adm-input-bg: #252b3b;
    --adm-border:   rgba(255, 255, 255, 0.08);
}

html.dark-mode .adm-card,
html.dark-mode .adm-kpi-card,
html.dark-mode .adm-filter-card,
html.dark-mode .adm-table-wrap,
html.dark-mode .modal-content,
body.dark-mode .adm-card,
body.dark-mode .adm-kpi-card,
body.dark-mode .adm-filter-card,
body.dark-mode .adm-table-wrap,
body.dark-mode .modal-content,
[data-theme="dark"] .adm-card,
[data-theme="dark"] .adm-kpi-card,
[data-theme="dark"] .adm-filter-card,
[data-theme="dark"] .adm-table-wrap,
[data-theme="dark"] .modal-content {
    background: #1e2535 !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3) !important;
    color: #cbd5e1 !important;
}

html.dark-mode .modal-header,
html.dark-mode .modal-footer,
body.dark-mode .modal-header,
body.dark-mode .modal-footer,
[data-theme="dark"] .modal-header,
[data-theme="dark"] .modal-footer {
    background: #1e2535 !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
}

html.dark-mode .text-dark,
body.dark-mode .text-dark,
[data-theme="dark"] .text-dark {
    color: #f1f5f9 !important;
}

html.dark-mode .text-muted,
body.dark-mode .text-muted,
[data-theme="dark"] .text-muted {
    color: #94a3b8 !important;
}

html.dark-mode .adm-kpi-title,
body.dark-mode .adm-kpi-title,
[data-theme="dark"] .adm-kpi-title {
    color: #94a3b8 !important;
}

html.dark-mode .adm-kpi-number,
body.dark-mode .adm-kpi-number,
[data-theme="dark"] .adm-kpi-number {
    color: #f1f5f9 !important;
}

html.dark-mode .adm-status-pill,
body.dark-mode .adm-status-pill,
[data-theme="dark"] .adm-status-pill {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
    color: #cbd5e1 !important;
}
html.dark-mode .adm-status-pill:hover,
body.dark-mode .adm-status-pill:hover,
[data-theme="dark"] .adm-status-pill:hover {
    background: #1e2535 !important;
    border-color: #38bdf8 !important;
    color: #38bdf8 !important;
}

html.dark-mode .adm-type-picker-btn,
body.dark-mode .adm-type-picker-btn,
[data-theme="dark"] .adm-type-picker-btn {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.12) !important;
    color: #f1f5f9 !important;
}
html.dark-mode .adm-type-picker-btn.has-filter,
body.dark-mode .adm-type-picker-btn.has-filter,
[data-theme="dark"] .adm-type-picker-btn.has-filter {
    background: rgba(14, 165, 233, 0.15) !important;
    border-color: #38bdf8 !important;
    color: #38bdf8 !important;
}

html.dark-mode .adm-table th,
body.dark-mode .adm-table th,
[data-theme="dark"] .adm-table th {
    background-color: #161b26 !important;
    color: #94a3b8 !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
}
html.dark-mode .adm-table td,
body.dark-mode .adm-table td,
[data-theme="dark"] .adm-table td {
    color: #cbd5e1 !important;
    border-color: rgba(255, 255, 255, 0.06) !important;
}
html.dark-mode .adm-table tbody tr:hover,
body.dark-mode .adm-table tbody tr:hover,
[data-theme="dark"] .adm-table tbody tr:hover {
    background-color: rgba(255, 255, 255, 0.03) !important;
}

html.dark-mode .adm-badge-neutral,
body.dark-mode .adm-badge-neutral,
[data-theme="dark"] .adm-badge-neutral {
    background-color: #252b3b !important;
    color: #cbd5e1 !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
}
html.dark-mode .adm-badge-success,
body.dark-mode .adm-badge-success,
[data-theme="dark"] .adm-badge-success {
    background-color: rgba(16, 185, 129, 0.2) !important;
    color: #6ee7b7 !important;
    border-color: rgba(16, 185, 129, 0.35) !important;
}
html.dark-mode .adm-badge-warning,
body.dark-mode .adm-badge-warning,
[data-theme="dark"] .adm-badge-warning {
    background-color: rgba(245, 158, 11, 0.2) !important;
    color: #fde68a !important;
    border-color: rgba(245, 158, 11, 0.35) !important;
}
html.dark-mode .adm-badge-danger,
body.dark-mode .adm-badge-danger,
[data-theme="dark"] .adm-badge-danger {
    background-color: rgba(239, 68, 68, 0.2) !important;
    color: #fca5a5 !important;
    border-color: rgba(239, 68, 68, 0.35) !important;
}

html.dark-mode .form-control,
html.dark-mode .form-select,
html.dark-mode .input-group-text,
body.dark-mode .form-control,
body.dark-mode .form-select,
body.dark-mode .input-group-text,
[data-theme="dark"] .form-control,
[data-theme="dark"] .form-select,
[data-theme="dark"] .input-group-text {
    background-color: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.12) !important;
    color: #f1f5f9 !important;
}

html.dark-mode .adm-action-btn.view,
body.dark-mode .adm-action-btn.view,
[data-theme="dark"] .adm-action-btn.view {
    background: rgba(14, 165, 233, 0.2) !important;
    color: #38bdf8 !important;
    border: 1px solid rgba(14, 165, 233, 0.3) !important;
}
html.dark-mode .adm-action-btn.view:hover,
body.dark-mode .adm-action-btn.view:hover,
[data-theme="dark"] .adm-action-btn.view:hover {
    background: #0ea5e9 !important;
    color: #ffffff !important;
}

html.dark-mode .adm-action-btn.download,
body.dark-mode .adm-action-btn.download,
[data-theme="dark"] .adm-action-btn.download {
    background: rgba(16, 185, 129, 0.2) !important;
    color: #34d399 !important;
    border: 1px solid rgba(16, 185, 129, 0.3) !important;
}
html.dark-mode .adm-action-btn.download:hover,
body.dark-mode .adm-action-btn.download:hover,
[data-theme="dark"] .adm-action-btn.download:hover {
    background: #10b981 !important;
    color: #ffffff !important;
}

html.dark-mode .adm-action-btn.delete,
body.dark-mode .adm-action-btn.delete,
[data-theme="dark"] .adm-action-btn.delete {
    background: rgba(239, 68, 68, 0.2) !important;
    color: #f87171 !important;
    border: 1px solid rgba(239, 68, 68, 0.3) !important;
}
html.dark-mode .adm-action-btn.delete:hover,
body.dark-mode .adm-action-btn.delete:hover,
[data-theme="dark"] .adm-action-btn.delete:hover {
    background: #ef4444 !important;
    color: #ffffff !important;
}

html.dark-mode .btn-outline-primary,
body.dark-mode .btn-outline-primary,
[data-theme="dark"] .btn-outline-primary {
    background: #1e2535 !important;
    border-color: rgba(14, 165, 233, 0.4) !important;
    color: #38bdf8 !important;
}
html.dark-mode .btn-outline-primary:hover,
body.dark-mode .btn-outline-primary:hover,
[data-theme="dark"] .btn-outline-primary:hover {
    background: #0ea5e9 !important;
    color: #ffffff !important;
}

html.dark-mode .btn-primary,
body.dark-mode .btn-primary,
[data-theme="dark"] .btn-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    border: none !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35) !important;
}

html.dark-mode .btn-light,
body.dark-mode .btn-light,
[data-theme="dark"] .btn-light {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.12) !important;
    color: #cbd5e1 !important;
}
html.dark-mode .btn-light:hover,
body.dark-mode .btn-light:hover,
[data-theme="dark"] .btn-light:hover {
    background: #1e2535 !important;
    color: #f8fafc !important;
}

html.dark-mode .adm-letter-filter-item,
body.dark-mode .adm-letter-filter-item,
[data-theme="dark"] .adm-letter-filter-item {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    color: #cbd5e1 !important;
}
html.dark-mode .adm-letter-filter-item:hover,
body.dark-mode .adm-letter-filter-item:hover,
[data-theme="dark"] .adm-letter-filter-item:hover {
    background: #1e2535 !important;
    border-color: #38bdf8 !important;
    color: #38bdf8 !important;
}
html.dark-mode .adm-letter-filter-item.active,
body.dark-mode .adm-letter-filter-item.active,
[data-theme="dark"] .adm-letter-filter-item.active {
    background: rgba(14, 165, 233, 0.2) !important;
    border-color: #38bdf8 !important;
    color: #38bdf8 !important;
}

html.dark-mode .adm-modal-cat-pill,
body.dark-mode .adm-modal-cat-pill,
[data-theme="dark"] .adm-modal-cat-pill {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
    color: #94a3b8 !important;
}
html.dark-mode .adm-modal-cat-pill.active,
body.dark-mode .adm-modal-cat-pill.active,
[data-theme="dark"] .adm-modal-cat-pill.active {
    background: #0ea5e9 !important;
    color: #ffffff !important;
}

html.dark-mode .pagination .page-link,
body.dark-mode .pagination .page-link,
[data-theme="dark"] .pagination .page-link {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    color: #cbd5e1 !important;
}
html.dark-mode .pagination .page-item.active .page-link,
body.dark-mode .pagination .page-item.active .page-link,
[data-theme="dark"] .pagination .page-item.active .page-link {
    background: #0ea5e9 !important;
    border-color: #0ea5e9 !important;
    color: #ffffff !important;
}

/* ── Mobile Responsive Overrides ─────────────────────────── */
@media (max-width: 767.98px) {
    .adm-status-pills-wrap {
        padding-bottom: 0.5rem;
        -webkit-overflow-scrolling: touch;
    }
    .adm-kpi-card {
        padding: 0.85rem 1rem;
        border-radius: 14px;
    }
    .adm-filter-card {
        padding: 0.85rem;
        border-radius: 14px;
    }
    .adm-table th,
    .adm-table td {
        padding: 0.75rem 0.85rem;
    }
}

/* ============================================================
   FLATPICKR UNIVERSAL DARK MODE ENGINE
   ============================================================ */
html.dark-mode .flatpickr-calendar,
body.dark-mode .flatpickr-calendar,
[data-theme="dark"] .flatpickr-calendar,
.dark-mode .flatpickr-calendar {
    background: #1e2535 !important;
    border: 1.5px solid rgba(255, 255, 255, 0.12) !important;
    box-shadow: 0 16px 36px rgba(0, 0, 0, 0.45) !important;
    color: #f1f5f9 !important;
}

html.dark-mode .flatpickr-calendar.arrowTop:before,
html.dark-mode .flatpickr-calendar.arrowTop:after,
body.dark-mode .flatpickr-calendar.arrowTop:before,
body.dark-mode .flatpickr-calendar.arrowTop:after,
[data-theme="dark"] .flatpickr-calendar.arrowTop:before,
[data-theme="dark"] .flatpickr-calendar.arrowTop:after {
    border-bottom-color: #1e2535 !important;
}
html.dark-mode .flatpickr-calendar.arrowBottom:before,
html.dark-mode .flatpickr-calendar.arrowBottom:after,
body.dark-mode .flatpickr-calendar.arrowBottom:before,
body.dark-mode .flatpickr-calendar.arrowBottom:after,
[data-theme="dark"] .flatpickr-calendar.arrowBottom:before,
[data-theme="dark"] .flatpickr-calendar.arrowBottom:after {
    border-top-color: #1e2535 !important;
}

html.dark-mode .flatpickr-months,
body.dark-mode .flatpickr-months,
[data-theme="dark"] .flatpickr-months {
    background: #161b26 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    color: #f1f5f9 !important;
}
html.dark-mode .flatpickr-months .flatpickr-month,
body.dark-mode .flatpickr-months .flatpickr-month,
[data-theme="dark"] .flatpickr-months .flatpickr-month {
    color: #f1f5f9 !important;
    fill: #f1f5f9 !important;
}
html.dark-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
body.dark-mode .flatpickr-current-month .flatpickr-monthDropdown-months,
[data-theme="dark"] .flatpickr-current-month .flatpickr-monthDropdown-months {
    background: #161b26 !important;
    color: #f1f5f9 !important;
}
html.dark-mode .flatpickr-current-month input.cur-year,
body.dark-mode .flatpickr-current-month input.cur-year,
[data-theme="dark"] .flatpickr-current-month input.cur-year {
    color: #f1f5f9 !important;
}
html.dark-mode .flatpickr-months .flatpickr-prev-month,
html.dark-mode .flatpickr-months .flatpickr-next-month,
body.dark-mode .flatpickr-months .flatpickr-prev-month,
body.dark-mode .flatpickr-months .flatpickr-next-month,
[data-theme="dark"] .flatpickr-months .flatpickr-prev-month,
[data-theme="dark"] .flatpickr-months .flatpickr-next-month {
    color: #94a3b8 !important;
    fill: #94a3b8 !important;
}
html.dark-mode .flatpickr-months .flatpickr-prev-month:hover,
html.dark-mode .flatpickr-months .flatpickr-next-month:hover,
body.dark-mode .flatpickr-months .flatpickr-prev-month:hover,
body.dark-mode .flatpickr-months .flatpickr-next-month:hover,
[data-theme="dark"] .flatpickr-months .flatpickr-prev-month:hover,
[data-theme="dark"] .flatpickr-months .flatpickr-next-month:hover {
    color: #38bdf8 !important;
    fill: #38bdf8 !important;
}

html.dark-mode span.flatpickr-weekday,
body.dark-mode span.flatpickr-weekday,
[data-theme="dark"] span.flatpickr-weekday {
    background: #161b26 !important;
    color: #94a3b8 !important;
    font-weight: 700 !important;
}

html.dark-mode .flatpickr-day,
body.dark-mode .flatpickr-day,
[data-theme="dark"] .flatpickr-day {
    color: #e2e8f0 !important;
    border-color: transparent !important;
}
html.dark-mode .flatpickr-day:hover,
body.dark-mode .flatpickr-day:hover,
[data-theme="dark"] .flatpickr-day:hover {
    background: #252b3b !important;
    border-color: #38bdf8 !important;
    color: #38bdf8 !important;
}
html.dark-mode .flatpickr-day.today,
body.dark-mode .flatpickr-day.today,
[data-theme="dark"] .flatpickr-day.today {
    border-color: #0ea5e9 !important;
    background: rgba(14, 165, 233, 0.15) !important;
    color: #38bdf8 !important;
}
html.dark-mode .flatpickr-day.selected,
html.dark-mode .flatpickr-day.startRange,
html.dark-mode .flatpickr-day.endRange,
body.dark-mode .flatpickr-day.selected,
body.dark-mode .flatpickr-day.startRange,
body.dark-mode .flatpickr-day.endRange,
[data-theme="dark"] .flatpickr-day.selected,
[data-theme="dark"] .flatpickr-day.startRange,
[data-theme="dark"] .flatpickr-day.endRange {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    border-color: #0ea5e9 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.4) !important;
}
html.dark-mode .flatpickr-day.inRange,
body.dark-mode .flatpickr-day.inRange,
[data-theme="dark"] .flatpickr-day.inRange {
    background: rgba(14, 165, 233, 0.2) !important;
    border-color: transparent !important;
    color: #38bdf8 !important;
    box-shadow: -5px 0 0 rgba(14, 165, 233, 0.2), 5px 0 0 rgba(14, 165, 233, 0.2) !important;
}
html.dark-mode .flatpickr-day.prevMonthDay,
html.dark-mode .flatpickr-day.nextMonthDay,
html.dark-mode .flatpickr-day.flatpickr-disabled,
body.dark-mode .flatpickr-day.prevMonthDay,
body.dark-mode .flatpickr-day.nextMonthDay,
body.dark-mode .flatpickr-day.flatpickr-disabled,
[data-theme="dark"] .flatpickr-day.prevMonthDay,
[data-theme="dark"] .flatpickr-day.nextMonthDay,
[data-theme="dark"] .flatpickr-day.flatpickr-disabled {
    color: #475569 !important;
    background: transparent !important;
}

html.dark-mode .flatpickr-time,
body.dark-mode .flatpickr-time,
[data-theme="dark"] .flatpickr-time {
    background: #161b26 !important;
    border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
}
html.dark-mode .flatpickr-time input,
body.dark-mode .flatpickr-time input,
[data-theme="dark"] .flatpickr-time input {
    color: #f1f5f9 !important;
    background: transparent !important;
}
html.dark-mode .flatpickr-time .flatpickr-time-separator,
body.dark-mode .flatpickr-time .flatpickr-time-separator,
[data-theme="dark"] .flatpickr-time .flatpickr-time-separator {
    color: #94a3b8 !important;
}
html.dark-mode .flatpickr-time .flatpickr-am-pm,
body.dark-mode .flatpickr-time .flatpickr-am-pm,
[data-theme="dark"] .flatpickr-time .flatpickr-am-pm {
    color: #38bdf8 !important;
    background: transparent !important;
}
</style>