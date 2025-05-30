<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <meta property="og:title" content="Ekspresi &#9679; LDK Syahid" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <meta property="og:description" content="Eksplorasi Potensi Diri Islami" />

    <title>Ekspresi &#9679; LDK Syahid</title>


    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap");


        .timeline>ul {
            --col-gap: 2rem;
            --row-gap: 2rem;
            --line-w: 0.25rem;
            display: grid;
            grid-template-columns: var(--line-w) 1fr;
            grid-auto-columns: max-content;
            column-gap: var(--col-gap);
            list-style: none;
            width: min(60rem, 90%);
            margin-inline: auto;
        }

        /* line */
        .timeline>ul::before {
            content: "";
            grid-column: 1;
            grid-row: 1 / span 20;
            background: rgb(255, 255, 255, 255);
            border-radius: calc(var(--line-w) / 2);
        }

        /* columns*/

        /* row gaps */
        .timeline>ul li:not(:last-child) {
            margin-bottom: var(--row-gap);
        }

        /* card */
        .timeline>ul li {
            grid-column: 2;
            --inlineP: 1.5rem;
            margin-inline: var(--inlineP);
            grid-row: span 2;
            display: grid;
            grid-template-rows: min-content min-content min-content;
        }

        /* date */
        .timeline>ul li .date {
            --dateH: 3rem;
            height: var(--dateH);
            margin-inline: calc(var(--inlineP) * -1);

            text-align: center;
            background-color: var(--accent-color);

            color: white;
            font-size: 1.25rem;
            font-weight: 700;

            display: grid;
            place-content: center;
            position: relative;

            border-radius: 15px;
        }

        /* circle */
        .timeline>ul li .date::after {
            content: "";
            position: absolute;
            width: 2rem;
            aspect-ratio: 1;
            background: var(--bgColor);
            border: 0.3rem solid var(--accent-color);
            border-radius: 50%;
            top: 50%;

            transform: translate(50%, -50%);
            right: calc(100% + var(--col-gap) + var(--line-w) / 2);
        }

        /* title descr */
        .timeline>ul li .title,
        .timeline>ul li .descr {
            background: var(--bgColor);
            position: relative;
            padding-inline: 1.5rem;
        }

        .timeline>ul li .title {
            overflow: hidden;
            padding-block-start: 1.5rem;
            padding-block-end: 1rem;
            font-weight: 500;
        }

        .timeline>ul li .descr {
            padding-block-end: 1.5rem;
            font-weight: 300;
        }

        /* shadows */
        .timeline>ul li .title::before,
        .timeline>ul li .descr::before {
            content: "";
            position: absolute;
            width: 90%;
            height: 0.5rem;
            background: rgba(0, 0, 0, 0.5);
            left: 50%;
            border-radius: 50%;
            filter: blur(4px);
            transform: translate(-50%, 50%);
        }

        .timeline>ul li .title::before {
            bottom: calc(100% + 0.125rem);
        }

        .timeline>ul li .descr::before {
            z-index: -1;
            bottom: 0.25rem;
        }

        @media (min-width: 40rem) {
            .timeline>ul {
                grid-template-columns: 1fr var(--line-w) 1fr;
            }

            .timeline>ul::before {
                grid-column: 2;
            }

            .timeline>ul li:nth-child(odd) {
                grid-column: 1;
            }

            .timeline>ul li:nth-child(even) {
                grid-column: 3;
            }

            /* start second card */
            .timeline>ul li:nth-child(2) {
                grid-row: 2/4;
            }

            .timeline>ul li:nth-child(odd) .date::before {
                clip-path: polygon(0 0, 100% 0, 100% 100%);
                left: 0;
            }

            .timeline>ul li:nth-child(odd) .date::after {
                transform: translate(-50%, -50%);
                left: calc(100% + var(--col-gap) + var(--line-w) / 2);
            }

            .timeline>ul li:nth-child(odd) .date {
                border-radius: 15px;
            }
        }
    </style>

    <!-- Favicons -->
    <link href="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm" rel="icon">
    <link href="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('arsha/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('arsha/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('arsha/css/style2024v1.css') }}" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Arsha
    * Updated: Jul 27 2023 with Bootstrap v5.3.1
    * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <h1 class="logo me-auto"><a href="#"><b>EKSPRESI 2024</b></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            {{-- <a href="index.html" class="logo me-auto"><img src="https://lh3.googleusercontent.com/d/1FlzBWS4ogRCHtYkOIhBw1h3hoTgK3aV6" alt="" class="img-fluid"></a> --}}

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#beranda">Beranda</a></li>
                    <li><a class="nav-link scrollto" href="#logo">Logo</a></li>
                    <li><a class="nav-link scrollto" href="#hyperlink">Hyperlink</a></li>
                    <li><a class="nav-link scrollto" href="#pengenalan">Pengenalan</a></li>
                    <li><a class="nav-link scrollto" href="#syarat">Syarat</a></li>
                    <li><a class="nav-link scrollto" href="#pendaftaran">Pendaftaran</a></li>
                    <li><a class="nav-link scrollto" href="#QnA">Q&A</a></li>
                    <li><a class="getstarted scrollto"
                            href="https://docs.google.com/forms/d/e/1FAIpQLSdPI2XZQn7fH6ic61R6EKDjBiE7aN3ouHs0LI0ZFtx_z8HaPw/viewform?pli=1"
                            target="_blank">Daftar Sekarang</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header>
    <!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="beranda" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    <h1>Esensi Keislaman : Menjadi Pribadi Muslim Sejati di Era Modernisasi</h1>
                    <h2>Berkembang Dalam Inovasi, Bangkitkan Muslim Sejati</h2>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSdPI2XZQn7fH6ic61R6EKDjBiE7aN3ouHs0LI0ZFtx_z8HaPw/viewform?pli=1"
                            class="btn-get-started scrollto" target="_blank">Daftar Sekarang</a>
                        <a href="https://youtu.be/xFJR6aA4NQ0?si=tRvLOxeA5EeXTCaS" class="glightbox btn-watch-video"><i
                                class="bi bi-play-circle"></i><span>Tonton Video</span></a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img text-center" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm"
                        class="img-fluid animated" alt="" style="width: 60%">
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <main id="main">

        <!-- ======= Clients Section ======= -->
        <section id="logo" class="clients section-bg">
            <div class="mx-3">
                <div class="container rounded border-0" style="background-color: #fff">
                    <div class="row justify-content-center" data-aos="zoom-in">

                        <div class="col-lg-12 col-md-4 col-12 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                                class="img-fluid" alt="" style="width: 100px;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1Fj4hZRy7SNQ1Kq72JvY4M557noiULg-i"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1R-3mi9Jzw5vt3-VKVPic9BTvJeFkaikK"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1INzkD8YgOvf5_FVIXEnW40wUCsxJdepp"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1t_dDa8IDgpOnH85RvU67DV3W2CxhSetx"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1yU1Oj1qrFBanjcoj3ZhO1LPFOon7V92-"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1u6mS175Q2Fbqd2k6CRNqKq0E3q5Sde1U"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1Iem3JZgYMXRitO1GOb9lTMVeMjiUQFUI"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1HinEWSv90pL0MUZ1F0dAbyHNSmk2L-B5"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1OZXhHsHd0PR994b75R2N8Qvny_k0aqKQ"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                        <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                            <img src="https://lh3.googleusercontent.com/d/1sr4GI8TE-Z2Og4PBm3hqm1Bb38NryJ6U"
                                class="img-fluid" alt="" style="max-width: 65%;">
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <!-- End Cliens Section -->

        <!-- ======= Services Section ======= -->
        <section id="hyperlink" class="services section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Hyperlink</h2>
                    <p>Klik link berikut untuk melihat informasi lainnya tentang ekspresi</p>
                </div>

                <div class="row text-center justify-content-center">
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSdPI2XZQn7fH6ic61R6EKDjBiE7aN3ouHs0LI0ZFtx_z8HaPw/viewform?pli=1"
                            target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-rocket-takeoff"></i></div>
                                <h4>Pendaftaran Ekspresi</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://drive.google.com/file/d/1SNIv1BS2MMVMS5x1e3JQxwy-h51ELqQW/view?usp=sharing"
                            target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-file-earmark-check"></i></div>
                                <h4>Surat Izin Orangtua</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://wa.me/6283830793225" target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-whatsapp"></i></div>
                                <h4>Pembayaran Ekspresi</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://twb.nz/ekspresi24" target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-reddit"></i></div>
                                <h4>Twibbon Ekspresi</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a style="color: #fff" target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-building-fill-exclamation"></i></div>
                                <h4>Technical Meeting</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://drive.google.com/drive/folders/1NjbGU6lY0NddyRHfZ8wOpI5UbJjVjURz"
                            style="color: #fff" target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-person-badge-fill"></i></div>
                                <h4>Name Tag Peserta</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://drive.google.com/drive/folders/1NltFSepC7yO0VqeyKG3f0yBYGJ3sokD6"
                            style="color: #fff" target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-house-heart"></i></div>
                                <h4>Kelompok Mentoring</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://wa.me/6281294158813" target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-whatsapp"></i></div>
                                <h4>Narahubung Ikhwan</h4>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6 d-flex justify-content-center m-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <a href="https://wa.me/6282113530522" target="_blank" rel="noopener noreferrer">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-whatsapp"></i></div>
                                <h4>Narahubung Akhwat</h4>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Services Section -->

        <!-- ======= Why Us Section ======= -->
        <section id="pengenalan" class="why-us section-bg py-5">
            <div class="container-fluid" data-aos="fade-up">
                <div class="row text-center">
                    <div class="section-title">
                        <h2>Selamat Datang Mahasiswa</h2>
                        {{-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> --}}
                    </div>
                    <div class="owl-ekspresi-aboutus owl-carousel owl-theme">
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>Mahasiswa merupakan unsur perubahan peradaban (agent of change) yang memikul harapan
                                    bangsa.</h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>Sehingganya, semangat (ghirah), kesungguhan (jiddiyah), dan kecerdasan intelektual
                                    yang dimiliki oleh para mahasiswa penting untuk dikembangkan.</h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>Namun semua itu sangat disayangkan apabila tidak dibekali dengan landasan keimanan
                                    yang kuat kepada Allah SWT.</h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>Berpijak pada pemikiran tersebut, LDK Syahid bermaksud melaksanakan kegiatan Latihan
                                    Kader Dakwah (LKD) 2024 yang dinamakan “EKSPRESI - Eksplorasi Potensi Diri Islami
                                    2024.</h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>Kegiatan ini diharapkan dapat memberikan manfaat dan memotivasi para mahasiswa UIN
                                    Syarif Hidayatullah Jakarta untuk terus bersinergi dan mengembangkan potensi diri.
                                </h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>Yang mana potensi tersebut tidak hanya berlandaskan intelektual (fikriyah) saja tapi
                                    juga agama (ruhiyah) dan aplikasinya dalam kehidupan (jasadiyah).</h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>LDK Syahid mengemas kegiatan ini dengan berbagai agenda menarik dan bermanfaat.</h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4>Kegiatan ini diharapkan akan membentuk kepribadian seorang muslim dalam diri para
                                    agent of change sehingga membawa dampak positif bagi perubahan.</h4>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h3>Siapkan dirimu untuk bergabung dan nantikan keseruan kolaborasi kebaikan dari
                                    inisiator yang sudah bergabung di LDK Syahid!</h3>
                            </div>
                        </div>
                        <div
                            class="col-lg-12 d-flex flex-column justify-content-center align-items-stretch order-2 order-lg-1">
                            <div class="content">
                                <h4><b>Daftar sekarang</b>, karena kamu juga akan berkesempatan ikut salah satu KMB
                                    (Kelas Minat Bakat) yang ada di LDK Syahid.</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Why Us Section -->

        <!-- ======= About Us Section ======= -->
        <section id="syarat" class="about section-bg">
            <div class="container" data-aos="fade-up">

                <div class="mx-3">
                    <div class="section-title">
                        <h2>Syarat Pendaftaran</h2>
                    </div>

                    <div class="row content">
                        <div class="col-lg-5 border-rules">
                            <p class="p-2">
                                Mahasiswa aktif UIN Syarif Hidayatullah Jakarta semester 1 & 3 (Dibuktikan dengan
                                KTM/KRS)
                            </p>
                        </div>
                        <div class="col-lg-2 pt-4 pt-lg-0"></div>
                        <div class="col-lg-5 border-rules">
                            <p class="p-2">
                                Siap belajar dan berkomitmen tinggi di LDK Syahid UIN Jakarta
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End About Us Section -->

        <!-- ======= Skills Section ======= -->
        <section id="pendaftaran" class="skills section-bg">
            <div class="container" data-aos="fade-up">

                <div class="row">
                    <div class="col-lg-4 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
                        <h3>Tanggal Penting</h3>
                        <br>
                        <div class="border-rules">
                            <div class="p-2">
                                <p><b>2 September 2024 - 6 Oktober 2024</b> <br> Pendaftaran (Mengisi Form Pendaftaran)
                                </p>
                            </div>
                        </div>
                        <br>
                        <div class="border-rules">
                            <div class="p-2">
                                <p><b>09 Oktober 2024</b> <br> Technical Meeting</p>
                            </div>
                        </div>
                        <br>
                        <div class="border-rules">
                            <div class="p-2">
                                <p><b>11 - 13 Oktober 2024</b> <br> Mengikuti EKSPRESI </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 pt-4 pt-lg-0 content timeline" data-aos="fade-right" data-aos-delay="100">
                        <h3 class="text-end">Tata Cara Pendaftaran</h3>
                        <ul class="mt-5">
                            <li style="--accent-color:#CFAF76">
                                <div class="date">Langkah 1</div>
                                <div class="title">
                                    <p>Buka Website</p>
                                </div>
                                <div style="z-index : 1">
                                    <p>Masuk ke website Ekspresi LDK syahid <a href="https://www.ldksyah.id/ekspresi"
                                            target="_blank" rel="noopener noreferrer">(ldksyah.id/ekspresi)</a> dan
                                        klik <a
                                            href="https://docs.google.com/forms/d/e/1FAIpQLSdPI2XZQn7fH6ic61R6EKDjBiE7aN3ouHs0LI0ZFtx_z8HaPw/viewform?pli=1"
                                            target="_blank" rel="noopener noreferrer">Daftar Sekarang</a></p>
                                </div>
                            </li>
                            <li style="--accent-color:#5aa7a8">
                                <div class="date">Langkah 2</div>
                                <div class="title">
                                    <p>Siapkan Berkas</p>
                                </div>
                                <div>
                                    <p>Untuk memudahkan pengisian form, silahkan siapkan berkas yang dibutuhkan</p>
                                    <div class="border-rules">
                                        <p class="p-2">KTM (Kartu tanda Mahasiswa) / KRS (Kartu Rencana Studi)</p>
                                    </div>
                                    <br>
                                    <div class="border-rules">
                                        <p class="p-2">Bukti pembayaran EKSPRESI (jika melakukan pembayaran secara
                                            tunai, silahkan ke stand EKSPRESI terdekatmu untuk meminta kwitansi sebagai
                                            bukti pembayaran)</p>
                                    </div>
                                </div>
                            </li>
                            <li style="--accent-color:#366566">
                                <div class="date">Langkah 3</div>
                                <div class="title">
                                    <p>Download File Izin Orang Tua</p>
                                </div>
                                <div style="z-index : 1">
                                    <p>Ditengah pertanyaan akan ada file izin orang tua yang harus kamu download,
                                        pastikan kamu tidak lupa mendownload file tersebut</p>
                                </div>
                            </li>
                            <li style="--accent-color:#CFAF76">
                                <div class="date">Langkah 4</div>
                                <div class="title">
                                    <p>Isi Semua Pertanyaan Dan Kirim</p>
                                </div>
                                <div>
                                    <p>Pastikan semua pertanyaan telah diisi, lalu silahkan submit pendaftaran kemudian
                                        join grup yang ada di akhir informasi pendaftaran</p>
                                </div>
                            </li>
                            <li style="--accent-color:#5aa7a8">
                                <div class="date">Langkah 5</div>
                                <div class="title">
                                    <p>Pergi ke stand Ekspresi Membawa File Izin Orang Tua</p>
                                </div>
                                <div style="z-index : 1">
                                    <p>Setelah mengisi semua rangkaian pendaftaran, selanjutnya silahkan isi file izin
                                        orang tua lalu serahkan ke stand EKSPRESI terdekatmu sebagai bukti kamu telah
                                        mengisi pendaftaran (wajib diserahkan)</p>
                                </div>
                            </li>
                            <li style="--accent-color:#366566">
                                <div class="date">Langkah 6</div>
                                <div class="title">
                                    <p>Contact Person</p>
                                </div>
                                <div>
                                    <p>Jika ada pertanyaan lebih lanjut silahkan menghubungi nomor berikut</p>
                                    <div class="border-rules">
                                        <p class="p-2">Ikhwan : <a href="http://wa.me/6281294158813"
                                                target="_blank" rel="noopener noreferrer">081294158813 </a><br>(Aldi
                                            Tri
                                            Prasetyo)</p>
                                    </div>
                                    <br>
                                    <div class="border-rules">
                                        <p class="p-2">Akhwat : <a href="http://wa.me/6282113530522"
                                                target="_blank" rel="noopener noreferrer">082113530522
                                            </a><br>(Ananda Nurul Aziza)</p>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Skills Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="QnA" class="faq section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Masih Bingung?</h2>
                    <p>Kalian ingin tahu pertanyaan yang sering ditanyakan seputar Ekspresi? Yuk cek kolom di bawah</p>
                </div>

                <div class="faq-list">
                    <ul>
                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                class="collapse faq" data-bs-target="#faq-list-1">Kak, EKSPRESI itu apa sih?<i
                                    class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-1" class="collapse" data-bs-parent=".faq-list">
                                <p class="answere">
                                    EKSPRESI itu Eksplorasi Potensi Diri Islami yaitu gerbang masuk utama untuk menjadi
                                    anggota LDK Syahid
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                class="collapse faq" data-bs-target="#faq-list-2"> Kegiatan EKSPRESI ada apa aja kak?
                                <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-2" class="collapse" data-bs-parent=".faq-list">
                                <p class="answere">
                                    Akan ada materi dari pemateri kece loh, ada games, ada kelas minat dan bakat, dan
                                    masih banyak lagi keseruannya deh
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                class="collapse faq" data-bs-target="#faq-list-3">Syaratnya kalau mau ikut EKSPRESI
                                apa aja kak? <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-3" class="collapse" data-bs-parent=".faq-list">
                                <p class="answere">
                                    Syaratnya gampang banget loh, yaitu Mahasiswa aktif semester 1 dan 3 yang siap
                                    belajar serta mau berkomitmen penuh menjadi anggota LDK Syahid
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                class="collapse faq" data-bs-target="#faq-list-4">Pendaftarannya Sampai Kapan kak? <i
                                    class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-4" class="collapse" data-bs-parent=".faq-list">
                                <p class="answere">
                                    Di Catat yah, jangan sampai kamu ketinggalan!! Untuk tanggal pendaftarannya kita
                                    buka dari 2 September - 6 Oktober 2024
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                class="collapse faq" data-bs-target="#faq-list-5">Biasanya Kalau mau daftar EKSPRESI
                                dimana kak? <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-5" class="collapse" data-bs-parent=".faq-list">
                                <p class="answere">
                                    Kamu bisa langsung kunjungi website LDK Syahid dan pilih tombol 'Daftar Sekarang'
                                    atau datang langsung ke stand utama EKSPRESI yang ada di Gazebo Taman FITK (Kampus
                                    1)
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse"
                                class="collapse faq" data-bs-target="#faq-list-6">Kira-Kira Biaya Pendaftarannya mahal
                                gk ya kak? <i class="bx bx-chevron-down icon-show"></i><i
                                    class="bx bx-chevron-up icon-close"></i></a>
                            <div id="faq-list-6" class="collapse" data-bs-parent=".faq-list">
                                <p class="answere">
                                    Untuk biaya pendaftarannya terjangkau banget loh yaitu sebesar 60.000 sudah include
                                    marchindise EKSPRESI, buku KIT Peserta, tempat menginap, biaya makan dan biaya
                                    transportasi.
                                </p>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </section>
        <!-- End Frequently Asked Questions Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>UKM LDK Syahid</h3>
                        <p style="color: #fff">
                            Lt. 3 Gedung SC UIN Jakarta <br>
                            Tangerang Selatan, Banten<br>
                            Indonesia <br><br>
                            <strong>Kontak:</strong> +62 851-5936-0504<br>
                            <strong>Email:</strong> ldk@apps.uinjkt.ac.id<br>
                        </p>
                    </div>

                    <div class="col-lg-6 col-md-6 d-flex justify-content-center footer-links">
                        <img src="https://lh3.googleusercontent.com/d/1ZUo19ZkNHE_fkWp4wiEpzr2Zjvca-VCm"
                            class="" alt="" style="width: 35%">
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Sosial Media Kami</h4>
                        <p>Segera ikuti sosial media kami untuk info dan update terbaru</p>
                        <div class="social-links mt-3">
                            <a href="https://www.instagram.com/ldksyahid/" class="instagram" target="_blank"><i
                                    class="bx bxl-instagram"></i></a>
                            <a href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ/"
                                class="youtube" target="_blank"><i class="bx bxl-youtube"></i></a>
                            <a href="https://www.tiktok.com/@ldksyahid?_t=8pS7g4CSfX6&_r=1"
                                class="tiktok" target="_blank"><i class="bx bxl-tiktok"></i></a>
                            <a href="https://twitter.com/ldksyahid/" class="twitter" target="_blank"><i
                                    class="bx bxl-twitter"></i></a>
                            <a href="https://www.facebook.com/ldksyahid/" class="facebook" target="_blank"><i
                                    class="bx bxl-facebook"></i></a>
                            <a href="https://www.linkedin.com/company/ukm-ldk-syahid-uin-syarif-hidayatullah-jakarta"
                                class="linkedin" target="_blank"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; <a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid UIN Syarif Hidayatullah
                    Jakarta - #KitaAdalahSaudara</a>
                <p>All Right Reserved.</p>
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/ -->
                Designed by <a href="https://bootstrapmade.com/" target="_blank">BootstrapMade</a>
                <br>
                Distributed by <a href="https://www.ldksyah.id/itsupport" target="_blank">IT Support UKM LDK
                    Syahid</a>
                <br>
                Managed by <a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a>
            </div>
        </div>
    </footer><!-- End Footer -->
    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('arsha/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('arsha/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('arsha/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('arsha/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('arsha/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('arsha/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('arsha/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('arsha/js/main.js') }}"></script>
    <script>
        $(".owl-ekspresi-aboutus").owlCarousel({
            dots: true,
            items: 1,
            loop: true,
            nav: false,
        });
    </script>

</body>

</html>
