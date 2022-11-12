<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>
            500 Server Error &#9679; LDK Syahid
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
        <link rel="stylesheet" href="{{ asset('e500/style.css') }}">
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
        <!-- Spinner Start -->
        <div
        id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
        >
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
        <!-- Spinner End -->

        {{-- Body Landing Page Start --}}
        <!-- 500 Start -->
        <div class="container">
            <div class="compcontainer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 90.5 74.769">
                    <path fill="#C7CCDB" d="M58.073 74.769H32.426l6.412-19.236h12.824z"/>
                    <path fill="#373F45" d="M90.5 52.063c0 1.917-2.025 3.471-4.525 3.471H4.525C2.025 55.534 0 53.98 0 52.063V3.471C0 1.554 2.026 0 4.525 0h81.449c2.5 0 4.525 1.554 4.525 3.471v48.592z"/>
                    <path fill="#F1F2F2" d="M84.586 46.889c0 1.509-1.762 2.731-3.936 2.731H9.846c-2.172 0-3.933-1.223-3.933-2.731V8.646c0-1.508 1.761-2.732 3.933-2.732H80.65c2.174 0 3.936 1.225 3.936 2.732v38.243z"/>
                    <path fill="#A2A7A5" d="M16.426 5.913L8.051 23h13l-6.875 12.384L26.75 46.259l-8.375-11.375L26.75 20H14.625l6.801-14.087zM68.551 49.62l-8.375-17.087h13l-6.875-12.384L78.875 9.274 70.5 20.649l8.375 14.884H66.75l6.801 14.087z"/>
                </svg>
            </div>
            <h1 class="header">500 SERVER ERROR</h1>
            <div class="instructions border-start border-end border-bottom border-top border-5 border-primary mb-5 p-5">
                <h2>Maaf, Sepertinya Kami Sedang Memililiki Beberapa Kendala Dengan Server</h3>
                <p>Silahkan Coba Lagi Secara Berkala Atau Esok Hari <br> Terimakasih ^_^</p>
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <a class="btn btn-primary py-3 px-5" href="/">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- 500 End -->
        {{-- Body Landing Page End --}}

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
        {{-- Script Landing Page Start --}}
        @yield('scripts')
        {{-- Script Landing Page End --}}
        @include('sweetalert::alert')
    </body>
</html>
