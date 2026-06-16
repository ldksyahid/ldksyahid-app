@extends('admin-page.template.body')

@section('styles')
@include('admin-page.security.two-factor.components._setup-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-user-shield me-2"></i>
                <span>2FA</span>
                <span class="highlighted-text ms-1">Security</span>
                <small>Two-Factor Authentication for Withdrawal</small>
            </h1>
        </div>

        @if($enabled)
            {{-- === ACTIVE STATE === --}}

            {{-- Card: Status --}}
            <div class="col-md-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-check-circle me-2"></i>Status
                        </h5>
                        <div class="mb-3">
                            <span class="status-badge-active">
                                <i class="fas fa-user-shield"></i>
                                Two-Factor Authentication is ACTIVE
                            </span>
                        </div>
                        @if($user->two_fa_enabled_at)
                        <p class="text-muted mb-2">
                            <i class="fas fa-calendar me-1"></i>
                            Enabled since: <strong>{{ $user->two_fa_enabled_at->format('d M Y, H:i') }}</strong>
                        </p>
                        @endif
                        @if($user->two_fa_last_used_at)
                        <p class="text-muted mb-2">
                            <i class="fas fa-clock me-1"></i>
                            Last verified: <strong>{{ $user->two_fa_last_used_at->format('d M Y, H:i') }}</strong>
                            @if($user->two_fa_last_used_ip)
                                from <code>{{ $user->two_fa_last_used_ip }}</code>
                            @endif
                        </p>
                        @endif
                        <div class="mt-3">
                            <a href="{{ route('admin.security.2fa.users') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-users me-1"></i> View All 2FA Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card: Disable --}}
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="section-title danger mb-3">
                            <i class="fas fa-triangle-exclamation me-2"></i>Disable 2FA
                        </h5>
                        <div class="alert alert-warning mb-3">
                            <small>Enter your current authenticator code to disable 2FA. You will need to set it up again to execute withdrawals.</small>
                        </div>
                        <form action="{{ route('admin.security.2fa.disable') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Current 6-Digit Code</label>
                                <input type="text" name="code" class="form-control otp-input @error('code') is-invalid @enderror"
                                       inputmode="numeric" maxlength="6" autocomplete="one-time-code" placeholder="000000">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Are you sure you want to disable 2FA? You will not be able to execute withdrawals until you set it up again.')">
                                <i class="fas fa-lock-open me-1"></i> Disable 2FA
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        @else
            {{-- === SETUP STATE === --}}

            {{-- Card: Setup --}}
            <div class="col-md-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-qrcode me-2"></i>Scan QR Code
                        </h5>

                        <ol class="step-list mb-4">
                            <li>Download <strong>Google Authenticator</strong> or any TOTP app on your phone.</li>
                            <li>Tap the <strong>+</strong> button and choose <em>Scan QR code</em>.</li>
                            <li>Scan the QR code below, then enter the 6-digit code to confirm.</li>
                        </ol>

                        {{-- QR Code --}}
                        <div class="qr-wrapper mb-3">
                            {!! $qrSvg !!}
                        </div>

                        {{-- Manual entry --}}
                        <p class="text-center text-muted small mb-2">Or enter this code manually:</p>
                        <div class="secret-key mb-4">{{ $secretFormatted }}</div>

                        {{-- Verify form --}}
                        <form action="{{ route('admin.security.2fa.enable') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Enter 6-Digit Code to Confirm Setup</label>
                                <input type="text" name="code" class="form-control otp-input @error('code') is-invalid @enderror"
                                       inputmode="numeric" maxlength="6" autocomplete="one-time-code"
                                       placeholder="000000" autofocus>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Code changes every 30 seconds.</small>
                            </div>
                            <button type="submit" class="btn btn-custom-primary">
                                <i class="fas fa-lock me-1"></i> Enable 2FA
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Card: Info --}}
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-info-circle me-2"></i>Why 2FA?
                        </h5>
                        <p class="text-muted small mb-3">
                            Two-Factor Authentication adds a second layer of security before executing fund withdrawals.
                            Even if your password is compromised, funds cannot be transferred without access to your authenticator app.
                        </p>
                        <ul class="step-list">
                            <li>Works offline — no internet needed after setup</li>
                            <li>Code changes every 30 seconds</li>
                            <li>Required for every withdrawal execution</li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
