@extends('landing-page.template.body')

@section('content')
<style>
    .form-floating .form-control {
        border-radius: 12px !important;
    }
    .password-toggle {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        font-size: 1.2rem;
    }
</style>

<!-- Confirm Password Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center align-items-center g-5">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="mb-5">
                    <h6 class="text-primary text-uppercase mb-2">Konfirmasi Password</h6>
                    <h1 class="display-6 mb-3">
                        Pastikan Keamanan Akun Kamu
                    </h1>
                    <p class="text-muted">
                        "Dan janganlah kamu (merasa) lemah, dan jangan (pula) bersedih hati, sebab kamu paling tinggi (derajatnya), jika kamu orang yang beriman."
                        <br> &#9679; (QS. Ali 'Imran 3: Ayat 139)
                    </p>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card border-0 shadow p-4 rounded-4 bg-light">
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="mb-4">
                                <div class="form-floating">
                                    <input
                                        id="password"
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password"
                                        required autocomplete="current-password"
                                    />
                                    <label for="password">Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-primary py-3 rounded-pill" type="submit">
                                    Konfirmasi Password
                                </button>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="btn btn-link small text-primary" href="{{ route('password.request') }}">
                                        Lupa Password?
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div> <!-- End Card -->
            </div>
        </div>
    </div>
</div>
<!-- Confirm Password Section End -->

@endsection
