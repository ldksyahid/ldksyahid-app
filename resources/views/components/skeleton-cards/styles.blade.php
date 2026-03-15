{{-- ================================================================
     SKELETON CARDS — shared styles
     Usage: @include('components.skeleton-cards.styles')
     Supports types: campaign, article, book, event, news
     ================================================================ --}}
@verbatim
<style>
/* ================================================================
   SKELETON CARDS  —  prefix: sk-
   ================================================================ */

/* ── Shared shimmer animation ── */
@keyframes skShimmer {
    to { transform: translateX(200%); }
}
.sk-base {
    position: relative;
    overflow: hidden;
    background: #e0e0e0;
    border-radius: 8px;
}
.sk-base::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(255,255,255,0.75) 50%,
        transparent 100%
    );
    transform: translateX(-100%);
    animation: skShimmer 1.5s ease-in-out infinite;
}

/* ================================================================
   CAMPAIGN  (celengan syahid)
   ================================================================ */
.sk-campaign-grid  { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.sk-campaign-card  { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.sk-campaign-img   { aspect-ratio: 4/3; border-radius: 0; }
.sk-campaign-body  { padding: 1.25rem; display: flex; flex-direction: column; gap: .625rem; }
.sk-campaign-org   { height: 18px; width: 45%; border-radius: 6px; }
.sk-campaign-ttl   { height: 20px; width: 90%; border-radius: 6px; }
.sk-campaign-ttl2  { height: 20px; width: 65%; border-radius: 6px; }
.sk-campaign-prog  { height:  6px; width: 100%; border-radius: 10px; }
.sk-campaign-stat  { height: 58px; width: 100%; border-radius: 14px; }
.sk-campaign-btn   { height: 38px; width: 100%; border-radius: 30px; margin-top: .25rem; }

.sk-campaign-carousel { display: flex; gap: 1rem; overflow: hidden; padding: 0 calc(50% - 140px) 1rem; }
.sk-campaign-mcard    { flex: 0 0 280px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.sk-campaign-mimg     { aspect-ratio: 4/3; border-radius: 0; }
.sk-campaign-mbody    { padding: 1rem; display: flex; flex-direction: column; gap: .5rem; }
.sk-campaign-mttl     { height: 15px; width: 85%; border-radius: 6px; }
.sk-campaign-msub     { height: 12px; width: 55%; border-radius: 6px; }
.sk-campaign-mprog    { height:  5px; width: 100%; border-radius: 10px; }

/* ================================================================
   ARTICLE
   ================================================================ */
.sk-article-grid   { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.sk-article-card   { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.sk-article-img    { aspect-ratio: 4/3; border-radius: 0; }
.sk-article-body   { padding: 1.25rem; display: flex; flex-direction: column; gap: .6rem; }
.sk-article-badge  { height: 22px; width: 90px; border-radius: 20px; }
.sk-article-ttl    { height: 20px; width: 90%; border-radius: 6px; }
.sk-article-ttl2   { height: 20px; width: 65%; border-radius: 6px; }
.sk-article-people { display: flex; align-items: center; gap: .6rem; margin-top: .25rem; }
.sk-article-avatar { height: 32px; width: 32px; border-radius: 50%; flex-shrink: 0; }
.sk-article-pinfo  { display: flex; flex-direction: column; gap: .35rem; flex: 1; }
.sk-article-plabel { height: 10px; width: 45%; border-radius: 4px; }
.sk-article-pname  { height: 13px; width: 70%; border-radius: 4px; }
.sk-article-btn    { height: 38px; width: 100%; border-radius: 30px; margin-top: .25rem; }

.sk-article-carousel { display: flex; gap: 1rem; overflow: hidden; padding: .25rem 1.25rem 1rem; }
.sk-article-mcard    { flex: 0 0 82vw; max-width: 300px; background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.09); }
.sk-article-mimg     { aspect-ratio: 3/2; width: 100%; border-radius: 0; }
.sk-article-mbody    { padding: .85rem 1rem 1rem; display: flex; flex-direction: column; gap: .45rem; }
.sk-article-mtheme   { height: 22px; width: 80px; border-radius: 8px; }
.sk-article-mttl     { height: 16px; width: 90%; border-radius: 4px; }
.sk-article-mttl2    { height: 16px; width: 70%; border-radius: 4px; }
.sk-article-mpeople  { display: flex; align-items: center; gap: .5rem; margin-top: .25rem; }
.sk-article-mavatar  { height: 28px; width: 28px; border-radius: 50%; flex-shrink: 0; }
.sk-article-mpinfo   { display: flex; flex-direction: column; gap: .3rem; flex: 1; }
.sk-article-mplabel  { height: 9px; width: 40%; border-radius: 4px; }
.sk-article-mpname   { height: 12px; width: 65%; border-radius: 4px; }

/* ================================================================
   BOOK  (catalog)
   ================================================================ */
.sk-book-list        { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
.sk-book-card        { display: flex; gap: 1.25rem; background: #fff; border-radius: 18px; padding: 1.25rem 1.5rem; box-shadow: 0 4px 18px rgba(0,0,0,.07); overflow: hidden; }
.sk-book-cover       { flex-shrink: 0; width: 130px; min-height: 190px; border-radius: 12px; }
.sk-book-content     { flex: 1; display: flex; flex-direction: column; gap: .5rem; padding-top: .25rem; }
/* title */
.sk-book-ttl         { height: 22px; width: 72%; border-radius: 6px; }
/* meta row: date + category badge */
.sk-book-meta-row    { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }
.sk-book-meta-date   { height: 14px; width: 100px; border-radius: 4px; }
.sk-book-meta-badge  { height: 20px; width: 65px; border-radius: 20px; }
/* tab nav: Spesifikasi | Sinopsis */
.sk-book-tabs-nav    { display: flex; gap: .5rem; margin-top: .25rem; }
.sk-book-tab         { height: 30px; border-radius: 8px; }
.sk-book-tab-1       { width: 100px; }
.sk-book-tab-2       { width: 80px; }
/* spec rows: label + value */
.sk-book-specs       { display: flex; flex-direction: column; gap: .4rem; }
.sk-book-spec-row    { display: flex; align-items: center; gap: .75rem; }
.sk-book-spec-label  { height: 12px; width: 80px; flex-shrink: 0; border-radius: 4px; }
.sk-book-spec-val    { height: 12px; flex: 1; max-width: 55%; border-radius: 4px; }
/* actions */
.sk-book-actions     { display: flex; gap: .75rem; margin-top: auto; padding-top: .25rem; }
.sk-book-btn         { height: 36px; flex: 1; border-radius: 20px; }
.sk-book-btn-sm      { height: 36px; width: 36px; flex-shrink: 0; border-radius: 50%; }

.sk-book-carousel { display: flex; gap: 1rem; overflow: hidden; padding: 0 calc(50% - 130px) 1rem; }
.sk-book-mcard    { flex: 0 0 260px; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 18px rgba(0,0,0,.08); }
.sk-book-mcover   { height: 200px; border-radius: 0; }
.sk-book-mbody    { padding: 1rem; display: flex; flex-direction: column; gap: .5rem; }
.sk-book-mttl     { height: 16px; width: 85%; border-radius: 4px; }
.sk-book-mauth    { height: 12px; width: 55%; border-radius: 4px; }
.sk-book-mhint    { height: 10px; width: 40%; border-radius: 4px; margin-top: .25rem; }

/* ================================================================
   EVENT
   ================================================================ */
.sk-event-grid   { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.sk-event-card   { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.sk-event-img    { aspect-ratio: 3/2; border-radius: 0; }
.sk-event-body   { padding: 1.25rem; display: flex; flex-direction: column; gap: .6rem; }
.sk-event-div    { height: 18px; width: 55%; border-radius: 20px; }
.sk-event-ttl    { height: 20px; width: 90%; border-radius: 6px; }
.sk-event-ttl2   { height: 20px; width: 60%; border-radius: 6px; }
.sk-event-meta   { height: 14px; width: 70%; border-radius: 4px; }
.sk-event-meta2  { height: 14px; width: 55%; border-radius: 4px; }
.sk-event-btn    { height: 38px; width: 100%; border-radius: 30px; margin-top: .25rem; }

.sk-event-carousel { display: flex; gap: 1rem; overflow: hidden; padding: 0 calc(50% - 140px) 1rem; }
.sk-event-mcard    { flex: 0 0 280px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.sk-event-mimg     { aspect-ratio: 3/2; border-radius: 0; }
.sk-event-mbody    { padding: 1rem; display: flex; flex-direction: column; gap: .4rem; }
.sk-event-mdiv     { height: 12px; width: 50%; border-radius: 4px; }
.sk-event-mttl     { height: 15px; width: 85%; border-radius: 4px; }
.sk-event-mttl2    { height: 15px; width: 60%; border-radius: 4px; }

/* ================================================================
   GALLERY  (about/gallery)
   ================================================================ */
/* Desktop — single-column list of event cards */
.sk-gallery-list   { display: flex; flex-direction: column; gap: 2.25rem; }
.sk-gallery-card   { background: #fff; border-radius: 24px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,.07); }
.sk-gallery-header { height: 56px; border-radius: 0; }
.sk-gallery-body   { padding: 1.5rem; display: flex; flex-direction: column; gap: .75rem; }
.sk-gallery-ttl    { height: 22px; width: 58%; border-radius: 6px; }
.sk-gallery-desc   { height: 15px; width: 95%; border-radius: 4px; }
.sk-gallery-desc2  { height: 15px; width: 72%; border-radius: 4px; }
.sk-gallery-photos { display: grid; grid-template-columns: repeat(4, 1fr); gap: .5rem; margin-top: .25rem; }
.sk-gallery-photo  { aspect-ratio: 1; border-radius: 10px; }

/* Mobile — single-column list */
.sk-gallery-mlist  { display: flex; flex-direction: column; gap: 1rem; }
.sk-gallery-mcard  { background: #fff; border-radius: 18px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.09); }
.sk-gallery-mthumb { aspect-ratio: 4/3; width: 100%; border-radius: 0; }
.sk-gallery-mbody  { padding: .9rem 1.1rem 1.1rem; display: flex; flex-direction: column; gap: .5rem; }
.sk-gallery-mttl   { height: 18px; width: 75%; border-radius: 4px; }
.sk-gallery-mdesc  { height: 13px; width: 90%; border-radius: 4px; }
.sk-gallery-mdesc2 { height: 13px; width: 60%; border-radius: 4px; }

/* ================================================================
   NEWS
   ================================================================ */
.sk-news-grid    { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
.sk-news-card    { background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.sk-news-img     { aspect-ratio: 4/3; border-radius: 0; }
.sk-news-body    { padding: 1.25rem; display: flex; flex-direction: column; gap: .6rem; }
.sk-news-pub     { height: 18px; width: 55%; border-radius: 20px; }
.sk-news-ttl     { height: 20px; width: 90%; border-radius: 6px; }
.sk-news-ttl2    { height: 20px; width: 65%; border-radius: 6px; }
.sk-news-exc     { height: 14px; width: 100%; border-radius: 4px; }
.sk-news-exc2    { height: 14px; width:  80%; border-radius: 4px; }
.sk-news-people  { display: flex; align-items: center; gap: .6rem; }
.sk-news-avatar  { height: 32px; width: 32px; border-radius: 50%; flex-shrink: 0; }
.sk-news-pinfo   { display: flex; flex-direction: column; gap: .35rem; flex: 1; }
.sk-news-plabel  { height: 10px; width: 45%; border-radius: 4px; }
.sk-news-pname   { height: 13px; width: 70%; border-radius: 4px; }
.sk-news-btn     { height: 38px; width: 100%; border-radius: 30px; margin-top: .25rem; }

.sk-news-carousel { display: flex; gap: 1rem; overflow: hidden; padding: .25rem .5rem 1rem; }
.sk-news-mcard    { flex: 0 0 85vw; max-width: 340px; background: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.sk-news-mimg     { aspect-ratio: 16/9; width: 100%; border-radius: 0; }
.sk-news-mbody    { padding: 1rem; display: flex; flex-direction: column; gap: .5rem; }
.sk-news-mpub     { height: 20px; width: 80px; border-radius: 50px; }
.sk-news-mttl     { height: 15px; width: 90%; border-radius: 4px; }
.sk-news-mttl2    { height: 15px; width: 68%; border-radius: 4px; }
.sk-news-mpeople  { display: flex; align-items: center; gap: .5rem; margin-top: .25rem; }
.sk-news-mavatar  { height: 28px; width: 28px; border-radius: 50%; flex-shrink: 0; }
.sk-news-mpinfo   { display: flex; flex-direction: column; gap: .3rem; flex: 1; }
.sk-news-mplabel  { height: 9px; width: 40%; border-radius: 4px; }
.sk-news-mpname   { height: 12px; width: 65%; border-radius: 4px; }

/* ================================================================
   CALL KESTARI  (service/call-kestari)
   Breakpoint: md (768px) — same as real cards
   ================================================================ */
/* Desktop — 3-col grid */
.sk-ck-grid      { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; margin-bottom: 1.5rem; }
.sk-ck-card      { background: #fff; border-radius: 22px; overflow: hidden; border: 1.5px solid #e5e7eb; box-shadow: 0 4px 20px rgba(0,0,0,.06); display: flex; flex-direction: column; }
.sk-ck-icon-wrap { padding: 1.85rem 2rem; background: #e0f7f5; display: flex; align-items: center; justify-content: center; }
.sk-ck-icon      { width: 66px; height: 66px; border-radius: 18px; }
.sk-ck-body      { padding: 1.2rem 1.4rem 1.4rem; display: flex; flex-direction: column; gap: .55rem; flex: 1; }
.sk-ck-name      { height: 20px; width: 75%; border-radius: 6px; }
.sk-ck-link      { height: 13px; width: 90%; border-radius: 4px; }
.sk-ck-link2     { height: 13px; width: 60%; border-radius: 4px; }
.sk-ck-footer    { display: flex; align-items: center; gap: .6rem; border-top: 1px solid #e5e7eb; padding-top: .85rem; margin-top: .75rem; }
.sk-ck-share     { height: 30px; width: 74px; border-radius: 50px; }
.sk-ck-share2    { height: 30px; width: 84px; border-radius: 50px; }
.sk-ck-cta       { height: 34px; width: 90px; border-radius: 50px; margin-left: auto; }

/* Mobile — vertical list */
.sk-ck-mlist  { display: flex; flex-direction: column; gap: .7rem; }
.sk-ck-mcard  { display: flex; align-items: center; gap: .8rem; background: #fff; border-radius: 18px; border: 1.5px solid #e5e7eb; padding: .85rem; box-shadow: 0 3px 14px rgba(0,0,0,.07); }
.sk-ck-micon  { width: 50px; height: 50px; border-radius: 14px; flex-shrink: 0; }
.sk-ck-minfo  { flex: 1; display: flex; flex-direction: column; gap: .35rem; }
.sk-ck-mname  { height: 16px; width: 70%; border-radius: 4px; }
.sk-ck-mlink  { height: 11px; width: 85%; border-radius: 4px; }
.sk-ck-marrow { width: 14px; height: 14px; border-radius: 4px; flex-shrink: 0; }

/* ── Dark Mode ── */
[data-theme="dark"] .sk-base { background: #252d42; }
[data-theme="dark"] .sk-base::after {
    background: linear-gradient(
        90deg,
        transparent 0%,
        rgba(255,255,255,0.12) 50%,
        transparent 100%
    );
}
[data-theme="dark"] .sk-campaign-card,
[data-theme="dark"] .sk-campaign-mcard,
[data-theme="dark"] .sk-article-card,
[data-theme="dark"] .sk-article-mcard,
[data-theme="dark"] .sk-article-mavatar,
[data-theme="dark"] .sk-book-card,
[data-theme="dark"] .sk-book-mcard,
[data-theme="dark"] .sk-event-card,
[data-theme="dark"] .sk-event-mcard,
[data-theme="dark"] .sk-news-card,
[data-theme="dark"] .sk-news-mcard,
[data-theme="dark"] .sk-news-mavatar,
[data-theme="dark"] .sk-gallery-card,
[data-theme="dark"] .sk-gallery-mcard { background: #161b27; }
[data-theme="dark"] .sk-ck-card,
[data-theme="dark"] .sk-ck-mcard  { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .sk-ck-icon-wrap { background: rgba(0,167,157,.1); }
[data-theme="dark"] .sk-ck-footer { border-top-color: rgba(0,167,157,.12); }
</style>
@endverbatim
