@extends('landing-page.template.body')

@section('content')
@php $title = "Reset Password" @endphp

{{-- Reset Password Section --}}
<div class="auth-center-section">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="auth-center-card">

                    {{-- Badge --}}
                    <div class="auth-badge" style="margin-bottom:1.5rem;">
                        <span>🛡️</span>
                        <span>Reset Password</span>
                        <span class="auth-badge-pulse"></span>
                    </div>

                    {{-- Icon --}}
                    <div class="auth-card-icon" style="margin-bottom:1rem;">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <h3 class="auth-card-title mb-2">Buat Password Baru</h3>
                    <p class="auth-card-subtitle mb-4">
                        Pastikan password baru kamu kuat dan mudah diingat.
                    </p>

                    <form method="POST" action="{{ route('password.update') }}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        {{-- Email --}}
                        <div class="auth-input-wrap">
                            <i class="fas fa-envelope auth-input-icon" style="top:29px;transform:none;"></i>
                            <div class="form-floating">
                                <input
                                    type="email"
                                    class="form-control has-icon @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    placeholder="name@example.com"
                                    value="{{ $email ?? old('email') }}"
                                    required autocomplete="email" autofocus
                                />
                                <label for="email" class="has-icon">Email</label>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- New Password --}}
                        <div class="auth-input-wrap">
                            <i class="fas fa-lock auth-input-icon" style="top:29px;transform:none;"></i>
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control has-icon @error('password') is-invalid @enderror"
                                    id="rst_password"
                                    name="password"
                                    placeholder="Password Baru"
                                    required autocomplete="new-password"
                                    style="padding-right:3rem;"
                                />
                                <label for="rst_password" class="has-icon">Password Baru</label>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <span class="auth-pwd-toggle" onclick="authTogglePass('rst_password','rstPwdIcon')">
                                <i id="rstPwdIcon" class="fas fa-eye"></i>
                            </span>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="auth-input-wrap">
                            <i class="fas fa-shield-alt auth-input-icon" style="top:29px;transform:none;"></i>
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control has-icon"
                                    id="rst_password_confirm"
                                    name="password_confirmation"
                                    placeholder="Konfirmasi Password"
                                    required autocomplete="new-password"
                                    style="padding-right:3rem;"
                                />
                                <label for="rst_password_confirm" class="has-icon">Konfirmasi Password Baru</label>
                            </div>
                            <span class="auth-pwd-toggle" onclick="authTogglePass('rst_password_confirm','rstConfirmIcon')">
                                <i id="rstConfirmIcon" class="fas fa-eye"></i>
                            </span>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="auth-btn mt-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Simpan Password Baru</span>
                            <div class="auth-btn-shine"></div>
                        </button>

                    </form>

                    <div class="auth-divider">
                        <span>Ingat password lama?</span>
                    </div>

                    <p class="auth-bottom">
                        <a href="/login" class="auth-link">&larr; Kembali ke Halaman Masuk</a>
                    </p>

                    <div class="auth-note">
                        <i class="fas fa-circle-info"></i>
                        Gunakan minimal 8 karakter dengan kombinasi huruf, angka, dan simbol agar password kamu lebih aman.
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function authTogglePass(inputId, iconId) {
    var input = document.getElementById(inputId);
    var icon  = document.getElementById(iconId);
    var isPass = input.type === 'password';
    input.type = isPass ? 'text' : 'password';
    icon.className = isPass ? 'fas fa-eye-slash' : 'fas fa-eye';
}
</script>
@endsection
