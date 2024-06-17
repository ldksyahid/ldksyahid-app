<!-- Sidebar Start -->
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
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
                    <img class="rounded-circle" src="https://lh3.google.com/u/0/d/{{Auth::User()->profile->gdrive_id}}" alt="{{Auth::User()->profile->namapanggilan}}" style="width: 40px; height: 40px;">
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
                <a href="/admin/dashboard" class="nav-item nav-link {{($title === "Dashboard") ? "active" : ""}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="/admin/user" class="nav-item nav-link {{($title === "User") ? "active" : ""}}"><i class="fa fa-users me-2"></i>User</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Home") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/jumbotron" class="dropdown-item">&#10070; Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item">&#10070; Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{($title === "Event") ? "active" : ""}}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <a href="/admin/article" class="nav-item nav-link {{($title === "Article") ? "active" : ""}}"><i class="fas fa-book-open me-2"></i>Article</a>
                <a href="/admin/schedule" class="nav-item nav-link {{($title === "Schedule") ? "active" : ""}}"><i class="fa fa-list-alt me-2"></i>Schedule</a>
                <a href="/admin/news" class="nav-item nav-link {{($title === "News") ? "active" : ""}}"><i class="fa fa-newspaper me-2"></i>News</a>
                <div class="nav-item dropdown">
                    <a href="/admin/service/celengansyahid" class="nav-link dropdown-toggle {{($title === "Celengan Syahid") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-donate me-2"></i>Celsyahid</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/celengansyahid/dashboard" class="dropdown-item">&#10070; Dashboard</a>
                        <a href="/admin/service/celengansyahid/campaigns" class="dropdown-item">&#10070; Campaign</a>
                        <a href="/admin/service/celengansyahid/donations" class="dropdown-item">&#10070; Donation</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "About Us") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-hand-holding-heart me-2"></i>About Us</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/about/contact/message" class="dropdown-item">&#10070; Contact Us Message</a>
                        <a href="/admin/about/structure" class="dropdown-item">&#10070; Structure</a>
                        <a href="/admin/about/gallery" class="dropdown-item">&#10070; Gallery</a>
                        <a href="/admin/about/itsupport" class="dropdown-item">&#10070; IT Support</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/shortlink" class="dropdown-item">&#10070; Shortlink</a>
                        <a href="/admin/service/callkestari" class="dropdown-item">&#10070; Call Kestari</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Request Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-bullhorn me-2"></i>Req Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/reqservice/shortlink" class="dropdown-item">&#10070; Request Shortlink</a>
                    </div>
                </div>
                <a href="/admin/ktaldksyahid" class="nav-item nav-link {{($title === "KTA") ? "active" : ""}}"><i class="fa fa-id-card me-2"></i>KTA LDK Syahid</a>
            </div>

        {{-- HelperAdmin Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperAdmin')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{($title === "Dashboard") ? "active" : ""}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Home") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/jumbotron" class="dropdown-item">&#10070; Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item">&#10070; Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{($title === "Event") ? "active" : ""}}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/shortlink" class="dropdown-item">&#10070; Shortlink</a>
                    </div>
                </div>
            </div>

        {{-- HelperCelsyahid Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperCelsyahid')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{($title === "Dashboard") ? "active" : ""}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Home") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/jumbotron" class="dropdown-item">&#10070; Jumbotron</a>
                    </div>
                </div>
                <a href="/admin/article" class="nav-item nav-link {{($title === "Article") ? "active" : ""}}"><i class="fas fa-book-open me-2"></i>Article</a>
                <a href="/admin/news" class="nav-item nav-link {{($title === "News") ? "active" : ""}}"><i class="fa fa-newspaper me-2"></i>News</a>
                <a href="/admin/event" class="nav-item nav-link {{($title === "Event") ? "active" : ""}}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <div class="nav-item dropdown">
                    <a href="/admin/service/celengansyahid" class="nav-link dropdown-toggle {{($title === "Celengan Syahid") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-donate me-2"></i>Celsyahid</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/celengansyahid/dashboard" class="dropdown-item">&#10070; Dashboard</a>
                        <a href="/admin/service/celengansyahid/campaigns" class="dropdown-item">&#10070; Campaign</a>
                        <a href="/admin/service/celengansyahid/donations" class="dropdown-item">&#10070; Donation</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/shortlink" class="dropdown-item">&#10070; Shortlink</a>
                    </div>
                </div>
            </div>

        {{-- HelperLetter Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperLetter')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{($title === "Dashboard") ? "active" : ""}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/shortlink" class="dropdown-item">&#10070; Shortlink</a>
                        <a href="/admin/service/callkestari" class="dropdown-item">&#10070; Call Kestari</a>
                    </div>
                </div>
                <a href="/admin/ktaldksyahid" class="nav-item nav-link {{($title === "KTA") ? "active" : ""}}"><i class="fa fa-id-card me-2"></i>KTA LDK Syahid</a>
            </div>

        {{-- HelperEventMart Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperEventMart')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{($title === "Dashboard") ? "active" : ""}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Home") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/jumbotron" class="dropdown-item">&#10070; Jumbotron</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/shortlink" class="dropdown-item">&#10070; Shortlink</a>
                    </div>
                </div>
            </div>

        {{-- HelperSPAM Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperSPAM')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{($title === "Dashboard") ? "active" : ""}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Home") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/jumbotron" class="dropdown-item">&#10070; Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item">&#10070; Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{($title === "Event") ? "active" : ""}}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <a href="/admin/schedule" class="nav-item nav-link {{($title === "Schedule") ? "active" : ""}}"><i class="fa fa-list-alt me-2"></i>Schedule</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "About Us") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-hand-holding-heart me-2"></i>About Us</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/about/contact/message" class="dropdown-item">&#10070; Contact Us Message</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/shortlink" class="dropdown-item">&#10070; Shortlink</a>
                    </div>
                </div>
            </div>

        {{-- HelperMedia Sidebar --}}
        @elseif (LFC::getRoleName(auth()->user()->getRoleNames()) == 'HelperMedia')
            <div class="navbar-nav w-100">
                <a href="/admin/dashboard" class="nav-item nav-link {{($title === "Dashboard") ? "active" : ""}}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Home") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-home me-2"></i>Home</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/jumbotron" class="dropdown-item">&#10070; Jumbotron</a>
                        <a href="/admin/testimony" class="dropdown-item">&#10070; Testimony</a>
                    </div>
                </div>
                <a href="/admin/event" class="nav-item nav-link {{($title === "Event") ? "active" : ""}}"><i class="fas fa-calendar-check me-2"></i>Event</a>
                <a href="/admin/article" class="nav-item nav-link {{($title === "Article") ? "active" : ""}}"><i class="fas fa-book-open me-2"></i>Article</a>
                <a href="/admin/schedule" class="nav-item nav-link {{($title === "Schedule") ? "active" : ""}}"><i class="fa fa-list-alt me-2"></i>Schedule</a>
                <a href="/admin/news" class="nav-item nav-link {{($title === "News") ? "active" : ""}}"><i class="fa fa-newspaper me-2"></i>News</a>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "About Us") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-hand-holding-heart me-2"></i>About Us</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/about/contact/message" class="dropdown-item">&#10070; Contact Us Message</a>
                        <a href="/admin/about/structure" class="dropdown-item">&#10070; Structure</a>
                        <a href="/admin/about/gallery" class="dropdown-item">&#10070; Gallery</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fas fa-tools me-2"></i>Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/service/shortlink" class="dropdown-item">&#10070; Shortlink</a>
                        <a href="/admin/service/callkestari" class="dropdown-item">&#10070; Call Kestari</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="/admin" class="nav-link dropdown-toggle {{($title === "Request Services") ? "active" : ""}}" data-bs-toggle="dropdown"><i class="fa fa-bullhorn me-2"></i>Req Service</a>
                    <div class="dropdown-menu bg-transparent border-0">
                        <a href="/admin/reqservice/shortlink" class="dropdown-item">&#10070; Request Shortlink</a>
                    </div>
                </div>
            </div>
        @endif
    </nav>
</div>
<!-- Sidebar End -->
