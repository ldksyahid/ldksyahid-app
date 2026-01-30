@extends('admin-page.template.body')

@section('styles')
<style>
    .page-title {
        font-size: 1.65rem;
        font-weight: 600;
        text-align: center;
        color: #00a79d;
        margin: .75rem 0 1.5rem;
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
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #00a79d;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e0f7f5;
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Greeting Header */
    .greeting-card {
        background: linear-gradient(135deg, #00a79d 0%, #008b84 50%, #006b63 100%);
        border-radius: 16px;
        color: #fff;
        padding: 1.5rem 2rem;
        position: relative;
        overflow: hidden;
    }
    .greeting-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }
    .greeting-card .greeting-text {
        font-size: 1.5rem;
        font-weight: 700;
    }
    .greeting-card .greeting-sub {
        font-size: 0.9rem;
        opacity: 0.85;
    }
    .greeting-card .live-clock {
        font-size: 2rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        letter-spacing: 2px;
    }
    .greeting-card .live-date {
        font-size: 0.9rem;
        opacity: 0.85;
    }

    /* Widget Cards */
    .widget-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        text-decoration: none;
        display: block;
        color: inherit;
    }
    .widget-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 167, 157, 0.2) !important;
        color: inherit;
        text-decoration: none;
    }
    .widget-card .widget-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fff;
        background: linear-gradient(135deg, #00a79d 0%, #008b84 100%);
        flex-shrink: 0;
    }
    .widget-card .widget-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #00a79d;
        line-height: 1;
    }
    .widget-card .widget-label {
        font-size: 0.85rem;
        color: #6c757d;
        font-weight: 500;
    }

    /* Charts */
    .chart-container {
        position: relative;
        height: 300px;
    }

    /* Prayer Cards */
    .prayer-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #fff;
        border: 1px solid #e0f7f5;
    }
    .prayer-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 167, 157, 0.15);
        border-color: #00a79d;
    }
    .prayer-card .prayer-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #00a79d 0%, #008b84 100%);
        color: #fff;
        font-size: 1rem;
    }
    .prayer-card .prayer-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #495057;
    }
    .prayer-card .prayer-time {
        font-size: 1rem;
        font-weight: 700;
        color: #00a79d;
    }

    /* Calendar & Map */
    .map-iframe {
        border-radius: 10px;
        border: 2px solid #e0f7f5;
    }

    @media (max-width: 768px) {
        .page-title { font-size: 1.35rem; }
        .section-title { font-size: 1rem; }
        .widget-card .widget-count { font-size: 1.25rem; }
        .widget-card .widget-icon { width: 44px; height: 44px; font-size: 1.1rem; }
        .greeting-card { padding: 1rem 1.25rem; flex-direction: column; align-items: flex-start !important; gap: 0.75rem; }
        .greeting-card .greeting-text { font-size: 1.1rem; }
        .greeting-card .greeting-sub { font-size: 0.8rem; }
        .greeting-card .live-clock { font-size: 1.3rem; }
        .greeting-card .live-date { font-size: 0.8rem; }
        .greeting-card .text-end { text-align: left !important; }
        .chart-container { height: 250px; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-tachometer-alt me-2"></i>
                <span>LDK&nbsp;Syahid</span>
                <span class="highlighted-text ms-1">Dashboard</span>
            </h1>

            <!-- Greeting Header + Live Clock -->
            <div class="col-md-12 mb-4">
                <div class="greeting-card d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <div class="greeting-text" id="greetingText">Selamat Datang</div>
                        <div class="greeting-sub" id="greetingSub">{{ Auth::user()->name ?? 'Admin' }} &mdash; Semoga harimu produktif!</div>
                    </div>
                    <div class="text-end mt-2 mt-md-0">
                        <div class="live-clock" id="liveClock">--:--:--</div>
                        <div class="live-date" id="liveDate">-</div>
                    </div>
                </div>
            </div>

            <!-- Statistics Widgets -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-chart-bar me-2"></i>Statistics Overview</h5>
                        @php
                            $widgets = [
                                ['icon' => 'fa-users', 'title' => 'Users', 'count' => $userCount, 'route' => 'admin.user.index'],
                                ['icon' => 'fa-calendar-check', 'title' => 'Events', 'count' => $eventCount, 'route' => 'admin.event.index'],
                                ['icon' => 'fa-book-open', 'title' => 'Articles', 'count' => $articleCount, 'route' => 'admin.article.index'],
                                ['icon' => 'fa-newspaper', 'title' => 'News', 'count' => $newsCount, 'route' => 'admin.news.index'],
                                ['icon' => 'fa-link', 'title' => 'Shortlinks', 'count' => $shortLinkCount, 'route' => 'admin.service.shortlink.index'],
                                ['icon' => 'fa-id-card', 'title' => 'ID Cards', 'count' => $idCardCount, 'route' => 'admin.ktaldksyahid.index'],
                            ];
                        @endphp
                        <div class="row g-3" id="widgetSection">
                            @foreach ($widgets as $widget)
                            <div class="col-6 col-md-4 col-lg-2">
                                <a href="{{ route($widget['route']) }}" class="widget-card bg-white border shadow-sm p-3 text-center">
                                    <div class="widget-icon mx-auto mb-2">
                                        <i class="fa {{ $widget['icon'] }}"></i>
                                    </div>
                                    <div class="widget-count" data-target="{{ $widget['count'] }}">0</div>
                                    <div class="widget-label">{{ $widget['title'] }}</div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="col-md-12 mb-4">
                <div class="row g-4">
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="section-title mb-3"><i class="fas fa-chart-bar me-2"></i>Data Overview</h5>
                                <div class="chart-container">
                                    <canvas id="barChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="section-title mb-3"><i class="fas fa-chart-pie me-2"></i>Data Proportion</h5>
                                <div class="chart-container">
                                    <canvas id="doughnutChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prayer Times -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-mosque me-2"></i>Prayer Times - Jakarta</h5>
                        <div class="row g-3">
                            @php
                                $prayers = ['Imsak', 'Subuh', 'Dzuhur', 'Ashar', 'Maghrib', 'Isya'];
                                $icons = ['fa-moon', 'fa-sun', 'fa-sun', 'fa-cloud-sun', 'fa-moon', 'fa-star'];
                            @endphp
                            @foreach ($prayers as $index => $name)
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="prayer-card text-center p-3">
                                    <div class="prayer-icon mx-auto mb-2">
                                        <i class="fa {{ $icons[$index] }}"></i>
                                    </div>
                                    <div class="prayer-name mb-1">{{ $name }}</div>
                                    <div class="prayer-time">{{ $prayerTimes[strtolower($name)] ?? '-' }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar & Location -->
            <div class="col-md-12 mb-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="section-title mb-3"><i class="fas fa-calendar-alt me-2"></i>Calendar</h5>
                                <div id="calender" style="min-height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="section-title mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location</h5>
                                <iframe class="w-100 map-iframe" style="min-height: 300px;"
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6773009952885!2d106.75319361449397!3d-6.306059963469107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efd9636c9d6b%3A0x71fbe6e9045945ff!2sLDK%20Syahid%20UIN%20Syarif%20Hidayatullah%20Jakarta!5e0!3m2!1sen!2sid!4v1664242233249!5m2!1sen!2sid"
                                    frameborder="0" allowfullscreen="" aria-hidden="false" tabindex="0">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // === Live Clock + Greeting ===
    function updateClock() {
        var now = new Date();
        var hours = String(now.getHours()).padStart(2, '0');
        var minutes = String(now.getMinutes()).padStart(2, '0');
        var seconds = String(now.getSeconds()).padStart(2, '0');
        $('#liveClock').text(hours + ':' + minutes + ':' + seconds);

        var days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        var months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $('#liveDate').text(days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear());

        var h = now.getHours();
        var greeting = h < 11 ? 'Selamat Pagi' : h < 15 ? 'Selamat Siang' : h < 18 ? 'Selamat Sore' : 'Selamat Malam';
        var icon = h < 11 ? '&#9728;' : h < 15 ? '&#9728;' : h < 18 ? '&#127749;' : '&#127769;';
        $('#greetingText').html(icon + ' ' + greeting + ',');
    }
    updateClock();
    setInterval(updateClock, 1000);

    // === Rotating Greeting Messages ===
    var userName = '{{ Auth::user()->name ?? "Admin" }}';
    var greetingMessages = [
        'Semoga harimu produktif!',
        'Tetap semangat dan istiqomah!',
        'Jangan lupa istirahat ya!',
        'Bismillah, semoga dimudahkan!',
        'Keep up the great work!',
        'Yuk, kelola data dengan rapi!',
        'Semoga selalu dalam lindungan-Nya!',
        'Senyum dulu, baru kerja~',
        'Have a wonderful day!',
        'Jaga kesehatan, jaga ibadah!',
    ];
    var currentMsgIndex = 0;

    function rotateGreeting() {
        currentMsgIndex = (currentMsgIndex + 1) % greetingMessages.length;
        var $sub = $('#greetingSub');
        $sub.animate({ opacity: 0 }, 400, function() {
            $sub.html(userName + ' &mdash; ' + greetingMessages[currentMsgIndex]);
            $sub.animate({ opacity: 1 }, 400);
        });
    }
    setInterval(rotateGreeting, 5000);

    // === Animated Counter (Count-Up) ===
    var counterAnimated = false;
    function animateCounters() {
        if (counterAnimated) return;
        counterAnimated = true;
        $('.widget-count').each(function() {
            var $this = $(this);
            var target = parseInt($this.data('target')) || 0;
            if (target === 0) { $this.text('0'); return; }
            $({ count: 0 }).animate({ count: target }, {
                duration: 1200,
                easing: 'swing',
                step: function() { $this.text(Math.floor(this.count)); },
                complete: function() { $this.text(target); }
            });
        });
    }

    // Try Waypoints, fallback to immediate
    if (typeof Waypoint !== 'undefined') {
        new Waypoint({
            element: document.getElementById('widgetSection'),
            handler: function() { animateCounters(); this.destroy(); },
            offset: '90%'
        });
    } else {
        animateCounters();
    }

    // === Chart.js ===
    var chartLabels = ['Users', 'Events', 'Articles', 'News', 'Shortlinks', 'ID Cards'];
    var chartData = [
        {{ $userCount }}, {{ $eventCount }}, {{ $articleCount }},
        {{ $newsCount }}, {{ $shortLinkCount }}, {{ $idCardCount }}
    ];
    var chartColors = ['#00a79d', '#008b84', '#00c9bd', '#006b63', '#33b8b0', '#4dd0c8'];

    // Bar Chart
    new Chart(document.getElementById('barChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Total Data',
                data: chartData,
                backgroundColor: chartColors,
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Doughnut Chart
    new Chart(document.getElementById('doughnutChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: chartLabels,
            datasets: [{
                data: chartData,
                backgroundColor: chartColors,
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { padding: 15, usePointStyle: true } }
            }
        }
    });
});
</script>
@endsection
