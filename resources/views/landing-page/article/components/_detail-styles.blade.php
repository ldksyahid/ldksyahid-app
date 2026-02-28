@verbatim
<style>
/* ================================================================
   ARTICLE DETAIL  —  prefix: ad-
   ================================================================ */
:root {
    --ad-primary:       #00a79d;
    --ad-primary-dark:  #008b82;
    --ad-primary-light: #e0f7f5;
    --ad-dark:          #2c3e50;
    --ad-gray:          #7f8c8d;
    --ad-gray-100:      #f3f4f6;
    --ad-gray-200:      #e5e7eb;
}


/* ── Hero ──────────────────────────────────────────────────────── */
.ad-hero {
    position: relative;
    padding: 7.5rem 0 3.5rem;
    background: linear-gradient(145deg, #f0fffe 0%, #ffffff 55%, #f5f0ff 100%);
    overflow: hidden;
}
.ad-hero-blob {
    position: absolute; border-radius: 50%;
    filter: blur(80px); opacity: .16; pointer-events: none;
}
.ad-hero-blob-1 {
    width: 480px; height: 480px;
    background: var(--ad-primary);
    top: -140px; left: -100px;
}
.ad-hero-blob-2 {
    width: 340px; height: 340px;
    background: #6366f1;
    bottom: -80px; right: 4%;
}
.ad-hero-blob-3 {
    width: 240px; height: 240px;
    background: #f59e0b;
    top: 50%; left: 38%;
}
.ad-hero-inner {
    display: flex; align-items: flex-start; gap: 2.5rem;
}


/* ── Date Card ─────────────────────────────────────────────────── */
.ad-date-card {
    flex-shrink: 0; width: 128px;
    background: white; border-radius: 24px;
    padding: 1.6rem .9rem 1.4rem; text-align: center;
    box-shadow: 0 10px 40px rgba(0,167,157,.14), 0 2px 10px rgba(0,0,0,.07);
    flex-direction: column; align-items: center;
    position: relative; overflow: hidden;
}
.ad-date-deco {
    position: absolute; bottom: -24px; right: -24px;
    width: 90px; height: 90px; border-radius: 50%;
    background: linear-gradient(135deg, var(--ad-primary), #6366f1);
    opacity: .1;
}
.ad-date-day {
    font-size: .68rem; font-weight: 800; color: var(--ad-primary);
    text-transform: uppercase; letter-spacing: .7px; margin-bottom: .35rem;
}
.ad-date-num {
    font-size: 3.4rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, var(--ad-primary), var(--ad-primary-dark));
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    background-clip: text;
}
.ad-date-month {
    font-size: .72rem; font-weight: 700; color: var(--ad-gray);
    text-transform: uppercase; letter-spacing: .7px; margin-top: .3rem;
}
.ad-date-year {
    font-size: .68rem; color: var(--ad-gray); opacity: .55; margin-top: .12rem;
}

/* Mobile date chip */
.ad-date-chip {
    display: inline-flex; align-items: center; gap: .45rem;
    background: white; border: 1.5px solid var(--ad-gray-200);
    border-radius: 50px; padding: .4rem .9rem;
    font-size: .75rem; font-weight: 600; color: var(--ad-gray);
    margin-bottom: .75rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.ad-date-chip i { color: var(--ad-primary); font-size: .72rem; }


/* ── Hero Info ─────────────────────────────────────────────────── */
.ad-hero-info { flex: 1; min-width: 0; }

.ad-theme-badge {
    display: inline-flex; align-items: center; gap: .45rem;
    background: var(--ad-primary-light); color: var(--ad-primary);
    padding: .4rem 1.1rem .4rem .75rem; border-radius: 50px;
    font-size: .78rem; font-weight: 700; margin-bottom: .9rem; letter-spacing: .2px;
}
.ad-theme-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: var(--ad-primary); flex-shrink: 0;
    animation: adThemeDot 2s ease-in-out infinite;
}
@keyframes adThemeDot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .35; transform: scale(1.6); }
}

.ad-title {
    font-size: 2.1rem; font-weight: 800; line-height: 1.3;
    color: var(--ad-dark); margin: 0 0 1.2rem;
}

