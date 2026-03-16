@verbatim
<style>
/* ================================================================
   NEWS DETAIL PAGE  —  prefix: nd-
   ================================================================ */

:root {
    --nd-primary:       #00a79d;
    --nd-primary-dark:  #008b82;
    --nd-primary-light: #e0f7f5;
    --nd-dark:          #1a1a2e;
    --nd-gray:          #6b7280;
    --nd-gray-100:      #f3f4f6;
    --nd-gray-200:      #e5e7eb;
    --nd-shadow-sm:     0 4px 20px rgba(0,0,0,.07);
    --nd-shadow-hover:  0 14px 40px rgba(0,167,157,.15);
    --nd-radius:        20px;
    --nd-transition:    all .3s cubic-bezier(.4,0,.2,1);
}

/* ─── Reading Progress Bar ─────────────────────────────────────── */
.nd-progress {
    position: fixed; top: 0; left: 0;
    height: 3px; width: 0%;
    background: linear-gradient(90deg, var(--nd-primary), #00d9bb);
    z-index: 2000;
    transition: width .1s linear;
    border-radius: 0 2px 2px 0;
}

/* ─── Hero Section ─────────────────────────────────────────────── */
.nd-hero {
    position: relative;
    min-height: 62vh;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    background: var(--nd-dark);
}
.nd-hero-bg {
    position: absolute; inset: 0;
    background-size: cover;
    background-position: center top;
    background-repeat: no-repeat;
    transition: transform 10s ease;
    will-change: transform;
}
.nd-hero:hover .nd-hero-bg { transform: scale(1.04); }

.nd-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,.05)  0%,
        rgba(0,0,0,.18) 40%,
        rgba(0,0,0,.72) 72%,
        rgba(0,0,0,.92) 100%
    );
}

.nd-hero-content {
    position: relative; z-index: 2;
    padding: 5rem 0 2.75rem;
    width: 100%;
}

.nd-hero-badge {
    display: inline-flex; align-items: center; gap: .45rem;
    background: rgba(255,255,255,.14);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.28);
    border-radius: 50px;
    padding: .3rem 1.1rem;
    font-size: .72rem; font-weight: 800;
    color: white; letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: .9rem;
    cursor: default;
}
.nd-hero-badge-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--nd-primary); flex-shrink: 0;
    animation: ndHeroPulse 2s ease infinite;
}
@keyframes ndHeroPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(0,212,200,.5); }
    50%      { box-shadow: 0 0 0 5px rgba(0,212,200,0); }
}

.nd-hero-title {
    font-size: clamp(1.35rem, 3.5vw, 2.35rem);
    font-weight: 900; color: white; line-height: 1.3;
    margin: 0 0 1.25rem;
    text-shadow: 0 2px 14px rgba(0,0,0,.4);
    max-width: 820px;
}

