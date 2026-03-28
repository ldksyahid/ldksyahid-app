<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
(function () {
    'use strict';

    // Init Bootstrap tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
        new bootstrap.Tooltip(el, { trigger: 'hover focus' });
    });

    var STATS_URL   = '{{ route("admin.api.visitor-stats") }}';
    var TP_URL      = '{{ route("admin.api.visitor-top-pages") }}';
    var lineChart   = null;
    var deviceChart = null;

    // ── Date range state (default: last 30 days) ───────────────────
    var startDate = moment().subtract(29, 'days').format('YYYY-MM-DD');
    var endDate   = moment().format('YYYY-MM-DD');

    // ── Top Pages state ────────────────────────────────────────────
    var tp = { search: '', sortBy: 'hits', sortOrder: 'desc', page: 1 };
    var tpSearchTimer = null;

    // ── Countdown + auto-refresh ───────────────────────────────────
    var timeLeft          = 60;
    var countdownInterval = null;

    function updateCountdown() {
        var el = document.getElementById('va-countdown');
        if (el) el.textContent = timeLeft;
    }

    function resetCountdown() { timeLeft = 60; updateCountdown(); }

    function startCountdown() {
        if (countdownInterval) clearInterval(countdownInterval);
        countdownInterval = setInterval(function () {
            timeLeft--;
            updateCountdown();
            if (timeLeft <= 0) {
                loadStats();
                timeLeft = 60;
            }
        }, 1000);
    }

    document.getElementById('va-refresh').addEventListener('click', function () {
        loadStats();
        loadTopPages();
        resetCountdown();
    });

    // ── Daterangepicker ────────────────────────────────────────────
    $('#va-daterange').daterangepicker({
        autoUpdateInput: true,
        startDate: moment().subtract(29, 'days'),
        endDate:   moment(),
        locale: {
            format: 'DD MMM YYYY',
            separator: ' – ',
            applyLabel: 'Apply',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su','Mo','Tu','We','Th','Fr','Sa'],
            monthNames: ['January','February','March','April','May','June','July','August','September','October','November','December'],
            firstDay: 1,
        },
        ranges: {
            'Today':        [moment(), moment()],
            'Last 7 Days':  [moment().subtract(6,  'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'Last 90 Days': [moment().subtract(89, 'days'), moment()],
            'This Month':   [moment().startOf('month'), moment()],
            'This Year':    [moment().startOf('year'),  moment()],
        },
        opens: 'right',
    });

    $('#va-daterange').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD MMM YYYY') + ' – ' + picker.endDate.format('DD MMM YYYY'));
        startDate = picker.startDate.format('YYYY-MM-DD');
        endDate   = picker.endDate.format('YYYY-MM-DD');
        tp.page   = 1;
        loadStats();
        loadTopPages();
        resetCountdown();
    });

    $('#va-daterange').on('cancel.daterangepicker', function () {
        startDate = moment().subtract(29, 'days').format('YYYY-MM-DD');
        endDate   = moment().format('YYYY-MM-DD');
        $(this).val(moment().subtract(29, 'days').format('DD MMM YYYY') + ' – ' + moment().format('DD MMM YYYY'));
        tp.page = 1;
        loadStats();
        loadTopPages();
        resetCountdown();
    });

    // ── Cached chart data (for theme re-render) ────────────────────
    var lastChartData = null, lastDeviceData = null;

    // ── Fetch summary + charts ─────────────────────────────────────
    function loadStats() {
        fetch(STATS_URL + '?start_date=' + startDate + '&end_date=' + endDate, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            lastChartData  = data.chart;
            lastDeviceData = data.devices;
            renderSummary(data.summary);
            renderLineChart(data.chart);
            renderDeviceChart(data.devices);
        })
        .catch(function () {});
    }

    // ── Fetch top pages (paginated + searchable) ───────────────────
    function loadTopPages() {
        showTopPagesSkeleton();

        $.ajax({
            url: TP_URL,
            type: 'GET',
            data: {
                start_date: startDate,
                end_date:   endDate,
                search:     tp.search,
                sort_by:    tp.sortBy,
                sort_order: tp.sortOrder,
                page:       tp.page,
            },
            success: function (res) {
                $('#va-top-pages').html(res.html);
                $('#va-tp-pagination').html(res.pagination || '');
                $('#va-tp-info').text(res.total > 0 ? ('Showing ' + res.from + '–' + res.to + ' of ' + res.total + ' paths') : '');
                updateSortArrows();
                document.querySelectorAll('#va-top-pages [data-bs-toggle="tooltip"]').forEach(function (el) {
                    new bootstrap.Tooltip(el, { trigger: 'hover focus' });
                });
            },
            error: function () {
                $('#va-top-pages').html('<tr><td colspan="4" class="text-center text-muted py-3">Failed to load data</td></tr>');
            }
        });
    }

    function showTopPagesSkeleton() {
        var rows = '';
        for (var i = 0; i < 8; i++) {
            rows += '<tr class="va-skeleton">'
                + '<td><div style="width:20px;"></div></td>'
                + '<td><div></div></td>'
                + '<td><div style="width:60px; margin-left:auto;"></div></td>'
                + '<td><div style="width:60px; margin-left:auto;"></div></td>'
                + '</tr>';
        }
        $('#va-top-pages').html(rows);
    }

    // ── Sort headers ───────────────────────────────────────────────
    $(document).on('click', '.va-sort-th', function () {
        var col = $(this).data('sort');
        if (tp.sortBy === col) {
            tp.sortOrder = tp.sortOrder === 'desc' ? 'asc' : 'desc';
        } else {
            tp.sortBy    = col;
            tp.sortOrder = 'desc';
        }
        tp.page = 1;
        loadTopPages();
    });

    function updateSortArrows() {
        document.querySelectorAll('.va-sort-arrow').forEach(function (el) { el.textContent = ''; el.classList.remove('active'); });
        var arrow = document.getElementById('va-arrow-' + tp.sortBy);
        if (arrow) {
            arrow.textContent = tp.sortOrder === 'asc' ? '↑' : '↓';
            arrow.classList.add('active');
        }
    }

    // ── Search input ───────────────────────────────────────────────
    document.getElementById('va-tp-search').addEventListener('input', function () {
        var val = this.value;
        document.getElementById('va-tp-clear').classList.toggle('d-none', val === '');
        clearTimeout(tpSearchTimer);
        tpSearchTimer = setTimeout(function () {
            tp.search = val;
            tp.page   = 1;
            loadTopPages();
        }, 350);
    });

    document.getElementById('va-tp-clear').addEventListener('click', function () {
        document.getElementById('va-tp-search').value = '';
        this.classList.add('d-none');
        tp.search = '';
        tp.page   = 1;
        loadTopPages();
    });

    // ── Pagination intercept ───────────────────────────────────────
    $(document).on('click', '#va-tp-pagination .pagination a', function (e) {
        e.preventDefault();
        var url = new URL($(this).attr('href'), window.location.origin);
        tp.page = parseInt(url.searchParams.get('page')) || 1;
        loadTopPages();
    });

    // ── Summary cards ──────────────────────────────────────────────
    function renderSummary(s) {
        setEl('va-today',     fmt(s.today));
        setEl('va-month',     fmt(s.month));
        setEl('va-year',      fmt(s.year));
        setEl('va-alltime',   fmt(s.allTime));
        setEl('va-activenow', fmt(s.activeNow));
    }

    // ── Line chart ─────────────────────────────────────────────────
    function renderLineChart(chart) {
        var ctx = document.getElementById('va-line-chart').getContext('2d');
        var isDark    = document.documentElement.classList.contains('dark-mode');
        var gridColor = isDark ? 'rgba(255,255,255,.07)' : 'rgba(0,0,0,.06)';
        var tickColor = isDark ? '#adb5bd' : '#6c757d';

        if (lineChart) { lineChart.destroy(); }

        lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chart.labels,
                datasets: [{
                    label: 'Visitors',
                    data: chart.data,
                    borderColor: '#00a79d',
                    backgroundColor: 'rgba(0,167,157,.1)',
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true,
                    tension: 0.3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { ticks: { color: tickColor, maxTicksLimit: 10, font: { size: 11 } }, grid: { color: gridColor } },
                    y: { beginAtZero: true, ticks: { color: tickColor, precision: 0, font: { size: 11 } }, grid: { color: gridColor } }
                }
            }
        });
    }

    // ── Device pie chart ───────────────────────────────────────────
    function renderDeviceChart(devices) {
        var ctx = document.getElementById('va-device-chart').getContext('2d');
        if (deviceChart) { deviceChart.destroy(); }

        deviceChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Desktop', 'Mobile', 'Tablet', 'Bot'],
                datasets: [{
                    data: [devices.desktop, devices.mobile, devices.tablet, devices.bot],
                    backgroundColor: ['#6366f1', '#00a79d', '#f59e0b', '#ef4444'],
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 12 }, padding: 16 } } }
            }
        });
    }

    // ── Helpers ────────────────────────────────────────────────────
    function setEl(id, val) { var el = document.getElementById(id); if (el) el.textContent = val; }
    function fmt(n) { return Number(n).toLocaleString('id-ID'); }

    // ── Re-render charts on dark/light mode toggle ─────────────────
    new MutationObserver(function () {
        if (lastChartData)  renderLineChart(lastChartData);
        if (lastDeviceData) renderDeviceChart(lastDeviceData);
    }).observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // ── Init ───────────────────────────────────────────────────────
    loadStats();
    loadTopPages();
    startCountdown();
})();
</script>
