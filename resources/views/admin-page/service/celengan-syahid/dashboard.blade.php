@extends('admin-page.template.body')

@section('styles')
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
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="cs-page-title">
                <i class="fa fa-donate me-2"></i>
                <span>Celengan Syahid</span>
                <span class="highlighted-text ms-1">Analytics Dashboard</span>
            </h1>

            <!-- Info Cards -->
            <div class="col-md-12 mb-4">
                <div class="row g-3">
                    <div class="col-6 col-md-4">
                        <div class="cs-info-card p-3 d-flex align-items-center gap-3">
                            <div class="cs-info-icon" style="background: linear-gradient(135deg, #00a79d, #008b84);">
                                <i class="fa fa-chart-bar"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-muted" style="font-size: 0.8rem;">Chart 1</div>
                                <div class="fw-semibold" style="color: #00a79d;">Donation Class</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="cs-info-card p-3 d-flex align-items-center gap-3">
                            <div class="cs-info-icon" style="background: linear-gradient(135deg, #008b84, #006b63);">
                                <i class="fa fa-chart-pie"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-muted" style="font-size: 0.8rem;">Chart 2</div>
                                <div class="fw-semibold" style="color: #008b84;">Age Category</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="cs-info-card p-3 d-flex align-items-center gap-3">
                            <div class="cs-info-icon" style="background: linear-gradient(135deg, #00c9bd, #00a79d);">
                                <i class="fa fa-chart-area"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-muted" style="font-size: 0.8rem;">Chart 3</div>
                                <div class="fw-semibold" style="color: #006b63;">Age × Donation</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 1: Bar + Pie -->
            <div class="col-md-12 mb-4">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="card cs-card h-100">
                            <div class="card-body">
                                <h5 class="cs-section-title mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>Donation Class Distribution
                                </h5>
                                <div class="cs-chart-container position-relative">
                                    <div class="cs-loading-overlay" id="barLoading">
                                        <div class="cs-loading-spinner"></div>
                                    </div>
                                    <div id="bar-plot"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="card cs-card h-100">
                            <div class="card-body">
                                <h5 class="cs-section-title mb-3">
                                    <i class="fas fa-chart-pie me-2"></i>Donors by Age Category
                                </h5>
                                <div class="cs-chart-container position-relative">
                                    <div class="cs-loading-overlay" id="pieLoading">
                                        <div class="cs-loading-spinner"></div>
                                    </div>
                                    <div id="age-pie-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Row 2: Grouped Bar -->
            <div class="col-md-12 mb-4">
                <div class="card cs-card">
                    <div class="card-body">
                        <h5 class="cs-section-title mb-3">
                            <i class="fas fa-chart-area me-2"></i>Donor Counts by Age & Donation Category
                        </h5>
                        <div class="cs-chart-container position-relative">
                            <div class="cs-loading-overlay" id="bar2Loading">
                                <div class="cs-loading-spinner"></div>
                            </div>
                            <div id="bar-plot-2"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script>
