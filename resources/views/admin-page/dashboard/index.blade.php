@extends('admin-page.template.body')

@section('content')
<!-- Dashboard Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4 mb-3">
        @php
            $widgets = [
                ['icon' => 'fa-users', 'title' => 'Users', 'count' => $userCount],
                ['icon' => 'fa-calendar-check', 'title' => 'Events', 'count' => $eventCount],
                ['icon' => 'fa-book-open', 'title' => 'Articles', 'count' => $articleCount],
                ['icon' => 'fa-newspaper', 'title' => 'News', 'count' => $newsCount],
                ['icon' => 'fa-link', 'title' => 'Shortlinks', 'count' => $shortLinkCount],
                ['icon' => 'fa-eye', 'title' => 'Visitors', 'count' => $visitorCount],
            ];
        @endphp
        @foreach ($widgets as $widget)
        <div class="col-sm-6 col-xl-4">
            <div class="bg-white shadow-sm rounded p-4 text-center">
                <i class="fa {{ $widget['icon'] }} fa-3x text-primary mb-2"></i>
                <h6 class="mb-1">{{ $widget['title'] }}</h6>
                <h5 class="mb-0 font-weight-bold">{{ $widget['count'] }}</h5>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Prayer Times -->
    <div class="row mb-3">
        <div class="col-sm-12 col-xl-12">
            <div class="bg-white shadow-sm rounded p-4">
                <h4 class="text-center mb-3">Prayer Times - Jakarta</h4>
                <div class="row text-center">
                    @php
                        $prayers = ['Imsak', 'Subuh', 'Dzuhur', 'Ashar', 'Maghrib', 'Isya'];
                        $icons = ['fa-moon', 'fa-sun', 'fa-sun', 'fa-cloud-sun', 'fa-moon', 'fa-star'];
                    @endphp
                    @foreach ($prayers as $index => $name)
                        <div class="col-2">
                            <div class="bg-light shadow-sm rounded p-3">
                                <i class="fa {{ $icons[$index] }} fa-2x text-primary mb-2"></i>
                                <h6 class="mb-1">{{ $name }}</h6>
                                <p class="mb-0 text-muted">{{ $prayerTimes[strtolower($name)] ?? '-' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Calendar -->
        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="bg-white shadow-sm rounded p-4">
                <h4 class="text-center mb-3">Calendar</h4>
                <div id="calender"></div>
            </div>
        </div>

        <!-- Location -->
        <div class="col-sm-12 col-xl-6">
            <div class="bg-white shadow-sm rounded p-4">
                <h4 class="text-center mb-3">Location</h4>
                <iframe class="position-relative rounded w-100 h-100"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6773009952885!2d106.75319361449397!3d-6.306059963469107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efd9636c9d6b%3A0x71fbe6e9045945ff!2sLDK%20Syahid%20UIN%20Syarif%20Hidayatullah%20Jakarta!5e0!3m2!1sen!2sid!4v1664242233249!5m2!1sen!2sid"
                    frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                    tabindex="0"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Dashboard End -->
@endsection
