@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp

{{-- Navbar Placeholder (maintains space when navbar becomes fixed) --}}
<div class="navbar-placeholder" id="navbarPlaceholder"></div>

{{-- Navbar --}}
<nav class="navbar-floating" id="mainNavbar">
    <div class="navbar-container">
        {{-- Brand --}}
        <a href="/" class="navbar-brand-fun">
            <div class="brand-logo-wrapper">
                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                     class="brand-logo"
                     alt="Logo LDK Syahid">
                <span class="brand-emoji">✨</span>
            </div>
            <div class="brand-text">
                <span class="brand-name">LDK Syahid</span>
                <span class="brand-tagline">UIN Jakarta</span>
            </div>
        </a>

        {{-- Desktop Navigation --}}
        <ul class="nav-menu d-none d-lg-flex">
            <li class="nav-item">
                <a href="/" class="nav-link {{ ($title === "Beranda") ? "active" : "" }}">
                    <span>Beranda</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ ($title === "Tentang Kami") ? "active" : "" }}">
                    <span>Tentang Kami</span>
                </a>
                <ul class="dropdown-menu dropdown-fun">
                    <li><a href="/about/structure" class="dropdown-item"><i class="fas fa-sitemap"></i>Struktur Pengurus</a></li>
                    <li><a href="/about/contact" class="dropdown-item"><i class="fas fa-phone"></i>Hubungi Kami</a></li>
                    <li><a href="/about/gallery" class="dropdown-item"><i class="fas fa-images"></i>Galeri</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="/articles" class="nav-link {{ ($title === "Artikel") ? "active" : "" }}">
                    <span>Artikel</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/news" class="nav-link {{ ($title === "Berita" || (isset($linkTitle) && $title === "Berita : $linkTitle")) ? "active" : "" }}">
                    <span>Berita</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/events" class="nav-link {{ ($title === "Kegiatan") ? "active" : "" }}">
                    <span>Kegiatan</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/perpustakaan" class="nav-link {{ ($title === "Perpustakaan") ? "active" : "" }}">
                    <span>Perpustakaan</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="/service" class="nav-link {{ ($title === "Layanan") ? "active" : "" }}">
                    <span>Layanan</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle {{ ($title === "Lainnya") ? "active" : "" }}">
                    <span>Lainnya</span>
                </a>
                <ul class="dropdown-menu dropdown-fun">
                    <li><a href="/laporan" class="dropdown-item"><i class="fas fa-file-alt"></i>Laporan</a></li>
                    <li><a href="/schedule" class="dropdown-item"><i class="fas fa-calendar-alt"></i>Jadwal</a></li>
                </ul>
            </li>
        </ul>

        {{-- User Section --}}
        <div class="nav-actions d-none d-lg-flex">
            @guest
                <div class="dropdown">
                    <button class="btn-user-fun" data-bs-toggle="dropdown">
                        <i class="fas fa-user-astronaut"></i>
                        <span>Masuk</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-fun">
                        @if (Route::has('login'))
                            <li><a class="dropdown-item" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>Masuk</a></li>
                        @endif
                        @if (Route::has('register'))
                            <li><a class="dropdown-item" href="{{ route('register') }}"><i class="fas fa-user-plus"></i>Daftar</a></li>
                        @endif
                    </ul>
                </div>
            @else
                <div class="dropdown">
                    <button class="btn-user-fun has-avatar" data-bs-toggle="dropdown">
                        @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                            <img class="user-avatar"
                                 src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}"
                                 alt="">
                        @else
                            <img class="user-avatar"
                                 src="https://lh3.googleusercontent.com/d/{{Auth::User()->profile->gdrive_id}}"
                                 alt="">
                        @endif
                        <span>{{ substr(Auth::user()->name, 0, 8) }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-fun">
                        @if (LFC::cekRoleAdmin(auth()->user()))
                            <li><a href="/admin/dashboard" class="dropdown-item"><i class="fas fa-tachometer-alt"></i>Admin Panel</a></li>
                        @endif
                        <li><a href="/profile" class="dropdown-item"><i class="fas fa-user-circle"></i>Profil Aku</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>Keluar
                            </a>
                        </li>
                    </ul>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @endguest
        </div>

        {{-- Mobile Toggle --}}
        <button class="mobile-toggle d-lg-none" id="mobileToggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>

{{-- Mobile Menu --}}
<div class="mobile-menu-overlay" id="mobileOverlay"></div>
<div class="mobile-menu-fun" id="mobileMenu">
    <div class="mobile-menu-header">
        <a href="/" class="mobile-brand">
            <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="Logo">
            <span>LDK Syahid</span>
        </a>
        <button class="mobile-close" id="mobileClose">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="mobile-menu-body">
        @auth
            <div class="mobile-user-card">
                @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                    <img src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="">
                @else
                    <img src="https://lh3.googleusercontent.com/d/{{Auth::User()->profile->gdrive_id}}" alt="">
                @endif
                <div>
                    <span class="name">Halo, {{ Auth::user()->name }}! 👋</span>
                    <span class="email">{{ Auth::user()->email }}</span>
                </div>
            </div>
        @endauth

        <nav class="mobile-nav-fun">
            <a href="/" class="{{ ($title === "Beranda") ? "active" : "" }}"><i class="fas fa-home"></i>Beranda</a>

            <div class="mobile-dropdown">
                <button class="mobile-dropdown-toggle"><i class="fas fa-info-circle"></i>Tentang Kami<i class="fas fa-chevron-down arrow"></i></button>
                <div class="mobile-dropdown-menu">
                    <a href="/about/structure">Struktur Pengurus</a>
                    <a href="/about/contact">Hubungi Kami</a>
                    <a href="/about/gallery">Galeri</a>
                </div>
            </div>

            <a href="/articles" class="{{ ($title === "Artikel") ? "active" : "" }}"><i class="fas fa-newspaper"></i>Artikel</a>
            <a href="/news" class="{{ ($title === "Berita") ? "active" : "" }}"><i class="fas fa-bullhorn"></i>Berita</a>
            <a href="/events" class="{{ ($title === "Kegiatan") ? "active" : "" }}"><i class="fas fa-calendar-check"></i>Kegiatan</a>
            <a href="/perpustakaan" class="{{ ($title === "Perpustakaan") ? "active" : "" }}"><i class="fas fa-book"></i>Perpustakaan</a>
            <a href="/service" class="{{ ($title === "Layanan") ? "active" : "" }}"><i class="fas fa-hands-helping"></i>Layanan</a>

            <div class="mobile-dropdown">
                <button class="mobile-dropdown-toggle"><i class="fas fa-ellipsis-h"></i>Lainnya<i class="fas fa-chevron-down arrow"></i></button>
                <div class="mobile-dropdown-menu">
                    <a href="/laporan">Laporan</a>
                    <a href="/schedule">Jadwal</a>
                </div>
            </div>
        </nav>

        <div class="mobile-actions">
            @guest
                <a href="{{ route('login') }}" class="btn-mobile-primary"><i class="fas fa-sign-in-alt"></i>Masuk</a>
                <a href="{{ route('register') }}" class="btn-mobile-outline"><i class="fas fa-user-plus"></i>Daftar</a>
            @else
                @if (LFC::cekRoleAdmin(auth()->user()))
                    <a href="/admin/dashboard" class="btn-mobile-primary"><i class="fas fa-tachometer-alt"></i>Admin Panel</a>
                @endif
                <a href="/profile" class="btn-mobile-outline"><i class="fas fa-user-circle"></i>Profil</a>
                <a href="{{ route('logout') }}" class="btn-mobile-danger"
                   onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                    <i class="fas fa-sign-out-alt"></i>Keluar
                </a>
                <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            @endguest
        </div>
    </div>

    <div class="mobile-menu-footer">
        <div class="social-links">
            <a href="https://www.facebook.com/ldksyahid/" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/ldksyahid/" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ" target="_blank"><i class="fab fa-youtube"></i></a>
            <a href="https://www.instagram.com/ldksyahid/" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
        <p class="copyright">© {{ date('Y') }} LDK Syahid 💚</p>
    </div>
</div>

<style>
/* ===== NAVBAR PLACEHOLDER ===== */
.navbar-placeholder {
    height: 0;
    transition: height 0.1s ease;
}

.navbar-placeholder.active {
    height: 70px;
}

/* ===== NAVBAR - TOP STATE (Static, above jumbotron) ===== */
.navbar-floating {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    background: rgba(255, 255, 255, 0.50);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(0, 167, 157, 0.1);
    padding: 0.75rem 2rem;
    z-index: 1050;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
}

/* ===== NAVBAR - SCROLLED STATE (Fixed floating) ===== */
.navbar-floating.scrolled {
    position: fixed;
    top: 15px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 40px);
    max-width: 1400px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 0.6rem 1.5rem;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
    border: 1px solid rgba(0, 167, 157, 0.1);
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateX(-50%) translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
}

