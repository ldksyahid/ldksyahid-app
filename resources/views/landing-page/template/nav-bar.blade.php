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
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
                <ul class="dropdown-menu dropdown-fun">
                    <li>
                        <a href="/about/structure" class="dropdown-item {{ request()->is('about/structure') ? 'active' : '' }}">
                            <div class="dropdown-icon"><i class="fas fa-sitemap"></i></div>
                            <div class="dropdown-text">
                                <span class="dropdown-title">Struktur Pengurus</span>
                                <span class="dropdown-desc">Kenali pengurus LDK Syahid</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/about/contact" class="dropdown-item {{ request()->is('about/contact') ? 'active' : '' }}">
                            <div class="dropdown-icon"><i class="fas fa-phone"></i></div>
                            <div class="dropdown-text">
                                <span class="dropdown-title">Hubungi Kami</span>
                                <span class="dropdown-desc">Sampaikan pesan & saran</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/about/gallery" class="dropdown-item {{ request()->is('about/gallery') ? 'active' : '' }}">
                            <div class="dropdown-icon"><i class="fas fa-images"></i></div>
                            <div class="dropdown-text">
                                <span class="dropdown-title">Galeri</span>
                                <span class="dropdown-desc">Dokumentasi kegiatan kami</span>
                            </div>
                        </a>
                    </li>
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
                    <i class="fas fa-chevron-down dropdown-arrow"></i>
                </a>
                <ul class="dropdown-menu dropdown-fun">
                    <li>
                        <a href="/laporan" class="dropdown-item {{ request()->is('laporan') ? 'active' : '' }}">
                            <div class="dropdown-icon"><i class="fas fa-file-alt"></i></div>
                            <div class="dropdown-text">
                                <span class="dropdown-title">Laporan</span>
                                <span class="dropdown-desc">Laporan kegiatan & keuangan</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/schedule" class="dropdown-item {{ request()->is('schedule') ? 'active' : '' }}">
                            <div class="dropdown-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="dropdown-text">
                                <span class="dropdown-title">Jadwal</span>
                                <span class="dropdown-desc">Agenda & jadwal kegiatan</span>
                            </div>
                        </a>
                    </li>
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
                            <li>
                                <a class="dropdown-item {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                    <div class="dropdown-icon"><i class="fas fa-sign-in-alt"></i></div>
                                    <div class="dropdown-text">
                                        <span class="dropdown-title">Masuk</span>
                                        <span class="dropdown-desc">Login ke akun kamu</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li>
                                <a class="dropdown-item {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                    <div class="dropdown-icon"><i class="fas fa-user-plus"></i></div>
                                    <div class="dropdown-text">
                                        <span class="dropdown-title">Daftar</span>
                                        <span class="dropdown-desc">Buat akun baru</span>
                                    </div>
                                </a>
                            </li>
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
                            <li>
                                <a href="/admin/dashboard" class="dropdown-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                    <div class="dropdown-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    <div class="dropdown-text">
                                        <span class="dropdown-title">Admin Panel</span>
                                        <span class="dropdown-desc">Kelola website</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="/profile" class="dropdown-item {{ request()->is('profile') ? 'active' : '' }}">
                                <div class="dropdown-icon"><i class="fas fa-user-circle"></i></div>
                                <div class="dropdown-text">
                                    <span class="dropdown-title">Profil Aku</span>
                                    <span class="dropdown-desc">Lihat & edit profil</span>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item dropdown-item-danger" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <div class="dropdown-icon dropdown-icon-danger"><i class="fas fa-sign-out-alt"></i></div>
                                <div class="dropdown-text">
                                    <span class="dropdown-title dropdown-title-danger">Keluar</span>
                                    <span class="dropdown-desc">Logout dari akun</span>
                                </div>
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
            <a href="/" class="{{ ($title === "Beranda") ? "active" : "" }}">
                <div class="mobile-nav-icon"><i class="fas fa-home"></i></div>
                <span>Beranda</span>
            </a>

            <div class="mobile-dropdown {{ ($title === 'Tentang Kami') ? 'open' : '' }}">
                <button class="mobile-dropdown-toggle">
                    <div class="mobile-nav-icon"><i class="fas fa-info-circle"></i></div>
                    <span>Tentang Kami</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </button>
                <div class="mobile-dropdown-menu">
                    <a href="/about/structure" class="{{ request()->is('about/structure') ? 'active' : '' }}"><i class="fas fa-sitemap"></i>Struktur Pengurus</a>
                    <a href="/about/contact" class="{{ request()->is('about/contact') ? 'active' : '' }}"><i class="fas fa-phone"></i>Hubungi Kami</a>
                    <a href="/about/gallery" class="{{ request()->is('about/gallery') ? 'active' : '' }}"><i class="fas fa-images"></i>Galeri</a>
                </div>
            </div>

            <a href="/articles" class="{{ ($title === "Artikel") ? "active" : "" }}">
                <div class="mobile-nav-icon"><i class="fas fa-newspaper"></i></div>
                <span>Artikel</span>
            </a>
            <a href="/news" class="{{ ($title === "Berita") ? "active" : "" }}">
                <div class="mobile-nav-icon"><i class="fas fa-bullhorn"></i></div>
                <span>Berita</span>
            </a>
            <a href="/events" class="{{ ($title === "Kegiatan") ? "active" : "" }}">
                <div class="mobile-nav-icon"><i class="fas fa-calendar-check"></i></div>
                <span>Kegiatan</span>
            </a>
            <a href="/perpustakaan" class="{{ ($title === "Perpustakaan") ? "active" : "" }}">
                <div class="mobile-nav-icon"><i class="fas fa-book"></i></div>
                <span>Perpustakaan</span>
            </a>
            <a href="/service" class="{{ ($title === "Layanan") ? "active" : "" }}">
                <div class="mobile-nav-icon"><i class="fas fa-hands-helping"></i></div>
                <span>Layanan</span>
            </a>

            <div class="mobile-dropdown {{ ($title === 'Lainnya') ? 'open' : '' }}">
                <button class="mobile-dropdown-toggle">
                    <div class="mobile-nav-icon"><i class="fas fa-ellipsis-h"></i></div>
                    <span>Lainnya</span>
                    <i class="fas fa-chevron-down arrow"></i>
                </button>
                <div class="mobile-dropdown-menu">
                    <a href="/laporan" class="{{ request()->is('laporan') ? 'active' : '' }}"><i class="fas fa-file-alt"></i>Laporan</a>
                    <a href="/schedule" class="{{ request()->is('schedule') ? 'active' : '' }}"><i class="fas fa-calendar-alt"></i>Jadwal</a>
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

