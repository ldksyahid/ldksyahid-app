@extends('admin-page.template.body')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@include('admin-page.service.celengan-syahid.withdrawal.components._withdrawal-styles')
<style>
    #amount::-webkit-inner-spin-button,
    #amount::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    #amount { -moz-appearance: textfield; }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-plus-circle me-2"></i>
                <span>Create</span>
                <span class="highlighted-text ms-1">Withdrawal</span>
                @if($campaign)
                <small>Campaign: {{ $campaign->judul }}</small>
                @endif
            </h1>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
        <div class="col-12 mb-3">
            <div class="alert alert-danger alert-dismissible fade show">
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
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-hand-holding-heart me-2"></i>Select Campaign</h5>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Campaign <span class="text-danger">*</span></label>
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
            </div>
            @else
            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
            @endif

            @if($campaign && $balance)

            {{-- Card 1: Balance Summary --}}
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-wallet me-2"></i>Balance Summary</h5>
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <label class="form-label fw-bold">Available to Withdraw</label>
                                <div class="balance-highlight">Rp {{ number_format($balance['available'], 0, ',', '.') }}</div>
                                <small class="text-muted">(Online payments via Amdigipay - Bisatopup only)</small>
                            </div>
                            @if($balance['pending_withdrawal'] > 0)
                            <div class="col-sm-6 mb-2">
                                <label class="form-label fw-bold">Pending Withdrawal</label>
                                <div class="form-control-plaintext text-warning fw-semibold">
                                    Rp {{ number_format($balance['pending_withdrawal'], 0, ',', '.') }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Destination Account --}}
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-building me-2"></i>Destination Account</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
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
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Account Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="account_number" name="account_number"
                                           class="form-control @error('account_number') is-invalid @enderror"
                                           value="{{ old('account_number') }}"
                                           placeholder="e.g. 1234567890" required>
                                    <button type="button" id="btn-verify" class="btn btn-verify-account">
                                        <i class="fas fa-circle-check me-1"></i> Verify
                                    </button>
                                    @error('account_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Account Holder</label>
                                <div id="inquiry-result" class="inquiry-result">
                                    <input type="text" id="account_holder_display" class="form-control" readonly
                                           placeholder="— Verify account first —"
                                           value="{{ old('account_holder') }}">
                                </div>
                            </div>
                        </div>
                        {{-- Hidden fields filled by AJAX --}}
                        <input type="hidden" name="account_holder" id="account_holder" value="{{ old('account_holder') }}">
                        <input type="hidden" name="fee" id="fee" value="{{ old('fee', 0) }}">
                        <input type="hidden" name="recipient_city_code" id="recipient_city_code" value="{{ old('recipient_city_code') }}">
                        <div id="inquiry-msg" class="mt-2"></div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Withdrawal Details --}}
            <div class="col-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-file-invoice me-2"></i>Withdrawal Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Withdrawal Amount <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" inputmode="numeric" name="amount" id="amount"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           value="{{ old('amount') ? number_format((int) old('amount'), 0, ',', '.') : '' }}"
                                           data-max="{{ $balance['available'] }}"
                                           placeholder="Min. 10.000" required autocomplete="off">
                                    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <small class="text-muted">Maximum: Rp {{ number_format($balance['available'], 0, ',', '.') }}</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Transfer Fee</label>
                                <div class="form-control-plaintext" id="fee-display">
                                    <span class="text-muted">— Verify account to see fee —</span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold">Remark <small class="text-muted fw-normal">(optional — appears on recipient's bank statement)</small></label>
                                <input type="text" name="remark" class="form-control @error('remark') is-invalid @enderror"
                                       value="{{ old('remark') }}" maxlength="100"
                                       placeholder="e.g. Fund withdrawal - Campaign Name">
                                @error('remark')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif {{-- end if $campaign && $balance --}}

            {{-- Action bar --}}
            <div class="col-12 d-flex justify-content-end gap-2 mb-4">
                @if($campaign)
                <a href="{{ route('admin.celsyahid.campaign.finance', $campaign->id) }}" class="btn btn-danger">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
                @else
                <a href="{{ route('admin.celsyahid.withdrawal.index') }}" class="btn btn-danger">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
                @endif
                @if($campaign && $balance)
                <button type="submit" class="btn btn-custom-primary" id="btn-submit">
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
    // Campaign dropdown (when no campaign pre-selected)
    $('select[name="campaign_id"]').each(function () {
        $(this).select2({
            placeholder: '— Select a campaign —',
            allowClear: false,
            width: '100%',
            dropdownParent: $('body'),
        });
    });

    // Bank dropdown
    $('#bank_code').select2({
        placeholder: '— Select bank —',
        allowClear: false,
        width: '100%',
        dropdownParent: $('body'),
        minimumResultsForSearch: 5,
    });
});
</script>
<script>
(function () {
    var btnVerify    = document.getElementById('btn-verify');
    var bankCodeEl   = document.getElementById('bank_code');
    var accountNoEl  = document.getElementById('account_number');
    var holderHidden = document.getElementById('account_holder');
    var holderInput  = document.getElementById('account_holder_display');
    var feeHidden    = document.getElementById('fee');
    var feeDisplay   = document.getElementById('fee-display');
    var inquiryMsg   = document.getElementById('inquiry-msg');
    var amountEl     = document.getElementById('amount');
    var btnSubmit    = document.getElementById('btn-submit');

    /* ── Amount: format with dots, strip before submit ─────── */
    function formatRibu(val) {
        var digits = val.replace(/[^\d]/g, '');
        return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    if (amountEl) {
        amountEl.addEventListener('input', function () {
            var raw    = this.value.replace(/[^\d]/g, '');
            var cursor = this.selectionStart;
            var oldLen = this.value.length;
            this.value = raw ? formatRibu(raw) : '';
            var newLen = this.value.length;
            this.setSelectionRange(cursor + (newLen - oldLen), cursor + (newLen - oldLen));
        });
    }

    if (!btnVerify) return;

    /* ── Inquiry / Verify ───────────────────────────────────── */
    btnVerify.addEventListener('click', function () {
        var bankCode  = bankCodeEl ? bankCodeEl.value : '';
        var accountNo = accountNoEl ? accountNoEl.value.trim() : '';

        if (!bankCode || !accountNo) {
            inquiryMsg.innerHTML = '<div class="alert alert-warning py-2">Please select a bank and enter an account number first.</div>';
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
                holderInput.value  = '';
                holderHidden.value = '';
                feeHidden.value    = '0';
                feeDisplay.innerHTML = '<span class="text-muted">—</span>';

                var errBankName   = data.bank_name || (bankCodeEl.options[bankCodeEl.selectedIndex] ? bankCodeEl.options[bankCodeEl.selectedIndex].text : bankCode);
                var errAccountNum = data.account_number || accountNo;
                var errStatus     = data.status ? data.status.replace(/_/g, ' ') : 'FAILED';
                var errMessage    = data.message || 'Account not found or verification failed.';

                inquiryMsg.innerHTML =
                    '<div class="alert alert-danger py-0 pt-2 pb-3">' +
                        '<div class="mb-2"><i class="fas fa-times-circle me-1"></i><strong>Verification Failed</strong></div>' +
                        '<div class="row g-2" style="font-size:.85rem">' +
                            '<div class="col-sm-4">' +
                                '<div class="text-muted small">Bank</div>' +
                                '<div class="fw-semibold">' + errBankName + '</div>' +
                            '</div>' +
                            '<div class="col-sm-4">' +
                                '<div class="text-muted small">Account Number</div>' +
                                '<div class="fw-semibold">' + errAccountNum + '</div>' +
                            '</div>' +
                            '<div class="col-sm-4">' +
                                '<div class="text-muted small">Status</div>' +
                                '<div class="fw-semibold text-danger">' + errStatus + '</div>' +
                            '</div>' +
                            '<div class="col-12 mt-1">' +
                                '<div class="text-muted small">Reason</div>' +
                                '<div class="fw-semibold">' + errMessage + '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            } else {
                holderInput.value  = data.account_holder;
                holderHidden.value = data.account_holder;
                feeHidden.value    = data.fee;
                feeDisplay.innerHTML = '<span class="fw-semibold">Rp ' + parseInt(data.fee).toLocaleString('id-ID') + '</span>';

                var bankName   = data.bank_name || (bankCodeEl.options[bankCodeEl.selectedIndex] ? bankCodeEl.options[bankCodeEl.selectedIndex].text : bankCode);
                var accountNum = data.account_number || accountNo;

                inquiryMsg.innerHTML =
                    '<div class="alert alert-success py-0 pt-2 pb-3">' +
                        '<div class="mb-2"><i class="fas fa-check-circle me-1"></i><strong>Account Verified Successfully</strong></div>' +
                        '<div class="row g-2" style="font-size:.85rem">' +
                            '<div class="col-sm-4">' +
                                '<div class="text-muted small">Bank</div>' +
                                '<div class="fw-semibold">' + bankName + '</div>' +
                            '</div>' +
                            '<div class="col-sm-4">' +
                                '<div class="text-muted small">Account Number</div>' +
                                '<div class="fw-semibold">' + accountNum + '</div>' +
                            '</div>' +
                            '<div class="col-sm-4">' +
                                '<div class="text-muted small">Account Holder</div>' +
                                '<div class="fw-semibold">' + data.account_holder + '</div>' +
                            '</div>' +
                            '<div class="col-sm-4 mt-1">' +
                                '<div class="text-muted small">Transfer Fee</div>' +
                                '<div class="fw-semibold">Rp ' + parseInt(data.fee).toLocaleString('id-ID') + '</div>' +
                            '</div>' +
                        '</div>' +
                    '</div>';
            }
        })
        .catch(function () {
            inquiryMsg.innerHTML = '<div class="alert alert-danger py-2">Failed to reach Amdigipay - Bisatopup. Please try again.</div>';
        })
        .finally(function () {
            btnVerify.disabled = false;
            btnVerify.innerHTML = '<i class="fas fa-search me-1"></i> Verify';
        });
    });

    /* ── Submit: strip dots from amount before POST ─────────── */
    document.getElementById('withdrawal-form').addEventListener('submit', function (e) {
        if (!holderHidden.value) {
            e.preventDefault();
            inquiryMsg.innerHTML = '<div class="alert alert-warning py-2">Please verify the destination account before continuing.</div>';
            accountNoEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }
        if (amountEl) {
            amountEl.value = amountEl.value.replace(/\./g, '');
        }
    });
})();
</script>
@endsection
