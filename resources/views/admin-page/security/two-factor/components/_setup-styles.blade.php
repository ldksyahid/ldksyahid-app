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

/* ── 2FA stat mini-cards ─────────────────────────────────────────── */
.tfa-stat-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
    padding: 1rem 1.1rem;
    display: flex; align-items: center; gap: 1rem;
    transition: box-shadow .2s;
}
.tfa-stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.12); }
.tfa-stat-icon {
    width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
}
.tfa-icon-active  { background: rgba(5,150,105,.12);  color: #059669; }
.tfa-icon-total   { background: rgba(0,167,157,.12);  color: #00a79d; }
.tfa-icon-pending { background: rgba(107,114,128,.1); color: #6b7280; }
.tfa-stat-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #9ca3af; margin-bottom: 2px; }
.tfa-stat-value { font-size: 1.6rem; font-weight: 700; line-height: 1; color: #111827; }
.tfa-stat-sub   { font-size: .72rem; color: #9ca3af; margin-top: 2px; }
html.dark-mode .tfa-stat-card { background: #2b2f33; box-shadow: 0 2px 10px rgba(0,0,0,.3); }
html.dark-mode .tfa-stat-value { color: #e4e6eb; }
html.dark-mode .tfa-icon-active  { background: rgba(74,222,128,.1); color: #4ade80; }
html.dark-mode .tfa-icon-total   { background: rgba(45,212,191,.1); color: #2dd4bf; }
html.dark-mode .tfa-icon-pending { background: rgba(156,163,175,.08); color: #9ca3af; }

/* ── Table card (audit log style) ──────────────────────────────── */
.tfa-table-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); overflow: hidden;
}
html.dark-mode .tfa-table-card { background: #2b2f33; box-shadow: 0 2px 10px rgba(0,0,0,.3); }

.tfa-table { font-size: .875rem; margin-bottom: 0; }
.tfa-table thead th {
    font-size: .8rem; font-weight: 600; color: #6c757d;
    background: #f8f9fa; border-bottom: 2px solid #e9ecef;
    white-space: nowrap; padding: .65rem .85rem; border-top: none;
}
.tfa-table thead th:first-child { font-weight: 700; color: #495057; }
.tfa-table tbody td { padding: .65rem .85rem; vertical-align: middle; }
.tfa-table tbody tr { transition: background .15s; }
.tfa-table tbody tr:hover > td { background: rgba(0,0,0,.025); }
html.dark-mode .tfa-table thead th { background: #1a1d21; color: #9ca3af; border-bottom-color: #373b3e; }
html.dark-mode .tfa-table thead th:first-child { color: #d1d5db; }
html.dark-mode .tfa-table tbody td { color: #e5e7eb; }
html.dark-mode .tfa-table tbody tr:hover > td { background: rgba(255,255,255,.04); }

/* ── Flat pagination ────────────────────────────────────────────── */
.tfa-table-pagination {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
    padding: .65rem 1rem; border-top: 1px solid #e9ecef; background: #fff;
}
html.dark-mode .tfa-table-pagination { background: #2b2f33; border-top-color: #373b3e; }
.tfa-pg-btn { font-size: .78rem !important; padding: .22rem .6rem !important; border-radius: 6px !important; min-width: 32px; }
.tfa-pg-btn.active { background: #00a79d !important; border-color: #00a79d !important; color: #fff !important; font-weight: 700; }
.tfa-pg-ellipsis { display: inline-flex; align-items: center; padding: 0 .3rem; color: #9ca3af; font-size: .82rem; }
html.dark-mode .tfa-pg-btn.active { background: #008b84 !important; border-color: #008b84 !important; }

/* ── 2FA status badges ──────────────────────────────────────────── */
.tfa-badge-active {
    display: inline-flex; align-items: center; gap: .35em;
    font-size: .73rem; font-weight: 700; padding: .28em .7em;
    border-radius: 50px; white-space: nowrap;
    background: rgba(5,150,105,.12); color: #059669; border: 1px solid rgba(5,150,105,.25);
}
.tfa-badge-inactive {
    display: inline-flex; align-items: center; gap: .35em;
    font-size: .73rem; font-weight: 700; padding: .28em .7em;
    border-radius: 50px; white-space: nowrap;
    background: rgba(107,114,128,.1); color: #6b7280; border: 1px solid rgba(107,114,128,.2);
}
html.dark-mode .tfa-badge-active   { background: rgba(74,222,128,.1); color: #4ade80; border-color: rgba(74,222,128,.25); }
html.dark-mode .tfa-badge-inactive { background: rgba(156,163,175,.08); color: #9ca3af; border-color: rgba(156,163,175,.15); }

/* ── Protected badge ────────────────────────────────────────────── */
.tfa-badge-protected {
    display: inline-flex; align-items: center; gap: .35em;
    font-size: .72rem; font-weight: 700; padding: .28em .7em;
    border-radius: 50px; white-space: nowrap; cursor: default;
    background: rgba(0,167,157,.1); color: #00a79d;
    border: 1px solid rgba(0,167,157,.25);
}
html.dark-mode .tfa-badge-protected {
    background: rgba(45,212,191,.1); color: #2dd4bf;
    border-color: rgba(45,212,191,.25);
}

/* ── Info rows (setup page) ─────────────────────────────────────── */
.tfa-info-row {
    display: flex; align-items: baseline; gap: .5rem;
    padding: .5rem 0; border-bottom: 1px solid #f3f4f6;
}
.tfa-info-row:last-child { border-bottom: none; }
.tfa-info-label { font-size: .75rem; font-weight: 700; color: #9ca3af; min-width: 120px; text-transform: uppercase; letter-spacing: .04em; flex-shrink: 0; }
.tfa-info-value { font-size: .875rem; color: #111827; }
html.dark-mode .tfa-info-row { border-bottom-color: rgba(255,255,255,.06); }
html.dark-mode .tfa-info-value { color: #e5e7eb; }

/* ── Disable card ───────────────────────────────────────────────── */
.tfa-disable-card {
    border: 1px solid rgba(220,53,69,.2);
    border-radius: 12px;
    overflow: hidden;
}
.tfa-disable-header {
    background: rgba(220,53,69,.06);
    border-bottom: 1px solid rgba(220,53,69,.15);
    padding: .6rem 1rem;
    font-weight: 700; font-size: .88rem; color: #dc2626;
    display: flex; align-items: center; gap: .4rem;
}
.tfa-disable-body { padding: 1rem; }
html.dark-mode .tfa-disable-card { border-color: rgba(248,113,113,.2); }
html.dark-mode .tfa-disable-header { background: rgba(248,113,113,.06); border-color: rgba(248,113,113,.15); color: #f87171; }

/* ── Search & Filter Bar ────────────────────────────────────────── */
.tfa-search-bar {
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
    padding: .6rem 1rem;
}
.tfa-search-group {
    display: flex;
    align-items: center;
    background: #fff;
    border: 1.5px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
    transition: border-color .2s, box-shadow .2s;
}
.tfa-search-group:focus-within {
    border-color: #00a79d;
    box-shadow: 0 0 0 .18rem rgba(0,167,157,.18);
}
.tfa-search-icon {
    padding: 0 .65rem;
    color: #9ca3af;
    font-size: .82rem;
    line-height: 1;
    flex-shrink: 0;
}
.tfa-search-input {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
    background: transparent !important;
    font-size: .85rem;
    color: #374151;
    padding: .42rem .25rem .42rem 0;
    flex: 1;
    min-width: 0;
}
.tfa-search-input::placeholder { color: #adb5bd; }
.tfa-search-clear {
    border: none;
    background: transparent;
    color: #9ca3af;
    padding: 0 .65rem;
    font-size: .78rem;
    cursor: pointer;
    line-height: 1;
    transition: color .15s;
}
.tfa-search-clear:hover { color: #dc3545; }
/* Dark mode overrides — search */
html.dark-mode .tfa-search-bar { background: #1a1d21; border-color: #373b3e; }
html.dark-mode .tfa-search-group { background: transparent; border-color: #4b5563; }
html.dark-mode .tfa-search-group:focus-within { border-color: #2dd4bf; box-shadow: 0 0 0 .18rem rgba(45,212,191,.15); }
html.dark-mode .tfa-search-icon { color: #6b7280; }
html.dark-mode .tfa-search-input { color: #e5e7eb !important; background: transparent !important; }
html.dark-mode .tfa-search-input::placeholder { color: #6b7280; }
html.dark-mode .tfa-search-clear { color: #6b7280; }
html.dark-mode .tfa-search-clear:hover { color: #f87171; }

/* ── Custom Status Dropdown ─────────────────────────────────────── */
.tfa-custom-select { position: relative; flex-shrink: 0; }
.tfa-custom-select-btn {
    display: inline-flex; align-items: center; gap: .55rem;
    background: #fff; border: 1.5px solid #dee2e6; border-radius: 8px;
    padding: .42rem .75rem; font-size: .82rem; color: #374151;
    cursor: pointer; white-space: nowrap; min-width: 130px;
    justify-content: space-between;
    transition: border-color .2s, box-shadow .2s;
    user-select: none;
}
.tfa-custom-select-btn:focus { outline: none; }
.tfa-custom-select.open .tfa-custom-select-btn,
.tfa-custom-select-btn:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 .18rem rgba(0,167,157,.18);
}
.tfa-select-label { flex: 1; text-align: left; }
.tfa-select-arrow {
    font-size: .68rem; color: #9ca3af;
    transition: transform .2s ease;
}
.tfa-custom-select.open .tfa-select-arrow { transform: rotate(180deg); }

.tfa-custom-select-menu {
    position: absolute; top: calc(100% + 5px); right: 0;
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 8px 24px rgba(0,0,0,.11), 0 2px 6px rgba(0,0,0,.06);
    min-width: 148px; z-index: 200; overflow: hidden;
    opacity: 0; transform: translateY(-5px); pointer-events: none;
    transition: opacity .15s ease, transform .15s ease;
}
.tfa-custom-select.open .tfa-custom-select-menu {
    opacity: 1; transform: translateY(0); pointer-events: auto;
}
.tfa-custom-select-item {
    display: flex; align-items: center; gap: .55rem;
    padding: .48rem .85rem; font-size: .82rem; color: #374151;
    cursor: pointer; transition: background .12s;
}
.tfa-custom-select-item:first-child { padding-top: .6rem; }
.tfa-custom-select-item:last-child  { padding-bottom: .6rem; }
.tfa-custom-select-item:hover { background: #f0fffe; color: #00a79d; }
.tfa-custom-select-item.selected {
    color: #00a79d; font-weight: 600;
    background: rgba(0,167,157,.06);
}
.tfa-status-dot {
    width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0;
}
.tfa-status-dot.all      { background: #9ca3af; }
.tfa-status-dot.active   { background: #059669; }
.tfa-status-dot.inactive { background: #6b7280; }

/* Dark mode — custom dropdown */
html.dark-mode .tfa-custom-select-btn {
    background: transparent; border-color: #4b5563; color: #e5e7eb;
}
html.dark-mode .tfa-custom-select.open .tfa-custom-select-btn,
html.dark-mode .tfa-custom-select-btn:focus {
    border-color: #2dd4bf;
    box-shadow: 0 0 0 .18rem rgba(45,212,191,.15);
}
html.dark-mode .tfa-select-arrow { color: #6b7280; }
html.dark-mode .tfa-custom-select-menu {
    background: #2b2f33; border-color: #4b5563;
    box-shadow: 0 8px 24px rgba(0,0,0,.45), 0 2px 6px rgba(0,0,0,.3);
}
html.dark-mode .tfa-custom-select-item { color: #e5e7eb; }
html.dark-mode .tfa-custom-select-item:hover  { background: rgba(45,212,191,.08); color: #2dd4bf; }
html.dark-mode .tfa-custom-select-item.selected { color: #2dd4bf; background: rgba(45,212,191,.08); }
html.dark-mode .tfa-status-dot.all      { background: #6b7280; }
html.dark-mode .tfa-status-dot.active   { background: #4ade80; }
html.dark-mode .tfa-status-dot.inactive { background: #9ca3af; }

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .otp-input { font-size: 1.2rem; letter-spacing: .25em; max-width: 100%; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
    .tfa-search-bar { flex-direction: column; align-items: stretch !important; }
    .tfa-search-group { max-width: 100% !important; flex: 1 1 auto; }
    .tfa-custom-select { width: 100%; }
    .tfa-custom-select-btn { width: 100%; }
    .tfa-custom-select-menu { right: auto; left: 0; min-width: 100%; }
}
</style>
