@extends('admin-page.template.body')

@section('content')
<!-- Widgets Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-users fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Users</p>
                    <h6 class="mb-0">{{ $userCount }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-calendar-check fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Events</p>
                    <h6 class="mb-0">{{ $eventCount }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-book-open fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Articles</p>
                    <h6 class="mb-0">{{ $articleCount }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-newspaper fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">News</p>
                    <h6 class="mb-0">{{ $newsCount }}</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-6">
            <div class="h-150 bg-light rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Calendar</h6>
                </div>
                <div id="calender"></div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <iframe class="position-relative rounded w-100 h-100"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6773009952885!2d106.75319361449397!3d-6.306059963469107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efd9636c9d6b%3A0x71fbe6e9045945ff!2sLDK%20Syahid%20UIN%20Syarif%20Hidayatullah%20Jakarta!5e0!3m2!1sen!2sid!4v1664242233249!5m2!1sen!2sid"
                frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                tabindex="0"></iframe>
            </div>
        </div>
    </div>
</div>
<!-- Widgets End -->
@endsection
