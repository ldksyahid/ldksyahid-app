@extends('landing-page.template.body')

@section('content')

{{-- Register Section --}}
<div class="auth-section">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center align-items-center g-5">

            {{-- Left: Form Card --}}
            <div class="col-lg-6 col-md-10">
                <div class="auth-card">

                    <div class="auth-card-header">
                        <div class="auth-card-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="auth-card-title">Buat Akun Baru ✨</div>
                        <div class="auth-card-subtitle">Isi data di bawah untuk bergabung bersama kami</div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" autocomplete="off">
                        @csrf

                        {{-- Name --}}
                        <div class="auth-input-wrap">
                            <div class="form-floating">
                                <input
                                    type="text"
                                    class="form-control has-icon @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    placeholder="Nama Lengkap"
                                    value="{{ old('name') }}"
                                    required
                                />
                                <label for="name" class="has-icon">Nama Lengkap</label>
                                <i class="fas fa-user auth-input-icon"></i>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

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
                                    required
                                />
                                <label for="email" class="has-icon">Email</label>
                                <i class="fas fa-envelope auth-input-icon"></i>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="auth-input-wrap">
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control has-icon @error('password') is-invalid @enderror"
                                    id="reg_password"
                                    name="password"
                                    placeholder="Password"
                                    required
                                    style="padding-right:3rem;"
                                />
                                <label for="reg_password" class="has-icon">Password</label>
                                <i class="fas fa-lock auth-input-icon"></i>
                                <span class="auth-pwd-toggle" onclick="authTogglePass('reg_password','regPwdIcon')">
                                    <i id="regPwdIcon" class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirm Password --}}
                        <div class="auth-input-wrap">
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control has-icon @error('password_confirmation') is-invalid @enderror"
                                    id="reg_password_confirm"
                                    name="password_confirmation"
                                    placeholder="Konfirmasi Password"
                                    required
                                    style="padding-right:3rem;"
                                />
                                <label for="reg_password_confirm" class="has-icon">Konfirmasi Password</label>
                                <i class="fas fa-shield-alt auth-input-icon"></i>
                                <span class="auth-pwd-toggle" onclick="authTogglePass('reg_password_confirm','regConfirmIcon')">
                                    <i id="regConfirmIcon" class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password_confirmation')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Remember me --}}
                        <div class="mb-3 auth-check">
                            <div class="form-check">
                                <input type="checkbox" name="remember" class="form-check-input" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                <label class="form-check-label small" for="remember">Ingat Saya</label>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="auth-btn">
                            <i class="fas fa-user-plus"></i>
                            <span>Daftar Sekarang</span>
                            <div class="auth-btn-shine"></div>
                        </button>

                        <div class="auth-divider">
                            <span>atau daftar dengan</span>
                        </div>

                        <a href="{{ route('auth.google') }}" class="auth-google-btn">
                            <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                <path fill="none" d="M0 0h48v48H0z"/>
                            </svg>
                            <span>Daftar dengan Google</span>
                        </a>

                        <div class="auth-divider">
                            <span>Sudah punya akun?</span>
                        </div>

                        <p class="auth-bottom">
                            Langsung saja <a href="/login">Masuk di sini &rarr;</a>
                        </p>

                    </form>
                </div>
            </div>

            {{-- Right: Decorative Content (disembunyikan di mobile) --}}
            <div class="col-lg-5 col-md-10 auth-deco-col" style="opacity:0;transform:translateX(28px);animation:authRightIn 0.7s ease 0.1s forwards;">
                <div class="ps-lg-3">

                    <div class="auth-badge">
                        <span>🚀</span>
                        <span>Daftar Sekarang</span>
                        <span class="auth-badge-pulse"></span>
                    </div>

                    <h2 class="auth-heading">
                        Melangkah Keluar dari<br>Zona <span class="auth-heading-highlight">Nyaman</span>
                    </h2>

                    <div class="auth-quote">
                        <p>"Dan janganlah kamu (merasa) lemah, dan jangan (pula) bersedih hati, sebab kamu paling tinggi (derajatnya), jika kamu orang yang beriman."</p>
                        <cite>&#9679; QS. Ali 'Imran 3: Ayat 139</cite>
                    </div>

                    <ul class="auth-features">
                        <li>
                            <span class="auth-bullet"></span>
                            Bergabung dalam barisan dakwah kampus yang penuh semangat
                        </li>
                        <li>
                            <span class="auth-bullet"></span>
                            Mengikuti kajian, pembinaan, dan kegiatan keislaman rutin
                        </li>
                        <li>
                            <span class="auth-bullet"></span>
                            Bertumbuh dalam iman, ilmu, dan ukhuwah Islamiyah
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('styles')
@include('auth.register.components._index-styles')
@endsection

@section('scripts')
@include('auth.register.components._index-scripts')
@endsection
