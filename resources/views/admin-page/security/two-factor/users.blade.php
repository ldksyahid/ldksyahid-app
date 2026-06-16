@extends('admin-page.template.body')

@section('styles')
@include('admin-page.security.two-factor.components._setup-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-users-cog me-2"></i>
                <span>2FA</span>
                <span class="highlighted-text ms-1">Users</span>
                <small>Manage Two-Factor Authentication status for all users</small>
            </h1>
        </div>

        {{-- Back link --}}
        <div class="col-12 mb-3">
            <a href="{{ route('admin.security.2fa') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to My 2FA Setup
            </a>
        </div>

        {{-- Table --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-center">2FA Status</th>
                                    <th class="text-center">Enabled Since</th>
                                    <th class="text-center">Last Verified</th>
                                    <th class="text-center">Last IP</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $u)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-semibold">{{ $u->name }}</td>
                                    <td class="text-muted small">{{ $u->email }}</td>
                                    <td class="text-center">
                                        @if($u->google2fa_enabled)
                                            <span class="badge bg-success"><i class="fas fa-user-shield me-1"></i>Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center small text-muted">
                                        {{ $u->two_fa_enabled_at ? $u->two_fa_enabled_at->format('d M Y') : '—' }}
                                    </td>
                                    <td class="text-center small text-muted">
                                        {{ $u->two_fa_last_used_at ? $u->two_fa_last_used_at->format('d M Y H:i') : '—' }}
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
                                                  onsubmit="return confirm('Force-revoke 2FA for {{ addslashes($u->name) }}? They must set up 2FA again.')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-lock-open me-1"></i>Revoke
                                                </button>
                                            </form>
                                        @elseif($u->id === auth()->id())
                                            <small class="text-muted">You</small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No users found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
