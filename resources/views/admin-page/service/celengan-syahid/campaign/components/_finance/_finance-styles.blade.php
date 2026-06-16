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

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .stat-value { font-size: 1.1rem; }
    .stat-value.available { font-size: 1.25rem; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
}
</style>
