@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.withdrawal.components._withdrawal-styles')
<style>
/* ── Confirm page extras ────────────────────────────── */
.cf-hero {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    border-radius: 16px;
    padding: 1.4rem 1.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    flex-wrap: wrap;
    color: #fff;
    position: relative;
    overflow: hidden;
}
.cf-hero::before {
    content: '';
    position: absolute;
    right: -30px; top: -30px;
    width: 140px; height: 140px;
    border-radius: 50%;
    background: rgba(255,255,255,.08);
}
.cf-hero::after {
    content: '';
    position: absolute;
    right: 50px; bottom: -40px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,.05);
}
.cf-hero-left { position: relative; z-index: 1; }
.cf-hero-label { font-size: .75rem; font-weight: 700; opacity: .8; text-transform: uppercase; letter-spacing: .08em; }
.cf-hero-amount { font-size: 2.2rem; font-weight: 800; line-height: 1.1; margin-top: .15rem; }
.cf-hero-ref { font-size: .72rem; opacity: .7; margin-top: .3rem; font-family: monospace; }
.cf-hero-right { position: relative; z-index: 1; }
.cf-hero-icon {
    width: 56px; height: 56px; border-radius: 50%;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
}
html.dark-mode .cf-hero { background: linear-gradient(135deg, #b45309, #92400e); }

/* ── Info rows ──────────────────────────────────────── */
.cf-info-row {
    display: flex;
    align-items: baseline;
    gap: .5rem;
    padding: .55rem 0;
    border-bottom: 1px solid #f3f4f6;
}
.cf-info-row:last-child { border-bottom: none; }
html.dark-mode .cf-info-row { border-bottom-color: rgba(255,255,255,.06); }
.cf-info-label {
    font-size: .75rem; font-weight: 700; color: #6b7280;
    min-width: 130px; text-transform: uppercase; letter-spacing: .04em; flex-shrink: 0;
}
.cf-info-value { font-size: .9rem; color: #111827; flex: 1; }
html.dark-mode .cf-info-label { color: #9ca3af; }
html.dark-mode .cf-info-value { color: #e5e7eb; }

/* ── Amount breakdown ───────────────────────────────── */
.cf-breakdown {
    background: rgba(0,167,157,.05);
    border: 1px solid rgba(0,167,157,.15);
    border-radius: 10px;
    padding: .85rem 1rem;
}
html.dark-mode .cf-breakdown { background: rgba(0,167,157,.08); border-color: rgba(0,167,157,.2); }
.cf-breakdown-row { display: flex; justify-content: space-between; align-items: center; padding: .3rem 0; font-size: .875rem; }
.cf-breakdown-row.total {
    border-top: 2px dashed rgba(0,167,157,.25);
    margin-top: .35rem;
    padding-top: .55rem;
    font-weight: 700;
}
.cf-net { font-size: 1.4rem; font-weight: 800; color: #059669; }
html.dark-mode .cf-net { color: #4ade80; }

/* ── Warning box ────────────────────────────────────── */
.cf-warning {
    border-radius: 12px;
    border: 1px solid #fbbf24;
    background: linear-gradient(135deg, rgba(251,191,36,.08) 0%, rgba(245,158,11,.05) 100%);
    overflow: hidden;
}
.cf-warning-header {
    background: rgba(251,191,36,.15);
    border-bottom: 1px solid rgba(251,191,36,.2);
    padding: .65rem 1rem;
    font-weight: 700;
    font-size: .88rem;
    color: #92400e;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.cf-warning-body { padding: 1rem; }
.cf-warning-dest {
    background: rgba(0,0,0,.04);
    border-radius: 8px;
    padding: .65rem .85rem;
    margin-bottom: .75rem;
    font-size: .875rem;
}
html.dark-mode .cf-warning { border-color: rgba(251,191,36,.3); background: rgba(251,191,36,.06); }
html.dark-mode .cf-warning-header { background: rgba(251,191,36,.1); border-color: rgba(251,191,36,.15); color: #fbbf24; }
html.dark-mode .cf-warning-dest { background: rgba(255,255,255,.04); }

/* ── Balance check panel ────────────────────────────── */
.cf-balance-panel {
    border-radius: 10px; padding: .75rem 1rem; font-size: .875rem;
    margin-bottom: .75rem;
}
.cf-balance-ok      { background: rgba(5,150,105,.07); border: 1px solid rgba(5,150,105,.2); }
.cf-balance-warn    { background: rgba(220,38,38,.07); border: 1px solid rgba(220,38,38,.25); }
.cf-balance-row     { display: flex; justify-content: space-between; align-items: center; padding: .2rem 0; }
.cf-balance-label   { font-size: .75rem; color: #6b7280; font-weight: 600; }
.cf-balance-value   { font-size: .875rem; font-weight: 700; color: #111827; }
.cf-balance-divider { border-top: 1px dashed rgba(0,0,0,.1); margin: .4rem 0; }
html.dark-mode .cf-balance-ok   { background: rgba(74,222,128,.06); border-color: rgba(74,222,128,.2); }
html.dark-mode .cf-balance-warn { background: rgba(248,113,113,.07); border-color: rgba(248,113,113,.25); }
html.dark-mode .cf-balance-label { color: #9ca3af; }
html.dark-mode .cf-balance-value { color: #e5e7eb; }
html.dark-mode .cf-balance-divider { border-color: rgba(255,255,255,.08); }

/* ── Cannot undo banner ─────────────────────────────── */
.cf-danger-banner {
    display: flex;
    align-items: center;
    gap: .6rem;
    background: rgba(220,53,69,.08);
    border: 1px solid rgba(220,53,69,.25);
    border-radius: 8px;
    padding: .6rem .85rem;
    font-size: .82rem;
    font-weight: 700;
    color: #b91c1c;
}
html.dark-mode .cf-danger-banner { background: rgba(248,113,113,.1); border-color: rgba(248,113,113,.3); color: #f87171; }

/* ── 2FA card ───────────────────────────────────────── */
.cf-2fa-card {
    background: linear-gradient(135deg, rgba(0,167,157,.04) 0%, rgba(0,139,132,.02) 100%);
    border: 1px solid rgba(0,167,157,.15);
    border-radius: 12px;
    padding: 1.25rem;
}
html.dark-mode .cf-2fa-card { background: rgba(0,167,157,.06); border-color: rgba(0,167,157,.2); }

/* ── Execute button ─────────────────────────────────── */
.btn-execute {
    background: linear-gradient(135deg, #059669, #047857);
    border: none;
    color: #fff;
    padding: .6rem 1.75rem;
    font-weight: 700;
    border-radius: 8px;
    font-size: .95rem;
    transition: all .25s;
    box-shadow: 0 4px 12px rgba(5,150,105,.35);
}
.btn-execute:hover {
    background: linear-gradient(135deg, #047857, #065f46);
    color: #fff;
    box-shadow: 0 6px 16px rgba(5,150,105,.45);
    transform: translateY(-1px);
}
.btn-execute:disabled {
    background: #9ca3af; box-shadow: none; transform: none; cursor: not-allowed;
}
html.dark-mode .btn-execute { background: linear-gradient(135deg, #047857, #065f46); }
</style>
@endsection

@php $requires2fa = \App\Helpers\TwoFaHelper::isAllowed(auth()->user()); @endphp

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center mb-4">
            <h1 class="page-title">
                <i class="fas fa-check-circle me-2"></i>
                <span>Confirm</span>
                <span class="highlighted-text ms-1">Withdrawal</span>
                <small>Review all details carefully before executing</small>
            </h1>
        </div>

        {{-- Hero Amount Banner --}}
        <div class="col-12 mb-4">
            <div class="cf-hero">
                <div class="cf-hero-left">
                    <div class="cf-hero-label">Withdrawal Amount</div>
                    <div class="cf-hero-amount">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</div>
                    <div class="cf-hero-ref"><i class="fas fa-tag me-1 opacity-75"></i>{{ $withdrawal->reff_id }}</div>
                </div>
                <div class="cf-hero-right">
                    <div class="cf-hero-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Left: Summary + Breakdown --}}
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Withdrawal Summary
                    </h5>

                    {{-- Info rows --}}
                    <div class="cf-info-row">
                        <span class="cf-info-label">Campaign</span>
                        <span class="cf-info-value fw-semibold">{{ $withdrawal->campaign->judul ?? '—' }}</span>
                    </div>
                    <div class="cf-info-row">
                        <span class="cf-info-label">Destination</span>
                        <span class="cf-info-value d-flex align-items-center gap-2 flex-wrap">
                            <span class="wd-bank-chip">{{ strtoupper($withdrawal->bank_code) }}</span>
                            <span class="fw-semibold">{{ $withdrawal->account_number }}</span>
                        </span>
                    </div>
                    <div class="cf-info-row">
                        <span class="cf-info-label">Account Holder</span>
                        <span class="cf-info-value fw-semibold">{{ $withdrawal->account_holder ?: '—' }}</span>
                    </div>
                    <div class="cf-info-row">
                        <span class="cf-info-label">Created By</span>
                        <span class="cf-info-value">{{ auth()->user()->name }}</span>
                    </div>
                    @if($withdrawal->remark)
                    <div class="cf-info-row">
                        <span class="cf-info-label">Remark</span>
                        <span class="cf-info-value text-muted">{{ $withdrawal->remark }}</span>
                    </div>
                    @endif

                    {{-- Amount Breakdown --}}
                    <div class="mt-4">
                        <div class="cf-breakdown">
                            <div class="cf-breakdown-row">
                                <span class="text-muted">Withdrawal Amount</span>
                                <span class="fw-semibold">Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="cf-breakdown-row">
                                <span class="text-muted">Transfer Fee</span>
                                <span class="text-danger fw-semibold">− Rp {{ number_format($withdrawal->fee, 0, ',', '.') }}</span>
                            </div>
                            <div class="cf-breakdown-row total">
                                <span>Amount Received by Recipient</span>
                                <span class="cf-net">Rp {{ number_format($withdrawal->amount_net, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Warning --}}
        <div class="col-md-5 mb-4">
            <div class="cf-warning h-100">
                <div class="cf-warning-header">
                    <i class="fas fa-exclamation-triangle"></i>
                    Before You Execute
                </div>
                <div class="cf-warning-body">
                    <p class="small text-muted mb-2">The following amount will be sent immediately:</p>

                    <div class="cf-warning-dest">
                        <div class="fw-bold fs-5 mb-1" style="color:#92400e">
                            Rp {{ number_format($withdrawal->amount_net, 0, ',', '.') }}
                        </div>
                        <div class="small">
                            <span class="wd-bank-chip me-1">{{ strtoupper($withdrawal->bank_code) }}</span>
                            <strong>{{ $withdrawal->account_number }}</strong>
                        </div>
                        <div class="small text-muted mt-1 fst-italic">{{ $withdrawal->account_holder }}</div>
                    </div>

                    <p class="small text-muted mb-2">
                        Campaign balance will be reduced by
                        <strong>Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}</strong>
                        (includes transfer fee of Rp {{ number_format($withdrawal->fee, 0, ',', '.') }}).
                    </p>

                    {{-- Live balance check --}}
                    <div class="cf-balance-panel {{ $canProceed ? 'cf-balance-ok' : 'cf-balance-warn' }} mb-3">
                        <div class="cf-balance-row">
                            <span class="cf-balance-label">QRIS Collected (after MDR)</span>
                            <span class="cf-balance-value">Rp {{ number_format($balance['qris_paid'], 0, ',', '.') }}</span>
                        </div>
                        <div class="cf-balance-row">
                            <span class="cf-balance-label">Already Withdrawn</span>
                            <span class="cf-balance-value text-muted">− Rp {{ number_format($balance['total_withdrawn'], 0, ',', '.') }}</span>
                        </div>
                        @php $otherPending = $balance['qris_paid'] - $balance['total_withdrawn'] - $effectiveAvailable; @endphp
                        @if($otherPending > 0)
                        <div class="cf-balance-row">
                            <span class="cf-balance-label">Other Pending Withdrawal(s)</span>
                            <span class="cf-balance-value text-warning">− Rp {{ number_format($otherPending, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        <div class="cf-balance-divider"></div>
                        <div class="cf-balance-row">
                            <span class="cf-balance-label fw-bold">Effective Available Now</span>
                            <span class="cf-balance-value {{ $canProceed ? 'text-success' : 'text-danger' }} fs-6">
                                Rp {{ number_format($effectiveAvailable, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="cf-balance-row mt-1">
                            <span class="cf-balance-label">This Withdrawal</span>
                            <span class="cf-balance-value {{ $canProceed ? '' : 'text-danger fw-bold' }}">
                                Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                                @if(!$canProceed)
                                    <i class="fas fa-exclamation-circle ms-1 text-danger"></i>
                                @else
                                    <i class="fas fa-check-circle ms-1 text-success"></i>
                                @endif
                            </span>
                        </div>
                        @if(!$canProceed)
                        <div class="mt-2 small fw-bold text-danger">
                            <i class="fas fa-times-circle me-1"></i>
                            Insufficient balance. Rp {{ number_format($withdrawal->amount - $effectiveAvailable, 0, ',', '.') }} short.
                            This may be caused by another withdrawal already executed.
                        </div>
                        @endif
                    </div>

                    <div class="cf-danger-banner">
                        <i class="fas fa-times-circle flex-shrink-0"></i>
                        <span>This action cannot be undone once executed.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2FA Card --}}
        @if($requires2fa)
        <div class="col-md-7 mb-4">
            @if(auth()->user()->google2fa_enabled)
            <div class="cf-2fa-card">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div style="width:36px;height:36px;border-radius:8px;background:rgba(0,167,157,.12);display:flex;align-items:center;justify-content:center;color:#00a79d;font-size:1rem;flex-shrink:0">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="font-size:.9rem;color:#00a79d">Two-Factor Authentication Required</div>
                        <div class="small text-muted">Enter the 6-digit code from your authenticator app</div>
                    </div>
                </div>
                <div id="twofa-field">
                    <input type="text" id="two-fa-code-input" name="two_fa_code_display"
                           class="form-control otp-code-input"
                           inputmode="numeric" maxlength="6" autocomplete="one-time-code" placeholder="000 000">
                    <small class="text-muted mt-1 d-block"><i class="fas fa-clock me-1"></i>Code refreshes every 30 seconds.</small>
                </div>
            </div>
            @else
            <div class="alert alert-warning mb-0">
                <i class="fas fa-exclamation-triangle me-2"></i>
                You must <a href="{{ route('admin.security.2fa') }}" class="fw-bold">enable Two-Factor Authentication</a>
                before you can execute withdrawals.
            </div>
            @endif
        </div>
        @endif

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-between align-items-center gap-2 mb-4 flex-wrap">
            <a href="{{ route('admin.celsyahid.campaign.finance', $withdrawal->campaign_id) }}"
               class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Cancel
            </a>
            <form action="{{ route('admin.celsyahid.withdrawal.execute', $withdrawal->id) }}" method="POST" id="execute-form">
                @csrf
                @if($requires2fa)
                    <input type="hidden" name="two_fa_code" id="two-fa-code-hidden">
                @endif
                @if($requires2fa && !auth()->user()->google2fa_enabled)
                    <button type="button" class="btn-execute" disabled>
                        <i class="fas fa-lock me-1"></i> 2FA Required
                    </button>
                @elseif(!$canProceed)
                    <button type="button" class="btn-execute" disabled
                        title="Insufficient balance — Rp {{ number_format($withdrawal->amount - $effectiveAvailable, 0, ',', '.') }} short">
                        <i class="fas fa-ban me-1"></i> Insufficient Balance
                    </button>
                @else
                    <button type="submit" class="btn-execute" id="btn-execute">
                        <i class="fas fa-paper-plane me-1"></i> Execute Withdrawal
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
    var codeInput  = document.getElementById('two-fa-code-input');
    var codeHidden = document.getElementById('two-fa-code-hidden');
    if (codeInput && codeHidden) {
        codeHidden.value = codeInput.value.replace(/\s/g, '').trim();
        if (codeHidden.value.length !== 6) {
            e.preventDefault();
            codeInput.focus();
            codeInput.classList.add('is-invalid');
            var existing = document.getElementById('twofa-error');
            if (!existing) {
                var err = document.createElement('div');
                err.id = 'twofa-error';
                err.className = 'invalid-feedback d-block';
                err.textContent = 'Please enter the 6-digit authenticator code.';
                codeInput.parentNode.appendChild(err);
            }
            return;
        }
        codeInput.classList.remove('is-invalid');
        var errEl = document.getElementById('twofa-error');
        if (errEl) errEl.remove();
    }
    @endif

    // All checks passed — disable to prevent double submission
    var btn = document.getElementById('btn-execute');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing…';
    }
});

@if($requires2fa && auth()->user()->google2fa_enabled)
// Auto-strip spaces from OTP input
document.getElementById('two-fa-code-input').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').slice(0, 6);
});
@endif
</script>
@endsection
