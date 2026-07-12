@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.campaign.components._finance._finance-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-wallet me-2"></i>
                <span>Campaign</span>
                <span class="highlighted-text ms-1">Finance</span>
                <small>{{ $campaign->judul }}</small>
            </h1>
        </div>

        {{-- Card 1: Amdigipay - Bisatopup Account Balance --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-building-columns me-2"></i>Amdigipay - Bisatopup Account Balance
                        <small class="text-muted fw-normal fs-6 ms-2">(All Campaigns)</small>
                    </h5>
                    <div class="bisabiller-badge d-inline-block">
                        <div class="small mb-1 opacity-75">Current Balance</div>
                        <div class="fw-bold fs-4" id="bisabiller-balance-value">
                            @if($bisabillerBalance !== null)
                                Rp {{ number_format($bisabillerBalance, 0, ',', '.') }}
                            @else
                                <span class="opacity-75 fs-6">Unable to fetch balance</span>
                            @endif
                        </div>
                        <div class="small mt-1 opacity-75">
                            Auto-refreshed · Last updated: <span id="bisabiller-balance-refreshed">{{ now()->format('H:i') }}</span>
                        </div>
                    </div>
                    @if($bisabillerBalance !== null)
                    @php
                        $dbExp = \App\Models\Donation::where('gateway','bisatopup')->where('payment_status','PAID')->sum('jumlah_donasi')
                            - \App\Models\Withdrawal::where('status','COMPLETED')->sum('amount');
                        $disc2 = $bisabillerBalance - $dbExp;
                        $discT2 = config('services.two_fa.discrepancy_threshold', 50000);
                    @endphp
                    <div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
                        @if($disc2 < 0)
                            <span class="badge bg-danger">
                                <i class="fas fa-exclamation-circle me-1"></i>Deficit Rp {{ number_format(abs($disc2), 0, ',', '.') }}
                            </span>
                        @elseif(abs($disc2) <= $discT2)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Balance Normal
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-exclamation-triangle me-1"></i>Gap Rp {{ number_format(abs($disc2), 0, ',', '.') }} — Needs Review
                            </span>
                        @endif
                        <a href="{{ route('admin.celsyahid.balance.report') }}" class="btn-balance-report">
                            <i class="fas fa-balance-scale me-1"></i> Balance Report
                        </a>
                    </div>
                    @endif
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-circle-info me-1"></i>
                            This is the total balance across all campaigns in the Amdigipay - Bisatopup account.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Fund Summary --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-chart-pie me-2"></i>Fund Summary
                    </h5>

                    <div class="row">
                        {{-- Online / Amdigipay --}}
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded finance-box-online">
                                <div class="fw-semibold mb-3 finance-box-online-title">
                                    <i class="fas fa-qrcode me-1"></i> Online Payments (via Amdigipay - Bisatopup)
                                </div>

                                <div class="row mb-2">
                                    <div class="col-7"><label class="form-label fw-bold mb-0">Total Collected (PAID)</label></div>
                                    <div class="col-5 text-end">
                                        <span class="stat-value">Rp {{ number_format($balance['qris_paid'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-7"><label class="form-label fw-bold mb-0">Total Withdrawn</label></div>
                                    <div class="col-5 text-end">
                                        <span class="text-warning fw-semibold">Rp {{ number_format($balance['total_withdrawn'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @if($balance['pending_withdrawal'] > 0)
                                <div class="row mb-2">
                                    <div class="col-7"><label class="form-label fw-bold mb-0">Pending Withdrawal</label></div>
                                    <div class="col-5 text-end">
                                        <span class="text-secondary fw-semibold">Rp {{ number_format($balance['pending_withdrawal'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                @endif

                                <div class="balance-divider"></div>

                                <div class="row align-items-center">
                                    <div class="col-7"><label class="form-label fw-bold mb-0">Available to Withdraw</label></div>
                                    <div class="col-5 text-end">
                                        <span class="stat-value available">Rp {{ number_format($balance['available'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Non-Amdigipay --}}
                        <div class="col-md-6 mb-3">
                            <div class="p-3 rounded h-100 finance-box-offline">
                                <div class="fw-semibold mb-3 finance-box-offline-title">
                                    <i class="fas fa-money-bill-wave me-1"></i> Non-Amdigipay - Bisatopup (Cash, Transfer, etc.)
                                </div>

                                <div class="row mb-2">
                                    <div class="col-7"><label class="form-label fw-bold mb-0">Total Collected (PAID)</label></div>
                                    <div class="col-5 text-end">
                                        <span class="fw-semibold text-secondary">Rp {{ number_format($balance['manual_paid'], 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="balance-divider balance-divider-muted"></div>

                                <small class="text-muted">
                                    <i class="fas fa-circle-info me-1"></i>
                                    Donations received outside Amdigipay - Bisatopup (cash, manual transfer, etc.) — not withdrawable via this system.
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Total all methods --}}
                    <div class="border-top pt-3 mt-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-muted">Total All Methods (PAID)</span>
                            <span class="fw-bold fs-5" class="text-brand">Rp {{ number_format($balance['total_paid'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Withdrawal History --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-clock-rotate-left me-2"></i>Withdrawal History
                        <small class="text-muted fw-normal fs-6 ms-2">(This Campaign)</small>
                    </h5>

                    <div class="table-responsive">
                        <table class="table wd-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width:36px">#</th>
                                    <th>Date</th>
                                    <th>Bank</th>
                                    <th>Account No.</th>
                                    <th>Recipient</th>
                                    <th class="text-end" style="min-width:120px">Amount</th>
                                    <th class="text-center" style="min-width:110px">Status</th>
                                    <th class="text-center" style="width:60px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="finance-wd-tbody">
                                @include('admin-page.service.celengan-syahid.campaign.components._finance._withdrawal-rows', compact('withdrawals'))
                            </tbody>
                        </table>
                    </div>

                    {{-- Flat AJAX pagination --}}
                    <div class="wi-table-pagination mt-0 border-top" id="finance-wd-pagination" style="border-radius:0">
                        <span class="text-muted small" id="finance-wd-pg-info">
                            @if($withdrawals->total() > 0)
                                Showing {{ $withdrawals->firstItem() }}–{{ $withdrawals->lastItem() }} of {{ $withdrawals->total() }} records
                            @endif
                        </span>
                        <div class="d-flex align-items-center gap-1" id="finance-wd-pg-controls"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-between align-items-center gap-2 mb-4 flex-wrap">
            <a href="{{ route('admin.service.index.celsyahid.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Campaigns
            </a>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.celsyahid.withdrawal.index', ['campaign_id' => $campaign->id]) }}"
                   class="btn btn-outline-secondary">
                    <i class="fas fa-list me-1"></i> All Withdrawals
                </a>
                @role('Superadmin')
                @if($balance['available'] > 0)
                <a href="{{ route('admin.celsyahid.withdrawal.create', ['campaign_id' => $campaign->id]) }}"
                   class="btn btn-custom-primary">
                    <i class="fas fa-money-bill-transfer me-1"></i> Withdraw Funds
                </a>
                @else
                <button class="btn btn-custom-primary" disabled title="No funds available to withdraw">
                    <i class="fas fa-money-bill-transfer me-1"></i> Withdraw Funds
                </button>
                @endif
                @endrole
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
@include('admin-page.service.celengan-syahid.campaign.components._finance._finance-scripts')
@endsection
