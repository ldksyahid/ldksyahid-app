@extends('landing-page.template.body')

@section('content')
<!-- UBAH PROFIL START -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body mb-2">Perbarui</h6>
                    <h1 class="display-6 mb-0">Perbarui Profil Kamu Dahulu</h1>
                </div>
                <p class="mb-0" style="text-align: justify">
                    "Barang siapa mengerjakan kebajikan maka (pahalanya) untuk dirinya sendiri dan barang siapa berbuat jahat maka (dosanya) menjadi tanggungan dirinya sendiri. Dan Tuhanmu sama sekali tidak menzalimi hamba-hamba-(Nya)."
                    <br>
                    &#9679; (QS. Fussilat 41: Ayat 46)
                </p>
            </div>
            <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <form role="form" action='/profile/{{ Auth::user()->id }}/store' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('POST')
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputnamalengkap" name="namalengkap" placeholder="Gurdian Name" value="{{ Auth::user()->name }}" disabled/>
                                <label for="inputnamalengkap">Nama Lengkap Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="email" class="form-control bg-light border-0" id="inputemail" name="email" placeholder="Gurdian Email" value="{{ Auth::user()->email }}" disabled/>
                                <label for="inputemail">Emailmu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputnamapanggilan" name="namapanggilan" placeholder="Gurdian Name"/>
                                <label for="inputnamapanggilan">Panggilan Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputsifat" name="sifat" placeholder="Gurdian Name"/>
                                <label for="inputsifat">Satu Sifatmu</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-light border-0" placeholder="Leave a message here" id="inputtentangdiri" name="tentangdiri" style="height: 100px"></textarea>
                                <label for="inputtentangdiri">Ceritain tentang dirimu</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputuniversitas" name="universitas" placeholder="Gurdian Name"/>
                                <label for="inputuniversitas">Universitasmu</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputnim" name="nim" placeholder="Gurdian Name"/>
                                <label for="inputnim">NIM Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputfakultas" name="fakultas" placeholder="Gurdian Name"/>
                                <label for="inputfakultas">Fakultasmu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputprogramstudi" name="programstudi" placeholder="Gurdian Name"/>
                                <label for="inputprogramstudi">Program Studimu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputforkat" name="forkat" placeholder="Gurdian Name"/>
                                <label for="inputforkat">Forkat Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputnomoranggota" name="nomoranggota" placeholder="Gurdian Name"/>
                                <label for="inputnomoranggota">Nomor Anggota Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputakuninstagram" name="akuninstagram" placeholder="Gurdian Name" value="@"/>
                                <label for="inputakuninstagram">Akun Instagram Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputakunlinkedin" name="akunlinkedin" placeholder="Gurdian Name"/>
                                <label for="inputakunlinkedin">Akun LinkedInmu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputmottohidup" name="mottohidup" placeholder="Gurdian Name"/>
                                <label for="inputmottohidup">Motto Hidup Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="">
                                <input type="file" class="form-control bg-light border-0" id="inputprofilepicture" name="profilepicture" placeholder="Gurdian Name" accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG"/>
                                <label for="inputprofilepicture">Pilih Foto Profil Kamu yaaaa</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Simpan Perubahan</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
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
<!-- UBAH PROFIL END -->
@endsection
