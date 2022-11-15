<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>
            Print Layout &#9679; LDK Syahid
        </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="keywords" />
        <meta content="" name="description" />


        <!-- Favicon -->
        <link href="{{ asset('Images/Logos/logoldksyahid.png') }}" rel="icon" />
        {{-- <link rel="shortcut icon" href="{{ asset('KestariHitungProkerbyYuda/images/kestari.ico') }}" type="image/x-icon"> --}}


        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap"
        rel="stylesheet"
        />

        <!-- Icon Font Stylesheet -->
        <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css"
        rel="stylesheet"
        />
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"
        rel="stylesheet"
        />

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('e404/css/bd-coming-soon.css') }}" rel="stylesheet" />
        <link href="{{ asset('e404/css/bd-coming-soon.css.map') }}" rel="stylesheet" />
        <link href="{{ asset('LandingPageSource/lib/animate/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('LandingPageSource/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('KestariHitungProkerbyYuda/css/style.css') }}">

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('LandingPageSource/css/bootstrap.min.css') }}" rel="stylesheet" />

        <!-- Template Stylesheet -->
        <link href="{{ asset('LandingPageSource/css/style.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/"></script>
    </head>

    <body>
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
                            <a href="/about/structure" class="nav-item dropdown-item">Struktur Pengurus</a>
                            <a href="/about/contact" class="nav-item dropdown-item">Hubungi Kami</a>
                            <a href="/about/gallery" class="nav-item dropdown-item">Galeri</a>
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
                                    <img class="rounded-circle" src="/{{Auth::User()->profile->profilepicture}}" alt="" style="width: 20px; height: 20px;">
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

        {{-- Body Landing Page Start --}}
        <div class="container-xxl py-5" id="photo" >
            <div class="container">
                <div class="row g-5">
                    <div class="col-6">
                        <div class="position-relative overflow-hidden ps-5 pt-5 h-100" style="min-height: 400px">
                                @if (Auth::User()->profile->profilepicture == null)
                                    <img class="position-sticky img-fluid" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setShape('square')->setDimension(500)->setFontSize(250)->toBase64() }}" alt="" style="object-fit: cover;" width= "500px" height= "700px"/>
                                @else
                                    <img class="position-sticky img-fluid" src="{{Auth::User()->profile->profilepicture}}" alt="" style="object-fit: cover"  width= "500px" height= "700px"/>
                                @endif
                            <div class="position-absolute top-0 start-0 bg-white pe-3 pb-3" style="width: 250px; height: 150px">
                                <div class="d-flex flex-column justify-content-center text-center bg-primary h-100 p-3">
                                    <h5 class="text-white bg-primary">Sipaling {{Auth::User()->profile->sifat}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h-100">
                            <div class="border-start border-5 border-primary ps-4 mb-5">
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-body mb-2">{{ Auth::user()->name }}</h6>
                                        <h1 class="display-4 mb-0">{{Auth::User()->profile->namapanggilan}}</h1>
                                    </div>
                                    <div class="col-6 text-end">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="LDK Syahid" width="100px" height="100px">
                                    </div>
                                </div>
                            </div>
                            <p class="" style="text-align: justify">{{Auth::User()->profile->tentangdiri}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Body Landing Page End --}}

        <!-- Footer Start -->
        <div class="container-fluid bg-dark footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h2 class="text-white mb-4">
                            <img src='{{ asset('Images/Logos/logoldksyahid.png') }}' width="55" height="55" alt="Logo LDK Syahid"> LDK Syahid
                        </h2>
                        <p style="text-align: justify">
                            Lembaga Dakwah Kampus UIN Syarif Hidayatullah (LDK Syahid) merupakan Unit Kegiatan Mahasiswa (UKM) yang berada di bawah naungan UIN Syarif Hidayatullah Jakarta.
                        </p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-square btn-outline-primary me-1" href="https://www.facebook.com/ldksyahid/" target="_blank"
                            ><i class="fab fa-facebook-f"></i
                            ></a>
                            <a class="btn btn-square btn-outline-primary me-1" href="https://twitter.com/ldksyahid/" target="_blank"
                            ><i class="fab fa-twitter"></i
                            ></a>
                            <a class="btn btn-square btn-outline-primary me-1" href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ?app=desktop/" target="_blank"
                            ><i class="fab fa-youtube"></i
                            ></a>
                            <a class="btn btn-square btn-outline-primary me-0" href="https://www.instagram.com/ldksyahid/" target="_blank"
                            ><i class="fab fa-instagram"></i
                            ></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Alamat</h4>
                        <p style="text-align: justify">
                            <i class="fas fa-map-marker-alt me-3"></i>Lt. 3 Gedung SC UIN Jakarta
                        </p>
                        <p><i class="fas fa-phone-alt me-3"></i>+62 851-5936-0504</p>
                        <p><i class="fa fa-envelope me-3"></i>ldk@uinjkt.ac.id</p>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Akses Cepat</h4>
                        <a class="btn btn-link" href="/about/contact">Hubungi Kami</a>
                        <a class="btn btn-link" href="/article">Artikel</a>
                        <a class="btn btn-link" href="/news">Berita</a>
                        <a class="btn btn-link" href="/event">Kegiatan</a>
                        <a class="btn btn-link" href="/schedule">Jadwal</a>
                        <a class="btn btn-link" href="/service/hitungproker">Hitung Proker (Kestari)</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h4 class="text-light mb-4">Berlangganan</h4>
                        <p style="text-align: justify">Dapatkan Informasi terkini yang akan dikirimkan melewati Email kamu Seputar LDK Syahid UIN Syarif Hidayatullah Jakarta dengan cara berlangganan bersama Kami</p>
                        <form action="{{ route('subscribers.store') }}" method="post">
                        @csrf
                            <div class="position-relative mx-auto" style="max-width: 400px">
                                <input class="form-control bg-transparent w-100 py-3 ps-4 pe-5" type="email" name="email" placeholder="Email kamu"/>
                                <input type="submit" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2" value="Daftar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container-fluid copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a href="#">UKM LDK Syahid UIN Syarif Hidayatullah Jakarta - #KitaAdalahSaudara</a>
                            <p>All Right Reserved.</p>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                            Designed By <a href="https://htmlcodex.com" target="_blank">HTML Codex</a>
                            <br/>
                            Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                            <br>
                            Developed By <a href="/itsupport" target="_blank">IT Support UKM LDK Syahid</a>
                            <br>
                            Managed By <a href="/">UKM LDK Syahid</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- JavaScript Libraries -->
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('LandingPageSource/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('LandingPageSource/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('LandingPageSource/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('LandingPageSource/lib/owlcarousel/owl.carousel.min.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('LandingPageSource/js/main.js') }}"></script>
        <script>
            window.print();
        </script>
    </body>
</html>

