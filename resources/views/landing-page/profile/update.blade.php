@extends('landing-page.template.body')

@section('styles')
@include('landing-page.profile.components._form-styles')
@endsection

@section('content')
<section class="prf-form-section">
    <div class="container">
        <div class="row g-4 align-items-start">

        {{-- ===== LEFT DECO ===== --}}
        <div class="col-lg-5 wow fadeInLeft" data-wow-delay="0.1s">
            <div class="prf-form-deco">
                <p class="prf-form-deco-label">Perbarui</p>
                <h1 class="prf-form-deco-title">Update Profilmu Disini</h1>
                <div class="prf-form-deco-bar"></div>
                <div class="prf-form-deco-quote">
                    <p>"Dan siapakah yang lebih baik perkataannya daripada orang yang menyeru kepada Allah dan mengerjakan kebajikan dan berkata, 'Sungguh, aku termasuk orang-orang muslim (yang berserah diri)?'"</p>
                    <span>&#9679; QS. Fussilat 41: 33</span>
                </div>
            </div>
        </div>

        {{-- ===== FORM CARD ===== --}}
        <div class="col-lg-7 wow fadeInRight" data-wow-delay="0.2s">
        <div class="prf-form-card">

            {{-- Mobile-only header --}}
            <div class="prf-mobile-form-title">
                <p class="prf-form-deco-label">Perbarui</p>
                <h2 class="prf-form-deco-title">Update Profilmu</h2>
                <div class="prf-form-deco-bar"></div>
            </div>

            <form role="form"
                  action="/profile/{{ Auth::user()->profile->id }}/update"
                  method="post"
                  enctype="multipart/form-data"
                  class="prf-needs-validation"
                  novalidate>
                @csrf
                @method('PUT')

                {{-- ---- Identitas ---- --}}
                <p class="prf-form-group-title"><i class="fas fa-user me-1"></i> Identitas</p>
                <div class="prf-fields-grid">
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputnamalengkap" name="namalengkap"
                                   placeholder=" " value="{{ Auth::user()->name }}" disabled/>
                            <label for="inputnamalengkap">Nama Lengkap</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="inputemail" name="email"
                                   placeholder=" " value="{{ Auth::user()->email }}" disabled/>
                            <label for="inputemail">Email</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputnamapanggilan" name="namapanggilan"
                                   placeholder=" " value="{{ Auth::User()->profile->namapanggilan }}" required/>
                            <label for="inputnamapanggilan">Panggilan Kamu</label>
                            <div class="invalid-feedback">Wajib diisi.</div>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputsifat" name="sifat"
                                   placeholder=" " value="{{ Auth::User()->profile->sifat }}" required/>
                            <label for="inputsifat">Satu Sifatmu</label>
                            <div class="invalid-feedback">Wajib diisi.</div>
                        </div>
                    </div>
                    <div class="prf-field prf-field--full">
                        <div class="form-floating">
                            <textarea class="form-control" id="inputtentangdiri" name="tentangdiri"
                                      placeholder=" " style="height: 100px">{{ Auth::User()->profile->tentangdiri }}</textarea>
                            <label for="inputtentangdiri">Ceritain tentang dirimu</label>
                        </div>
                    </div>
                </div>

                {{-- ---- Akademik ---- --}}
                <p class="prf-form-group-title"><i class="fas fa-graduation-cap me-1"></i> Informasi Akademik</p>
                <div class="prf-fields-grid">
                    <div class="prf-field prf-field--full">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputuniversitas" name="universitas"
                                   placeholder=" " value="{{ Auth::User()->profile->universitas }}"/>
                            <label for="inputuniversitas">Universitas</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputnim" name="nim"
                                   placeholder=" " value="{{ Auth::User()->profile->nim }}"/>
                            <label for="inputnim">NIM</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputfakultas" name="fakultas"
                                   placeholder=" " value="{{ Auth::User()->profile->fakultas }}"/>
                            <label for="inputfakultas">Fakultas</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputprogramstudi" name="programstudi"
                                   placeholder=" " value="{{ Auth::User()->profile->programstudi }}"/>
                            <label for="inputprogramstudi">Program Studi</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputforkat" name="forkat"
                                   placeholder=" " value="{{ Auth::User()->profile->forkat }}"/>
                            <label for="inputforkat">Forum Angkatan</label>
                        </div>
                    </div>
                    <div class="prf-field prf-field--full">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputnomoranggota" name="nomoranggota"
                                   placeholder=" " value="{{ Auth::User()->profile->nomoranggota }}"/>
                            <label for="inputnomoranggota">Nomor Anggota</label>
                        </div>
                    </div>
                </div>

                {{-- ---- Sosial & Motto ---- --}}
                <p class="prf-form-group-title"><i class="fas fa-user-circle me-1"></i> Sosial & Motto</p>
                <div class="prf-fields-grid">
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputakuninstagram" name="akuninstagram"
                                   placeholder=" " value="{{ Auth::User()->profile->akuninstagram }}"/>
                            <label for="inputakuninstagram">Instagram</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputakunlinkedin" name="akunlinkedin"
                                   placeholder=" " value="{{ Auth::User()->profile->akunlinkedin }}"/>
                            <label for="inputakunlinkedin">LinkedIn</label>
                        </div>
                    </div>
                    <div class="prf-field prf-field--full">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputmottohidup" name="mottohidup"
                                   placeholder=" " value="{{ Auth::User()->profile->mottohidup }}"/>
                            <label for="inputmottohidup">Motto Hidup</label>
                        </div>
                    </div>
                </div>

                {{-- ---- Foto Profil ---- --}}
                <p class="prf-form-group-title"><i class="fas fa-camera me-1"></i> Foto Profil</p>
                <div class="prf-file-wrap">
                    <input type="file" class="prf-file-input" id="inputprofilepicture" name="profilepicture"
                           accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG"/>
                    <label class="prf-file-label" for="inputprofilepicture">
                        <span class="prf-file-icon"><i class="fas fa-camera"></i></span>
                        <span class="prf-file-btn-text">Ganti Foto</span>
                        <span class="prf-file-sep">|</span>
                        @if (Auth::User()->profile->profilepicture != null)
                            <span class="prf-file-name-display prf-file-name-display--set" id="prf-file-name">
                                <i class="fas fa-check-circle me-1"></i>{{ Auth::User()->profile->profilepicture }}
                            </span>
                        @else
                            <span class="prf-file-name-display" id="prf-file-name">Belum ada foto terpasang</span>
                        @endif
                    </label>
                    <p class="prf-file-hint">JPG / PNG &middot; maks. 2 MB &middot; kosongkan jika tidak ingin mengubah foto</p>
                </div>

                {{-- ---- Tombol ---- --}}
                <div class="prf-form-actions">
                    <a href="/profile" class="prf-btn prf-btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="prf-btn prf-btn-submit">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
        </div>{{-- /col-lg-7 --}}

        </div>{{-- /row --}}
    </div>{{-- /container --}}
</section>
@endsection

@section('scripts')
@include('landing-page.profile.components._form-scripts')
@endsection