/* ===== NAVBAR - RETURNING TO TOP (smooth transition) ===== */
.navbar-floating.returning-top {
    position: fixed;
    top: 15px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 40px);
    max-width: 1400px;
    border-radius: 20px;
    padding: 0.6rem 1.5rem;
    border: 1px solid rgba(0, 167, 157, 0.1);
    animation: slideUp 0.35s ease forwards;
}

@keyframes slideUp {
    from {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }
    to {
        opacity: 0;
        transform: translateX(-50%) translateY(-20px);
    }
}

/* ===== NAVBAR - APPEAR AT TOP (fade in) ===== */
.navbar-floating.appear-top {
    animation: fadeInTop 0.35s ease forwards;
}

@keyframes fadeInTop {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 991.98px) {
    .navbar-floating.returning-top {
        top: 15px;
        width: calc(100% - 30px);
        padding: 0.5rem 1.25rem;
        border-radius: 16px;
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
    gap: 0.15rem;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav-menu .nav-item {
    position: relative;
}

.nav-menu .nav-link {
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    color: var(--dark);
    font-weight: 500;
    font-size: 0.9rem;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.2s ease;
    position: relative;
    white-space: nowrap;
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

/* Dropdown Arrow */
.dropdown-arrow {
    font-size: 0.65rem;
    margin-left: 0.35rem;
    transition: transform 0.3s ease;
}

.nav-menu .nav-item.dropdown:hover .dropdown-arrow {
    transform: rotate(180deg);
}

/* Dropdown - show on hover */
.nav-menu .nav-item.dropdown {
    position: relative;
}

.nav-menu .dropdown-fun,
.nav-actions .dropdown-fun {
    position: absolute !important;
    top: calc(100% + 8px) !important;
    left: 50% !important;
    transform: translateX(-50%) translateY(10px) !important;
    min-width: 280px !important;
    background: white !important;
    border-radius: 18px !important;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12), 0 8px 24px rgba(0, 167, 157, 0.08) !important;
    padding: 0.75rem !important;
    opacity: 0 !important;
    visibility: hidden !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    border: 1px solid rgba(0, 167, 157, 0.08) !important;
    z-index: 1100 !important;
    list-style: none !important;
    display: block !important;
    margin: 0 !important;
}


/* Show dropdown on hover - Desktop */
@media (min-width: 992px) {
    .nav-menu .nav-item.dropdown:hover > .dropdown-fun,
    .nav-menu .nav-item.dropdown:focus-within > .dropdown-fun {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateX(-50%) translateY(0) !important;
    }

    .nav-actions .dropdown:hover > .dropdown-fun,
    .nav-actions .dropdown:focus-within > .dropdown-fun {
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateX(-50%) translateY(0) !important;
    }

    /* For right-aligned dropdowns */
    .nav-actions .dropdown-fun,
    .nav-actions .dropdown-menu-end.dropdown-fun {
        left: auto !important;
        right: 0 !important;
        transform: translateX(0) translateY(10px) !important;
    }

    .nav-actions .dropdown:hover > .dropdown-fun,
    .nav-actions .dropdown:focus-within > .dropdown-fun {
        transform: translateX(0) translateY(0) !important;
    }

}

/* Also show on click for fallback */
.dropdown-fun.show {
    opacity: 1 !important;
    visibility: visible !important;
    transform: translateX(-50%) translateY(0) !important;
}

.nav-menu .dropdown-fun .dropdown-item,
.nav-actions .dropdown-fun .dropdown-item {
    display: flex !important;
    align-items: center !important;
    gap: 0.875rem !important;
    padding: 0.75rem 1rem !important;
    color: var(--dark) !important;
    border-radius: 14px !important;
    font-size: 0.9rem !important;
    font-weight: 500 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    overflow: hidden !important;
    background: transparent !important;
}

/* Dropdown icon wrapper */
.dropdown-icon {
    width: 40px !important;
    height: 40px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    background: var(--primary-light) !important;
    color: var(--primary) !important;
    border-radius: 12px !important;
    font-size: 0.9rem !important;
    transition: all 0.3s ease !important;
    flex-shrink: 0 !important;
}

/* Dropdown text */
.dropdown-text {
    display: flex !important;
    flex-direction: column !important;
    gap: 2px !important;
}

.dropdown-title {
    font-weight: 600 !important;
    font-size: 0.9rem !important;
    color: var(--dark) !important;
    transition: color 0.3s ease !important;
}

.dropdown-desc {
    font-size: 0.75rem !important;
    color: var(--gray) !important;
    font-weight: 400 !important;
    transition: color 0.3s ease !important;
}

.nav-menu .dropdown-fun .dropdown-item:hover,
.nav-actions .dropdown-fun .dropdown-item:hover {
    background: linear-gradient(135deg, var(--primary-light), rgba(0, 167, 157, 0.06)) !important;
    color: var(--primary) !important;
    transform: translateX(4px) !important;
}

.nav-menu .dropdown-fun .dropdown-item:hover .dropdown-icon,
.nav-actions .dropdown-fun .dropdown-item:hover .dropdown-icon {
    background: var(--primary) !important;
    color: white !important;
    transform: scale(1.08) !important;
}

.nav-menu .dropdown-fun .dropdown-item:hover .dropdown-title,
.nav-actions .dropdown-fun .dropdown-item:hover .dropdown-title {
    color: var(--primary) !important;
}

.nav-menu .dropdown-fun .dropdown-item:hover .dropdown-desc,
.nav-actions .dropdown-fun .dropdown-item:hover .dropdown-desc {
    color: var(--primary) !important;
    opacity: 0.7 !important;
}

/* Dropdown item active state */
.nav-menu .dropdown-fun .dropdown-item.active,
.nav-actions .dropdown-fun .dropdown-item.active {
    background: linear-gradient(135deg, var(--primary-light), rgba(0, 167, 157, 0.08)) !important;
}

.nav-menu .dropdown-fun .dropdown-item.active .dropdown-icon,
.nav-actions .dropdown-fun .dropdown-item.active .dropdown-icon {
    background: var(--primary) !important;
    color: white !important;
}

.nav-menu .dropdown-fun .dropdown-item.active .dropdown-title,
.nav-actions .dropdown-fun .dropdown-item.active .dropdown-title {
    color: var(--primary) !important;
}

/* Dropdown divider */
.nav-actions .dropdown-fun .dropdown-divider {
    margin: 0.35rem 0.75rem !important;
    border-color: rgba(0, 0, 0, 0.06) !important;
}

/* Dropdown danger item (logout) */
.dropdown-icon-danger {
    background: rgba(220, 53, 69, 0.1) !important;
    color: var(--danger) !important;
}

.dropdown-title-danger {
    color: var(--danger) !important;
}

.dropdown-item-danger:hover .dropdown-icon-danger {
    background: var(--danger) !important;
    color: white !important;
}

.dropdown-item-danger:hover .dropdown-title-danger {
    color: var(--danger) !important;
}

.dropdown-item-danger:hover {
    background: rgba(220, 53, 69, 0.08) !important;
}

.nav-menu .dropdown-fun li + li,
.nav-actions .dropdown-fun li + li {
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
    background: var(--primary-light);
    color: var(--primary);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.mobile-close:hover {
    background: var(--primary);
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
    gap: 0.2rem;
}

/* Section label */
.mobile-nav-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--gray);
    padding: 0.75rem 1rem 0.35rem;
    margin-top: 0.25rem;
}

.mobile-nav-label:first-child {
    margin-top: 0;
    padding-top: 0.25rem;
}

/* Nav icon wrapper */
.mobile-nav-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 10px;
    font-size: 0.85rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.mobile-nav-fun > a,
.mobile-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.65rem 0.75rem;
    color: var(--dark);
    text-decoration: none;
    border-radius: 14px;
    font-weight: 500;
    transition: all 0.25s ease;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 0.95rem;
}

