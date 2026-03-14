@verbatim
<style>
/* ================================================================
   SEARCH-FILTER-BAR  Component Styles   (prefix: sfb-)
   Include with: @include('components.search-filter-bar.styles')
   ================================================================ */

/* ── Wrapper — plain flex, no background ─────────────────────── */
.sfb-wrap {
    display: flex;
    align-items: center;
    gap: .6rem;
    flex-wrap: wrap;
}

/* ── Search Field — pill card ────────────────────────────────── */
.sfb-field {
    flex: 1 1 280px;
    position: relative;            /* for clear button only */
    display: flex;
    align-items: center;
    gap: .5rem;                    /* space between icon and input */
    background: #ffffff;
    border-radius: 50px;
    border: 2px solid rgba(0,167,157,.2);
    box-shadow: 0 4px 20px rgba(0,167,157,.12), 0 1px 6px rgba(0,0,0,.05);
    transition: border-color .22s, box-shadow .22s;
    padding: 0 .5rem 0 1.1rem;    /* left pad starts the icon; right pad clears the × btn */
}
.sfb-field:focus-within {
    border-color: #00a79d;
    box-shadow: 0 4px 22px rgba(0,167,157,.22), 0 0 0 4px rgba(0,167,157,.09);
}

/* Icon — regular flex child (NOT absolute), auto-centered by align-items */
.sfb-search-icon {
    flex-shrink: 0;
    color: #00a79d;
    font-size: .95rem;
    pointer-events: none;
    user-select: none;
    opacity: .55;
    transition: opacity .2s;
}
.sfb-field:focus-within .sfb-search-icon { opacity: 1; }

/* Input — use .sfb-field .sfb-input for specificity (0,2,0) to beat
   global rule: input[type="text"] { border:1px solid #ddd; padding:10px; margin:5px 0 }
   which has specificity (0,1,1). Without this, gray border + wrong padding appear. */
