<style>
/* ===== PAGE TITLE ===== */
.page-title {
    font-size: 1.65rem;
    font-weight: 600;
    text-align: center;
    color: #00a79d;
    margin: .75rem 0 1.5rem;
    position: relative;
    display: inline-block;
}
.page-title .highlighted-text { color: #008b84; font-weight: 700; }
.page-title small { font-size: .75rem; color: #6c757d; font-weight: 400; }
.page-title::after {
    content: '';
    display: block;
    height: 4px;
    width: 120px;
    margin: .35rem auto 0;
    border-radius: 3px;
    background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
}

/* ===== SECTION TITLE ===== */
.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #00a79d;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e0f7f5;
    margin-bottom: 1.25rem;
}

/* ===== BUTTONS ===== */
.btn-custom-primary {
    color: #fff;
    background-color: #00a79d;
    border: 1px solid #00a79d;
    transition: all 0.3s ease;
}
.btn-custom-primary:hover {
    background-color: #008b84;
    border-color: #008b84;
    color: #fff;
}
.btn-custom-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
}

/* ===== CARD ===== */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

/* ===== FORM CONTROLS ===== */
.form-control:focus, .form-select:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
}
.form-text { font-size: 0.8rem; color: #6c757d; }
.invalid-feedback { font-size: 0.85rem; }

/* ===== NUMBER INPUT SPIN BUTTONS ===== */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] { -moz-appearance: textfield; }

/* ===== VIEW MODE — plaintext display ===== */
.form-control-plaintext {
    padding: 0.375rem 0;
    margin-bottom: 0;
    line-height: 1.5;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
    min-height: 38px;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}
.form-label.fw-bold { color: #495057; font-weight: 600; }

/* ===== STAT BOX ===== */
.stat-box {
    text-align: center;
    padding: 1.25rem;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
}
.stat-box .stat-num { font-size: 2rem; font-weight: 800; color: #00a79d; }
.stat-box .stat-lbl { font-size: .75rem; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; }

/* ===== STATUS BADGE ===== */
.status-badge-lg { font-size: .9rem; padding: .45rem 1rem; border-radius: 50px; }

/* ===== FIELD PILLS ===== */
.field-pill {
    display: inline-flex; align-items: center; gap: .35rem;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 20px; padding: .25rem .75rem;
    font-size: .8rem; color: #166534; margin: .2rem;
}
.field-pill.system { background: #fef3c7; border-color: #fde68a; color: #92400e; }

/* ===== GOOGLE DRIVE LINK ===== */
.gdrive-link {
    display: flex; align-items: center; gap: .75rem;
    padding: .75rem 1rem; background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 8px; text-decoration: none; color: #166534;
    transition: all .2s; margin-bottom: .5rem;
}
.gdrive-link:hover { background: #dcfce7; color: #166534; text-decoration: none; }
.gdrive-link .gdrive-icon { font-size: 1.2rem; flex-shrink: 0; }
.gdrive-link .gdrive-text { flex: 1; }
.gdrive-link .gdrive-text strong { display: block; font-size: .875rem; font-weight: 600; }
.gdrive-link .gdrive-text small { font-size: .75rem; color: #6b7280; }
.gdrive-link .gdrive-ext { font-size: .7rem; opacity: .5; flex-shrink: 0; }

/* ===== COPY URL BUTTON ===== */
.copy-url-btn {
    background: none; border: 1px solid #d1d5db; border-radius: 6px;
    padding: .15rem .5rem; font-size: .75rem; color: #6b7280;
    cursor: pointer; transition: all .15s; line-height: 1.4;
    vertical-align: middle;
}
.copy-url-btn:hover { background: #00a79d; border-color: #00a79d; color: #fff; }
.gdrive-link-disabled { opacity: .55; pointer-events: none; cursor: default; }
.gdrive-link-disabled .gdrive-ext { color: #6b7280; }

/* ===== DARK MODE — form-specific components only ===== */
html.dark-mode .form-label.fw-bold { color: #c8cdd3; }
html.dark-mode .stat-box { background: #1a2d1e; border-color: #2d4a30; }
html.dark-mode .stat-box .stat-num { color: #2dd4bf; }
html.dark-mode .stat-box .stat-lbl { color: #9ca3af; }
html.dark-mode .field-pill { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .field-pill.system { background: #2d2510; border-color: #4a3a1a; color: #fbbf24; }
html.dark-mode .gdrive-link { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .gdrive-link:hover { background: #1f3524; color: #86efac; }
html.dark-mode .gdrive-link .gdrive-text small { color: #9ca3af; }
html.dark-mode .copy-url-btn { border-color: #374151; color: #9ca3af; }
html.dark-mode .copy-url-btn:hover { background: #00a79d; border-color: #00a79d; color: #fff; }
html.dark-mode .gdrive-info-alert { background: #0f2233; border-color: #1e4060; color: #7ec8e3; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .page-title { font-size: 1.35rem; }
    .card-body { padding: 1rem; }
    .section-title { font-size: 1rem; }
    .form-label { font-size: 0.9rem; }
    .form-text { font-size: 0.75rem; }
    .d-flex.justify-content-end.gap-2 { flex-direction: column; }
    .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
}
</style>
