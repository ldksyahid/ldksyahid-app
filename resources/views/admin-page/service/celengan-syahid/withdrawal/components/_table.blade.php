@if($items->count() > 0)
<div class="table-responsive">
    <table class="table table-hover wi-table align-middle mb-0">
        <thead>
            <tr>
                <th style="width:36px">#</th>
                <th style="min-width:100px">Date</th>
                <th style="min-width:180px">Campaign</th>
                <th>Bank / Account</th>
                <th>Recipient</th>
                <th class="text-end" style="min-width:110px">Amount</th>
                <th class="text-end" style="min-width:80px">Fee</th>
                <th class="text-center" style="min-width:110px">Status</th>
                <th class="text-center" style="width:60px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $i => $wd)
            @php
                $statusClass = match($wd->status) {
                    'COMPLETED' => 'wd-status-COMPLETED',
                    'PENDING'   => 'wd-status-PENDING',
                    'FAILED'    => 'wd-status-FAILED',
                    default     => 'wd-status-default',
                };
                $statusIcon = match($wd->status) {
                    'COMPLETED' => 'fa-check-circle',
                    'PENDING'   => 'fa-clock',
                    'FAILED'    => 'fa-times-circle',
                    default     => 'fa-file-pen',
                };
            @endphp
            <tr>
                <td class="text-muted small">{{ $items->firstItem() + $i }}</td>
                <td>
                    <div class="fw-semibold small">{{ optional($wd->created_at)->format('d M Y') }}</div>
                    <div class="text-muted" style="font-size:.72rem">{{ optional($wd->created_at)->format('H:i') }}</div>
                </td>
                <td>
                    @if($wd->campaign)
                    <a href="{{ route('admin.celsyahid.campaign.finance', $wd->campaign_id) }}"
                       class="wi-campaign-link" title="{{ $wd->campaign->judul }}">
                        {{ $wd->campaign->judul }}
                    </a>
                    @else
                    <span class="text-muted small">—</span>
                    @endif
                </td>
                <td>
                    <span class="wd-bank-chip">{{ strtoupper($wd->bank_code) }}</span>
                    <div class="wd-account mt-1">{{ $wd->account_number }}</div>
                </td>
                <td class="fw-semibold small">{{ $wd->account_holder ?: '—' }}</td>
                <td class="text-end">
                    <span class="wd-amount">Rp {{ number_format($wd->amount, 0, ',', '.') }}</span>
                </td>
                <td class="text-end">
                    <span class="text-muted small">Rp {{ number_format($wd->fee, 0, ',', '.') }}</span>
                </td>
                <td class="text-center">
                    <span class="wd-badge {{ $statusClass }}">
                        <i class="fas {{ $statusIcon }}"></i>
                        {{ $wd->status }}
                    </span>
                </td>
                <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.celsyahid.withdrawal.show', $wd->id) }}"
                           class="btn btn-custom-primary" title="View Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($wd->status === 'DRAFT' && \App\Helpers\TwoFaHelper::isAllowed(auth()->user()))
                        <a href="{{ route('admin.celsyahid.withdrawal.confirm', $wd->id) }}"
                           class="btn btn-custom-primary" title="Continue to Confirm">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-5 text-muted">
    <i class="fas fa-money-bill-transfer fa-2x mb-2 d-block opacity-50"></i>
    <div>No withdrawal records found.</div>
    <small>Try adjusting your filters.</small>
</div>
@endif
