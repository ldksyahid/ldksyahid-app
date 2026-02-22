@extends('landing-page.template.body')

@section('content')

{{-- Confirm Password Section --}}
<div class="auth-center-section">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="auth-center-card">

                    {{-- Badge --}}
                    <div class="auth-badge" style="margin-bottom:1.5rem;">
                        <span>🔒</span>
                        <span>Konfirmasi Identitas</span>
                        <span class="auth-badge-pulse"></span>
                    </div>

                    {{-- Icon --}}
                    <div class="auth-card-icon" style="margin-bottom:1rem;">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <h3 class="auth-card-title mb-2">Pastikan Ini Kamu</h3>
                    <p class="auth-card-subtitle mb-1">
                        Area ini memerlukan konfirmasi identitas. Masukkan<br class="d-none d-sm-inline">password kamu untuk melanjutkan.
                    </p>

                    {{-- Quote --}}
                    <div class="auth-quote mt-3 mb-4" style="text-align:left;">
                        <p>"Dan janganlah kamu (merasa) lemah, dan jangan (pula) bersedih hati, sebab kamu paling tinggi (derajatnya), jika kamu orang yang beriman."</p>
                        <cite>&#9679; QS. Ali 'Imran 3: Ayat 139</cite>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        {{-- Password --}}
                        <div class="auth-input-wrap">
                            <div class="form-floating">
                                <input
                                    type="password"
                                    class="form-control has-icon @error('password') is-invalid @enderror"
                                    id="conf_password"
                                    name="password"
                                    placeholder="Password"
                                    required autocomplete="current-password"
                                    style="padding-right:3rem;"
                                />
                                <label for="conf_password" class="has-icon">Password</label>
                                <i class="fas fa-lock auth-input-icon"></i>
                                <span class="auth-pwd-toggle" onclick="authTogglePass('conf_password','confPwdIcon')">
                                    <i id="confPwdIcon" class="fas fa-eye"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="auth-btn mt-2">
                            <i class="fas fa-check-circle"></i>
                            <span>Konfirmasi Password</span>
                            <div class="auth-btn-shine"></div>
                        </button>

                    </form>

                    @if (Route::has('password.request'))
                        <div class="auth-divider">
                            <span>Lupa password?</span>
                        </div>
                        <p class="auth-bottom">
                            <a href="{{ route('password.request') }}" class="auth-link">Reset Password di sini &rarr;</a>
                        </p>
                    @endif

                    <div class="auth-note">
                        <i class="fas fa-circle-info"></i>
                        Halaman ini dilindungi untuk keamanan akun kamu. Konfirmasi diperlukan sebelum mengakses area sensitif.
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
@include('auth.passwords.confirm.components._index-styles')
@endsection

@section('scripts')
@include('auth.passwords.confirm.components._index-scripts')
@endsection
