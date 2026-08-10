<style>
/* ── Welcome Gemilang Popup  (prefix: wrp-)
   Concept: Gemilang (Perunggu) — Istiqomah, Doa Orang Tua, Masa Terang
   Color: sunrise gold / amber ─────────────────────────────────────── */

#wrp-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    width: 100%; height: 100%;
    background: rgba(0, 0, 0, .25);
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

/* ── Outer — animation ── */
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
    background: #fffbeb;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 28px 64px rgba(120, 53, 15, .14), 0 6px 22px rgba(217, 119, 6, .14);
    position: relative;
    display: flex;
    flex-direction: column;
    max-height: calc(100svh - 2.5rem);
}

/* ── Close X ── */
#wrp-x {
    position: absolute; top: .85rem; right: .85rem;
    width: 28px; height: 28px; border-radius: 50%;
    background: rgba(180, 83, 9, .14); border: none;
    color: rgba(120, 53, 15, .65); font-size: .62rem;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; z-index: 10;
    transition: background .2s, transform .18s;
    line-height: 1; flex-shrink: 0;
}
#wrp-x:hover { background: rgba(180, 83, 9, .28); transform: scale(1.1); }

/* ── Header ── */
#wrp-header {
    flex-shrink: 0;
    background: linear-gradient(145deg, #d97706 0%, #f59e0b 50%, #b45309 100%);
    padding: 2rem 1.75rem 1.5rem;
    text-align: center;
    position: relative; overflow: hidden;
}
#wrp-header::before {
    content: '';
    position: absolute; top: -36px; right: -36px;
    width: 160px; height: 160px; border-radius: 50%;
    background: rgba(255, 255, 255, .12); pointer-events: none;
}
#wrp-header::after {
    content: '';
    position: absolute; bottom: -44px; left: -24px;
    width: 130px; height: 130px; border-radius: 50%;
    background: rgba(255, 255, 255, .08); pointer-events: none;
}

#wrp-header-dot1, #wrp-header-dot2 {
    position: absolute; border-radius: 50%;
    pointer-events: none; background: rgba(255, 255, 255, .25);
}
#wrp-header-dot1 { width: 10px; height: 10px; top: 22px; left: 28px; }
#wrp-header-dot2 { width: 6px;  height: 6px;  top: 42px; left: 52px; }

#wrp-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: rgba(255, 255, 255, .22);
    border: 1px solid rgba(255, 255, 255, .42);
    border-radius: 50px; padding: .26rem .82rem;
    font-size: .68rem; font-weight: 700; letter-spacing: .07em;
    text-transform: uppercase; color: #fff;
    margin-bottom: .65rem;
    position: relative; z-index: 1;
}
#wrp-badge i { font-size: .6rem; }

#wrp-header h2 {
    font-size: 1.35rem; font-weight: 800; color: #fff;
    margin: 0 0 .35rem; line-height: 1.3;
    position: relative; z-index: 1;
    text-shadow: 0 2px 14px rgba(120, 53, 15, .25);
    letter-spacing: -.015em;
}
#wrp-header-sub {
    font-size: .68rem; color: rgba(255, 255, 255, .72);
    margin: 0; font-style: italic; letter-spacing: .01em;
    position: relative; z-index: 1;
}
#wrp-header-sub em { font-style: normal; color: rgba(255, 255, 255, .9); font-weight: 600; }

/* ── Body ── */
#wrp-body {
    padding: 1.25rem 1.5rem 1rem;
    overflow-y: auto;
    flex: 1;
    min-height: 0;
}

#wrp-desc {
    font-size: .815rem; color: #92400e;
    line-height: 1.7; margin: 0 0 1rem;
    text-align: center;
}
#wrp-desc em { color: #d97706; font-style: normal; font-weight: 700; }

/* ── Features ── */
#wrp-features { display: flex; flex-direction: column; gap: .55rem; }

