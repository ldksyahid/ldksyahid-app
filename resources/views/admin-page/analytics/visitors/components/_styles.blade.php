<style>
    .va-stat-card {
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        transition: transform .15s;
    }
    .va-stat-card:hover { transform: translateY(-2px); }
    .va-stat-card .va-value { font-size: 2rem; font-weight: 700; line-height: 1; }
    .va-stat-card .va-label { font-size: .8rem; color: #6c757d; margin-top: .4rem; }
    .va-stat-card .va-sublabel { font-size: .68rem; color: #adb5bd; margin-top: 2px; }

    .va-section-title { font-size: 1rem; font-weight: 600; color: #00a79d; margin-bottom: 0; }
    .va-chart-container { position: relative; height: 300px; }

    .va-table th { font-size: .78rem; color: #6c757d; font-weight: 600; text-transform: uppercase; }
    .va-table td { font-size: .875rem; vertical-align: middle; }
    .va-sort-th:hover { color: #00a79d !important; }
    .va-sort-th:hover .va-sort-arrow { color: #00a79d; }
    .va-sort-arrow { font-size: .75rem; color: #adb5bd; }
    .va-sort-arrow.active { color: #00a79d; font-weight: 700; }

    /* Date range bar */
    .va-range-bar { border-top:1px solid rgba(0,0,0,.06); border-bottom:1px solid rgba(0,0,0,.06); }
    #va-daterange { cursor:pointer; }
    #va-refresh { background:transparent; color:#00a79d; border:1px solid #00a79d; border-radius:6px; padding:2px 9px; line-height:1.5; cursor:pointer; }

    /* Search input */
    .va-search-wrap { position: relative; }
    .va-search-icon {
        position: absolute; left: 9px; top: 50%; transform: translateY(-50%);
        color: #adb5bd; font-size: .75rem; pointer-events: none; z-index: 1;
    }
    .va-search-input { padding-left: 28px; padding-right: 28px; min-width: 200px; }
    .va-search-clear {
        position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
        background: none; border: none; color: #adb5bd; padding: 0; line-height: 1; cursor: pointer;
    }
    .va-search-clear:hover { color: #495057; }

    /* Skeleton loading */
    .va-skeleton td div {
        height: 14px; border-radius: 4px;
        background: linear-gradient(90deg, #e9ecef 25%, #f8f9fa 50%, #e9ecef 75%);
        background-size: 200% 100%;
        animation: va-shimmer 1.2s infinite;
    }
    @keyframes va-shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

    /* Pagination */
    #va-tp-pagination .pagination { margin-bottom: 0; }
    #va-tp-pagination .page-link { font-size: .8rem; padding: .3rem .6rem; color: #00a79d; }
    #va-tp-pagination .page-item.active .page-link { background:#00a79d; border-color:#00a79d; color:#fff; }
    #va-tp-pagination .page-link:focus { box-shadow: 0 0 0 .15rem rgba(0,167,157,.25); }

    html.dark-mode .va-stat-card .va-label { color: #adb5bd; }
    html.dark-mode .va-stat-card .va-sublabel { color: #6c757d; }
    html.dark-mode .va-table th { color: #adb5bd; }
    html.dark-mode .va-skeleton td div {
        background: linear-gradient(90deg, #2c2f33 25%, #3a3e44 50%, #2c2f33 75%);
        background-size: 200% 100%;
    }
    html.dark-mode .va-range-bar { border-color:rgba(255,255,255,.06) !important; }
    html.dark-mode #va-daterange { background-color:#2b2f33; border-color:#3a3e44; color:#dee2e6; }
    html.dark-mode #va-daterange::placeholder { color:#6c757d; }
    html.dark-mode #va-refresh { color:#00a79d; border-color:#00a79d; }
    html.dark-mode .va-search-clear:hover { color: #dee2e6; }
    html.dark-mode #va-tp-pagination .page-link { background-color:#2b2f33; border-color:#3a3e44; color:#00a79d; }
    html.dark-mode #va-tp-pagination .page-item.active .page-link { background:#00a79d; border-color:#00a79d; color:#fff; }
    html.dark-mode #va-tp-pagination .page-item.disabled .page-link { background-color:#2b2f33; border-color:#3a3e44; color:#6c757d; }
    html.dark-mode #va-tp-search { background-color:#2b2f33; border-color:#3a3e44; color:#dee2e6; }
    html.dark-mode #va-tp-search::placeholder { color:#6c757d; }
    html.dark-mode #va-tp-search:focus { background-color:#2b2f33; border-color:#00a79d; color:#dee2e6; box-shadow:0 0 0 .15rem rgba(0,167,157,.25); }
</style>
