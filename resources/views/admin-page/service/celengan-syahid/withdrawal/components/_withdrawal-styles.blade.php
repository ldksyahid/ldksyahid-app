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
html.dark-mode .wd-bank-chip { background: rgba(45,212,191,.15); color: #2dd4bf; }
.wd-account { font-size: .78rem; color: #6b7280; }
html.dark-mode .wd-account { color: #9ca3af; }
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

/* ── Alert dark mode refinements ────────────────────────── */

/* X button: Bootstrap uses a black SVG by default — invert to white in dark mode */
html.dark-mode .alert .btn-close {
    filter: invert(1) brightness(1.8);
    opacity: .7;
}
html.dark-mode .alert .btn-close:hover { opacity: 1; }

/* Inquiry success card inner text */
html.dark-mode .alert-success .text-muted,
html.dark-mode .alert-success small.text-muted { color: #6ee7b7 !important; }
html.dark-mode .alert-success .fw-semibold { color: #d1fae5; }

/* Inquiry error card inner text */
html.dark-mode .alert-danger .text-muted,
html.dark-mode .alert-danger small.text-muted  { color: #fca5a5 !important; }
html.dark-mode .alert-danger .fw-semibold  { color: #fee2e2; }
html.dark-mode .alert-danger .text-danger  { color: #f87171 !important; }

/* Warning alert inner text */
html.dark-mode .alert-warning .fw-semibold { color: #fef08a; }

/* ── Net breakdown box ──────────────────────────────── */
.net-breakdown-box {
    background: rgba(0,167,157,.06);
    border: 1px solid rgba(0,167,157,.2);
    border-radius: 8px;
    padding: .75rem 1rem;
    font-size: .875rem;
}
.net-breakdown-box hr { border-color: rgba(0,167,157,.2); }
html.dark-mode .net-breakdown-box {
    background: rgba(0,167,157,.08);
    border-color: rgba(0,167,157,.25);
    color: #d1d5db;
}
html.dark-mode .net-breakdown-box hr { border-color: rgba(0,167,157,.2); }

/* ── Withdrawal Index Table ─────────────────────────── */
.wi-table { font-size: .875rem; }
.wi-table thead th {
    font-weight: 600;
    color: #00a79d;
    border-bottom: 2px solid #e0f7f5;
    white-space: nowrap;
    padding: .7rem .75rem;
    background: rgba(0,167,157,.04);
    border-top: none;
}
.wi-table tbody td { padding: .75rem .75rem; vertical-align: middle; }
.wi-table tbody tr { border-bottom: 1px solid #f0f0f0; transition: background .15s; }
.wi-table tbody tr:hover { background: rgba(0,167,157,.04); }
.wi-table tbody tr:last-child { border-bottom: none; }

html.dark-mode .wi-table thead th { background: rgba(45,212,191,.06); color: #2dd4bf; border-bottom-color: rgba(45,212,191,.2); }
html.dark-mode .wi-table tbody tr { border-bottom-color: rgba(255,255,255,.06); }
html.dark-mode .wi-table tbody tr:hover { background: rgba(45,212,191,.06); }

/* ── Campaign link in table ─────────────────────────── */
.wi-campaign-link {
    font-weight: 600;
    font-size: .85rem;
    color: #00a79d;
    max-width: 200px;
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: middle;
}
.wi-campaign-link:hover { color: #008b84; text-decoration: underline; }
html.dark-mode .wi-campaign-link { color: #2dd4bf; }
html.dark-mode .wi-campaign-link:hover { color: #5eead4; }

/* ── Filter card ────────────────────────────────────── */
.wi-filter-card {
    background: rgba(0,167,157,.03);
    border: 1px solid rgba(0,167,157,.12) !important;
}
html.dark-mode .wi-filter-card {
    background: rgba(45,212,191,.04);
    border-color: rgba(45,212,191,.12) !important;
}
.wi-clear-btn {
    display: inline-flex;
    align-items: center;
    gap: .3em;
    font-size: .78rem;
    font-weight: 600;
    color: #6b7280;
    background: none;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    padding: .28rem .65rem;
    cursor: pointer;
    transition: all .2s;
    text-decoration: none;
    white-space: nowrap;
}
.wi-clear-btn:hover { color: #ef4444; border-color: #ef4444; background: rgba(239,68,68,.05); }
html.dark-mode .wi-clear-btn { color: #9ca3af; border-color: #374151; }
html.dark-mode .wi-clear-btn:hover { color: #f87171; border-color: #f87171; background: rgba(248,113,113,.08); }

/* ── Active filter chip ─────────────────────────────── */
.wi-filter-chip {
    display: inline-flex;
    align-items: center;
    gap: .35em;
    font-size: .72rem;
    font-weight: 700;
    background: rgba(0,167,157,.1);
    color: #008b84;
    border: 1px solid rgba(0,167,157,.25);
    border-radius: 50px;
    padding: .2em .65em;
}
html.dark-mode .wi-filter-chip { background: rgba(45,212,191,.12); color: #2dd4bf; border-color: rgba(45,212,191,.25); }

/* ── Pagination teal theme ──────────────────────────── */
#withdrawal-pagination .pagination .page-link {
    color: #00a79d;
    border-color: #e0f7f5;
    border-radius: 6px !important;
    margin: 0 2px;
    font-size: .8rem;
    font-weight: 600;
    padding: .35rem .65rem;
    transition: all .15s;
}
#withdrawal-pagination .pagination .page-link:hover { background: #e0f7f5; border-color: #00a79d; }
#withdrawal-pagination .pagination .page-item.active .page-link {
    background: #00a79d;
    border-color: #00a79d;
    color: #fff;
}
#withdrawal-pagination .pagination .page-item.disabled .page-link { color: #adb5bd; border-color: #e9ecef; }
html.dark-mode #withdrawal-pagination .pagination .page-link { color: #2dd4bf; border-color: rgba(45,212,191,.2); background: transparent; }
html.dark-mode #withdrawal-pagination .pagination .page-link:hover { background: rgba(45,212,191,.1); border-color: #2dd4bf; }
html.dark-mode #withdrawal-pagination .pagination .page-item.active .page-link { background: #008b84; border-color: #008b84; color: #fff; }
html.dark-mode #withdrawal-pagination .pagination .page-item.disabled .page-link { color: #4b5563; border-color: rgba(255,255,255,.08); }

/* ── Loading overlay ────────────────────────────────── */
.wi-loading {
    position: relative;
    min-height: 80px;
}
.wi-loading::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,.7);
    border-radius: 8px;
    z-index: 5;
}
html.dark-mode .wi-loading::after { background: rgba(17,24,39,.7); }

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .wi-campaign-link { max-width: 130px; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
}
</style>
