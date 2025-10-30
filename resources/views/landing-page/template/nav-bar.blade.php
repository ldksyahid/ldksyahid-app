
<!-- Topbar Start -->
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="container-fluid bg-light p-0">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center border-start border-end px-3">
                <small class="fas fa-phone-alt me-2"></small>
                <small>+62 851-5936-0504</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center border-end px-3">
                <small class="far fa-envelope-open me-2"></small>
                <small>ldk.ormawa@apps.uinjkt.ac.id</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center border-end px-3">
              <small class="far fa-clock me-2"></small>
              <small>Setiap Waktu</small>
            </div>
        </div>
        <div class="col-lg-5 px-5 text-end">
            <div class="h-100 d-inline-flex align-items-center">
                <a class="btn btn-square border-end border-start" href="https://www.facebook.com/ldksyahid/" target="_blank"
                    ><i class="fab fa-facebook-f"></i
                ></a>
                <a class="btn btn-square border-end" href="https://twitter.com/ldksyahid/" target="_blank"
                    ><i class="fab fa-twitter"></i
                ></a>
                <a class="btn btn-square border-end" href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ?app=desktop/" target="_blank"
                    ><i class="fab fa-youtube"></i
                ></a>
                <a class="btn btn-square border-end" href="https://www.instagram.com/ldksyahid/" target="_blank"
                    ><i class="fab fa-instagram"></i
                ></a>
            </div>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0" id="navbar">
    <a href="#" class="navbar-brand d-flex align-items-center">
        <h3 class="m-0 website-responsive">
            <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" width="55" height="55" alt="Logo LDK Syahid"> </i>LDK Syahid
        </h3>
        <h6 class="m-0 mobile-responsive">
            <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" width="44" height="44" alt="Logo LDK Syahid"> </i>
        </h6>
    </a>
    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-3 py-lg-0">
            {{-- HOME NAV START --}}
            <a href="/" class="nav-item nav-link text-capitalize {{($title === "Beranda") ? "active" : ""}}">Beranda</a>
            {{-- HOME NAV END --}}

            {{-- ABOUT US NAV START --}}
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Tentang Kami") ? "active" : ""}}" data-bs-toggle="dropdown">Tentang Kami</a>
                <div class="dropdown-menu bg-light m-0" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <a href="/about/structure" class="dropdown-item">Struktur Pengurus</a>
                    <a href="/about/contact" class="dropdown-item">Hubungi Kami</a>
                    <a href="/about/gallery" class="dropdown-item">Galeri</a>
                </div>
            </div>
            {{-- ABOUT US NAV END --}}

            {{-- ARTICLE NAV START --}}
            <a href="/articles" class="nav-item nav-link text-capitalize {{($title === "Artikel") ? "active" : ""}}">Artikel</a>
            {{-- ARTICLE NAV END --}}

            {{-- NEWS NAV START --}}
            @if ($title === "Berita")
                <a href="/news" class="nav-item nav-link text-capitalize {{($title === "Berita" || $title === "Berita : $linkTitle") ? "active" : ""}}">Berita</a>
            @else
                <a href="/news" class="nav-item nav-link text-capitalize {{($title === "Berita") ? "active" : ""}}">Berita</a>
            @endif
            {{-- NEWS NAV END --}}

            {{-- ACTIVITY NAV START --}}
            <a href="/events" class="nav-item nav-link text-capitalize {{($title === "Kegiatan") ? "active" : ""}}">Kegiatan</a>
            {{-- ACTIVITY NAV END --}}

            {{-- BOOK CATALOG NAV START --}}
            <a href="/perpustakaan" class="nav-item nav-link text-capitalize {{($title === "Perpustakaan") ? "active" : ""}}">Perpustakaan</a>
            {{-- BOOK CATALOG END --}}

            {{-- LAYANAN NAV START --}}
            <a href="/service" class="nav-item nav-link text-capitalize {{($title === "Layanan") ? "active" : ""}}">Layanan</a>
            {{-- LAYANAN NAV END --}}

            {{-- OTHER NAV START --}}
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Lainnya") ? "active" : ""}}" data-bs-toggle="dropdown">Lainnya</a>
                <div class="dropdown-menu bg-light m-0" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <a href="/schedule" class="dropdown-item">Jadwal</a>
                </div>
            </div>
            {{-- OTHER NAV END --}}

            {{-- USER NAV START --}}
            @guest
                <div class="nav-item dropdown">
                    <a
                    href="#"
                    class="nav-link dropdown-toggle text-capitalize {{($title === "Masuk" || $title === "Daftar") ? "active" : ""}}  "
                    data-bs-toggle="dropdown"
                    ><span class="fa fa-user"></span> Pengunjung</a>
                    <div class="dropdown-menu bg-light m-0" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        @if (Route::has('login'))
                            <a class="dropdown-item" href="{{ route('login') }}">{{ __('Masuk') }}</a>
                        @endif
                        @if (Route::has('register'))
                            <a class="dropdown-item" href="{{ route('register') }}">{{ __('Daftar') }}</a>
                        @endif
                    </div>
                </div>
            @else
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Profilku") ? "active" : ""}}" data-bs-toggle="dropdown"><span class="mr-5">
                        @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                            <img class="rounded-circle" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 27px; height: 27px;">
                        @else
                            <img class="rounded-circle" src="https://lh3.googleusercontent.com/d/{{Auth::User()->profile->gdrive_id}}" alt="" style="width: 20px; height: 20px;">
                        @endif
                    </span>{{ substr(Auth::user()->name,0, 15) }}</a>
                    <div class="dropdown-menu bg-light m-0" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        @if (LFC::cekRoleAdmin(auth()->user()))
                            <a href="/admin/dashboard" class="dropdown-item">Admin Panel</a>
                            <a href="/profile" class="dropdown-item">Profil Aku</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Keluar') }}
                            </a>
                        @else
                            <a href="/profile" class="dropdown-item">Profil Aku</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{ __('Keluar') }}
                            </a>
                        @endif
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
            {{-- USER NAV END --}}
        </div>
    </div>
