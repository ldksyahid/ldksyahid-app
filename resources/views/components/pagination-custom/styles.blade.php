@verbatim
<style>
/* ================================================================
   PAGINATION CUSTOM COMPONENT STYLES
   Shared across pages that use @include('components.pagination-custom').
   ================================================================ */

.pgn-wrap {
    display: flex; flex-direction: column; align-items: center; gap: .9rem;
    margin-top: 3rem; padding-bottom: 1rem;
}
.pgn-info {
    font-size: .82rem; color: var(--gray);
}
.pgn-info strong { color: var(--primary); font-weight: 700; }
.pgn-inner {
    display: flex; align-items: center; gap: .4rem;
    flex-wrap: wrap; justify-content: center;
}

/* ── Shared base for nav & page numbers ── */
.pgn-nav,
.pgn-num {
    height: 40px;
    border: 1.5px solid var(--primary);
    background: #fff;
    color: var(--primary);
    cursor: pointer;
    font-size: .82rem; font-weight: 600; line-height: 1;
    display: inline-flex; align-items: center; justify-content: center;
    text-decoration: none; flex-shrink: 0;
    transition: background .22s cubic-bezier(.4,0,.2,1),
                color .22s cubic-bezier(.4,0,.2,1),
                border-color .22s,
                transform .22s cubic-bezier(.4,0,.2,1),
                box-shadow .22s cubic-bezier(.4,0,.2,1);
}

/* ── Nav: <<, <, >, >> ── */
.pgn-nav {
    width: 40px;
    border-radius: 50px;
}
/* Asymmetric pill for edge buttons */
.pgn-edge:first-child,
a.pgn-edge:first-child,
button.pgn-edge:first-child { border-radius: 50px 14px 14px 50px; }
.pgn-edge:last-child,
a.pgn-edge:last-child,
button.pgn-edge:last-child  { border-radius: 14px 50px 50px 14px; }

.pgn-nav:hover:not([disabled]) {
    background: var(--primary); color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,167,157,.28);
}
.pgn-nav[disabled] {
    color: #c8d6d5; border-color: #e2ecec;
    background: #f7fafa; cursor: default; pointer-events: none;
}

/* ── Page numbers ── */
.pgn-num {
    min-width: 40px; padding: 0 .55rem;
    border-radius: 50px;
}
.pgn-num:hover:not(.active) {
    background: var(--primary); color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,167,157,.28);
}
.pgn-num.active {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark, #007a72) 100%);
    border-color: transparent; color: #fff; font-weight: 700; font-size: .9rem;
    transform: translateY(-3px) scale(1.08);
    box-shadow: 0 8px 22px rgba(0,167,157,.38);
    pointer-events: none;
}

/* ── Pages container ── */
.pgn-pages {
    display: flex; align-items: center; gap: .4rem;
    flex-wrap: wrap; justify-content: center;
}

/* ── Ellipsis ── */
.pgn-ellipsis {
    width: 28px; height: 40px;
    display: flex; align-items: flex-end; justify-content: center;
    color: var(--primary); font-weight: 800; font-size: .78rem;
    padding-bottom: 4px; letter-spacing: 2px; user-select: none; opacity: .7;
}

/* ── Mobile ── */
@media (max-width: 575.98px) {
    .pgn-wrap { width: 100%; }
    .pgn-inner {
        flex-wrap: wrap;
        justify-content: center;
        width: 100%;
        padding: .25rem .5rem;
        gap: .25rem;
    }
    .pgn-inner::-webkit-scrollbar { display: none; }
    .pgn-nav, .pgn-num { height: 34px; flex-shrink: 0; }
    .pgn-nav { width: 34px; }
    .pgn-num { min-width: 34px; font-size: .75rem; }
    .pgn-ellipsis { height: 34px; font-size: .7rem; flex-shrink: 0; }
    .pgn-info { font-size: .78rem; text-align: center; }
}
</style>
@endverbatim
