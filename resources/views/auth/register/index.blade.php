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
