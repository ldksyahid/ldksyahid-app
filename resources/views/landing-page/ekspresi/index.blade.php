@php
    $googleDriveLogoId = '1nQ3wAqQlB8_4mxETAWM8VcDwgAaOjEv2';
    $logoEkspresiUrl = !empty($googleDriveLogoId) 
        ? "https://lh3.googleusercontent.com/d/{$googleDriveLogoId}" 
        : asset('landing-page-ext-rsrc/img/ekspresi-2026-logo.png');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Finding Direction, Building Civilization: Menjadi Muslim Berdaya di Tengah Perubahan Zaman" name="description">
    <meta content="Ekspresi, LDK Syahid, UIN Jakarta, Kaderisasi, Ekspresi 30, 2026" name="keywords">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <meta property="og:title" content="EKSPRESI 2026 &#9679; LDK Syahid" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ $logoEkspresiUrl }}" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <meta property="og:description" content="Finding Direction, Building Civilization: Menjadi Muslim Berdaya di Tengah Perubahan Zaman" />

    <title>EKSPRESI 2026 &#9679; LDK Syahid</title>

    <link href="{{ $logoEkspresiUrl }}" rel="icon">
    <link href="{{ $logoEkspresiUrl }}" rel="apple-touch-icon">

    @include('landing-page.ekspresi._index-styles-v2')

    <!-- =======================================================
    * Template Name: Arsha
    * Updated: Jul 27 2023 with Bootstrap v5.3.1
    * Template URL: https://bootstrapmade.com/arsha-free-bootstrap-html-template-corporate/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>
    @include('landing-page.ekspresi.template.nav-bar')
    <!-- ======= Hero Section ======= -->
    <section id="beranda" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up" data-aos-delay="200">
                    <h1 class="fw-bold">Finding Direction, Building Civilization: Menjadi Muslim Berdaya di Tengah Perubahan Zaman</h1>
                    <h2>Eksplorasi Potensi Diri Islami 2026 — LDK Syahid UIN Syarif Hidayatullah Jakarta</h2>
                    <div class="d-flex flex-column flex-md-row justify-content-center justify-content-lg-start">
                        <a href="https://ldksyah.id/ekspresi26"
                            class="btn-get-started scrollto mb-3 mb-md-0 me-md-3" target="_blank" rel="noopener noreferrer">Daftar Sekarang</a>
                        <a href="https://youtu.be/oReHVyhX8xQ?si=rqtMWSf-LcY88ViQ" class="glightbox btn-watch-video d-flex align-items-center"><i
                                class="bi bi-play-circle me-2"></i><span>Tonton Video</span></a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img text-center" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{ $logoEkspresiUrl }}"
                        class="img-fluid animated" alt="Logo EKSPRESI 2026" style="max-height: 380px;">
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <main id="main">
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
                                    Kader Dakwah (LKD) 2026 yang dinamakan "EKSPRESI 30 - Eksplorasi Potensi Diri Islami
                                    2026".</h4>
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
                        <div class="col-lg-5 border-rules mb-4 mb-lg-0">
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

        <!-- ======= Pendaftaran & Tanggal Penting Section ======= -->
        <section id="pendaftaran" class="skills section-bg py-5">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Tanggal Penting & Tata Cara Pendaftaran</h2>
                    <p>Catat jadwal penting dan ikuti 5 langkah mudah pendaftaran EKSPRESI 30</p>
                </div>

                {{-- Row 1: 3 Card Tanggal Penting --}}
                <div class="row g-4 justify-content-center mb-5">
                    {{-- 1. Pendaftaran Peserta --}}
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="date-card text-center h-100">
                            <div class="date-card-icon">
                                <i class="bi bi-calendar2-check"></i>
                            </div>
                            <h4>Pendaftaran Peserta</h4>
                            <div class="date-badge mb-3">
                                30 Agustus – 05 Oktober 2026
                            </div>
                            <p class="date-card-desc">Pengisian formulir pendaftaran online dan penyerahan berkas perizinan.</p>
                        </div>
                    </div>

                    {{-- 2. Technical Meeting --}}
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                        <div class="date-card text-center h-100">
                            <div class="date-card-icon">
                                <i class="bi bi-megaphone"></i>
                            </div>
                            <h4>Technical Meeting (TM)</h4>
                            <div class="date-badge mb-3">
                                08 Oktober 2026
                            </div>
                            <p class="date-card-desc">Briefing teknis kegiatan, pembagian kelompok, dan pengenalan tata tertib.</p>
                        </div>
                    </div>

                    {{-- 3. Pelaksanaan EKSPRESI --}}
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                        <div class="date-card text-center h-100">
                            <div class="date-card-icon">
                                <i class="bi bi-trophy"></i>
                            </div>
                            <h4>Pelaksanaan EKSPRESI</h4>
                            <div class="date-badge mb-3">
                                09 – 11 Oktober 2026
                            </div>
                            <p class="date-card-desc">Rangkaian acara kaderisasi LDK Syahid (materi, kelas minat bakat, & outbound).</p>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Tata Cara Pendaftaran (5 Langkah Berurutan) --}}
                <div class="mt-4" data-aos="fade-up">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold" style="color: #1E6310;">
                            <i class="bi bi-list-check me-2"></i>Alur Pendaftaran (5 Langkah Mudah)
                        </h3>
                    </div>

                    <div class="row g-3 g-lg-4 justify-content-center">
                        {{-- Step 1 --}}
                        <div class="col-xl col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="step-card h-100 text-center">
                                <div class="step-badge">01</div>
                                <div class="step-icon mb-2"><i class="bi bi-globe2"></i></div>
                                <h4>Buka Website</h4>
                                <p>Akses website <a href="https://www.ldksyah.id/ekspresi" target="_blank" rel="noopener noreferrer">ldksyah.id/ekspresi</a> lalu klik tombol <b>Daftar Sekarang</b>.</p>
                            </div>
                        </div>

                        {{-- Step 2 --}}
                        <div class="col-xl col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="150">
                            <div class="step-card h-100 text-center">
                                <div class="step-badge">02</div>
                                <div class="step-icon mb-2"><i class="bi bi-folder2-open"></i></div>
                                <h4>Siapkan Berkas</h4>
                                <p>Siapkan foto/scan <b>KTM / KRS aktif</b> dan bukti transfer / bukti bayar tunai di stand.</p>
                            </div>
                        </div>

                        {{-- Step 3 --}}
                        <div class="col-xl col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="step-card h-100 text-center">
                                <div class="step-badge">03</div>
                                <div class="step-icon mb-2"><i class="bi bi-file-earmark-arrow-down"></i></div>
                                <h4>Surat Izin Ortu</h4>
                                <p>Unduh berkas izin di <a href="https://ldksyah.id/SuratIzinOrtu_Ekspresi2026" target="_blank" rel="noopener noreferrer">Template Surat Izin</a>, cetak & minta tanda tangan orang tua/wali.</p>
                            </div>
                        </div>

                        {{-- Step 4 --}}
                        <div class="col-xl col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="250">
                            <div class="step-card h-100 text-center">
                                <div class="step-badge">04</div>
                                <div class="step-icon mb-2"><i class="bi bi-pencil-square"></i></div>
                                <h4>Isi Form & Kirim</h4>
                                <p>Lengkapi seluruh formulir pendaftaran di <a href="https://ldksyah.id/ekspresi26" target="_blank" rel="noopener noreferrer">Form Pendaftaran</a> lalu klik submit.</p>
                            </div>
                        </div>

                        {{-- Step 5 --}}
                        <div class="col-xl col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="step-card h-100 text-center">
                                <div class="step-badge">05</div>
                                <div class="step-icon mb-2"><i class="bi bi-check2-circle"></i></div>
                                <h4>Upload & Konfirmasi</h4>
                                <p>Upload berkas yang sudah ditandatangani ke <a href="https://ldksyah.id/PengumpulanSuratIzinOrtu_Ekspresi26" target="_blank" rel="noopener noreferrer">Form Pengumpulan</a> atau serahkan ke stand.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Skills / Pendaftaran Section -->

        <!-- ======= Services / Hyperlink Section ======= -->
        <section id="hyperlink" class="services section-bg py-5">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Pusat Tautan & Berkas</h2>
                    <p>Akses cepat seluruh formulir pendaftaran, berkas perizinan, atribut peserta, dan narahubung</p>
                </div>

                {{-- Kategori 1: Alur Pendaftaran Utama (4 Kolom) --}}
                <div class="row g-4 justify-content-center mb-4">
                    {{-- 1. Form Pendaftaran Peserta --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <a href="https://ldksyah.id/ekspresi26" target="_blank" rel="noopener noreferrer" class="hyperlink-item">
                            <div class="icon-box highlight-card text-center">
                                <div class="icon"><i class="bi bi-rocket-takeoff"></i></div>
                                <h4>Form Pendaftaran</h4>
                                <span class="badge-card-sub">Daftar online peserta</span>
                            </div>
                        </a>
                    </div>
                    {{-- 2. Template Surat Izin Ortu --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="150">
                        <a href="https://ldksyah.id/SuratIzinOrtu_Ekspresi2026" target="_blank" rel="noopener noreferrer" class="hyperlink-item">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-file-earmark-check"></i></div>
                                <h4>Template Surat Izin</h4>
                                <span class="badge-card-sub">Unduh file izin orang tua</span>
                            </div>
                        </a>
                    </div>
                    {{-- 3. Form Pengumpulan Surat Izin Ortu --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                        <a href="https://ldksyah.id/PengumpulanSuratIzinOrtu_Ekspresi26" target="_blank" rel="noopener noreferrer" class="hyperlink-item">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
                                <h4>Pengumpulan Surat Izin</h4>
                                <span class="badge-card-sub">Upload berkas bertanda tangan</span>
                            </div>
                        </a>
                    </div>
                    {{-- 4. Konfirmasi Pembayaran --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="250">
                        <a href="https://wa.me/6287796214820" target="_blank" rel="noopener noreferrer" class="hyperlink-item">
                            <div class="icon-box text-center">
                                <div class="icon"><i class="bi bi-credit-card-2-front"></i></div>
                                <h4>Konfirmasi Pembayaran</h4>
                                <span class="badge-card-sub">Kirim bukti via WhatsApp</span>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Kategori 2: Atribut & Persiapan Acara (4 Kolom) --}}
                <div class="row g-4 justify-content-center mb-5">
                    {{-- 5. Twibbon Ekspresi --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <a href="javascript:void(0)" class="hyperlink-item disabled-link" title="Informasi Twibbon Menyusul">
                            <div class="icon-box dashed-card text-center">
                                <span class="badge-status-menyusul">Menyusul</span>
                                <div class="icon"><i class="bi bi-image"></i></div>
                                <h4>Twibbon Peserta</h4>
                                <span class="badge-card-sub">Segera dirilis</span>
                            </div>
                        </a>
                    </div>
                    {{-- 6. Technical Meeting --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="150">
                        <a href="javascript:void(0)" class="hyperlink-item disabled-link" title="Informasi Technical Meeting Menyusul">
                            <div class="icon-box dashed-card text-center">
                                <span class="badge-status-menyusul">Menyusul</span>
                                <div class="icon"><i class="bi bi-building-fill-exclamation"></i></div>
                                <h4>Technical Meeting</h4>
                                <span class="badge-card-sub">Briefing & persiapan</span>
                            </div>
                        </a>
                    </div>
                    {{-- 7. Name Tag Peserta --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                        <a href="javascript:void(0)" class="hyperlink-item disabled-link" title="Informasi Name Tag Peserta Menyusul">
                            <div class="icon-box dashed-card text-center">
                                <span class="badge-status-menyusul">Menyusul</span>
                                <div class="icon"><i class="bi bi-person-badge-fill"></i></div>
                                <h4>Name Tag Peserta</h4>
                                <span class="badge-card-sub">Format identitas peserta</span>
                            </div>
                        </a>
                    </div>
                    {{-- 8. Kelompok Mentoring --}}
                    <div class="col-xl-3 col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="250">
                        <a href="javascript:void(0)" class="hyperlink-item disabled-link" title="Informasi Kelompok Mentoring Menyusul">
                            <div class="icon-box dashed-card text-center">
                                <span class="badge-status-menyusul">Menyusul</span>
                                <div class="icon"><i class="bi bi-people-fill"></i></div>
                                <h4>Kelompok Mentoring</h4>
                                <span class="badge-card-sub">Daftar kelompok peserta</span>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Kategori 3: Narahubung WhatsApp Strip (2 Kontak) --}}
                <div class="row justify-content-center">
                    <div class="col-lg-10" data-aos="fade-up" data-aos-delay="300">
                        <div class="contact-strip text-center p-3 p-md-4">
                            <h5 class="text-white fw-bold mb-1">
                                <i class="bi bi-headset me-2 text-warning"></i>Butuh Bantuan atau Informasi Lebih Lanjut?
                            </h5>
                            <p class="text-light opacity-75 mb-3 small">Silahkan hubungi narahubung resmi panitia EKSPRESI 2026 melalui WhatsApp:</p>
                            <div class="d-flex flex-wrap justify-content-center gap-3">
                                <a href="https://wa.me/6287713671510" target="_blank" rel="noopener noreferrer" class="btn btn-contact-wa">
                                    <i class="bi bi-whatsapp me-2"></i>Narahubung Ikhwan (0877-1367-1510)
                                </a>
                                <a href="https://wa.me/6285779446994" target="_blank" rel="noopener noreferrer" class="btn btn-contact-wa">
                                    <i class="bi bi-whatsapp me-2"></i>Narahubung Akhwat (0857-7944-6994)
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- End Services / Hyperlink Section -->

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
                                    buka dari 30 Agustus - 05 Oktober 2026
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

        <!-- ======= Clients / Partner Section ======= -->
        <section id="logo" class="clients section-bg py-5">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Media Partner & Sponsor</h2>
                    <p>Didukung oleh berbagai media partner dan sponsor terpercaya</p>
                </div>
                <div class="mx-3">
                    <div class="container rounded border-0 p-4" style="background-color: #fff">
                        <div class="row justify-content-center align-items-center" data-aos="zoom-in">

                            <div class="col-lg-12 col-md-4 col-12 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                                    class="img-fluid" alt="" style="width: 100px;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1Fj4hZRy7SNQ1Kq72JvY4M557noiULg-i"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1R-3mi9Jzw5vt3-VKVPic9BTvJeFkaikK"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1INzkD8YgOvf5_FVIXEnW40wUCsxJdepp"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1t_dDa8IDgpOnH85RvU67DV3W2CxhSetx"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1yU1Oj1qrFBanjcoj3ZhO1LPFOon7V92-"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1u6mS175Q2Fbqd2k6CRNqKq0E3q5Sde1U"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1Iem3JZgYMXRitO1GOb9lTMVeMjiUQFUI"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1HinEWSv90pL0MUZ1F0dAbyHNSmk2L-B5"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1zgyRIwgN-wnFHAquVyBvSuyhb4ZzpJ0R"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center mb-4">
                                <img src="https://lh3.googleusercontent.com/d/1sr4GI8TE-Z2Og4PBm3hqm1Bb38NryJ6U"
                                    class="img-fluid" alt="" style="max-width: 65%;">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- End Clients Section -->
    </main>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    @include('landing-page.ekspresi.template.footer')
    @include('landing-page.ekspresi._index-scripts')
</body>

</html>