.wrp-feat {
    display: flex; align-items: center; gap: .7rem;
    background: #fef9e7;
    border: 1px solid rgba(217, 119, 6, .16);
    border-radius: 11px; padding: .52rem .8rem;
    transition: background .18s;
}
.wrp-feat:hover { background: #fef3c7; }
.wrp-feat-icon {
    width: 32px; height: 32px; border-radius: 9px; flex-shrink: 0;
    background: linear-gradient(135deg, #f59e0b, #b45309);
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: .76rem;
    box-shadow: 0 3px 8px rgba(217, 119, 6, .32);
}
.wrp-feat-text {
    font-size: .79rem; color: #78350f; font-weight: 500; line-height: 1.4;
}
.wrp-feat-text strong { color: #92400e; }
.wrp-lyric {
    display: block; font-size: .7rem; color: #b45309;
    font-style: italic; margin: .18rem 0 .1rem;
    padding-left: .5rem;
    border-left: 2px solid rgba(217, 119, 6, .45);
    line-height: 1.45;
}

/* ── Footer ── */
#wrp-footer {
    flex-shrink: 0;
    display: flex; flex-direction: column; gap: .42rem;
    padding: .85rem 1.5rem 1.35rem;
}

#wrp-btn-explore {
    display: flex; align-items: center; justify-content: center; gap: .45rem;
    background: linear-gradient(135deg, #d97706, #b45309);
    color: #fff; border: none;
    font-size: .88rem; font-weight: 700;
    padding: .8rem 1.5rem; border-radius: 50px;
    cursor: pointer;
    box-shadow: 0 5px 18px rgba(217, 119, 6, .42);
    transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
    width: 100%;
}
#wrp-btn-explore:hover {
    transform: translateY(-2px);
    box-shadow: 0 9px 26px rgba(217, 119, 6, .52);
    filter: brightness(1.06);
}
#wrp-btn-explore:active { transform: scale(.97); }

#wrp-share-fallback {
    display: none;
    font-size: .68rem; color: #b45309;
    text-align: center; padding: .3rem .5rem; line-height: 1.55;
}
#wrp-share-fallback a { color: #d97706; text-decoration: underline; }

#wrp-btn-dismiss {
    background: none; border: none;
    font-size: .74rem; color: #d4a55a;
    cursor: pointer; padding: .25rem;
    text-decoration: underline; text-underline-offset: 3px;
    transition: color .18s; width: 100%; text-align: center;
}
#wrp-btn-dismiss:hover { color: #92400e; }

/* ── Pesan Section ── */
#wrp-msg-section {
    margin-top: .9rem;
    border-top: 1px solid rgba(217, 119, 6, .16);
    padding-top: .85rem;
}

#wrp-msg-heading {
    display: flex; align-items: center; gap: .4rem;
    font-size: .68rem; font-weight: 700; color: #b45309;
    text-transform: uppercase; letter-spacing: .07em;
    margin-bottom: .55rem;
}
#wrp-msg-heading i { font-size: .62rem; }

#wrp-msg-list { display: flex; flex-direction: column; gap: .38rem; margin-bottom: .45rem; }

#wrp-msg-empty {
    font-size: .75rem; color: #c4a060; text-align: center;
    padding: .6rem 0; font-style: italic;
}

.wrp-msg-item {
    background: #fef9e7;
    border: 1px solid rgba(217, 119, 6, .14);
    border-radius: 9px;
    padding: .45rem .6rem;
    animation: wrp-fadein .3s ease;
}
@keyframes wrp-fadein { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }

.wrp-msg-item-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: .18rem;
}
.wrp-msg-item-name {
    font-size: .7rem; font-weight: 700; color: #92400e;
}
.wrp-msg-item-date {
    font-size: .6rem; color: #d4a560;
}
.wrp-msg-item-text {
    font-size: .76rem; color: #78350f; line-height: 1.45;
    word-break: break-word;
}

#wrp-msg-load-more {
    width: 100%; background: none;
    border: 1px dashed rgba(217, 119, 6, .35);
    border-radius: 8px; padding: .38rem;
    font-size: .7rem; color: #b45309; font-weight: 600;
    cursor: pointer; margin-bottom: .6rem;
    transition: background .18s, color .18s;
}
#wrp-msg-load-more:hover { background: #fef3c7; color: #92400e; }
#wrp-msg-load-more i { margin-left: .3rem; font-size: .6rem; }

/* ── Divider ── */
#wrp-msg-divider {
    display: flex; align-items: center; gap: .55rem;
    margin: .65rem 0 .55rem;
}
#wrp-msg-divider::before,
#wrp-msg-divider::after {
    content: ''; flex: 1;
    height: 1px; background: rgba(217, 119, 6, .22);
}
#wrp-msg-divider span {
    font-size: .65rem; font-weight: 700; color: #b45309;
    text-transform: uppercase; letter-spacing: .07em;
    white-space: nowrap;
}
#wrp-msg-divider i { font-size: .6rem; }

/* ── Form Pesan ── */
#wrp-msg-form { display: flex; flex-direction: column; gap: .3rem; }

#wrp-msg-form-fields { display: flex; flex-direction: column; gap: .3rem; }

