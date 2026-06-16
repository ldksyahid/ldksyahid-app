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

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('admin.celsyahid.campaign.finance', $withdrawal->campaign_id) }}"
               class="btn btn-danger">
                <i class="fas fa-times me-1"></i> Cancel
            </a>
            <form action="{{ route('admin.celsyahid.withdrawal.execute', $withdrawal->id) }}" method="POST" id="execute-form">
                @csrf
                <button type="submit" class="btn btn-custom-primary" id="btn-execute">
                    <i class="fas fa-check me-1"></i> Yes, Execute Now
                </button>
            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('execute-form').addEventListener('submit', function () {
    var btn = document.getElementById('btn-execute');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Processing...';
    }
});
</script>
@endsection
