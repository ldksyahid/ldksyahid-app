@forelse($users as $i => $u)
<tr>
    <td class="ps-4 text-muted small">{{ $users->firstItem() + $i }}</td>
    <td>
        <div class="fw-semibold" style="font-size:.875rem">{{ $u->name }}</div>
        @if($u->id === auth()->id())
            <span style="font-size:.68rem;font-weight:700;color:#00a79d;text-transform:uppercase;letter-spacing:.04em">You</span>
        @endif
    </td>
    <td class="small text-muted">{{ $u->email }}</td>
    <td class="text-center">
        @if($u->google2fa_enabled)
            <span class="tfa-badge-active"><i class="fas fa-shield-alt"></i> Active</span>
        @else
            <span class="tfa-badge-inactive"><i class="fas fa-times-circle"></i> Inactive</span>
        @endif
    </td>
    <td class="text-center">
        @if($u->two_fa_enabled_at)
            <div class="small fw-semibold">{{ $u->two_fa_enabled_at->format('d M Y') }}</div>
            <div style="font-size:.72rem;color:#9ca3af">{{ $u->two_fa_enabled_at->format('H:i') }}</div>
        @else
            <span class="text-muted">—</span>
        @endif
    </td>
    <td class="text-center">
        @if($u->two_fa_last_used_at)
            <div class="small fw-semibold">{{ $u->two_fa_last_used_at->format('d M Y') }}</div>
            <div style="font-size:.72rem;color:#9ca3af">{{ $u->two_fa_last_used_at->format('H:i') }}</div>
        @else
            <span class="text-muted">—</span>
        @endif
    </td>
    <td class="text-center">
        @if($u->two_fa_last_used_ip)
            <code class="small">{{ $u->two_fa_last_used_ip }}</code>
        @else
            <span class="text-muted">—</span>
        @endif
    </td>
    <td class="text-center">
        @if($u->google2fa_enabled && $u->id !== auth()->id())
            <form action="{{ route('admin.security.2fa.revoke', $u->id) }}" method="POST"
                  onsubmit="return confirm('Force-revoke 2FA for {{ addslashes($u->name) }}?')">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px;font-size:.75rem">
                    <i class="fas fa-lock-open me-1"></i>Revoke
                </button>
            </form>
        @else
            <span class="text-muted small">—</span>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="8">
        <div class="text-center py-5 text-muted">
            <i class="fas fa-users fa-2x mb-2 d-block opacity-50"></i>
            No users found.
        </div>
    </td>
</tr>
@endforelse