#wrp-msg-name,
#wrp-msg-text {
    width: 100%; box-sizing: border-box;
    background: #fff;
    border: 1px solid rgba(217, 119, 6, .28);
    border-radius: 8px;
    padding: .48rem .65rem;
    font-size: .78rem; color: #78350f;
    font-family: inherit;
    transition: border-color .18s, box-shadow .18s;
    outline: none; resize: none;
}
#wrp-msg-name::placeholder,
#wrp-msg-text::placeholder { color: #d4a560; }
#wrp-msg-name:focus,
#wrp-msg-text:focus {
    border-color: #f59e0b;
    box-shadow: 0 0 0 3px rgba(245, 158, 11, .15);
}

#wrp-msg-form-footer {
    display: flex; justify-content: space-between; align-items: center;
}
#wrp-msg-char { font-size: .62rem; color: #d4a560; }

#wrp-msg-submit {
    background: linear-gradient(135deg, #d97706, #b45309);
    color: #fff; border: none;
    font-size: .76rem; font-weight: 700;
    padding: .38rem .9rem; border-radius: 50px;
    cursor: pointer;
    transition: filter .18s, transform .12s;
}
#wrp-msg-submit:hover { filter: brightness(1.08); }
#wrp-msg-submit:active { transform: scale(.96); }
#wrp-msg-submit:disabled { opacity: .55; cursor: not-allowed; }

#wrp-msg-feedback {
    font-size: .7rem; min-height: 1rem; text-align: center;
    transition: color .2s;
}
#wrp-msg-feedback.success { color: #16a34a; }
#wrp-msg-feedback.error   { color: #dc2626; }

/* ── Responsive ── */
@media (max-width: 480px) {
    #wrp-card { border-radius: 20px; }
    #wrp-x { top: .7rem; right: .7rem; }
    #wrp-header { padding: 1.5rem 1.25rem 1.25rem; }
    #wrp-header h2 { font-size: 1.15rem; }
    #wrp-body { padding: 1rem 1.25rem .875rem; }
    #wrp-footer { padding: .75rem 1.25rem 1.25rem; }
}

/* ── Dark Mode ── */
[data-theme="dark"] #wrp-card { background: #1c0e02; }
[data-theme="dark"] #wrp-body { background: #1c0e02; }
[data-theme="dark"] #wrp-desc { color: #d4aa60; }
[data-theme="dark"] .wrp-feat { background: #2d1a04; border-color: rgba(217, 119, 6, .2); }
[data-theme="dark"] .wrp-feat:hover { background: #3d2305; }
[data-theme="dark"] .wrp-feat-text { color: #e8c070; }
[data-theme="dark"] .wrp-feat-text strong { color: #f0d080; }
[data-theme="dark"] .wrp-lyric { color: #e8a840; border-left-color: rgba(245, 158, 11, .4); }

/* dark — message section */
[data-theme="dark"] #wrp-msg-section { border-top-color: rgba(217, 119, 6, .18); }
[data-theme="dark"] #wrp-msg-heading { color: #e8a840; }
[data-theme="dark"] #wrp-msg-empty { color: #a07838; }
[data-theme="dark"] .wrp-msg-item { background: #2d1a04; border-color: rgba(217, 119, 6, .18); }
[data-theme="dark"] .wrp-msg-item-name { color: #f0c060; }
[data-theme="dark"] .wrp-msg-item-date { color: #a07838; }
[data-theme="dark"] .wrp-msg-item-text { color: #d4aa60; }
[data-theme="dark"] #wrp-msg-load-more { color: #e8a840; border-color: rgba(217, 119, 6, .3); }
[data-theme="dark"] #wrp-msg-load-more:hover { background: #2d1a04; color: #f0c060; }
[data-theme="dark"] #wrp-msg-divider::before,
[data-theme="dark"] #wrp-msg-divider::after { background: rgba(217, 119, 6, .2); }
[data-theme="dark"] #wrp-msg-divider span { color: #e8a840; }
[data-theme="dark"] #wrp-msg-name,
[data-theme="dark"] #wrp-msg-text {
    background: #2a1608;
    border-color: rgba(217, 119, 6, .3);
    color: #e8c070;
}
[data-theme="dark"] #wrp-msg-name::placeholder,
[data-theme="dark"] #wrp-msg-text::placeholder { color: #8a5a28; }
[data-theme="dark"] #wrp-msg-name:focus,
[data-theme="dark"] #wrp-msg-text:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, .12); }
[data-theme="dark"] #wrp-msg-char { color: #a07838; }

/* dark — footer */
[data-theme="dark"] #wrp-footer { background: #1c0e02; border-top-color: rgba(217, 119, 6, .12); }
[data-theme="dark"] #wrp-btn-dismiss { color: #8a5a20; }
[data-theme="dark"] #wrp-btn-dismiss:hover { color: #d4a550; }
[data-theme="dark"] #wrp-share-fallback { color: #c4903a; }
</style>
