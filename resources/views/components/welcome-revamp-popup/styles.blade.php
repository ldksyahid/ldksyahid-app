<style>
/* ── Welcome 17 Agustus / HUT RI ke-81 Popup  (prefix: wrp-) ─────────────────── */

#wrp-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100%; height: 100%;
    background: rgba(18, 2, 2, .78);
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
    max-width: 420px; width: 100%;
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
    background: #1a0606;
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid rgba(220, 40, 40, .25);
    box-shadow: 0 0 60px rgba(200, 20, 20, .1), 0 28px 64px rgba(0, 0, 0, .5);
    position: relative;
    display: flex;
    flex-direction: column;
    max-height: calc(100svh - 2.5rem);
}

/* ── Close X ── */
#wrp-x {
    position: absolute; top: .8rem; right: .8rem;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(255, 255, 255, .1); border: none;
    color: rgba(255, 255, 255, .7); font-size: .62rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 10;
    transition: background .2s, transform .18s;
    line-height: 1; flex-shrink: 0;
}
#wrp-x:hover { background: rgba(255, 255, 255, .22); transform: scale(1.1); }

/* ── Header ── */
#wrp-header {
    flex-shrink: 0;
    background: linear-gradient(160deg, #2e0808 0%, #7a1010 55%, #1c0505 100%);
    padding: 1.5rem 1.75rem 1.1rem;
    text-align: center;
    position: relative; overflow: hidden;
}

#wrp-moon-canvas {
    display: block;
    width: 100%; height: 90px;
}

#wrp-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .35);
    border-radius: 50px; padding: .22rem .75rem;
    font-size: .63rem; font-weight: 700; letter-spacing: .09em;
    text-transform: uppercase; color: #ffffff;
    margin-top: .55rem; margin-bottom: .45rem;
    position: relative; z-index: 1;
}
#wrp-badge i { font-size: .58rem; color: #ff4444; }

#wrp-header h2 {
    font-size: 1.15rem; font-weight: 800; color: #fff;
    margin: 0; line-height: 1.3;
    position: relative; z-index: 1;
    letter-spacing: -.015em;
}
#wrp-header p {
    font-size: .7rem; color: rgba(255, 255, 255, .5);
    margin-top: .3rem; line-height: 1.55;
    position: relative; z-index: 1;
}

/* ── Body ── */
#wrp-body {
    padding: .9rem 1.2rem .7rem;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
    background: #1a0606;
}

/* ── Game ── */
#wrp-game-area {
    background: #140404;
    border: 1px solid rgba(220, 40, 40, .2);
    border-radius: 13px;
    padding: .65rem;
    margin-bottom: .65rem;
}
#wrp-game-label {
    font-size: .63rem; color: #e05050;
    text-align: center; margin-bottom: .45rem;
    letter-spacing: .07em; text-transform: uppercase; font-weight: 700;
}
#wrp-canvas {
    display: block; width: 100%; height: 120px;
    cursor: crosshair; border-radius: 9px;
    background: #0d0303;
    border: 1px solid rgba(120, 20, 20, .3);
}
#wrp-score-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: .45rem;
}
#wrp-score {
    font-size: .72rem; color: #ff6b6b; font-weight: 700;
}
#wrp-timer {
    font-size: .72rem; color: rgba(255, 255, 255, .35);
    transition: color .3s;
}
#wrp-game-msg {
    font-size: .68rem; color: #6b5252;
    text-align: center; margin: .4rem 0 0;
    min-height: 1em; transition: color .2s;
}

/* ── Features ── */
#wrp-features { display: flex; flex-direction: column; gap: .32rem; margin-bottom: .65rem; }

.wrp-feat {
    display: flex; align-items: center; gap: .55rem;
    background: #240a0a;
    border: 1px solid rgba(220, 40, 40, .12);
    border-radius: 10px; padding: .42rem .65rem;
    transition: background .18s;
}
.wrp-feat:hover { background: #300d0d; }
.wrp-feat-icon {
    width: 26px; height: 26px; border-radius: 7px; flex-shrink: 0;
    background: linear-gradient(135deg, #7a0e0e, #e02929);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .65rem;
}
.wrp-feat-text {
    font-size: .72rem; color: #d4bcbc; line-height: 1.45; font-weight: 500;
}
.wrp-feat-text strong { color: #ff5c5c; }

/* ── Footer ── */
#wrp-footer {
    flex-shrink: 0;
    display: flex; flex-direction: column; gap: .4rem;
    padding: .65rem 1.2rem 1.1rem;
    background: #1a0606;
}

#wrp-btn-share {
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    background: linear-gradient(135deg, #b81616, #ff4444);
    color: #ffffff; border: none;
    font-size: .82rem; font-weight: 800;
    padding: .72rem 1.5rem; border-radius: 50px;
    cursor: pointer; width: 100%;
    letter-spacing: .01em;
    transition: transform .2s ease, filter .2s ease;
}
#wrp-btn-share i { color: #ffffff; }
#wrp-btn-share:hover { transform: translateY(-2px); filter: brightness(1.1); }
#wrp-btn-share:active { transform: scale(.97); }

#wrp-share-fallback {
    display: none;
    font-size: .68rem; color: #8a7070;
    text-align: center; padding: .3rem .5rem; line-height: 1.55;
}
#wrp-share-fallback a { color: #ff6b6b; text-decoration: underline; }

#wrp-btn-dismiss {
    background: none; border: none;
    font-size: .7rem; color: #5c4444;
    cursor: pointer; padding: .18rem;
    text-decoration: underline; text-underline-offset: 3px;
    transition: color .18s; width: 100%; text-align: center;
}
#wrp-btn-dismiss:hover { color: #8a7070; }

/* ── Responsive ── */
@media (max-width: 480px) {
    #wrp-card { border-radius: 18px; }
    #wrp-x { top: .7rem; right: .7rem; }
    #wrp-header { padding: 1.25rem 3rem .9rem; }
    #wrp-header h2 { font-size: 1rem; }
    #wrp-body { padding: .75rem 1rem .6rem; }
    #wrp-footer { padding: .6rem 1rem 1rem; }
}

/* ── Dark mode (ikut data-theme="dark") ── */
[data-theme="dark"] #wrp-card { background: #100303; }
[data-theme="dark"] #wrp-body { background: #100303; }
[data-theme="dark"] #wrp-footer { background: #100303; }
[data-theme="dark"] #wrp-game-area { background: #0a0202; }
[data-theme="dark"] .wrp-feat { background: #1a0505; }
[data-theme="dark"] .wrp-feat:hover { background: #240a0a; }
[data-theme="dark"] .wrp-feat-text { color: #c4a8a8; }
[data-theme="dark"] #wrp-btn-dismiss { color: #4b3939; }
[data-theme="dark"] #wrp-btn-dismiss:hover { color: #8a7070; }
</style>