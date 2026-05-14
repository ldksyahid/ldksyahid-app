<style>
/* ── Welcome Revamp Popup  (prefix: wrp-) ─────────────────────── */
#wrp-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100%; height: 100%;
    background: rgba(8, 4, 16, .65);
    backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    z-index: 99998;
    display: flex; align-items: center; justify-content: center;
    padding: 1.25rem 1rem;
    opacity: 0; visibility: hidden;
    transition: opacity .4s ease, visibility .4s ease;
    transform: translateZ(0);
    will-change: transform;
}
#wrp-backdrop.active { opacity: 1; visibility: visible; }

/* ── Outer wrapper — animation ── */
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
    box-shadow: 0 28px 64px rgba(0,0,0,.16), 0 6px 22px rgba(109,40,217,.12);
    position: relative;
    display: flex;
    flex-direction: column;
    max-height: calc(100svh - 2.5rem);
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
    line-height: 1; flex-shrink: 0;
}
#wrp-x:hover { background: rgba(255,255,255,.45); transform: scale(1.12); }

/* ── Header — flex-shrink:0 agar tidak terpotong ── */
#wrp-header {
    flex-shrink: 0;
    background: linear-gradient(145deg, #5b21b6 0%, #9333ea 50%, #7c3aed 100%);
    padding: 2rem 1.75rem 1.5rem;
    text-align: center;
    position: relative; overflow: hidden;
}
#wrp-header::before {
    content: '';
    position: absolute; top: -36px; right: -36px;
    width: 160px; height: 160px; border-radius: 50%;
    background: rgba(255,255,255,.09); pointer-events: none;
}
#wrp-header::after {
    content: '';
    position: absolute; bottom: -44px; left: -24px;
    width: 130px; height: 130px; border-radius: 50%;
    background: rgba(255,255,255,.07); pointer-events: none;
}
#wrp-header-dot1, #wrp-header-dot2 {
    position: absolute; border-radius: 50%;
    pointer-events: none; background: rgba(255,255,255,.18);
}
#wrp-header-dot1 { width: 10px; height: 10px; top: 22px; left: 28px; }
#wrp-header-dot2 { width:  6px; height:  6px; top: 42px; left: 52px; }

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
    text-shadow: 0 2px 14px rgba(0,0,0,.18);
    letter-spacing: -.015em;
}

/* ── Body — flex:1 + overflow scroll ── */
#wrp-body {
    padding: 1.25rem 1.5rem 1rem;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
}

#wrp-desc {
    font-size: .815rem; color: #6b7280; line-height: 1.7;
    margin: 0 0 1rem; text-align: center;
}

/* ── Features ── */
#wrp-features { display: flex; flex-direction: column; gap: .42rem; margin-bottom: .9rem; }

.wrp-feat {
    display: flex; align-items: center; gap: .7rem;
    background: #faf5ff;
    border: 1px solid rgba(109,40,217,.12);
    border-radius: 11px; padding: .52rem .8rem;
    transition: background .18s;
}
.wrp-feat:hover { background: #f3e8ff; }
.wrp-feat-icon {
    width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #6d28d9, #a855f7);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .76rem;
    box-shadow: 0 3px 8px rgba(109,40,217,.3);
}
.wrp-feat-text {
    font-size: .79rem; color: #374151; font-weight: 500; line-height: 1.4;
}

/* ══════════════════════════════════════════════════════
   MINI GAME — Kambing Runner  (Chrome Dino style)
   ══════════════════════════════════════════════════════ */
#wrp-minigame {
    border-radius: 12px;
    overflow: hidden;
    border: 1.5px solid rgba(167,139,250,.28);
    background: #1c0a35;
}
#wrp-game-label {
    font-size: .67rem; font-weight: 700;
    color: #d8b4fe;
    background: rgba(109,40,217,.42);
    padding: .3rem .75rem;
    text-align: center;
    border-bottom: 1px solid rgba(167,139,250,.18);
    font-family: monospace; letter-spacing: .04em;
}
#wrp-dino-canvas {
    width: 100%;
    height: 145px;
    display: block;
    cursor: pointer;
    touch-action: none;
    -webkit-user-select: none; user-select: none;
}
#wrp-game-hint {
    font-size: .6rem; color: rgba(192,132,252,.6);
    text-align: center; margin: 0;
    padding: .22rem .5rem;
    background: rgba(0,0,0,.22);
    font-family: monospace;
}

/* ── Footer — flex-shrink:0 agar tidak terpotong ── */
#wrp-footer {
    flex-shrink: 0;
    display: flex; flex-direction: column; gap: .55rem;
    padding: .875rem 1.5rem 1.5rem;
}
#wrp-btn-explore {
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    background: linear-gradient(135deg, #6d28d9, #a855f7);
    color: #fff; border: none;
    font-size: .88rem; font-weight: 700;
    padding: .8rem 1.5rem; border-radius: 50px;
    cursor: pointer;
    box-shadow: 0 5px 18px rgba(109,40,217,.4);
    transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
}
#wrp-btn-explore:hover {
    transform: translateY(-2px);
    box-shadow: 0 9px 26px rgba(109,40,217,.5);
    filter: brightness(1.06);
}
#wrp-btn-dismiss {
    background: none; border: none;
    font-size: .76rem; color: #9ca3af;
    cursor: pointer; padding: .25rem;
    text-decoration: underline; text-underline-offset: 3px;
    transition: color .18s;
}
#wrp-btn-dismiss:hover { color: #6b7280; }

/* ── Responsive ── */
@media (max-width: 480px) {
    #wrp-card { border-radius: 22px; }
    #wrp-x { top: .875rem; right: .875rem; width: 34px; height: 34px; }
    #wrp-header { padding: 1.75rem 3rem 1.25rem; }
    #wrp-header h2 { font-size: 1.15rem; }
    #wrp-body { padding: 1rem 1.25rem .875rem; }
    #wrp-footer { padding: .75rem 1.25rem 1.25rem; }
    #wrp-dino-canvas { height: 130px; }
}

/* ── Dark Mode ── */
[data-theme="dark"] #wrp-card { background: #1a1428; }
[data-theme="dark"] #wrp-desc { color: #9ca3af; }
[data-theme="dark"] .wrp-feat { background: #2d1a4a; border-color: rgba(109,40,217,.2); }
[data-theme="dark"] .wrp-feat:hover { background: #3b1f5e; }
[data-theme="dark"] .wrp-feat-text { color: #d1d5db; }
[data-theme="dark"] #wrp-btn-dismiss { color: #6b7280; }
[data-theme="dark"] #wrp-btn-dismiss:hover { color: #9ca3af; }
</style>
