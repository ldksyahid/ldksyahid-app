@extends('admin-page.template.body')

@section('styles')
@include('admin-page.security.two-factor.components._setup-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Header --}}
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="page-title mb-0">
                        <i class="fas fa-user-shield me-2"></i>2FA Security
                    </h1>
                    <p class="text-muted mb-0 mt-1 small">Two-Factor Authentication for withdrawal execution</p>
                </div>
                <a href="{{ route('admin.security.2fa.users') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px">
                    <i class="fas fa-users me-1"></i> View All 2FA Users
                </a>
            </div>
        </div>

        @if($enabled)
        {{-- ═══════════ ACTIVE STATE ═══════════ --}}

        {{-- Stat cards --}}
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-active"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <div class="tfa-stat-label">Status</div>
                            <div class="tfa-stat-value" style="font-size:1.1rem; color:#059669">Active</div>
                            <div class="tfa-stat-sub">2FA is enabled</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-total"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div class="tfa-stat-label">Enabled Since</div>
                            <div class="tfa-stat-value" style="font-size:1rem">
                                {{ $user->two_fa_enabled_at ? $user->two_fa_enabled_at->format('d M Y') : '—' }}
                            </div>
                            <div class="tfa-stat-sub">{{ $user->two_fa_enabled_at ? $user->two_fa_enabled_at->format('H:i') : '' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-pending"><i class="fas fa-clock"></i></div>
                        <div>
                            <div class="tfa-stat-label">Last Verified</div>
                            <div class="tfa-stat-value" style="font-size:1rem">
                                {{ $user->two_fa_last_used_at ? $user->two_fa_last_used_at->format('d M Y') : '—' }}
                            </div>
                            <div class="tfa-stat-sub">
                                @if($user->two_fa_last_used_at)
                                    {{ $user->two_fa_last_used_at->format('H:i') }}
                                    @if($user->two_fa_last_used_ip)
                                        from <code>{{ $user->two_fa_last_used_ip }}</code>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status + Disable --}}
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-4">
                        <i class="fas fa-check-circle me-2" style="color:#059669"></i>Authentication Active
                    </h5>

                    <div class="mb-4">
                        <span class="status-badge-active">
                            <i class="fas fa-shield-alt"></i>
                            Two-Factor Authentication is ACTIVE
                        </span>
                    </div>

                    <div class="tfa-info-row">
                        <span class="tfa-info-label">Account</span>
                        <span class="tfa-info-value fw-semibold">{{ $user->name }}</span>
                    </div>
                    <div class="tfa-info-row">
                        <span class="tfa-info-label">Email</span>
                        <span class="tfa-info-value">{{ $user->email }}</span>
                    </div>
                    @if($user->two_fa_enabled_at)
                    <div class="tfa-info-row">
                        <span class="tfa-info-label">Enabled Since</span>
                        <span class="tfa-info-value">{{ $user->two_fa_enabled_at->isoFormat('D MMM YYYY, HH:mm') }}</span>
                    </div>
                    @endif
                    @if($user->two_fa_last_used_at)
                    <div class="tfa-info-row">
                        <span class="tfa-info-label">Last Verified</span>
                        <span class="tfa-info-value">
                            {{ $user->two_fa_last_used_at->isoFormat('D MMM YYYY, HH:mm') }}
                            @if($user->two_fa_last_used_ip)
                                <code class="ms-1">{{ $user->two_fa_last_used_ip }}</code>
                            @endif
                        </span>
                    </div>
                    @endif

                    <div class="mt-4 p-3 rounded" style="background:rgba(0,167,157,.05);border:1px solid rgba(0,167,157,.15)">
                        <p class="small text-muted mb-0">
                            <i class="fas fa-info-circle me-1" style="color:#00a79d"></i>
                            Your authenticator app is required each time you execute a withdrawal. Keep it accessible.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="tfa-disable-card h-100">
                <div class="tfa-disable-header">
                    <i class="fas fa-exclamation-triangle"></i> Disable 2FA
                </div>
                <div class="tfa-disable-body">
                    <p class="small text-muted mb-3">
                        Enter your current authenticator code to disable 2FA.
                        You will need to set it up again to execute withdrawals.
                    </p>
                    <form action="{{ route('admin.security.2fa.disable') }}" method="POST" id="disable-2fa-form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Current 6-Digit Code</label>
                            <input type="text" name="code"
                                   class="form-control otp-input @error('code') is-invalid @enderror"
                                   inputmode="numeric" maxlength="6" autocomplete="one-time-code"
                                   placeholder="000000">
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-clock me-1"></i>Code changes every 30 seconds.
                            </small>
                        </div>
                        <button type="button" class="btn btn-danger w-100"
                            style="border-radius:8px;font-weight:700"
                            id="btn-disable-2fa">
                            <i class="fas fa-lock-open me-1"></i> Disable 2FA
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @else
        {{-- ═══════════ SETUP STATE ═══════════ --}}

        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-qrcode me-2"></i>Scan QR Code to Set Up
                    </h5>

                    <ol class="step-list mb-4">
                        <li>Download <strong>Google Authenticator</strong> or any TOTP app on your phone.</li>
                        <li>Tap <strong>+</strong> and choose <em>Scan QR code</em>.</li>
                        <li>Scan the QR code below, then enter the 6-digit code to confirm.</li>
                    </ol>

                    <div class="qr-wrapper mb-3">
                        {!! $qrSvg !!}
                    </div>

                    <p class="text-center text-muted small mb-2">Or enter this code manually in your app:</p>
                    <div class="secret-key mb-4">{{ $secretFormatted }}</div>

                    <form action="{{ route('admin.security.2fa.enable') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Enter 6-Digit Code to Confirm Setup</label>
                            <input type="text" name="code"
                                   class="form-control otp-input @error('code') is-invalid @enderror"
                                   inputmode="numeric" maxlength="6" autocomplete="one-time-code"
                                   placeholder="000000" autofocus>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Code changes every 30 seconds.</small>
                        </div>
                        <button type="submit" class="btn btn-custom-primary" style="border-radius:8px;font-weight:700">
                            <i class="fas fa-lock me-1"></i> Enable 2FA
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-info-circle me-2"></i>Why Set Up 2FA?
                    </h5>
                    <p class="text-muted small mb-3">
                        Two-Factor Authentication adds a second layer of security before executing fund withdrawals.
                        Even if your password is compromised, funds cannot be transferred without your authenticator app.
                    </p>
                    <ul class="step-list mb-4">
                        <li>Works offline — no internet needed after setup</li>
                        <li>Code changes every 30 seconds</li>
                        <li>Required for every withdrawal execution</li>
                    </ul>

                    <div class="p-3 rounded" style="background:rgba(245,158,11,.06);border:1px solid rgba(245,158,11,.2)">
                        <p class="small mb-0" style="color:#92400e">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>You cannot execute withdrawals</strong> until 2FA is enabled for your account.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @endif

    </div>
</div>
@endsection

@section('scripts')
<script>
$(function () {
    @if($enabled)
    // Numeric-only OTP input
    $(document).on('input', 'input[name="code"]', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 6);
    });

    // SweetAlert confirmation for Disable 2FA
    $(document).on('click', '#btn-disable-2fa', function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Disable 2FA?',
            html: 'You will <strong>not be able to execute withdrawals</strong> until you set up 2FA again.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Disable',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
        }).then(function (result) {
            if (result.isConfirmed) {
                $('#disable-2fa-form').submit();
            }
        });
    });
    @endif
});
</script>
@endsection
