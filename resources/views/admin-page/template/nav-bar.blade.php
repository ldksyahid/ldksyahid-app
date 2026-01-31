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
        <!-- Dark Mode Toggle -->
        <div class="nav-item d-flex align-items-center me-3">
            <div class="dark-mode-toggle-container">
                <input type="checkbox" id="darkModeSwitch" class="dark-mode-checkbox">
                <label for="darkModeSwitch" class="dark-mode-toggle" title="Toggle Dark Mode" tabindex="0" role="button" aria-label="Toggle dark mode">
                    <div class="toggle-track">
                        <div class="toggle-thumb">
                            <div class="sun-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16">
                                    <path fill="currentColor" d="M12,9c1.65,0,3,1.35,3,3s-1.35,3-3,3s-3-1.35-3-3S10.35,9,12,9z M12,7c-2.76,0-5,2.24-5,5s2.24,5,5,5s5-2.24,5-5 S14.76,7,12,7z M2,13h2c0.55,0,1-0.45,1-1s-0.45-1-1-1H2c-0.55,0-1,0.45-1,1S1.45,13,2,13z M20,13h2c0.55,0,1-0.45,1-1s-0.45-1-1-1 h-2c-0.55,0-1,0.45-1,1S19.45,13,20,13z M11,2v2c0,0.55,0.45,1,1,1s1-0.45,1-1V2c0-0.55-0.45-1-1-1S11,1.45,11,2z M11,20v2 c0,0.55,0.45,1,1,1s1-0.45,1-1v-2c0-0.55-0.45-1-1-1S11,19.45,11,20z M5.99,4.58c-0.39-0.39-1.03-0.39-1.41,0 c-0.39,0.39-0.39,1.03,0,1.41l1.06,1.06c0.39,0.39,1.03,0.39,1.41,0s0.39-1.03,0-1.41L5.99,4.58z M18.36,16.95 c-0.39-0.39-1.03-0.39-1.41,0c-0.39,0.39-0.39,1.03,0,1.41l1.06,1.06c0.39,0.39,1.03,0.39,1.41,0c0.39-0.39,0.39-1.03,0-1.41 L18.36,16.95z M19.42,5.99c0.39-0.39,0.39-1.03,0-1.41c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06c-0.39,0.39-0.39,1.03,0,1.41 s1.03,0.39,1.41,0L19.42,5.99z M7.05,18.36c0.39-0.39,0.39-1.03,0-1.41c-0.39-0.39-1.03-0.39-1.41,0l-1.06,1.06 c-0.39,0.39-0.39,1.03,0,1.41s1.03,0.39,1.41,0L7.05,18.36z"></path>
                                </svg>
                            </div>
                            <div class="moon-icon">
                                <svg viewBox="0 0 24 24" width="16" height="16">
                                    <path fill="currentColor" d="M9.37,5.51C9.19,6.15,9.1,6.82,9.1,7.5c0,4.08,3.32,7.4,7.4,7.4c0.68,0,1.35-0.09,1.99-0.27C17.45,17.19,14.93,19,12,19 c-3.86,0-7-3.14-7-7C5,9.07,6.81,6.55,9.37,5.51z M12,3c-4.97,0-9,4.03-9,9s4.03,9,9,9s9-4.03,9-9c0-0.46-0.04-0.92-0.1-1.36 c-0.98,1.37-2.58,2.26-4.4,2.26c-2.98,0-5.4-2.42-5.4-5.4c0-1.81,0.89-3.42,2.26-4.4C12.92,3.04,12.46,3,12,3L12,3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>

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
