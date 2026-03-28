<!-- Sidebar Start -->
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;

    // Helper function to check if current route matches
    $isActive = function($path) {
        return request()->is($path) || request()->is($path . '/*');
    };

    // Helper function for dropdown active state
    $isDropdownActive = function($paths) use ($isActive) {
        foreach ($paths as $path) {
            if ($isActive($path)) return true;
        }
        return false;
    };
@endphp
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="/" class="navbar-brand mx-4 mb-3 mt-2">
            <h5 class="text-primary"><i class="fa fa-hashtag me-2"></i>KitaAdalahSaudara</h5>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                    <img class="rounded-circle" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 40px; height: 40px;">
                @else
                    <img class="rounded-circle" src="https://lh3.googleusercontent.com/d/{{Auth::User()->profile->gdrive_id}}" alt="{{Auth::User()->profile->namapanggilan}}" style="width: 40px; height: 40px;">
                @endif
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
                    <i class="badge badge-pill bg-danger">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperAdmin')
                    <i class="badge badge-pill bg-warning">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperCelsyahid')
                    <i class="badge badge-pill bg-success">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperEventMart')
                    <i class="badge badge-pill" style="background-color: #5352ed;">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperSPAM')
                    <i class="badge badge-pill bg-info">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperMedia')
                    <i class="badge badge-pill bg-dark">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperLetter')
                    <i class="badge badge-pill bg-secondary">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'User')
                    <i class="badge badge-pill bg-primary">{{ LFC::getRoleName(auth()->user()->getRoleNames()) }}</i>
                @endif
            </div>
        </div>

        {{-- Superadmin Sidebar --}}
        @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{ $isActive('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="/admin/user" class="nav-item nav-link {{ $isActive('admin/user') ? 'active' : '' }}"><i class="fa fa-users me-2"></i>User</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/jumbotron', 'admin/testimony']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/jumbotron" class="dropdown-item {{ $isActive('admin/jumbotron') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item {{ $isActive('admin/testimony') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{ $isActive('admin/event') ? 'active' : '' }}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <a href="/admin/article" class="nav-item nav-link {{ $isActive('admin/article') ? 'active' : '' }}"><i class="fas fa-book-open me-2"></i>Article</a>
                <a href="/admin/schedule" class="nav-item nav-link {{ $isActive('admin/schedule') ? 'active' : '' }}"><i class="fa fa-list-alt me-2"></i>Schedule</a>
                <a href="/admin/news" class="nav-item nav-link {{ $isActive('admin/news') ? 'active' : '' }}"><i class="fa fa-newspaper me-2"></i>News</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/celengansyahid']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-donate me-2"></i>Celsyahid</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/celengansyahid/dashboard" class="dropdown-item {{ $isActive('admin/service/celengansyahid/dashboard') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Dashboard</a>
                        <a href="/admin/service/celengansyahid/campaigns" class="dropdown-item {{ $isActive('admin/service/celengansyahid/campaigns') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Campaign</a>
                        <a href="/admin/service/celengansyahid/donations" class="dropdown-item {{ $isActive('admin/service/celengansyahid/donations') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Donation</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/about']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-hand-holding-heart me-2"></i>About Us</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/about/contact/message" class="dropdown-item {{ $isActive('admin/about/contact/message') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Contact Us Message</a>
                        <a href="/admin/about/structure" class="dropdown-item {{ $isActive('admin/about/structure') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Structure</a>
                        <a href="/admin/about/gallery" class="dropdown-item {{ $isActive('admin/about/gallery') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Gallery</a>
                        <a href="/admin/about/itsupport" class="dropdown-item {{ $isActive('admin/about/itsupport') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>IT Support</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/shortlink', 'admin/service/callkestari']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/shortlink" class="dropdown-item {{ $isActive('admin/service/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Shortlink</a>
                        <a href="/admin/service/callkestari" class="dropdown-item {{ $isActive('admin/service/callkestari') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Call Kestari</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/reqservice']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-bullhorn me-2"></i>Req Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/reqservice/shortlink" class="dropdown-item {{ $isActive('admin/reqservice/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Request Shortlink</a>
                    </div>
                </div>
                <a href="/admin/ktaldksyahid" class="nav-item nav-link {{ $isActive('admin/ktaldksyahid') ? 'active' : '' }}"><i class="fa fa-id-card me-2"></i>KTA LDK Syahid</a>
                <a href="/admin/catalog/books" class="nav-item nav-link {{ $isActive('admin/catalog/books') ? 'active' : '' }}"><i class="fa fa-book me-2"></i>Book Catalog</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/finance-report']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-file-alt me-2"></i>Reports</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/finance-report" class="dropdown-item {{ $isActive('admin/finance-report') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Finance Report</a>
                    </div>
                </div>
            </div>

        {{-- HelperAdmin Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperAdmin')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{ $isActive('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/jumbotron', 'admin/testimony']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/jumbotron" class="dropdown-item {{ $isActive('admin/jumbotron') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item {{ $isActive('admin/testimony') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{ $isActive('admin/event') ? 'active' : '' }}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/shortlink']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/shortlink" class="dropdown-item {{ $isActive('admin/service/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Shortlink</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/finance-report']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-file-alt me-2"></i>Reports</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/finance-report" class="dropdown-item {{ $isActive('admin/finance-report') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Finance Report</a>
                    </div>
                </div>
            </div>

        {{-- HelperCelsyahid Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperCelsyahid')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{ $isActive('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/jumbotron']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/jumbotron" class="dropdown-item {{ $isActive('admin/jumbotron') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Jumbotron</a>
                    </div>
                </div>
                <a href="/admin/article" class="nav-item nav-link {{ $isActive('admin/article') ? 'active' : '' }}"><i class="fas fa-book-open me-2"></i>Article</a>
                <a href="/admin/news" class="nav-item nav-link {{ $isActive('admin/news') ? 'active' : '' }}"><i class="fa fa-newspaper me-2"></i>News</a>
                <a href="/admin/event" class="nav-item nav-link {{ $isActive('admin/event') ? 'active' : '' }}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/celengansyahid']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-donate me-2"></i>Celsyahid</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/celengansyahid/dashboard" class="dropdown-item {{ $isActive('admin/service/celengansyahid/dashboard') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Dashboard</a>
                        <a href="/admin/service/celengansyahid/campaigns" class="dropdown-item {{ $isActive('admin/service/celengansyahid/campaigns') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Campaign</a>
                        <a href="/admin/service/celengansyahid/donations" class="dropdown-item {{ $isActive('admin/service/celengansyahid/donations') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Donation</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/shortlink']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/shortlink" class="dropdown-item {{ $isActive('admin/service/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Shortlink</a>
                    </div>
                </div>
            </div>

        {{-- HelperLetter Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperLetter')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{ $isActive('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/shortlink', 'admin/service/callkestari']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/shortlink" class="dropdown-item {{ $isActive('admin/service/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Shortlink</a>
                        <a href="/admin/service/callkestari" class="dropdown-item {{ $isActive('admin/service/callkestari') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Call Kestari</a>
                    </div>
                </div>
                <a href="/admin/ktaldksyahid" class="nav-item nav-link {{ $isActive('admin/ktaldksyahid') ? 'active' : '' }}"><i class="fa fa-id-card me-2"></i>KTA LDK Syahid</a>
                <a href="/admin/catalog/books" class="nav-item nav-link {{ $isActive('admin/catalog/books') ? 'active' : '' }}"><i class="fa fa-book me-2"></i>Book Catalog</a>
            </div>

        {{-- HelperEventMart Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperEventMart')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{ $isActive('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/jumbotron']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/jumbotron" class="dropdown-item {{ $isActive('admin/jumbotron') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Jumbotron</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/shortlink']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/shortlink" class="dropdown-item {{ $isActive('admin/service/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Shortlink</a>
                    </div>
                </div>
            </div>

        {{-- HelperSPAM Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperSPAM')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{ $isActive('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/jumbotron', 'admin/testimony']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/jumbotron" class="dropdown-item {{ $isActive('admin/jumbotron') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item {{ $isActive('admin/testimony') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{ $isActive('admin/event') ? 'active' : '' }}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <a href="/admin/schedule" class="nav-item nav-link {{ $isActive('admin/schedule') ? 'active' : '' }}"><i class="fa fa-list-alt me-2"></i>Schedule</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/about']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-hand-holding-heart me-2"></i>About Us</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/about/contact/message" class="dropdown-item {{ $isActive('admin/about/contact/message') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Contact Us Message</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/shortlink']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/shortlink" class="dropdown-item {{ $isActive('admin/service/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Shortlink</a>
                    </div>
                </div>
            </div>

        {{-- HelperMedia Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperMedia')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{ $isActive('admin/dashboard') ? 'active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/jumbotron', 'admin/testimony']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/jumbotron" class="dropdown-item {{ $isActive('admin/jumbotron') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item {{ $isActive('admin/testimony') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{ $isActive('admin/event') ? 'active' : '' }}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <a href="/admin/article" class="nav-item nav-link {{ $isActive('admin/article') ? 'active' : '' }}"><i class="fas fa-book-open me-2"></i>Article</a>
                <a href="/admin/schedule" class="nav-item nav-link {{ $isActive('admin/schedule') ? 'active' : '' }}"><i class="fa fa-list-alt me-2"></i>Schedule</a>
                <a href="/admin/news" class="nav-item nav-link {{ $isActive('admin/news') ? 'active' : '' }}"><i class="fa fa-newspaper me-2"></i>News</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/about']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-hand-holding-heart me-2"></i>About Us</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/about/contact/message" class="dropdown-item {{ $isActive('admin/about/contact/message') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Contact Us Message</a>
                        <a href="/admin/about/structure" class="dropdown-item {{ $isActive('admin/about/structure') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Structure</a>
                        <a href="/admin/about/gallery" class="dropdown-item {{ $isActive('admin/about/gallery') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Gallery</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/service/shortlink', 'admin/service/callkestari']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/service/shortlink" class="dropdown-item {{ $isActive('admin/service/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Shortlink</a>
                        <a href="/admin/service/callkestari" class="dropdown-item {{ $isActive('admin/service/callkestari') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Call Kestari</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/reqservice']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-bullhorn me-2"></i>Req Service</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/reqservice/shortlink" class="dropdown-item {{ $isActive('admin/reqservice/shortlink') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Request Shortlink</a>
                    </div>
                </div>
                <a href="/admin/catalog/books" class="nav-item nav-link {{ $isActive('admin/catalog/books') ? 'active' : '' }}"><i class="fa fa-book me-2"></i>Book Catalog</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle {{ $isDropdownActive(['admin/finance-report']) ? 'active' : '' }}" data-bs-toggle="dropdown"><i class="fa fa-file-alt me-2"></i>Reports</a>
                    <div class="dropdown-menu bg-transparent border-0 ">
                        <a href="/admin/finance-report" class="dropdown-item {{ $isActive('admin/finance-report') ? 'active' : '' }}"><i class="fas fa-angle-right me-2"></i>Finance Report</a>
                    </div>
                </div>
            </div>
        @endif
    </nav>
</div>
<!-- Sidebar End -->

<style>
/* Dark mode sidebar active & click state override */
html.dark-mode .sidebar .navbar .dropdown-item {
    color: #9ca3af;
    background-color: transparent;
}
html.dark-mode .sidebar .navbar .dropdown-item:hover {
    background-color: rgba(255,255,255,0.07) !important;
    color: #e4e6eb !important;
}
html.dark-mode .sidebar .navbar .dropdown-item.active,
html.dark-mode .sidebar .navbar .dropdown-item.active:hover,
html.dark-mode .sidebar .navbar .dropdown-item.active:focus,
html.dark-mode .sidebar .navbar .dropdown-item.active:active,
html.dark-mode .sidebar .navbar .dropdown-item:active {
    background-color: rgba(0,167,157,0.15) !important;
    color: #00a79d !important;
}
</style>

{{-- Script to open dropdowns that have an active submenu --}}
<script>
$(document).ready(function() {
    // Remove Bootstrap data-bs-toggle to prevent conflict
    $('.sidebar .dropdown-toggle').removeAttr('data-bs-toggle');

    // Hide all dropdown menus initially (jQuery will handle display)
    $('.sidebar .dropdown-menu').hide();

    // Custom dropdown handler for sidebar with slide animation
    $('.sidebar .dropdown-toggle').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $this = $(this);
        var $dropdown = $this.closest('.dropdown');
        var $menu = $dropdown.find('.dropdown-menu');
        var isOpen = $menu.hasClass('show');

        // Toggle current dropdown with slide animation
        if (isOpen) {
            $menu.slideUp(250, function() {
                $menu.removeClass('show');
            });
            $this.attr('aria-expanded', 'false');
        } else {
            $menu.addClass('show').hide().slideDown(250);
            $this.attr('aria-expanded', 'true');
        }
    });

    // Open dropdown that has active submenu on page load (no animation)
    $('.sidebar .dropdown-item.active').each(function() {
        var $dropdown = $(this).closest('.dropdown');
        $dropdown.find('.dropdown-menu').addClass('show').show();
        $dropdown.find('.dropdown-toggle').attr('aria-expanded', 'true');
    });
});
</script>
