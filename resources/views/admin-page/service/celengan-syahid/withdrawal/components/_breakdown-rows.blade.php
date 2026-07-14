@forelse($rows as $i => $row)
@php $netPositive = $row['net'] >= 0; @endphp
<tr>
    <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
    <td>
        <span class="fw-semibold" style="font-size:.875rem">{{ $row['campaign'] }}</span>
        @if(($row['pending_count'] ?? 0) > 0)
            <div class="mt-1">
                <span class="br-settling-inline">
                    <i class="fas fa-clock"></i>
                    +Rp {{ number_format($row['pending_wallet'], 0, ',', '.') }}
                    ({{ $row['pending_count'] }} txn settling…)
                </span>
            </div>
        @endif
    </td>
    <td class="text-end text-muted small">Rp {{ number_format($row['total_qris'], 0, ',', '.') }}</td>
    <td class="text-end small">Rp {{ number_format($row['wallet_credit'], 0, ',', '.') }}</td>
    <td class="text-center"><span class="br-txn-badge">{{ $row['txn_count'] }}</span></td>
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