.navbar-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1400px;
    margin: 0 auto;
}

/* Brand */
.navbar-brand-fun {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
}

.brand-logo-wrapper {
    position: relative;
}

.brand-logo {
    width: 42px;
    height: 42px;
    transition: transform 0.3s ease;
}

.navbar-brand-fun:hover .brand-logo {
    transform: rotate(-5deg) scale(1.05);
}

.brand-emoji {
    position: absolute;
    top: -8px;
    right: -8px;
    font-size: 1rem;
    animation: sparkle 2s ease-in-out infinite;
}

@keyframes sparkle {
    0%, 100% { transform: scale(1) rotate(0deg); opacity: 1; }
    50% { transform: scale(1.2) rotate(15deg); opacity: 0.8; }
}

.brand-text {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
}

.navbar-brand-fun .brand-name {
    font-weight: 700;
    font-size: 1.1rem;
    color: #1a1d1f;
    display: block;
    letter-spacing: -0.01em;
}

.navbar-brand-fun .brand-tagline {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--primary);
}


/* Nav Menu */
.nav-menu {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-menu .nav-link {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.85rem;
    color: var(--dark);
    font-weight: 500;
    font-size: 0.9rem;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.2s ease;
    position: relative;
}

/* Top state - nav links on light bg */
.nav-menu .nav-link:hover {
    color: var(--primary);
    background: var(--primary-light);
}

.nav-menu .nav-link.active {
    color: white;
    background: var(--primary);
}

/* Scrolled state - dark text on white bg */
.navbar-floating.scrolled .nav-menu .nav-link {
    color: var(--dark);
}

.navbar-floating.scrolled .nav-menu .nav-link:hover {
    color: var(--primary);
    background: var(--primary-light);
}

.navbar-floating.scrolled .nav-menu .nav-link.active {
    color: white;
    background: var(--primary);
}

/* Dropdown - show on hover */
.nav-item.dropdown {
    position: relative;
}

.dropdown-fun {
    position: absolute;
    top: 100%;
    left: 0;
    min-width: 220px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    padding: 0.75rem;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.25s ease;
    border: none;
    margin-top: 0;
    z-index: 1100;
}

/* Show dropdown on hover - Desktop */
@media (min-width: 992px) {
    .nav-item.dropdown:hover > .dropdown-fun,
    .nav-item.dropdown:focus-within > .dropdown-fun {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .nav-actions .dropdown:hover > .dropdown-fun,
    .nav-actions .dropdown:focus-within > .dropdown-fun {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
}

/* Also show on click for fallback */
.dropdown-fun.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-fun .dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1rem;
    color: var(--dark);
    border-radius: 10px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.dropdown-fun .dropdown-item i {
    width: 24px;
    color: var(--primary);
    margin-right: 0.75rem;
    font-size: 0.9rem;
}

.dropdown-fun .dropdown-item:hover {
    background: var(--primary-light);
    color: var(--primary);
    transform: translateX(5px);
}

.dropdown-fun li + li {
    margin-top: 0.25rem;
}

/* User Button */
.btn-user-fun {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1.25rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 15px rgba(0, 167, 157, 0.3);
}

.btn-user-fun:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 167, 157, 0.4);
}

/* Scrolled state - same as top state now */
.navbar-floating.scrolled .btn-user-fun {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.btn-user-fun.has-avatar {
    padding: 0.35rem 1rem 0.35rem 0.35rem;
}

.btn-user-fun .user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.5);
}