.mobile-nav-fun > a:hover,
.mobile-nav-fun > a.active,
.mobile-dropdown-toggle:hover {
    background: var(--primary-light);
    color: var(--primary);
}

.mobile-nav-fun > a.active .mobile-nav-icon {
    background: var(--primary);
    color: white;
}

.mobile-nav-fun > a:hover .mobile-nav-icon {
    background: var(--primary);
    color: white;
    transform: scale(1.05);
}

.mobile-dropdown-toggle .arrow {
    margin-left: auto;
    font-size: 0.65rem;
    color: var(--gray);
    transition: transform 0.3s ease;
}

.mobile-dropdown.open .arrow {
    transform: rotate(180deg);
    color: var(--primary);
}

.mobile-dropdown.open .mobile-dropdown-toggle {
    background: var(--primary-light);
    color: var(--primary);
}

.mobile-dropdown.open .mobile-dropdown-toggle .mobile-nav-icon {
    background: var(--primary);
    color: white;
}

.mobile-dropdown-menu {
    max-height: 0;
    overflow: hidden;
    padding-left: 1rem;
    margin-left: 1.1rem;
    border-left: 2px solid var(--primary-light);
    transition: max-height 0.35s ease, padding-top 0.35s ease, padding-bottom 0.35s ease;
    padding-top: 0;
    padding-bottom: 0;
}

