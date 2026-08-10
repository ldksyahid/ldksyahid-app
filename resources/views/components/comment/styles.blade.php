@verbatim
<style>
/* ================================================================
   COMMENT SECTION  —  prefix: cmt-
   Dark mode via [data-theme="dark"]
   ================================================================ */

/* ── Wrapper ────────────────────────────────────────────────────── */
.cmt-section { margin: 2rem 0; font-family: inherit; }
.cmt-title {
    font-size: 1.2rem; font-weight: 700; color: #1e293b;
    margin-bottom: .4rem; display: flex; align-items: center; gap: .5rem;
}
.cmt-title i { color: #00a79d; }
.cmt-desc  { font-size: .875rem; color: #64748b; margin-bottom: 1.25rem; }
.cmt-divider { height: 1px; background: #e2e8f0; margin: 1.5rem 0; }

/* ── Avatar ─────────────────────────────────────────────────────── */
.cmt-avatar-img {
    width: 42px; height: 42px; border-radius: 50%;
    object-fit: cover; display: block;
}
.cmt-avatar-placeholder {
    width: 42px; height: 42px; border-radius: 50%;
    background: #00a79d; color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 1rem; flex-shrink: 0;
}

/* ── Main form ──────────────────────────────────────────────────── */
.cmt-form-wrap { display: flex; gap: 1rem; align-items: flex-start; }
.cmt-form-avatar { flex-shrink: 0; padding-top: .25rem; }
.cmt-form-body  { flex: 1; min-width: 0; }
.cmt-textarea {
    width: 100%; border: 1.5px solid #e2e8f0; border-radius: .75rem;
    padding: .75rem 1rem; font-size: .9rem; line-height: 1.6;
    resize: vertical; background: #f8fafc; color: #1e293b;
    transition: border-color .2s, box-shadow .2s, background .2s;
    min-height: 80px; font-family: inherit; box-sizing: border-box;
}
.cmt-textarea:focus {
    outline: none; border-color: #00a79d; background: #fff;
    box-shadow: 0 0 0 3px rgba(0,167,157,.1);
}
.cmt-form-footer {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: .5rem; flex-wrap: wrap; gap: .5rem;
}
.cmt-media-toolbar { display: flex; gap: .35rem; }
.cmt-form-controls  { display: flex; align-items: center; gap: .75rem; }
.cmt-char { font-size: .78rem; color: #94a3b8; }

/* ── Media buttons (icon style) ─────────────────────────────────── */
.cmt-media-btn {
    background: rgba(0,0,0,.05); border: none; border-radius: .45rem;
    height: 28px; min-width: 28px; padding: 0 .45rem;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: background .15s; color: #475569;
}
.cmt-media-btn:hover { background: rgba(0,167,157,.15); }
.cmt-media-btn .fa-image { font-size: .95rem; color: #64748b; }
.cmt-media-btn:hover .fa-image { color: #00a79d; }

/* GIF open button — single rounded icon */
.cmt-gif-open-btn { background: rgba(0,167,157,.12) !important; }
.cmt-gif-open-btn:hover { background: rgba(0,167,157,.22) !important; }

.cmt-gif-icon-wrap {
    display: inline-flex; align-items: center; justify-content: center; gap: .2rem;
}
.cmt-gif-icon-text {
    font-size: .68rem; font-weight: 900; letter-spacing: .4px;
    color: #00a79d; font-family: inherit; line-height: 1;
}
.cmt-stk-text { font-weight: 700; opacity: .8; }
.cmt-gif-sep { font-size: .65rem; color: #00a79d; opacity: .5; line-height: 1; }
[data-theme="dark"] .cmt-gif-open-btn { background: rgba(0,167,157,.18) !important; }
[data-theme="dark"] .cmt-gif-icon-text { color: #2dd4bf; }
[data-theme="dark"] .cmt-gif-sep { color: #2dd4bf; }

/* ── Media preview ──────────────────────────────────────────────── */
.cmt-media-preview-wrap {
    position: relative; display: inline-block; margin-top: .6rem;
    border-radius: .5rem; overflow: hidden;
    border: 1.5px solid #e2e8f0; background: #f1f5f9;
}
.cmt-media-thumb {
    display: block; max-width: 260px; max-height: 180px; object-fit: contain;
}
.cmt-media-remove {
    position: absolute; top: 4px; right: 4px;
    background: rgba(0,0,0,.55); color: #fff; border: none;
    border-radius: 50%; width: 22px; height: 22px;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; font-size: .75rem; transition: background .2s;
}
.cmt-media-remove:hover { background: rgba(220,38,38,.8); }

/* ── Submit button ──────────────────────────────────────────────── */
.cmt-btn-submit {
    background: #00a79d; color: #fff; border: none; border-radius: .5rem;
    padding: .45rem 1.1rem; font-size: .85rem; font-weight: 600;
    cursor: pointer; transition: background .2s, transform .1s;
    display: inline-flex; align-items: center; gap: .4rem; white-space: nowrap;
}
.cmt-btn-submit:hover:not(:disabled) { background: #008b82; transform: translateY(-1px); }
.cmt-btn-submit:active:not(:disabled) { transform: translateY(0); }
.cmt-btn-submit:disabled { opacity: .6; cursor: not-allowed; }

/* ── Login prompt ───────────────────────────────────────────────── */
.cmt-login-prompt {
    background: #f0fdf9; border: 1.5px dashed #00a79d; border-radius: .75rem;
    padding: 1rem 1.25rem; display: flex; align-items: center;
    gap: .75rem; font-size: .9rem; color: #475569;
}
.cmt-login-prompt p { margin: 0; }
.cmt-login-icon { color: #00a79d; font-size: 1.2rem; flex-shrink: 0; }
.cmt-login-link { color: #00a79d; font-weight: 600; text-decoration: none; }
.cmt-login-link:hover { text-decoration: underline; }

/* ── Comment list ───────────────────────────────────────────────── */
.cmt-list { display: flex; flex-direction: column; gap: .75rem; }
.cmt-loading,.cmt-empty {
    text-align: center; padding: 2.5rem 1rem; color: #94a3b8; font-size: .9rem;
}
.cmt-empty i { display: block; font-size: 2rem; margin-bottom: .5rem; color: #cbd5e1; }
.cmt-empty p { margin: 0; }

/* ── Comment item ───────────────────────────────────────────────── */
.cmt-item {
    display: flex; gap: .85rem; align-items: flex-start;
    animation: cmtFadeIn .3s ease both;
}
@keyframes cmtFadeIn {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}
.cmt-item-avatar { flex-shrink: 0; padding-top: .2rem; }
.cmt-item-body {
    flex: 1; min-width: 0; background: #fff; margin-top: 5px; margin-bottom: 5px;
    border-radius: .75rem; padding: .85rem 1rem; border: 1px solid #e2e8f0;
}
.cmt-item-header {
    display: flex; align-items: center;
    flex-wrap: wrap; gap: .4rem .75rem; margin-bottom: .4rem;
}
.cmt-item-name { font-weight: 600; font-size: .9rem; color: #1e293b; }
.cmt-item-time { font-size: .78rem; color: #94a3b8; }
.cmt-item-text {
    font-size: .9rem; line-height: 1.65; color: #334155;
    margin: 0; word-break: break-word; white-space: pre-wrap;
}

/* ── Attached media in comment ──────────────────────────────────── */
.cmt-item-media { margin-top: .6rem; }
.cmt-item-img {
    max-width: 100%; max-height: 320px; object-fit: contain;
    border-radius: .5rem; display: block; cursor: zoom-in;
    border: 1px solid #e2e8f0;
}

/* ── Action row ─────────────────────────────────────────────────── */
.cmt-item-actions {
    margin-top: .6rem; display: flex; align-items: center;
    flex-wrap: wrap; gap: .35rem;
}

/* ── Reply toggle button ────────────────────────────────────────── */
.cmt-reply-toggle {
    background: none; border: none; color: #00a79d; font-size: .8rem;
    font-weight: 600; cursor: pointer; padding: .25rem .55rem;
    border-radius: .375rem; transition: background .2s;
    display: inline-flex; align-items: center; gap: .35rem; font-family: inherit;
}
.cmt-reply-toggle:hover { background: rgba(0,167,157,.08); }

/* ── Reaction system ────────────────────────────────────────────── */
.cmt-reactions-row {
    display: flex; align-items: center; flex-wrap: wrap; gap: .3rem; margin-top: .5rem;
}

/* Each active reaction as a separate pill */
.cmt-rx-pill {
    background: #f1f5f9; border: 1px solid #e2e8f0; border-radius: 999px;
    padding: .2rem .6rem; font-size: .82rem; cursor: pointer;
    display: inline-flex; align-items: center; gap: .25rem; color: #475569;
    transition: all .15s; font-family: inherit; line-height: 1.4;
}
.cmt-rx-pill:hover { border-color: #00a79d; background: rgba(0,167,157,.06); color: #00a79d; }
.cmt-rx-pill.active {
    background: rgba(0,167,157,.1); border-color: #00a79d; color: #00a79d; font-weight: 600;
}
.cmt-rx-pill-emoji { font-size: .9rem; line-height: 1; }
.cmt-rx-pill-count { font-weight: 600; font-size: .78rem; }

/* "+" add reaction button */
.cmt-rx-wrap { position: relative; display: inline-flex; }
.cmt-rx-add-btn {
    background: none; border: 1px dashed #cbd5e1; border-radius: 999px;
    padding: .2rem .55rem; font-size: .82rem; cursor: pointer; color: #94a3b8;
    display: inline-flex; align-items: center; gap: .25rem;
    transition: all .15s; font-family: inherit;
}
.cmt-rx-add-btn:hover { border-color: #00a79d; color: #00a79d; }

/* Floating emoji picker */
.cmt-rx-picker {
    position: absolute; bottom: calc(100% + 6px); left: 0;
    background: #fff; border: 1px solid #e2e8f0; border-radius: .75rem;
    padding: .4rem .5rem; display: none; flex-direction: row; gap: .2rem;
    box-shadow: 0 8px 30px rgba(0,0,0,.15); z-index: 200; white-space: nowrap;
}
.cmt-rx-wrap.open .cmt-rx-picker { display: flex; }
.cmt-rx-pick-btn {
    background: none; border: 2px solid transparent; border-radius: .5rem;
    padding: .3rem; font-size: 1.3rem; cursor: pointer; line-height: 1;
    transition: transform .12s, border-color .12s, background .12s;
}
.cmt-rx-pick-btn:hover  { transform: scale(1.35); background: #f1f5f9; }
.cmt-rx-pick-btn.active { border-color: #00a79d; background: rgba(0,167,157,.08); }

/* ── Reply form ─────────────────────────────────────────────────── */
.cmt-reply-form { margin-top: .75rem; }
.cmt-reply-textarea { min-height: 60px; }
.cmt-reply-footer {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: .45rem; flex-wrap: wrap; gap: .4rem;
}
.cmt-reply-mpw {
    position: relative; display: inline-block; margin-top: .5rem;
    border-radius: .5rem; overflow: hidden;
    border: 1.5px solid #e2e8f0; background: #f1f5f9;
}
.cmt-reply-media-thumb {
    display: block; max-width: 200px; max-height: 140px; object-fit: contain;
}

/* ── Collapsible replies ────────────────────────────────────────── */
.cmt-replies-wrap { margin-top: .75rem; }

.cmt-replies-toggle-btn {
    background: none; border: none; color: #64748b; font-size: .82rem;
    cursor: pointer; padding: .3rem .6rem; border-radius: .375rem;
    display: inline-flex; align-items: center; gap: .4rem; font-family: inherit;
    transition: background .2s, color .2s;
}
.cmt-replies-toggle-btn:hover { background: #f1f5f9; color: #00a79d; }
.cmt-replies-toggle-btn.open  { color: #00a79d; }
.cmt-replies-toggle-btn .cmt-chevron {
    font-size: .7rem; transition: transform .2s;
}

/* Reply container (hidden by default) */
.cmt-replies {
    padding-left: .75rem; margin-top: .5rem;
    display: flex; flex-direction: column; gap: .5rem;
    border-left: 2px solid rgba(0,167,157,.25);
}
.cmt-reply-item .cmt-avatar-img,
.cmt-reply-item .cmt-avatar-placeholder { width: 32px; height: 32px; font-size: .8rem; }
.cmt-reply-item .cmt-item-body { background: #f8fafc; }

/* Level-2 replies */
.cmt-replies .cmt-replies { padding-left: .5rem; border-left-color: rgba(0,167,157,.12); }
.cmt-replies .cmt-replies .cmt-item-body { background: #f1f5f9; }

/* ── GIF Picker Modal ───────────────────────────────────────────── */
.cmt-gif-modal {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: flex-end; justify-content: center;
}
.cmt-gif-backdrop {
    position: absolute; inset: 0; background: rgba(0,0,0,.5);
    backdrop-filter: blur(2px);
}
.cmt-gif-dialog {
    position: relative; z-index: 1; background: #fff;
    width: min(520px, 100vw); height: min(580px, 90vh);
    border-radius: 1rem 1rem 0 0; display: flex; flex-direction: column;
    overflow: hidden; box-shadow: 0 -4px 40px rgba(0,0,0,.2);
}
/* Desktop: centered modal (fixed to viewport, doesn't follow scroll) */
@media (min-width: 576px) {
    .cmt-gif-modal  { align-items: center; justify-content: center; }
    .cmt-gif-dialog {
        position: relative; z-index: 1;
        width: min(720px, calc(100vw - 40px));
        height: min(580px, 85vh);
        border-radius: 1rem;
        box-shadow: 0 8px 40px rgba(0,0,0,.3);
    }
}

/* Header with tabs */
.cmt-gif-header {
    display: flex; align-items: center; padding: .65rem .75rem;
    border-bottom: 1px solid #e2e8f0; flex-shrink: 0; gap: .5rem;
}
.cmt-gif-tabs { display: flex; gap: .25rem; flex: 1; }
.cmt-gif-tab {
    background: none; border: none; padding: .35rem .9rem; font-size: .85rem;
    font-weight: 600; border-radius: .375rem; cursor: pointer;
    color: #64748b; font-family: inherit; transition: background .15s, color .15s;
}
.cmt-gif-tab.active { background: rgba(0,167,157,.12); color: #00a79d; }
.cmt-gif-tab:hover:not(.active) { background: #f1f5f9; }
.cmt-gif-close {
    background: none; border: none; color: #94a3b8; cursor: pointer;
    font-size: 1rem; width: 30px; height: 30px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s;
}
.cmt-gif-close:hover { background: #fee2e2; color: #ef4444; }

/* Search bar */
.cmt-gif-search-wrap {
    display: flex; align-items: center; gap: .5rem;
    padding: .6rem .75rem; border-bottom: 1px solid #e2e8f0; flex-shrink: 0;
}
.cmt-gif-search-icon { color: #94a3b8; font-size: .85rem; flex-shrink: 0; }
.cmt-gif-input {
    flex: 1; border: none; outline: none; font-size: .9rem;
    background: transparent; color: #1e293b; font-family: inherit;
}
.cmt-gif-clear {
    background: none; border: none; color: #94a3b8; cursor: pointer;
    font-size: .85rem; padding: 0; line-height: 1;
}
.cmt-gif-clear:hover { color: #ef4444; }

/* Category chips */
.cmt-gif-chips {
    display: flex; gap: .35rem; padding: .5rem .75rem; overflow-x: auto;
    flex-shrink: 0; scrollbar-width: none; -ms-overflow-style: none;
}
.cmt-gif-chips::-webkit-scrollbar { display: none; }
.cmt-gif-chip {
    background: #f1f5f9; border: none; border-radius: 999px;
    padding: .25rem .75rem; font-size: .78rem; white-space: nowrap;
    cursor: pointer; font-family: inherit; color: #475569;
    transition: background .15s, color .15s;
}
.cmt-gif-chip.active { background: #00a79d; color: #fff; }
.cmt-gif-chip:hover:not(.active) { background: #e2e8f0; }

/* GIF grid — uniform cells, no stacking */
.cmt-gif-grid {
    flex: 1; overflow-y: auto; padding: .5rem .75rem;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-auto-rows: 90px;   /* fixed row height = uniform cells */
    gap: .35rem;
    align-content: start;
}
.cmt-gif-item {
    border-radius: .4rem; overflow: hidden; cursor: pointer;
    background: #f1f5f9; border: 2px solid transparent;
    transition: transform .15s, box-shadow .15s;
    /* No aspect-ratio — height controlled by grid-auto-rows */
}
.cmt-gif-item img {
    width: 100%; height: 100%;
    object-fit: cover;   /* crop to fill the cell evenly */
    display: block;
}
.cmt-gif-item:hover {
    transform: scale(1.04); box-shadow: 0 4px 16px rgba(0,0,0,.2);
    border-color: #00a79d;
}
.cmt-gif-item:hover {
    transform: scale(1.04); box-shadow: 0 4px 16px rgba(0,0,0,.18);
    border-color: #00a79d;
}
.cmt-gif-hint,.cmt-gif-loading {
    grid-column: 1/-1; text-align: center; padding: 2rem; color: #94a3b8;
}
.cmt-gif-hint i { font-size: 2rem; display: block; margin-bottom: .5rem; color: #cbd5e1; }
.cmt-gif-hint p { margin: .25rem 0 0; }

/* Footer */
.cmt-gif-footer {
    padding: .4rem .75rem; border-top: 1px solid #e2e8f0;
    font-size: .72rem; color: #94a3b8; text-align: right; flex-shrink: 0;
    display: flex; align-items: center; justify-content: flex-end; gap: .35rem;
}
.cmt-giphy-logo { vertical-align: middle; opacity: .7; }

/* ── Dark mode ──────────────────────────────────────────────────── */
[data-theme="dark"] .cmt-title       { color: #e2e8f0; }
[data-theme="dark"] .cmt-desc        { color: #9ca3af; }
[data-theme="dark"] .cmt-divider     { background: rgba(255,255,255,.08); }
[data-theme="dark"] .cmt-textarea    { background: #1e2535; border-color: rgba(255,255,255,.1); color: #e2e8f0; }
[data-theme="dark"] .cmt-textarea::placeholder { color: #6b7280; }
[data-theme="dark"] .cmt-textarea:focus { border-color: #00a79d; background: #252b3b; }
[data-theme="dark"] .cmt-char        { color: #6b7280; }
[data-theme="dark"] .cmt-media-btn        { background: rgba(255,255,255,.07); }
[data-theme="dark"] .cmt-media-btn:hover  { background: rgba(0,167,157,.2); }
[data-theme="dark"] .cmt-media-btn .fa-image { color: #9ca3af; }
[data-theme="dark"] .cmt-media-preview-wrap { border-color: rgba(255,255,255,.1); background: #1e2535; }
[data-theme="dark"] .cmt-login-prompt { background: rgba(0,167,157,.06); border-color: rgba(0,167,157,.3); color: #9ca3af; }
[data-theme="dark"] .cmt-item-body   { background: #1e2535; border-color: rgba(255,255,255,.07); }
[data-theme="dark"] .cmt-reply-item .cmt-item-body { background: #252b3b; }
[data-theme="dark"] .cmt-replies .cmt-replies .cmt-item-body { background: #1a1f2e; }
[data-theme="dark"] .cmt-item-name   { color: #e2e8f0; }
[data-theme="dark"] .cmt-item-time   { color: #6b7280; }
[data-theme="dark"] .cmt-item-text   { color: #cbd5e1; }
[data-theme="dark"] .cmt-item-img    { border-color: rgba(255,255,255,.1); }
[data-theme="dark"] .cmt-empty,
[data-theme="dark"] .cmt-loading     { color: #6b7280; }
[data-theme="dark"] .cmt-replies     { border-left-color: rgba(0,167,157,.2); }
[data-theme="dark"] .cmt-replies .cmt-replies { border-left-color: rgba(0,167,157,.1); }
[data-theme="dark"] .cmt-avatar-placeholder { background: #00897b; }
[data-theme="dark"] .cmt-rx-pill        { background: #252b3b; border-color: rgba(255,255,255,.1); color: #9ca3af; }
[data-theme="dark"] .cmt-rx-pill:hover  { border-color: #00a79d; background: rgba(0,167,157,.1); color: #00a79d; }
[data-theme="dark"] .cmt-rx-pill.active { background: rgba(0,167,157,.15); border-color: #00a79d; color: #2dd4bf; }
[data-theme="dark"] .cmt-rx-add-btn     { border-color: rgba(255,255,255,.15); color: #6b7280; }
[data-theme="dark"] .cmt-rx-add-btn:hover { border-color: #00a79d; color: #00a79d; }
[data-theme="dark"] .cmt-rx-picker      { background: #252b3b; border-color: rgba(255,255,255,.1); }
[data-theme="dark"] .cmt-rx-pick-btn:hover  { background: #1e2535; }
[data-theme="dark"] .cmt-rx-pick-btn.active { border-color: #00a79d; background: rgba(0,167,157,.12); }
[data-theme="dark"] .cmt-replies-toggle-btn:hover { background: rgba(255,255,255,.06); }
[data-theme="dark"] .cmt-gif-dialog  { background: #1e2535; }
[data-theme="dark"] .cmt-gif-header,
[data-theme="dark"] .cmt-gif-search-wrap,
[data-theme="dark"] .cmt-gif-footer  { border-color: rgba(255,255,255,.08); }
[data-theme="dark"] .cmt-gif-input   { color: #e2e8f0; }
[data-theme="dark"] .cmt-gif-chip    { background: #252b3b; color: #9ca3af; }
[data-theme="dark"] .cmt-gif-chip:hover:not(.active) { background: #1e2535; }
[data-theme="dark"] .cmt-gif-item    { background: #252b3b; }
[data-theme="dark"] .cmt-gif-hint,
[data-theme="dark"] .cmt-gif-loading { color: #6b7280; }

/* ── Upload loading indicator ───────────────────────────────────── */
.cmt-media-preview-wrap.cmt-media-loading,
.cmt-reply-mpw.cmt-media-loading {
    min-width: 90px; min-height: 70px;
    display: inline-block !important;
}
.cmt-media-loading::after {
    content: ''; position: absolute;
    top: 50%; left: 50%;
    margin-top: -13px; margin-left: -13px;
    width: 26px; height: 26px;
    border: 3px solid rgba(0,167,157,.2);
    border-top-color: #00a79d;
    border-radius: 50%;
    animation: cmtSpinUpload .7s linear infinite;
}
@keyframes cmtSpinUpload { to { transform: rotate(360deg); } }
[data-theme="dark"] .cmt-media-loading::after {
    border-color: rgba(45,212,191,.15); border-top-color: #2dd4bf;
}

/* ── Owner action buttons (edit / delete) ───────────────────────── */
.cmt-owner-actions {
    display: inline-flex; align-items: center; gap: .15rem; margin-left: auto;
}
.cmt-edit-btn, .cmt-delete-btn {
    background: none; border: none; border-radius: .375rem;
    padding: .2rem .4rem; font-size: .72rem; cursor: pointer;
    display: inline-flex; align-items: center; justify-content: center;
    transition: background .15s, color .15s; font-family: inherit;
    color: #94a3b8; line-height: 1;
}
.cmt-edit-btn:hover   { background: rgba(0,167,157,.1); color: #00a79d; }
.cmt-delete-btn:hover { background: rgba(239,68,68,.08); color: #ef4444; }
[data-theme="dark"] .cmt-edit-btn   { color: #6b7280; }
[data-theme="dark"] .cmt-delete-btn { color: #6b7280; }
[data-theme="dark"] .cmt-edit-btn:hover   { background: rgba(0,167,157,.15); color: #2dd4bf; }
[data-theme="dark"] .cmt-delete-btn:hover { background: rgba(239,68,68,.1);  color: #f87171; }

/* ── Inline edit form ────────────────────────────────────────────── */
.cmt-edit-form { margin-top: .65rem; }
.cmt-edit-textarea { min-height: 60px; }
.cmt-edit-footer {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: .45rem; flex-wrap: wrap; gap: .4rem;
}
.cmt-edit-mpw {
    position: relative; display: inline-block; margin-top: .5rem;
    border-radius: .5rem; overflow: hidden;
    border: 1.5px solid #e2e8f0; background: #f1f5f9;
}
[data-theme="dark"] .cmt-edit-mpw { border-color: rgba(255,255,255,.1); background: #1e2535; }
.cmt-btn-save-edit {
    background: #00a79d; color: #fff; border: none; border-radius: .5rem;
    padding: .35rem .85rem; font-size: .82rem; font-weight: 600;
    cursor: pointer; display: inline-flex; align-items: center; gap: .35rem;
    transition: background .2s; font-family: inherit;
}
.cmt-btn-save-edit:hover:not(:disabled) { background: #008b82; }
.cmt-btn-save-edit:disabled { opacity: .6; cursor: not-allowed; }
.cmt-btn-cancel-edit {
    background: none; border: 1px solid #cbd5e1; border-radius: .5rem;
    color: #64748b; padding: .35rem .75rem; font-size: .82rem;
    cursor: pointer; font-family: inherit; transition: background .15s;
}
.cmt-btn-cancel-edit:hover { background: #f1f5f9; }
[data-theme="dark"] .cmt-btn-cancel-edit { border-color: rgba(255,255,255,.15); color: #9ca3af; }
[data-theme="dark"] .cmt-btn-cancel-edit:hover { background: rgba(255,255,255,.05); }

/* ── Mobile ─────────────────────────────────────────────────────── */
@media (max-width: 575.98px) {
    .cmt-form-avatar,.cmt-item-avatar { display: none; }
    .cmt-textarea   { font-size: .875rem; border-radius: .5rem; }
    .cmt-item-body  { border-radius: .5rem; padding: .75rem; }
    .cmt-btn-submit { padding: .4rem .8rem; font-size: .82rem; }
    .cmt-replies    { padding-left: .5rem; }
    .cmt-gif-grid   { grid-template-columns: repeat(2,1fr); grid-auto-rows: 110px; }
    .cmt-rx-picker  { left: auto; right: 0; }
}
</style>
@endverbatim
