@extends('landing-page.template.body')

@section('content')
@php $title = "Lupa Password" @endphp

{{-- Forgot Password Section --}}
<div class="auth-center-section">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8 col-sm-10">
                <div class="auth-center-card">

                    {{-- Badge --}}
                    <div class="auth-badge" style="margin-bottom:1.5rem;">
                        <span>🔑</span>
                        <span>Lupa Password</span>
                        <span class="auth-badge-pulse"></span>
                    </div>

                    {{-- Icon --}}
                    <div class="auth-card-icon" style="margin-bottom:1rem;">
                        <i class="fas fa-key"></i>
                    </div>

                    <h3 class="auth-card-title mb-2">Reset Password Kamu</h3>
                    <p class="auth-card-subtitle mb-1">
                        Tenang, ini mudah! Masukkan email kamu dan kami<br class="d-none d-sm-inline">akan kirimkan link reset password.
                    </p>

                    {{-- Quote --}}
                    <div class="auth-quote mt-3 mb-4" style="text-align:left;">
                        <p>"Maka sesungguhnya bersama kesulitan itu ada kemudahan."</p>
                        <cite>&#9679; QS. Al-Insyirah 94: Ayat 5-6</cite>
                    </div>

                    {{-- Status Message --}}
                    @if (session('status'))
                        <div class="auth-status-alert">
                            <span class="auth-status-icon">✅</span>
                            <div>
                                <strong>Terkirim!</strong> Kami telah mengirimkan link reset password ke email kamu. Silakan cek inbox sekarang!
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
                        @csrf

                        {{-- Email --}}
                        <div class="auth-input-wrap">
                            <div class="form-floating">
                                <input
                                    type="email"
                                    class="form-control has-icon @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    placeholder="name@example.com"
                                    value="{{ old('email') }}"
                                    required autocomplete="email" autofocus
                                />
                                <label for="email" class="has-icon">Email</label>
                                <i class="fas fa-envelope auth-input-icon"></i>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="auth-btn mt-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Link Reset Password</span>
                            <div class="auth-btn-shine"></div>
                        </button>

                    </form>

                    <div class="auth-divider">
                        <span>Sudah ingat password?</span>
                    </div>

                    <p class="auth-bottom">
                        <a href="/login" class="auth-link">&larr; Kembali ke Halaman Masuk</a>
                    </p>

                    <div class="auth-note">
                        <i class="fas fa-circle-info"></i>
                        Link reset password hanya berlaku selama 60 menit. Jika tidak menerima email, periksa folder spam atau coba lagi.
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
@include('auth.passwords.email.components._index-styles')
@endsection