.ad-authors {
    display: flex; align-items: center; flex-wrap: wrap;
    gap: .5rem; margin-bottom: 1.25rem;
}
.ad-author-chip {
    display: flex; align-items: center; gap: .5rem;
    background: white; border: 1.5px solid var(--ad-gray-200);
    border-radius: 50px; padding: .38rem .85rem .38rem .5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.ad-author-icon {
    width: 26px; height: 26px; border-radius: 50%;
    background: var(--ad-primary-light);
    display: flex; align-items: center; justify-content: center;
    color: var(--ad-primary); font-size: .62rem; flex-shrink: 0;
}
.ad-author-text { display: flex; flex-direction: column; line-height: 1.25; }
.ad-author-label {
    font-size: .55rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .5px; color: var(--ad-gray); opacity: .6;
}
.ad-author-name { font-size: .8rem; font-weight: 600; color: var(--ad-dark); }
.ad-author-divider { width: 1px; height: 26px; background: var(--ad-gray-200); }


/* ── Share ─────────────────────────────────────────────────────── */
.ad-share-label {
    display: flex; align-items: center; gap: .55rem;
    font-size: .67rem; font-weight: 600; color: var(--ad-gray);
    letter-spacing: .3px; margin-bottom: .45rem;
    white-space: nowrap; opacity: .5;
}
.ad-share-label::before,
.ad-share-label::after {
    content: ''; flex: 1; height: 1px; background: var(--ad-gray-200);
}
.ad-share-row { display: flex; gap: .5rem; }
.ad-share-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: .4rem;
    border: 1.5px solid transparent; border-radius: 50px;
    padding: 7px 16px; font-size: .78rem; font-weight: 600;
    cursor: pointer; transition: all .22s ease; white-space: nowrap; line-height: 1;
}
.ad-share-btn i { font-size: .8rem; }
.ad-share-copy {
    background: color-mix(in srgb, var(--ad-primary) 8%, white);
    border-color: color-mix(in srgb, var(--ad-primary) 22%, transparent);
    color: var(--ad-primary);
}
.ad-share-copy:hover {
    background: var(--ad-primary); color: white; border-color: var(--ad-primary);
    box-shadow: 0 4px 14px color-mix(in srgb, var(--ad-primary) 30%, transparent);
    transform: translateY(-1px);
}
.ad-share-wa {
    background: rgba(37,211,102,.08);
    border-color: rgba(37,211,102,.28); color: #1da851;
}
.ad-share-wa:hover {
    background: #25d366; color: white; border-color: #25d366;
    box-shadow: 0 4px 14px rgba(37,211,102,.30);
    transform: translateY(-1px);
}
.ad-swal-below-nav { top: 76px !important; right: 1rem !important; }


/* ── Main layout ───────────────────────────────────────────────── */
.ad-main { padding-top: 2.5rem; padding-bottom: 4rem; }


