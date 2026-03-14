<style>
/* ================================================================
   DETAIL PAGE VARIABLES
   ================================================================ */
:root {
    --cd-primary:     #00a79d;
    --cd-primary-dk:  #008a82;
    --cd-primary-lt:  #e0f7f5;
    --cd-dark:        #1a2332;
    --cd-gray:        #6b7280;
    --cd-gray-100:    #f8f9fa;
    --cd-gray-200:    #e9ecef;
    --cd-white:       #ffffff;
    --cd-radius:      14px;
    --cd-radius-lg:   20px;
    --cd-radius-xl:   24px;
    --cd-shadow:      0 4px 20px rgba(0,0,0,.07);
    --cd-shadow-lg:   0 12px 40px rgba(0,0,0,.12);
    --cd-transition:  all .3s cubic-bezier(.4,0,.2,1);
}

/* ================================================================
   DETAIL PAGE SECTION
   ================================================================ */
.cd-page { min-height: 100vh; position: relative; z-index: 1; }

/* ── Hero image ── */
.cd-hero-img-wrap {
    width: 100%; overflow: hidden;
    border-radius: var(--cd-radius-xl);
    box-shadow: var(--cd-shadow-lg);
    aspect-ratio: 16/9;
    max-height: 440px;
}
.cd-hero-img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
}

/* ── Info Panel ── */
.cd-info-panel {
    background: var(--cd-white);
    border-radius: var(--cd-radius-xl);
    padding: 1.75rem;
    box-shadow: var(--cd-shadow);
    display: flex;
    flex-direction: column;
    gap: 1.125rem;
    height: 100%;
}

.cd-cat-badge {
    display: inline-flex; align-items: center; gap: .35rem;
    background: var(--cd-primary-lt); color: var(--cd-primary);
    font-size: .75rem; font-weight: 700;
    padding: .28rem .8rem; border-radius: 20px;
    align-self: flex-start;
}

.cd-title {
    font-size: 1.35rem; font-weight: 800;
    color: var(--cd-dark); line-height: 1.3; margin: 0;
}

/* Org */
.cd-org-row {
    display: flex; align-items: center; gap: .625rem;
    padding: .625rem .875rem;
    background: var(--cd-gray-100); border-radius: var(--cd-radius);
}
.cd-org-logo {
    width: 32px; height: 32px;
    border-radius: 50%; object-fit: cover;
    flex-shrink: 0;
}
.cd-org-info { min-width: 0; }
.cd-org-label { font-size: .7rem; color: var(--cd-gray); display: block; }
.cd-org-name {
    font-size: .88rem; font-weight: 700; color: var(--cd-dark);
    text-decoration: none; display: block;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.cd-org-name:hover { color: var(--cd-primary); }

/* Stats row */
.cd-stats-top {
    display: flex; align-items: center; gap: .5rem;
    justify-content: space-between;
}
.cd-amount {
    font-size: 1.45rem; font-weight: 800; color: var(--cd-primary); line-height: 1.1;
}
.cd-donor-chip {
    display: flex; align-items: center; gap: .35rem;
    background: var(--cd-gray-100); color: var(--cd-gray);
    font-size: .78rem; font-weight: 600;
    padding: .3rem .75rem; border-radius: 20px;
    white-space: nowrap;
}
.cd-donor-chip i { color: var(--cd-primary); }

/* Progress */
.cd-progress-track {
    height: 10px; background: var(--cd-gray-200);
    border-radius: 10px; overflow: hidden;
}
.cd-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--cd-primary) 0%, #00d4c8 100%);
    border-radius: 10px;
    transition: width .8s ease;
}
.cd-progress-meta {
    display: flex; justify-content: space-between;
    font-size: .75rem; color: var(--cd-gray); margin-top: .375rem;
}
.cd-progress-pct { font-weight: 700; color: var(--cd-primary); }
.cd-progress-target { font-weight: 600; }

