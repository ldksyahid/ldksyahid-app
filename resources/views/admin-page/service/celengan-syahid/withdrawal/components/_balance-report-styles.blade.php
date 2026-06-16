<style>
/* ── Base (same as _withdrawal-styles) ─────────────────────────── */
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
.text-brand { color: #00a79d; }
html.dark-mode .text-brand { color: #2dd4bf; }

/* ── Balance report specific ────────────────────────────────────── */
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .6rem 0;
    border-bottom: 1px solid #e9ecef;
}
.summary-row:last-child { border-bottom: none; }
.summary-label { color: #6c757d; font-weight: 500; }
.summary-value { font-weight: 700; font-size: 1.05rem; color: #212529; }

.discrepancy-badge {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    padding: .35rem .85rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: .9rem;
}
.discrepancy-normal  { color: #198754; background: #d1fae5; border: 1px solid #6ee7b7; }
.discrepancy-warning { color: #92400e; background: #fef3c7; border: 1px solid #fcd34d; }
.discrepancy-deficit { color: #fff;    background: #dc3545; border: 1px solid #b91c1c; }

/* ── Dark mode ──────────────────────────────────────────────────── */
html.dark-mode .page-title { color: #2dd4bf; }
html.dark-mode .page-title .highlighted-text { color: #14b8a6; }
html.dark-mode .page-title small { color: #9ca3af; }
html.dark-mode .section-title { color: #2dd4bf; border-bottom-color: rgba(45,212,191,.15); }
html.dark-mode .card { background-color: #1f2937; box-shadow: 0 4px 12px rgba(0,0,0,.3); }
html.dark-mode small.text-muted, html.dark-mode .text-muted { color: #9ca3af !important; }
html.dark-mode .table { color: #e5e7eb; }
html.dark-mode .table-light th { background-color: #374151 !important; color: #d1d5db; }
html.dark-mode .table-hover tbody tr:hover td { background-color: rgba(255,255,255,.04); }
html.dark-mode tfoot.table-light td { background-color: #374151 !important; color: #d1d5db; }
html.dark-mode code { color: #2dd4bf; background-color: rgba(45,212,191,.1); padding: 0 4px; border-radius: 3px; }
html.dark-mode .btn-outline-secondary { color: #9ca3af; border-color: #4b5563; }
html.dark-mode .btn-outline-secondary:hover { background-color: #374151; color: #e5e7eb; }
/* Summary rows */
html.dark-mode .summary-row { border-bottom-color: rgba(255,255,255,.07); }
html.dark-mode .summary-label { color: #9ca3af; }
html.dark-mode .summary-value { color: #e5e7eb; }
/* Discrepancy badges */
html.dark-mode .discrepancy-normal  { background: rgba(34,197,94,.12);  border-color: rgba(34,197,94,.35);  color: #4ade80; }
html.dark-mode .discrepancy-warning { background: rgba(234,179,8,.12);  border-color: rgba(234,179,8,.35);  color: #fde68a; }
html.dark-mode .discrepancy-deficit { background: rgba(239,68,68,.2);   border-color: rgba(239,68,68,.5);   color: #fca5a5; }

@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .discrepancy-badge { font-size: .8rem; }
    .summary-row { flex-direction: column; align-items: flex-start; gap: .25rem; }
}
</style>
