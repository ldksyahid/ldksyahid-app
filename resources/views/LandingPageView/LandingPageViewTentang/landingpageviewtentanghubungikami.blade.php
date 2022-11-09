@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4 text-uppercase">Hubungi Kami</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <p class="text-white">Mari Mengenal lebih dalam UKM LDK Syahid</p>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
<!-- Contact Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Facts Start -->
            <div class="container-fluid my-5 p-0">
                <div class="row g-0">
                    <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="https://source.unsplash.com/500x600?me" alt="" />
                            <div class="facts-overlay">
                                <h1 class="display-1">01</h1>
                                <h4 class="text-white mb-3">Alamat Lengkap</h4>
                                <p class="text-white" style="font-size: 10px; text-align: justify;">
                                    Gedung Student Center Lantai 3 Ruang LDK Syahid , Universitas Islam Negeri Syarif Hidayatullah Jakarta, Jalan Ir. H. Djuanda No. 95, Cemp. Putih, Kec. Ciputat Tim., Kota Tangerang Selatan, Banten 15412
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="https://source.unsplash.com/500x600?islamic" alt="" />
                            <div class="facts-overlay text-center">
                                <h1 class="display-1">02</h1>
                                <h4 class="text-white mb-3">Kontak</h4>
                                <p class="text-white"><a href="https://wa.me/6285159360504" target="_blank" rel="noopener noreferrer" class="text-white">+62 851-5936-0504</a></p>
                                <p class="text-white">(Admin LDK Syahid UIN Jakarta)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="https://source.unsplash.com/500x600?makkah" alt="" />
                            <div class="facts-overlay text-center">
                                <h1 class="display-1">03</h1>
                                <h4 class="text-white mb-3">Alamat Email</h4>
                                <p class="text-white">
                                    <a href="mailto:ldk@uinjkt.ac.id" target="_blank" rel="noopener noreferrer" class="text-white">ldk@uinjkt.ac.id</a>
                                </p>
                                <p class="text-white">(Admin LDK Syahid UIN Jakarta)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="https://source.unsplash.com/500x600?madinah" alt="" />
                            <div class="facts-overlay text-end">
                                <h1 class="display-1">04</h1>
                                <h4 class="text-white mb-3">Sosial Media</h4>
                                <a href="https://www.instagram.com/ldksyahid/" target="_blank" rel="noopener noreferrer" class="text-white">instagram.com/ldksyahid</a>
                                <a href="https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ?app=desktop/" target="_blank" rel="noopener noreferrer" class="text-white">youtube.com/syahidtv</a>
                                <a href="https://twitter.com/ldksyahid/" target="_blank" rel="noopener noreferrer" class="text-white">twitter.com/ldksyahid</a>
                                <a href="https://www.facebook.com/ldksyahid/" target="_blank" rel="noopener noreferrer" class="text-white">facebook.com/ldksyahid</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Facts End -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 450px">
                <div class="position-relative h-100">
                    <iframe class="position-relative w-100 h-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6773009952885!2d106.75319361449397!3d-6.306059963469107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efd9636c9d6b%3A0x71fbe6e9045945ff!2sLDK%20Syahid%20UIN%20Syarif%20Hidayatullah%20Jakarta!5e0!3m2!1sen!2sid!4v1664598000447!5m2!1sen!2sid" frameborder="0" style="min-height: 450px; border: 0" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body text-uppercase mb-2">Hubungi Kami</h6>
                    <h1 class="display-6 mb-0">Jika Kamu Memiliki Pertanyaan, Silahkan Hubungi Kami</h1>
                </div>
                <p class="mb-4" style="text-align: justify">"Sesungguhnya malu dan iman selalu berbarengan apabila salah satu diantaranya diangkat ( di hilangkan ) maka yang lainnya pun akan diangkat pula" &#9679; (HR. imam hakim)</p>
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
                            <button class="btn btn-primary py-3 px-5" type="submit">Kirim Pesan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
  <!-- Contact End -->
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
