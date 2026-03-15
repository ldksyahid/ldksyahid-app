<style>
/* ================================================================
   DONATION STATUS PAGE VARIABLES
   ================================================================ */
:root {
    --ds-primary:     #00a79d;
    --ds-primary-lt:  #e0f7f5;
    --ds-dark:        #1a2332;
    --ds-gray:        #6b7280;
    --ds-gray-100:    #f8f9fa;
    --ds-gray-200:    #e9ecef;
    --ds-white:       #ffffff;
    --ds-radius:      14px;
    --ds-radius-lg:   20px;
    --ds-shadow:      0 4px 20px rgba(0,0,0,.07);
    --ds-transition:  all .25s cubic-bezier(.4,0,.2,1);

    /* Status colors */
    --ds-success:     #16a34a;
    --ds-success-bg:  #f0fdf4;
    --ds-success-lt:  #dcfce7;
    --ds-warning:     #d97706;
    --ds-warning-bg:  #fffbeb;
    --ds-warning-lt:  #fef3c7;
    --ds-danger:      #dc2626;
    --ds-danger-bg:   #fff5f5;
    --ds-danger-lt:   #fee2e2;
}

/* ── Page wrapper ── */
.ds-page { min-height: 100vh; position: relative; z-index: 1; }


/* ================================================================
   STATUS BANNER
   ================================================================ */
.ds-status-banner {
    border-radius: var(--ds-radius-lg);
    padding: 2rem 1.5rem;
    text-align: center;
    margin-bottom: 1.5rem;
    display: flex; flex-direction: column; align-items: center; gap: .75rem;
}
.ds-status-banner.paid    { background: var(--ds-success-bg); }
.ds-status-banner.pending { background: var(--ds-warning-bg); }
.ds-status-banner.failed  { background: var(--ds-danger-bg);  }

.ds-status-icon {
    width: 72px; height: 72px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem; flex-shrink: 0;
}
.ds-status-banner.paid    .ds-status-icon { background: var(--ds-success-lt); color: var(--ds-success); }
.ds-status-banner.pending .ds-status-icon { background: var(--ds-warning-lt); color: var(--ds-warning); }
.ds-status-banner.failed  .ds-status-icon { background: var(--ds-danger-lt);  color: var(--ds-danger);  }

.ds-status-title {
    font-size: 1.35rem; font-weight: 800; margin: 0;
}
.ds-status-banner.paid    .ds-status-title { color: var(--ds-success); }
.ds-status-banner.pending .ds-status-title { color: var(--ds-warning); }
.ds-status-banner.failed  .ds-status-title { color: var(--ds-danger);  }

.ds-status-sub {
    font-size: .88rem; color: var(--ds-gray); margin: 0;
}


/* ================================================================
   DETAIL CARD
   ================================================================ */
.ds-detail-card {
    background: var(--ds-white);
    border-radius: var(--ds-radius-lg);
    box-shadow: var(--ds-shadow);
    overflow: hidden;
    margin-bottom: 1.5rem;
}
.ds-detail-header {
    padding: 1.25rem 1.5rem .875rem;
    border-bottom: 2px solid var(--ds-gray-200);
}
.ds-detail-title {
    font-size: 1rem; font-weight: 800; color: var(--ds-dark); margin: 0;
    display: flex; align-items: center; gap: .5rem;
}
.ds-detail-title i { color: var(--ds-primary); }

.ds-detail-body { padding: .25rem 0; }
.ds-detail-row {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: 1rem; padding: .875rem 1.5rem;
}
.ds-detail-row:nth-child(even) { background: var(--ds-gray-100); }

.ds-detail-key {
    font-size: .82rem; color: var(--ds-gray); font-weight: 500;
    flex-shrink: 0; min-width: 120px;
}
.ds-detail-val {
    font-size: .9rem; font-weight: 700; color: var(--ds-dark);
    text-align: right; word-break: break-word;
}
.ds-detail-val.amount { color: var(--ds-primary); font-size: 1rem; }


/* ================================================================
   ACTION BUTTONS
   ================================================================ */
.ds-action-wrap {
    display: flex; flex-direction: column; gap: .75rem;
}
.ds-btn {
    display: flex; align-items: center; justify-content: center; gap: .5rem;
    padding: .875rem 1.5rem;
    font-size: .9rem; font-weight: 700; border-radius: 30px;
    text-decoration: none; border: none; cursor: pointer;
    transition: var(--ds-transition); width: 100%;
}
.ds-btn-primary {
    background: var(--ds-primary); color: #fff;
    box-shadow: 0 4px 14px rgba(0,167,157,.25);
}
.ds-btn-primary:hover { color: #fff; filter: brightness(.9); transform: translateY(-1px); }

.ds-btn-outline {
    background: var(--ds-white); color: var(--ds-primary);
    border: 2px solid var(--ds-primary);
}
.ds-btn-outline:hover { background: var(--ds-primary-lt); }

.ds-btn-gray {
    background: var(--ds-gray-100); color: var(--ds-dark);
    border: 2px solid var(--ds-gray-200);
}
.ds-btn-gray:hover { background: var(--ds-gray-200); }

.ds-btn-success {
    background: var(--ds-success); color: #fff;
    box-shadow: 0 4px 14px rgba(22,163,74,.2);
}
.ds-btn-success:hover { color: #fff; filter: brightness(.9); }


/* ================================================================
   RESPONSIVE
   ================================================================ */
@media (min-width: 576px) {
    .ds-action-wrap.two-col {
        flex-direction: row;
    }
    .ds-action-wrap.two-col .ds-btn { flex: 1; }
}
@media (max-width: 575.98px) {
    .ds-detail-key { min-width: 100px; }
    .ds-status-icon { width: 60px; height: 60px; font-size: 1.4rem; }
    .ds-status-title { font-size: 1.15rem; }
}

/* ── Dark Mode ──────────────────────────────────────────── */
/* Status banner */
[data-theme="dark"] .ds-status-banner.paid    { background: rgba(22,163,74,.12); }
[data-theme="dark"] .ds-status-banner.pending { background: rgba(217,119,6,.12); }
[data-theme="dark"] .ds-status-banner.failed  { background: rgba(220,38,38,.12); }
[data-theme="dark"] .ds-status-title  { color: #e2e8f0; }
[data-theme="dark"] .ds-status-sub    { color: #9ca3af; }
/* Detail card */
[data-theme="dark"] .ds-detail-card   { background: #1a1f2e; }
[data-theme="dark"] .ds-detail-header { border-bottom-color: rgba(0,167,157,.2); }
[data-theme="dark"] .ds-detail-title  { color: #e2e8f0; }
[data-theme="dark"] .ds-detail-row:nth-child(even) { background: #252b3b; }
[data-theme="dark"] .ds-detail-key    { color: #9ca3af; }
[data-theme="dark"] .ds-detail-val    { color: #e2e8f0; }
/* Buttons */
[data-theme="dark"] .ds-btn-outline { background: #1a1f2e; }
[data-theme="dark"] .ds-btn-gray    { background: #252b3b; border-color: rgba(255,255,255,.1); color: #e2e8f0; }
</style>
