<style>
/* ── Comment detail view — mirrors article _form-styles exactly ── */

/* Page title — exact copy from article _form-styles */
.page-title {
    font-size: 1.65rem !important;
    font-weight: 600 !important;
    text-align: center !important;
    color: #00a79d !important;
    margin: .75rem 0 1.5rem !important;
    position: relative;
    display: inline-block;
}
.page-title .highlighted-text {
    color: #008b84;
    font-weight: 700;
}
.page-title::after {
    content: '';
    display: block;
    height: 4px;
    width: 120px;
    margin: .35rem auto 0;
    border-radius: 3px;
    background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
}
.page-title small {
    color: #6c757d !important;
    font-size: .9rem !important;
    font-weight: 400 !important;
    display: block !important;
    margin-top: .4rem;
}

/* Section title — exact copy from article _form-styles */
.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #00a79d;
    padding-bottom: .5rem;
    border-bottom: 2px solid #e0f7f5;
}
html.dark-mode .section-title { color: #2dd4bf; border-bottom-color: rgba(45,212,191,.15); }

/* form-control-plaintext — exact copy from article _form-styles */
.form-control-plaintext {
    padding: .375rem 0;
    margin-bottom: 0;
    line-height: 1.5;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
    min-height: 38px;
    display: flex;
    align-items: center;
}

/* form-label fw-bold — exact copy from article _form-styles */
.form-label.fw-bold {
    color: #495057;
    font-weight: 600;
}
html.dark-mode .form-label.fw-bold { color: #9ca3af; }

/* Cards — exact copy from article _form-styles */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,.08);
}

/* Comment body text */
.cmtv-body-text {
    font-size: .92rem;
    line-height: 1.7;
    color: #334155;
    white-space: pre-wrap;
    word-break: break-word;
}
html.dark-mode .cmtv-body-text { color: #cbd5e1; }

/* Media */
.cmtv-media-wrap {
    border: 1px solid #e2e8f0;
    border-radius: .6rem;
    overflow: hidden;
    background: #f8fafc;
    display: inline-block;
}
html.dark-mode .cmtv-media-wrap { border-color: rgba(255,255,255,.1); background: #1e2535; }

.cmtv-media-img {
    display: block;
    max-width: 100%;
    max-height: 240px;
    object-fit: contain;
    cursor: zoom-in;
}
.cmtv-media-sm { max-height: 150px; max-width: 220px; }

/* Reaction pills */
.cmtv-rx-pill {
    display: inline-flex;
    align-items: center;
    gap: .25rem;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 999px;
    padding: .2rem .65rem;
    font-size: .85rem;
    cursor: default;
}
html.dark-mode .cmtv-rx-pill { background: #252b3b; border-color: rgba(255,255,255,.1); }
.cmtv-rx-count { font-weight: 700; font-size: .78rem; }

/* Reply rows */
.cmtv-reply-row { padding-top: .25rem; }

/* Level-2 replies indented section */
.cmtv-l2-wrap {
    border-left: 2px solid rgba(0,167,157,.25);
    padding-left: .75rem;
}
.cmtv-l2-row { padding: .4rem .5rem; border-radius: .4rem; }
.cmtv-l2-row:hover { background: rgba(0,0,0,.02); }
html.dark-mode .cmtv-l2-row:hover { background: rgba(255,255,255,.02); }
</style>
