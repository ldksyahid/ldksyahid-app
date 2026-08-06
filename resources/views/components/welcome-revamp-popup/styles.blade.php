<style>
/* ── Welcome 17 Agustus / HUT RI ke-81 Popup (prefix: wrp-) — REVAMP ─────────── */

#wrp-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100%; height: 100%;
    background: radial-gradient(ellipse at 50% 30%, rgba(90, 10, 10, .55), rgba(10, 0, 0, .86) 70%);
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    z-index: 99998;
    display: flex; align-items: center; justify-content: center;
    padding: 1.25rem 1rem;
    opacity: 0; visibility: hidden;
    transition: opacity .4s ease, visibility .4s ease;
    transform: translateZ(0);
    will-change: transform;
    overflow: hidden;
}
#wrp-backdrop.active { opacity: 1; visibility: visible; }

/* ── Full-screen confetti/fireworks layer ── */
#wrp-confetti-canvas {
    position: absolute; top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    z-index: 1;
}

/* ── Outer wrapper — entry animation ── */
#wrp-outer {
    position: relative;
    max-width: 430px; width: 100%;
    z-index: 2;
    transform: translateY(40px) scale(.9);
    opacity: 0;
    transition: transform .55s cubic-bezier(.34, 1.56, .64, 1), opacity .4s ease;
}
#wrp-backdrop.active #wrp-outer {
    transform: translateY(0) scale(1);
    opacity: 1;
}

/* ── Card ── */
#wrp-card {
    background: linear-gradient(180deg, #260808 0%, #1a0606 40%, #120404 100%);
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(255, 90, 90, .28);
    box-shadow:
        0 0 0 1px rgba(255,255,255,.04) inset,
        0 0 70px rgba(220, 30, 30, .22),
        0 0 140px rgba(255, 60, 60, .08),
        0 30px 70px rgba(0, 0, 0, .6);
    position: relative;
    display: flex;
    flex-direction: column;
    max-height: calc(100svh - 2.5rem);
}
/* floating ambient glow blobs inside card */
#wrp-card::before,
#wrp-card::after {
    content: '';
    position: absolute;
    width: 180px; height: 180px;
    border-radius: 50%;
    filter: blur(70px);
    pointer-events: none;
    z-index: 0;
}
#wrp-card::before {
    top: -60px; right: -40px;
    background: rgba(255, 60, 60, .28);
}
#wrp-card::after {
    bottom: -60px; left: -40px;
    background: rgba(255, 180, 40, .14);
}

/* ── Close X ── */
#wrp-x {
    position: absolute; top: .8rem; right: .8rem;
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(255, 255, 255, .12); border: none;
    color: rgba(255, 255, 255, .8); font-size: .64rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 12;
    transition: background .2s, transform .18s;
    line-height: 1; flex-shrink: 0;
}
#wrp-x:hover { background: rgba(255, 255, 255, .26); transform: scale(1.12) rotate(90deg); }

/* ── Header ── */
#wrp-header {
    flex-shrink: 0;
    background: linear-gradient(160deg, #300a0a 0%, #8a1212 55%, #1e0505 100%);
    padding: 1.5rem 1.75rem 1.1rem;
    text-align: center;
    position: relative; overflow: hidden;
}
#wrp-header::after {
    content: '';
    position: absolute; top: -60%; left: -60%;
    width: 220%; height: 220%;
    background: linear-gradient(115deg, transparent 42%, rgba(255,255,255,.06) 48%, rgba(255,255,255,.02) 52%, transparent 58%);
    animation: wrp-shine 5s ease-in-out infinite;
    pointer-events: none;
}
@keyframes wrp-shine {
    0%, 60% { transform: translateX(-40%) rotate(8deg); opacity: 0; }
    75% { opacity: 1; }
    100% { transform: translateX(40%) rotate(8deg); opacity: 0; }
}

#wrp-moon-canvas {
    display: block;
    width: 100%; height: 96px;
    position: relative; z-index: 1;
}

@keyframes wrp-fadeup {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}
#wrp-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .4);
    border-radius: 50px; padding: .24rem .8rem;
    font-size: .63rem; font-weight: 800; letter-spacing: .09em;
    text-transform: uppercase; color: #ffffff;
    margin-top: .55rem; margin-bottom: .45rem;
    position: relative; z-index: 1;
    box-shadow: 0 0 16px rgba(255, 60, 60, .35);
    animation: wrp-fadeup .6s ease both;
}
#wrp-badge i { font-size: .58rem; color: #ff4444; animation: wrp-pulse 1.6s ease-in-out infinite; }
@keyframes wrp-pulse { 0%,100%{ transform: scale(1);} 50%{ transform: scale(1.25);} }

