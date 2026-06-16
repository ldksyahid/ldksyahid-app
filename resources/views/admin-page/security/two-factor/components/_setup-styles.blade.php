<style>
/* ── Base ───────────────────────────────────────────────────────── */
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
.section-title.danger {
    color: #dc3545;
    border-bottom-color: #f8d7da;
}
.card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
.form-label.fw-bold { color: #495057; font-weight: 600; }
.form-control:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 .2rem rgba(0,167,157,.25);
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
.text-brand { color: #00a79d; }

/* ── 2FA specific ────────────────────────────────────────────────── */
.qr-wrapper {
    display: flex;
    justify-content: center;
    padding: 1rem 0;
}
.qr-wrapper svg {
    border: 8px solid #fff;
    border-radius: 8px;
    box-shadow: 0 2px 12px rgba(0,0,0,.12);
}
.secret-key {
    font-family: 'Courier New', monospace;
    font-size: 1.1rem;
    letter-spacing: .15em;
    color: #00a79d;
    font-weight: 700;
    background: #f0fffe;
    padding: .6rem 1rem;
    border-radius: 8px;
    border: 1px dashed #00a79d;
    text-align: center;
    word-break: break-all;
}
.otp-input {
    font-size: 1.5rem;
    font-weight: 700;
    letter-spacing: .4em;
    text-align: center;
    border-radius: 8px;
    border: 2px solid #ced4da;
    max-width: 220px;
    padding: .4rem 1rem;
}
.otp-input:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 .2rem rgba(0,167,157,.25);
    outline: none;
}
.status-badge-active {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: #198754;
    background: #d1fae5;
    padding: .5rem 1.25rem;
    border-radius: 50px;
    border: 1px solid #6ee7b7;
}
.step-list { padding-left: 1.5rem; }
.step-list li { margin-bottom: .5rem; color: #495057; }

/* ── Dark mode ──────────────────────────────────────────────────── */
html.dark-mode .page-title { color: #2dd4bf; }
html.dark-mode .page-title .highlighted-text { color: #14b8a6; }
html.dark-mode .page-title small { color: #9ca3af; }
html.dark-mode .section-title { color: #2dd4bf; border-bottom-color: rgba(45,212,191,.15); }
html.dark-mode .section-title.danger { color: #f87171; border-bottom-color: rgba(248,113,113,.15); }
html.dark-mode .card { background-color: #1f2937; box-shadow: 0 4px 12px rgba(0,0,0,.3); }
html.dark-mode .form-label.fw-bold { color: #9ca3af; }
html.dark-mode .form-control {
    background-color: #374151;
    border-color: #4b5563;
    color: #e5e7eb;
}
html.dark-mode .form-control::placeholder { color: #6b7280; }
html.dark-mode .form-control:focus {
    border-color: #2dd4bf;
    box-shadow: 0 0 0 .2rem rgba(45,212,191,.2);
    background-color: #374151;
    color: #e5e7eb;
}
html.dark-mode .btn-custom-primary { background-color: #00a79d; border-color: #00a79d; color: #fff; }
html.dark-mode .btn-custom-primary:hover { background-color: #008b84; border-color: #008b84; }
html.dark-mode .btn-outline-secondary { color: #9ca3af; border-color: #4b5563; }
html.dark-mode .btn-outline-secondary:hover { background-color: #374151; color: #e5e7eb; }
html.dark-mode .text-brand { color: #2dd4bf; }
html.dark-mode small.text-muted, html.dark-mode .text-muted { color: #9ca3af !important; }
html.dark-mode .table { color: #e5e7eb; }
html.dark-mode .table-light th { background-color: #374151 !important; color: #d1d5db; }
html.dark-mode .table-hover tbody tr:hover td { background-color: rgba(255,255,255,.04); }
html.dark-mode .alert-warning {
    background-color: rgba(234,179,8,.1);
    border-color: rgba(234,179,8,.3);
    color: #fde68a;
}
html.dark-mode .alert-warning a { color: #fbbf24; }
html.dark-mode code { color: #2dd4bf; background-color: rgba(45,212,191,.1); padding: 0 4px; border-radius: 3px; }
html.dark-mode .badge.bg-success { background-color: rgba(34,197,94,.2) !important; color: #4ade80 !important; }
html.dark-mode .badge.bg-secondary { background-color: rgba(107,114,128,.2) !important; color: #9ca3af !important; }
html.dark-mode .btn-danger { background-color: #dc2626; border-color: #dc2626; }
html.dark-mode .btn-danger:hover { background-color: #b91c1c; border-color: #b91c1c; }
/* 2FA-specific dark mode */
html.dark-mode .qr-wrapper svg { border-color: #1f2937; box-shadow: 0 2px 12px rgba(0,0,0,.5); }
html.dark-mode .secret-key {
    background: rgba(45,212,191,.07);
    border-color: #2dd4bf;
    color: #2dd4bf;
}
html.dark-mode .otp-input {
    background-color: #374151;
    border-color: #4b5563;
    color: #e5e7eb;
}
html.dark-mode .otp-input:focus {
    border-color: #2dd4bf;
    box-shadow: 0 0 0 .2rem rgba(45,212,191,.2);
    background-color: #374151;
}
html.dark-mode .status-badge-active {
    background: rgba(34,197,94,.1);
    border-color: rgba(34,197,94,.3);
    color: #4ade80;
}
html.dark-mode .step-list li { color: #9ca3af; }

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .otp-input { font-size: 1.2rem; letter-spacing: .25em; max-width: 100%; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
}
</style>