.mobile-dropdown.open .mobile-dropdown-menu {
    max-height: 300px;
    padding-top: 0.35rem;
    padding-bottom: 0.35rem;
}

.mobile-dropdown-menu a {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.6rem 0.85rem;
    color: var(--dark);
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 450;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.mobile-dropdown-menu a i {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 8px;
    font-size: 0.75rem;
    flex-shrink: 0;
    transition: all 0.2s ease;
}

.mobile-dropdown-menu a:hover {
    color: var(--primary);
    background: var(--primary-light);
}

.mobile-dropdown-menu a:hover i {
    background: var(--primary);
    color: white;
}

/* Mobile dropdown item active */
.mobile-dropdown-menu a.active {
    color: var(--primary);
    background: var(--primary-light);
    font-weight: 600;
}

.mobile-dropdown-menu a.active i {
    background: var(--primary);
    color: white;
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
        padding: 0.6rem 1.25rem;
    }

    .navbar-floating.scrolled {
        position: fixed;
        top: 15px;
        width: calc(100% - 30px);
        padding: 0.5rem 1.25rem;
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

/* Override Bootstrap popper positioning */
@media (min-width: 992px) {
    .nav-menu .dropdown-fun[data-bs-popper],
    .nav-actions .dropdown-fun[data-bs-popper] {
        transform: translateX(-50%) translateY(10px) !important;
        inset: auto !important;
        top: calc(100% + 8px) !important;
        left: 50% !important;
        margin-top: 0 !important;
    }

    .nav-menu .nav-item.dropdown:hover .dropdown-fun[data-bs-popper],
    .nav-actions .dropdown:hover .dropdown-fun[data-bs-popper] {
        transform: translateX(-50%) translateY(0) !important;
    }

    .nav-actions .dropdown-fun[data-bs-popper] {
        left: auto !important;
        right: 0 !important;
        transform: translateX(0) translateY(10px) !important;
    }

    .nav-actions .dropdown:hover .dropdown-fun[data-bs-popper] {
        transform: translateX(0) translateY(0) !important;
    }

    .dropdown-toggle::after {
        display: none;
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
                navbar.classList.remove('returning-top');
                navbar.classList.add('scrolled');
                placeholder.classList.add('active');
            } else {
                // Smooth transition back to top
                navbar.classList.remove('scrolled');
                navbar.classList.add('returning-top');

                navbar.addEventListener('animationend', function onEnd() {
                    navbar.removeEventListener('animationend', onEnd);
                    navbar.classList.remove('returning-top');
                    placeholder.classList.remove('active');

                    // Fade in at top position
                    navbar.classList.add('appear-top');
                    navbar.addEventListener('animationend', function onAppear() {
                        navbar.removeEventListener('animationend', onAppear);
                        navbar.classList.remove('appear-top');
                    }, { once: true });
                }, { once: true });
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
