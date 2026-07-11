@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.withdrawal.components._balance-report-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Header --}}
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 br-page-header">
                <div>
                    <h1 class="br-page-title mb-0">
                        <i class="fas fa-balance-scale me-2"></i>Balance Report
                    </h1>
                    <p class="text-muted mb-0 mt-1 small">Bisatopup wallet vs. internal DB — QRIS transactions only</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.celsyahid.withdrawal.index') }}" class="btn btn-sm btn-outline-secondary btn-rounded">
                        <i class="fas fa-arrow-left me-1"></i>Withdrawals
                    </a>
                    <a href="{{ route('admin.celsyahid.balance.report') }}" class="btn btn-sm btn-outline-secondary btn-rounded">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </a>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="col-12 mb-4">
            <div class="row g-3">
                {{-- Actual Balance --}}
                <div class="col-md-4">
                    <div class="br-stat-card">
                        <div class="br-stat-icon br-icon-actual"><i class="fas fa-building-columns"></i></div>
                        <div class="br-stat-info">
                            <div class="br-stat-label">Actual Balance</div>
                            <div class="br-stat-value">
                                @if($actualBalance !== null)
                                    Rp {{ number_format($actualBalance, 0, ',', '.') }}
                                @else
                                    <span class="text-muted small fw-normal">Unable to fetch</span>
                                @endif
                            </div>
                            <div class="br-stat-sub">Bisatopup API</div>
                        </div>
                    </div>
                </div>

                {{-- Expected Balance --}}
                <div class="col-md-4">
                    <div class="br-stat-card">
                        <div class="br-stat-icon br-icon-expected"><i class="fas fa-database"></i></div>
                        <div class="br-stat-info">
                            <div class="br-stat-label">Expected Balance</div>
                            <div class="br-stat-value">Rp {{ number_format($totalExpected, 0, ',', '.') }}</div>
                            <div class="br-stat-sub">Calculated from DB</div>
                        </div>
                    </div>
                </div>

                {{-- Discrepancy --}}
                <div class="col-md-4">
                    <div class="br-stat-card">
                        <div class="br-stat-icon {{ $discrepancy === null ? 'br-icon-neutral' : ($discrepancy < 0 ? 'br-icon-deficit' : ($isNormal ? 'br-icon-normal' : 'br-icon-warning')) }}">
                            <i class="fas {{ $discrepancy === null ? 'fa-question' : ($discrepancy < 0 ? 'fa-exclamation-circle' : ($isNormal ? 'fa-check-circle' : 'fa-exclamation-triangle')) }}"></i>
                        </div>
                        <div class="br-stat-info">
                            <div class="br-stat-label">Discrepancy</div>
                            <div class="br-stat-value">
                                @if($discrepancy !== null)
                                    @if($discrepancy < 0)
                                        <span class="text-danger">− Rp {{ number_format(abs($discrepancy), 0, ',', '.') }}</span>
                                    @else
                                        <span class="{{ $isNormal ? 'text-success' : 'text-warning' }}">
                                            + Rp {{ number_format($discrepancy, 0, ',', '.') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted small fw-normal">N/A</span>
                                @endif
                            </div>
                            <div class="br-stat-sub">
                                @if($discrepancy === null) —
                                @elseif($discrepancy < 0) Deficit
                                @elseif($isNormal) Normal (≤ Rp {{ number_format($threshold, 0, ',', '.') }})
                                @else Needs Review
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Discrepancy Explanation --}}
        <div class="col-12 mb-4">
            <div class="br-explain-card">
                <div class="br-explain-header">
                    <i class="fas fa-info-circle me-2"></i>Why might there be a discrepancy?
                </div>
                <div class="br-explain-body">
                    <ul class="mb-3">
                        <li>Bisatopup transaction fee (~Rp 10/txn) deducted and recorded in the <code>biaya_admin</code> column.</li>
                        <li>Donations with <code>PAID</code> status but not yet settled to the wallet (T+1 / T+2).</li>
                        <li>Minor rounding differences from the Bisatopup system.</li>
                    </ul>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="discrepancy-badge discrepancy-normal">
                            <i class="fas fa-check-circle"></i> Normal — gap ≤ Rp {{ number_format($threshold, 0, ',', '.') }}
                        </span>
                        <span class="discrepancy-badge discrepancy-warning">
                            <i class="fas fa-exclamation-triangle"></i> Needs Review — gap > threshold
                        </span>
                        <span class="discrepancy-badge discrepancy-deficit">
                            <i class="fas fa-exclamation-circle"></i> Deficit — actual &lt; expected
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Breakdown Table --}}
        <div class="col-12 mb-4">
            <div class="wi-table-card">
                {{-- Card header --}}
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-3 flex-wrap gap-2">
                    <span class="fw-semibold" style="font-size:.95rem; color:#495057">
                        <i class="fas fa-table me-2 text-muted"></i>Breakdown per Campaign
                        <span class="br-qris-badge ms-2">QRIS only</span>
                    </span>
                    <small class="text-muted">Last updated: {{ now()->format('d M Y, H:i') }}</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover wi-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:42px" class="ps-4">#</th>
                                <th>Campaign</th>
                                <th class="text-end" style="min-width:140px">QRIS PAID<br><span class="fw-normal text-muted" style="font-size:.72rem">(Gross)</span></th>
                                <th class="text-end" style="min-width:130px">After MDR<br><span class="fw-normal text-muted" style="font-size:.72rem">(1%)</span></th>
                                <th class="text-center" style="width:60px">Txn</th>
                                <th class="text-end" style="min-width:120px">Withdrawn</th>
                                <th class="text-end" style="min-width:130px">Net Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $i => $row)
                            @php $netPositive = $row['net'] >= 0; @endphp
                            <tr>
                                <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
                                <td>
                                    <span class="fw-semibold" style="font-size:.875rem">{{ $row['campaign'] }}</span>
                                </td>
                                <td class="text-end text-muted small">Rp {{ number_format($row['total_qris'], 0, ',', '.') }}</td>
                                <td class="text-end small">Rp {{ number_format($row['wallet_credit'], 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="br-txn-badge">{{ $row['txn_count'] }}</span>
                                </td>
                                <td class="text-end">
                                    @if($row['total_withdrawn'] > 0)
                                        <span class="br-withdrawn">Rp {{ number_format($row['total_withdrawn'], 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="br-net {{ $netPositive ? 'br-net-positive' : 'br-net-negative' }}">
                                        Rp {{ number_format($row['net'], 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                        No QRIS transactions found.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($rows->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="6" class="ps-4 text-end br-tfoot-label">Total Expected Balance</td>
                                <td class="text-end br-tfoot-value">Rp {{ number_format($totalExpected, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Footer info --}}
                <div class="br-table-footer">
                    <span class="text-muted small">
                        <i class="fas fa-circle-info me-1"></i>
                        MDR = Merchant Discount Rate charged by Bisatopup on each QRIS transaction. Withdrawn = COMPLETED withdrawals only.
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
