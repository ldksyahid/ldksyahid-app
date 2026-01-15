<!-- Navbar Start -->
@php
    // Define submenu mappings based on URL path
    $submenuMap = [
        // Service submenus
        'admin/service/shortlink' => ['parent' => 'Service', 'parentIcon' => 'fa-tools', 'name' => 'Shortlink', 'icon' => 'fa-link'],
        'admin/service/callkestari' => ['parent' => 'Service', 'parentIcon' => 'fa-tools', 'name' => 'Call Kestari', 'icon' => 'fa-phone'],

        // Celsyahid submenus
        'admin/service/celengansyahid/dashboard' => ['parent' => 'Celsyahid', 'parentIcon' => 'fa-donate', 'name' => 'Dashboard', 'icon' => 'fa-tachometer-alt'],
        'admin/service/celengansyahid/campaigns' => ['parent' => 'Celsyahid', 'parentIcon' => 'fa-donate', 'name' => 'Campaign', 'icon' => 'fa-bullhorn'],
        'admin/service/celengansyahid/donations' => ['parent' => 'Celsyahid', 'parentIcon' => 'fa-donate', 'name' => 'Donation', 'icon' => 'fa-hand-holding-usd'],

        // Home submenus
        'admin/jumbotron' => ['parent' => 'Home', 'parentIcon' => 'fa-home', 'name' => 'Jumbotron', 'icon' => 'fa-images'],
        'admin/testimony' => ['parent' => 'Home', 'parentIcon' => 'fa-home', 'name' => 'Testimony', 'icon' => 'fa-quote-right'],

        // About Us submenus
        'admin/about/contact/message' => ['parent' => 'About Us', 'parentIcon' => 'fa-hand-holding-heart', 'name' => 'Contact Message', 'icon' => 'fa-envelope'],
        'admin/about/structure' => ['parent' => 'About Us', 'parentIcon' => 'fa-hand-holding-heart', 'name' => 'Structure', 'icon' => 'fa-sitemap'],
        'admin/about/gallery' => ['parent' => 'About Us', 'parentIcon' => 'fa-hand-holding-heart', 'name' => 'Gallery', 'icon' => 'fa-images'],
        'admin/about/itsupport' => ['parent' => 'About Us', 'parentIcon' => 'fa-hand-holding-heart', 'name' => 'IT Support', 'icon' => 'fa-headset'],

        // Req Service submenus
        'admin/reqservice/shortlink' => ['parent' => 'Req Service', 'parentIcon' => 'fa-bullhorn', 'name' => 'Request Shortlink', 'icon' => 'fa-link'],

        // Reports submenus
        'admin/finance-report' => ['parent' => 'Reports', 'parentIcon' => 'fa-file-alt', 'name' => 'Finance Report', 'icon' => 'fa-file-invoice-dollar'],
    ];

    // Main pages (no parent)
    $mainPages = [
        'admin/dashboard' => ['name' => 'Dashboard', 'icon' => 'fa-tachometer-alt'],
        'admin/user' => ['name' => 'User', 'icon' => 'fa-users'],
        'admin/event' => ['name' => 'Event', 'icon' => 'fa-calendar-check'],
        'admin/article' => ['name' => 'Article', 'icon' => 'fa-book-open'],
        'admin/schedule' => ['name' => 'Schedule', 'icon' => 'fa-list-alt'],
        'admin/news' => ['name' => 'News', 'icon' => 'fa-newspaper'],
        'admin/ktaldksyahid' => ['name' => 'KTA LDK Syahid', 'icon' => 'fa-id-card'],
        'admin/catalog/books' => ['name' => 'Book Catalog', 'icon' => 'fa-book'],
    ];

    // Get current path
    $currentPath = request()->path();

    // Find matching submenu or main page
    $breadcrumb = null;

    // Check submenus first (more specific paths)
    foreach ($submenuMap as $path => $info) {
        if (str_starts_with($currentPath, $path)) {
            $breadcrumb = [
                'hasParent' => true,
                'parent' => $info['parent'],
                'parentIcon' => $info['parentIcon'],
                'name' => $info['name'],
                'icon' => $info['icon'],
            ];
            break;
        }
    }

    // If no submenu found, check main pages
    if (!$breadcrumb) {
        foreach ($mainPages as $path => $info) {
            if (str_starts_with($currentPath, $path)) {
                $breadcrumb = [
                    'hasParent' => false,
                    'name' => $info['name'],
                    'icon' => $info['icon'],
                ];
                break;
            }
        }
    }

    // Fallback
    if (!$breadcrumb) {
        $breadcrumb = [
            'hasParent' => false,
            'name' => $title ?? 'Admin',
            'icon' => 'fa-file',
        ];
    }
@endphp
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>

    {{-- Breadcrumb --}}
    <div class="d-none d-md-flex align-items-center ms-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 bg-transparent p-0">
                <li class="breadcrumb-item">
                    <a href="/admin/dashboard" class="text-decoration-none">
                        <i class="fa fa-home text-primary"></i>
                    </a>
                </li>
                @if($breadcrumb['hasParent'])
                <li class="breadcrumb-item">
                    <i class="fas {{ $breadcrumb['parentIcon'] }} me-1 text-primary"></i>
                    <span class="text-muted">{{ $breadcrumb['parent'] }}</span>
                </li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas {{ $breadcrumb['icon'] }} me-1 text-primary"></i>
                    <span class="fw-semibold text-dark">{{ $breadcrumb['name'] }}</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="navbar-nav align-items-center ms-auto">
        <div class="nav-item">
            <a href="/" class="nav-link">
                <i class="fa fa-globe me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Website</span>
            </a>
        </div>
        <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                    <img class="rounded-circle me-lg-2" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 40px; height: 40px;">
                @else
                    <img class="rounded-circle me-lg-2" src="https://lh3.googleusercontent.com/d/{{Auth::User()->profile->gdrive_id}}" alt="{{Auth::User()->profile->namapanggilan}}" style="width: 40px; height: 40px;">
                @endif
                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                <a href="/profile" class="dropdown-item">Profil Aku</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Keluar') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->