#wrp-header h2 {
    font-size: 1.18rem; font-weight: 800; color: #fff;
    margin: 0; line-height: 1.3;
    position: relative; z-index: 1;
    letter-spacing: -.015em;
    text-shadow: 0 0 24px rgba(255, 90, 90, .45);
    animation: wrp-fadeup .6s .1s ease both;
}
#wrp-header p {
    font-size: .7rem; color: rgba(255, 255, 255, .55);
    margin-top: .3rem; line-height: 1.55;
    position: relative; z-index: 1;
    animation: wrp-fadeup .6s .2s ease both;
}

/* ── Body ── */
#wrp-body {
    padding: .9rem 1.2rem .7rem;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
    background: transparent;
    position: relative; z-index: 1;
}

/* ── Kado HUT RI ke-81 ── */
#wrp-gift {
    border-radius: 14px;
    padding: .2rem 0 .75rem;
    margin-bottom: .6rem;
    text-align: center;
}
#wrp-gift-box {
    position: relative;
    display: inline-flex; flex-direction: column; align-items: center;
    cursor: pointer; user-select: none;
    padding: .4rem 1.2rem;
    transition: transform .2s;
}
#wrp-gift-box:hover #wrp-gift-lid { transform: translateY(-3px); }
#wrp-gift-box:active { transform: scale(.96); }
#wrp-gift-box:focus-visible { outline: 2px solid #ff5c5c; border-radius: 10px; }
#wrp-gift-lid {
    color: #ff5c5c;
    font-size: 1.7rem;
    background: rgba(255, 60, 60, .12);
    width: 52px; height: 40px; border-radius: 9px 9px 3px 3px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 0 18px rgba(255, 60, 60, .35);
    transition: transform .2s;
    animation: wrp-gift-bob 2.4s ease-in-out infinite;
}
@keyframes wrp-gift-bob {
    0%,100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
}
#wrp-gift-body {
    color: #ff8080;
    font-size: 1.5rem;
    width: 52px; height: 34px;
    background: rgba(255, 60, 60, .08);
    border-radius: 0 0 9px 9px;
    display: flex; align-items: center; justify-content: center;
    margin-top: -2px;
}
#wrp-gift-hint {
    font-size: .66rem; color: #ff9a9a;
    margin-top: .5rem; letter-spacing: .04em;
    animation: wrp-pulse 2s ease-in-out infinite;
}

/* Reveal card */
#wrp-gift-reveal { animation: wrp-fadeup .5s ease both; }
#wrp-gift-card {
    background: linear-gradient(150deg, #3a0d0d, #240808);
    border: 1px solid rgba(255, 150, 90, .35);
    border-radius: 14px;
    padding: 1rem 1.1rem;
    position: relative;
    box-shadow: 0 0 30px rgba(255, 140, 60, .18);
    margin-top: .2rem;
}
#wrp-gift-card-emblem {
    font-size: 2rem; line-height: 1; margin-bottom: .3rem;
}
#wrp-gift-card h3 {
    font-size: .95rem; color: #ffcf7a; margin: 0 0 .4rem;
    font-weight: 800;
}
#wrp-gift-card-message {
    font-size: .72rem; color: #f0dede; line-height: 1.6; margin: 0 0 .5rem;
}
#wrp-gift-card-doa {
    background: rgba(255, 255, 255, .06);
    border-left: 3px solid #ffcf7a;
    border-radius: 7px;
    padding: .5rem .6rem;
    font-size: .68rem; color: #d8c4a8; line-height: 1.6;
    text-align: left; margin-bottom: .7rem;
}
#wrp-gift-card-doa strong { color: #ffcf7a; }
#wrp-btn-gift-share {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    background: linear-gradient(135deg, #ffb347, #ff5c5c);
    color: #fff; border: none;
    font-size: .78rem; font-weight: 800;
    padding: .55rem 1.1rem; border-radius: 50px;
    cursor: pointer; transition: transform .2s, filter .2s;
}
#wrp-btn-gift-share:hover { transform: translateY(-2px); filter: brightness(1.08); }
#wrp-gift-reveal[hidden] { display: none; }

