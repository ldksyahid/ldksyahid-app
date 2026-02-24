@verbatim
<style>
/* ================================================================
   SEARCH-FILTER-BAR  Component Styles   (prefix: sfb-)
   Include with: @include('components.search-filter-bar.styles')
   ================================================================ */

/* ── Wrapper ─────────────────────────────────────────────────── */
.sfb-wrap {
    display: flex;
    align-items: center;
    gap: .75rem;
    flex-wrap: wrap;
}

/* ── Search Field ────────────────────────────────────────────── */
.sfb-field {
    flex: 1 1 280px;
    position: relative;
    display: flex;
    align-items: center;
}
.sfb-search-icon {
    position: absolute;
    left: 1.1rem;
    color: #b0bec5;
    font-size: .85rem;
    pointer-events: none;
    z-index: 1;
    transition: color .2s;
}
.sfb-field:focus-within .sfb-search-icon { color: #00a79d; }

.sfb-input {
    width: 100%;
    border: 1.5px solid #e5e7eb;
    border-radius: 50px;
    padding: .58rem 2.8rem .58rem 2.6rem;  /* left room for icon, right for clear btn */
    font-size: .9rem;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    transition: border-color .2s, box-shadow .2s;
    color: #2c3e50;
}
.sfb-input:focus {
    outline: none;
    border-color: #00a79d;
    box-shadow: 0 0 0 3.5px rgba(0,167,157,.12);
}
.sfb-input::placeholder { color: #b0bec5; }

.sfb-clear {
    position: absolute;
    right: .85rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #b0bec5;
    font-size: 1.3rem;
    line-height: 1;
    padding: 0;
    transition: color .2s;
    z-index: 1;
}
.sfb-clear:hover { color: #7f8c8d; }

/* ── Filter Button ───────────────────────────────────────────── */
.sfb-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    border: 1.5px solid #00a79d;
    color: #00a79d;
    background: white;
    border-radius: 50px;
    padding: .56rem 1.15rem;
    font-size: .88rem;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    position: relative;
    transition: background .22s, color .22s, box-shadow .22s;
}
.sfb-filter-btn:hover {
    background: #00a79d;
    color: white;
    box-shadow: 0 4px 12px rgba(0,167,157,.3);
}

/* Filter count badge */
.sfb-badge {
    position: absolute;
    top: -7px; right: -7px;
    background: #ef4444;
    color: white;
    min-width: 18px; height: 18px;
    border-radius: 50px;
    font-size: .62rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    border: 2px solid white;
    box-shadow: 0 1px 4px rgba(0,0,0,.2);
}

/* ── Sort Button ─────────────────────────────────────────────── */
.sfb-sort-btn {
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    border: 1.5px solid #e5e7eb;
    color: #7f8c8d;
    background: white;
    border-radius: 50px;
    padding: .56rem 1rem;
    font-size: .88rem;
    font-weight: 500;
    white-space: nowrap;
    cursor: pointer;
    transition: border-color .22s, color .22s;
}
.sfb-sort-btn:hover,
.sfb-sort-btn:focus {
    border-color: #00a79d;
    color: #00a79d;
    outline: none;
}
/* Bootstrap dropdown arrow keeps its styling */
.sfb-sort-btn.dropdown-toggle::after { margin-left: .35em; }

/* ── Active Filter Pills ─────────────────────────────────────── */
.sfb-pills {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
    min-height: 0;    /* collapse when empty */
}
.sfb-pill {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    background: #e0f7f5;
    color: #00a79d;
    border-radius: 50px;
    padding: .22rem .8rem;
    font-size: .78rem;
    font-weight: 600;
    border: 1px solid rgba(0,167,157,.25);
    cursor: pointer;
    user-select: none;
    transition: background .2s, color .2s;
}
.sfb-pill:hover { background: #00a79d; color: white; }
.sfb-pill i { font-size: .62rem; }

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .sfb-wrap { gap: .5rem; }
    .sfb-filter-btn,
    .sfb-sort-btn { padding: .5rem .9rem; font-size: .83rem; }
}
@media (max-width: 576px) {
    .sfb-field  { flex: 1 1 100%; }
    .sfb-filter-btn,
    .sfb-sort-btn { padding: .48rem .85rem; font-size: .8rem; }
}
</style>
@endverbatim
