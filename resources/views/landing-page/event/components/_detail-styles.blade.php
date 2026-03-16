@verbatim
<style>
/* ================================================================
   EVENT DETAIL PAGE  —  prefix: ed-
   Primary: #00a79d  (follows global --primary)
   ================================================================ */

:root {
    --ed-primary:       #00a79d;
    --ed-primary-dark:  #008f86;
    --ed-primary-light: #e0f7f5;
    --ed-dark:          #1a2c2a;
    --ed-gray:          #6b7280;
    --ed-gray-100:      #f3f4f6;
    --ed-gray-200:      #e5e7eb;
    --ed-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --ed-radius:        20px;
    --ed-transition:    all .3s cubic-bezier(.4,0,.2,1);
}

/* ─── Reading Progress Bar ───────────────────────────────────── */
.ed-progress {
    position: fixed; top: 0; left: 0;
    height: 3px; width: 0%;
    background: linear-gradient(90deg, #00a79d, #14b8a6, #0ea5e9);
    z-index: 2000; transition: width .1s linear;
    border-radius: 0 2px 2px 0;
}

/* ─── Hero ───────────────────────────────────────────────────── */
.ed-hero {
    position: relative; min-height: 72vh;
    display: flex; align-items: flex-end;
    overflow: hidden; background: var(--ed-dark);
}
.ed-hero-bg {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    background-repeat: no-repeat;
    transition: transform 10s ease;
    will-change: transform;
}
.ed-hero:hover .ed-hero-bg { transform: scale(1.04); }
.ed-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        160deg,
        rgba(0,30,28,.08) 0%,
        rgba(0,80,75,.42) 40%,
        rgba(0,40,38,.82) 70%,
        rgba(0,20,18,.96) 100%
    );
}
/* Teal glow at bottom */
.ed-hero-overlay::after {
    content: '';
    position: absolute; bottom: 0; left: 0; right: 0;
    height: 60%;
    background: linear-gradient(to top,
        rgba(0,167,157,.18) 0%,
        transparent 100%);
    pointer-events: none;
}
.ed-hero-content {
    position: relative; z-index: 2;
    padding: 5rem 0 3rem; width: 100%;
}
/* Decorative silhouette icon in hero background */
.ed-hero-deco-icon {
    position: absolute; right: 4%; top: 50%;
    transform: translateY(-50%);
    font-size: clamp(7rem, 16vw, 13rem);
    color: white; opacity: .05;
    pointer-events: none; user-select: none;
    z-index: 1;
}
.ed-hero-division {
    display: inline-flex; align-items: center; gap: .45rem;
    background: rgba(0,167,157,.22);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(0,210,200,.35);
    border-radius: 50px;
    padding: .3rem 1.1rem;
    font-size: .72rem; font-weight: 800;
    color: #b2f0ec; letter-spacing: .5px;
    text-transform: uppercase; margin-bottom: .9rem; cursor: default;
}
.ed-hero-division-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: #5eead4;
    animation: edHeroPulse 2s ease infinite; flex-shrink: 0;
}
@keyframes edHeroPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(94,234,212,.5); }
    50%      { box-shadow: 0 0 0 5px rgba(94,234,212,0); }
}
.ed-hero-title {
    font-size: clamp(1.4rem, 3.5vw, 2.5rem);
    font-weight: 900; color: white; line-height: 1.28;
    margin: 0 0 1.35rem;
    text-shadow: 0 2px 20px rgba(0,0,0,.5);
    max-width: 800px;
}
.ed-hero-metas {
    display: flex; flex-wrap: wrap; gap: .5rem; align-items: center;
}
.ed-hero-meta {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.18);
    border-radius: 50px;
    padding: .28rem .9rem;
    font-size: .74rem; font-weight: 600;
    color: rgba(255,255,255,.9);
    transition: var(--ed-transition);
}
.ed-hero-meta:hover { background: rgba(0,167,157,.28); border-color: rgba(0,210,200,.4); }
.ed-hero-meta i { font-size: .68rem; opacity: .8; }