/* Mobile Toggle */
.mobile-toggle {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    background: var(--primary-light);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    gap: 5px;
    padding: 10px;
    transition: all 0.2s ease;
}

.mobile-toggle span {
    display: block;
    width: 20px;
    height: 2px;
    background: var(--primary);
    border-radius: 2px;
    transition: all 0.3s ease;
}

/* Scrolled state - same as top state now */
.navbar-floating.scrolled .mobile-toggle {
    background: var(--primary-light);
}

.navbar-floating.scrolled .mobile-toggle span {
    background: var(--primary);
}

.mobile-toggle.active {
    background: var(--primary);
}

.mobile-toggle.active span {
    background: white;
}

.mobile-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(5px, 5px);
}

.mobile-toggle.active span:nth-child(2) {
    opacity: 0;
}

.mobile-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(5px, -5px);
}

/* ===== MOBILE MENU ===== */
.mobile-menu-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 1060;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.mobile-menu-overlay.active {
    opacity: 1;
    visibility: visible;
}

.mobile-menu-fun {
    position: fixed;
    top: 0;
    right: -100%;
    width: 85%;
    max-width: 320px;
    height: 100vh;
    background: white;
    z-index: 1070;
    display: flex;
    flex-direction: column;
    transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: -10px 0 40px rgba(0, 0, 0, 0.1);
}

