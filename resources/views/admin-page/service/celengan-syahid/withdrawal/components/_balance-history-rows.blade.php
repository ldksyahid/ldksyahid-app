@forelse($items as $entry)
@php
    $isCredit  = $entry['amount'] >= 0;
    $absAmount = abs($entry['amount']);
    $balAfter  = $entry['balance_after'];
    $balBefore = $balAfter - $entry['amount'];
    $detail    = json_encode($entry['details'], JSON_UNESCAPED_UNICODE);
@endphp
<tr class="bh-row {{ $isCredit ? 'bh-row-credit' : 'bh-row-debit' }}">
    <td class="ps-3">
        <span class="bh-type-badge {{ $isCredit ? 'bh-badge-payment' : 'bh-badge-disbursement' }}">
            <i class="fas {{ $isCredit ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
            {{ $entry['type'] === 'PAYMENT' ? 'Payment' : 'Transfer' }}
        </span>
    </td>
    <td>
        <div class="fw-semibold small" style="font-size:.82rem">
            {{ $entry['date'] ? \Carbon\Carbon::parse($entry['date'])->format('d M Y') : '—' }}
        </div>
        <div class="text-muted" style="font-size:.72rem">
            {{ $entry['date'] ? \Carbon\Carbon::parse($entry['date'])->format('H:i') : '' }}
        </div>
    </td>
    <td class="small">
        <div class="bh-campaign-name">{{ $entry['campaign'] }}</div>
        <div class="bh-reference">{{ $entry['reference'] }}</div>
    </td>
    <td class="text-end">
        <span class="bh-amount-pill {{ $isCredit ? 'bh-pill-amount-credit' : 'bh-pill-amount-debit' }}">
            {{ $isCredit ? '+' : '−' }} Rp {{ number_format($absAmount, 0, ',', '.') }}
        </span>
    </td>
    <td class="text-end">
        <span class="bh-balance-after">Rp {{ number_format($balAfter, 0, ',', '.') }}</span>
    </td>
    <td class="text-center pe-3">
        <button type="button" class="btn btn-custom-primary btn-sm bh-view-btn"
            style="border-radius:6px;padding:.25rem .55rem;font-size:.75rem"
            data-type="{{ $entry['type'] }}"
            data-detail='{{ $detail }}'>
            <i class="fas fa-eye"></i>
        </button>
    </td>
</tr>
@empty
<tr>
    <td colspan="6">
        <div class="text-center py-5 text-muted">
            <i class="fas fa-history fa-2x mb-2 d-block opacity-50"></i>
            <div>No balance history found.</div>
        </div>
    </td>
</tr>
@endforelse
