@extends('landing-page.template.body')

@section('content')

{{-- Login Section --}}
<div class="auth-section">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center align-items-center g-5">

            {{-- Left: Content --}}
            <div class="col-lg-5 col-md-10 auth-left-enter">
                <div class="pe-lg-3">

                    <div class="auth-badge">
                        <span>🔐</span>
                        <span>Masuk Akun</span>
                        <span class="auth-badge-pulse"></span>
                    </div>

                    <h2 class="auth-heading">
                        Manfaatkan Hidup Kita<br>dengan <span class="auth-heading-highlight">Baik</span>
                    </h2>

                    <div class="auth-quote">
                        <p>"Maka sesungguhnya bersama kesulitan itu ada kemudahan, sesungguhnya bersama kesulitan itu ada kemudahan."</p>
                        <cite>&#9679; QS. Al-Insyirah 94: Ayat 5-6</cite>
                    </div>

                    <ul class="auth-features">
                        <li>
                            <span class="auth-bullet"></span>
                            Akses penuh ke seluruh fitur LDK Syahid
                        </li>
                        <li>
                            <span class="auth-bullet"></span>
                            Pantau program kerja dan kegiatan terkini
                        </li>
                        <li>
                            <span class="auth-bullet"></span>
                            Bergabung dengan komunitas mahasiswa aktif
                        </li>
                    </ul>

                </div>
            </div>

            {{-- Right: Form Card --}}
            <div class="col-lg-6 col-md-10">
                <div class="auth-card">

                    <div class="auth-card-header">
                        <div class="auth-card-icon">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="auth-card-title">Selamat Datang Kembali! 👋</div>
                        <div class="auth-card-subtitle">Masukkan kredensial kamu untuk melanjutkan</div>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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
                                    value="{{ old('email') }}"
                                    required autocomplete="email" autofocus
                                />
                                <label for="email" class="has-icon">Email</label>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="auth-input-wrap">
                            <i class="fas fa-lock auth-input-icon" style="top:29px;transform:none;"></i>
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control has-icon @error('password') is-invalid @enderror"
                                    id="login_password"
                                    name="password"
                                    placeholder="Password"
                                    required autocomplete="current-password"
                                    style="padding-right:3rem;"
                                />
                                <label for="login_password" class="has-icon">Password</label>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <span class="auth-pwd-toggle" onclick="authTogglePass('login_password','loginPwdIcon')">
                                <i id="loginPwdIcon" class="fas fa-eye"></i>
                            </span>
                        </div>

                        {{-- Remember & Forgot --}}
                        <div class="d-flex justify-content-between align-items-center mb-3 auth-check">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label small" for="remember">Ingat Saya</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="auth-link">Lupa Password?</a>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="auth-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Masuk Sekarang</span>
                            <div class="auth-btn-shine"></div>
                        </button>

                        <div class="auth-divider">
                            <span>Belum punya akun?</span>
                        </div>

                        <p class="auth-bottom">
                            Yuk bergabung! <a href="/register">Daftar Sekarang &rarr;</a>
                        </p>

                    </form>
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