.nd-hero-metas {
    display: flex; flex-wrap: wrap; gap: .5rem; align-items: center;
}
.nd-hero-meta {
    display: inline-flex; align-items: center; gap: .4rem;
    background: rgba(255,255,255,.12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 50px;
    padding: .28rem .85rem;
    font-size: .74rem; font-weight: 600;
    color: rgba(255,255,255,.92);
    transition: var(--nd-transition);
}
.nd-hero-meta:hover { background: rgba(255,255,255,.2); }
.nd-hero-meta i { font-size: .68rem; opacity: .8; }

/* ─── Section entrance animation ──────────────────────────────── */
.nd-enter {
    opacity: 0; transform: translateY(22px);
    transition: opacity .55s ease, transform .55s ease;
}
.nd-enter.nd-visible { opacity: 1; transform: translateY(0); }

/* ─── Content Layout (flexbox — no Bootstrap row on mobile) ──── */
.nd-content-wrap { padding: 2.75rem 0 4rem; }

.nd-layout {
    display: flex; gap: 2.5rem; align-items: flex-start;
}
.nd-main  { flex: 1; min-width: 0; }
.nd-aside { flex: 0 0 310px; width: 310px; }

/* Pre-layout: featured image — inside nd-main, full column width */
.nd-pre-layout { margin-bottom: 1.5rem; }

/* Post-layout: back btn / share / comments — same width as nd-main */
.nd-post-layout { width: calc(100% - 310px - 2.5rem); }

/* ─── Back button ──────────────────────────────────────────────── */
.nd-back-btn {
    display: inline-flex; align-items: center; gap: .55rem;
    color: var(--nd-primary); font-size: .85rem; font-weight: 700;
    text-decoration: none;
    padding: .6rem 1.2rem;
    background: var(--nd-primary-light);
    border-radius: 50px;
    transition: var(--nd-transition);
    margin-bottom: 1.75rem;
    border: 1.5px solid rgba(0,167,157,.2);
}
.nd-back-btn:hover {
    background: var(--nd-primary); color: white;
    transform: translateX(-4px);
    box-shadow: 0 4px 18px rgba(0,167,157,.3);
}
.nd-back-btn i { font-size: .75rem; transition: transform .25s ease; }
.nd-back-btn:hover i { transform: translateX(-3px); }

/* ─── Divider ──────────────────────────────────────────────────── */
.nd-divider {
    height: 2px; border-radius: 2px;
    background: linear-gradient(90deg, transparent, var(--nd-primary-light) 20%, var(--nd-primary) 50%, var(--nd-primary-light) 80%, transparent);
    margin: 2rem 0;
}

/* ─── News Body ────────────────────────────────────────────────── */
.nd-body-card {
    background: white;
    border-radius: var(--nd-radius);
    padding: 2rem;
    box-shadow: var(--nd-shadow-sm);
    border: 1px solid rgba(0,0,0,.04);
    margin-bottom: 1.5rem;
}

.nd-body {
    font-size: 1.04rem; line-height: 1.88; color: #2d3748;
}
.nd-body p {
    margin-bottom: 1.35rem; text-align: justify;
}
.nd-body p:last-child { margin-bottom: 0; }

.nd-body img {
    max-width: 100%; height: auto; display: block;
    border-radius: 16px; margin: 1.5rem auto;
    box-shadow: 0 8px 32px rgba(0,0,0,.1);
}
.nd-body h2 {
    font-size: 1.4rem; font-weight: 800; color: var(--nd-dark);
    margin: 2.25rem 0 .85rem;
    padding-bottom: .5rem;
    border-bottom: 2px solid var(--nd-primary-light);
}
.nd-body h3 {
    font-size: 1.15rem; font-weight: 700; color: var(--nd-dark);
    margin: 1.85rem 0 .7rem;
}
.nd-body h4 { font-size: 1rem; font-weight: 700; color: var(--nd-dark); margin: 1.5rem 0 .6rem; }
.nd-body a  { color: var(--nd-primary); text-decoration: underline; text-underline-offset: 3px; }
.nd-body a:hover { color: var(--nd-primary-dark); }

/* Animated growing bullet for ul */
.nd-body ul {
    list-style: none; padding: 0; margin: 0 0 1.35rem;
}
.nd-body ul li {
    display: flex; align-items: flex-start; gap: .7rem;
    padding: .3rem 0; line-height: 1.75; color: #2d3748;
}
.nd-body ul li::before {
    content: '';
    width: 8px; height: 8px; min-width: 8px;
    border-radius: 50%;
    background: var(--nd-primary);
    margin-top: .55rem; flex-shrink: 0;
    animation: ndBulletGrow 2.8s ease-in-out infinite;
}
@keyframes ndBulletGrow {
    0%,100% { transform: scale(1);   box-shadow: 0 0 0 0 rgba(0,167,157,.45); }
    50%      { transform: scale(1.4); box-shadow: 0 0 0 5px rgba(0,167,157,0); }
}

.nd-body ol {
    padding-left: 1.6rem; margin: 0 0 1.35rem;
}
.nd-body ol li { padding: .25rem 0; line-height: 1.75; color: #2d3748; }

/* Blockquote */
.nd-body blockquote {
    border-left: 4px solid var(--nd-primary);
    padding: 1rem 1.5rem; margin: 2rem 0;
    background: var(--nd-primary-light);
    border-radius: 0 16px 16px 0;
    font-style: italic; color: #374151;
}
.nd-body blockquote p:last-child { margin-bottom: 0; }

/* Table */
.nd-body table {
    width: 100%; border-collapse: collapse;
    margin: 1.5rem 0; font-size: .92rem;
    border-radius: 12px; overflow: hidden;
    box-shadow: var(--nd-shadow-sm);
}
.nd-body table th {
    background: var(--nd-primary); color: white;
    padding: .75rem 1rem; font-weight: 700; text-align: left;
}
.nd-body table td {
    padding: .65rem 1rem;
    border-bottom: 1px solid var(--nd-gray-100);
}
.nd-body table tr:last-child td { border-bottom: none; }
.nd-body table tr:nth-child(even) td { background: var(--nd-gray-100); }

/* Image caption */
.nd-img-caption {
    display: block; text-align: center;
    font-size: .82rem; color: var(--nd-gray);
    font-style: italic; margin: -.75rem 0 1.5rem;
}

/* ─── Sidebar Cards ────────────────────────────────────────────── */
.nd-sidebar { }

.nd-card-box {
    background: white; border-radius: var(--nd-radius);
    padding: 1.4rem 1.5rem;
    box-shadow: var(--nd-shadow-sm);
    border: 1px solid rgba(0,0,0,.04);
    margin-bottom: 1.35rem;
}
.nd-card-box-title {
    font-size: .7rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .65px;
    color: var(--nd-primary); margin: 0 0 1rem;
    display: flex; align-items: center; gap: .55rem;
}
.nd-card-box-title::before {
    content: ''; width: 14px; height: 3px;
    background: var(--nd-primary); border-radius: 2px; flex-shrink: 0;
}

/* Meta items */
.nd-meta-item {
    display: flex; align-items: flex-start; gap: .72rem;
    padding: .65rem 0;
    border-bottom: 1px solid var(--nd-gray-100);
}
.nd-meta-item:last-child { border-bottom: none; padding-bottom: 0; }
.nd-meta-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--nd-primary-light);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.nd-meta-icon i { color: var(--nd-primary); font-size: .8rem; }
.nd-meta-text   { display: flex; flex-direction: column; min-width: 0; }
.nd-meta-label  {
    font-size: .62rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .45px; color: var(--nd-gray); opacity: .7; line-height: 1.1;
}
.nd-meta-value  {
    font-size: .88rem; font-weight: 700; color: var(--nd-dark);
    line-height: 1.4; word-break: break-word;
}

/* Share buttons in sidebar */
.nd-share-row { display: flex; gap: .5rem; }
.nd-share-btn {
    flex: 1; display: inline-flex; align-items: center; justify-content: center;
    gap: .4rem; padding: .55rem .7rem; border-radius: 12px;
    font-size: .78rem; font-weight: 700; cursor: pointer;
    border: 1.5px solid transparent; transition: var(--nd-transition);
}
.nd-share-copy {
    background: var(--nd-primary-light); border-color: rgba(0,167,157,.2);
    color: var(--nd-primary);
}
.nd-share-copy:hover {
    background: var(--nd-primary); color: white; border-color: var(--nd-primary);
    box-shadow: 0 4px 14px rgba(0,167,157,.3); transform: translateY(-1px);
}
.nd-share-wa {
    background: rgba(37,211,102,.08); border-color: rgba(37,211,102,.28);
    color: #1da851;
}
.nd-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.3); transform: translateY(-1px);
}
.nd-share-tw {
    background: #1a1a2e; border-color: #1a1a2e; color: white;
}
.nd-share-tw:hover {
    background: #000; border-color: #000;
    box-shadow: 0 4px 14px rgba(0,0,0,.3); transform: translateY(-1px);
}