.mobile-menu-fun.active {
    right: 0;
}

.mobile-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--gray-200);
}

.mobile-brand {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
}

.mobile-brand img {
    width: 36px;
    height: 36px;
    border-radius: 10px;
}

.mobile-brand span {
    font-weight: 700;
    color: var(--dark);
}

.mobile-close {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gray-100);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.mobile-close:hover {
    background: var(--danger);
    color: white;
}

.mobile-menu-body {
    flex: 1;
    overflow-y: auto;
    padding: 1rem;
}

.mobile-user-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: linear-gradient(135deg, var(--primary-light), rgba(0, 167, 157, 0.05));
    border-radius: 16px;
    margin-bottom: 1rem;
}

.mobile-user-card img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary);
}

.mobile-user-card .name {
    font-weight: 600;
    color: var(--dark);
    display: block;
}

.mobile-user-card .email {
    font-size: 0.8rem;
    color: var(--gray);
}

.mobile-nav-fun {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.mobile-nav-fun > a,
.mobile-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    color: var(--dark);
    text-decoration: none;
    border-radius: 12px;
    font-weight: 500;
    transition: all 0.2s ease;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 0.95rem;
}

.mobile-nav-fun > a i,
.mobile-dropdown-toggle i:first-child {
    width: 20px;
    color: var(--primary);
}

.mobile-nav-fun > a:hover,
.mobile-nav-fun > a.active,
.mobile-dropdown-toggle:hover {
    background: var(--primary-light);
    color: var(--primary);
}

.mobile-dropdown-toggle .arrow {
    margin-left: auto;
    font-size: 0.7rem;
    transition: transform 0.3s ease;
}

.mobile-dropdown.open .arrow {
    transform: rotate(180deg);
}

.mobile-dropdown-menu {
    display: none;
    padding-left: 2.5rem;
    padding-top: 0.25rem;
}

