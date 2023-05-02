@extends('landing-page.template.body')

@section('content')
@php
    $title = "Lupa Password"
@endphp
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                <h6 class="text-body text-uppercase mb-2">Reset Password</h6>
                <h1 class="display-6 mb-0">
                    Manfaatkan Hidup Kita dengan Baik
                </h1>
                </div>
                <p class="mb-0">
                    "Maka sesungguhnya bersama kesulitan itu ada kemudahan, sesungguhnya bersama kesulitan itu ada kemudahan." <br> &#9679; (QS. Al-Insyirah 94: Ayat 5 - 6)
                </p>
            </div>
            <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <form method="POST" action="{{ route('password.email') }}">
                @csrf
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control bg-light border-0 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}"
                                    required autocomplete="email"
                                    autofocus
                                />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary w-100 py-3" type="submit">
                                {{ __('Kirim Link Reset Password') }}
                            </button>
                        </div>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                <p>Kami Telah Mengirikan Email untuk Mereset Password Kamu, Silahkan Cek Email Kamu Sekarang!</p>
                            </div>
                         @endif
                         <div class="col-12">
                            <p><a href="/login"><u>Kembali</u></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