/* ── Game ── */
#wrp-game-area {
    background: rgba(20, 4, 4, .85);
    border: 1px solid rgba(220, 40, 40, .22);
    border-radius: 14px;
    padding: .65rem;
    margin-bottom: .65rem;
    box-shadow: 0 0 20px rgba(220, 30, 30, .08);
}
#wrp-game-top {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: .45rem;
}
#wrp-game-label {
    font-size: .63rem; color: #e05050;
    text-align: center;
    letter-spacing: .07em; text-transform: uppercase; font-weight: 700;
}
#wrp-best {
    font-size: .66rem; color: #ffcf7a; font-weight: 700;
    display: inline-flex; align-items: center; gap: .25rem;
}
#wrp-best i { color: #ffd43b; }
#wrp-canvas {
    display: block; width: 100%; height: 120px;
    cursor: crosshair; border-radius: 10px;
    background: #0d0303;
    border: 1px solid rgba(120, 20, 20, .35);
}
#wrp-score-row {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: .45rem;
}
#wrp-score {
    font-size: .72rem; color: #ff6b6b; font-weight: 700;
}
#wrp-combo {
    font-size: .7rem; color: #ff9a3c; font-weight: 700;
    transition: transform .12s;
}
#wrp-combo.pop { animation: wrp-pop .25s ease; }
@keyframes wrp-pop { 0%{ transform: scale(1);} 50%{ transform: scale(1.35);} 100%{ transform: scale(1);} }
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
    background: rgba(36, 10, 10, .85);
    border: 1px solid rgba(220, 40, 40, .13);
    border-radius: 11px; padding: .42rem .65rem;
    transition: background .18s, transform .18s;
    animation: wrp-fadeup .5s ease both;
}
.wrp-feat:nth-child(1) { animation-delay: .15s; }
.wrp-feat:nth-child(2) { animation-delay: .25s; }
.wrp-feat:nth-child(3) { animation-delay: .35s; }
.wrp-feat:hover { background: #300d0d; transform: translateX(3px); }
.wrp-feat-icon {
    width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #7a0e0e, #e02929);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .68rem;
    box-shadow: 0 0 12px rgba(224, 41, 41, .35);
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
    background: transparent;
    position: relative; z-index: 1;
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
    box-shadow: 0 6px 20px rgba(255, 60, 60, .3);
}
#wrp-btn-share i { color: #ffffff; }
#wrp-btn-share:hover { transform: translateY(-2px); filter: brightness(1.1); }
#wrp-btn-share:active { transform: scale(.97); }

#wrp-share-row {
    display: flex; gap: .4rem; justify-content: center;
}
.wrp-share-btn {
    flex: 1;
    display: flex; align-items: center; justify-content: center; gap: .3rem;
    background: rgba(255, 255, 255, .08);
    border: 1px solid rgba(255, 255, 255, .14);
    color: #e6d0d0; border-radius: 10px;
    font-size: .7rem; font-weight: 700;
    padding: .45rem 0; cursor: pointer;
    transition: background .2s, transform .18s, border-color .2s;
}
.wrp-share-btn:hover { background: rgba(255, 255, 255, .16); transform: translateY(-1px); }
.wrp-share-btn:active { transform: scale(.95); }
.wrp-share-btn .fab, .wrp-share-btn .fas { font-size: .8rem; }
#wrp-share-copy i { color: #7fd0ff; }
#wrp-share-wa i { color: #25d366; }
#wrp-share-fb i { color: #1877f2; }
#wrp-share-x i { color: #e6e6e6; }
#wrp-share-copy.copied { background: rgba(40, 167, 69, .25); border-color: #2ecc71; color: #7fffa0; }

#wrp-share-fallback {
    display: none;
    font-size: .68rem; color: #8a7070;
    text-align: center; padding: .3rem .5rem; line-height: 1.55;
}
#wrp-share-fallback b { color: #ff6b6b; }

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
    #wrp-card { border-radius: 20px; }
    #wrp-x { top: .7rem; right: .7rem; }
    #wrp-header { padding: 1.25rem 3rem .9rem; }
    #wrp-header h2 { font-size: 1.02rem; }
    #wrp-body { padding: .75rem 1rem .6rem; }
    #wrp-footer { padding: .6rem 1rem 1rem; }
    .wrp-share-btn { font-size: .64rem; }
    .wrp-share-btn span { display: none; }
    .wrp-share-btn { flex: 0 1 44px; }
}

/* ── Dark mode (ikut data-theme="dark") ── */
[data-theme="dark"] #wrp-card { background: linear-gradient(180deg, #160404 0%, #100303 40%, #0a0202 100%); }
[data-theme="dark"] #wrp-card::before { background: rgba(255, 50, 50, .18); }
[data-theme="dark"] #wrp-card::after { background: rgba(255, 170, 40, .1); }
[data-theme="dark"] #wrp-game-area { background: rgba(10, 2, 2, .9); }
[data-theme="dark"] .wrp-feat { background: rgba(26, 5, 5, .9); }
[data-theme="dark"] .wrp-feat:hover { background: #240a0a; }
[data-theme="dark"] .wrp-feat-text { color: #c4a8a8; }
[data-theme="dark"] #wrp-btn-dismiss { color: #4b3939; }
[data-theme="dark"] #wrp-btn-dismiss:hover { color: #8a7070; }
</style>