/* Related news list — desktop */
.nd-related-list { display: flex; flex-direction: column; gap: .35rem; }
.nd-related-item {
    display: flex; gap: .9rem; text-decoration: none;
    padding: .65rem .55rem;
    border-radius: 14px;
    border: 1px solid transparent;
    position: relative; overflow: hidden;
    transition: all .22s ease;
}
.nd-related-item:hover {
    background: linear-gradient(135deg, var(--nd-primary-light), #f8fffe 70%);
    border-color: rgba(0,167,157,.15);
    box-shadow: 0 2px 12px rgba(0,167,157,.1);
    transform: translateX(5px);
}
.nd-related-thumb {
    width: 78px; height: 64px; border-radius: 12px;
    object-fit: cover; flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    transition: transform .3s ease;
}
.nd-related-item:hover .nd-related-thumb { transform: scale(1.06); }
.nd-related-info {
    min-width: 0; flex: 1;
    display: flex; flex-direction: column; justify-content: center; gap: .22rem;
}
.nd-related-title {
    font-size: .83rem; font-weight: 700; color: var(--nd-dark);
    line-height: 1.4; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color .2s ease;
}
.nd-related-item:hover .nd-related-title { color: var(--nd-primary-dark); }
.nd-related-date {
    font-size: .67rem; color: var(--nd-gray);
    display: flex; align-items: center; gap: .28rem;
}
.nd-related-empty {
    font-size: .85rem; color: var(--nd-gray);
    text-align: center; padding: .5rem 0; font-style: italic;
}

/* ─── Share section (at bottom of main col) ───────────────────── */
.nd-share-section {
    background: linear-gradient(135deg, var(--nd-primary-light), white 70%);
    border: 1px solid rgba(0,167,157,.12);
    border-radius: var(--nd-radius); padding: 1.5rem 2rem;
    display: flex; align-items: center; gap: 1.25rem;
    flex-wrap: wrap; margin-top: 1.5rem;
}
.nd-share-section-label {
    font-size: .82rem; font-weight: 700; color: var(--nd-gray);
    text-transform: uppercase; letter-spacing: .4px; flex-shrink: 0;
}
.nd-share-btns { display: flex; gap: .55rem; flex-wrap: wrap; flex: 1; }
.nd-share-full-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    padding: .6rem 1.35rem; border-radius: 50px;
    font-size: .82rem; font-weight: 700; cursor: pointer;
    border: 1.5px solid transparent; transition: var(--nd-transition);
    text-decoration: none;
}
.nd-share-full-btn.nd-share-copy {
    background: white; border-color: rgba(0,167,157,.25);
    color: var(--nd-primary); box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.nd-share-full-btn.nd-share-copy:hover {
    background: var(--nd-primary); color: white;
    box-shadow: 0 4px 18px rgba(0,167,157,.35); transform: translateY(-1px);
}
.nd-share-full-btn.nd-share-wa {
    background: white; border-color: rgba(37,211,102,.3);
    color: #1da851; box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.nd-share-full-btn.nd-share-wa:hover {
    background: #25d366; color: white;
    box-shadow: 0 4px 18px rgba(37,211,102,.35); transform: translateY(-1px);
}
.nd-share-full-btn.nd-share-tw {
    background: #1a1a2e; border-color: #1a1a2e;
    color: white; box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.nd-share-full-btn.nd-share-tw:hover {
    background: #000; box-shadow: 0 4px 18px rgba(0,0,0,.35); transform: translateY(-1px);
}

/* ─── Comments Section ────────────────────────────────────────── */
.nd-comments-section {
    background: white; border-radius: var(--nd-radius);
    padding: 2rem; box-shadow: var(--nd-shadow-sm);
    border: 1px solid rgba(0,0,0,.04);
    margin-top: 1.5rem;
}
.nd-comments-title {
    font-size: 1.05rem; font-weight: 800; color: var(--nd-dark);
    margin: 0 0 1.5rem;
    display: flex; align-items: center; gap: .6rem;
}
.nd-comments-title::before {
    content: ''; width: 4px; height: 22px;
    background: linear-gradient(180deg, var(--nd-primary), var(--nd-primary-dark));
    border-radius: 2px; flex-shrink: 0;
}

/* SweetAlert toast fix */
.nd-swal-below-nav { top: 76px !important; right: 1rem !important; }

/* ─── Responsive ───────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .nd-layout { flex-direction: column; }
    .nd-aside  { flex: unset; width: 100%; }
    .nd-sidebar { position: static; }
    .nd-pre-layout, .nd-post-layout { max-width: 100%; width: 100%; }

    /* Horizontal scroll cards for related on tablet/mobile */
    .nd-related-list {
        flex-direction: row; overflow-x: auto; gap: .9rem;
        padding: .25rem .05rem 1.1rem;
        scrollbar-width: none; scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }
    .nd-related-list::-webkit-scrollbar { display: none; }
    .nd-related-item {
        flex: 0 0 152px; flex-direction: column;
        border-radius: 16px; overflow: hidden; padding: 0;
        background: white;
        box-shadow: 0 3px 14px rgba(0,0,0,.09);
        border: 1px solid var(--nd-gray-200);
        scroll-snap-align: start;
        transition: transform .22s ease, box-shadow .22s ease;
    }
    .nd-related-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 22px rgba(0,167,157,.16);
        background: white;
    }
    .nd-related-thumb { width: 100%; height: 100px; border-radius: 0; }
    .nd-related-item:hover .nd-related-thumb { transform: none; }
    .nd-related-info {
        padding: .65rem .7rem .75rem;
        flex: 1; display: flex; flex-direction: column; gap: .3rem;
        border-top: 2.5px solid var(--nd-primary-light);
    }
    .nd-related-title { font-size: .78rem; -webkit-line-clamp: 3; margin: 0; }
    .nd-related-date  { font-size: .66rem; margin-top: auto; }

    .nd-hero { min-height: 52vh; }
    .nd-body-card { padding: 1.5rem 1.25rem; }
    .nd-share-section { padding: 1.25rem; }
}
@media (max-width: 575.98px) {
    .nd-hero { min-height: 44vh; }
    .nd-hero-title { font-size: 1.25rem; }
    .nd-hero-content { padding-bottom: 1.75rem; }
    .nd-content-wrap { padding: 1.5rem 0 3rem; }
    .nd-body { font-size: .97rem; }
    .nd-body-card { padding: 1.25rem 1rem; }
    .nd-back-btn { font-size: .78rem; padding: .5rem 1rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
/* Body & content card */
[data-theme="dark"] .nd-body-card     { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nd-body          { color: #e2e8f0 !important; }
[data-theme="dark"] .nd-body *        { color: #e2e8f0 !important; }
[data-theme="dark"] .nd-body p        { color: #e2e8f0 !important; }
[data-theme="dark"] .nd-body ul li    { color: #e2e8f0 !important; }
[data-theme="dark"] .nd-body ol li    { color: #e2e8f0 !important; }
[data-theme="dark"] .nd-body h2,
[data-theme="dark"] .nd-body h3,
[data-theme="dark"] .nd-body h4       { color: #e2e8f0 !important; }
[data-theme="dark"] .nd-body a        { color: #4dd9cf !important; }
[data-theme="dark"] .nd-body blockquote { background: rgba(0,167,157,.1); border-left-color: rgba(0,167,157,.6); color: #cbd5e0 !important; }
[data-theme="dark"] .nd-body table td { border-bottom-color: rgba(0,167,157,.15); color: #cbd5e0 !important; }
[data-theme="dark"] .nd-body table tr:nth-child(even) td { background: #252b3b; }
[data-theme="dark"] .nd-img-caption   { color: #9ca3af !important; }
/* Back btn */
[data-theme="dark"] .nd-back-btn      { background: #1e2535; border-color: rgba(0,167,157,.25); color: #4dd9cf; }
/* Sidebar — fix wrong class name: nd-sidebar-card → nd-card-box */
[data-theme="dark"] .nd-card-box       { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nd-meta-value     { color: #e2e8f0; }
[data-theme="dark"] .nd-meta-label     { color: #9ca3af; }
[data-theme="dark"] .nd-meta-item      { border-bottom-color: rgba(0,167,157,.15); }
/* Share buttons (sidebar) */
[data-theme="dark"] .nd-share-btn      { background: #1e2535; border-color: rgba(0,167,157,.25); color: #e2e8f0; }
/* Related news (desktop list) */
[data-theme="dark"] .nd-related-title  { color: #e2e8f0; }
[data-theme="dark"] .nd-related-date   { color: #9ca3af; }
[data-theme="dark"] .nd-related-item:hover { background: rgba(0,167,157,.1); border-color: rgba(0,167,157,.2); }
/* Related news (mobile card) */
[data-theme="dark"] .nd-related-item   { background: #252b3b; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nd-related-info   { border-top-color: rgba(0,167,157,.2); }
/* Share section at bottom */
[data-theme="dark"] .nd-share-section  { background: rgba(0,167,157,.06); border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .nd-share-section-label { color: #9ca3af; }
[data-theme="dark"] .nd-share-full-btn.nd-share-copy { background: #1e2535; border-color: rgba(0,167,157,.3); color: #4dd9cf; }
[data-theme="dark"] .nd-share-full-btn.nd-share-wa   { background: #1e2535; border-color: rgba(37,211,102,.25); }
/* Comments */
[data-theme="dark"] .nd-comments-section { background: #1a1f2e; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .nd-comments-title   { color: #e2e8f0; }
</style>
@endverbatim
