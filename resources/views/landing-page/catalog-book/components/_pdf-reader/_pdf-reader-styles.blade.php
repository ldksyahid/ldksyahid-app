<style>
/* === VARIABLES === */
:root {
    --primary: #00bfa6;
    --primary-dark: #009b89;
    --primary-light: #e0f7f5;
    --secondary: #6c757d;
    --success: #28a745;
    --warning: #ffc107;
    --danger: #dc3545;
    --dark: #2c3e50;
    --light: #f8f9fa;
    --white: #ffffff;
    --bd-accent: #00bfa6;

    --radius: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;

    --shadow-elegant: 0 4px 24px rgba(0, 0, 0, 0.08);
    --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* === HEADER === */
.pr-header {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: #fff;
    border-radius: var(--radius-xl);
    padding: 1.75rem 2rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-elegant);
    position: relative;
    z-index: 1;
}

/* === COVER === */
.pr-cover { flex-shrink: 0; }

.pr-cover-img {
    width: 88px;
    height: 116px;
    object-fit: cover;
    border-radius: var(--radius);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.18);
    transition: var(--transition);
}
.pr-cover-img:hover {
    transform: scale(1.04);
    box-shadow: 0 18px 44px rgba(0, 0, 0, 0.25);
}

.pr-cover-placeholder {
    width: 88px;
    height: 116px;
    background: linear-gradient(135deg, var(--bd-accent) 0%, color-mix(in srgb, var(--bd-accent) 75%, black) 100%);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.8rem;
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.18);
}

/* === INFO === */
.pr-info { flex: 1; min-width: 0; }

.pr-cat-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    background: color-mix(in srgb, var(--bd-accent) 12%, white);
    color: var(--bd-accent);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.625rem;
}

.pr-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--dark);
    line-height: 1.25;
    margin-bottom: 0.375rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.pr-author {
    font-size: 0.9rem;
    color: var(--bd-accent);
    font-weight: 600;
    margin-bottom: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}
.pr-author-type {
    color: var(--secondary);
    font-weight: 400;
}

.pr-meta-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}
.pr-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8rem;
    color: var(--secondary);
    background: var(--light);
    padding: 0.3rem 0.75rem;
    border-radius: 20px;
}
.pr-meta-item i { color: var(--bd-accent); font-size: 0.8rem; }

/* === ACTIONS === */
.pr-actions {
    display: flex;
    flex-direction: column;
    gap: 0.625rem;
    flex-shrink: 0;
}

.pr-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    cursor: pointer;
    border: none;
    white-space: nowrap;
}

.pr-btn-back {
    background: var(--light);
    color: var(--dark);
}
.pr-btn-back:hover {
    background: color-mix(in srgb, var(--bd-accent) 10%, white);
    color: var(--bd-accent);
    transform: translateY(-1px);
}

.pr-btn-full {
    background: var(--bd-accent);
    color: #fff;
    box-shadow: 0 4px 14px color-mix(in srgb, var(--bd-accent) 35%, transparent);
}
.pr-btn-full:hover {
    color: #fff;
    filter: brightness(0.9);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px color-mix(in srgb, var(--bd-accent) 45%, transparent);
}

