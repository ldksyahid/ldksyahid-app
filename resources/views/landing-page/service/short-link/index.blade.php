@extends('landing-page.template.body')

@section('content')
<!-- Appointment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body text-uppercase mb-2">Perpendek URL</h6>
                    <h1 class="display-6 mb-0">
                        Layanan untuk perpendek URL yang disediakan oleh UKM LDK Syahid UIN Jakarta
                    </h1>
                </div>
                <p class="mb-0">
                    Layanan untuk perpendek URL yang disediakan oleh UKM LDK Syahid UIN Jakarta hanya dapat digunakan oleh anggota UKM LDK Syahid UIN Jakarta
                </p>
            </div>
            <div class="col-lg-8 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <form role="form" action='/service/shortlink/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control bg-light border-0"
                                    id="name"
                                    placeholder="Gurdian Name"
                                    name="name"
                                    required
                                />
                                <label for="name">Nama Lengkapmu</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Nama Lengkapmu ya
                                </div>
                                <div class="valid-feedback">
                                    Namanya Bagus
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input
                                    type="email"
                                    class="form-control bg-light border-0"
                                    id="email"
                                    placeholder="Gurdian Email"
                                    name="email"
                                    required
                                />
                                <label for="email">Emailmu</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Email Kamu ya
                                </div>
                                <div class="valid-feedback">
                                    Emailmu keren
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control bg-light border-0"
                                    id="whatsapp"
                                    placeholder="Child Name"
                                    name="whatsapp"
                                    value="+62"
                                    required
                                />
                                <label for="whatsapp">Whatsapp Aktif</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Nomor Whatsapp kamu ya
                                </div>
                                <div class="valid-feedback">
                                    Nomor Cantik ya
                                </div>
                                <p style="font-size: 10px">*Nomor Whatsapp harus diawali dengan +62 </p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control bg-light border-0"
                                    id="defaultLink"
                                    placeholder="Child Age"
                                    name="defaultLink"
                                    required
                                />
                                <label for="defaultLink">Link Asli</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Link Aslinya ya
                                </div>
                                <div class="valid-feedback">
                                    Panjang banget linknya
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control bg-light border-0"
                                    id="customLink"
                                    placeholder="Child Age"
                                    name="customLink"
                                    value="https://ldksyah.id/"
                                    required
                                />
                                <label for="customLink">Setelah dikustomisasi</label>
                                <div class="invalid-feedback">
                                    Jangan lupa untuk masukkan Link setelah dikustomisasi ya
                                </div>
                                <div class="valid-feedback">
                                    Linknya kreatif ya
                                </div>
                                <p style="font-size: 10px">*Link harus diawali dengan https://ldksyah.id/ <br> *Jika link tidak tersedia maka akan diganti secara random <br>*Beri tanda pisah “-” jika 1 kata terdapat > 10 huruf </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea
                                    class="form-control bg-light border-0"
                                    placeholder="Leave a message here"
                                    id="note"
                                    style="height: 100px"
                                    name="note"
                                    required
                                ></textarea>
                                <label for="note">Catatan</label>
                                <div class="invalid-feedback">
                                    Kasih catatan dong untuk kami
                                </div>
                                <div class="valid-feedback">
                                    Woke!
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">
                            Kirim
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-8 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-end border-bottom border-top border-5 border-primary mb-5 p-5">
                    <h6 class="text-body mb-2">Konfirmasi Layanan Perpendek URL</h6>
                    <h4 class="mb-0" style="text-align: justify">
                        Silahkan konfirmasi ke whatsapp dibawah ini setelah "Kirim" untuk mendapatkan pelayanan lebih cepat
                    </h4>
                    <div class="col-sm-6 d-flex wow fadeIn mt-5" data-wow-delay="0.3s">
                        <i class="fa fa-whatsapp fa-3x text-primary flex-shrink-0 me-3"></i>
                        <div class="row">
                            <h6 class="mb-0"><a href="https://api.whatsapp.com/send?phone=+6287874371243&text=*%5BFOLLOW%20UP%20LAYANAN%20PERPENDEK%20URL%5D*%0A%0A_Assalammu%27alaikum_%0A%0AIzin%20untuk%20*Memfollow%20up%20Layanan%20Perpendek%20URL*%20dan%20saya%20telah%20mengisi%20formulir%20tersebut%0A%0A_Terimakasih%20Sebelumnya_%0A_Wassalammua%27laikum_%0A%0A%23KitaAdalahSaudara%0A%23LDKSyahid%0A%23PijarAskara%0A%23UINJakarta" target="_blank">R Revaldy A</a></h6><br>
                            <p class="mb-0">+6287874371243</p>
                        </div>
                    </div>
                    <p class="mb-0 mt-5">
                       Kami akan menghubungimu melalui Whatsapp yang telah di daftarkan setelah <i>Shortlink</i> berhasil kami buat
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Appointment End -->
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
