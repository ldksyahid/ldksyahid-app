<style>
/* ── Welcome Revamp Popup  (prefix: wrp-) ─────────────────────── */
#wrp-backdrop {
    position: fixed; inset: 0;
    background: rgba(8, 16, 24, .62);
    backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    z-index: 99998;
    display: flex; align-items: center; justify-content: center;
    padding: 1.25rem 1rem;
    opacity: 0; visibility: hidden;
    transition: opacity .4s ease, visibility .4s ease;
}
#wrp-backdrop.active { opacity: 1; visibility: visible; }

/* ── Outer wrapper — handle animasi ── */
#wrp-outer {
    position: relative;
    max-width: 430px; width: 100%;
    transform: translateY(36px) scale(.93);
    opacity: 0;
    transition: transform .5s cubic-bezier(.34, 1.56, .64, 1), opacity .38s ease;
}
#wrp-backdrop.active #wrp-outer {
    transform: translateY(0) scale(1);
    opacity: 1;
}

/* ── Card ── */
#wrp-card {
    background: #fff;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 28px 64px rgba(0,0,0,.16), 0 6px 22px rgba(0,167,157,.1);
    position: relative;
}

/* ── Close X ── */
#wrp-x {
    position: absolute; top: 1rem; right: 1rem;
    width: 32px; height: 32px; border-radius: 50%;
    background: rgba(255,255,255,.25); border: none;
    color: #fff; font-size: .72rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 10;
    transition: background .2s, transform .18s;
    line-height: 1;
    flex-shrink: 0;
}
#wrp-x:hover { background: rgba(255,255,255,.45); transform: scale(1.12); }

/* ── Header ── */
#wrp-header {
    background: linear-gradient(145deg, #00b5aa 0%, #00c9bb 50%, #0097a7 100%);
    padding: 2rem 1.75rem 1.5rem;
    text-align: center;
    position: relative; overflow: hidden;
}
#wrp-header::before {
    content: '';
    position: absolute; top: -36px; right: -36px;
    width: 160px; height: 160px; border-radius: 50%;
    background: rgba(255,255,255,.09);
    pointer-events: none;
}
#wrp-header::after {
    content: '';
    position: absolute; bottom: -44px; left: -24px;
    width: 130px; height: 130px; border-radius: 50%;
    background: rgba(255,255,255,.07);
    pointer-events: none;
}
#wrp-header-dot1, #wrp-header-dot2 {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
    background: rgba(255,255,255,.18);
}
#wrp-header-dot1 { width: 10px; height: 10px; top: 22px; left: 28px; }
#wrp-header-dot2 { width: 6px;  height: 6px;  top: 42px; left: 52px; }

#wrp-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: rgba(255,255,255,.2);
    border: 1px solid rgba(255,255,255,.38);
    border-radius: 50px; padding: .26rem .82rem;
    font-size: .68rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #fff;
    margin-bottom: .7rem;
    position: relative; z-index: 1;
    backdrop-filter: blur(6px);
}
#wrp-badge i { font-size: .6rem; }

#wrp-header h2 {
    font-size: 1.35rem; font-weight: 800; color: #fff;
    margin: 0; line-height: 1.3;
    position: relative; z-index: 1;
    text-shadow: 0 2px 14px rgba(0,0,0,.14);
    letter-spacing: -.015em;
}

/* ── Body ── */
#wrp-body { padding: 1.25rem 1.5rem 1rem; }

#wrp-desc {
    font-size: .815rem; color: #6b7280; line-height: 1.7;
    margin: 0 0 1rem;
    text-align: center;
}

#wrp-features { display: flex; flex-direction: column; gap: .42rem; }

.wrp-feat {
    display: flex; align-items: center; gap: .7rem;
    background: #f0fefa;
    border: 1px solid rgba(0,167,157,.12);
    border-radius: 11px; padding: .52rem .8rem;
    transition: background .18s;
}
.wrp-feat:hover { background: #e2f8f5; }
.wrp-feat-icon {
    width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #00a79d, #00d2c5);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .76rem;
    box-shadow: 0 3px 8px rgba(0,167,157,.28);
}
.wrp-feat-text {
    font-size: .79rem; color: #374151; font-weight: 500; line-height: 1.4;
}

/* ── Footer ── */
#wrp-footer {
    display: flex; flex-direction: column; gap: .42rem;
    padding: .875rem 1.5rem 1.5rem;
}
#wrp-btn-explore {
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    background: linear-gradient(135deg, #00a79d, #00c4b8);
    color: #fff; border: none;
    font-size: .88rem; font-weight: 700;
    padding: .8rem 1.5rem; border-radius: 50px;
    cursor: pointer;
    box-shadow: 0 5px 18px rgba(0,167,157,.38);
    transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
}
#wrp-btn-explore:hover {
    transform: translateY(-2px);
    box-shadow: 0 9px 26px rgba(0,167,157,.48);
    filter: brightness(1.06);
}
/* ── Responsive ── */
@media (max-width: 480px) {
    #wrp-card { border-radius: 22px; }
    #wrp-x { top: .875rem; right: .875rem; width: 34px; height: 34px; }
    #wrp-header { padding: 1.75rem 3rem 1.25rem; } /* kanan lebih lebar agar x tidak overlap teks */
    #wrp-header h2 { font-size: 1.15rem; }
    #wrp-body { padding: 1rem 1.25rem .875rem; }
    #wrp-footer { padding: .75rem 1.25rem 1.25rem; }
}
</style>
