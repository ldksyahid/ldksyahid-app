@forelse($withdrawals as $i => $wd)
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
        default     => 'fa-circle',
    };
@endphp
<tr class="{{ $wd->status === 'FAILED' ? 'wd-row-failed' : '' }}">
    <td class="text-muted small">{{ $withdrawals->firstItem() + $i }}</td>
    <td>
        <div class="fw-semibold small">{{ optional($wd->created_at)->format('d M Y') }}</div>
        <div class="text-muted" style="font-size:.72rem">{{ optional($wd->created_at)->format('H:i') }}</div>
    </td>
    <td><span class="wd-bank-chip">{{ strtoupper($wd->bank_code) }}</span></td>
    <td><span class="wd-account">{{ $wd->account_number }}</span></td>
    <td class="fw-semibold small">{{ $wd->account_holder ?: '—' }}</td>
    <td class="text-end">
        <span class="wd-amount">Rp {{ number_format($wd->amount, 0, ',', '.') }}</span>
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
@empty
<tr>
    <td colspan="8">
        <div class="text-center py-5 text-muted">
            <i class="fas fa-money-bill-transfer fa-2x mb-2 d-block opacity-50"></i>
            <div>No withdrawals found for this campaign.</div>
        </div>
    </td>
</tr>
@endforelse
