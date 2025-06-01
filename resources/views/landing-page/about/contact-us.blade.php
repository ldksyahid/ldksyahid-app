@extends('landing-page.template.body')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="https://lh3.googleusercontent.com/d/1Xt3HVJLvYBrcxcg-HyNK2pKOQ7WUIQBj" alt="Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Information Start -->
            <div class="container my-5">
                <div class="row g-4">
                    @php
                        $information = [
                            [
                                'title' => 'Alamat Lengkap',
                                'content' => 'Gedung Student Center Lantai 3 Ruang LDK Syahid, Universitas Islam Negeri Syarif Hidayatullah Jakarta, Jalan Ir. H. Djuanda No. 95, Cemp. Putih, Kec. Ciputat Tim., Kota Tangerang Selatan, Banten 15412',
                                'bg' => '#0dcaf0' // bs-info
                            ],
                            [
                                'title' => 'Kontak',
                                'content' => '<a href="https://wa.me/6285159360504" target="_blank" class="text-white text-decoration-underline">+62 851-5936-0504</a><br><small class="text-white">(Admin LDK Syahid UIN Jakarta)</small>',
                                'bg' => '#00a79d' // bs-green
                            ],
                            [
                                'title' => 'Alamat Email',
                                'content' => '<a href="mailto:ldk.ormawa@apps.uinjkt.ac.id" target="_blank" class="text-white text-decoration-underline">ldk.ormawa@apps.uinjkt.ac.id</a><br><small class="text-white">(Admin LDK Syahid UIN Jakarta)</small>',
                                'bg' => '#20c997' // bs-teal
                            ],
                            [
                                'title' => 'Sosial Media',
                                'content' => '
                                    <a href="https://www.instagram.com/ldksyahid/" target="_blank" class="text-white d-block">
                                        <i class="fab fa-instagram me-2"></i>instagram.com/ldksyahid
                                    </a>
                                    <a href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ?app=desktop" target="_blank" class="text-white d-block">
                                        <i class="fab fa-youtube me-2"></i>youtube.com/syahidtv
                                    </a>
                                    <a href="https://twitter.com/ldksyahid/" target="_blank" class="text-white d-block">
                                        <i class="fab fa-twitter me-2"></i>twitter.com/ldksyahid
                                    </a>
                                    <a href="https://www.facebook.com/ldksyahid/" target="_blank" class="text-white d-block">
                                        <i class="fab fa-facebook-f me-2"></i>facebook.com/ldksyahid
                                    </a>
                                ',
                                'bg' => '#0dcaf0' // bs-cyan/info
                            ],
                        ];
                    @endphp

                    <div class="row g-4">
                        @foreach($information as $index => $info)
                            <div class="col-md-6 col-xl-3 wow fadeInUp">
                                <div class="text-white p-4 hover-card position-relative overflow-hidden shadow-sm" style="min-height: 250px; border-radius: 1rem; background-color: {{ $info['bg'] }};">
                                    <h5 class="mb-3 fw-bold">{{ $info['title'] }}</h5>
                                    <p class="small m-0">{!! $info['content'] !!}</p>
                                    <div class="position-absolute end-0 p-2 display-1">{{ sprintf('%02d', $index + 1) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Information End -->

            <!-- Map Location Start -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 450px">
                <div class="position-relative h-100 map-container rounded-map">
                    <iframe class="position-relative w-100 h-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6773009952885!2d106.75319361449397!3d-6.306059963469107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efd9636c9d6b%3A0x71fbe6e9045945ff!2sLDK%20Syahid%20UIN%20Syarif%20Hidayatullah%20Jakarta!5e0!3m2!1sen!2sid!4v1664598000447!5m2!1sen!2sid"
                        frameborder="0" style="border: 0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
            <!-- Map Location End -->

            <!-- Form Start -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <h6 class="text-primary text-uppercase mb-2">Hubungi Kami</h6>
                <h1 class="fw-bold mb-3">Jika Kamu Memiliki Pertanyaan, Silahkan Hubungi Kami</h1>
                <p class="text-muted mb-5" style="text-align: justify;">
                    "Sesungguhnya malu dan iman selalu berbarengan apabila salah satu diantaranya diangkat (di hilangkan) maka yang lainnya pun akan diangkat pula" &#9679; (HR. imam hakim)
                </p>
                <form role="form" action='/about/contact/message/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0 bg-light" id="name" name="name" placeholder="Nama Kamu" required/>
                                <label for="name">Nama Kamu</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Nama Kamu ya
                                </div>
                                <div class="valid-feedback">
                                    Nama kamu MasyaAllah
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control border-0 bg-light" id="email" name="email" placeholder="Email Kamu" required/>
                                <label for="email">Email Kamu</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Email Kamu ya
                                </div>
                                <div class="valid-feedback">
                                    Emailmu keren
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="text" class="form-control border-0 bg-light" id="subject" name="subject" placeholder="Subjek" required/>
                                <label for="subject">Subjek</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Subjeknya ya
                                </div>
                                <div class="valid-feedback">
                                    Subjeknya hebat
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control border-0 bg-light" placeholder="Tinggalkan Pesanmu disini" name="message" id="message" style="height: 150px" required></textarea>
                                <label for="message">Pesan</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Pesannya ya
                                </div>
                                <div class="valid-feedback">
                                    Terimakasih sebelumnya
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary py-3 px-5" type="submit" style="border-radius: 50rem !important;">Kirim Pesan</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Form End -->
        </div>
    </div>
</div>
  <!-- Contact End -->
@endsection

@section('styles')
<style>
    .hover-card {
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1);
        z-index: 1;
    }
    .rounded-map {
        border-radius: 1rem;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        overflow: hidden;
        height: 100%;
    }
    form.needs-validation .form-control,
    form.needs-validation textarea.form-control,
    form.needs-validation button.btn-primary {
        border-radius: 1rem !important;
    }
</style>
@endsection

@section('scripts')
<script>
    // Pemanggilan Validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection

