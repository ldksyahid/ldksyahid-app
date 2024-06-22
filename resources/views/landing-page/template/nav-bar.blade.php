<!-- Topbar Start -->
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
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
            <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" width="55" height="55" alt="Logo LDK Syahid"> </i>LDK Syahid
        </h3>
        <h6 class="m-0 mobile-responsive">
            <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" width="44" height="44" alt="Logo LDK Syahid"> </i>
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
                <div class="dropdown-menu bg-light m-0">
                    <a href="/about/structure" class="nav-item dropdown-item">Struktur Pengurus</a>
                    <a href="/about/contact" class="nav-item dropdown-item">Hubungi Kami</a>
                    <a href="/about/gallery" class="nav-item dropdown-item">Galeri</a>
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

            {{-- JADWALIN NAV START --}}
            <a href="/schedule" class="nav-item nav-link text-capitalize {{($title === "Jadwal") ? "active" : ""}}">Jadwal</a>
            {{-- JADWALIN NAV END --}}

            {{-- LAYANAN NAV START --}}
            <a href="/service" class="nav-item nav-link text-capitalize {{($title === "Layanan") ? "active" : ""}}">Layanan</a>
            {{-- LAYANAN NAV END --}}

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
                            <img class="rounded-circle" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 27px; height: 27px;">
                        @else
                            <img class="rounded-circle" src="https://lh3.googleusercontent.com/d/{{Auth::User()->profile->gdrive_id}}" alt="" style="width: 20px; height: 20px;">
                        @endif
                    </span>{{ substr(Auth::user()->name,0, 15) }}</a>
                    <div class="dropdown-menu bg-light m-0">
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
