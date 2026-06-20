@extends('admin-page.template.body')

@section('styles')
@include('admin-page.forms.components._form._form-styles')
<style>
/* ── Analytics Page ── */
.an-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .75rem; margin-bottom: 1.5rem;
}

.stat-card {
    background: #fff; border-radius: 12px; border: 1px solid #e5e7eb;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); padding: 1.25rem 1.5rem;
    display: flex; align-items: center; gap: 1rem;
}
.stat-card-icon {
    width: 48px; height: 48px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; flex-shrink: 0;
}
.stat-card-icon.teal  { background: rgba(0,167,157,.12); color: #00a79d; }
.stat-card-icon.green { background: rgba(34,197,94,.12);  color: #16a34a; }
.stat-card-icon.red   { background: rgba(239,68,68,.12);  color: #dc2626; }
.stat-card-icon.blue  { background: rgba(59,130,246,.12); color: #2563eb; }
.stat-card-num { font-size: 1.75rem; font-weight: 800; line-height: 1; color: #111827; }
.stat-card-lbl { font-size: .78rem; color: #6b7280; margin-top: 3px; }

.chart-card {
    background: #fff; border-radius: 12px; border: 1px solid #e5e7eb;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); padding: 1.25rem 1.5rem; margin-bottom: 1.25rem;
    overflow: hidden; min-width: 0;
}

.chart-card canvas { max-width: 100%; display: block; }
.chart-card-title {
    font-size: .85rem; font-weight: 700; color: #374151;
    margin-bottom: 1rem; display: flex; align-items: center; gap: .5rem;
}
.chart-card-badge {
    font-size: .65rem; background: #e0f7f5; color: #00857c;
    border-radius: 4px; padding: 2px 7px; font-weight: 600;
    text-transform: uppercase; letter-spacing: .04em;
}
.recent-table { font-size: .83rem; }
.recent-table th {
    font-size: .73rem; text-transform: uppercase; letter-spacing: .05em;
    color: #9ca3af; font-weight: 600; border-bottom: 2px solid #e5e7eb;
}

/* Dark mode */
html.dark-mode .stat-card        { background: #22252d; border-color: #2d3139; }
html.dark-mode .stat-card-num    { color: #e4e6eb; }
html.dark-mode .stat-card-lbl    { color: #9ca3af; }
html.dark-mode .chart-card       { background: #22252d; border-color: #2d3139; }
html.dark-mode .chart-card-title { color: #c8cdd3; }
html.dark-mode .chart-card-badge { background: rgba(0,167,157,.15); color: #2dd4bf; }
html.dark-mode .recent-table th  { color: #6b7280; border-bottom-color: #2d3139; }
html.dark-mode .recent-table td  { color: #c8cdd3; border-color: #2d3139; }
html.dark-mode .recent-table     { color: #c8cdd3; }
html.dark-mode .recent-table .badge.bg-success { background-color: #166534 !important; }
html.dark-mode .recent-table .badge.bg-danger  { background-color: #7f1d1d !important; }
html.dark-mode .an-header .badge { opacity: .9; }

/* Mobile responsive */
@media (max-width: 767px) {
    /* Reduce container padding on mobile */
    .container-fluid.pt-4.px-4 { padding-left: .75rem !important; padding-right: .75rem !important; }

    .stat-card         { padding: .9rem 1rem; gap: .75rem; }
    .stat-card-num     { font-size: 1.4rem; }
    .stat-card-icon    { width: 38px; height: 38px; font-size: 1rem; }
    .stat-card-lbl     { font-size: .72rem; }

    .chart-card        { padding: .85rem; }
    .chart-card-title  { font-size: .78rem; flex-wrap: wrap; gap: .35rem; }
    .chart-card-badge  { font-size: .58rem; }

    .recent-table      { font-size: .72rem; }
    .recent-table th   { font-size: .62rem; }
}
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4" style="overflow-x:hidden;">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        <div class="col-12 text-center mb-3">
            <h1 class="page-title">
                <i class="fa fa-chart-bar me-2"></i>
                <span>Form</span>
                <span class="highlighted-text ms-1">Analytics</span>
                <small class="d-block mt-2">{{ $form->title }}</small>
            </h1>
        </div>

        <div class="col-12 mb-4">

            {{-- Header bar --}}
            <div class="an-header">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge
                        @if($form->status === 'published') bg-success
                        @elseif($form->status === 'draft')  bg-secondary
                        @elseif($form->status === 'closed') bg-warning text-dark
                        @else bg-dark @endif">
                        {{ ucfirst($form->status) }}
                    </span>
                    <span class="text-muted" style="font-size:.83rem;">
                        <i class="fa fa-calendar me-1"></i>
                        As of {{ now()->timezone('Asia/Jakarta')->format('d M Y') }}
                    </span>
                </div>
            </div>

            {{-- Stat cards --}}
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-card-icon teal"><i class="fa fa-paper-plane"></i></div>
                        <div>
                            <div class="stat-card-num">{{ number_format($submissions->count()) }}</div>
                            <div class="stat-card-lbl">Total Responses</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-card-icon green"><i class="fa fa-check-circle"></i></div>
                        <div>
                            <div class="stat-card-num">{{ number_format($validCount) }}</div>
                            <div class="stat-card-lbl">Valid Responses</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-card-icon blue"><i class="fa fa-users"></i></div>
                        <div>
                            <div class="stat-card-num">{{ number_format($submissions->unique('respondentEmail')->count()) }}</div>
                            <div class="stat-card-lbl">Unique Respondents</div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="stat-card-icon red"><i class="fa fa-file-upload"></i></div>
                        <div>
                            <div class="stat-card-num">{{ number_format($totalFiles) }}</div>
                            <div class="stat-card-lbl">Files Uploaded</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                {{-- Submissions over 30 days --}}
                <div class="col-md-8">
                    <div class="chart-card">
                        <div class="chart-card-title">
                            <i class="fa fa-chart-line text-success"></i>
                            Submissions — Last 30 Days
                        </div>
                        <canvas id="chartDaily" height="100"></canvas>
                    </div>
                </div>

                {{-- Valid vs Invalid --}}
                <div class="col-md-4">
                    <div class="chart-card">
                        <div class="chart-card-title">
                            <i class="fa fa-chart-pie text-info"></i>
                            Response Status
                        </div>
                        <canvas id="chartStatus" height="170"></canvas>
                        <div class="text-center mt-2" style="font-size:.75rem; color:#6b7280;">
                            <span class="me-3">
                                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#00a79d;margin-right:4px;"></span>
                                Valid ({{ $validCount }})
                            </span>
                            <span>
                                <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:#ef4444;margin-right:4px;"></span>
                                Invalid ({{ $invalidCount }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Field-level answer charts ── --}}
            @if(!empty($fieldCharts))
            <div class="chart-card mb-3">
                <div class="chart-card-title mb-0">
                    <i class="fa fa-poll text-primary"></i>
                    Question Breakdown
                    <span class="chart-card-badge">{{ count($fieldCharts) }} fields analyzed</span>
                </div>
            </div>

            <div class="row g-3 mb-3">
                @foreach($fieldCharts as $idx => $fc)
                @php
                    $colClass = $fc['chartType'] === 'doughnut' ? 'col-md-4' : 'col-md-6';
                    if (in_array($fc['type'], ['short_text','email','date'])) $colClass = 'col-12';
                    $icon = match($fc['chartType']) {
                        'doughnut'       => 'fa-chart-pie',
                        'bar-horizontal' => 'fa-bars',
                        default          => 'fa-chart-bar',
                    };
                    $typeLabel = match($fc['type']) {
                        'short_text'    => 'Short Text',
                        'linear_scale'  => 'Linear Scale',
                        'email'         => 'Email Domain',
                        default         => ucfirst(str_replace('_', ' ', $fc['type'])),
                    };
                    $canvasH = match($fc['chartType']) {
                        'doughnut'       => '200',
                        'bar-horizontal' => (string)(count($fc['labels']) * 28 + 40),
                        default          => '140',
                    };
                @endphp
                <div class="{{ $colClass }}">
                    <div class="chart-card" style="height:100%;">
                        <div class="chart-card-title">
                            <i class="fa {{ $icon }} text-muted"></i>
                            {{ $fc['label'] }}
                            <span class="chart-card-badge">{{ $typeLabel }}</span>
                        </div>
                        <canvas id="fieldChart{{ $idx }}" height="{{ $canvasH }}"></canvas>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Recent submissions table --}}
            <div class="chart-card mb-4">
                <div class="chart-card-title">
                    <i class="fa fa-list text-primary"></i>
                    10 Most Recent Submissions
                </div>
                @if($recent->isEmpty())
                <p class="text-muted text-center py-3" style="font-size:.85rem;">No responses yet.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-hover recent-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Submitted At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recent as $i => $sub)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $sub->respondentName ?: '—' }}</td>
                                <td>{{ $sub->respondentEmail ?: '—' }}</td>
                                <td>{{ $sub->submittedAt?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                                <td>
                                    @if($sub->flagValid)
                                        <span class="badge bg-success">Valid</span>
                                    @else
                                        <span class="badge bg-danger">Invalid</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            {{-- Back button — bottom right --}}
            <div class="row mb-5">
                <div class="col-12 d-flex justify-content-end">
                    <a href="{{ route('admin.forms.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const isDark     = document.documentElement.classList.contains('dark-mode');
    const gridColor  = isDark ? 'rgba(255,255,255,.07)' : 'rgba(0,0,0,.06)';
    const labelColor = isDark ? '#9ca3af' : '#6b7280';
    const tooltipBg  = isDark ? '#22252d' : '#fff';
    const tooltipTxt = isDark ? '#e4e6eb' : '#111827';
    const borderClr  = isDark ? '#2d3139' : '#e5e7eb';

    // Global Chart.js defaults for mobile & dark mode
    Chart.defaults.responsive        = true;
    Chart.defaults.maintainAspectRatio = true;
    Chart.defaults.color             = labelColor;
    Chart.defaults.borderColor       = gridColor;

    const PALETTE = [
        '#00a79d','#6366f1','#f59e0b','#ef4444','#10b981',
        '#3b82f6','#a855f7','#ec4899','#14b8a6','#f97316',
    ];

    // ── Daily line chart ──────────────────────────────────────────
    const ctxLine = document.getElementById('chartDaily');
    if (ctxLine) {
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($dailyLabels),
                datasets: [{
                    label: 'Submissions',
                    data: @json($dailyCounts),
                    borderColor: '#00a79d',
                    backgroundColor: 'rgba(0,167,157,.12)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#00a79d',
                    fill: true,
                    tension: .35,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: tooltipBg, titleColor: tooltipTxt, bodyColor: tooltipTxt, borderColor: gridColor, borderWidth: 1 } },
                scales: {
                    x: { grid: { color: gridColor }, ticks: { color: labelColor, maxTicksLimit: 10 } },
                    y: { grid: { color: gridColor }, ticks: { color: labelColor, precision: 0, beginAtZero: true } },
                }
            }
        });
    }

    // ── Response status doughnut ──────────────────────────────────
    const ctxPie = document.getElementById('chartStatus');
    if (ctxPie) {
        new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: ['Valid', 'Invalid'],
                datasets: [{ data: [{{ $validCount }}, {{ $invalidCount }}], backgroundColor: ['#00a79d','#ef4444'], borderWidth: 0 }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false }, tooltip: { backgroundColor: tooltipBg, titleColor: tooltipTxt, bodyColor: tooltipTxt } },
                cutout: '65%',
            }
        });
    }

    // ── Field-level charts ────────────────────────────────────────
    const fieldCharts = @json($fieldCharts ?? []);
    fieldCharts.forEach(function (fc, idx) {
        const canvas = document.getElementById('fieldChart' + idx);
        if (!canvas) return;

        const colors = fc.labels.map(function (_, i) { return PALETTE[i % PALETTE.length]; });

        var tooltipOpts = { backgroundColor: tooltipBg, titleColor: tooltipTxt, bodyColor: tooltipTxt };

        if (fc.chartType === 'doughnut') {
            new Chart(canvas, {
                type: 'doughnut',
                data: {
                    labels: fc.labels,
                    datasets: [{ data: fc.data, backgroundColor: colors, borderWidth: 0 }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: labelColor, font: { size: 11 }, boxWidth: 12, padding: 10 } },
                        tooltip: Object.assign({}, tooltipOpts, { callbacks: { label: function (ctx) {
                            var total = ctx.dataset.data.reduce(function(a,b){return a+b;}, 0);
                            var pct = total ? Math.round(ctx.parsed / total * 100) : 0;
                            return ' ' + ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                        }}})
                    },
                    cutout: '55%',
                }
            });
        } else if (fc.chartType === 'bar-horizontal') {
            // Horizontal bar — for short_text, email domain, date
            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: fc.labels,
                    datasets: [{
                        label: 'Responses',
                        data: fc.data,
                        backgroundColor: PALETTE[0],
                        borderRadius: 4,
                        borderWidth: 0,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: { legend: { display: false }, tooltip: tooltipOpts },
                    scales: {
                        x: { grid: { color: gridColor }, ticks: { color: labelColor, precision: 0, beginAtZero: true } },
                        y: { grid: { color: 'transparent' }, ticks: { color: labelColor, font: { size: 11 } } },
                    }
                }
            });
        } else {
            // Vertical bar — for checkbox, linear_scale, rating, number
            var isNumericType = ['linear_scale','rating','number'].indexOf(fc.type) >= 0;
            new Chart(canvas, {
                type: 'bar',
                data: {
                    labels: fc.labels,
                    datasets: [{
                        label: 'Responses',
                        data: fc.data,
                        backgroundColor: isNumericType ? '#00a79d' : colors,
                        borderRadius: 5,
                        borderWidth: 0,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false }, tooltip: tooltipOpts },
                    scales: {
                        x: { grid: { color: gridColor }, ticks: { color: labelColor } },
                        y: { grid: { color: gridColor }, ticks: { color: labelColor, precision: 0, beginAtZero: true } },
                    }
                }
            });
        }
    });
})();
</script>
@endsection