.sfb-field .sfb-input {
    flex: 1;
    width: auto;          /* beat global width:100% which breaks flex layout */
    border: none;         /* beat global border:1px solid #ddd (gray box) */
    border-radius: 0;     /* beat global border-radius:5px; container does pill */
    margin: 0;            /* beat global margin:5px 0 */
    padding: .78rem 2.4rem .78rem 0;  /* right pad = space for × button */
    font-size: .9rem;
    background: transparent;
    color: #2c3e50;
    outline: none;
    box-shadow: none;
    min-width: 0;
    box-sizing: border-box;
}
.sfb-field .sfb-input::placeholder { color: #b0ccca; }

/* Clear (×) button — still absolute on the right */
.sfb-clear {
    position: absolute;
    right: .9rem;
    top: 50%;
    transform: translateY(-50%);
    background: #e0f4f2;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    cursor: pointer;
    color: #00a79d;
    font-size: .62rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    line-height: 1;
    transition: background .2s, color .2s, transform .15s;
    flex-shrink: 0;
}
.sfb-clear:hover { background: #00a79d; color: white; transform: translateY(-50%) scale(1.1); }

/* ── Actions group ───────────────────────────────────────────── */
.sfb-actions {
    display: flex;
    align-items: center;
    gap: .5rem;
    flex-shrink: 0;
}

/* ── Filter Button Group ─────────────────────────────────────── */
.sfb-filter-group {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: .3rem;
}

/* Clear-all X button (shown when filters are active) */
.sfb-filter-clear {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: #fee2e2;
    border: 1.5px solid rgba(239,68,68,.28);
    color: #ef4444;
    font-size: .6rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    flex-shrink: 0;
    transition: background .2s, color .2s, border-color .2s, transform .15s, box-shadow .15s;
    box-shadow: 0 2px 8px rgba(239,68,68,.18);
}
.sfb-filter-clear:hover {
    background: #ef4444; color: white;
    border-color: transparent;
    transform: scale(1.12);
    box-shadow: 0 4px 14px rgba(239,68,68,.4);
}
.sfb-filter-clear:active { transform: scale(1); }

/* ── Filter Button ───────────────────────────────────────────── */
.sfb-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    background: linear-gradient(135deg, #00c4b8 0%, #00a79d 100%);
    color: white;
    border: none;
    border-radius: 50px;
    padding: .75rem 1.35rem;
    font-size: .875rem;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    position: relative;
    box-shadow: 0 4px 16px rgba(0,167,157,.4);
    transition: filter .22s, box-shadow .22s, transform .18s;
}
.sfb-filter-btn:hover {
    filter: brightness(1.08);
    box-shadow: 0 6px 22px rgba(0,167,157,.52);
    transform: translateY(-1px);
}
.sfb-filter-btn:active { transform: translateY(0); box-shadow: 0 2px 8px rgba(0,167,157,.3); }

/* Filter count badge */
.sfb-badge {
    position: absolute;
    top: -7px; right: -7px;
    background: #ef4444;
    color: white;
    min-width: 20px; height: 20px;
    border-radius: 50%;
    font-size: .63rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 4px;
    border: 2px solid white;
    box-shadow: 0 2px 6px rgba(239,68,68,.45);
}

/* ── Sort Button ─────────────────────────────────────────────── */
.sfb-sort-btn {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    border: 2px solid rgba(0,167,157,.28);
    color: #00a79d;
    background: white;
    border-radius: 50px;
    padding: .73rem 1.25rem;
    font-size: .875rem;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,.05);
    transition: border-color .22s, background .22s, color .22s, box-shadow .22s, transform .18s;
}
.sfb-sort-btn:hover,
.sfb-sort-btn:focus {
    border-color: #00a79d;
    background: #f0fefd;
    box-shadow: 0 4px 16px rgba(0,167,157,.18);
    transform: translateY(-1px);
    outline: none;
}
.sfb-sort-btn:active { transform: translateY(0); }
.sfb-sort-btn.dropdown-toggle::after { margin-left: .3em; vertical-align: .15em; }

/* Sort dropdown menu — smooth open/close */
.sfb-sort-menu {
    border: 1.5px solid rgba(0,167,157,.22) !important;
    border-radius: 1rem !important;
    box-shadow: 0 12px 40px rgba(0,0,0,.12), 0 2px 8px rgba(0,167,157,.08) !important;
    overflow: hidden;
    padding: .45rem 0 !important;
    min-width: 195px !important;
    z-index: 1060 !important;

    /* Override Bootstrap display:none — use visibility+opacity only (no transform to avoid glitch) */
    display: block !important;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    /* close: delay visibility until fade-out finishes */
    transition: opacity .18s ease, visibility 0s .18s;
}
.sfb-sort-menu.show {
    visibility: visible;
    opacity: 1;
    pointer-events: auto;
    /* open: visibility instant, then fade in */
    transition: opacity .18s ease, visibility 0s 0s;
}
.sfb-sort-item {
    display: flex !important;
    align-items: center;
    gap: .6rem;
    padding: .65rem 1.15rem !important;
    font-size: .875rem;
    color: #4a5568 !important;
    transition: background .15s, color .15s;
}
.sfb-sort-item i:first-child {
    color: #c4d6d5;
    font-size: .85rem;
    width: 1rem;
    text-align: center;
    transition: color .15s;
    flex-shrink: 0;
}
.sfb-sort-item > span { flex: 1; }
.sfb-sort-item:hover { background: #f0fefd !important; color: #00a79d !important; }
.sfb-sort-item:hover i:first-child { color: #00a79d; }
.sfb-sort-item.active {
    background: linear-gradient(135deg, #eafaf8, #d4f5f2) !important;
    color: #007d76 !important;
    font-weight: 600;
}
.sfb-sort-item.active i:first-child { color: #00897b; }
.sfb-sort-item.active::after {
    content: '\f00c';
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
    font-size: .7rem;
    color: #00a79d;
}

/* ── Active Filter Pills ─────────────────────────────────────── */
.sfb-pills {
    display: flex;
    flex-wrap: wrap;
    gap: .4rem;
    min-height: 0;
}
.sfb-pill {
    display: inline-flex;
    align-items: center;
    gap: .38rem;
    background: #e8faf8;
    color: #007d76;
    border-radius: 50px;
    padding: .32rem .65rem .32rem 1rem;
    font-size: .78rem;
    font-weight: 600;
    border: 1.5px solid rgba(0,167,157,.22);
    cursor: default;
    user-select: none;
    box-shadow: 0 1px 4px rgba(0,167,157,.08);
}

/* × circle — the only interactive part */
.sfb-pill i {
    width: 16px; height: 16px;
    border-radius: 50%;
    background: rgba(0,125,118,.13);
    display: inline-flex; align-items: center; justify-content: center;
    font-size: .5rem;
    flex-shrink: 0;
    cursor: pointer;
    transition: background .18s, color .18s, transform .15s, box-shadow .15s;
}
.sfb-pill i:hover {
    background: #ef4444;
    color: white;
    transform: scale(1.15);
    box-shadow: 0 2px 8px rgba(239,68,68,.38);
}

/* ── Responsive ──────────────────────────────────────────────── */
@media (max-width: 576px) {
    .sfb-wrap { gap: .55rem; }
    .sfb-field { flex: 1 1 100%; }
    .sfb-actions { flex: 1 1 100%; gap: .5rem; }
    .sfb-actions .dropdown { flex: 1; }
    .sfb-filter-btn {
        flex: 1;
        justify-content: center;
        padding: .72rem 1rem;
    }
    .sfb-sort-btn {
        width: 100%;
        justify-content: center;
        padding: .7rem 1rem;
    }
}
</style>
@endverbatim
