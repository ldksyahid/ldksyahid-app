{{-- Path: resources/views/admin-page/service-request/persuratan/components/_show-styles.blade.php --}}
<style>
/* ================================================================
   ADMIN PERSURATAN SHOW — Details, Approval & Full Dark Mode Engine
   ================================================================ */
.adm-letter-container {
    padding: 1.5rem 0.5rem;
}
.adm-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.2s ease;
}
.adm-card-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.85rem;
    border-bottom: 1px solid #e2e8f0;
}
.adm-card-header h5,
.adm-card-header h6 {
    margin: 0;
    font-weight: 800;
    color: #0f172a;
}

/* Header Icons */
.adm-header-icon {
    width: 36px;
    height: 36px;
    min-width: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}
.adm-header-icon.primary { background-color: #e0f2fe; color: #0284c7; }
.adm-header-icon.success { background-color: #d1fae5; color: #059669; }
.adm-header-icon.danger  { background-color: #fee2e2; color: #dc2626; }
.adm-header-icon.warning { background-color: #fef3c7; color: #d97706; }

/* Detail Table */
.adm-detail-table {
    width: 100%;
}
.adm-detail-table tr {
    border-bottom: 1px solid #f1f5f9;
}
.adm-detail-table tr:last-child {
    border-bottom: none;
}
.adm-detail-table td {
    padding: 0.8rem 0;
    vertical-align: top;
    font-size: 0.88rem;
}
.adm-detail-label {
    width: 38%;
    font-weight: 700;
    color: #64748b;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding-right: 1rem;
}
.adm-detail-val {
    color: #0f172a;
    font-weight: 600;
}

/* Badges */
.adm-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.35rem 0.75rem;
    border-radius: 50rem;
    font-size: 0.75rem;
    font-weight: 700;
}
.adm-badge-success { background-color: #dcfce7 !important; color: #15803d !important; border: 1px solid #86efac !important; }
.adm-badge-warning { background-color: #fef3c7 !important; color: #b45309 !important; border: 1px solid #fcd34d !important; }
.adm-badge-danger  { background-color: #fee2e2 !important; color: #b91c1c !important; border: 1px solid #fca5a5 !important; }
.adm-badge-neutral { background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #cbd5e1 !important; }

/* Action Panels */
.adm-action-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1rem;
}

/* Trigger Box for Department */
.adm-type-picker-btn {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    min-height: 42px;
    padding: 0.5rem 0.95rem;
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

/* Modal Selector Items */
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
    --adm-card-bg: #1e2535;
    --adm-input-bg: #252b3b;
    --adm-border:   rgba(255, 255, 255, 0.08);
}

html.dark-mode .adm-card,
body.dark-mode .adm-card,
[data-theme="dark"] .adm-card,
html.dark-mode .modal-content,
body.dark-mode .modal-content,
[data-theme="dark"] .modal-content {
    background: #1e2535 !important;
    border-color: rgba(255, 255, 255, 0.08) !important;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3) !important;
    color: #cbd5e1 !important;
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

html.dark-mode .text-success,
body.dark-mode .text-success,
[data-theme="dark"] .text-success {
    color: #34d399 !important;
}

html.dark-mode .text-danger,
body.dark-mode .text-danger,
[data-theme="dark"] .text-danger {
    color: #f87171 !important;
}

html.dark-mode .text-primary,
body.dark-mode .text-primary,
[data-theme="dark"] .text-primary {
    color: #38bdf8 !important;
}

html.dark-mode .text-warning,
body.dark-mode .text-warning,
[data-theme="dark"] .text-warning {
    color: #fbbf24 !important;
}

html.dark-mode .adm-header-icon.primary,
body.dark-mode .adm-header-icon.primary,
[data-theme="dark"] .adm-header-icon.primary {
    background-color: rgba(14, 165, 233, 0.2) !important;
    color: #38bdf8 !important;
}

html.dark-mode .adm-header-icon.success,
body.dark-mode .adm-header-icon.success,
[data-theme="dark"] .adm-header-icon.success {
    background-color: rgba(16, 185, 129, 0.2) !important;
    color: #34d399 !important;
}

html.dark-mode .adm-header-icon.danger,
body.dark-mode .adm-header-icon.danger,
[data-theme="dark"] .adm-header-icon.danger {
    background-color: rgba(239, 68, 68, 0.2) !important;
    color: #f87171 !important;
}

html.dark-mode .adm-card-header,
body.dark-mode .adm-card-header,
[data-theme="dark"] .adm-card-header,
html.dark-mode .modal-header,
body.dark-mode .modal-header,
[data-theme="dark"] .modal-header,
html.dark-mode .modal-footer,
body.dark-mode .modal-footer,
[data-theme="dark"] .modal-footer {
    border-bottom-color: rgba(255, 255, 255, 0.08) !important;
}

html.dark-mode .adm-card-header h5,
html.dark-mode .adm-card-header h6,
body.dark-mode .adm-card-header h5,
body.dark-mode .adm-card-header h6,
[data-theme="dark"] .adm-card-header h5,
[data-theme="dark"] .adm-card-header h6 {
    color: #f1f5f9 !important;
}

html.dark-mode .adm-detail-table tr,
body.dark-mode .adm-detail-table tr,
[data-theme="dark"] .adm-detail-table tr {
    border-bottom-color: rgba(255, 255, 255, 0.06) !important;
}

html.dark-mode .adm-detail-label,
body.dark-mode .adm-detail-label,
[data-theme="dark"] .adm-detail-label {
    color: #94a3b8 !important;
}

html.dark-mode .adm-detail-val,
body.dark-mode .adm-detail-val,
[data-theme="dark"] .adm-detail-val {
    color: #f1f5f9 !important;
}

html.dark-mode .adm-action-box,
body.dark-mode .adm-action-box,
[data-theme="dark"] .adm-action-box {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.1) !important;
    color: #cbd5e1 !important;
}

html.dark-mode .adm-type-picker-btn,
body.dark-mode .adm-type-picker-btn,
[data-theme="dark"] .adm-type-picker-btn {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.12) !important;
    color: #f1f5f9 !important;
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
body.dark-mode .form-control,
body.dark-mode .form-select,
[data-theme="dark"] .form-control,
[data-theme="dark"] .form-select {
    background-color: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.12) !important;
    color: #f1f5f9 !important;
}
html.dark-mode .form-control::placeholder,
body.dark-mode .form-control::placeholder,
[data-theme="dark"] .form-control::placeholder {
    color: #64748b !important;
}

/* Custom Radio in Dark Mode */
html.dark-mode .custom-control-label,
body.dark-mode .custom-control-label,
[data-theme="dark"] .custom-control-label {
    color: #e2e8f0 !important;
}
html.dark-mode .custom-control-label::before,
body.dark-mode .custom-control-label::before,
[data-theme="dark"] .custom-control-label::before {
    background-color: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.2) !important;
}
html.dark-mode .custom-control-input:checked ~ .custom-control-label::before,
body.dark-mode .custom-control-input:checked ~ .custom-control-label::before,
[data-theme="dark"] .custom-control-input:checked ~ .custom-control-label::before {
    background-color: #0ea5e9 !important;
    border-color: #0ea5e9 !important;
}

/* Alerts in Dark Mode */
html.dark-mode .adm-alert-success,
body.dark-mode .adm-alert-success,
[data-theme="dark"] .adm-alert-success {
    background-color: rgba(16, 185, 129, 0.15) !important;
    border: 1px solid rgba(16, 185, 129, 0.35) !important;
    color: #6ee7b7 !important;
}
html.dark-mode .adm-alert-danger,
body.dark-mode .adm-alert-danger,
[data-theme="dark"] .adm-alert-danger {
    background-color: rgba(239, 68, 68, 0.15) !important;
    border: 1px solid rgba(239, 68, 68, 0.35) !important;
    color: #fca5a5 !important;
}

/* Document Verification Token Code */
html.dark-mode code.text-primary,
body.dark-mode code.text-primary,
[data-theme="dark"] code.text-primary {
    background-color: #161b26 !important;
    color: #38bdf8 !important;
    border: 1px solid rgba(14, 165, 233, 0.3) !important;
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

html.dark-mode .btn-outline-danger,
body.dark-mode .btn-outline-danger,
[data-theme="dark"] .btn-outline-danger {
    background: #1e2535 !important;
    border-color: rgba(239, 68, 68, 0.4) !important;
    color: #f87171 !important;
}
html.dark-mode .btn-outline-danger:hover,
body.dark-mode .btn-outline-danger:hover,
[data-theme="dark"] .btn-outline-danger:hover {
    background: #ef4444 !important;
    color: #ffffff !important;
}

html.dark-mode .btn-success,
body.dark-mode .btn-success,
[data-theme="dark"] .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
    border: none !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35) !important;
}

html.dark-mode .btn-primary,
body.dark-mode .btn-primary,
[data-theme="dark"] .btn-primary {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%) !important;
    border: none !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35) !important;
}

html.dark-mode .btn-outline-secondary,
body.dark-mode .btn-outline-secondary,
[data-theme="dark"] .btn-outline-secondary {
    background: #252b3b !important;
    border-color: rgba(255, 255, 255, 0.15) !important;
    color: #cbd5e1 !important;
}
html.dark-mode .btn-outline-secondary:hover,
body.dark-mode .btn-outline-secondary:hover,
[data-theme="dark"] .btn-outline-secondary:hover {
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

/* ── Mobile Responsive Overrides ─────────────────────────── */
@media (max-width: 575.98px) {
    .adm-card {
        padding: 1.15rem 1rem;
        border-radius: 14px;
    }
    .adm-detail-table tr {
        display: flex;
        flex-direction: column;
        padding: 0.55rem 0;
        gap: 0.25rem;
    }
    .adm-detail-table td {
        display: block;
        width: 100% !important;
        padding: 0;
    }
    .adm-detail-label {
        font-size: 0.74rem;
        margin-bottom: 0.15rem;
    }
    .adm-action-box {
        padding: 0.75rem;
    }
}
</style>