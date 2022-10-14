@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Appointment Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                <h6 class="text-body text-uppercase mb-2">Masuk</h6>
                <h1 class="display-6 mb-0">
                    Manfaatkan Hidup Kita dengan Baik
                </h1>
                </div>
                <p class="mb-0">
                    "Maka sesungguhnya bersama kesulitan itu ada kemudahan, sesungguhnya bersama kesulitan itu ada kemudahan." <br> &#9679; (QS. Al-Insyirah 94: Ayat 5 - 6)
                </p>
            </div>
            <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <form method="POST" action="{{ route('login') }}">
                @csrf
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input
                                type="email"
                                class="form-control bg-light border-0  @error('email') is-invalid @enderror"
                                id="email"
                                placeholder="Gurdian Email"
                                name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="gmail">Email</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control bg-light border-0 @error('password') is-invalid @enderror"
                                    id="password"
                                    placeholder="Gurdian Password"
                                    name="password"
                                    required autocomplete="current-password"
                                />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-check">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="form-check-input"
                                    id="remember" {{ old('remember') ? 'checked' : '' }}
                                />
                                <label class="form-check-label" for="remember">
                                    {{ __('Ingat Akun Saya') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary w-100 py-3" type="submit">
                                {{ __('Masuk') }}
                            </button>
                        </div>
                        <div class="col-12">
                            <p>Belum Memiliki Akun? <a href="/register"><u>Daftar</u></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Appointment End -->
@endsection
