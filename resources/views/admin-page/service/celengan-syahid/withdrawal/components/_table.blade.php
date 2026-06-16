@if($items->count() > 0)
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Date</th>
                <th>Campaign</th>
                <th>Bank / Account</th>
                <th>Recipient Name</th>
                <th class="text-end">Amount</th>
                <th class="text-end">Fee</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $wd)
            <tr>
                <td>{{ optional($wd->created_at)->format('d M Y') }}</td>
                <td>
                    @if($wd->campaign)
                    <a href="{{ route('admin.celsyahid.campaign.finance', $wd->campaign_id) }}">
                        {{ $wd->campaign->judul }}
                    </a>
                    @else —
                    @endif
                </td>
                <td>
                    <span class="fw-semibold">{{ strtoupper($wd->bank_code) }}</span>
                    <br><small class="text-muted">{{ $wd->account_number }}</small>
                </td>
                <td>{{ $wd->account_holder ?: '—' }}</td>
                <td class="text-end fw-semibold">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                <td class="text-end text-muted">Rp {{ number_format($wd->fee, 0, ',', '.') }}</td>
                <td class="text-center">
                    <span class="badge {{ \App\Models\Withdrawal::statusBadgeClass($wd->status) }}">
                        {{ $wd->status }}
                    </span>
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.celsyahid.withdrawal.show', $wd->id) }}"
                       class="btn btn-sm btn-custom-primary" title="View Detail">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="text-center py-4 text-muted">
    <i class="fas fa-money-bill-transfer fa-2x mb-2 d-block"></i>
    No withdrawal records found.
</div>
@endif