$(document).ready(function() {
    var tealPalette = ['#00a79d', '#00c9bd', '#008b84', '#33b8b0', '#006b63'];
    var plotConfig = { responsive: true, displayModeBar: false };

    // Cache data for re-render on dark mode toggle
    var cachedData = { bar1: null, pie: null, bar2: null };

    function isDark() {
        return document.documentElement.classList.contains('dark-mode');
    }
    function chartColors() {
        return isDark()
            ? { font: '#e4e6eb', grid: '#373b3e', hover_bg: '#2b2f33', hover_font: '#e4e6eb' }
            : { font: '#495057', grid: '#e0f7f5', hover_bg: '#fff', hover_font: '#333' };
    }

    function hideLoading(id) {
        $('#' + id).fadeOut(300);
    }

    function showError(containerId, loadingId) {
        hideLoading(loadingId);
        $('#' + containerId).html(
            '<div class="cs-error-msg"><i class="fa fa-exclamation-triangle me-2"></i>Failed to load chart data.</div>'
        );
    }

    function renderBar1(data) {
        var c = chartColors();
        var classCounts = data.class_counts;
        var categories = [
            'Low (0 - 25k)', 'Moderately Low (26k - 50k)',
            'Moderate (51k - 100k)', 'Moderately High (101k - 250k)', 'High (> 251k)'
        ];
        var counts = categories.map((_, i) => classCounts[i]);
        Plotly.react('bar-plot', [{
            x: categories, y: counts, type: 'bar',
            marker: { color: tealPalette, line: { color: '#fff', width: 1 } },
            text: counts.map(String), textposition: 'outside',
            hoverinfo: 'x+y',
            hoverlabel: { bgcolor: c.hover_bg, bordercolor: '#00a79d', font: { color: c.hover_font } }
        }], {
            title: { text: '' },
            xaxis: { title: 'Donation Category', tickangle: -15, color: c.font },
            yaxis: { title: 'Donor Count', gridcolor: c.grid, color: c.font },
            plot_bgcolor: 'rgba(0,0,0,0)', paper_bgcolor: 'rgba(0,0,0,0)',
            font: { family: 'inherit', color: c.font },
            margin: { t: 20, b: 120, l: 50, r: 30 }
        }, plotConfig);
    }

    function renderPie(data) {
        var c = chartColors();
        var categoryOrder = [
            'Children (5-11 years old)', 'Teenagers (12-25 years old)',
            'Adults (26-45 years old)', 'Elderly (46-65 years old)', 'Other Ages'
        ];
        var ageLabels = Object.keys(data);
        var sorted = categoryOrder.reduce((acc, label) => {
            var idx = ageLabels.indexOf(label);
            if (idx !== -1) { acc.labels.push(label); acc.values.push(Object.values(data)[idx]); }
            return acc;
        }, { labels: [], values: [] });
        Plotly.react('age-pie-chart', [{
            labels: sorted.labels, values: sorted.values,
            type: 'pie', hole: 0.45,
            marker: { colors: tealPalette, line: { color: '#fff', width: 2 } },
            textinfo: 'percent+label', textfont: { size: 11, color: c.font },
            hoverinfo: 'label+value+percent',
            hoverlabel: { bgcolor: c.hover_bg, bordercolor: '#00a79d', font: { color: c.hover_font } }
        }], {
            title: { text: '' }, showlegend: true,
            legend: { orientation: 'h', y: -0.15, font: { size: 11, color: c.font } },
            plot_bgcolor: 'rgba(0,0,0,0)', paper_bgcolor: 'rgba(0,0,0,0)',
            font: { family: 'inherit', color: c.font },
            margin: { t: 20, b: 60, l: 20, r: 20 }
        }, plotConfig);
    }

    function renderBar2(data) {
        var c = chartColors();
        var order = [
            'Low (0 - 25k)', 'Moderately Low (26k - 50k)',
            'Moderate (51k - 100k)', 'Moderately High (101k - 250k)', 'High (> 251k)'
        ];
        var categoryOrder = [
            'Children (5-11 years old)', 'Teenagers (12-25 years old)',
            'Adults (26-45 years old)', 'Elderly (46-65 years old)', 'Other Ages'
        ];
        var dataDict = {};
        for (var i = 0; i < data.age_category.length; i++) {
            var dc = data.donation_category[i];
            if (!dataDict[dc]) dataDict[dc] = { x: [], y: [], type: 'bar', name: dc, text: [], textposition: 'auto' };
            dataDict[dc].x.push(data.age_category[i]);
            dataDict[dc].y.push(data.donor_count[i]);
            dataDict[dc].text.push(data.donor_count[i]);
        }
        var validBarData = order.map((cat, idx) => {
            var bar = dataDict[cat];
            if (bar && bar.x.length > 0) {
                bar.marker = { color: tealPalette[idx % tealPalette.length], line: { color: '#fff', width: 1 } };
                bar.hoverinfo = 'name+y';
                bar.hoverlabel = { bgcolor: c.hover_bg, bordercolor: '#00a79d', font: { color: c.hover_font } };
                return bar;
            }
            return null;
        }).filter(Boolean);
        Plotly.react('bar-plot-2', validBarData, {
            barmode: 'group', title: { text: '' },
            xaxis: { title: 'Age Category', categoryorder: 'array', categoryarray: categoryOrder, automargin: true, tickangle: -15, color: c.font },
            yaxis: { title: 'Donor Count', gridcolor: c.grid, color: c.font },
            legend: { title: { text: 'Donation Category', font: { size: 12, color: '#00a79d' } }, font: { size: 11, color: c.font } },
            plot_bgcolor: 'rgba(0,0,0,0)', paper_bgcolor: 'rgba(0,0,0,0)',
            font: { family: 'inherit', color: c.font },
            margin: { t: 20, b: 100, l: 50, r: 50 }
        }, plotConfig);
    }

    // === Load & render charts ===
    fetch('/machine-learning/output/bar_plot_donation_class.json')
        .then(r => r.json())
        .then(data => { cachedData.bar1 = data; renderBar1(data); hideLoading('barLoading'); })
        .catch(() => showError('bar-plot', 'barLoading'));

    fetch('/machine-learning/output/pie_chart_age_category_counts.json')
        .then(r => r.json())
        .then(data => { cachedData.pie = data; renderPie(data); hideLoading('pieLoading'); })
        .catch(() => showError('age-pie-chart', 'pieLoading'));

    fetch('/machine-learning/output/bar_plot_count_age_donation.json')
        .then(r => r.json())
        .then(data => { cachedData.bar2 = data; renderBar2(data); hideLoading('bar2Loading'); })
        .catch(() => showError('bar-plot-2', 'bar2Loading'));

    // Re-render charts on dark mode toggle
    $(document).on('darkModeChange', function() {
        if (cachedData.bar1) renderBar1(cachedData.bar1);
        if (cachedData.pie)  renderPie(cachedData.pie);
        if (cachedData.bar2) renderBar2(cachedData.bar2);
    });
});
</script>
@endsection
