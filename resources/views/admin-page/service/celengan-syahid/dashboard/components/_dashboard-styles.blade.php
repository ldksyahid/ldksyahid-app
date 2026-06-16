<style>
    .cs-page-title {
        font-size: 1.65rem;
        font-weight: 600;
        text-align: center;
        color: #00a79d;
        margin: .75rem 0 1.5rem;
        position: relative;
        display: inline-block;
    }
    .cs-page-title .highlighted-text {
        color: #008b84;
        font-weight: 700;
    }
    .cs-page-title::after {
        content: '';
        display: block;
        height: 4px;
        width: 120px;
        margin: .35rem auto 0;
        border-radius: 3px;
        background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
    }
    .cs-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #00a79d;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e0f7f5;
    }
    .cs-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }
    .cs-card:hover {
        box-shadow: 0 6px 20px rgba(0, 167, 157, 0.15);
    }
    .cs-chart-container {
        position: relative;
        min-height: 380px;
    }
    .cs-chart-container .js-plotly-plot {
        border-radius: 8px;
    }
    .cs-info-card {
        border-radius: 12px;
        border: 1px solid #e0f7f5;
        background: #fff;
        transition: all 0.3s ease;
    }
    .cs-info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 167, 157, 0.15);
        border-color: #00a79d;
    }
    .cs-info-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
        flex-shrink: 0;
    }
    .cs-loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.85);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        z-index: 5;
    }
    .cs-loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e0f7f5;
        border-top: 4px solid #00a79d;
        border-radius: 50%;
        animation: cs-spin 0.8s linear infinite;
    }
    @keyframes cs-spin {
        to { transform: rotate(360deg); }
    }
    .cs-error-msg {
        color: #dc3545;
        font-size: 0.9rem;
        text-align: center;
        padding: 2rem;
    }

    /* ── Campaign Progress Table ────────────────────────────────── */
    .cs-campaign-table { font-size: .875rem; }
    .cs-campaign-table thead th {
        font-weight: 600;
        color: #00a79d;
        border-bottom: 2px solid #e0f7f5;
        white-space: nowrap;
        padding: .6rem .75rem;
    }
    .cs-campaign-table tbody td { padding: .65rem .75rem; vertical-align: middle; }
    .cs-campaign-table tfoot td { border-top: 2px solid #e0f7f5; }
    .cs-campaign-name {
        font-weight: 600;
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .cs-category-badge {
        display: inline-block;
        font-size: .72rem;
        font-weight: 600;
        padding: .2em .65em;
        border-radius: 50px;
        background: #e0f7f5;
        color: #008b84;
        white-space: nowrap;
    }
    .cs-amount-collected { font-weight: 700; color: #00a79d; }
    .cs-amount-available { font-weight: 700; color: #198754; }
    .cs-progress-wrap { display: flex; align-items: center; gap: .5rem; }
    .cs-progress-bar-bg {
        flex: 1;
        height: 8px;
        border-radius: 4px;
        background: #e9ecef;
        overflow: hidden;
    }
    .cs-progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width .4s ease;
    }
    .cs-bar-full  { background: linear-gradient(90deg, #00a79d, #198754); }
    .cs-bar-good  { background: linear-gradient(90deg, #00c9bd, #00a79d); }
    .cs-bar-mid   { background: linear-gradient(90deg, #fbbf24, #f59e0b); }
    .cs-bar-low   { background: linear-gradient(90deg, #f87171, #ef4444); }
    .cs-pct-label { font-size: .75rem; font-weight: 700; color: #6c757d; white-space: nowrap; min-width: 38px; }
    .cs-expired-tag {
        display: inline-block;
        font-size: .65rem;
        font-weight: 700;
        padding: .1em .4em;
        border-radius: 4px;
        background: #dc3545;
        color: #fff;
        vertical-align: middle;
        margin-left: .2rem;
    }
    .cs-btn-finance {
        color: #fff;
        background-color: #00a79d;
        border-color: #00a79d;
        padding: .2rem .5rem;
    }
    .cs-btn-finance:hover { background-color: #008b84; border-color: #008b84; color: #fff; }
    .cs-btn-all {
        font-size: .8rem;
        font-weight: 600;
        color: #00a79d;
        border: 1px solid #00a79d;
        border-radius: 6px;
        padding: .25rem .75rem;
        text-decoration: none;
        transition: all .2s;
        white-space: nowrap;
    }
    .cs-btn-all:hover { background: #00a79d; color: #fff; text-decoration: none; }

    /* Dark Mode */
    html.dark-mode .cs-info-card {
        background: #2b2f33 !important;
        border-color: #373b3e !important;
        color: #e4e6eb;
    }
    html.dark-mode .cs-info-card .text-muted {
        color: #b0b3b8 !important;
    }
    html.dark-mode .cs-section-title {
        border-bottom-color: #373b3e;
    }
    html.dark-mode .cs-loading-overlay {
        background: rgba(26,29,33,0.85) !important;
    }
    html.dark-mode .cs-loading-spinner {
        border-color: #373b3e;
        border-top-color: #00a79d;
    }

    html.dark-mode .cs-campaign-table thead th { color: #2dd4bf; border-bottom-color: rgba(45,212,191,.15); }
    html.dark-mode .cs-campaign-table tbody tr:hover td { background-color: rgba(255,255,255,.04); }
    html.dark-mode .cs-campaign-table tfoot td { border-top-color: rgba(45,212,191,.15); }
    html.dark-mode .cs-campaign-name { color: #e5e7eb; }
    html.dark-mode .cs-category-badge { background: rgba(0,167,157,.15); color: #2dd4bf; }
    html.dark-mode .cs-amount-collected { color: #2dd4bf; }
    html.dark-mode .cs-amount-available { color: #4ade80; }
    html.dark-mode .cs-pct-label { color: #9ca3af; }
    html.dark-mode .cs-progress-bar-bg { background: rgba(255,255,255,.1); }
    html.dark-mode .cs-btn-finance { background-color: #00a79d; border-color: #00a79d; }
    html.dark-mode .cs-btn-finance:hover { background-color: #008b84; border-color: #008b84; }
    html.dark-mode .cs-btn-all { color: #2dd4bf; border-color: #2dd4bf; }
    html.dark-mode .cs-btn-all:hover { background: #008b84; border-color: #008b84; color: #fff; }
    html.dark-mode .text-muted { color: #9ca3af !important; }

    @media (max-width: 768px) {
        .cs-page-title { font-size: 1.35rem; }
        .cs-section-title { font-size: 1rem; }
        .cs-chart-container { min-height: 300px; }
        .cs-info-icon { width: 40px; height: 40px; font-size: 1rem; }
        .cs-info-card {
            min-height: 0;
        }
        .cs-info-card .fw-semibold {
            font-size: 0.75rem;
            word-break: break-word;
        }
        .cs-info-card .fw-bold {
            font-size: 0.7rem;
        }
    }
</style>
