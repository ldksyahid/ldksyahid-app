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
