@extends('admin-page.template.body')

@section('styles')
@include('admin-page.security.two-factor.components._setup-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Header --}}
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="page-title mb-0">
                        <i class="fas fa-users-cog me-2"></i>2FA Users
                    </h1>
                    <p class="text-muted mb-0 mt-1 small">Manage Two-Factor Authentication status for all users</p>
                </div>
                <a href="{{ route('admin.security.2fa') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px">
                    <i class="fas fa-arrow-left me-1"></i> My 2FA Setup
                </a>
            </div>
        </div>

        {{-- Stat cards --}}
        @php
            $totalUsers  = $users->total();
            $activeUsers = $users->getCollection()->where('google2fa_enabled', true)->count();
        @endphp
        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-total"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="tfa-stat-label">Total Users</div>
                            <div class="tfa-stat-value">{{ $users->total() }}</div>
                            <div class="tfa-stat-sub">in this page & beyond</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-active"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <div class="tfa-stat-label">2FA Active</div>
                            <div class="tfa-stat-value">{{ $activeUsers }}</div>
                            <div class="tfa-stat-sub">on this page</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-pending"><i class="fas fa-user-times"></i></div>
                        <div>
                            <div class="tfa-stat-label">2FA Inactive</div>
                            <div class="tfa-stat-value">{{ $users->count() - $activeUsers }}</div>
                            <div class="tfa-stat-sub">on this page</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="col-12 mb-4">
            <div class="tfa-table-card">
                <div class="d-flex justify-content-between align-items-center px-4 pt-3 pb-2 flex-wrap gap-2">
                    <span class="fw-semibold" style="font-size:.9rem; color:#495057">
                        <i class="fas fa-list me-1 text-muted"></i>User List
                    </span>
                    <small class="text-muted">{{ $users->total() }} user(s) found</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover tfa-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:42px" class="ps-4">#</th>
                                <th style="min-width:160px">Name</th>
                                <th style="min-width:180px">Email</th>
                                <th class="text-center" style="min-width:120px">2FA Status</th>
                                <th class="text-center" style="min-width:130px">Enabled Since</th>
                                <th class="text-center" style="min-width:150px">Last Verified</th>
                                <th class="text-center" style="min-width:120px">Last IP</th>
                                <th class="text-center" style="width:80px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                        <span class="tfa-badge-active">
                                            <i class="fas fa-shield-alt"></i> Active
                                        </span>
                                    @else
                                        <span class="tfa-badge-inactive">
                                            <i class="fas fa-times-circle"></i> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($u->two_fa_enabled_at)
                                        <div class="small fw-semibold">{{ $u->two_fa_enabled_at->format('d M Y') }}</div>
                                        <div style="font-size:.72rem; color:#9ca3af">{{ $u->two_fa_enabled_at->format('H:i') }}</div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($u->two_fa_last_used_at)
                                        <div class="small fw-semibold">{{ $u->two_fa_last_used_at->format('d M Y') }}</div>
                                        <div style="font-size:.72rem; color:#9ca3af">{{ $u->two_fa_last_used_at->format('H:i') }}</div>
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
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px; font-size:.75rem">
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
                        </tbody>
                    </table>
                </div>

                {{-- Flat Pagination --}}
                <div class="tfa-table-pagination" id="tfa-pagination-bar">
                    <span class="text-muted small" id="tfa-pg-info">
                        @if($users->total() > 0)
                            Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
                        @endif
                    </span>
                    <div class="d-flex align-items-center gap-1" id="tfa-pg-controls"></div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    var curPage  = {{ $users->currentPage() }};
    var lastPage = {{ $users->lastPage() }};
    var baseUrl  = '{{ route("admin.security.2fa.users") }}';

    function pageWindows(cur, last) {
        var show = {}, arr = [];
        [1, last].forEach(function (p) { if (p >= 1 && p <= last) show[p] = true; });
        for (var p = Math.max(1, cur - 2); p <= Math.min(last, cur + 2); p++) show[p] = true;
        var prev = 0;
        Object.keys(show).map(Number).sort(function (a, b) { return a - b; }).forEach(function (p) {
            if (prev && p - prev > 1) arr.push(null);
            arr.push(p); prev = p;
        });
        return arr;
    }

    function renderPagination() {
        var $ctrl = document.getElementById('tfa-pg-controls');
        if (!$ctrl || lastPage <= 1) return;
        $ctrl.innerHTML = '';

        function makeBtn(label, href, disabled, active, isIcon) {
            var el = document.createElement(href ? 'a' : 'button');
            el.className = 'btn btn-sm btn-outline-secondary tfa-pg-btn' + (active ? ' active' : '');
            if (href && !disabled) el.href = href;
            if (disabled) el.disabled = true;
            el.innerHTML = label;
            return el;
        }

        $ctrl.appendChild(makeBtn('<i class="fas fa-chevron-left"></i>',
            curPage > 1 ? baseUrl + '?page=' + (curPage - 1) : null,
            curPage <= 1, false, true));

        pageWindows(curPage, lastPage).forEach(function (p) {
            if (p === null) {
                var ell = document.createElement('span');
                ell.className = 'tfa-pg-ellipsis'; ell.textContent = '…';
                $ctrl.appendChild(ell);
            } else {
                $ctrl.appendChild(makeBtn(p, p !== curPage ? baseUrl + '?page=' + p : null, false, p === curPage));
            }
        });

        $ctrl.appendChild(makeBtn('<i class="fas fa-chevron-right"></i>',
            curPage < lastPage ? baseUrl + '?page=' + (curPage + 1) : null,
            curPage >= lastPage, false, true));
    }

    renderPagination();
})();
</script>
@endsection
