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

@media (max-width: 767px) {
    .br-stat-card { padding: .75rem; gap: .65rem; }
    .br-stat-icon { width: 40px; height: 40px; border-radius: 10px; font-size: 1rem; }
    .br-stat-value { font-size: 1.1rem; }
    .br-page-title { font-size: 1.25rem; }
    .discrepancy-badge { font-size: .72rem; }
}
</style>
