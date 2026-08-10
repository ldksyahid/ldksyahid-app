@php
    use Illuminate\Support\Str;

    $badgeClass = function ($action) {
        if (Str::contains($action, ['create', 'draft', 'store'])) return 'badge-create';
        if (Str::contains($action, ['update', 'edit', 'execute', 'verify'])) return 'badge-update';
        if (Str::contains($action, ['delete', 'remove', 'failed', 'fail'])) return 'badge-delete';
        return 'badge-other';
    };

    $offset = ($logs->currentPage() - 1) * $logs->perPage();
@endphp

@forelse($logs as $log)
<tr>
    <td class="text-muted small text-center" style="width:36px">{{ $offset + $loop->iteration }}</td>
    <td class="text-nowrap">
        <div class="fw-semibold small">{{ optional($log->created_at)->format('d M Y') }}</div>
        <div style="font-size:.72rem; color:#9ca3af">{{ optional($log->created_at)->format('H:i:s') }}</div>
    </td>
    <td>
        <div class="fw-semibold small">{{ optional($log->user)->name ?? 'System' }}</div>
    </td>
    <td>
        <span class="badge-status {{ $badgeClass($log->action) }}">
            <span class="status-dot"></span>{{ $log->action }}
        </span>
    </td>
    <td>
        @if($log->entity_type)
            <span class="badge-entity">{{ ucfirst($log->entity_type) }}</span>
            @if($log->entity_id)
                <div class="entity-id">{{ Str::limit($log->entity_id, 14) }}</div>
            @endif
        @else
            <span class="text-muted small">—</span>
        @endif
    </td>
    <td style="max-width:280px">
        <span class="small" title="{{ $log->description }}">{{ $log->description ?: '—' }}</span>
    </td>
    <td class="text-nowrap">
        <span class="small text-muted font-monospace">{{ $log->ip_address ?: '—' }}</span>
    </td>
</tr>
@empty
<tr>
    <td colspan="7">
        <div class="audit-empty">
            <i class="fas fa-history"></i>
            No audit records {{ request()->hasAny(['action_type', 'entity_type', 'search']) ? 'match your filters' : 'yet' }}.
        </div>
    </td>
</tr>
@endforelse
