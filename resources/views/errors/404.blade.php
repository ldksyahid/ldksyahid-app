<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>
            404 Not Found &#9679; LDK Syahid
        </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="keywords" />
        <meta content="" name="description" />
        <link href="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" rel="icon" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>
        <link href="{{ asset('landing-page-ext-rsrc/lib/animate/animate.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/css/bootstrap.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('landing-page-ext-rsrc/css/style.css') }}" rel="stylesheet" />
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.esm.js"></script>
	    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/"></script>
        <script src="{{ asset('proker-counter-by-yuda-ext-rsrc/js/code.js') }}" charset="utf-8" async></script>
    </head>

    <style>
        #spinner .spinner-grow {
            width: 3rem;
            height: 3rem;
            border-width: 0.5rem;
        }

        body {
            background: #f4f4f4;
            color: #333;
            font-family: 'Roboto', sans-serif;
             overflow: hidden;
        }
        .container {
            padding: 5% 0;
        }
        img {
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            font-size: 2.5rem;
            color: #00a79d;
        }
        p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }
        .btn-primary {
            background-color: #00a79d;
            border-color: #00a79d;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 1.1rem;
        }
    </style>

    <body>
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>

        <div class="wow fadeInUp" data-wow-delay="0.1s">
            <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-12 mb-5" >
                    <img src="https://lh3.googleusercontent.com/d/1K96icn3irTFOATLyqYgdfAvES8vorV2v" alt="" width="300" height="300">
                    <h1 class="my-3">Halaman tidak ditemukan</h1>
                    <p>
                        Maaf, halaman yang Kamu cari tidak ada disini!
                    </p>
                    <a class="btn btn-primary py-3 px-5" href="/">Kembali ke Beranda</a>
                </div>
            </div>
            </div>
        </div>

        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/wow/wow.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('landing-page-ext-rsrc/js/main.js') }}"></script>
        @yield('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new WOW().init();
            });
        </script>
    </body>
</html>