</nav>
<!-- Navbar End -->
@endif
@if((new \Jenssegers\Agent\Agent())->isMobile())
<!-- Mobile Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5 py-lg-0" id="mobile-navbar">
    <div class="container-fluid">
        <a href="#" class="navbar-brand d-flex align-items-center">
            <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" width="44" height="44" alt="Logo LDK Syahid">
            <span class="ms-2">LDK Syahid</span>
        </a>

        <!-- Animated Hamburger Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNavbarCollapse" aria-controls="mobileNavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mobileNavbarCollapse">
            <div class="navbar-nav">
                <!-- Home -->
                <a href="/" class="nav-item nav-link text-capitalize {{($title === "Beranda") ? "active" : ""}}">Beranda</a>

                 <!-- About Us Dropdown -->
                 <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Tentang Kami") ? "active" : ""}}" data-bs-toggle="dropdown" role="button" aria-expanded="false">Tentang Kami</a>
                    <div class="dropdown-menu" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <a href="/about/structure" class="dropdown-item">Struktur Pengurus</a>
                        <a href="/about/contact" class="dropdown-item">Hubungi Kami</a>
                        <a href="/about/gallery" class="dropdown-item">Galeri</a>
                    </div>
                </div>

                <!-- Article -->
                <a href="/articles" class="nav-item nav-link text-capitalize {{($title === "Artikel") ? "active" : ""}}">Artikel</a>

                <!-- News -->
                @if ($title === "Berita")
                    <a href="/news" class="nav-item nav-link text-capitalize {{($title === "Berita" || $title === "Berita : $linkTitle") ? "active" : ""}}">Berita</a>
                @else
                    <a href="/news" class="nav-item nav-link text-capitalize {{($title === "Berita") ? "active" : ""}}">Berita</a>
                @endif

                <!-- Activity -->
                <a href="/events" class="nav-item nav-link text-capitalize {{($title === "Kegiatan") ? "active" : ""}}">Kegiatan</a>

                <!-- Book Catalog -->
                <a href="/perpustakaan" class="nav-item nav-link text-capitalize {{($title === "Perpustakaan") ? "active" : ""}}">Perpustakaan</a>

                <!-- Service -->
                <a href="/service" class="nav-item nav-link text-capitalize {{($title === "Layanan") ? "active" : ""}}">Layanan</a>

                <!-- Other -->
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Lainnya") ? "active" : ""}}" data-bs-toggle="dropdown" role="button" aria-expanded="false">Lainnya</a>
                    <div class="dropdown-menu" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <a href="/schedule" class="dropdown-item">Jadwal</a>
                    </div>
                </div>

                <!-- User Section -->
                @guest
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Masuk" || $title === "Daftar") ? "active" : ""}}" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="fa fa-user"></span> Pengunjung
                        </a>
                        <div class="dropdown-menu m-0 animate__animated animate__fadeIn animate__faster" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            @if (Route::has('login'))
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Masuk') }}</a>
                            @endif
                            @if (Route::has('register'))
                                <a class="dropdown-item" href="{{ route('register') }}">{{ __('Daftar') }}</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Profilku") ? "active" : ""}}" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                            @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                                <img class="rounded-circle" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 27px; height: 27px;">
                            @else
                                <img class="rounded-circle" src="https://lh3.googleusercontent.com/d/{{Auth::User()->profile->gdrive_id}}" alt="" style="width: 20px; height: 20px;">
                            @endif
                            <span class="ms-2">{{ substr(Auth::user()->name,0, 15) }}</span>
                        </a>
                        <div class="dropdown-menu m-0 animate__animated animate__fadeIn animate__faster" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                            @if (LFC::cekRoleAdmin(auth()->user()))
                                <a href="/admin/dashboard" class="dropdown-item">Admin Panel</a>
                                <a href="/profile" class="dropdown-item">Profil Aku</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Keluar') }}
                                </a>
                            @else
                                <a href="/profile" class="dropdown-item">Profil Aku</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Keluar') }}
                                </a>
                            @endif
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <hr>
            <!-- Contact Info -->
            <div class="navbar-info">
                <div class="mt-4 p-3 shadow-sm border" style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    <div class="d-flex align-items-center py-2 border-bottom">
                        <i class="fas fa-phone-alt me-2 text-primary"></i>
                        <small class="text-dark">+62 851-5936-0504</small>
                    </div>
                    <div class="d-flex align-items-center py-2 border-bottom">
                        <i class="far fa-envelope-open me-2 text-primary"></i>
                        <small class="text-dark">ldk.ormawa@apps.uinjkt.ac.id</small>
                    </div>
                    <div class="d-flex align-items-center py-2 border-bottom">
                        <i class="far fa-clock me-2 text-primary"></i>
                        <small class="text-dark">Setiap Waktu</small>
                    </div>
                    <div class="d-flex justify-content-start align-items-center pt-3">
                        <a class="btn btn-sm border me-2" href="https://www.facebook.com/ldksyahid/" style="border-radius: 12px;" target="_blank">
                            <i class="fab fa-facebook-f text-primary"></i>
                        </a>
                        <a class="btn btn-sm border me-2" href="https://twitter.com/ldksyahid/" style="border-radius: 12px;" target="_blank">
                            <i class="fab fa-twitter text-primary"></i>
                        </a>
                        <a class="btn btn-sm border me-2" href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ?app=desktop/" style="border-radius: 12px;" target="_blank">
                            <i class="fab fa-youtube text-danger"></i>
                        </a>
                        <a class="btn btn-sm border" href="https://www.instagram.com/ldksyahid/" style="border-radius: 12px;" target="_blank">
                            <i class="fab fa-instagram text-danger"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>
