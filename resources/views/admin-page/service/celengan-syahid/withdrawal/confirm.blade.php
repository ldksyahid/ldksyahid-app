@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.withdrawal.components._withdrawal-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-circle-check me-2"></i>
                <span>Confirm</span>
                <span class="highlighted-text ms-1">Withdrawal</span>
                <small>Review carefully before executing</small>
            </h1>
        </div>

        {{-- Card 1: Withdrawal Summary --}}
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Withdrawal Summary
                    </h5>

                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Campaign</label>
                            <div class="form-control-plaintext">{{ $withdrawal->campaign->judul ?? '—' }}</div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Reference ID</label>
                            <div class="form-control-plaintext">
                                <code class="small">{{ $withdrawal->reff_id }}</code>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Created By</label>
                            <div class="form-control-plaintext">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Destination Bank</label>
                            <div class="form-control-plaintext fw-semibold">{{ strtoupper($withdrawal->bank_code) }}</div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Account Number</label>
                            <div class="form-control-plaintext">{{ $withdrawal->account_number }}</div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Account Holder</label>
                            <div class="form-control-plaintext fw-semibold">{{ $withdrawal->account_holder ?: '—' }}</div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Withdrawal Amount</label>
                            <div class="form-control-plaintext fs-5 fw-bold" class="text-brand">
                                Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Transfer Fee</label>
                            <div class="form-control-plaintext text-muted">
                                Rp {{ number_format($withdrawal->fee, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Amount Received</label>
                            <div class="amount-net">
                                Rp {{ number_format($withdrawal->amount_net, 0, ',', '.') }}
                            </div>
                        </div>
                        @if($withdrawal->remark)
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Remark</label>
                            <div class="form-control-plaintext">{{ $withdrawal->remark }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Warning --}}
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm border-warning h-100">
                <div class="card-body">
                    <h5 class="section-title danger mb-3">
                        <i class="fas fa-triangle-exclamation me-2"></i>Warning
                    </h5>
                    <div class="alert alert-warning mb-0">
                        <p class="mb-2 fw-semibold">
                            An amount of <strong>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</strong>
                            will be transferred to:
                        </p>
                        <p class="mb-2">
                            <strong>{{ strtoupper($withdrawal->bank_code) }}</strong>
                            {{ $withdrawal->account_number }}
                            <br>
                            <em>{{ $withdrawal->account_holder }}</em>
                        </p>
                        <p class="mb-0 text-danger fw-semibold">
                            <i class="fas fa-circle-xmark me-1"></i>
                            This action cannot be undone once executed.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @php $requires2fa = \App\Helpers\TwoFaHelper::isAllowed(auth()->user()); @endphp

        @if($requires2fa)
        {{-- Card 3: 2FA Verification --}}
        <div class="col-md-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-shield-halved me-2"></i>Two-Factor Authentication
                    </h5>
                    @if(auth()->user()->google2fa_enabled)
                        <p class="text-muted mb-3">Enter the 6-digit code from your authenticator app to proceed.</p>
                        <div class="mb-0" id="twofa-field">
                            <label class="form-label fw-bold">Authenticator Code</label>
                            <input type="text" id="two-fa-code-input" name="two_fa_code_display"
                                   class="form-control otp-code-input"
                                   inputmode="numeric" maxlength="6" autocomplete="one-time-code" placeholder="000000">
                            <small class="text-muted">Code changes every 30 seconds.</small>
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-triangle-exclamation me-2"></i>
                            You must <a href="{{ route('admin.security.2fa') }}" class="fw-bold">enable Two-Factor Authentication</a>
                            before you can execute withdrawals.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('admin.celsyahid.campaign.finance', $withdrawal->campaign_id) }}"
               class="btn btn-danger">
                <i class="fas fa-times me-1"></i> Cancel
            </a>
            <form action="{{ route('admin.celsyahid.withdrawal.execute', $withdrawal->id) }}" method="POST" id="execute-form">
                @csrf
                @if($requires2fa)
                    <input type="hidden" name="two_fa_code" id="two-fa-code-hidden">
                @endif
                @if($requires2fa && !auth()->user()->google2fa_enabled)
                    <button type="button" class="btn btn-custom-primary" disabled>
                        <i class="fas fa-lock me-1"></i> 2FA Required
                    </button>
                @else
                    <button type="submit" class="btn btn-custom-primary" id="btn-execute">
                        <i class="fas fa-check me-1"></i> Yes, Execute Now
                    </button>
                @endif
            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('execute-form').addEventListener('submit', function (e) {
    @if($requires2fa && auth()->user()->google2fa_enabled)
    // Copy visible OTP input value to hidden field
    var codeInput  = document.getElementById('two-fa-code-input');
    var codeHidden = document.getElementById('two-fa-code-hidden');
    if (codeInput && codeHidden) {
        codeHidden.value = codeInput.value.trim();
        if (codeHidden.value.length !== 6) {
            e.preventDefault();
            codeInput.focus();
            codeInput.classList.add('is-invalid');
            if (!document.getElementById('twofa-error')) {
                var err = document.createElement('div');
                err.id = 'twofa-error';
                err.className = 'invalid-feedback d-block';
                err.textContent = 'Please enter the 6-digit authenticator code.';
                codeInput.parentNode.appendChild(err);
            }
            return;
        }
        codeInput.classList.remove('is-invalid');
    }
    @endif

    var btn = document.getElementById('btn-execute');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
    }
});
</script>
@endsection
