@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- UBAH PROFIL START -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body mb-2">Update</h6>
                    <h1 class="display-6 mb-0">Update Profil Kamu Disini</h1>
                </div>
                <p class="mb-0">
                    "Dan siapakah yang lebih baik perkataannya daripada orang yang menyeru kepada Allah dan mengerjakan kebajikan dan berkata, "Sungguh, aku termasuk orang-orang muslim (yang berserah diri)?""
                    &#9679; (QS. Fussilat 41: Ayat 33)
                </p>
            </div>
            <div class="col-lg-7 col-md-6 wow fadeInRight" data-wow-delay="0.5s">
                <form role="form" action='/profile/{{ Auth::user()->profile->id }}/update' method='post' enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
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
                                <input type="text" class="form-control bg-light border-0" id="inputnamapanggilan" name="namapanggilan" placeholder="Gurdian Name" value="{{Auth::User()->profile->namapanggilan}}"/>
                                <label for="inputnamapanggilan">Panggilan Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputsifat" name="sifat" placeholder="Gurdian Name" value="{{Auth::User()->profile->sifat}}"/>
                                <label for="inputsifat">Satu Sifatmu</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea class="form-control bg-light border-0" placeholder="Leave a message here" id="inputtentangdiri" name="tentangdiri" style="height: 100px">{{Auth::User()->profile->tentangdiri}}</textarea>
                                <label for="inputtentangdiri">Ceritain tentang dirimu</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputuniversitas" name="universitas" placeholder="Gurdian Name" value="{{Auth::User()->profile->universitas}}"/>
                                <label for="inputuniversitas">Universitasmu</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputnim" name="nim" placeholder="Gurdian Name" value="{{Auth::User()->profile->nim}}"/>
                                <label for="inputnim">NIM Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputfakultas" name="fakultas" placeholder="Gurdian Name" value="{{Auth::User()->profile->fakultas}}"/>
                                <label for="inputfakultas">Fakultasmu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputprogramstudi" name="programstudi" placeholder="Gurdian Name" value="{{Auth::User()->profile->programstudi}}"/>
                                <label for="inputprogramstudi">Program Studimu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputforkat" name="forkat" placeholder="Gurdian Name" value="{{Auth::User()->profile->forkat}}"/>
                                <label for="inputforkat">Forkat Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputnomoranggota" name="nomoranggota" placeholder="Gurdian Name" value="{{Auth::User()->profile->nomoranggota}}"/>
                                <label for="inputnomoranggota">Nomor Anggota Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputakuninstagram" name="akuninstagram" placeholder="Gurdian Name" value="{{Auth::User()->profile->akuninstagram}}"/>
                                <label for="inputakuninstagram">Akun Instagram Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputakunlinkedin" name="akunlinkedin" placeholder="Gurdian Name" value="{{Auth::User()->profile->akunlinkedin}}"/>
                                <label for="inputakunlinkedin">Akun LinkedInmu</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input type="text" class="form-control bg-light border-0" id="inputmottohidup" name="mottohidup" placeholder="Gurdian Name" value="{{Auth::User()->profile->mottohidup}}"/>
                                <label for="inputmottohidup">Motto Hidup Kamu</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="">
                                <input type="file" class="form-control bg-light border-0" id="inputprofilepicture" name="profilepicture" placeholder="Gurdian Name" accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG"/>
                                <label for="inputprofilepicture">
                                    @if (Auth::User()->profile->profilepicture == !null )
                                        <i>{{Auth::User()->profile->profilepicture}}</i>
                                    @endif
                                </label>
                                {{-- <br>
                                @if (Auth::User()->profile->profilepicture == !null )
                                    <form action=" /profile/{{ Auth::User()->profile->id }}/destroy/profilepicture" method="post" id='form_delete_pp'>
                                        @csrf
                                        @method('DELETE')
                                        <a href="javascript:{}" onclick="document.getElementById('form_delete_pp').submit(); return false;">Hapus Poto Profil</a>
                                    </form>
                                @endif --}}
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="/profile" class="btn btn-primary w-100 py-3">Kembali ke Profilku</a>
                        </div>
                        <div class="col-6">
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
