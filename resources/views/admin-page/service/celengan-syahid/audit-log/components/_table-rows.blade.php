@php
    use Illuminate\Support\Str;

    $badgeClass = function ($action) {
        if (Str::contains($action, 'create')) return 'badge-create';
        if (Str::contains($action, 'update')) return 'badge-update';
        if (Str::contains($action, 'delete')) return 'badge-delete';
        return 'badge-other';
    };
@endphp

@forelse($logs as $log)
<tr>
    <td class="text-nowrap">{{ optional($log->created_at)->isoFormat('D MMM YYYY, HH:mm') }}</td>
    <td>{{ optional($log->user)->name ?? 'System' }}</td>
    <td>
        <span class="badge-status {{ $badgeClass($log->action) }}">
            <span class="status-dot"></span>{{ $log->action }}
        </span>
    </td>
    <td>
        @if($log->entity_type)
            <span class="badge-entity">{{ ucfirst($log->entity_type) }}</span>
            @if($log->entity_id)
                <div class="entity-id">{{ Str::limit($log->entity_id, 12) }}</div>
            @endif
        @else
            <span class="text-muted">-</span>
        @endif
    </td>
    <td>{{ $log->description ?: '-' }}</td>
    <td class="text-nowrap">{{ $log->ip_address ?: '-' }}</td>
</tr>
@empty
<tr>
    <td colspan="6">
        <div class="audit-empty">
            <i class="fas fa-history"></i>
            No audit records {{ request()->hasAny(['action_type', 'entity_type', 'search']) ? 'match your filters' : 'yet' }}.
        </div>
    </td>
</tr>
@endforelse