/* ── Reader Card ───────────────────────────────────────────────── */
.ad-reader-card {
    background: white; border-radius: 22px; overflow: hidden;
    box-shadow: 0 10px 48px rgba(0,0,0,.1), 0 2px 10px rgba(0,0,0,.05);
    border: 1px solid var(--ad-gray-200);
}
.ad-reader-bar {
    display: flex; align-items: center; gap: .75rem;
    padding: .7rem 1rem;
    background: var(--ad-gray-100); border-bottom: 1px solid var(--ad-gray-200);
}
.ad-reader-dots { display: flex; gap: .38rem; flex-shrink: 0; }
.ad-rd { width: 12px; height: 12px; border-radius: 50%; }
.ad-rd-r { background: #ff5f57; }
.ad-rd-y { background: #ffbd2e; }
.ad-rd-g { background: #28c840; }
.ad-reader-url-pill {
    flex: 1; display: flex; align-items: center; gap: .4rem;
    background: white; border: 1px solid var(--ad-gray-200);
    border-radius: 50px; padding: .26rem .85rem;
    font-size: .7rem; color: var(--ad-gray); min-width: 0;
    box-shadow: inset 0 1px 3px rgba(0,0,0,.04);
}
.ad-reader-url-pill i { font-size: .62rem; color: #28c840; flex-shrink: 0; }
.ad-reader-open {
    flex-shrink: 0; width: 28px; height: 28px; border-radius: 8px;
    border: 1.5px solid var(--ad-gray-200); background: white;
    color: var(--ad-gray); display: flex; align-items: center;
    justify-content: center; font-size: .62rem; text-decoration: none;
    transition: all .2s ease;
}
.ad-reader-open:hover {
    background: var(--ad-primary); color: white; border-color: var(--ad-primary);
}
.ad-reader-body iframe {
    width: 100%; min-height: 640px; border: none; display: block;
}


/* ── Sidebar ───────────────────────────────────────────────────── */
.ad-sidebar {
    background: white; border-radius: 22px; padding: 1.4rem;
    box-shadow: 0 4px 24px rgba(0,0,0,.07);
    border: 1px solid var(--ad-gray-200);
    position: sticky; top: 88px;
}
.ad-sidebar-header {
    display: flex; align-items: center; gap: .6rem;
    margin-bottom: 1rem; padding-bottom: .85rem;
    border-bottom: 2px solid var(--ad-primary-light);
}
.ad-sidebar-icon {
    width: 34px; height: 34px; border-radius: 10px;
    background: var(--ad-primary-light);
    display: flex; align-items: center; justify-content: center;
    color: var(--ad-primary); font-size: .82rem;
}
.ad-sidebar-title { font-size: .95rem; font-weight: 800; color: var(--ad-dark); margin: 0; }

.ad-related-list { display: flex; flex-direction: column; gap: .5rem; }
.ad-related-card {
    display: flex; align-items: center; gap: .7rem;
    padding: .65rem .8rem; border-radius: 14px;
    border: 1.5px solid var(--ad-gray-200);
    text-decoration: none; background: var(--ad-gray-100);
    transition: all .22s ease;
}
.ad-related-card:hover {
    background: var(--ad-primary-light); border-color: var(--ad-primary);
    transform: translateX(4px);
    box-shadow: 0 4px 14px rgba(0,167,157,.13);
}
.ad-related-num {
    font-size: .62rem; font-weight: 800; color: var(--ad-primary);
    opacity: .45; flex-shrink: 0; font-family: monospace; letter-spacing: .5px;
}
.ad-related-info {
    flex: 1; min-width: 0; display: flex; flex-direction: column; gap: .16rem;
}
.ad-related-title {
    font-size: .8rem; font-weight: 600; color: var(--ad-dark);
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden; line-height: 1.42;
}
.ad-related-date {
    font-size: .66rem; color: var(--ad-gray); opacity: .65;
    display: flex; align-items: center; gap: .3rem;
}
.ad-related-date i { font-size: .58rem; }
.ad-related-arrow {
    font-size: .6rem; color: var(--ad-primary); flex-shrink: 0;
    opacity: 0; transition: opacity .2s, transform .2s;
}
.ad-related-card:hover .ad-related-arrow { opacity: 1; transform: translateX(2px); }


/* ── Bottom actions bar ─────────────────────────────────────────── */
.ad-actions {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 1rem;
    margin-top: 2rem; padding: 1.1rem 1.4rem;
    background: white; border-radius: 18px;
    border: 1.5px solid var(--ad-gray-200);
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
}
.ad-back-btn {
    display: inline-flex; align-items: center; gap: .5rem;
    background: var(--ad-primary-light);
    border: 1.5px solid color-mix(in srgb, var(--ad-primary) 25%, transparent);
    color: var(--ad-primary); text-decoration: none;
    border-radius: 50px; padding: .55rem 1.2rem;
    font-size: .82rem; font-weight: 700; transition: all .22s ease;
}
.ad-back-btn:hover {
    background: var(--ad-primary); color: white;
    box-shadow: 0 4px 14px rgba(0,167,157,.28);
    transform: translateX(-2px);
}
.ad-back-btn i { font-size: .72rem; }


/* ── Section divider ─────────────────────────────────────────────── */
.ad-section-divider {
    display: flex; align-items: center; gap: 1rem;
    margin: 2.5rem 0 1.5rem;
}
.ad-section-divider::before,
.ad-section-divider::after {
    content: ''; flex: 1; height: 2px;
    background: linear-gradient(to right, transparent, var(--ad-primary-light), transparent);
}
.ad-section-divider-icon {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--ad-primary-light);
    display: flex; align-items: center; justify-content: center;
    color: var(--ad-primary); font-size: .88rem;
}


/* ── Disqus ─────────────────────────────────────────────────────── */
.ad-disqus-wrap {
    background: white; border-radius: 22px;
    padding: 2rem; border: 1px solid var(--ad-gray-200);
    box-shadow: 0 4px 20px rgba(0,0,0,.06);
    margin-bottom: 2rem;
}


/* ── Responsive ─────────────────────────────────────────────────── */
@media (max-width: 991.98px) {
    .ad-reader-body iframe { min-height: 520px; }
    .ad-sidebar { position: static; }
}
@media (max-width: 767.98px) {
    .ad-hero { padding: 6.5rem 0 2.5rem; }
    .ad-title { font-size: 1.65rem; }
    .ad-reader-body iframe { min-height: 460px; }
}
@media (max-width: 575.98px) {
    .ad-title { font-size: 1.4rem; }
    .ad-share-btn span { display: none; }
    .ad-share-btn { padding: 8px 13px; }
    .ad-actions { padding: .9rem 1rem; }
    .ad-disqus-wrap { padding: 1.25rem; }
}
</style>
@endverbatim
