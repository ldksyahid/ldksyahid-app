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
        max-width: 560px;
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

    /* Quick Actions */
    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 1rem;
        border-radius: 10px;
        border: 1px solid #e0f7f5;
        background: #fff;
        color: #495057;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .quick-action-btn:hover {
        background: linear-gradient(135deg, #00a79d 0%, #008b84 100%);
        color: #fff;
        border-color: #00a79d;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 167, 157, 0.25);
        text-decoration: none;
    }
    .quick-action-btn .qa-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: #fff;
        background: linear-gradient(135deg, #00a79d 0%, #008b84 100%);
        flex-shrink: 0;
        transition: all 0.3s ease;
    }
    .quick-action-btn:hover .qa-icon {
        background: rgba(255,255,255,0.25);
    }

    /* Calendar & Map */
    .map-iframe {
        border-radius: 10px;
        border: 2px solid #e0f7f5;
    }

    /* Dark Mode Overrides - Dashboard */
    html.dark-mode .quick-action-btn {
        background: #2b2f33;
        border-color: #373b3e;
        color: #e4e6eb;
    }
    html.dark-mode .quick-action-btn:hover {
        background: linear-gradient(135deg, #00a79d 0%, #008b84 100%);
        color: #fff;
        border-color: #00a79d;
    }
    html.dark-mode .prayer-card {
        background: #2b2f33;
        border-color: #373b3e;
    }
    html.dark-mode .prayer-card:hover {
        border-color: #00a79d;
        box-shadow: 0 6px 16px rgba(0, 167, 157, 0.25);
    }
    html.dark-mode .prayer-card .prayer-name {
        color: #e4e6eb !important;
    }
    html.dark-mode .widget-card {
        background: #2b2f33 !important;
        border-color: #373b3e !important;
    }
    html.dark-mode .widget-card .widget-label {
        color: #b0b3b8 !important;
    }
    html.dark-mode .map-iframe {
        border-color: #373b3e;
    }
    /* Calendar (datetimepicker) dark mode */
    html.dark-mode .bootstrap-datetimepicker-widget {
        background: #2b2f33 !important;
        border-color: #373b3e !important;
        color: #e4e6eb !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table th,
    html.dark-mode .bootstrap-datetimepicker-widget table td {
        color: #e4e6eb !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table td.day:hover,
    html.dark-mode .bootstrap-datetimepicker-widget table td span:hover {
        background: #373b3e !important;
        color: #e4e6eb !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table td.active,
    html.dark-mode .bootstrap-datetimepicker-widget table td.active:hover {
        background: #00a79d !important;
        color: #fff !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table td.today::before {
        border-bottom-color: #00a79d !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table td.old,
    html.dark-mode .bootstrap-datetimepicker-widget table td.new {
        color: #6c757d !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table th.prev,
    html.dark-mode .bootstrap-datetimepicker-widget table th.next,
    html.dark-mode .bootstrap-datetimepicker-widget table th.picker-switch {
        color: #e4e6eb !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table th.prev:hover,
    html.dark-mode .bootstrap-datetimepicker-widget table th.next:hover,
    html.dark-mode .bootstrap-datetimepicker-widget table th.picker-switch:hover {
        background: #373b3e !important;
    }
    html.dark-mode .bootstrap-datetimepicker-widget table th.dow {
        color: #b0b3b8 !important;
    }

    /* ===== Admin Hadith / Quran Daily Widget ===== */
    .adm-hq-arab {
        font-size: 1.35rem;
        line-height: 2.1;
        text-align: right;
        direction: rtl;
        color: #2d2d2d;
        margin-bottom: 0.5rem;
    }
    .adm-hq-text-wrapper {
        max-height: 155px;
        overflow: hidden;
        transition: max-height 0.5s ease;
        position: relative;
    }
    .adm-hq-text-wrapper.expanded { max-height: 2000px; }
    .adm-hq-text-wrapper.adm-hq-no-overflow { max-height: none; }
    .adm-hq-text-wrapper:not(.expanded):not(.adm-hq-no-overflow)::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 36px;
        background: linear-gradient(to bottom, transparent, #fff);
        pointer-events: none;
    }
    .adm-hq-text {
        font-size: 0.9rem;
        line-height: 1.8;
        color: #495057;
        font-style: italic;
        margin-bottom: 0;
    }
    .adm-hq-fade {
        transition: opacity 0.3s ease;
    }
    .adm-hq-fade.fade-out { opacity: 0; }
    #adm-hq-toggle-icon {
        transition: transform 0.3s ease;
        display: inline-block;
    }
    html.dark-mode .adm-hq-arab { color: #e4e6eb; }
    html.dark-mode .adm-hq-text { color: #b0b3b8; }
    html.dark-mode #adm-hq-source { color: #fff !important; }
    html.dark-mode .adm-hq-text-wrapper:not(.expanded):not(.adm-hq-no-overflow)::after {
        background: linear-gradient(to bottom, transparent, #2b2f33);
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
        .quick-action-btn { font-size: 0.75rem; padding: 0.5rem 0.6rem; gap: 0.4rem; }
        .quick-action-btn .qa-icon { width: 28px; height: 28px; font-size: 0.7rem; border-radius: 6px; }
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
                        <div class="greeting-sub" id="greetingSub">Semoga harimu produktif!</div>
                    </div>
                    <div class="text-end mt-2 mt-md-0">
                        <div class="live-clock" id="liveClock">--:--:--</div>
                        <div class="live-date" id="liveDate">-</div>
                    </div>
                </div>
            </div>

            <!-- Hadith / Quran Daily -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="section-title mb-0">
                                <i class="fas fa-book-open me-2"></i>Hadits &amp; Al-Qur'an Harian
                            </h5>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-muted small">
                                    Konten berikutnya dalam
                                    <span class="fw-semibold" style="color:#00a79d;" id="adm-hq-countdown">60</span>
                                    detik
                                </span>
                                <button id="adm-hq-refresh" title="Muat konten baru"
                                    style="background:transparent; color:#00a79d; border:1px solid #00a79d; border-radius:6px; padding:2px 9px; cursor:pointer; line-height:1.5;">
                                    <i class="fas fa-sync-alt fa-xs"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="adm-hq-fade" id="adm-hq-source"
                                style="background:#00a79d; color:#fff; font-size:0.78rem; padding:3px 10px; border-radius:20px; white-space:nowrap;">
                                Memuat...
                            </span>
                            <span class="text-muted small adm-hq-fade" id="adm-hq-number"></span>
                        </div>
                        <div class="adm-hq-text-wrapper" id="adm-hq-wrapper">
                            <p class="adm-hq-arab adm-hq-fade" id="adm-hq-arab"></p>
                            <p class="adm-hq-text adm-hq-fade" id="adm-hq-text">Sedang memuat konten...</p>
                        </div>
                        <button id="adm-hq-toggle"
                            style="background:transparent; border:none; color:#00a79d; font-size:0.85rem; padding:0; margin-top:0.5rem; cursor:pointer; display:none;">
                            <span id="adm-hq-toggle-text">Lihat Selengkapnya</span>
                            <i class="fas fa-chevron-down fa-xs ms-1" id="adm-hq-toggle-icon"></i>
                        </button>
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
                                ['icon' => 'fa-users', 'title' => 'Users', 'count' => $userCount],
                                ['icon' => 'fa-image', 'title' => 'Jumbotron', 'count' => $jumbotronCount],
                                ['icon' => 'fa-star', 'title' => 'Testimony', 'count' => $testimonyCount],
                                ['icon' => 'fa-calendar-check', 'title' => 'Events', 'count' => $eventCount],
                                ['icon' => 'fa-book-open', 'title' => 'Articles', 'count' => $articleCount],
                                ['icon' => 'fa-clock', 'title' => 'Schedules', 'count' => $scheduleCount],
                                ['icon' => 'fa-newspaper', 'title' => 'News', 'count' => $newsCount],
                                ['icon' => 'fa-bullhorn', 'title' => 'Campaigns', 'count' => $campaignCount],
                                ['icon' => 'fa-donate', 'title' => 'Donations', 'count' => $donationCount],
                                ['icon' => 'fa-envelope', 'title' => 'Messages', 'count' => $contactMessageCount],
                                ['icon' => 'fa-sitemap', 'title' => 'Structure', 'count' => $structureCount],
                                ['icon' => 'fa-images', 'title' => 'Gallery', 'count' => $galleryCount],
                                ['icon' => 'fa-headset', 'title' => 'IT Support', 'count' => $itSupportCount],
                                ['icon' => 'fa-link', 'title' => 'Shortlinks', 'count' => $shortlinkServiceCount],
                                ['icon' => 'fa-phone', 'title' => 'Call Kestari', 'count' => $callKestariCount],
                                ['icon' => 'fa-external-link-alt', 'title' => 'Req Shortlink', 'count' => $reqShortlinkCount],
                                ['icon' => 'fa-id-card', 'title' => 'KTA LDK', 'count' => $idCardCount],
                                ['icon' => 'fa-book', 'title' => 'Book Catalog', 'count' => $catalogBookCount],
                                ['icon' => 'fa-file-alt', 'title' => 'Finance Report', 'count' => $financeReportCount],
                            ];
                        @endphp
                        <div class="row g-3" id="widgetSection">
                            @foreach ($widgets as $widget)
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="widget-card bg-white border shadow-sm p-3 text-center">
                                    <div class="widget-icon mx-auto mb-2">
                                        <i class="fa {{ $widget['icon'] }}"></i>
                                    </div>
                                    <div class="widget-count" data-target="{{ $widget['count'] }}">0</div>
                                    <div class="widget-label">{{ $widget['title'] }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                        @php
                            $quickActions = [
                                ['icon' => 'fa-user-plus', 'label' => 'Add User', 'route' => 'admin.user.create', 'roles' => ['Superadmin']],
                                ['icon' => 'fa-image', 'label' => 'Add Jumbotron', 'route' => 'admin.jumbotron.create', 'roles' => ['Superadmin', 'HelperAdmin', 'HelperCelsyahid', 'HelperEventMart', 'HelperSPAM', 'HelperMedia']],
                                ['icon' => 'fa-star', 'label' => 'Add Testimony', 'route' => 'admin.testimony.create', 'roles' => ['Superadmin', 'HelperAdmin', 'HelperSPAM', 'HelperMedia']],
                                ['icon' => 'fa-calendar-check', 'label' => 'Add Event', 'route' => 'admin.event.create', 'roles' => ['Superadmin', 'HelperAdmin', 'HelperSPAM', 'HelperMedia', 'HelperCelsyahid']],
                                ['icon' => 'fa-book-open', 'label' => 'Add Article', 'route' => 'admin.article.create', 'roles' => ['Superadmin', 'HelperCelsyahid', 'HelperMedia']],
                                ['icon' => 'fa-clock', 'label' => 'Add Schedule', 'route' => 'admin.schedule.create', 'roles' => ['Superadmin', 'HelperSPAM', 'HelperMedia']],
                                ['icon' => 'fa-newspaper', 'label' => 'Add News', 'route' => 'admin.news.create', 'roles' => ['Superadmin', 'HelperCelsyahid', 'HelperMedia']],
                                ['icon' => 'fa-bullhorn', 'label' => 'Add Campaign', 'route' => 'admin.service.create.campaign', 'roles' => ['Superadmin', 'HelperCelsyahid']],
                                ['icon' => 'fa-sitemap', 'label' => 'Add Structure', 'route' => 'admin.about.structure.create', 'roles' => ['Superadmin', 'HelperMedia']],
                                ['icon' => 'fa-images', 'label' => 'Add Gallery', 'route' => 'admin.about.gallery.create', 'roles' => ['Superadmin', 'HelperMedia']],
                                ['icon' => 'fa-headset', 'label' => 'Add IT Support', 'route' => 'admin.about.itsupport.create', 'roles' => ['Superadmin']],
                                ['icon' => 'fa-phone', 'label' => 'Add Call Kestari', 'route' => 'admin.service.callkestari.create', 'roles' => ['Superadmin', 'HelperLetter', 'HelperMedia']],
                                ['icon' => 'fa-id-card', 'label' => 'Add KTA', 'route' => 'admin.ktaldksyahid.create', 'roles' => ['Superadmin', 'HelperLetter']],
                                ['icon' => 'fa-book', 'label' => 'Add Book Catalog', 'route' => 'admin.catalog.books.create', 'roles' => ['Superadmin', 'HelperLetter', 'HelperMedia']],
                                ['icon' => 'fa-file-alt', 'label' => 'Add Finance Report', 'route' => 'admin.finance-report.create', 'roles' => ['Superadmin', 'HelperAdmin', 'HelperCelsyahid', 'HelperEventMart', 'HelperSPAM', 'HelperMedia', 'HelperLetter']],
                                ['icon' => 'fa-link', 'label' => 'Add Shortlink', 'route' => 'admin.service.shortlink.index', 'roles' => ['Superadmin', 'HelperAdmin', 'HelperCelsyahid', 'HelperEventMart', 'HelperSPAM', 'HelperMedia', 'HelperLetter']],
                            ];
                        @endphp
                        <div class="row g-2">
                            @foreach ($quickActions as $action)
                                @if(auth()->user()->hasAnyRole($action['roles']))
                                <div class="col-6 col-md-4 col-lg-3">
                                    <a href="{{ route($action['route']) }}" class="quick-action-btn">
                                        <div class="qa-icon"><i class="fa {{ $action['icon'] }}"></i></div>
                                        {{ $action['label'] }}
                                    </a>
                                </div>
                                @endif
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
    var userName = '{{ Auth::user()->name ?? "Admin" }}';

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
        $('#greetingText').html(icon + ' ' + greeting + ', ' + userName);
    }
    updateClock();
    setInterval(updateClock, 1000);

    // === Motivational Quotes from API (quotes.liupurnomo.com) ===
    var greetingRetryCount = 0, GREETING_MAX_RETRY = 5, greetingRetryTimer = null;

    function applyGreetingQuote($sub, html, animate) {
        if (animate) {
            $sub.animate({ opacity: 0 }, 400, function() {
                $sub.html(html);
                $sub.animate({ opacity: 1 }, 400);
            });
        } else {
            $sub.html(html);
        }
    }

    function fetchMotivasiQuote(animate) {
        var $sub = $('#greetingSub');
        $.ajax({
            url: '{{ route("admin.api.motivasi-quotes") }}',
            method: 'GET',
            timeout: 10000,
            success: function(json) {
                if (json.data && json.data.text) {
                    greetingRetryCount = 0;
                    var text   = json.data.text;
                    var author = json.data.author
                        ? ' <span style="font-size:0.8em;opacity:0.75;font-style:normal;font-weight:400;">— ' + json.data.author + '</span>'
                        : '';
                    applyGreetingQuote($sub, '<em>' + text + '</em>' + author, animate);
                } else {
                    scheduleGreetingRetry(animate);
                }
            },
            error: function() {
                scheduleGreetingRetry(animate);
            }
        });
    }

    function scheduleGreetingRetry(animate) {
        greetingRetryCount++;
        if (greetingRetryCount <= GREETING_MAX_RETRY) {
            greetingRetryTimer = setTimeout(function() {
                fetchMotivasiQuote(animate);
            }, 3000);
        }
        // If all retries exhausted, keep the previous text displayed
    }

    fetchMotivasiQuote(false);
    setInterval(function() {
        greetingRetryCount = 0;
        if (greetingRetryTimer) clearTimeout(greetingRetryTimer);
        fetchMotivasiQuote(true);
    }, 10000);

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
    var chartLabels = [
        'Users', 'Jumbotron', 'Testimony', 'Events', 'Articles', 'Schedules',
        'News', 'Campaigns', 'Donations', 'Messages', 'Structure', 'Gallery',
        'IT Support', 'Shortlinks', 'Call Kestari', 'Req Shortlink',
        'KTA LDK', 'Book Catalog', 'Finance Report'
    ];
    var chartData = [
        {{ $userCount }}, {{ $jumbotronCount }}, {{ $testimonyCount }},
        {{ $eventCount }}, {{ $articleCount }}, {{ $scheduleCount }},
        {{ $newsCount }}, {{ $campaignCount }}, {{ $donationCount }},
        {{ $contactMessageCount }}, {{ $structureCount }}, {{ $galleryCount }},
        {{ $itSupportCount }}, {{ $shortlinkServiceCount }}, {{ $callKestariCount }},
        {{ $reqShortlinkCount }}, {{ $idCardCount }}, {{ $catalogBookCount }},
        {{ $financeReportCount }}
    ];
    var chartColors = [
        '#00a79d', '#008b84', '#00c9bd', '#006b63', '#33b8b0',
        '#4dd0c8', '#00887f', '#26b5ab', '#1a9e95', '#0dbfb3',
        '#009688', '#00796b', '#00897b', '#4db6ac', '#80cbc4',
        '#b2dfdb', '#00bfa5', '#1de9b6', '#69f0ae'
    ];

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
<script>
(function () {
    /* ================================================================
       ADMIN DASHBOARD — Hadith / Quran Daily Widget
       Prefix: adm-hq-   (no conflict with hero-jumbotron hj-)
       ================================================================ */

    var contentType = (Math.random() < 0.5) ? 'hadith' : 'quran';
    var timeLeft = 60, countdownInterval = null, isFetching = false;
    var retryCount = 0, MAX_RETRY = 5, retryTimeout = null;

    var books = [
        { id: 'bukhari',    name: 'HR. Bukhari',    max: 6638 },
        { id: 'muslim',     name: 'HR. Muslim',     max: 4930 },
        { id: 'abu-daud',   name: 'HR. Abu Daud',   max: 4419 },
        { id: 'tirmidzi',   name: 'HR. Tirmidzi',   max: 3625 },
        { id: 'ibnu-majah', name: 'HR. Ibnu Majah', max: 4285 },
        { id: 'nasai',      name: 'HR. Nasai',      max: 5364 },
    ];

    var surahMaxAyah = [
        7,286,200,176,120,165,206,75,129,109,123,111,43,52,99,128,
        111,110,98,135,112,78,118,64,77,227,93,88,69,60,34,30,
        73,54,45,83,182,88,75,85,54,53,89,59,37,35,38,29,
        18,45,60,49,62,55,78,96,29,22,24,13,14,11,11,18,
        12,12,30,52,52,44,28,28,20,56,40,31,50,40,46,42,
        29,19,36,25,22,17,19,26,30,20,15,21,11,8,8,19,
        5,8,8,11,11,8,3,9,5,4,7,3,6,3,5,4,5,6
    ];

    function getEl(id) { return document.getElementById(id); }

    function getFadeEls() {
        return ['adm-hq-arab','adm-hq-text','adm-hq-source','adm-hq-number']
            .map(function(id){ return getEl(id); })
            .filter(function(el){ return el; });
    }

    function fadeOut(cb) {
        var els = getFadeEls(), done = 0, total = els.length;
        if (!total) { cb(); return; }
        els.forEach(function(el){ el.classList.add('fade-out'); });
        els.forEach(function(el){
            var h = function(){
                el.removeEventListener('transitionend', h);
                if (++done === total) cb();
            };
            el.addEventListener('transitionend', h);
            setTimeout(function(){
                if (el.classList.contains('fade-out') && done < total) {
                    el.removeEventListener('transitionend', h);
                    if (++done === total) cb();
                }
            }, 400);
        });
    }

    function fadeIn() {
        getFadeEls().forEach(function(el){ el.classList.remove('fade-out'); });
    }

    function checkOverflow() {
        var wrapper = getEl('adm-hq-wrapper');
        var toggle  = getEl('adm-hq-toggle');
        if (!wrapper || !toggle) return;
        var overflow = wrapper.scrollHeight > wrapper.offsetHeight + 5;
        toggle.style.display = overflow ? 'inline-block' : 'none';
        wrapper.classList.toggle('adm-hq-no-overflow', !overflow);
    }

    function updateCountdown() {
        var el = getEl('adm-hq-countdown');
        if (el) el.textContent = timeLeft;
    }

    function resetCountdown() { timeLeft = 60; updateCountdown(); }

    function startCountdown() {
        if (countdownInterval) clearInterval(countdownInterval);
        countdownInterval = setInterval(function(){
            timeLeft--;
            updateCountdown();
            if (timeLeft <= 0) {
                contentType = (contentType === 'hadith') ? 'quran' : 'hadith';
                timeLeft = 60;
                fetchContent();
            }
        }, 1000);
    }

    function applyContent(arabText, idText, sourceLabel, numberLabel) {
        var wrapper  = getEl('adm-hq-wrapper');
        var toggle   = getEl('adm-hq-toggle');
        var toggleTxt = getEl('adm-hq-toggle-text');
        var icon     = getEl('adm-hq-toggle-icon');
        if (wrapper) wrapper.classList.remove('expanded');
        if (toggle)  { toggle.classList.remove('expanded'); }
        if (toggleTxt) toggleTxt.textContent = 'Lihat Selengkapnya';
        if (icon)    icon.style.transform = '';
        var arabEl = getEl('adm-hq-arab');
        var textEl = getEl('adm-hq-text');
        var srcEl  = getEl('adm-hq-source');
        var numEl  = getEl('adm-hq-number');
        if (arabEl) arabEl.textContent = arabText;
        if (textEl) textEl.innerHTML   = '\u201c' + idText + '\u201d';
        if (srcEl)  srcEl.textContent  = sourceLabel;
        if (numEl)  numEl.textContent  = numberLabel;
        fadeIn();
        setTimeout(checkOverflow, 100);
        resetCountdown();
    }

    function showError(msg) {
        var textEl = getEl('adm-hq-text');
        var srcEl  = getEl('adm-hq-source');
        var arabEl = getEl('adm-hq-arab');
        var numEl  = getEl('adm-hq-number');
        var toggle = getEl('adm-hq-toggle');
        if (textEl) textEl.innerHTML  = msg;
        if (srcEl)  srcEl.textContent = (contentType === 'quran') ? 'Al-Quran' : 'Hadits';
        if (arabEl) arabEl.textContent = '';
        if (numEl)  numEl.textContent  = '';
        if (toggle) toggle.style.display = 'none';
    }

    function scheduleRetry(delay) {
        if (retryTimeout) clearTimeout(retryTimeout);
        if (retryCount < MAX_RETRY) {
            retryTimeout = setTimeout(fetchContent, delay || 3000);
        } else {
            showError('Gagal memuat konten setelah ' + MAX_RETRY + ' percobaan. Silakan refresh halaman.');
            retryCount = 0;
        }
    }

    function fetchRandomHadith() {
        var book   = books[Math.floor(Math.random() * books.length)];
        var number = Math.floor(Math.random() * book.max) + 1;
        var ctrl   = new AbortController();
        var tId    = setTimeout(function(){ ctrl.abort(); }, 10000);
        fetch('https://api.hadith.gading.dev/books/' + book.id + '/' + number, { signal: ctrl.signal })
            .then(function(r){ clearTimeout(tId); return r.json(); })
            .then(function(json){
                if (json.code === 200 && json.data && json.data.contents) {
                    retryCount = 0;
                    var c = json.data.contents;
                    fadeOut(function(){
                        applyContent(c.arab, c.id, book.name, book.name + ' No. ' + c.number);
                    });
                } else { throw new Error('Invalid response'); }
            })
            .catch(function(e){
                retryCount++;
                var msg = e.name === 'AbortError'
                    ? 'Timeout memuat hadits. Mencoba lagi... (' + retryCount + '/' + MAX_RETRY + ')'
                    : (e.message === 'Failed to fetch'
                        ? 'Koneksi terputus. Mencoba lagi... (' + retryCount + '/' + MAX_RETRY + ')'
                        : 'Gagal memuat hadits. Mencoba lagi... (' + retryCount + '/' + MAX_RETRY + ')');
                fadeOut(function(){ showError(msg); fadeIn(); scheduleRetry(3000); });
            })
            .finally(function(){ isFetching = false; });
    }

    function fetchRandomAyah() {
        var surahNo = Math.floor(Math.random() * 114) + 1;
        var ayahNo  = Math.floor(Math.random() * surahMaxAyah[surahNo - 1]) + 1;
        var ctrl    = new AbortController();
        var tId     = setTimeout(function(){ ctrl.abort(); }, 10000);
        fetch('https://quran-api-id.vercel.app/surah/' + surahNo + '/' + ayahNo, { signal: ctrl.signal })
            .then(function(r){ clearTimeout(tId); return r.json(); })
            .then(function(json){
                if (json.code === 200 && json.data) {
                    retryCount = 0;
                    var d = json.data;
                    var arabText  = d.text && d.text.arab ? d.text.arab : '';
                    var idText    = d.translation && d.translation.id ? d.translation.id : '';
                    var surahName = (d.surah && d.surah.name && d.surah.name.transliteration)
                                  ? 'QS. ' + d.surah.name.transliteration.id
                                  : 'QS. Surah ' + surahNo;
                    var fullRef   = surahName + ': ' + ayahNo;
                    fadeOut(function(){
                        applyContent(arabText, idText, surahName, fullRef);
                    });
                } else { throw new Error('Invalid response'); }
            })
            .catch(function(e){
                retryCount++;
                var msg = e.name === 'AbortError'
                    ? 'Timeout memuat ayat. Mencoba lagi... (' + retryCount + '/' + MAX_RETRY + ')'
                    : (e.message === 'Failed to fetch'
                        ? 'Koneksi terputus. Mencoba lagi... (' + retryCount + '/' + MAX_RETRY + ')'
                        : 'Gagal memuat ayat. Mencoba lagi... (' + retryCount + '/' + MAX_RETRY + ')');
                fadeOut(function(){ showError(msg); fadeIn(); scheduleRetry(3000); });
            })
            .finally(function(){ isFetching = false; });
    }

    function fetchContent() {
        if (isFetching) return;
        isFetching = true;
        if (contentType === 'quran') { fetchRandomAyah(); } else { fetchRandomHadith(); }
    }

    /* Toggle expand/collapse */
    document.addEventListener('click', function(e){
        if (e.target.closest('#adm-hq-toggle')) {
            e.preventDefault();
            var wrapper   = getEl('adm-hq-wrapper');
            var toggleTxt = getEl('adm-hq-toggle-text');
            var icon      = getEl('adm-hq-toggle-icon');
            if (wrapper) {
                var exp = wrapper.classList.toggle('expanded');
                if (toggleTxt) toggleTxt.textContent = exp ? 'Sembunyikan' : 'Lihat Selengkapnya';
                if (icon)      icon.style.transform  = exp ? 'rotate(180deg)' : '';
            }
        }
        /* Manual refresh button */
        if (e.target.closest('#adm-hq-refresh')) {
            e.preventDefault();
            retryCount = 0;
            if (retryTimeout) clearTimeout(retryTimeout);
            contentType = (Math.random() < 0.5) ? 'hadith' : 'quran';
            fetchContent();
        }
    });

    document.addEventListener('DOMContentLoaded', function(){
        fetchContent();
        startCountdown();
        window.addEventListener('resize', checkOverflow);
    });
})();
</script>
@endsection
