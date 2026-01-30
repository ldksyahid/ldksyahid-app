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

    /* Widget Cards */
    .widget-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }
    .widget-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 167, 157, 0.2) !important;
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

            <!-- Statistics Widgets -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-chart-bar me-2"></i>Statistics Overview</h5>
                        @php
                            $widgets = [
                                ['icon' => 'fa-users', 'title' => 'Users', 'count' => $userCount],
                                ['icon' => 'fa-calendar-check', 'title' => 'Events', 'count' => $eventCount],
                                ['icon' => 'fa-book-open', 'title' => 'Articles', 'count' => $articleCount],
                                ['icon' => 'fa-newspaper', 'title' => 'News', 'count' => $newsCount],
                                ['icon' => 'fa-link', 'title' => 'Shortlinks', 'count' => $shortLinkCount],
                                ['icon' => 'fa-id-card', 'title' => 'ID Cards', 'count' => $idCardCount],
                            ];
                        @endphp
                        <div class="row g-3">
                            @foreach ($widgets as $widget)
                            <div class="col-6 col-md-4 col-lg-2">
                                <div class="widget-card bg-white border shadow-sm p-3 text-center">
                                    <div class="widget-icon mx-auto mb-2">
                                        <i class="fa {{ $widget['icon'] }}"></i>
                                    </div>
                                    <div class="widget-count">{{ $widget['count'] }}</div>
                                    <div class="widget-label">{{ $widget['title'] }}</div>
                                </div>
                            </div>
                            @endforeach
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
