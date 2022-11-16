<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Print Layout &#9679; LDK Syahid</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <style>

        </style>
    </head>
    {{-- <img src="{{ public_path(Auth::User()->profile->profilepicture) }}" alt=""> --}}
    <body>
        <div class="mx-3 my-5">
            <div class="col-12">
                <h3 class="m-0">
                    <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" width="55" height="55" alt="Logo LDK Syahid"> </i>UKM LDK Syahid
                </h3>
            </div>
            <div class="col-12 my-3">
                <div class="row">
                    <div class="col-6">
                        <h6>#KitaAdalahSaudara</h6>
                    </div>
                    <div class="col-6 text-end">
                        <a href="#" class="nav-link dropdown-toggle text-lowercase" data-bs-toggle="dropdown"><span class="mr-5">
                            @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                                <img class="rounded-circle" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 27px; height: 27px;">
                            @else
                                <img class="rounded-circle" src="/{{Auth::User()->profile->profilepicture}}" alt="" style="width: 20px; height: 20px;">
                            @endif
                        </span>{{ Auth::user()->email }}</a>
                    </div>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="col-6 text-center">
                    <img src="../{{Auth::User()->profile->profilepicture}}" alt="" style="object-fit: cover"  width= "300px" height= "500px"/> <br> <i class="small">{{Auth::User()->profile->mottohidup}}</i>
                </div>
                <div class="col-6">

                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script>
            window.print();
        </script>
    </body>
</html>

{{-- <!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            Print Layout &#9679; LDK Syahid
        </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="keywords" />
        <meta content="" name="description" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


        <!-- Favicon -->
        <link href="{{ asset('Images/Logos/logoldksyahid.png') }}" rel="icon" />



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
        <script src="{{ asset('KestariHitungProkerbyYuda/js/code.js') }}" charset="utf-8" async></script>
    </head>

    <body>


        <div>
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-white navbar-light  sticky-top px-4 px-lg-5 py-lg-0">
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
                                <a href="#" class="nav-link dropdown-toggle text-lowercase" data-bs-toggle="dropdown"><span class="mr-5">
                                    @if (Auth::User()->profile == null || Auth::User()->profile->profilepicture == null)
                                        <img class="rounded-circle" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setDimension(600)->setFontSize(325)->toBase64() }}" alt="" style="width: 27px; height: 27px;">
                                    @else
                                        <img class="rounded-circle" src="/{{Auth::User()->profile->profilepicture}}" alt="" style="width: 20px; height: 20px;">
                                    @endif
                                </span>{{ Auth::user()->email }}</a>
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
                    </div>
                </div>
            </nav>
            <!-- Navbar End -->
        </div>


        <div class="container-xxl py-1">
            <div class="container">
                <div class="row g-5">
                    <div class="col-6">
                        <a href=""><strong>#KitaAdalahSaudara</strong></a>
                        <div class="position-relative overflow-hidden ps-5 pt-5 h-100" style="min-height: 400px">
                            @if (Auth::User()->profile->profilepicture == null)
                                <img class="position-sticky img-fluid" src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setShape('square')->setDimension(500)->setFontSize(250)->toBase64() }}" alt="" style="object-fit: cover;" width= "500px" height= "700px"/>
                            @else
                                <img class="position-sticky img-fluid" src="../{{Auth::User()->profile->profilepicture}}" alt="" style="object-fit: cover"  width= "500px" height= "700px"/>
                            @endif
                            <div class="text-center mt-3">
                                <a href=""><i>{{Auth::User()->profile->mottohidup}}</i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="h-100">
                            <div class="border-start border-5 border-primary ps-4 mb-5">
                                <div class="row">
                                    <div class="col-6">
                                        <h6 class="text-body mb-2">{{ substr(Auth::user()->name,0, 19) }}</h6>
                                        <h1 class="display-4 mb-0">{{Auth::User()->profile->namapanggilan}}</h1>
                                    </div>
                                    <div class="col-6 text-end">
                                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="LDK Syahid" width="100px" height="100px">
                                    </div>
                                </div>
                            </div>
                            <p class="" style="text-align: justify">{{Auth::User()->profile->tentangdiri}}</p>
                            <div class="pe-3 pb-3" style="width: 300px; height: 100px">
                                <div class=" justify-content-center text-center h-100 p-3">
                                    <h3 class="text-secondary small">Sipaling {{Auth::User()->profile->sifat}} ?</h3>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-sm-6 d-flex">
                                    <i class="fab fa-instagram fa-2x text-primary flex-shrink-0 me-3"></i>
                                    <div class="row">
                                        <h6 class="mb-0">Akun Instagram</h6><br>
                                        <p class="mb-0">{{Auth::User()->profile->akuninstagram}}</p>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row g-4">
                                <div class="col-sm-6 d-flex">
                                    <i class="fab fa-linkedin fa-2x text-primary flex-shrink-0 me-3"></i>
                                    <div class="row">
                                        <h6 class="mb-0">Akun LinkedIn</h6><br>
                                        <p class="mb-0">{{Auth::User()->profile->akunlinkedin}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="border-top mt-4 pt-4">
                            <div class="row g-4">
                                <div class="col-6">
                                    <i class="fa fa-university fa-2x text-primary flex-shrink-0 me-3"></i>
                                    <div class="row">
                                        <h6 class="mb-0">Universitas</h6><br>
                                        <p class="mb-0">{{Auth::User()->profile->universitas}}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <i class="fa fa-building fa-2x text-primary flex-shrink-0 me-3"></i>
                                    <div class="row">
                                        <h6 class="mb-0">Fakultas</h6><br>
                                        <p class="mb-0">{{Auth::User()->profile->fakultas}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3">
                            <div class="row g-4">
                                <div class="col-6">
                                    <i class="fas fa-book-reader fa-2x text-primary flex-shrink-0 me-3"></i>
                                    <div class="row">
                                        <h6 class="mb-0">Program Studi</h6><br>
                                        <p class="mb-0">{{Auth::User()->profile->programstudi}}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-chess-pawn fa-2x text-primary flex-shrink-0 me-3"></i>
                                    <div class="row">
                                        <h6 class="mb-0">Forum Angkatan</h6><br>
                                        <p class="mb-0">{{Auth::User()->profile->forkat}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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

        @yield('scripts')

        @include('sweetalert::alert')

    </body>
</html> --}}
