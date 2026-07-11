<style>
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
.page-title::after {
    content: '';
    display: block;
    height: 4px;
    width: 120px;
    margin: .35rem auto 0;
    border-radius: 3px;
    background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
}
.page-title small {
    color: #6c757d;
    font-size: .85rem;
    font-weight: 400;
    display: block;
    margin-top: .4rem;
}
.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #00a79d;
    padding-bottom: .5rem;
    border-bottom: 2px solid #e0f7f5;
}
.card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
.form-label.fw-bold { color: #495057; font-weight: 600; }
.form-control-plaintext {
    padding: .375rem 0;
    line-height: 1.5;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
    min-height: 38px;
    display: flex;
    align-items: center;
    word-break: break-word;
}
.btn-custom-primary {
    color: #fff;
    background-color: #00a79d;
    border: 1px solid #00a79d;
    transition: all .3s ease;
}
.btn-custom-primary:hover, .btn-custom-primary:focus {
    background-color: #008b84;
    border-color: #008b84;
    color: #fff;
    box-shadow: 0 0 0 .2rem rgba(0,167,157,.25);
}
.bisabiller-badge {
    background: linear-gradient(135deg, #00a79d, #008b84);
    color: #fff;
    border-radius: 12px;
    padding: 1rem 1.5rem;
}
.stat-value {
    font-size: 1.3rem;
    font-weight: 700;
    color: #00a79d;
}
.stat-value.available {
    font-size: 1.5rem;
    color: #198754;
}
.balance-divider {
    border-top: 2px dashed #e0f7f5;
    margin: .75rem 0;
}
.withdrawal-badge {
    font-size: .85rem;
    padding: .35em .65em;
}
.text-brand { color: #00a79d; }
html.dark-mode .text-brand { color: #2dd4bf; }
.btn-balance-report {
    display: inline-flex;
    align-items: center;
    color: #fff;
    background: linear-gradient(135deg, #00a79d, #008b84);
    border: none;
    border-radius: 6px;
    font-size: .78rem;
    font-weight: 600;
    padding: .3rem .75rem;
    box-shadow: 0 2px 6px rgba(0,167,157,.3);
    transition: all .25s ease;
    white-space: nowrap;
    text-decoration: none;
}
.btn-balance-report:hover {
    background: linear-gradient(135deg, #008b84, #006f6a);
    color: #fff;
    box-shadow: 0 4px 10px rgba(0,167,157,.4);
    transform: translateY(-1px);
    text-decoration: none;
}
html.dark-mode .btn-balance-report { background: linear-gradient(135deg, #008b84, #006f6a); }
html.dark-mode .btn-balance-report:hover { background: linear-gradient(135deg, #006f6a, #005a56); }

/* ── Finance boxes ──────────────────────────────────── */
.finance-box-online {
    background: #f0fdfc;
    border: 1px solid #e0f7f5;
}
.finance-box-online-title { color: #00a79d; }
.finance-box-offline {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
}
.finance-box-offline-title { color: #6c757d; }
.balance-divider-muted { border-top-color: #dee2e6; }

/* ── Withdrawal History Table ───────────────────────── */
.wd-table { font-size: .875rem; }
.wd-table thead th {
    font-weight: 600;
    color: #00a79d;
    border-bottom: 2px solid #e0f7f5;
    white-space: nowrap;
    padding: .7rem .75rem;
    background: rgba(0,167,157,.04);
    border-top: none;
}
.wd-table tbody td { padding: .75rem .75rem; vertical-align: middle; }
.wd-table tbody tr { border-bottom: 1px solid #f0f0f0; transition: background .15s; }
.wd-table tbody tr:hover { background: rgba(0,167,157,.04); }
.wd-table tbody tr:last-child { border-bottom: none; }
.wd-table tbody tr.wd-row-failed { opacity: .8; }
.wd-amount {
    font-weight: 700;
    color: #00a79d;
    font-size: .9rem;
}
.wd-bank-chip {
    display: inline-block;
    background: #e0f7f5;
    color: #008b84;
    font-size: .7rem;
    font-weight: 700;
    padding: .2em .65em;
    border-radius: 50px;
    letter-spacing: .04em;
    text-transform: uppercase;
}
.wd-account { font-size: .82rem; color: #495057; }
.wd-status-COMPLETED { background: rgba(25,135,84,.12) !important; color: #146c43 !important; border: 1px solid rgba(25,135,84,.25) !important; }
.wd-status-PENDING   { background: rgba(255,193,7,.15) !important; color: #856404 !important; border: 1px solid rgba(255,193,7,.3) !important; }
.wd-status-FAILED    { background: rgba(220,53,69,.12) !important; color: #b02a37 !important; border: 1px solid rgba(220,53,69,.25) !important; }
.wd-status-default   { background: rgba(108,117,125,.12) !important; color: #495057 !important; border: 1px solid rgba(108,117,125,.2) !important; }
.wd-badge {
    display: inline-flex;
    align-items: center;
    gap: .3em;
    font-size: .75rem;
    font-weight: 700;
    padding: .3em .7em;
    border-radius: 50px;
    letter-spacing: .03em;
    text-transform: uppercase;
}

/* ── Dark mode ──────────────────────────────────────── */
html.dark-mode .page-title { color: #2dd4bf; }
html.dark-mode .page-title .highlighted-text { color: #14b8a6; }
html.dark-mode .section-title { color: #2dd4bf; border-bottom-color: rgba(45,212,191,.15); }
html.dark-mode .card {
    background-color: #1f2937;
    box-shadow: 0 4px 12px rgba(0,0,0,.3);
}
html.dark-mode .form-label.fw-bold { color: #9ca3af; }
html.dark-mode .form-control-plaintext { color: #e5e7eb; }
html.dark-mode .bisabiller-badge { background: linear-gradient(135deg,#008b84,#006f6a); }
html.dark-mode .stat-value { color: #2dd4bf; }
html.dark-mode .stat-value.available { color: #4ade80; }
html.dark-mode .balance-divider { border-top-color: rgba(45,212,191,.2); }
html.dark-mode .balance-divider-muted { border-top-color: rgba(255,255,255,.1); }
html.dark-mode .finance-box-online {
    background: rgba(0,167,157,.1);
    border-color: rgba(0,167,157,.25);
}
html.dark-mode .finance-box-online-title { color: #2dd4bf; }
html.dark-mode .finance-box-offline {
    background: rgba(255,255,255,.04);
    border-color: rgba(255,255,255,.1);
}
html.dark-mode .finance-box-offline-title { color: #9ca3af; }
html.dark-mode .btn-custom-primary {
    background-color: #00a79d;
    border-color: #00a79d;
    color: #fff;
}
html.dark-mode .btn-custom-primary:hover {
    background-color: #008b84;
    border-color: #008b84;
}
html.dark-mode .btn-outline-secondary {
    color: #9ca3af;
    border-color: #4b5563;
}
html.dark-mode .btn-outline-secondary:hover {
    background-color: #374151;
    color: #e5e7eb;
}
html.dark-mode .border-top { border-color: rgba(255,255,255,.1) !important; }
html.dark-mode .table { color: #e5e7eb; }
html.dark-mode .table-light th { background-color: #374151; color: #d1d5db; }
html.dark-mode .table-hover tbody tr:hover { background-color: rgba(255,255,255,.05); }
html.dark-mode .badge.bg-secondary { background-color: #4b5563 !important; }
html.dark-mode small.text-muted, html.dark-mode .text-muted { color: #9ca3af !important; }
html.dark-mode .withdrawal-badge { opacity: .9; }
html.dark-mode .wd-table thead th { background: rgba(45,212,191,.06); color: #2dd4bf; border-bottom-color: rgba(45,212,191,.2); }
html.dark-mode .wd-table tbody tr { border-bottom-color: rgba(255,255,255,.06); }
html.dark-mode .wd-table tbody tr:hover { background: rgba(45,212,191,.06); }
html.dark-mode .wd-amount { color: #2dd4bf; }
html.dark-mode .wd-bank-chip { background: rgba(45,212,191,.15); color: #2dd4bf; }
html.dark-mode .wd-account { color: #9ca3af; }
html.dark-mode .wd-status-COMPLETED { background: rgba(34,197,94,.15) !important; color: #4ade80 !important; border-color: rgba(34,197,94,.3) !important; }
html.dark-mode .wd-status-PENDING   { background: rgba(251,191,36,.15) !important; color: #fbbf24 !important; border-color: rgba(251,191,36,.3) !important; }
html.dark-mode .wd-status-FAILED    { background: rgba(239,68,68,.15) !important; color: #f87171 !important; border-color: rgba(239,68,68,.3) !important; }
html.dark-mode .wd-status-default   { background: rgba(156,163,175,.1) !important; color: #9ca3af !important; border-color: rgba(156,163,175,.2) !important; }

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .stat-value { font-size: 1.1rem; }
    .stat-value.available { font-size: 1.25rem; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
}
</style>
