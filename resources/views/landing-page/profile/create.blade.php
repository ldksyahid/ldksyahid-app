@extends('landing-page.template.body')

@section('styles')
@include('landing-page.profile.components._form-styles')
@endsection

@section('content')
<section class="prf-form-section">
    <div class="prf-form-layout">

        {{-- ===== LEFT DECO ===== --}}
        <div class="prf-form-deco wow fadeInUp" data-wow-delay="0.1s">
            <p class="prf-form-deco-label">Langkah Pertama</p>
            <h1 class="prf-form-deco-title">Lengkapi Profilmu Dahulu</h1>
            <div class="prf-form-deco-bar"></div>
            <div class="prf-form-deco-quote">
                <p>"Barang siapa mengerjakan kebajikan maka (pahalanya) untuk dirinya sendiri dan barang siapa berbuat jahat maka (dosanya) menjadi tanggungan dirinya sendiri. Dan Tuhanmu sama sekali tidak menzalimi hamba-hamba-Nya."</p>
                <span>&#9679; QS. Fussilat 41: 46</span>
            </div>
        </div>

        {{-- ===== FORM CARD ===== --}}
        <div class="prf-form-card wow fadeInUp" data-wow-delay="0.2s">

            {{-- Mobile-only header --}}
            <div class="prf-mobile-form-title">
                <p class="prf-form-deco-label">Langkah Pertama</p>
                <h2 class="prf-form-deco-title">Lengkapi Profilmu</h2>
                <div class="prf-form-deco-bar"></div>
            </div>

            <form role="form"
                  action="/profile/{{ Auth::user()->id }}/store"
                  method="post"
                  enctype="multipart/form-data"
                  class="prf-needs-validation"
                  novalidate>
                @csrf
                @method('POST')

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
                                   placeholder=" " required/>
                            <label for="inputnamapanggilan">Panggilan Kamu</label>
                            <div class="invalid-feedback">Wajib diisi.</div>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputsifat" name="sifat"
                                   placeholder=" " required/>
                            <label for="inputsifat">Satu Sifatmu</label>
                            <div class="invalid-feedback">Wajib diisi.</div>
                        </div>
                    </div>
                    <div class="prf-field prf-field--full">
                        <div class="form-floating">
                            <textarea class="form-control" id="inputtentangdiri" name="tentangdiri"
                                      placeholder=" " style="height: 100px"></textarea>
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
                                   placeholder=" "/>
                            <label for="inputuniversitas">Universitas</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputnim" name="nim"
                                   placeholder=" "/>
                            <label for="inputnim">NIM</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputfakultas" name="fakultas"
                                   placeholder=" "/>
                            <label for="inputfakultas">Fakultas</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputprogramstudi" name="programstudi"
                                   placeholder=" "/>
                            <label for="inputprogramstudi">Program Studi</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputforkat" name="forkat"
                                   placeholder=" "/>
                            <label for="inputforkat">Forum Angkatan</label>
                        </div>
                    </div>
                    <div class="prf-field prf-field--full">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputnomoranggota" name="nomoranggota"
                                   placeholder=" "/>
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
                                   placeholder=" " value="@"/>
                            <label for="inputakuninstagram">Instagram</label>
                        </div>
                    </div>
                    <div class="prf-field">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputakunlinkedin" name="akunlinkedin"
                                   placeholder=" "/>
                            <label for="inputakunlinkedin">LinkedIn</label>
                        </div>
                    </div>
                    <div class="prf-field prf-field--full">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="inputmottohidup" name="mottohidup"
                                   placeholder=" "/>
                            <label for="inputmottohidup">Motto Hidup</label>
                        </div>
                    </div>
                </div>

                {{-- ---- Foto Profil ---- --}}
                <p class="prf-form-group-title"><i class="fas fa-camera me-1"></i> Foto Profil</p>
                <div class="prf-file-wrap">
                    <input type="file" class="prf-file-input" id="inputprofilepicture" name="profilepicture"
                           accept="image/png, image/jpeg, image/jpg, image/JPG, image/PNG"/>
                    <p class="prf-file-hint" id="prf-file-hint">Tidak ada file dipilih &middot; JPG / PNG maks. 2MB</p>
                </div>

                {{-- ---- Tombol ---- --}}
                <div class="prf-form-actions">
                    <a href="/" class="prf-btn prf-btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="prf-btn prf-btn-submit">
                        <i class="fas fa-save"></i> Simpan Profil
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>
@endsection

@section('scripts')
@include('landing-page.profile.components._form-scripts')
@endsection