<!-- Mobile Navbar End -->

<style>
    .navbar-toggler {
        border: none !important;
        background: transparent !important;
        padding: 0.5rem !important;
        position: relative !important;
        width: 40px !important;
        height: 40px !important;
    }

    .navbar-toggler:focus {
        box-shadow: none !important;
        outline: none !important;
    }

    .navbar-toggler span {
        display: block !important;
        width: 25px !important;
        height: 2px !important;
        background-color: #333 !important;
        margin: 5px 0 !important;
        transition: all 0.3s ease !important;
        position: absolute !important;
        left: 7px !important;
    }

    .navbar-toggler span:nth-child(1) {
        top: 10px !important;
    }

    .navbar-toggler span:nth-child(2) {
        top: 18px !important;
    }

    .navbar-toggler span:nth-child(3) {
        top: 26px !important;
    }

    .navbar-toggler[aria-expanded="true"] span:nth-child(1) {
        transform: rotate(45deg) !important;
        top: 18px !important;
    }

    .navbar-toggler[aria-expanded="true"] span:nth-child(2) {
        opacity: 0 !important;
    }

    .navbar-toggler[aria-expanded="true"] span:nth-child(3) {
        transform: rotate(-45deg) !important;
        top: 18px !important;
    }

    .dropdown-menu {
        position: absolute !important;
        left: 0;
        top: 100%;
        z-index: 999;
        width: 100%;
        display: block !important;
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition:
            max-height 0.3s ease,
            opacity 0.3s ease,
            transform 0.3s ease,
            visibility 0.3s ease;
    }

    .dropdown-menu.show {
        max-height: 500px;
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .nav-item.dropdown {
        position: relative;
    }

    .navbar-collapse.collapsing {
        transition: height 0.35s ease !important;
    }

    .navbar-info{
        height: 100vh !important;
    }

    .navbar-nav .nav-link {
        padding: 12px 15px !important;
        border-bottom: 1px solid #f0f0f0;
    }

    .nav-item.dropdown .dropdown-toggle::after {
        float: right;
        margin-top: 8px;
    }

    .dropdown-menu .dropdown-item {
        padding: 10px 20px;
        border-bottom: 1px solid #f8f9fa;
    }

    .dropdown-menu .dropdown-item:last-child {
        border-bottom: none;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownToggles = document.querySelectorAll('.nav-item.dropdown .nav-link');

        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    const isOpen = dropdownMenu.classList.contains('show');

                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        if (menu !== dropdownMenu) {
                            menu.classList.remove('show');
                        }
                    });

                    if (!isOpen) {
                        dropdownMenu.classList.add('show');
                    } else {
                        dropdownMenu.classList.remove('show');
                    }
                }
            });
        });

        document.addEventListener('click', function(e) {
            if (!e.target.matches('.nav-link') && !e.target.closest('.dropdown-menu')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    });
</script>
@endif
