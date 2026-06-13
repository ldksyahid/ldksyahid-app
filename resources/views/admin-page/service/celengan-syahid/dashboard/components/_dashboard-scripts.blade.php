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

    // === Load & render charts (single aggregated endpoint) ===
    fetch(@json(route('admin.service.dashboard.data')), { headers: { 'Accept': 'application/json' } })
        .then(r => r.json())
        .then(data => {
            cachedData.bar1 = data.donation_class; renderBar1(data.donation_class); hideLoading('barLoading');
            cachedData.pie  = data.age_category;   renderPie(data.age_category);    hideLoading('pieLoading');
            cachedData.bar2 = data.age_donation;   renderBar2(data.age_donation);   hideLoading('bar2Loading');
        })
        .catch(() => {
            showError('bar-plot', 'barLoading');
            showError('age-pie-chart', 'pieLoading');
            showError('bar-plot-2', 'bar2Loading');
        });

    // Re-render charts on dark mode toggle
    $(document).on('darkModeChange', function() {
        if (cachedData.bar1) renderBar1(cachedData.bar1);
        if (cachedData.pie)  renderPie(cachedData.pie);
        if (cachedData.bar2) renderBar2(cachedData.bar2);
    });
});
</script>