/* Status chip */
.ed-hero-status {
    display: inline-flex; align-items: center; gap: .38rem;
    padding: .3rem .9rem; border-radius: 50px;
    font-size: .72rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .4px;
}
.ed-hero-status.upcoming { background: rgba(16,185,129,.9); color: white; }
.ed-hero-status.ongoing  { background: rgba(245,158,11,.9);  color: white; }
.ed-hero-status.past     { background: rgba(107,114,128,.8); color: white; }
.ed-status-pulse {
    width: 6px; height: 6px; border-radius: 50%; background: white;
    animation: edHeroPulse 1.5s ease infinite; flex-shrink: 0;
}

/* ─── Content wrap — pull-up over hero, gray bg (distinct from news/article) */
.ed-content-wrap {
    padding: 2.5rem 0 4rem;
    margin-top: 2rem;
    position: relative; z-index: 3;
    border-radius: 28px 28px 0 0;
}

.ed-layout { display: flex; gap: 2.5rem; align-items: flex-start; }
.ed-main   { flex: 1; min-width: 0; }
.ed-aside  { flex: 0 0 300px; width: 300px; }

/* ─── Section card ───────────────────────────────────────────── */
.ed-card {
    background: white; border-radius: var(--ed-radius);
    padding: 2rem; box-shadow: var(--ed-shadow-sm);
    border: 1px solid rgba(0,0,0,.04);
    margin-bottom: 1.5rem;
}
.ed-card-title {
    font-size: .7rem; font-weight: 800; color: var(--ed-primary);
    text-transform: uppercase; letter-spacing: .65px;
    margin: 0 0 1.25rem;
    display: flex; align-items: center; gap: .55rem;
}
.ed-card-title::before {
    content: ''; width: 14px; height: 3px;
    background: linear-gradient(90deg, var(--ed-primary), #14b8a6);
    border-radius: 2px; flex-shrink: 0;
}

/* ─── Broadcast body ─────────────────────────────────────────── */
.ed-body {
    font-size: 1.03rem; line-height: 1.85; color: #2d3748;
}
.ed-body p { margin-bottom: 1.3rem; text-align: justify; }
.ed-body p:last-child { margin-bottom: 0; }
.ed-body img {
    max-width: 100%; height: auto; display: block;
    border-radius: 16px; margin: 1.5rem auto;
    box-shadow: 0 8px 32px rgba(0,0,0,.1);
}
.ed-body h2 {
    font-size: 1.35rem; font-weight: 800; color: var(--ed-dark);
    margin: 2rem 0 .8rem; padding-bottom: .45rem;
    border-bottom: 2px solid var(--ed-primary-light);
}
.ed-body h3 { font-size: 1.1rem; font-weight: 700; color: var(--ed-dark); margin: 1.75rem 0 .65rem; }
.ed-body ul { list-style: none; padding: 0; margin: 0 0 1.3rem; }
.ed-body ul li {
    display: flex; align-items: flex-start; gap: .7rem;
    padding: .28rem 0; line-height: 1.72; color: #2d3748;
}
.ed-body ul li::before {
    content: ''; width: 8px; height: 8px; min-width: 8px;
    border-radius: 50%; background: var(--ed-primary);
    margin-top: .55rem; flex-shrink: 0;
    animation: edBulletGrow 2.8s ease-in-out infinite;
}
@keyframes edBulletGrow {
    0%,100% { transform: scale(1);   box-shadow: 0 0 0 0 rgba(0,167,157,.45); }
    50%      { transform: scale(1.4); box-shadow: 0 0 0 5px rgba(0,167,157,0); }
}
.ed-body ol { padding-left: 1.6rem; margin: 0 0 1.3rem; }
.ed-body ol li { padding: .22rem 0; line-height: 1.72; color: #2d3748; }
.ed-body a { color: var(--ed-primary); text-decoration: underline; text-underline-offset: 3px; }
.ed-body a:hover { color: var(--ed-primary-dark); }
.ed-body blockquote {
    border-left: 4px solid var(--ed-primary);
    padding: 1rem 1.5rem; margin: 2rem 0;
    background: var(--ed-primary-light);
    border-radius: 0 16px 16px 0;
    font-style: italic; color: #374151;
}
.ed-body blockquote p:last-child { margin-bottom: 0; }

/* ─── Event Info Sidebar ─────────────────────────────────────── */
.ed-info-card {
    background: white; border-radius: var(--ed-radius);
    box-shadow: var(--ed-shadow-sm);
    border: 1px solid rgba(0,0,0,.04);
    overflow: hidden; margin-bottom: 1.25rem;
}
.ed-info-header {
    background: linear-gradient(135deg, #00a79d, #008f86);
    padding: 1.2rem 1.4rem;
    color: white;
    position: relative; overflow: hidden;
}
.ed-info-header::after {
    content: '';
    position: absolute; right: -20px; top: -20px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
    pointer-events: none;
}
.ed-info-header-label {
    font-size: .65rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: .6px; opacity: .75; margin-bottom: .25rem;
}
.ed-info-header-title {
    font-size: .95rem; font-weight: 800; line-height: 1.35;
}
.ed-info-body { padding: 1.2rem 1.4rem; }

.ed-info-item {
    display: flex; align-items: flex-start; gap: .72rem;
    padding: .7rem 0; border-bottom: 1px solid var(--ed-gray-100);
}
.ed-info-item:last-child { border-bottom: none; padding-bottom: 0; }
.ed-info-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--ed-primary-light);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.ed-info-icon i { color: var(--ed-primary); font-size: .8rem; }
.ed-info-text { display: flex; flex-direction: column; min-width: 0; }
.ed-info-label {
    font-size: .6rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .45px; color: var(--ed-gray); opacity: .75; line-height: 1.1;
}
.ed-info-value {
    font-size: .87rem; font-weight: 700; color: var(--ed-dark);
    line-height: 1.4; word-break: break-word;
}
.ed-info-value a { color: var(--ed-primary); text-decoration: none; }
.ed-info-value a:hover { color: var(--ed-primary-dark); text-decoration: underline; }

/* ─── Ticket separator (between info-header and info-body) ──── */
.ed-ticket-sep {
    display: flex; align-items: center;
    padding: .4rem 1.4rem;
    background: var(--ed-gray-100);
    gap: .6rem;
}
.ed-ticket-sep::before,
.ed-ticket-sep::after {
    content: ''; flex: 1;
    border-top: 2px dashed rgba(0,167,157,.25);
}
.ed-ticket-sep-icon {
    width: 24px; height: 24px; border-radius: 50%;
    background: white;
    border: 1.5px dashed rgba(0,167,157,.35);
    display: flex; align-items: center; justify-content: center;
    color: var(--ed-primary); font-size: .58rem; flex-shrink: 0;
}

/* ─── Registration card ──────────────────────────────────────── */
.ed-regist-card {
    background: white; border-radius: var(--ed-radius);
    box-shadow: var(--ed-shadow-sm);
    border: 1px solid rgba(0,167,157,.12);
    padding: 1.4rem; margin-bottom: 1.25rem;
    text-align: center;
    position: relative; overflow: hidden;
}
.ed-regist-card::before {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(145deg, rgba(0,167,157,.05) 0%, transparent 60%);
    pointer-events: none;
}
.ed-regist-open-label {
    font-size: .7rem; font-weight: 800; color: var(--ed-gray);
    text-transform: uppercase; letter-spacing: .5px;
    margin-bottom: .75rem; display: block;
}
.ed-regist-btn {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    padding: .82rem 1rem; border-radius: 14px;
    background: linear-gradient(135deg, #00a79d, #008f86);
    color: white;
    font-size: .88rem; font-weight: 700;
    text-decoration: none;
    transition: var(--ed-transition);
    margin-bottom: .65rem;
    box-shadow: 0 4px 18px rgba(0,167,157,.3);
}
.ed-regist-btn:hover {
    background: linear-gradient(135deg, #008f86, #007a72);
    color: white; transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(0,167,157,.4);
}
.ed-regist-btn.closed {
    background: var(--ed-gray-200); color: var(--ed-gray);
    cursor: default; box-shadow: none;
}
.ed-regist-btn.closed:hover { transform: none; box-shadow: none; background: var(--ed-gray-200); }
.ed-regist-deadline {
    font-size: .72rem; color: var(--ed-gray);
    display: flex; align-items: center; justify-content: center; gap: .3rem;
}
.ed-regist-deadline.urgent { color: #ef4444; }
.ed-regist-deadline i { font-size: .65rem; }

/* Registration card — vivid when open (major differentiator from news/article) */
.ed-regist-card.regist-open {
    background: linear-gradient(145deg, #00a79d 0%, #008f86 55%, #14b8a6 100%);
    border-color: transparent;
    box-shadow: 0 8px 32px rgba(0,167,157,.38);
}
.ed-regist-card.regist-open::before {
    background: linear-gradient(145deg, rgba(255,255,255,.12) 0%, transparent 60%);
}
.ed-regist-card.regist-open .ed-regist-open-label { color: rgba(255,255,255,.8); }
.ed-regist-card.regist-open .ed-countdown-unit {
    background: rgba(255,255,255,.18);
    border-color: rgba(255,255,255,.3);
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}
.ed-regist-card.regist-open .ed-countdown-unit::before { background: rgba(255,255,255,.5); }
.ed-regist-card.regist-open .ed-countdown-num   { color: white; }
.ed-regist-card.regist-open .ed-countdown-label { color: rgba(255,255,255,.72); }
.ed-regist-card.regist-open .ed-regist-btn {
    background: white; color: var(--ed-primary);
    box-shadow: 0 6px 22px rgba(0,0,0,.18);
}
.ed-regist-card.regist-open .ed-regist-btn:hover {
    background: var(--ed-primary-light); color: var(--ed-primary-dark);
}
.ed-regist-card.regist-open .ed-regist-deadline { color: rgba(255,255,255,.78); }
.ed-regist-card.regist-open .ed-regist-deadline i { opacity: .8; }

/* ─── Countdown — fun teal blocks ──────────────────────────── */
.ed-countdown {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: .45rem;
    margin-bottom: .85rem;
}
.ed-countdown-unit {
    text-align: center;
    background: white;
    border: 2px solid var(--ed-primary-light);
    border-radius: 14px; padding: .65rem .25rem;
    position: relative; overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,167,157,.1);
    transition: transform .2s ease;
}
.ed-countdown-unit:hover { transform: translateY(-2px); }
/* Teal gradient top accent bar */
.ed-countdown-unit::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--ed-primary), #14b8a6);
    border-radius: 2px 2px 0 0;
}
.ed-countdown-num {
    font-size: 1.5rem; font-weight: 900; color: var(--ed-primary);
    line-height: 1; display: block; letter-spacing: -1px;
}
.ed-countdown-label {
    font-size: .5rem; font-weight: 700; color: var(--ed-gray);
    text-transform: uppercase; letter-spacing: .5px; margin-top: .15rem;
    display: block;
}

/* ─── Documentation card ─────────────────────────────────────── */
.ed-doc-grid { display: flex; flex-direction: column; gap: .65rem; }
.ed-doc-link {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1rem; border-radius: 14px;
    background: var(--ed-gray-100);
    text-decoration: none; color: var(--ed-dark);
    font-size: .85rem; font-weight: 700;
    transition: var(--ed-transition);
    border: 1.5px solid transparent;
}
.ed-doc-link:hover {
    background: var(--ed-primary-light);
    border-color: rgba(0,167,157,.2);
    color: var(--ed-primary-dark);
    transform: translateX(4px);
}
.ed-doc-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: white; box-shadow: 0 2px 8px rgba(0,0,0,.08);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; color: var(--ed-primary); font-size: .88rem;
}
.ed-doc-link:hover .ed-doc-icon { background: var(--ed-primary); color: white; }

/* Contact persons */
.ed-contact-list { display: flex; flex-direction: column; gap: .6rem; }
.ed-contact-item {
    display: flex; align-items: center; gap: .75rem;
    padding: .65rem .8rem; border-radius: 14px;
    background: var(--ed-gray-100);
    transition: var(--ed-transition);
    text-decoration: none;
}
.ed-contact-item:hover { background: #dcfce7; transform: translateX(3px); }
.ed-contact-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #25d366, #128c7e);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: .82rem; flex-shrink: 0;
}
.ed-contact-name { font-size: .82rem; font-weight: 700; color: var(--ed-dark); line-height: 1.2; }
.ed-contact-num  { font-size: .72rem; color: var(--ed-gray); }

/* ─── Share section ──────────────────────────────────────────── */
.ed-share-section {
    background: linear-gradient(135deg, rgba(0,167,157,.07), rgba(20,184,166,.04) 60%, white);
    border: 1px solid rgba(0,167,157,.12);
    border-radius: var(--ed-radius); padding: 1.5rem 2rem;
    display: flex; align-items: center; gap: 1.25rem;
    flex-wrap: wrap; margin-top: 1.5rem;
}
.ed-share-label {
    font-size: .82rem; font-weight: 700; color: var(--ed-gray);
    text-transform: uppercase; letter-spacing: .4px; flex-shrink: 0;
}
.ed-share-btns { display: flex; gap: .55rem; flex-wrap: wrap; flex: 1; }
.ed-share-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .6rem 1.35rem; border-radius: 50px;
    font-size: .82rem; font-weight: 700; cursor: pointer;
    border: 1.5px solid transparent; transition: var(--ed-transition);
    text-decoration: none;
}
.ed-share-btn--copy {
    background: white; border-color: rgba(0,167,157,.25);
    color: var(--ed-primary); box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.ed-share-btn--copy:hover {
    background: var(--ed-primary); color: white;
    box-shadow: 0 4px 18px rgba(0,167,157,.35); transform: translateY(-1px);
}
.ed-share-btn--wa {
    background: white; border-color: rgba(37,211,102,.3);
    color: #1da851; box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.ed-share-btn--wa:hover {
    background: #25d366; color: white;
    box-shadow: 0 4px 18px rgba(37,211,102,.35); transform: translateY(-1px);
}
.ed-share-btn--tw {
    background: #1a1a2e; border-color: #1a1a2e;
    color: white; box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.ed-share-btn--tw:hover { background: #000; box-shadow: 0 4px 18px rgba(0,0,0,.35); transform: translateY(-1px); }

/* ─── Back button ────────────────────────────────────────────── */
.ed-back-btn {
    display: inline-flex; align-items: center; gap: .55rem;
    color: var(--ed-primary); font-size: .85rem; font-weight: 700;
    text-decoration: none; padding: .6rem 1.2rem;
    background: var(--ed-primary-light);
    border-radius: 50px;
    transition: var(--ed-transition); margin-bottom: 1.75rem;
    border: 1.5px solid rgba(0,167,157,.2);
}
.ed-back-btn:hover {
    background: var(--ed-primary); color: white;
    transform: translateX(-4px); box-shadow: 0 4px 18px rgba(0,167,157,.3);
}
.ed-back-btn i { font-size: .75rem; transition: transform .25s ease; }
.ed-back-btn:hover i { transform: translateX(-3px); }

/* ─── Comments ───────────────────────────────────────────────── */
.ed-comments-section {
    background: white; border-radius: var(--ed-radius);
    padding: 2rem; box-shadow: var(--ed-shadow-sm);
    border: 1px solid rgba(0,0,0,.04); margin-top: 1.5rem;
}
.ed-comments-title {
    font-size: 1.05rem; font-weight: 800; color: var(--ed-dark);
    margin: 0 0 1.5rem;
    display: flex; align-items: center; gap: .6rem;
}
.ed-comments-title::before {
    content: ''; width: 4px; height: 22px;
    background: linear-gradient(180deg, #00a79d, #14b8a6);
    border-radius: 2px; flex-shrink: 0;
}

/* ─── Tabs — Modern Segmented Control ───────────────────────── */
.ed-tabs-nav {
    display: flex; gap: .3rem;
    background: white;
    border-radius: 18px;
    padding: .35rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 16px rgba(0,0,0,.07), 0 1px 4px rgba(0,0,0,.04);
    border: none;
    overflow-x: auto; scrollbar-width: none;
}
.ed-tabs-nav::-webkit-scrollbar { display: none; }
.ed-tab-btn {
    flex: 1; min-width: max-content;
    display: inline-flex; align-items: center; justify-content: center; gap: .45rem;
    padding: .65rem 1.1rem;
    font-size: .82rem; font-weight: 700;
    color: var(--ed-gray); background: transparent;
    border: none; cursor: pointer;
    transition: color .22s ease, background .22s ease, box-shadow .22s ease, transform .18s ease;
    border-radius: 13px;
    margin-bottom: 0; white-space: nowrap;
}
.ed-tab-btn:hover:not(.active) {
    color: var(--ed-primary);
    background: var(--ed-primary-light);
    transform: translateY(-1px);
}
.ed-tab-btn.active {
    color: white;
    background: linear-gradient(135deg, var(--ed-primary), var(--ed-primary-dark));
    box-shadow: 0 4px 16px rgba(0,167,157,.35);
    transform: translateY(-1px);
}
.ed-tab-btn i { font-size: .75rem; }

/* Smooth fade+slide when switching tabs */
.ed-tab-pane { display: none; }
.ed-tab-pane.active {
    display: block;
    animation: edTabIn .35s cubic-bezier(.4,0,.2,1) both;
}
.ed-tab-pane.ed-tab-leaving {
    display: block;
    animation: edTabOut .2s ease both;
    pointer-events: none;
}
@keyframes edTabIn {
    from { opacity: 0; transform: translateY(12px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes edTabOut {
    from { opacity: 1; transform: translateY(0); }
    to   { opacity: 0; transform: translateY(-8px); }
}

/* Doc empty state */
.ed-doc-empty {
    text-align: center; padding: 2.5rem 1rem;
    color: var(--ed-gray);
}
.ed-doc-empty i { font-size: 2.5rem; opacity: .25; margin-bottom: .75rem; display: block; }
.ed-doc-empty p { font-size: .88rem; margin: 0; }

/* Divider */
.ed-divider {
    height: 2px; border-radius: 2px;
    background: linear-gradient(90deg, transparent, rgba(0,167,157,.15) 20%, #00a79d 50%, rgba(0,167,157,.15) 80%, transparent);
    margin: 2rem 0;
}

/* ─── Bottom Actions (Kembali + Kegiatan Lainnya) ─────────── */
.ed-bottom-actions {
    background: linear-gradient(135deg, #00a79d 0%, #008f86 50%, #0e9488 100%);
    padding: 3rem 0;
    position: relative; overflow: hidden;
}
.ed-bottom-actions::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(circle at 78% 40%, rgba(255,255,255,.1) 0%, transparent 55%);
    pointer-events: none;
}
.ed-bottom-actions::after {
    content: '';
    position: absolute; top: -60px; right: -60px;
    width: 220px; height: 220px; border-radius: 50%;
    background: rgba(255,255,255,.06);
    pointer-events: none;
}
.ed-bottom-inner {
    display: flex; align-items: center;
    justify-content: space-between;
    gap: 1.5rem; flex-wrap: wrap;
    position: relative; z-index: 1;
}
.ed-bottom-text { flex: 1; min-width: 0; }
.ed-bottom-title {
    font-size: 1.2rem; font-weight: 900; color: white;
    margin: 0 0 .3rem; line-height: 1.3;
}
.ed-bottom-sub {
    font-size: .86rem; color: rgba(255,255,255,.78);
    margin: 0;
}
.ed-bottom-btns {
    display: flex; gap: .65rem; flex-wrap: wrap; align-items: center;
    flex-shrink: 0;
}
.ed-bottom-more-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .72rem 1.75rem; border-radius: 50px;
    background: white; color: var(--ed-primary);
    font-size: .88rem; font-weight: 800;
    text-decoration: none;
    box-shadow: 0 6px 22px rgba(0,0,0,.15);
    transition: all .28s ease;
    border: 2px solid transparent;
}
.ed-bottom-more-btn:hover {
    background: transparent; color: white;
    border-color: rgba(255,255,255,.65);
    transform: translateY(-2px);
}
.ed-bottom-more-btn i { font-size: .8rem; transition: transform .25s ease; }
.ed-bottom-more-btn:hover i { transform: translateX(4px); }

/* SweetAlert toast fix */
.ed-swal-below-nav { top: 76px !important; right: 1rem !important; z-index: 1100 !important; }

/* ─── Responsive ─────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .ed-layout { flex-direction: column; }
    .ed-aside  { width: 100%; flex: unset; }
    .ed-hero   { min-height: 56vh; }
    .ed-card   { padding: 1.5rem 1.25rem; }
    .ed-share-section { padding: 1.25rem; }
    .ed-countdown { grid-template-columns: repeat(4, 1fr); }
    .ed-bottom-inner { flex-direction: column; text-align: center; }
    .ed-bottom-btns { justify-content: center; }
}
@media (max-width: 767.98px) {
    /* Prevent any inner element from causing horizontal scroll */
    .ed-content-wrap { overflow-x: hidden; }
    /* Broadcast HTML content might have wide elements */
    .ed-body img, .ed-body table, .ed-body iframe, .ed-body video {
        max-width: 100% !important; height: auto;
    }
    .ed-body table { display: block; overflow-x: auto; }
    /* Hero deco icon too large on mobile, hide it */
    .ed-hero-deco-icon { display: none; }
    /* Share buttons stack vertically on narrow screens */
    .ed-share-section {
        flex-direction: column; align-items: flex-start;
        gap: .75rem; padding: 1rem 1.1rem;
    }
    .ed-share-btns { gap: .45rem; width: 100%; }
    .ed-share-btn { flex: 1; justify-content: center; padding: .55rem .6rem; font-size: .8rem; }
    /* Info card tick separator icon smaller */
    .ed-ticket-sep-icon { width: 20px; height: 20px; font-size: .5rem; }
}
@media (max-width: 575.98px) {
    /* Hero — enough bottom pad so content-wrap doesn't overlap meta chips */
    .ed-hero { min-height: 52vh; }
    .ed-hero-title { font-size: 1.15rem; line-height: 1.35; }
    .ed-hero-content { padding: 5rem 0 4rem; }
    .ed-hero-division { font-size: .62rem; padding: .22rem .8rem; margin-bottom: .65rem; }
    .ed-hero-metas { gap: .35rem; }
    .ed-hero-meta { font-size: .66rem; padding: .2rem .65rem; }
    .ed-hero-status { font-size: .66rem; padding: .22rem .75rem; }

    /* Content wrap — less negative overlap, more top padding for breathing room */
    .ed-content-wrap { margin-top: -1.5rem; padding: 2.5rem 0 3rem; border-radius: 18px 18px 0 0; }

    /* Tabs */
    .ed-tabs-nav { padding: .25rem; gap: .18rem; border-radius: 13px; margin-bottom: 1.1rem; }
    .ed-tab-btn { padding: .52rem .7rem; font-size: .76rem; border-radius: 10px; }
    .ed-tab-btn i { display: none; }

    /* Cards */
    .ed-card { padding: 1rem .85rem; }
    .ed-comments-section { padding: 1.1rem .85rem; }
    .ed-body { font-size: .94rem; line-height: 1.75; }

    /* Sidebar */
    .ed-info-header { padding: 1rem 1.1rem; }
    .ed-info-header-title { font-size: .88rem; }
    .ed-info-body { padding: .9rem 1.1rem; }
    .ed-info-item { gap: .5rem; padding: .55rem 0; }
    .ed-info-icon { width: 30px; height: 30px; border-radius: 8px; }
    .ed-info-value { font-size: .82rem; }
    .ed-regist-card { padding: 1rem; }
    .ed-countdown { gap: .3rem; }
    .ed-countdown-num { font-size: 1.1rem; }
    .ed-countdown-unit { padding: .5rem .18rem; border-radius: 10px; }
    .ed-countdown-label { font-size: .45rem; }

    /* Share */
    .ed-share-section { margin-top: 1rem; }

    /* Bottom */
    .ed-bottom-actions { padding: 1.75rem 0; }
    .ed-bottom-title { font-size: .95rem; }
    .ed-bottom-sub { font-size: .8rem; }
    .ed-bottom-btns { flex-direction: column; width: 100%; }
    .ed-bottom-more-btn { justify-content: center; width: 100%; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
/* Tabs nav */
[data-theme="dark"] .ed-tabs-nav       { background: #1a1f2e; box-shadow: 0 2px 16px rgba(0,0,0,.3); }
[data-theme="dark"] .ed-tab-btn        { color: #e2e8f0; }
[data-theme="dark"] .ed-tab-btn:hover:not(.active) { background: rgba(0,167,157,.12); }
/* Section cards — fix wrong class: ed-content-card → ed-card */
[data-theme="dark"] .ed-card           { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
/* Body — fix wrong class: ed-broadcast-body → ed-body */
[data-theme="dark"] .ed-body           { color: #e2e8f0 !important; }
[data-theme="dark"] .ed-body *         { color: #e2e8f0 !important; }
[data-theme="dark"] .ed-body p         { color: #e2e8f0 !important; }
[data-theme="dark"] .ed-body ul li     { color: #e2e8f0 !important; }
[data-theme="dark"] .ed-body ol li     { color: #e2e8f0 !important; }
[data-theme="dark"] .ed-body h2,
[data-theme="dark"] .ed-body h3        { color: #e2e8f0 !important; }
[data-theme="dark"] .ed-body a         { color: #4dd9cf !important; }
[data-theme="dark"] .ed-body blockquote { background: rgba(0,167,157,.1); border-left-color: rgba(0,167,157,.6); color: #cbd5e0 !important; }
/* Info card (sidebar) */
[data-theme="dark"] .ed-info-card      { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .ed-info-body      { background: #1a1f2e; }
[data-theme="dark"] .ed-info-item      { border-bottom-color: rgba(0,167,157,.15); }
[data-theme="dark"] .ed-info-label     { color: #e2e8f0; }
[data-theme="dark"] .ed-info-value     { color: #e2e8f0; }
[data-theme="dark"] .ed-ticket-sep     { background: #252b3b; }
/* Registration card — fix wrong class: ed-reg-card → ed-regist-card */
[data-theme="dark"] .ed-regist-card    { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ed-regist-open-label { color: #e2e8f0 }
[data-theme="dark"] .ed-regist-deadline { color: #9ca3af; }
[data-theme="dark"] .ed-regist-btn.closed { background: #252b3b; color: #6b7280; }
/* Countdown */
[data-theme="dark"] .ed-countdown-unit  { background: #252b3b; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ed-countdown-label { color: #9ca3af; }
/* Doc links */
[data-theme="dark"] .ed-doc-link        { background: #252b3b; color: #e2e8f0; }
[data-theme="dark"] .ed-doc-link:hover  { background: rgba(0,167,157,.12); }
/* Contact items */
[data-theme="dark"] .ed-contact-item   { background: #252b3b; }
[data-theme="dark"] .ed-contact-name   { color: #e2e8f0; }
[data-theme="dark"] .ed-contact-num    { color: #9ca3af; }
/* Share section */
[data-theme="dark"] .ed-share-section  { background: rgba(0,167,157,.06) !important; border-color: rgba(0,167,157,.2) !important; }
[data-theme="dark"] .ed-share-label    { color: #9ca3af; }
[data-theme="dark"] .ed-share-btn--copy { background: #1e2535; border-color: rgba(0,167,157,.3); color: #4dd9cf; }
[data-theme="dark"] .ed-share-btn--wa  { background: #1e2535; border-color: rgba(37,211,102,.25); }
/* Back btn & comments */
[data-theme="dark"] .ed-back-btn       { background: #1e2535; border-color: rgba(0,167,157,.25); color: #4dd9cf; }
[data-theme="dark"] .ed-comments-section { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .ed-comments-title   { color: #e2e8f0; }
</style>
@endverbatim