/* === FRAME === */
.pr-frame-wrap {
    background: #fff;
    border-radius: var(--radius-xl);
    box-shadow: 0 10px 48px rgba(0,0,0,.1), 0 2px 10px rgba(0,0,0,.05);
    border: 1px solid #e9ecef;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

/* Browser bar */
.pr-reader-bar {
    display: flex;
    align-items: center;
    gap: .75rem;
    padding: .7rem 1rem;
    background: #f4f6f8;
    border-bottom: 1px solid #e9ecef;
}

.pr-reader-dots { display: flex; gap: .38rem; flex-shrink: 0; }
.pr-rd { width: 12px; height: 12px; border-radius: 50%; }
.pr-rd-r { background: #ff5f57; }
.pr-rd-y { background: #ffbd2e; }
.pr-rd-g { background: #28c840; }

.pr-reader-url-pill {
    flex: 1;
    display: flex;
    align-items: center;
    gap: .4rem;
    background: #fff;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: .28rem .75rem;
    font-size: .78rem;
    color: #6c757d;
    box-shadow: inset 0 1px 3px rgba(0,0,0,.04);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pr-reader-url-pill i { font-size: .62rem; color: #28c840; flex-shrink: 0; }

.pr-reader-open {
    flex-shrink: 0;
    width: 28px;
    height: 28px;
    border-radius: 8px;
    border: 1.5px solid #e9ecef;
    background: #fff;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: .72rem;
    text-decoration: none;
    transition: var(--transition);
}
.pr-reader-open:hover {
    background: var(--bd-accent);
    color: #fff;
    border-color: var(--bd-accent);
}

/* iframe body */
.pr-reader-body { line-height: 0; }

.pr-frame {
    width: 100%;
    min-height: 720px;
    border: none;
    display: block;
    background: #fff;
}

/* Fullscreen */
.pr-frame-wrap.fullscreen {
    position: fixed;
    top: 0; left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
    border-radius: 0;
    margin: 0;
    border: none;
}
.pr-frame-wrap.fullscreen .pr-frame {
    min-height: 100vh;
    height: 100vh;
}

/* === CONTROLS === */
.pr-controls {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    background: #fff;
    border-radius: var(--radius-lg);
    padding: 1rem 1.5rem;
    margin-top: 1.25rem;
    box-shadow: var(--shadow-elegant);
    position: relative;
    z-index: 1;
    flex-wrap: wrap;
}

.pr-controls-left { display: flex; gap: 0.5rem; align-items: center; }

.pr-ctrl-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background: var(--light);
    color: var(--dark);
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition);
    position: relative;
    overflow: hidden;
}
.pr-ctrl-btn:hover {
    background: var(--bd-accent);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px color-mix(in srgb, var(--bd-accent) 30%, transparent);
}

.pr-controls-right { margin-left: auto; }

.pr-status {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.3rem 0.875rem;
    border-radius: 20px;
    background: color-mix(in srgb, var(--bd-accent) 12%, white);
    color: var(--bd-accent);
    transition: var(--transition);
}
.pr-status.status-loading {
    background: #fef3c7;
    color: #92400e;
}
.pr-status.status-success {
    background: #dcfce7;
    color: #15803d;
}
.pr-status.status-error {
    background: #fee2e2;
    color: #b91c1c;
}

/* === SWEETALERT TOAST — below navbar === */
.swal-bd-toast.swal2-toast {
    margin-top: 72px !important;
}

/* === RESPONSIVE === */
@media (max-width: 992px) {
    .pr-title { font-size: 1.3rem; }
    .pr-frame { min-height: 600px; }
}

@media (max-width: 768px) {
    .pr-header {
        flex-direction: column;
        text-align: center;
        padding: 1.5rem;
        gap: 1.25rem;
    }
    .pr-cat-badge { margin-left: auto; margin-right: auto; }
    .pr-meta-bar { justify-content: center; }
    .pr-author { justify-content: center; }
    .pr-title { white-space: normal; font-size: 1.2rem; }
    .pr-actions {
        width: 100%;
        flex-direction: row;
        justify-content: center;
    }
    .pr-btn { flex: 1; max-width: 160px; }
    .pr-frame { min-height: 500px; }
    .pr-controls { flex-direction: column; gap: 0.875rem; text-align: center; padding: 1rem; }
    .pr-controls-left { justify-content: center; }
    .pr-controls-right { margin-left: 0; }
}

@media (max-width: 576px) {
    .pr-cover-img, .pr-cover-placeholder { width: 72px; height: 94px; }
    .pr-frame { min-height: 400px; }
    .pr-btn { font-size: 0.8rem; padding: 0.55rem 1rem; }
}

/* Safe area for notched devices in fullscreen */
@supports(padding: max(0px)) {
    .pr-frame-wrap.fullscreen {
        padding-top: env(safe-area-inset-top);
        padding-bottom: env(safe-area-inset-bottom);
        padding-left: env(safe-area-inset-left);
        padding-right: env(safe-area-inset-right);
    }
}

/* ── Dark Mode ──────────────────────────────────────────── */
[data-theme="dark"] .pr-header   { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .pr-title    { color: #e2e8f0; }
[data-theme="dark"] .pr-author   { color: #9ca3af; }
[data-theme="dark"] .pr-bar      { background: #252b3b; border-color: rgba(0,167,157,.15); }
[data-theme="dark"] .pr-url-pill { background: #1e2535; border-color: rgba(0,167,157,.2); color: #9ca3af; }
[data-theme="dark"] .pr-ctrl-btn { background: #252b3b; color: #e2e8f0; }
[data-theme="dark"] .pr-controls { background: #1a1f2e; border-color: rgba(0,167,157,.2); }
[data-theme="dark"] .pr-frame-wrap { background: #0f1117; }
[data-theme="dark"] .pr-status.status-loading { background: #2d2a1e; color: #fbbf24; }
[data-theme="dark"] .pr-status.status-success { background: #1a2d1e; color: #4ade80; }
[data-theme="dark"] .pr-status.status-error   { background: #2d1a1a; color: #f87171; }
</style>
