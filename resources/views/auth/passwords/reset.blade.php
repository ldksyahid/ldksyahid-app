@extends('landing-page.template.body')

@section('content')
@php
    $title = "Lupa Password"
@endphp
<style>
    .form-floating .form-control {
        border-radius: 12px !important;
    }
    textarea.form-control {
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

<!-- Reset Password Section Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row justify-content-center align-items-center g-5">
            <!-- Text Content on the left -->
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="mb-5">
                    <h6 class="text-primary text-uppercase mb-2">Reset Password</h6>
                    <h1 class="display-6 mb-3">
                        Manfaatkan Hidup Kita dengan Baik
                    </h1>
                    <p class="text-muted">
                        "Maka sesungguhnya bersama kesulitan itu ada kemudahan, sesungguhnya bersama kesulitan itu ada kemudahan."
                        <br> &#9679; (QS. Al-Insyirah 94: Ayat 5-6)
                    </p>
                </div>
            </div>

            <!-- Form Content on the right -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card border-0 shadow p-4 rounded-4 bg-light">
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}" autocomplete="off">
                            @csrf
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="form-floating">
                                    <input
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email"
                                        placeholder="name@example.com"
                                        name="email"
                                        value="{{ $email ?? old('email') }}"
                                        required autocomplete="email" autofocus
                                    />
                                    <label for="email">Email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4 position-relative">
                                <div class="form-floating">
                                    <input
                                        type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        id="password"
                                        placeholder="Password"
                                        name="password"
                                        required autocomplete="new-password"
                                    />
                                    <label for="password">Password</label>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <span class="password-toggle" onclick="togglePassword()">
                                    <i id="toggleIcon" class="fa fa-eye"></i>
                                </span>
                            </div>

                            <div class="mb-4 position-relative">
                                <div class="form-floating">
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password-confirm"
                                        placeholder="Confirm Password"
                                        name="password_confirmation"
                                        required autocomplete="new-password"
                                    />
                                    <label for="password-confirm">Confirm Password</label>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button class="btn btn-primary py-3 rounded-pill" type="submit">
                                    Reset Password
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="mb-0">
                                    <a href="/login" class="text-primary"><u>Kembali</u></a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div> <!-- End Card -->
            </div>
        </div>
    </div>
</div>
<!-- Reset Password Section End -->

<script>
function togglePassword() {
    const password = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    if (password.type === "password") {
        password.type = "text";
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        password.type = "password";
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>

@endsection