/* Deadline */
.cd-deadline-row {
    display: flex; align-items: center; gap: .5rem;
    font-size: .82rem; color: var(--cd-gray);
}
.cd-deadline-row i { color: var(--cd-primary); }
.cd-days-badge {
    background: var(--cd-primary-lt); color: var(--cd-primary);
    font-weight: 700; font-size: .8rem;
    padding: .2rem .65rem; border-radius: 20px;
}
.cd-days-badge.ended { background: #fee2e2; color: #b91c1c; }

/* Action buttons */
.cd-action-row { display: flex; flex-direction: column; gap: .625rem; margin-top: auto; }
.cd-btn-donate {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    background: var(--cd-primary); color: #fff;
    font-size: .95rem; font-weight: 700;
    padding: .85rem 1.5rem; border-radius: 30px;
    text-decoration: none; transition: var(--cd-transition);
    box-shadow: 0 4px 14px rgba(0,167,157,.3);
}
.cd-btn-donate:hover { color: #fff; filter: brightness(.9); transform: translateY(-1px); }

.cd-share-row {
    display: flex; gap: .5rem; align-items: center;
}
.cd-share-label { font-size: .78rem; color: var(--cd-gray); font-weight: 500; }
.cd-share-btn {
    flex: 1; display: flex; align-items: center; justify-content: center; gap: .4rem;
    font-size: .8rem; font-weight: 600;
    padding: .5rem .75rem; border-radius: 10px;
    border: 1.5px solid var(--cd-gray-200); background: var(--cd-white);
    color: var(--cd-dark); cursor: pointer; text-decoration: none;
    transition: var(--cd-transition);
}
.cd-share-copy:hover { background: var(--cd-primary-lt); color: var(--cd-primary); border-color: var(--cd-primary); }
.cd-share-wa:hover   { background: #dcfce7; color: #16a34a; border-color: #16a34a; }


/* ================================================================
   TABS
   ================================================================ */
.cd-tabs-wrap {
    background: var(--cd-white);
    border-radius: var(--cd-radius-xl);
    box-shadow: var(--cd-shadow);
    overflow: hidden;
    margin-top: 1.5rem;
}
.cd-tabs-nav {
    display: flex;
    border-bottom: 1px solid var(--cd-gray-200);
    padding: 0 1.75rem;
}
.cd-tab {
    position: relative;
    background: none; border: none;
    padding: 1rem 1.25rem;
    font-size: .88rem; font-weight: 600;
    color: var(--cd-gray); cursor: pointer;
    transition: color .2s;
    white-space: nowrap;
}
.cd-tab::after {
    content: '';
    position: absolute; bottom: -1px; left: 0; right: 0;
    height: 2px; background: var(--cd-primary);
    transform: scaleX(0); transition: transform .25s;
    border-radius: 2px;
}
.cd-tab.active { color: var(--cd-primary); }
.cd-tab.active::after { transform: scaleX(1); }
.cd-tab-badge {
    display: inline-flex; align-items: center; justify-content: center;
    background: var(--cd-primary-lt); color: var(--cd-primary);
    font-size: .7rem; font-weight: 700;
    min-width: 18px; height: 18px; border-radius: 20px;
    padding: 0 .4rem; margin-left: .35rem;
}

.cd-tab-pane { display: none; }
.cd-tab-pane.active { display: block; animation: cdFadeIn .25s ease; }
@keyframes cdFadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to   { opacity: 1; transform: translateY(0); }
}

.cd-tab-body { padding: 1.75rem; }

/* Story content */
.cd-story-content {
    font-size: .9rem; line-height: 1.75; color: var(--cd-dark);
    word-break: break-word;
}
.cd-story-content img { max-width: 100%; border-radius: 10px; margin: .75rem 0; }

/* Updates */
.cd-updates-content {
    font-size: .9rem; line-height: 1.75; color: var(--cd-dark);
}
.cd-no-update {
    text-align: center; padding: 2rem 1rem; color: var(--cd-gray);
}
.cd-no-update i { font-size: 2.5rem; color: var(--cd-gray-200); display: block; margin-bottom: .75rem; }

/* Donors */
.cd-donor-list { display: flex; flex-direction: column; gap: .75rem; }
.cd-donor-item {
    display: flex; align-items: center; gap: .875rem;
    padding: 1rem 1.125rem;
    background: var(--cd-gray-100); border-radius: var(--cd-radius);
}
.cd-donor-avatar {
    width: 44px; height: 44px;
    border-radius: 50%; overflow: hidden; flex-shrink: 0;
    background: var(--cd-primary-lt);
    display: flex; align-items: center; justify-content: center;
    color: var(--cd-primary); font-size: 1.2rem;
}
.cd-donor-avatar img { width: 100%; height: 100%; object-fit: cover; }
.cd-donor-info { flex: 1; min-width: 0; }
.cd-donor-name { font-size: .88rem; font-weight: 700; color: var(--cd-dark); margin: 0 0 .2rem; }
.cd-donor-amount { font-size: .82rem; font-weight: 600; color: var(--cd-primary); }
.cd-donor-msg { font-size: .78rem; color: var(--cd-gray); margin-top: .2rem; }
.cd-donor-time { font-size: .72rem; color: var(--cd-gray); flex-shrink: 0; }
.cd-no-donors {
    text-align: center; padding: 2rem 1rem; color: var(--cd-gray);
}
.cd-no-donors i { font-size: 2.5rem; color: var(--cd-gray-200); display: block; margin-bottom: .75rem; }


/* ================================================================
   MOBILE STICKY DONATE BUTTON
   ================================================================ */
.cd-mobile-footer {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--cd-white);
    padding: .875rem 1rem calc(.875rem + env(safe-area-inset-bottom, 0px));
    box-shadow: 0 -4px 20px rgba(0,0,0,.1);
    z-index: 100;
}
.cd-mobile-donate-btn {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    background: var(--cd-primary); color: #fff;
    font-size: .95rem; font-weight: 700;
    padding: .85rem; border-radius: 30px;
    text-decoration: none; width: 100%;
    box-shadow: 0 4px 14px rgba(0,167,157,.3);
}
.cd-mobile-donate-btn:hover { color: #fff; filter: brightness(.9); }


/* ================================================================
   BACK LINK
   ================================================================ */
.cd-back-link {
    display: inline-flex; align-items: center; gap: .5rem;
    color: var(--cd-gray); text-decoration: none;
    font-size: .85rem; font-weight: 600;
    padding: .5rem .875rem;
    background: var(--cd-gray-100); border-radius: 30px;
    transition: var(--cd-transition);
    margin-bottom: 1.5rem;
}
.cd-back-link:hover { background: var(--cd-primary-lt); color: var(--cd-primary); }


/* ================================================================
   MOBILE — bottom space for sticky button
   ================================================================ */
@media (max-width: 991.98px) {
    .cd-page-content { padding-bottom: 5rem; }
    .cd-hero-img-wrap { max-height: 260px; }
}
@media (max-width: 575.98px) {
    .cd-title { font-size: 1.15rem; }
    .cd-amount { font-size: 1.2rem; }
    .cd-tabs-nav { padding: 0 1rem; overflow-x: auto; scrollbar-width: none; }
    .cd-tabs-nav::-webkit-scrollbar { display: none; }
    .cd-tab-body { padding: 1.25rem 1rem; }
}
</style>
