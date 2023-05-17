<!-- Contact Us Start -->
@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="container-fluid appointment my-5 py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-lg-6 col-md-6 wow fadeIn" data-wow-delay="0.3s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-white text-uppercase mb-2">Hubungi Kami</h6>
                    <h1 class="display-6 text-white mb-0">
                        Jika Kamu Memiliki Pertanyaan, Kritik dan saran, Silahkan Hubungi Kami
                    </h1>
                </div>
                <p class="text-white mb-0" style="text-align: justify">
                    "Dan Kami tidak mengutus sebelum engkau (Muhammad), melainkan orang laki-laki yang Kami beri wahyu kepada mereka; maka bertanyalah kepada orang yang mempunyai pengetahuan jika kamu tidak mengetahui," &#9679; (QS. An-Nahl 16: Ayat 43)
                </p>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeIn" data-wow-delay="0.5s">
                <form role="form" action='/about/contact/message/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 bg-dark" id="name" name="name" placeholder="Nama Kamu" required/>
                            <label for="name">Nama Kamu</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <input type="email" class="form-control border-0 bg-dark" id="email" name="email" placeholder="Email Kamu" required/>
                            <label for="email">Email Kamu</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control border-0 bg-dark" id="subject" name="subject" placeholder="Subjek" required/>
                            <label for="subject">Subjek</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control border-0 bg-dark" placeholder="Tinggalkan Pesanmu disini" name="message" id="message" style="height: 150px" required></textarea>
                            <label for="message">Pesan</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3" type="submit">
                          Kirim Pesan
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-fluid appointment my-5 py-5 shadow">
    <div class="container py-5">
        <div class="row g-5 wow fadeIn" data-wow-delay="0.5s">
            <div class="col-lg-6 col-md-6">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-white text-uppercase mb-2 mobile-font-2">Hubungi Kami</h6>
                    <h1 class="display-6 text-white mb-0 mobile-font-4">
                        Jika Kamu Memiliki Pertanyaan, Kritik dan saran, Silahkan Hubungi Kami
                    </h1>
                </div>
                <p class="text-white mb-0 mobile-font-2" style="text-align: justify">
                    "Dan Kami tidak mengutus sebelum engkau (Muhammad), melainkan orang laki-laki yang Kami beri wahyu kepada mereka; maka bertanyalah kepada orang yang mempunyai pengetahuan jika kamu tidak mengetahui," &#9679; (QS. An-Nahl 16: Ayat 43)
                </p>
            </div>
            <div class="col-lg-6 col-md-6">
                <form role="form" action='/about/contact/message/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-floating mobile-font-2">
                            <input type="text" class="form-control border-0 bg-dark" id="name" name="name" placeholder="Nama Kamu" required/>
                            <label for="name">Nama Kamu</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating mobile-font-2">
                            <input type="email" class="form-control border-0 bg-dark" id="email" name="email" placeholder="Email Kamu" required/>
                            <label for="email">Email Kamu</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mobile-font-2">
                            <input type="text" class="form-control border-0 bg-dark" id="subject" name="subject" placeholder="Subjek" required/>
                            <label for="subject">Subjek</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating mobile-font-2">
                            <textarea class="form-control border-0 bg-dark" placeholder="Tinggalkan Pesanmu disini" name="message" id="message" style="height: 150px" required></textarea>
                            <label for="message">Pesan</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary w-100 py-3 mobile-font-2" type="submit">
                          Kirim Pesan
                        </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Contact Us End -->
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
