@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7 col-md-6  wow fadeInUp" data-wow-delay="0.5s">
                <form method="POST" action="{{ route('register') }}">
                @csrf
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <div class="form-floating">
                                <input
                                type="name"
                                class="form-control bg-light border-0  @error('name') is-invalid @enderror"
                                id="name"
                                placeholder="Gurdian Name"
                                name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus
                                />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="name">Nama Lengkap</label>
                            </div>
                        </div>
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
                        <div class="col-sm-6">
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
                        <div class="col-sm-6">
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control bg-light border-0 @error('password') is-invalid @enderror"
                                    id="password-confirm"
                                    placeholder="Gurdian Password"
                                    name="password_confirmation"
                                    required autocomplete="new-passwordd"
                                />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="password-confirm">Konfirmasi Password</label>
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
                                {{ __('Daftar') }}
                            </button>
                        </div>
                        <div class="col-12">
                            <p>Sudah Memiliki Akun? <a href="/login"><u>Masuk</u></a></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                <h6 class="text-body text-uppercase mb-2">Daftar</h6>
                <h1 class="display-6 mb-0">
                    Melangkah Keluar dari Zona Nyaman
                </h1>
                </div>
                <p class="mb-0">
                    "Dan janganlah kamu (merasa) lemah, dan jangan (pula) bersedih hati, sebab kamu paling tinggi (derajatnya), jika kamu orang yang beriman." &#9679; (QS. Ali 'Imran 3: Ayat 139)
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Appointment End -->
@endsection
