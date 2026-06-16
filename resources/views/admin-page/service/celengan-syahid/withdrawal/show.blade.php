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
                <i class="fas fa-eye me-2"></i>
                <span>Withdrawal</span>
                <span class="highlighted-text ms-1">Detail</span>
                <small>{{ $withdrawal->reff_id }}</small>
            </h1>
        </div>

        {{-- Status badge card --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="text-muted small">Withdrawal Amount</div>
                        <div class="fs-4 fw-bold" class="text-brand">
                            Rp {{ number_format($withdrawal->amount, 0, ',', '.') }}
                        </div>
                    </div>
                    <span class="badge fs-6 px-3 py-2 {{ \App\Models\Withdrawal::statusBadgeClass($withdrawal->status) }}">
                        {{ $withdrawal->status }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Card 1: Withdrawal Information --}}
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-file-invoice-dollar me-2"></i>Withdrawal Information
                    </h5>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Reference ID</label>
                            <div class="form-control-plaintext"><code>{{ $withdrawal->reff_id }}</code></div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Campaign</label>
                            <div class="form-control-plaintext">
                                @if($withdrawal->campaign)
                                <a href="{{ route('admin.celsyahid.campaign.finance', $withdrawal->campaign_id) }}">
                                    {{ $withdrawal->campaign->judul }}
                                </a>
                                @else —
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Destination Bank</label>
                            <div class="form-control-plaintext fw-semibold">{{ strtoupper($withdrawal->bank_code) }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Account Number</label>
                            <div class="form-control-plaintext">{{ $withdrawal->account_number }}</div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Account Holder</label>
                            <div class="form-control-plaintext fw-semibold">{{ $withdrawal->account_holder ?: '—' }}</div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <label class="form-label fw-bold">Withdrawal Amount</label>
                            <div class="form-control-plaintext fw-bold" class="text-brand">
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
                            <div class="form-control-plaintext fw-bold text-success fs-5">
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

        {{-- Card 2: Status & Timeline --}}
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-circle-info me-2"></i>Transfer Status
                    </h5>

                    <div class="text-center mb-4">
                        <span class="badge fs-5 px-4 py-3 {{ \App\Models\Withdrawal::statusBadgeClass($withdrawal->status) }}">
                            {{ $withdrawal->status }}
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Created By</label>
                            <div class="form-control-plaintext">
                                {{ $withdrawal->creator->name ?? '—' }}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Created At</label>
                            <div class="form-control-plaintext">
                                {{ optional($withdrawal->created_at)->isoFormat('D MMM YYYY, HH:mm') ?: '—' }}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Executed At</label>
                            <div class="form-control-plaintext">
                                {{ optional($withdrawal->executed_at)->isoFormat('D MMM YYYY, HH:mm') ?: '—' }}
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Completed At</label>
                            <div class="form-control-plaintext">
                                {{ optional($withdrawal->completed_at)->isoFormat('D MMM YYYY, HH:mm') ?: '—' }}
                            </div>
                        </div>
                        @if($withdrawal->receipt_url)
                        <div class="col-12">
                            <a href="{{ $withdrawal->receipt_url }}" target="_blank" rel="noopener"
                               class="btn btn-custom-primary btn-sm">
                                <i class="fas fa-receipt me-1"></i> View Receipt
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('admin.celsyahid.withdrawal.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Withdrawal List
            </a>
            @if($withdrawal->campaign)
            <a href="{{ route('admin.celsyahid.campaign.finance', $withdrawal->campaign_id) }}"
               class="btn btn-outline-secondary">
                <i class="fas fa-wallet me-1"></i> Campaign Finance
            </a>
            @endif
        </div>

    </div>
</div>
@endsection
