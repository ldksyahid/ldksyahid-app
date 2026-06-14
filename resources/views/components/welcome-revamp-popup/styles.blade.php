<style>
/* ── Welcome Muharram 1448 H Popup  (prefix: wrp-) ─────────────────── */

#wrp-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100%; height: 100%;
    background: rgba(2, 5, 18, .78);
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
    background: #080d1c;
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid rgba(180, 150, 60, .22);
    box-shadow: 0 0 60px rgba(180, 130, 20, .08), 0 28px 64px rgba(0, 0, 0, .5);
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
    background: linear-gradient(160deg, #08122e 0%, #0f1f50 55%, #080f2a 100%);
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
    background: rgba(210, 170, 50, .15);
    border: 1px solid rgba(210, 170, 50, .35);
    border-radius: 50px; padding: .22rem .75rem;
    font-size: .63rem; font-weight: 700; letter-spacing: .09em;
    text-transform: uppercase; color: #d4a830;
    margin-top: .55rem; margin-bottom: .45rem;
    position: relative; z-index: 1;
}
#wrp-badge i { font-size: .58rem; }

#wrp-header h2 {
    font-size: 1.15rem; font-weight: 800; color: #fff;
    margin: 0; line-height: 1.3;
    position: relative; z-index: 1;
    letter-spacing: -.015em;
}
#wrp-header p {
    font-size: .7rem; color: rgba(255, 255, 255, .45);
    margin-top: .3rem; line-height: 1.55;
    position: relative; z-index: 1;
}

/* ── Body ── */
#wrp-body {
    padding: .9rem 1.2rem .7rem;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
    background: #080d1c;
}

/* ── Game ── */
#wrp-game-area {
    background: #060b18;
    border: 1px solid rgba(180, 150, 60, .18);
    border-radius: 13px;
    padding: .65rem;
    margin-bottom: .65rem;
}
#wrp-game-label {
    font-size: .63rem; color: #a07828;
    text-align: center; margin-bottom: .45rem;
    letter-spacing: .07em; text-transform: uppercase; font-weight: 700;
}
#wrp-canvas {
    display: block; width: 100%; height: 120px;
    cursor: crosshair; border-radius: 9px;
    background: #04081a;
    border: 1px solid rgba(80, 60, 10, .3);
}
#wrp-score-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: .45rem;
}
#wrp-score {
    font-size: .72rem; color: #c9a030; font-weight: 700;
}
#wrp-timer {
    font-size: .72rem; color: rgba(255, 255, 255, .35);
    transition: color .3s;
}
#wrp-game-msg {
    font-size: .68rem; color: #4b5563;
    text-align: center; margin: .4rem 0 0;
    min-height: 1em; transition: color .2s;
}

/* ── Features ── */
#wrp-features { display: flex; flex-direction: column; gap: .32rem; margin-bottom: .65rem; }

.wrp-feat {
    display: flex; align-items: center; gap: .55rem;
    background: #0c1530;
    border: 1px solid rgba(180, 150, 60, .1);
    border-radius: 10px; padding: .42rem .65rem;
    transition: background .18s;
}
.wrp-feat:hover { background: #101d40; }
.wrp-feat-icon {
    width: 26px; height: 26px; border-radius: 7px; flex-shrink: 0;
    background: linear-gradient(135deg, #6b4a00, #b8820a);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .65rem;
}
.wrp-feat-text {
    font-size: .72rem; color: #b0bcd4; line-height: 1.45; font-weight: 500;
}
.wrp-feat-text strong { color: #d4a830; }

/* ── Footer ── */
#wrp-footer {
    flex-shrink: 0;
    display: flex; flex-direction: column; gap: .4rem;
    padding: .65rem 1.2rem 1.1rem;
    background: #080d1c;
}

#wrp-btn-share {
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    background: linear-gradient(135deg, #b8820a, #e8b020);
    color: #0a0600; border: none;
    font-size: .82rem; font-weight: 800;
    padding: .72rem 1.5rem; border-radius: 50px;
    cursor: pointer; width: 100%;
    letter-spacing: .01em;
    transition: transform .2s ease, filter .2s ease;
}
#wrp-btn-share i { color: #0a0600; }
#wrp-btn-share:hover { transform: translateY(-2px); filter: brightness(1.1); }
#wrp-btn-share:active { transform: scale(.97); }

#wrp-share-fallback {
    display: none;
    font-size: .68rem; color: #6b7280;
    text-align: center; padding: .3rem .5rem; line-height: 1.55;
}
#wrp-share-fallback a { color: #c9a030; text-decoration: underline; }

#wrp-btn-dismiss {
    background: none; border: none;
    font-size: .7rem; color: #374151;
    cursor: pointer; padding: .18rem;
    text-decoration: underline; text-underline-offset: 3px;
    transition: color .18s; width: 100%; text-align: center;
}
#wrp-btn-dismiss:hover { color: #6b7280; }

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
[data-theme="dark"] #wrp-card { background: #05080f; }
[data-theme="dark"] #wrp-body { background: #05080f; }
[data-theme="dark"] #wrp-footer { background: #05080f; }
[data-theme="dark"] #wrp-game-area { background: #030610; }
[data-theme="dark"] .wrp-feat { background: #080f22; }
[data-theme="dark"] .wrp-feat:hover { background: #0c1530; }
[data-theme="dark"] .wrp-feat-text { color: #9dafc8; }
[data-theme="dark"] #wrp-btn-dismiss { color: #4b5563; }
[data-theme="dark"] #wrp-btn-dismiss:hover { color: #6b7280; }
</style>