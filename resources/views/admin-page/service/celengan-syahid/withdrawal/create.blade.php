@extends('admin-page.template.body')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@include('admin-page.service.celengan-syahid.withdrawal.components._withdrawal-styles')
<style>
/* ── Create page extras ─────────────────────────────── */
#amount::-webkit-inner-spin-button,
#amount::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
#amount { -moz-appearance: textfield; }

/* Balance stat mini-cards */
.cw-bal-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
    padding: .9rem 1.1rem;
    display: flex;
    align-items: center;
    gap: .85rem;
}
html.dark-mode .cw-bal-card { background: #2b2f33; box-shadow: 0 2px 10px rgba(0,0,0,.3); }
.cw-bal-icon {
    width: 44px; height: 44px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.1rem;
}
.cw-bal-icon-avail  { background: rgba(5,150,105,.12); color: #059669; }
.cw-bal-icon-pend   { background: rgba(245,158,11,.12); color: #d97706; }
html.dark-mode .cw-bal-icon-avail { background: rgba(74,222,128,.1); color: #4ade80; }
html.dark-mode .cw-bal-icon-pend  { background: rgba(251,191,36,.1); color: #fbbf24; }
.cw-bal-label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #9ca3af; margin-bottom: 1px; }
.cw-bal-value { font-size: 1.3rem; font-weight: 800; color: #059669; line-height: 1.1; }
.cw-bal-value-pend { color: #d97706; }
.cw-bal-sub   { font-size: .7rem; color: #9ca3af; margin-top: 1px; }
html.dark-mode .cw-bal-value { color: #4ade80; }
html.dark-mode .cw-bal-value-pend { color: #fbbf24; }

/* Step badge */
.cw-step-badge {
    display: inline-flex;
    align-items: center;
    gap: .4em;
    font-size: .7rem;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    background: rgba(0,167,157,.1);
    color: #00a79d;
    border: 1px solid rgba(0,167,157,.2);
    border-radius: 50px;
    padding: .18em .7em;
    margin-bottom: .4rem;
}
html.dark-mode .cw-step-badge { background: rgba(45,212,191,.1); color: #2dd4bf; border-color: rgba(45,212,191,.2); }

/* Inquiry result card */
.cw-inquiry-card {
    border-radius: 10px;
    padding: .75rem 1rem;
    font-size: .875rem;
}
.cw-inquiry-success { background: rgba(5,150,105,.07); border: 1px solid rgba(5,150,105,.2); }
.cw-inquiry-error   { background: rgba(220,53,69,.06);  border: 1px solid rgba(220,53,69,.2); }
.cw-inquiry-title   { font-weight: 700; font-size: .85rem; margin-bottom: .5rem; display: flex; align-items: center; gap: .4rem; }
.cw-inquiry-success .cw-inquiry-title { color: #059669; }
.cw-inquiry-error   .cw-inquiry-title { color: #dc2626; }
.cw-inquiry-grid    { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: .5rem .75rem; }
.cw-inquiry-field-label { font-size: .7rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
.cw-inquiry-field-val   { font-weight: 700; font-size: .875rem; color: #111827; }
html.dark-mode .cw-inquiry-success { background: rgba(74,222,128,.06); border-color: rgba(74,222,128,.2); }
html.dark-mode .cw-inquiry-error   { background: rgba(248,113,113,.06); border-color: rgba(248,113,113,.2); }
html.dark-mode .cw-inquiry-field-val { color: #e5e7eb; }

/* Net breakdown */
.cw-breakdown {
    background: rgba(0,167,157,.05);
    border: 1px solid rgba(0,167,157,.15);
    border-radius: 10px;
    padding: .85rem 1rem;
    font-size: .875rem;
}
html.dark-mode .cw-breakdown { background: rgba(0,167,157,.08); border-color: rgba(0,167,157,.2); }
.cw-bd-row { display: flex; justify-content: space-between; align-items: center; padding: .28rem 0; }
.cw-bd-row.total {
    border-top: 2px dashed rgba(0,167,157,.25);
    margin-top: .35rem;
    padding-top: .55rem;
    font-weight: 700;
}

/* Fee display */
.cw-fee-display {
    min-height: 38px;
    display: flex;
    align-items: center;
    font-size: .9rem;
}

/* Campaign select card */
.cw-campaign-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(0,0,0,.07);
    padding: 1.5rem;
    text-align: center;
}
html.dark-mode .cw-campaign-card { background: #2b2f33; }
.cw-campaign-icon {
    width: 56px; height: 56px; border-radius: 14px;
    background: rgba(0,167,157,.1); color: #00a79d;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; margin: 0 auto .85rem;
}

/* Submit button */
.btn-cw-submit {
    background: linear-gradient(135deg, #00a79d, #008b84);
    border: none; color: #fff;
    padding: .6rem 1.75rem;
    font-weight: 700; border-radius: 8px; font-size: .95rem;
    transition: all .25s;
    box-shadow: 0 4px 12px rgba(0,167,157,.35);
}
.btn-cw-submit:hover {
    background: linear-gradient(135deg, #008b84, #006f6a);
    color: #fff;
    box-shadow: 0 6px 16px rgba(0,167,157,.45);
    transform: translateY(-1px);
}
.btn-cw-submit:disabled { background: #9ca3af; box-shadow: none; transform: none; }

@media (max-width: 767px) {
    .cw-bal-card { padding: .7rem .85rem; }
    .cw-bal-value { font-size: 1.1rem; }
}
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center mb-4">
            <h1 class="page-title">
                <i class="fas fa-plus-circle me-2"></i>
                <span>Create</span>
                <span class="highlighted-text ms-1">Withdrawal</span>
                @if($campaign)
                <small>{{ $campaign->judul }}</small>
                @endif
            </h1>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
        <div class="col-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.celsyahid.withdrawal.store') }}" method="POST" id="withdrawal-form">
        @csrf

        {{-- Campaign selector (if not pre-selected) --}}
        @if(!$campaign)
        <div class="col-12 mb-4">
            <div class="cw-campaign-card">
                <div class="cw-campaign-icon"><i class="fas fa-hand-holding-heart"></i></div>
                <h5 class="fw-bold mb-1" style="color:#00a79d">Select a Campaign</h5>
                <p class="text-muted small mb-3">Choose the campaign you want to withdraw funds from.</p>
                <div class="col-md-6 mx-auto">
                    <select name="campaign_id" class="form-select" required
                        onchange="window.location='{{ route('admin.celsyahid.withdrawal.create') }}?campaign_id='+this.value">
                        <option value="">— Select a campaign —</option>
                        @foreach($campaigns as $c)
                        <option value="{{ $c->id }}" {{ old('campaign_id') == $c->id ? 'selected' : '' }}>
                            {{ $c->judul }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @else
        <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
        @endif

        @if($campaign && $balance)

        {{-- Balance mini stat cards --}}
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="cw-bal-card">
                        <div class="cw-bal-icon cw-bal-icon-avail"><i class="fas fa-wallet"></i></div>
                        <div>
                            <div class="cw-bal-label">Available to Withdraw</div>
                            <div class="cw-bal-value">Rp {{ number_format($balance['available'], 0, ',', '.') }}</div>
                            <div class="cw-bal-sub">Via Amdigipay - Bisatopup</div>
                        </div>
                    </div>
                </div>
                @if($balance['pending_withdrawal'] > 0)
                <div class="col-md-4">
                    <div class="cw-bal-card">
                        <div class="cw-bal-icon cw-bal-icon-pend"><i class="fas fa-clock"></i></div>
                        <div>
                            <div class="cw-bal-label">Pending Withdrawal</div>
                            <div class="cw-bal-value cw-bal-value-pend">Rp {{ number_format($balance['pending_withdrawal'], 0, ',', '.') }}</div>
                            <div class="cw-bal-sub">Awaiting confirmation</div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-4">
                    <div class="cw-bal-card">
                        <div class="cw-bal-icon" style="background:rgba(99,102,241,.1);color:#6366f1"><i class="fas fa-hand-holding-usd"></i></div>
                        <div>
                            <div class="cw-bal-label">Total Collected (PAID)</div>
                            <div class="cw-bal-value" style="color:#6366f1">Rp {{ number_format($balance['qris_paid'], 0, ',', '.') }}</div>
                            <div class="cw-bal-sub">QRIS online payments</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Step 1: Destination Account --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="cw-step-badge"><i class="fas fa-circle" style="font-size:.45rem"></i> Step 1</div>
                    <h5 class="section-title mb-3"><i class="fas fa-university me-2"></i>Destination Account</h5>

                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label fw-bold">Destination Bank <span class="text-danger">*</span></label>
                            <select name="bank_code" id="bank_code" class="form-select @error('bank_code') is-invalid @enderror" required>
                                <option value="">— Select bank —</option>
                                @foreach($bankList as $bank)
                                <option value="{{ $bank['bank_code'] ?? $bank['code'] ?? '' }}"
                                    {{ old('bank_code') == ($bank['bank_code'] ?? $bank['code'] ?? '') ? 'selected' : '' }}>
                                    {{ $bank['name'] ?? $bank['bank_name'] ?? $bank['bank_code'] ?? '' }}
                                </option>
                                @endforeach
                            </select>
                            @error('bank_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold">Account Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" id="account_number" name="account_number"
                                       class="form-control @error('account_number') is-invalid @enderror"
                                       value="{{ old('account_number') }}"
                                       placeholder="e.g. 1234567890" required>
                                @error('account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" id="btn-verify" class="btn btn-verify-account w-100" style="height:38px">
                                <i class="fas fa-check-circle me-1"></i> Verify
                            </button>
                        </div>
                    </div>

                    {{-- Hidden fields --}}
                    <input type="hidden" name="account_holder" id="account_holder" value="{{ old('account_holder') }}">
                    <input type="hidden" name="fee" id="fee" value="{{ old('fee', 0) }}">
                    <input type="hidden" name="recipient_city_code" id="recipient_city_code" value="{{ old('recipient_city_code') }}">

                    {{-- Inquiry result --}}
                    <div id="inquiry-msg" class="mt-3"></div>
                </div>
            </div>
        </div>

        {{-- Step 2: Withdrawal Details --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="cw-step-badge"><i class="fas fa-circle" style="font-size:.45rem"></i> Step 2</div>
                    <h5 class="section-title mb-3"><i class="fas fa-file-invoice-dollar me-2"></i>Withdrawal Details</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Withdrawal Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text fw-semibold">Rp</span>
                                <input type="text" inputmode="numeric" name="amount" id="amount"
                                       class="form-control @error('amount') is-invalid @enderror"
                                       value="{{ old('amount') ? number_format((int) old('amount'), 0, ',', '.') : '' }}"
                                       data-max="{{ $balance['available'] }}"
                                       placeholder="Min. 10.000" required autocomplete="off">
                                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <small class="text-muted">
                                Max: <strong>Rp {{ number_format($balance['available'], 0, ',', '.') }}</strong> — fee will be deducted.
                            </small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Transfer Fee</label>
                            <div class="cw-fee-display" id="fee-display">
                                <span class="text-muted small">— Verify account first —</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Remark <span class="text-muted fw-normal small">(optional)</span></label>
                            <input type="text" name="remark" class="form-control @error('remark') is-invalid @enderror"
                                   value="{{ old('remark') }}" maxlength="100"
                                   placeholder="e.g. Fund withdrawal">
                            @error('remark')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Net breakdown --}}
                        <div id="net-breakdown" class="col-12" style="display:none">
                            <div class="cw-breakdown">
                                <div class="cw-bd-row">
                                    <span class="text-muted">Campaign Deduction</span>
                                    <span class="fw-semibold" id="bd-gross">Rp 0</span>
                                </div>
                                <div class="cw-bd-row">
                                    <span class="text-danger">Transfer Fee</span>
                                    <span class="fw-semibold text-danger" id="bd-fee-line">− Rp 0</span>
                                </div>
                                <div class="cw-bd-row total">
                                    <span>Recipient Receives</span>
                                    <span class="fs-5" id="bd-net">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        {{-- Amount warning --}}
                        <div id="amount-warning" class="col-12" style="display:none">
                            <div class="alert alert-warning py-2 mb-0" id="amount-warning-msg"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @endif

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-between align-items-center gap-2 mb-4 flex-wrap">
            @if($campaign)
            <a href="{{ route('admin.celsyahid.campaign.finance', $campaign->id) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Cancel
            </a>
            @else
            <a href="{{ route('admin.celsyahid.withdrawal.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            @endif

            @if($campaign && $balance)
            <button type="submit" class="btn-cw-submit" id="btn-submit">
                <i class="fas fa-arrow-right me-1"></i> Continue to Confirmation
            </button>
            @endif
        </div>

        </form>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    $('select[name="campaign_id"]').each(function () {
        $(this).select2({ placeholder: '— Select a campaign —', allowClear: false, width: '100%', dropdownParent: $('body') });
    });
    $('#bank_code').select2({ placeholder: '— Select bank —', allowClear: false, width: '100%', dropdownParent: $('body'), minimumResultsForSearch: 5 });
});
</script>
<script>
(function () {
    var btnVerify    = document.getElementById('btn-verify');
    var bankCodeEl   = document.getElementById('bank_code');
    var accountNoEl  = document.getElementById('account_number');
    var holderHidden = document.getElementById('account_holder');
    var feeHidden    = document.getElementById('fee');
    var feeDisplay   = document.getElementById('fee-display');
    var inquiryMsg   = document.getElementById('inquiry-msg');
    var amountEl     = document.getElementById('amount');
    var currentFee   = 0;
    var available    = {{ $balance['available'] ?? 0 }};

    function fmt(n) { return 'Rp ' + Math.abs(n).toLocaleString('id-ID'); }

    function formatRibu(val) {
        var digits = val.replace(/[^\d]/g, '');
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateBreakdown() {
        var netBox    = document.getElementById('net-breakdown');
        var warnBox   = document.getElementById('amount-warning');
        var warnMsg   = document.getElementById('amount-warning-msg');
        var bdGross   = document.getElementById('bd-gross');
        var bdFeeLine = document.getElementById('bd-fee-line');
        var bdNetEl   = document.getElementById('bd-net');
        if (!netBox) return;

        var raw   = amountEl ? amountEl.value.replace(/\./g, '') : '';
        var gross = parseInt(raw) || 0;

        if (!currentFee || !gross) { netBox.style.display = 'none'; if (warnBox) warnBox.style.display = 'none'; return; }

        var net = gross - currentFee;
        bdGross.textContent   = fmt(gross);
        bdFeeLine.textContent = '− ' + fmt(currentFee);
        bdNetEl.textContent   = net > 0 ? fmt(net) : 'Rp 0';
        netBox.style.display  = 'block';

        var warning = '';
        if (gross > available) {
            warning = 'Amount exceeds available balance (' + fmt(available) + ').';
        } else if (net <= 0) {
            warning = 'Amount must be greater than the transfer fee (' + fmt(currentFee) + ').';
        } else if (net < 10000) {
            warning = 'Recipient amount (' + fmt(net) + ') is below the minimum transfer of Rp 10.000.';
        }

        if (warning) {
            warnMsg.innerHTML     = '<i class="fas fa-exclamation-triangle me-1"></i>' + warning;
            warnBox.style.display = 'block';
            bdNetEl.className     = 'fs-5 fw-bold text-danger';
        } else {
            if (warnBox) warnBox.style.display = 'none';
            bdNetEl.className = 'fs-5 fw-bold text-brand';
        }
    }

    if (amountEl) {
        amountEl.addEventListener('input', function () {
            var raw    = this.value.replace(/[^\d]/g, '');
            var cursor = this.selectionStart;
            var oldLen = this.value.length;
            this.value = raw ? formatRibu(raw) : '';
            var newLen = this.value.length;
            this.setSelectionRange(cursor + (newLen - oldLen), cursor + (newLen - oldLen));
            updateBreakdown();
        });
    }

    if (!btnVerify) return;

    btnVerify.addEventListener('click', function () {
        var bankCode  = bankCodeEl ? bankCodeEl.value : '';
        var accountNo = accountNoEl ? accountNoEl.value.trim() : '';

        if (!bankCode || !accountNo) {
            inquiryMsg.innerHTML = '<div class="alert alert-warning py-2 mb-0"><i class="fas fa-exclamation-triangle me-1"></i>Please select a bank and enter an account number first.</div>';
            return;
        }

        btnVerify.disabled = true;
        btnVerify.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Verifying...';
        inquiryMsg.innerHTML = '';

        fetch('{{ route("admin.celsyahid.withdrawal.inquiry") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ bank_code: bankCode, account_number: accountNo })
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.error) {
                document.getElementById('account_holder').value = '';
                feeHidden.value      = '0';
                feeDisplay.innerHTML = '<span class="text-muted small">—</span>';
                currentFee = 0;
                updateBreakdown();

                var errBank   = data.bank_name || (bankCodeEl.options[bankCodeEl.selectedIndex] ? bankCodeEl.options[bankCodeEl.selectedIndex].text : bankCode);
                var errAcc    = data.account_number || accountNo;
                var errStatus = data.status ? data.status.replace(/_/g, ' ') : 'FAILED';
                var errMsg    = data.message || 'Account not found or verification failed.';

                inquiryMsg.innerHTML =
                    '<div class="cw-inquiry-card cw-inquiry-error">' +
                        '<div class="cw-inquiry-title"><i class="fas fa-times-circle"></i>Verification Failed</div>' +
                        '<div class="cw-inquiry-grid">' +
                            '<div><div class="cw-inquiry-field-label">Bank</div><div class="cw-inquiry-field-val">' + errBank + '</div></div>' +
                            '<div><div class="cw-inquiry-field-label">Account No.</div><div class="cw-inquiry-field-val">' + errAcc + '</div></div>' +
                            '<div><div class="cw-inquiry-field-label">Status</div><div class="cw-inquiry-field-val text-danger">' + errStatus + '</div></div>' +
                            '<div style="grid-column:1/-1"><div class="cw-inquiry-field-label">Reason</div><div class="cw-inquiry-field-val">' + errMsg + '</div></div>' +
                        '</div>' +
                    '</div>';
            } else {
                document.getElementById('account_holder').value = data.account_holder;
                feeHidden.value      = data.fee;
                feeDisplay.innerHTML = '<span class="fw-bold text-brand fs-6">Rp ' + parseInt(data.fee).toLocaleString('id-ID') + '</span>';
                currentFee = parseInt(data.fee) || 0;
                updateBreakdown();

                var bankName   = data.bank_name || (bankCodeEl.options[bankCodeEl.selectedIndex] ? bankCodeEl.options[bankCodeEl.selectedIndex].text : bankCode);
                var accountNum = data.account_number || accountNo;

                inquiryMsg.innerHTML =
                    '<div class="cw-inquiry-card cw-inquiry-success">' +
                        '<div class="cw-inquiry-title"><i class="fas fa-check-circle"></i>Account Verified</div>' +
                        '<div class="cw-inquiry-grid">' +
                            '<div><div class="cw-inquiry-field-label">Bank</div><div class="cw-inquiry-field-val">' + bankName + '</div></div>' +
                            '<div><div class="cw-inquiry-field-label">Account No.</div><div class="cw-inquiry-field-val">' + accountNum + '</div></div>' +
                            '<div><div class="cw-inquiry-field-label">Account Holder</div><div class="cw-inquiry-field-val">' + data.account_holder + '</div></div>' +
                            '<div><div class="cw-inquiry-field-label">Transfer Fee</div><div class="cw-inquiry-field-val">Rp ' + parseInt(data.fee).toLocaleString('id-ID') + '</div></div>' +
                        '</div>' +
                    '</div>';
            }
        })
        .catch(function () {
            inquiryMsg.innerHTML = '<div class="alert alert-danger py-2 mb-0"><i class="fas fa-times-circle me-1"></i>Failed to reach Amdigipay - Bisatopup. Please try again.</div>';
        })
        .finally(function () {
            btnVerify.disabled = false;
            btnVerify.innerHTML = '<i class="fas fa-check-circle me-1"></i> Verify';
        });
    });

    function rejectSubmit(e, message, scrollTarget) {
        e.preventDefault(); e.stopPropagation();
        var warnBox = document.getElementById('amount-warning');
        var warnMsg = document.getElementById('amount-warning-msg');
        if (warnBox && warnMsg && message) {
            warnMsg.innerHTML     = '<i class="fas fa-exclamation-triangle me-1"></i>' + message;
            warnBox.style.display = 'block';
        }
        if (scrollTarget) scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    document.getElementById('withdrawal-form').addEventListener('submit', function (e) {
        if (!document.getElementById('account_holder').value) {
            e.preventDefault(); e.stopPropagation();
            inquiryMsg.innerHTML = '<div class="alert alert-warning py-2 mb-0"><i class="fas fa-exclamation-triangle me-1"></i>Please verify the destination account before continuing.</div>';
            accountNoEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        var rawAmt = amountEl ? parseInt(amountEl.value.replace(/\./g, '')) || 0 : 0;
        var net    = rawAmt - currentFee;

        if (rawAmt > available) { rejectSubmit(e, 'Amount exceeds available balance (' + fmt(available) + ').', amountEl); return; }
        if (currentFee > 0 && net <= 0) { rejectSubmit(e, 'Amount must be greater than the transfer fee (' + fmt(currentFee) + ').', amountEl); return; }
        if (currentFee > 0 && net < 10000) { rejectSubmit(e, 'Recipient amount (' + fmt(net) + ') is below the minimum transfer of Rp 10.000.', amountEl); return; }

        if (amountEl) amountEl.value = amountEl.value.replace(/\./g, '');
    });
})();
</script>
@endsection
