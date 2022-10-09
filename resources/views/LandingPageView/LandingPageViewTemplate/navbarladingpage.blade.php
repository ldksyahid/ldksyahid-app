<!-- Topbar Start -->
<div class="container-fluid bg-light p-0">
    <div class="row gx-0 d-none d-lg-flex">
        <div class="col-lg-7 px-5 text-start">
            <div class="h-100 d-inline-flex align-items-center border-start border-end px-3">
                <small class="fas fa-phone-alt me-2"></small>
                <small>+62 851-5936-0504</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center border-end px-3">
                <small class="far fa-envelope-open me-2"></small>
                <small>ldk@uinjkt.ac.id</small>
            </div>
            <div class="h-100 d-inline-flex align-items-center border-end px-3">
              <small class="far fa-clock me-2"></small>
              <small>Mon - Fri : 09 AM - 05 PM</small>
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
<nav class="navbar navbar-expand-lg bg-white navbar-light  sticky-top px-4 px-lg-5 py-lg-0">
    <a href="#" class="navbar-brand d-flex align-items-center">
        <h3 class="m-0">
            <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" width="55" height="55" alt="Logo LDK Syahid"> </i>LDK Syahid
        </h1>
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
                <div class="dropdown-menu bg-light m-0">
                    <a href="/about/structure" class="nav-item dropdown-item">Struktur Pengurus LDK Syahid 26</a>
                    <a href="/about/contact" class="nav-item dropdown-item">Hubungi Kami</a>
                </div>
            </div>
            {{-- ABOUT US NAV END --}}

            {{-- ARTICLE NAV START --}}
            <a href="/article" class="nav-item nav-link text-capitalize {{($title === "Artikel") ? "active" : ""}}">Artikel</a>
            {{-- ARTICLE NAV END --}}

            {{-- NEWS NAV START --}}
            <a href="/news" class="nav-item nav-link text-capitalize {{($title === "Berita") ? "active" : ""}}">Berita</a>
            {{-- NEWS NAV END --}}

            {{-- ACTIVITY NAV START --}}
            <a href="/event" class="nav-item nav-link text-capitalize {{($title === "Kegiatan") ? "active" : ""}}">Kegiatan</a>
            {{-- ACTIVITY NAV END --}}

            {{-- JADWALIN NAV START --}}
            <a href="/schedule" class="nav-item nav-link text-capitalize {{($title === "Jadwal") ? "active" : ""}}">Jadwal</a>
            {{-- JADWALIN NAV END --}}

            {{-- FITURE NAV START --}}
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle text-capitalize {{($title === "Layanan") ? "active" : ""}}" data-bs-toggle="dropdown">Layanan</a>
                <div class="dropdown-menu bg-light m-0">
                    <a href="/service/hitungproker" class="dropdown-item">Hitung Proker (Kestari)</a>
                    <a href="/service/shortlink" class="dropdown-item">Perpendek URL</a>
                </div>
            </div>
            {{-- FITURE NAV END --}}

            {{-- USER NAV START --}}
            @guest
                <div class="nav-item dropdown">
                    <a
                    href="#"
                    class="nav-link dropdown-toggle text-capitalize {{($title === "Masuk" || $title === "Daftar") ? "active" : ""}}  "
                    data-bs-toggle="dropdown"
                    ><span class="fa fa-user"></span> Pengunjung</a>
                    <div class="dropdown-menu bg-light m-0">
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
                            <img class="rounded-circle" src="https://source.unsplash.com/20x20?bee" alt="" style="width: 20px; height: 20px;">
                        @else
                            <img class="rounded-circle" src="{{asset('Images/uploads/profiles')}}/{{Auth::User()->profile->profilepicture}}" alt="" style="width: 20px; height: 20px;">
                        @endif
                        {{-- <img class="rounded-circle" src="{{ asset('Images/Icons/guesticon.png') }}" alt="" style="width: 20px; height: 20px;"> --}}
                    </span>{{ Auth::user()->name }}</a>
                    <div class="dropdown-menu bg-light m-0">
                        @if (Auth::user()->is_admin==1)
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
