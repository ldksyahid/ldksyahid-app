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

        // Email Config submenus
        'admin/subscription' => ['parent' => 'Email Config', 'parentIcon' => 'fa-paper-plane', 'name' => 'Subscription', 'icon' => 'fa-envelope'],
        'admin/email-config/generate' => ['parent' => 'Email Config', 'parentIcon' => 'fa-paper-plane', 'name' => 'Generate Email', 'icon' => 'fa-pen-to-square'],
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
        <!-- Prayer Button -->
        <div class="nav-item d-flex align-items-center">
            <button class="btn-prayer-navbar" id="prayerNavBtn">
                <span class="prayer-nav-icon-wrap"><i class="fas fa-mosque"></i></span>
                <span class="prayer-nav-text">
                    <span class="prayer-nav-label" id="prayerNavName">Prayer</span>
                    <span class="prayer-nav-time-display" id="prayerNavTime">--:--</span>
                </span>
            </button>
        </div>

        <!-- Dark Mode Toggle -->
        <div class="nav-item d-flex align-items-center">
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
            <div class="dropdown-menu dropdown-menu-end bg-light border-0 m-0 dropdown-profile">
                <a href="/profile" class="dropdown-item">My Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
<!-- Navbar End -->

{{-- Prayer Modal --}}
<div class="prayer-modal-overlay" id="prayerModalOverlay">
    <div class="prayer-modal" id="prayerModal">
        <div class="prayer-modal-hero">
            <div class="prayer-hero-blob prayer-hero-blob-1"></div>
            <div class="prayer-hero-blob prayer-hero-blob-2"></div>
            <div class="prayer-hero-blob prayer-hero-blob-3"></div>
            <div class="prayer-hero-silhouette"><i class="fas fa-mosque"></i></div>
            <div class="prayer-hero-star s1"></div>
            <div class="prayer-hero-star s2"></div>
            <div class="prayer-hero-star s3"></div>
            <button class="prayer-modal-close" id="prayerModalClose">&times;</button>
            <div class="prayer-modal-icon"><i class="fas fa-mosque"></i></div>
            <div class="prayer-live-clock">
                <div class="prayer-time-wrap">
                    <span class="prayer-tz-badge">
                        <span class="prayer-tz-live-dot"></span>
                        WIB
                    </span>
                    <span id="prayerCurrentTime">--:--:--</span>
                </div>
            </div>
            <h3 class="prayer-modal-title">Today's Prayer Schedule</h3>
            <p class="prayer-modal-date" id="prayerModalDate"></p>
            <p class="prayer-modal-location" id="prayerModalLocation">Jakarta & Surrounding Area</p>
        </div>
        <div class="prayer-list" id="prayerModalBody">
            <div class="prayer-modal-loading">
                <i class="fas fa-spinner"></i>
                <p>Loading prayer schedule...</p>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== RIGHT NAVBAR UNIFORM SPACING & ALIGNMENT ===== */
.content .navbar .navbar-nav.ms-auto {
    gap: 4px;
    align-items: center;
}
.content .navbar .navbar-nav.ms-auto > .nav-item {
    display: flex !important;
    align-items: center !important;
    align-self: center !important;
}
.content .navbar .navbar-nav.ms-auto > .nav-item > .nav-link {
    margin-left: 0 !important;
    padding-left: 8px !important;
    padding-right: 8px !important;
    display: flex !important;
    align-items: center !important;
}
.dark-mode-toggle-container {
    display: flex !important;
    align-items: center;
}

/* ===== PRAYER BUTTON ===== */
.btn-prayer-navbar {
    display: flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0 0.8rem;
    height: 36px;
    background: rgba(0,167,157,0.08);
    border: 1px solid rgba(0,167,157,0.22);
    outline: none;
    border-radius: 10px;
    color: #00a79d;
    cursor: pointer;
    transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
    white-space: nowrap;
    font-family: inherit;
    line-height: 1;
    text-align: left;
}
.btn-prayer-navbar:hover {
    background: rgba(0,167,157,0.15);
    border-color: rgba(0,167,157,0.4);
    color: #007a73;
}
.btn-prayer-navbar:focus { box-shadow: none; outline: none; }
.prayer-nav-icon-wrap {
    font-size: 1rem;
    line-height: 1;
    flex-shrink: 0;
}
.prayer-nav-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}
.prayer-nav-label {
    font-size: 0.6rem;
    font-weight: 500;
    opacity: 0.7;
}
.prayer-nav-time-display {
    font-size: 0.8rem;
    font-weight: 700;
}

/* ===== PRAYER MODAL ===== */
.prayer-modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.55);
    backdrop-filter: blur(6px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}
