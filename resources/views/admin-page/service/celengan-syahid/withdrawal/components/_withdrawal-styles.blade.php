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
.section-title.danger {
    color: #dc3545;
    border-bottom-color: #f8d7da;
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
.form-control:focus, .form-select:focus {
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
.balance-highlight {
    font-size: 1.4rem;
    font-weight: 700;
    color: #198754;
}
.amount-net {
    font-size: 1.5rem;
    font-weight: 800;
    color: #198754;
}
.inquiry-result { min-height: 40px; }
.text-brand { color: #00a79d; }
html.dark-mode .text-brand { color: #2dd4bf; }
.btn-balance-report {
    color: #fff;
    background: linear-gradient(135deg, #00a79d, #008b84);
    border: none;
    border-radius: 6px;
    font-size: .78rem;
    font-weight: 600;
    padding: .3rem .75rem;
    letter-spacing: .02em;
    box-shadow: 0 2px 6px rgba(0,167,157,.3);
    transition: all .25s ease;
    white-space: nowrap;
}
.btn-balance-report:hover {
    background: linear-gradient(135deg, #008b84, #006f6a);
    color: #fff;
    box-shadow: 0 4px 10px rgba(0,167,157,.4);
    transform: translateY(-1px);
    text-decoration: none;
}
html.dark-mode .btn-balance-report {
    background: linear-gradient(135deg, #008b84, #006f6a);
    box-shadow: 0 2px 6px rgba(0,139,132,.4);
}
html.dark-mode .btn-balance-report:hover {
    background: linear-gradient(135deg, #006f6a, #005a56);
}
.otp-code-input {
    font-size: 1.4rem;
    font-weight: 700;
    letter-spacing: .35em;
    text-align: center;
    max-width: 210px;
    border: 2px solid #ced4da;
    border-radius: 8px;
}
.otp-code-input:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 .2rem rgba(0,167,157,.25);
}
html.dark-mode .otp-code-input {
    color: #e5e7eb;
}
html.dark-mode .otp-code-input:focus {
    border-color: #2dd4bf;
    box-shadow: 0 0 0 .2rem rgba(45,212,191,.2);
}

.btn-verify-account {
    color: #fff;
    background: linear-gradient(135deg, #00a79d, #008b84);
    border: none;
    padding: 0 1.1rem;
    font-weight: 600;
    letter-spacing: .02em;
    white-space: nowrap;
    transition: all .25s ease;
    box-shadow: 0 2px 6px rgba(0,167,157,.35);
}
.btn-verify-account:hover {
    background: linear-gradient(135deg, #008b84, #006f6a);
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,167,157,.45);
    transform: translateY(-1px);
}
.btn-verify-account:disabled {
    background: linear-gradient(135deg, #9ecfcc, #8bbfbc);
    box-shadow: none;
    transform: none;
    cursor: not-allowed;
}
/* ── Select2 ─────────────────────────────────────────── */
.select2-container { z-index: 1; }
.select2-container--open { z-index: 1050; }
.select2-container .select2-selection--single {
    height: calc(2.5rem + 2px);
    padding: 0 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid #ced4da;
    background-color: #fff;
    font-size: 1rem;
    display: flex;
    align-items: center;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #6c757d !important;
    font-weight: 500;
    line-height: calc(2.5rem);
    padding-left: 0;
    padding-right: 40px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    right: 8px; height: 100%; top: 0;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border-color: #00a79d transparent transparent transparent;
    border-width: 6px 5px 0 5px;
}
.select2-dropdown {
    border-radius: 0.5rem;
    border: 1px solid #e8e8e8;
    font-size: 0.95rem;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}
.select2-search--dropdown { padding: 6px; }
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #dee2e6 !important;
    border-radius: 4px !important;
    padding: 6px 10px !important;
    font-size: 0.9rem !important;
    outline: none !important;
    box-shadow: none !important;
}
.select2-container--default .select2-results__option {
    padding: 10px 14px;
    font-size: 0.95rem;
    color: #333;
    border-bottom: 1px solid #e0f2ef;
    cursor: pointer;
}
.select2-results__option:last-child { border-bottom: none; }
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #00a79d !important;
    color: #fff !important;
}
.select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: #e0f7f5 !important;
    color: #008b84 !important;
    font-weight: 600;
}

/* ── Dark mode ──────────────────────────────────────── */
html.dark-mode .page-title { color: #2dd4bf; }
html.dark-mode .page-title .highlighted-text { color: #14b8a6; }
html.dark-mode .section-title { color: #2dd4bf; border-bottom-color: rgba(45,212,191,.15); }
html.dark-mode .section-title.danger { color: #f87171; border-bottom-color: rgba(248,113,113,.15); }
html.dark-mode .card {
    background-color: #1f2937;
    box-shadow: 0 4px 12px rgba(0,0,0,.3);
}
html.dark-mode .form-label.fw-bold { color: #9ca3af; }
html.dark-mode .form-control-plaintext { color: #e5e7eb; }
html.dark-mode .form-control,
html.dark-mode .form-select,
html.dark-mode .input-group-text {
    color: #e2e8f0;
}
html.dark-mode .form-control::placeholder { color: #64748b; }
html.dark-mode .form-control[readonly] {
    color: #94a3b8;
}
html.dark-mode .form-control:focus,
html.dark-mode .form-select:focus {
    border-color: #2dd4bf;
    box-shadow: 0 0 0 .2rem rgba(45,212,191,.15);
    color: #e2e8f0;
}
html.dark-mode .balance-highlight { color: #4ade80; }
html.dark-mode .amount-net { color: #4ade80; }
html.dark-mode .btn-custom-primary {
    background-color: #00a79d;
    border-color: #00a79d;
    color: #fff;
}
html.dark-mode .btn-custom-primary:hover {
    background-color: #008b84;
    border-color: #008b84;
}
html.dark-mode .btn-verify-account {
    background: linear-gradient(135deg, #008b84, #006f6a);
    box-shadow: 0 2px 6px rgba(0,139,132,.35);
}
html.dark-mode .btn-verify-account:hover {
    background: linear-gradient(135deg, #006f6a, #005a56);
}
html.dark-mode .btn-outline-secondary {
    color: #9ca3af;
    border-color: #4b5563;
}
html.dark-mode .btn-outline-secondary:hover {
    color: #e5e7eb;
}
html.dark-mode .btn-secondary {
    color: #e5e7eb;
}
html.dark-mode .table { color: #e5e7eb; }
html.dark-mode .table-light th { background-color: #374151 !important; color: #d1d5db; }
html.dark-mode .table-hover tbody tr:hover td { background-color: rgba(255,255,255,.04); }
html.dark-mode .alert-warning {
    background-color: rgba(234,179,8,.1);
    border-color: rgba(234,179,8,.3);
    color: #fde68a;
}
html.dark-mode .alert-success {
    background-color: rgba(34,197,94,.1);
    border-color: rgba(34,197,94,.3);
    color: #86efac;
}
html.dark-mode .alert-danger {
    background-color: rgba(239,68,68,.1);
    border-color: rgba(239,68,68,.3);
    color: #fca5a5;
}
html.dark-mode small.text-muted,
html.dark-mode .text-muted { color: #9ca3af !important; }
html.dark-mode .fs-4.fw-bold[style*="color:#00a79d"] { color: #2dd4bf !important; }
html.dark-mode code { color: #2dd4bf; background-color: rgba(45,212,191,.1); padding: 0 4px; border-radius: 3px; }
html.dark-mode .border-warning { border-color: rgba(234,179,8,.4) !important; }
html.dark-mode .card.border-0 { border: none !important; }

/* Select2 dark mode */
html.dark-mode .select2-container .select2-selection--single {
    color: #e2e8f0;
}
html.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #e2e8f0 !important;
}
html.dark-mode .select2-dropdown {
    border-color: #334155;
}
html.dark-mode .select2-container--default .select2-search--dropdown .select2-search__field {
    color: #e2e8f0 !important;
}
html.dark-mode .select2-container--default .select2-results__option {
    color: #e2e8f0;
    border-bottom-color: rgba(255,255,255,.05);
}
html.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #008b84 !important;
    color: #fff !important;
}
html.dark-mode .select2-container--default .select2-results__option[aria-selected="true"] {
    background-color: rgba(0,167,157,.2) !important;
    color: #2dd4bf !important;
}

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
}
</style>