.mobile-dropdown.open .mobile-dropdown-menu {
    display: block;
}

.mobile-dropdown-menu a {
    display: block;
    padding: 0.6rem 1rem;
    color: var(--gray);
    text-decoration: none;
    font-size: 0.9rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.mobile-dropdown-menu a:hover {
    color: var(--primary);
    background: var(--primary-light);
}

.mobile-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-top: 1.5rem;
    padding-top: 1rem;
    border-top: 1px solid var(--gray-200);
}

.btn-mobile-primary,
.btn-mobile-outline,
.btn-mobile-danger {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-mobile-primary {
    background: var(--primary);
    color: white;
}

.btn-mobile-outline {
    background: var(--primary-light);
    color: var(--primary);
}

.btn-mobile-danger {
    background: rgba(220, 53, 69, 0.1);
    color: var(--danger);
}

.mobile-menu-footer {
    padding: 1rem 1.25rem;
    border-top: 1px solid var(--gray-200);
    text-align: center;
}

.mobile-menu-footer .social-links {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.mobile-menu-footer .social-links a {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 50%;
    transition: all 0.3s ease;
}

.mobile-menu-footer .social-links a:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
}

.mobile-menu-footer .copyright {
    font-size: 0.8rem;
    color: var(--gray);
    margin: 0;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991.98px) {
    .navbar-placeholder.active {
        height: 56px;
    }

    .navbar-floating {
        padding: 0.6rem 1rem;
    }

    .navbar-floating.scrolled {
        position: fixed;
        top: 10px;
        width: calc(100% - 20px);
        padding: 0.5rem 1rem;
        border-radius: 16px;
    }

    .brand-logo {
        width: 36px;
        height: 36px;
    }

    .brand-name {
        font-size: 1rem;
    }

    .brand-emoji {
        display: none;
    }
}

@media (min-width: 992px) {
    .dropdown-fun[data-bs-popper] {
        transform: none !important;
        inset: auto !important;
        top: 100% !important;
        left: 0 !important;
        margin-top: 0.5rem !important;
    }

    .dropdown-menu-end.dropdown-fun[data-bs-popper] {
        left: auto !important;
        right: 0 !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('mainNavbar');
    const placeholder = document.getElementById('navbarPlaceholder');
    const mobileToggle = document.getElementById('mobileToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileClose = document.getElementById('mobileClose');

    // Get navbar height for scroll threshold
    const navbarHeight = navbar ? navbar.offsetHeight : 60;
    const scrollThreshold = navbarHeight + 50;

    let isScrolled = false;

    function handleScroll() {
        const shouldBeScrolled = window.scrollY > scrollThreshold;

        if (shouldBeScrolled !== isScrolled) {
            isScrolled = shouldBeScrolled;

            if (isScrolled) {
                navbar.classList.add('scrolled');
                placeholder.classList.add('active');
            } else {
                navbar.classList.remove('scrolled');
                placeholder.classList.remove('active');
            }
        }
    }

    // Initial check
    handleScroll();

    window.addEventListener('scroll', handleScroll, { passive: true });

    // Mobile menu
    function openMenu() {
        mobileMenu.classList.add('active');
        mobileOverlay.classList.add('active');
        mobileToggle.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeMenu() {
        mobileMenu.classList.remove('active');
        mobileOverlay.classList.remove('active');
        mobileToggle.classList.remove('active');
        document.body.style.overflow = '';
    }

    mobileToggle?.addEventListener('click', () => mobileMenu.classList.contains('active') ? closeMenu() : openMenu());
    mobileClose?.addEventListener('click', closeMenu);
    mobileOverlay?.addEventListener('click', closeMenu);

    // Mobile dropdowns
    document.querySelectorAll('.mobile-dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function() {
            this.closest('.mobile-dropdown').classList.toggle('open');
        });
    });

    // Escape key
    document.addEventListener('keydown', e => e.key === 'Escape' && closeMenu());
});
</script>