.prayer-modal-overlay.active { opacity: 1; visibility: visible; }
.prayer-modal {
    background: white;
    border-radius: 24px;
    width: 100%;
    max-width: 390px;
    max-height: 90vh;
    overflow-y: auto;
    overflow-x: hidden;
    position: relative;
    transform: scale(0.88) translateY(24px);
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 30px 70px rgba(0,0,0,0.2);
}
.prayer-modal-overlay.active .prayer-modal { transform: scale(1) translateY(0); }
.prayer-modal-hero {
    position: relative;
    background: linear-gradient(145deg, #00a79d 0%, #007b73 60%, #005f5a 100%);
    border-radius: 22px 22px 0 0;
    padding: 2rem 1.5rem 1.75rem;
    text-align: center;
    overflow: hidden;
}
.prayer-hero-silhouette {
    position: absolute; bottom: -25px; right: -20px;
    font-size: 9rem; color: rgba(255,255,255,0.09);
    pointer-events: none; line-height: 1;
    animation: silhouetteFloat 5s ease-in-out infinite;
}
@keyframes silhouetteFloat {
    0%, 100% { transform: translateY(0) scale(1); }
    50%       { transform: translateY(-10px) scale(1.03); }
}
.prayer-hero-blob { position: absolute; border-radius: 50%; pointer-events: none; background: rgba(255,255,255,0.07); }
.prayer-hero-blob-1 { width: 160px; height: 160px; top: -65px; left: -50px; animation: blob1Float 9s ease-in-out infinite; }
.prayer-hero-blob-2 { width: 100px; height: 100px; top: 10px; right: -10px; background: rgba(255,255,255,0.05); animation: blob2Float 7s ease-in-out infinite; }
.prayer-hero-blob-3 { width: 55px; height: 55px; bottom: 15px; left: 15%; background: rgba(255,255,255,0.06); animation: blob3Float 11s ease-in-out infinite; }
@keyframes blob1Float { 0%, 100% { transform: translate(0,0) scale(1); } 33% { transform: translate(12px,15px) scale(1.06); } 66% { transform: translate(-8px,8px) scale(0.95); } }
@keyframes blob2Float { 0%, 100% { transform: translate(0,0) scale(1); } 50% { transform: translate(-12px,18px) scale(1.08); } }
@keyframes blob3Float { 0%, 100% { transform: translate(0,0) scale(1); } 50% { transform: translate(10px,-14px) scale(1.1); } }
.prayer-hero-star { position: absolute; border-radius: 50%; background: rgba(255,255,255,0.6); pointer-events: none; animation: starTwinkle 2.5s ease-in-out infinite; }
.prayer-hero-star.s1 { width: 4px; height: 4px; top: 18%; left: 12%; animation-delay: 0s; }
.prayer-hero-star.s2 { width: 3px; height: 3px; top: 30%; right: 18%; animation-delay: 0.8s; }
.prayer-hero-star.s3 { width: 5px; height: 5px; bottom: 22%; left: 40%; animation-delay: 1.5s; }
@keyframes starTwinkle { 0%, 100% { transform: scale(1); opacity: 0.7; } 50% { transform: scale(1.8); opacity: 0.2; } }
.prayer-modal-close {
    position: absolute; top: 0.85rem; right: 0.85rem;
    width: 30px; height: 30px;
    background: rgba(255,255,255,0.2); border: none; border-radius: 50%;
    font-size: 1.2rem; line-height: 1; cursor: pointer; color: white;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s ease; z-index: 5; backdrop-filter: blur(4px);
}
.prayer-modal-close:hover { background: rgba(255,255,255,0.35); transform: scale(1.1); }
.prayer-modal-icon {
    width: 72px; height: 72px;
    background: rgba(255,255,255,0.18); border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 0.8rem; font-size: 1.9rem; color: white;
    border: 2px solid rgba(255,255,255,0.3);
    position: relative; z-index: 2;
    animation: iconPulseGlow 3s ease-in-out infinite;
}
@keyframes iconPulseGlow { 0%, 100% { box-shadow: 0 0 0 0 rgba(255,255,255,0.2); } 50% { box-shadow: 0 0 0 10px rgba(255,255,255,0); } }
.prayer-live-clock { display: flex; justify-content: center; margin-bottom: 0.6rem; position: relative; z-index: 2; }
.prayer-time-wrap { position: relative; display: inline-flex; align-items: center; justify-content: center; padding-top: 1.6rem; }
#prayerCurrentTime { font-size: 2.2rem; font-weight: 700; color: white; letter-spacing: 0.04em; font-family: 'Courier New', monospace; text-shadow: 0 2px 12px rgba(0,0,0,0.2); line-height: 1; }
.prayer-tz-badge {
    position: absolute; top: 0;
    display: inline-flex; align-items: center; gap: 0.28rem;
    font-size: 0.62rem; font-weight: 800; color: white;
    background: linear-gradient(135deg, rgba(255,255,255,0.25) 0%, rgba(255,255,255,0.1) 100%);
    border: 1px solid rgba(255,255,255,0.45);
    padding: 0.17rem 0.5rem 0.17rem 0.38rem;
    border-radius: 20px; letter-spacing: 0.1em; backdrop-filter: blur(8px);
}
.prayer-tz-live-dot {
    width: 6px; height: 6px; border-radius: 50%; background: #7fffd4; flex-shrink: 0;
    box-shadow: 0 0 5px rgba(127,255,212,0.8);
    animation: tzDotPulse 1.6s ease-in-out infinite;
}
@keyframes tzDotPulse { 0%, 100% { opacity: 1; transform: scale(1); } 50% { opacity: 0.55; transform: scale(0.7); } }
.prayer-modal-title { font-size: 1.2rem; font-weight: 700; color: white; margin: 0 0 0.3rem; position: relative; z-index: 2; }
.prayer-modal-date { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.9); margin: 0 0 0.2rem; position: relative; z-index: 2; }
.prayer-modal-location { font-size: 0.78rem; color: rgba(255,255,255,0.65); margin: 0; position: relative; z-index: 2; }
.prayer-list { display: flex; flex-direction: column; gap: 0.45rem; padding: 1.1rem 1.25rem 1.5rem; }
.prayer-item { display: flex; align-items: center; gap: 0.75rem; padding: 0.7rem 1rem; background: #f8fafb; border-radius: 12px; transition: all 0.2s ease; }
.prayer-item.next-prayer { background: rgba(0,167,157,0.1); }
.prayer-item-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(0,167,157,0.25); border: 2px solid #00a79d; flex-shrink: 0; }
.prayer-item.next-prayer .prayer-item-dot { background: #00a79d; animation: pulseDot 1.6s ease-in-out infinite; }
@keyframes pulseDot { 0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0,167,157,0.45); } 50% { transform: scale(1.15); box-shadow: 0 0 0 6px rgba(0,167,157,0); } }
.prayer-item-name { flex: 1; font-weight: 500; font-size: 0.88rem; color: #333; }
.prayer-item.next-prayer .prayer-item-name { color: #00a79d; font-weight: 700; }
.prayer-next-badge { font-size: 0.62rem; background: #00a79d; color: white; padding: 0.12rem 0.45rem; border-radius: 20px; font-weight: 600; }
.prayer-item-time { font-weight: 600; font-size: 0.88rem; color: #333; min-width: 40px; text-align: right; }
.prayer-item.next-prayer .prayer-item-time { color: #00a79d; font-weight: 700; }
.prayer-modal-loading { text-align: center; padding: 2rem 1rem; color: #888; }
.prayer-modal-loading i { font-size: 1.75rem; color: #00a79d; display: block; margin-bottom: 0.5rem; animation: prayerSpin 0.9s linear infinite; }
@keyframes prayerSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.prayer-modal-loading p { font-size: 0.85rem; margin: 0; }

/* Dark Mode */
html.dark-mode .btn-prayer-navbar {
    background: rgba(0,167,157,0.1);
    border-color: rgba(0,167,157,0.28);
    color: #3ecfc6;
}
html.dark-mode .btn-prayer-navbar:hover {
    background: rgba(0,167,157,0.18);
    border-color: rgba(0,167,157,0.45);
    color: #4dd9cf;
}
html.dark-mode .prayer-modal { background: #1a1f2e; box-shadow: 0 30px 70px rgba(0,0,0,0.6); }
html.dark-mode .prayer-item { background: #252b3b; }
html.dark-mode .prayer-item.next-prayer { background: rgba(0,167,157,0.15); }
html.dark-mode .prayer-item-name { color: #e2e8f0; }
html.dark-mode .prayer-item-time { color: #e2e8f0; }
html.dark-mode .prayer-item.next-prayer .prayer-item-name { color: #4dd9cf; }
html.dark-mode .prayer-item.next-prayer .prayer-item-time { color: #4dd9cf; }
html.dark-mode .prayer-modal-loading { color: #9ca3af; }
</style>

<script>
/* ===== PRAYER TIMES (Admin) ===== */
(function() {
    const CITY_ID = 1301;
    const PRAYERS = [
        { key: 'subuh',   name: 'Subuh'   },
        { key: 'dzuhur',  name: 'Dzuhur'  },
        { key: 'ashar',   name: 'Ashar'   },
        { key: 'maghrib', name: 'Maghrib' },
        { key: 'isya',    name: 'Isya'    },
    ];
    let prayerData = null;
    let prayerClockInterval = null;
    let _prayerTouchLock = null, _prayerWheelLock = null, _prayerKeyLock = null;

    function tickPrayerClock() {
        const el = document.getElementById('prayerCurrentTime');
        if (!el) return;
        const wib = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
        el.textContent = [
            String(wib.getHours()).padStart(2,'0'),
            String(wib.getMinutes()).padStart(2,'0'),
            String(wib.getSeconds()).padStart(2,'0'),
        ].join(':');
    }

    function toMinutes(t) {
        if (!t) return Infinity;
        const [h, m] = t.split(':').map(Number);
        return h * 60 + m;
    }

    function getNextPrayer(jadwal) {
        const now = new Date();
        const cur = now.getHours() * 60 + now.getMinutes();
        for (const p of PRAYERS) {
            if (toMinutes(jadwal[p.key]) > cur) return { ...p, time: jadwal[p.key] };
        }
        return { ...PRAYERS[0], time: jadwal[PRAYERS[0].key] };
    }

    function formatDate(d) {
        const days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    }

    async function fetchPrayerTimes() {
        try {
            const d    = new Date();
            const date = `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`;
            const res  = await fetch(`https://api.myquran.com/v2/sholat/jadwal/${CITY_ID}/${date}`);
            const json = await res.json();
            if (json.status && json.data) {
                prayerData = json.data;
                updatePrayerButton();
            }
        } catch (e) { console.warn('Prayer fetch failed:', e); }
    }

    function updatePrayerButton() {
        if (!prayerData?.jadwal) return;
        const next = getNextPrayer(prayerData.jadwal);
        const navName = document.getElementById('prayerNavName');
        const navTime = document.getElementById('prayerNavTime');
        if (navName) navName.textContent = next.name;
        if (navTime) navTime.textContent = next.time;
    }

    function renderModal() {
        const body  = document.getElementById('prayerModalBody');
        const dateEl = document.getElementById('prayerModalDate');
        const locEl  = document.getElementById('prayerModalLocation');
        if (!body) return;
        if (!prayerData) {
            body.innerHTML = '<div class="prayer-modal-loading"><i class="fas fa-spinner"></i><p>Loading prayer schedule...</p></div>';
            return;
        }
        const jadwal = prayerData.jadwal;
        const next   = getNextPrayer(jadwal);
        if (dateEl) dateEl.textContent = formatDate(new Date());
        if (locEl && prayerData.lokasi) locEl.textContent = prayerData.lokasi + ' & Surrounding Area';
        body.innerHTML = PRAYERS.map(p => {
            const time = jadwal[p.key] || '--:--';
            const isNext = p.key === next.key;
            return `<div class="prayer-item ${isNext ? 'next-prayer' : ''}">
                <div class="prayer-item-dot"></div>
                <span class="prayer-item-name">${p.name}</span>
                ${isNext ? '<span class="prayer-next-badge">Next</span>' : ''}
                <span class="prayer-item-time">${time}</span>
            </div>`;
        }).join('');
    }

    window.openPrayerModal = function() {
        const overlay = document.getElementById('prayerModalOverlay');
        if (!overlay) return;
        renderModal();
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
        _prayerWheelLock = e => e.preventDefault();
        _prayerKeyLock = e => { if ([' ','ArrowUp','ArrowDown','PageUp','PageDown'].includes(e.key)) e.preventDefault(); };
        window.addEventListener('wheel', _prayerWheelLock, { passive: false });
        window.addEventListener('keydown', _prayerKeyLock);
        _prayerTouchLock = e => { if (!document.getElementById('prayerModal')?.contains(e.target)) e.preventDefault(); };
        document.addEventListener('touchmove', _prayerTouchLock, { passive: false });
        tickPrayerClock();
        prayerClockInterval = setInterval(tickPrayerClock, 1000);
    };

    window.closePrayerModal = function() {
        const overlay = document.getElementById('prayerModalOverlay');
        if (!overlay) return;
        overlay.classList.remove('active');
        document.body.style.overflow = '';
        if (_prayerWheelLock) { window.removeEventListener('wheel', _prayerWheelLock); _prayerWheelLock = null; }
        if (_prayerKeyLock)   { window.removeEventListener('keydown', _prayerKeyLock); _prayerKeyLock = null; }
        if (_prayerTouchLock) { document.removeEventListener('touchmove', _prayerTouchLock); _prayerTouchLock = null; }
        clearInterval(prayerClockInterval);
        prayerClockInterval = null;
    };

    fetchPrayerTimes();
    setInterval(updatePrayerButton, 60000);

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('prayerNavBtn')?.addEventListener('click', openPrayerModal);
        document.getElementById('prayerModalClose')?.addEventListener('click', closePrayerModal);
        document.getElementById('prayerModalOverlay')?.addEventListener('click', function(e) {
            if (e.target === this) closePrayerModal();
        });
        document.addEventListener('keydown', e => e.key === 'Escape' && closePrayerModal());
    });
})();
</script>
