<style>
/* ── Page Header ──────────────────────────────────────── */
.br-page-title {
    font-size: 1.55rem; font-weight: 700;
    color: #00a79d; position: relative; display: inline-block;
}
.br-page-title::after {
    content: ''; display: block; height: 4px; width: 100px;
    margin: .3rem 0 0; border-radius: 3px;
    background: linear-gradient(90deg, #00a79d, #008b84);
}
.btn-rounded { border-radius: 8px !important; }

/* ── Stat Cards ───────────────────────────────────────── */
.br-stat-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
    padding: 1rem 1.1rem;
    display: flex; align-items: center; gap: 1rem;
    transition: box-shadow .2s;
}
.br-stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.12); }
.br-stat-icon {
    width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
}
.br-icon-actual   { background: rgba(0,167,157,.12);  color: #00a79d; }
.br-icon-expected { background: rgba(99,102,241,.12); color: #6366f1; }
.br-icon-normal   { background: rgba(34,197,94,.12);  color: #16a34a; }
.br-icon-warning  { background: rgba(234,179,8,.15);  color: #ca8a04; }
.br-icon-deficit  { background: rgba(239,68,68,.12);  color: #dc2626; }
.br-icon-neutral  { background: rgba(107,114,128,.1); color: #6b7280; }
.br-stat-info { flex: 1; min-width: 0; }
.br-stat-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #9ca3af; margin-bottom: 2px; }
.br-stat-value { font-size: 1.4rem; font-weight: 800; line-height: 1.1; color: #111827; }
.br-stat-sub   { font-size: .72rem; color: #9ca3af; margin-top: 2px; }

/* ── Explanation Card ─────────────────────────────────── */
.br-explain-card {
    background: #fff; border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); overflow: hidden;
}
.br-explain-header {
    background: rgba(0,167,157,.06);
    border-bottom: 1px solid rgba(0,167,157,.12);
    padding: .65rem 1.25rem;
    font-weight: 700; font-size: .88rem; color: #00a79d;
}
.br-explain-body {
    padding: 1rem 1.25rem;
    font-size: .875rem; color: #6b7280;
}
.br-explain-body ul { padding-left: 1.25rem; margin-bottom: .75rem; }
.br-explain-body li + li { margin-top: .3rem; }

/* ── Discrepancy badges ───────────────────────────────── */
.discrepancy-badge {
    display: inline-flex; align-items: center; gap: .4rem;
    padding: .3rem .85rem; border-radius: 50px;
    font-weight: 700; font-size: .8rem;
}
.discrepancy-normal  { color: #166534; background: #dcfce7; border: 1px solid #86efac; }
.discrepancy-warning { color: #92400e; background: #fef3c7; border: 1px solid #fcd34d; }
.discrepancy-deficit { color: #fff;    background: #dc2626; border: 1px solid #b91c1c; }

/* ── Table Card ───────────────────────────────────────── */
.wi-table-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07); overflow: hidden;
}
.wi-table { font-size: .875rem; margin-bottom: 0; }
.wi-table thead th {
    font-size: .8rem; font-weight: 600; color: #6c757d;
    background: #f8f9fa; border-bottom: 2px solid #e9ecef;
    white-space: nowrap; padding: .7rem .75rem; border-top: none;
}
.wi-table thead th:first-child { font-weight: 700; color: #495057; }
.wi-table tbody td { padding: .75rem .75rem; vertical-align: middle; }
.wi-table tbody tr { transition: background .15s; }
.wi-table tbody tr:hover > td { background: rgba(0,0,0,.025); }

/* tfoot */
.wi-table tfoot tr { border-top: 2px solid #e0f7f5; }
.br-tfoot-label {
    font-size: .82rem; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: .04em; padding: .85rem .75rem;
}
.br-tfoot-value {
    font-size: 1.05rem; font-weight: 800; color: #00a79d; padding: .85rem .75rem;
}

/* ── Table elements ───────────────────────────────────── */
.br-qris-badge {
    display: inline-block; font-size: .68rem; font-weight: 700;
    padding: .15em .6em; border-radius: 50px;
    background: rgba(0,167,157,.1); color: #008b84;
    border: 1px solid rgba(0,167,157,.2); vertical-align: middle;
}
.br-txn-badge {
    display: inline-block; min-width: 28px; text-align: center;
    font-size: .78rem; font-weight: 700; padding: .15em .5em;
    border-radius: 6px; background: #f3f4f6; color: #374151;
}
.br-withdrawn { font-weight: 600; color: #d97706; font-size: .875rem; }
.br-net { font-weight: 800; font-size: .9rem; }
.br-net-positive { color: #00a79d; }
.br-net-negative { color: #dc2626; }
.br-table-footer {
    padding: .65rem 1.25rem;
    border-top: 1px solid #f3f4f6;
    background: #fafafa;
}

/* ── Dark mode ────────────────────────────────────────── */
html.dark-mode .br-page-title { color: #2dd4bf; }
html.dark-mode .br-page-title::after { background: linear-gradient(90deg, #2dd4bf, #0d9488); }
html.dark-mode .br-stat-card,
html.dark-mode .br-explain-card,
html.dark-mode .wi-table-card { background: #2b2f33 !important; box-shadow: 0 2px 10px rgba(0,0,0,.3) !important; }
html.dark-mode .br-stat-label { color: #6b7280; }
html.dark-mode .br-stat-value { color: #f9fafb; }
html.dark-mode .br-stat-sub   { color: #6b7280; }
html.dark-mode .br-icon-actual   { background: rgba(45,212,191,.12); color: #2dd4bf; }
html.dark-mode .br-icon-expected { background: rgba(129,140,248,.12); color: #818cf8; }
html.dark-mode .br-icon-normal   { background: rgba(74,222,128,.12);  color: #4ade80; }
html.dark-mode .br-icon-warning  { background: rgba(251,191,36,.12);  color: #fbbf24; }
html.dark-mode .br-icon-deficit  { background: rgba(248,113,113,.12); color: #f87171; }
html.dark-mode .br-explain-header { background: rgba(45,212,191,.06); border-color: rgba(45,212,191,.12); color: #2dd4bf; }
html.dark-mode .br-explain-body { color: #9ca3af; }
html.dark-mode .discrepancy-normal  { background: rgba(74,222,128,.1);  border-color: rgba(74,222,128,.25);  color: #4ade80; }
html.dark-mode .discrepancy-warning { background: rgba(251,191,36,.1);  border-color: rgba(251,191,36,.25);  color: #fbbf24; }
html.dark-mode .discrepancy-deficit { background: rgba(248,113,113,.15); border-color: rgba(248,113,113,.35); color: #fca5a5; }
html.dark-mode .wi-table thead th { background: #1a1d21; color: #9ca3af; border-bottom-color: #373b3e; }
html.dark-mode .wi-table thead th:first-child { color: #d1d5db; }
html.dark-mode .wi-table tbody td { color: #e5e7eb; }
html.dark-mode .wi-table tbody tr:hover > td { background: rgba(255,255,255,.04); }
html.dark-mode .wi-table tfoot tr { border-top-color: rgba(45,212,191,.2); }
html.dark-mode .br-tfoot-label { color: #9ca3af; }
html.dark-mode .br-tfoot-value { color: #2dd4bf; }
html.dark-mode .br-qris-badge { background: rgba(45,212,191,.1); color: #2dd4bf; border-color: rgba(45,212,191,.2); }
html.dark-mode .br-txn-badge  { background: #2b2f33; color: #d1d5db; }
html.dark-mode .br-withdrawn  { color: #fbbf24; }
html.dark-mode .br-net-positive { color: #2dd4bf; }
html.dark-mode .br-net-negative { color: #f87171; }
html.dark-mode .br-table-footer { background: #1a1d21; border-color: #373b3e; }
html.dark-mode .text-muted { color: #6b7280 !important; }
html.dark-mode code { color: #2dd4bf; background: rgba(45,212,191,.1); padding: 0 4px; border-radius: 3px; }
html.dark-mode .bg-light { background: #111827 !important; }
html.dark-mode .btn-outline-secondary { color: #9ca3af; border-color: #374151; }
html.dark-mode .btn-outline-secondary:hover { background: #374151; color: #e5e7eb; }

/* ── Balance History Scope Pills (subtitle) ───────────────── */
.bh-scope-pill {
    display: inline-flex; align-items: center; gap: .3em;
    font-size: .68rem; font-weight: 600;
    padding: .18em .6em; border-radius: 4px; white-space: nowrap;
}
.bh-scope-credit {
    background: rgba(0,167,157,.08); color: #00a79d;
    border: 1px solid rgba(0,167,157,.2);
}
.bh-scope-debit {
    background: rgba(220,38,38,.07); color: #b91c1c;
    border: 1px solid rgba(220,38,38,.2);
}
.bh-scope-sep { font-size: .72rem; color: #9ca3af; font-weight: 700; }
html.dark-mode .bh-scope-credit { background: rgba(45,212,191,.08); color: #2dd4bf; border-color: rgba(45,212,191,.2); }
html.dark-mode .bh-scope-debit  { background: rgba(248,113,113,.08); color: #f87171; border-color: rgba(248,113,113,.2); }
html.dark-mode .bh-scope-sep    { color: #6b7280; }

/* ── Balance History Summary Pills ────────────────────────── */
.bh-summary-pill-wrap {
    display: flex; flex-direction: column; align-items: flex-start; gap: .2rem;
}
.bh-summary-label {
    font-size: .68rem; font-weight: 600; text-transform: uppercase;
    letter-spacing: .04em; color: #9ca3af;
}
.bh-pill-credit, .bh-pill-debit {
    display: inline-flex; align-items: center;
    font-size: .8rem; font-weight: 700;
    padding: .25em .85em; border-radius: 50px; white-space: nowrap;
}
.bh-pill-credit { background: rgba(0,167,157,.12); color: #007a72; border: 1px solid rgba(0,167,157,.3); }
.bh-pill-debit  { background: rgba(220,38,38,.1);  color: #b91c1c; border: 1px solid rgba(220,38,38,.25); }
html.dark-mode .bh-summary-label { color: #6b7280; }
html.dark-mode .bh-pill-credit { background: rgba(45,212,191,.1); color: #2dd4bf; border-color: rgba(45,212,191,.25); }
html.dark-mode .bh-pill-debit  { background: rgba(248,113,113,.1); color: #f87171; border-color: rgba(248,113,113,.25); }

/* ── Balance History Custom Dropdown ──────────────────────── */
.bh-custom-select { position: relative; flex-shrink: 0; }
.bh-custom-select-btn {
    display: inline-flex; align-items: center; gap: .55rem;
    background: #fff; border: 1.5px solid #dee2e6; border-radius: 8px;
    padding: .42rem .75rem; font-size: .82rem; color: #374151;
    cursor: pointer; white-space: nowrap; min-width: 160px;
    justify-content: space-between; user-select: none;
    transition: border-color .2s, box-shadow .2s;
}
.bh-custom-select-btn:focus { outline: none; }
.bh-custom-select.open .bh-custom-select-btn,
.bh-custom-select-btn:focus { border-color: #00a79d; box-shadow: 0 0 0 .18rem rgba(0,167,157,.18); }
.bh-select-label { flex: 1; text-align: left; }
.bh-select-arrow { font-size: .68rem; color: #9ca3af; transition: transform .2s ease; }
.bh-custom-select.open .bh-select-arrow { transform: rotate(180deg); }

.bh-custom-select-menu {
    position: absolute; top: calc(100% + 5px); right: 0;
    background: #fff; border: 1.5px solid #e2e8f0;
    border-radius: 10px; min-width: 170px; z-index: 200; overflow: hidden;
    box-shadow: 0 8px 24px rgba(0,0,0,.11), 0 2px 6px rgba(0,0,0,.06);
    opacity: 0; transform: translateY(-5px); pointer-events: none;
    transition: opacity .15s ease, transform .15s ease;
}
.bh-custom-select.open .bh-custom-select-menu { opacity: 1; transform: translateY(0); pointer-events: auto; }

.bh-select-item {
    display: flex; align-items: center; gap: .55rem;
    padding: .48rem .85rem; font-size: .82rem; color: #374151;
    cursor: pointer; transition: background .12s;
}
.bh-select-item:first-child { padding-top: .6rem; }
.bh-select-item:last-child  { padding-bottom: .6rem; }
.bh-select-item:hover  { background: #f0fffe; color: #00a79d; }
.bh-select-item.selected { color: #00a79d; font-weight: 600; background: rgba(0,167,157,.06); }

.bh-select-dot { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
.bh-dot-all    { background: #9ca3af; }
.bh-dot-credit { background: #00a79d; }
.bh-dot-debit  { background: #d97706; }

html.dark-mode .bh-custom-select-btn { background: transparent; border-color: #4b5563; color: #e5e7eb; }
html.dark-mode .bh-custom-select.open .bh-custom-select-btn { border-color: #2dd4bf; box-shadow: 0 0 0 .18rem rgba(45,212,191,.15); }
html.dark-mode .bh-select-arrow { color: #6b7280; }
html.dark-mode .bh-custom-select-menu { background: #2b2f33; border-color: #4b5563; box-shadow: 0 8px 24px rgba(0,0,0,.45); }
html.dark-mode .bh-select-item { color: #e5e7eb; }
html.dark-mode .bh-select-item:hover  { background: rgba(45,212,191,.08); color: #2dd4bf; }
html.dark-mode .bh-select-item.selected { color: #2dd4bf; background: rgba(45,212,191,.08); }
html.dark-mode .bh-dot-all    { background: #6b7280; }
html.dark-mode .bh-dot-credit { background: #2dd4bf; }
html.dark-mode .bh-dot-debit  { background: #fbbf24; }

/* ── Balance History Table Text Colors ────────────────────── */
.bh-campaign-name { font-size: .82rem; font-weight: 600; color: #374151; }
.bh-reference     { font-size: .72rem; color: #9ca3af; font-family: monospace; }
html.dark-mode .bh-campaign-name { color: #e5e7eb; }
html.dark-mode .bh-reference     { color: #6b7280; }

/* ── Balance History Filter Bar ───────────────────────────── */
.bh-filter-bar {
    display: flex; align-items: center; gap: .5rem; flex-wrap: wrap;
    padding: .6rem 1rem;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    border-bottom: 1px solid #e9ecef;
}
.bh-search-group {
    display: flex; align-items: center;
    background: #fff; border: 1.5px solid #dee2e6; border-radius: 8px;
    overflow: hidden; flex: 1 1 200px; max-width: 300px;
    transition: border-color .2s, box-shadow .2s;
}
.bh-search-group:focus-within {
    border-color: #00a79d; box-shadow: 0 0 0 .18rem rgba(0,167,157,.18);
}
.bh-search-icon { padding: 0 .65rem; color: #9ca3af; font-size: .8rem; flex-shrink: 0; }
.bh-search-input {
    border: none !important; outline: none !important; box-shadow: none !important;
    background: transparent !important; font-size: .84rem; color: #374151;
    padding: .42rem .25rem .42rem 0; flex: 1; min-width: 0;
}
.bh-search-input::placeholder { color: #adb5bd; }
.bh-search-clear {
    border: none; background: transparent; color: #9ca3af;
    padding: 0 .65rem; font-size: .78rem; cursor: pointer; transition: color .15s;
}
.bh-search-clear:hover { color: #dc3545; }
.bh-filter-select {
    font-size: .82rem !important; border: 1.5px solid #dee2e6 !important;
    border-radius: 8px !important; background-color: #fff !important;
    color: #374151 !important; padding: .42rem .75rem !important;
    cursor: pointer; transition: border-color .2s;
}
.bh-filter-select:focus {
    border-color: #00a79d !important;
    box-shadow: 0 0 0 .18rem rgba(0,167,157,.18) !important; outline: none;
}

/* ── Balance History Table Rows ───────────────────────────── */
.bh-type-badge {
    display: inline-flex; align-items: center; gap: .35em;
    font-size: .7rem; font-weight: 700; padding: .25em .65em;
    border-radius: 50px; white-space: nowrap;
}
.bh-badge-payment {
    background: rgba(0,167,157,.1); color: #00a79d;
    border: 1px solid rgba(0,167,157,.25);
}
.bh-badge-disbursement {
    background: rgba(217,119,6,.1); color: #b45309;
    border: 1px solid rgba(217,119,6,.25);
}
.bh-amount-pill {
    display: inline-flex; align-items: center;
    font-size: .78rem; font-weight: 700;
    padding: .28em .75em; border-radius: 50px; white-space: nowrap;
}
.bh-pill-amount-credit {
    background: rgba(0,167,157,.12); color: #007a72;
    border: 1px solid rgba(0,167,157,.3);
}
.bh-pill-amount-debit {
    background: rgba(220,38,38,.1); color: #b91c1c;
    border: 1px solid rgba(220,38,38,.25);
}
html.dark-mode .bh-pill-amount-credit {
    background: rgba(45,212,191,.12); color: #2dd4bf;
    border-color: rgba(45,212,191,.3);
}
html.dark-mode .bh-pill-amount-debit {
    background: rgba(248,113,113,.12); color: #f87171;
    border-color: rgba(248,113,113,.3);
}
.bh-balance-after { font-size: .875rem; font-weight: 600; color: #374151; }

/* ── Balance History Pagination ───────────────────────────── */
.bh-pagination-bar {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .5rem;
    padding: .65rem 1rem; border-top: 1px solid #e9ecef; background: #fff;
}
.bh-pg-btn { font-size: .78rem !important; padding: .22rem .6rem !important; border-radius: 6px !important; min-width: 32px; }
.bh-pg-btn.active { background: #00a79d !important; border-color: #00a79d !important; color: #fff !important; font-weight: 700; }
.bh-pg-ellipsis { display: inline-flex; align-items: center; padding: 0 .3rem; color: #9ca3af; font-size: .82rem; }

/* ── Balance History Modal ────────────────────────────────── */
.bh-modal-content {
    border: none; border-radius: 14px;
    box-shadow: 0 20px 60px rgba(0,0,0,.15), 0 8px 24px rgba(0,0,0,.1);
    overflow: hidden;
}
.bh-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 2px solid rgba(0,167,157,.12);
    background: #fff;
}
.bh-modal-icon { flex-shrink: 0; }
.bh-modal-title { font-size: 1rem; font-weight: 700; color: #111827; }
.bh-modal-sub   { font-size: .75rem; color: #9ca3af; font-family: monospace; }
.bh-modal-close {
    border: none; background: transparent; color: #9ca3af;
    font-size: .9rem; cursor: pointer; padding: .25rem .4rem; border-radius: 6px;
    transition: background .15s, color .15s;
}
.bh-modal-close:hover { background: #f3f4f6; color: #374151; }
.bh-modal-body { padding: 1rem 1.25rem; background: #fff; }
.bh-detail-grid { display: flex; flex-direction: column; gap: 0; }
.bh-detail-row {
    display: flex; align-items: baseline; justify-content: space-between;
    gap: .5rem; padding: .5rem 0;
    border-bottom: 1px solid #f3f4f6;
    font-size: .84rem;
}
.bh-detail-row:last-child { border-bottom: none; }
.bh-detail-label { color: #6b7280; font-size: .78rem; font-weight: 600; flex-shrink: 0; }
.bh-detail-value { color: #111827; text-align: right; word-break: break-all; }

/* ── Dark Mode — History ──────────────────────────────────── */
html.dark-mode .bh-filter-bar { background: #1a1d21; border-color: #373b3e; }
html.dark-mode .bh-search-group { background: transparent; border-color: #4b5563; }
html.dark-mode .bh-search-group:focus-within { border-color: #2dd4bf; box-shadow: 0 0 0 .18rem rgba(45,212,191,.15); }
html.dark-mode .bh-search-input { color: #e5e7eb !important; }
html.dark-mode .bh-search-input::placeholder { color: #6b7280; }
html.dark-mode .bh-search-clear { color: #6b7280; }
html.dark-mode .bh-filter-select { background: transparent !important; border-color: #4b5563 !important; color: #e5e7eb !important; }
html.dark-mode .bh-badge-payment { background: rgba(45,212,191,.1); color: #2dd4bf; border-color: rgba(45,212,191,.2); }
html.dark-mode .bh-badge-disbursement { background: rgba(251,191,36,.08); color: #fbbf24; border-color: rgba(251,191,36,.2); }
html.dark-mode .bh-amount-credit { color: #2dd4bf; }
html.dark-mode .bh-amount-debit  { color: #fbbf24; }
html.dark-mode .bh-balance-after { color: #e5e7eb; }
html.dark-mode .bh-pagination-bar { background: #2b2f33; border-top-color: #373b3e; }
html.dark-mode .bh-pg-btn.active { background: #008b84 !important; border-color: #008b84 !important; }
html.dark-mode .bh-modal-content { background: #2b2f33; box-shadow: 0 20px 60px rgba(0,0,0,.5); }
html.dark-mode .bh-modal-header { background: #2b2f33; border-bottom-color: #373b3e; }
html.dark-mode .bh-modal-title { color: #f9fafb; }
html.dark-mode .bh-modal-close { color: #6b7280; }
html.dark-mode .bh-modal-close:hover { background: #374151; color: #e5e7eb; }
html.dark-mode .bh-modal-body { background: #2b2f33; }
html.dark-mode .bh-detail-row { border-bottom-color: #373b3e; }
html.dark-mode .bh-detail-label { color: #9ca3af; }
html.dark-mode .bh-detail-value { color: #e5e7eb; }

/* ── Settlement Pending Banner ────────────────────────────── */
.br-pending-banner {
    display: flex; align-items: flex-start; gap: .9rem;
    background: linear-gradient(135deg, rgba(234,179,8,.08), rgba(234,179,8,.04));
    border: 1.5px solid rgba(234,179,8,.35);
    border-radius: 12px; padding: .9rem 1.1rem;
}
.br-pending-banner-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: rgba(234,179,8,.15); color: #ca8a04;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.br-pending-banner-body { flex: 1; min-width: 0; }
.br-pending-banner-title {
    font-size: .82rem; font-weight: 700; color: #92400e; margin-bottom: .2rem;
}
.br-pending-banner-desc {
    font-size: .78rem; color: #78350f; line-height: 1.45;
}
.br-pending-amount {
    font-size: .85rem; font-weight: 800; color: #b45309;
    background: rgba(234,179,8,.15); padding: .1em .5em; border-radius: 5px;
}
html.dark-mode .br-pending-banner {
    background: linear-gradient(135deg, rgba(251,191,36,.07), rgba(251,191,36,.03));
    border-color: rgba(251,191,36,.3);
}
html.dark-mode .br-pending-banner-icon { background: rgba(251,191,36,.12); color: #fbbf24; }
html.dark-mode .br-pending-banner-title { color: #fde68a; }
html.dark-mode .br-pending-banner-desc { color: #d97706; }
html.dark-mode .br-pending-amount { color: #fbbf24; background: rgba(251,191,36,.12); }

/* ── Pending Transfer Banner (withdrawal sent, awaiting callback) ─ */
.br-transfer-banner {
    display: flex; align-items: flex-start; gap: .9rem;
    background: linear-gradient(135deg, rgba(99,102,241,.08), rgba(99,102,241,.04));
    border: 1.5px solid rgba(99,102,241,.3);
    border-radius: 12px; padding: .9rem 1.1rem;
}
.br-transfer-banner-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    background: rgba(99,102,241,.12); color: #6366f1;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
}
.br-transfer-banner-title {
    font-size: .82rem; font-weight: 700; color: #312e81; margin-bottom: .2rem;
}
.br-transfer-banner-desc {
    font-size: .78rem; color: #4338ca; line-height: 1.45;
}
.br-transfer-amount {
    font-size: .85rem; font-weight: 800; color: #4338ca;
    background: rgba(99,102,241,.12); padding: .1em .5em; border-radius: 5px;
}
html.dark-mode .br-transfer-banner {
    background: linear-gradient(135deg, rgba(129,140,248,.07), rgba(129,140,248,.03));
    border-color: rgba(129,140,248,.3);
}
html.dark-mode .br-transfer-banner-icon { background: rgba(129,140,248,.12); color: #818cf8; }
html.dark-mode .br-transfer-banner-title { color: #c7d2fe; }
html.dark-mode .br-transfer-banner-desc  { color: #a5b4fc; }
html.dark-mode .br-transfer-amount { color: #a5b4fc; background: rgba(129,140,248,.12); }

/* ── Transfer pending inline badge in breakdown rows ──────── */
.br-transfer-pending-inline {
    display: inline-flex; align-items: center; gap: .3em;
    font-size: .68rem; font-weight: 600; padding: .15em .55em;
    border-radius: 50px; white-space: nowrap;
    background: rgba(99,102,241,.1); color: #4338ca;
    border: 1px solid rgba(99,102,241,.25);
}
html.dark-mode .br-transfer-pending-inline {
    background: rgba(129,140,248,.1); color: #a5b4fc; border-color: rgba(129,140,248,.25);
}

/* ── Settling inline badge in breakdown rows ─────────────── */
.br-settling-inline {
    display: inline-flex; align-items: center; gap: .3em;
    font-size: .68rem; font-weight: 600; padding: .15em .55em;
    border-radius: 50px; white-space: nowrap;
    background: rgba(234,179,8,.1); color: #92400e;
    border: 1px solid rgba(234,179,8,.3);
}
html.dark-mode .br-settling-inline {
    background: rgba(251,191,36,.08); color: #fbbf24; border-color: rgba(251,191,36,.25);
}

/* ── Settling badge in balance history rows ───────────────── */
.bh-settling-badge {
    display: inline-flex; align-items: center; gap: .3em;
    font-size: .65rem; font-weight: 700; padding: .12em .5em;
    border-radius: 50px; white-space: nowrap; animation: bh-pulse 2s infinite;
    background: rgba(234,179,8,.12); color: #92400e;
    border: 1px solid rgba(234,179,8,.3);
}
@keyframes bh-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: .6; }
}
.bh-settling-note {
    font-size: .65rem; color: #92400e; font-style: italic; margin-top: 1px;
}
.bh-row-settling { background: rgba(234,179,8,.03) !important; }
.bh-row-settling:hover > td { background: rgba(234,179,8,.06) !important; }
.bh-balance-settling { color: #9ca3af !important; font-style: italic; }
html.dark-mode .bh-settling-badge {
    background: rgba(251,191,36,.1); color: #fbbf24; border-color: rgba(251,191,36,.25);
}
html.dark-mode .bh-settling-note { color: #d97706; }
html.dark-mode .bh-row-settling { background: rgba(251,191,36,.03) !important; }
html.dark-mode .bh-row-settling:hover > td { background: rgba(251,191,36,.06) !important; }
html.dark-mode .bh-balance-settling { color: #6b7280 !important; }

@media (max-width: 767px) {
    .br-stat-card { padding: .75rem; gap: .65rem; }
    .br-stat-icon { width: 40px; height: 40px; border-radius: 10px; font-size: 1rem; }
    .br-stat-value { font-size: 1.1rem; }
    .br-page-title { font-size: 1.25rem; }
    .discrepancy-badge { font-size: .72rem; }
}
</style>
