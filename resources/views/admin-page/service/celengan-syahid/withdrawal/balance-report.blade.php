@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.withdrawal.components._balance-report-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-balance-scale me-2"></i>
                <span>Balance</span>
                <span class="highlighted-text ms-1">Report</span>
                <small>Bisatopup wallet vs. internal DB — QRIS only</small>
            </h1>
        </div>

        {{-- Card 1: Summary --}}
        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-chart-bar me-2"></i>Summary
                    </h5>

                    <div class="summary-row">
                        <span class="summary-label">Actual Balance (Bisatopup API)</span>
                        <span class="summary-value">
                            @if($actualBalance !== null)
                                Rp {{ number_format($actualBalance, 0, ',', '.') }}
                            @else
                                <span class="text-muted small">Unable to fetch</span>
                            @endif
                        </span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Expected Balance (from DB)</span>
                        <span class="summary-value">Rp {{ number_format($totalExpected, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Discrepancy</span>
                        <span>
                            @if($discrepancy !== null)
                                @if($discrepancy < 0)
                                    <span class="discrepancy-badge discrepancy-deficit">
                                        <i class="fas fa-exclamation-circle"></i>
                                        Deficit: Rp {{ number_format(abs($discrepancy), 0, ',', '.') }}
                                    </span>
                                @elseif($isNormal)
                                    <span class="discrepancy-badge discrepancy-normal">
                                        <i class="fas fa-check-circle"></i>
                                        + Rp {{ number_format($discrepancy, 0, ',', '.') }} — Normal
                                    </span>
                                @else
                                    <span class="discrepancy-badge discrepancy-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        + Rp {{ number_format($discrepancy, 0, ',', '.') }} — Needs Review
                                    </span>
                                @endif
                            @else
                                <span class="text-muted small">N/A</span>
                            @endif
                        </span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Last Updated</span>
                        <span class="summary-value small text-muted">{{ now()->format('H:i') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Discrepancy Threshold</span>
                        <span class="summary-value small text-muted">Rp {{ number_format($threshold, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Explanation --}}
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-info-circle me-2"></i>Discrepancy Explained
                    </h5>
                    <p class="text-muted small mb-2">A small gap between actual and expected balance is normal and may be caused by:</p>
                    <ul class="text-muted small mb-3">
                        <li>Bisatopup transaction fee (~Rp 10/txn) deducted and recorded in the <code>biaya_admin</code> column.</li>
                        <li>Donations with <code>PAID</code> status but not yet settled to the wallet (T+1 / T+2).</li>
                        <li>Minor rounding differences from the Bisatopup system.</li>
                    </ul>
                    <div class="d-flex gap-3 flex-wrap">
                        <span class="discrepancy-badge discrepancy-normal" style="font-size:.8rem;">
                            <i class="fas fa-check-circle"></i> Normal — gap ≤ Rp {{ number_format($threshold, 0, ',', '.') }}
                        </span>
                        <span class="discrepancy-badge discrepancy-warning" style="font-size:.8rem;">
                            <i class="fas fa-exclamation-triangle"></i> Needs Review — gap > threshold
                        </span>
                        <span class="discrepancy-badge discrepancy-deficit" style="font-size:.8rem;">
                            <i class="fas fa-exclamation-circle"></i> Deficit — actual balance is less than expected
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 2: Breakdown per Campaign --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="px-4 pt-4 pb-2">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-table me-2"></i>Breakdown per Campaign (QRIS only)
                        </h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Campaign</th>
                                    <th class="text-end">QRIS PAID</th>
                                    <th class="text-end">Fee Bisatopup</th>
                                    <th class="text-center">Txn</th>
                                    <th class="text-end">Withdrawn</th>
                                    <th class="text-end">Net Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rows as $i => $row)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                                    <td class="fw-semibold">{{ $row['campaign'] }}</td>
                                    <td class="text-end">Rp {{ number_format($row['total_qris'], 0, ',', '.') }}</td>
                                    <td class="text-end text-muted small">
                                        @if($row['total_fee'] > 0)
                                            − Rp {{ number_format($row['total_fee'], 0, ',', '.') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="text-center text-muted small">{{ $row['txn_count'] }}</td>
                                    <td class="text-end text-warning fw-semibold">
                                        @if($row['total_withdrawn'] > 0)
                                            Rp {{ number_format($row['total_withdrawn'], 0, ',', '.') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="text-end fw-bold text-brand">
                                        Rp {{ number_format($row['net'], 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No QRIS transactions found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="6" class="ps-4 fw-bold text-end">Total Expected</td>
                                    <td class="text-end fw-bold fs-6 text-brand">
                                        Rp {{ number_format($totalExpected, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
