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
                    <i class="fas fa-wrench me-1"></i> My 2FA Setup
                </a>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-total"><i class="fas fa-users"></i></div>
                        <div>
                            <div class="tfa-stat-label">Total Users</div>
                            <div class="tfa-stat-value" id="stat-total">{{ $users->total() }}</div>
                            <div class="tfa-stat-sub">registered</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-active"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <div class="tfa-stat-label">2FA Active</div>
                            <div class="tfa-stat-value" id="stat-active">{{ $activeCount }}</div>
                            <div class="tfa-stat-sub">all users</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="tfa-stat-card">
                        <div class="tfa-stat-icon tfa-icon-pending"><i class="fas fa-user-times"></i></div>
                        <div>
                            <div class="tfa-stat-label">2FA Inactive</div>
                            <div class="tfa-stat-value" id="stat-inactive">{{ $inactiveCount }}</div>
                            <div class="tfa-stat-sub">all users</div>
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
                    <small class="text-muted" id="tfa-found-count">{{ $users->total() }} user(s) found</small>
                </div>

                {{-- Search & Filter Bar --}}
                <div class="tfa-search-bar d-flex align-items-center gap-2 flex-wrap">
                    <div class="tfa-search-group" style="max-width:300px;flex:1 1 200px">
                        <span class="tfa-search-icon"><i class="fas fa-search"></i></span>
                        <input type="text" id="tfa-search" class="tfa-search-input"
                               placeholder="Search name or email…">
                        <button type="button" id="tfa-search-clear" class="tfa-search-clear" style="display:none" title="Clear">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <input type="hidden" id="tfa-status-filter" value="">
                    <div class="tfa-custom-select" id="tfa-status-dropdown">
                        <button type="button" class="tfa-custom-select-btn" id="tfa-status-btn">
                            <span class="tfa-select-label" id="tfa-status-label">All Status</span>
                            <i class="fas fa-chevron-down tfa-select-arrow"></i>
                        </button>
                        <div class="tfa-custom-select-menu" id="tfa-status-menu">
                            <div class="tfa-custom-select-item selected" data-value="">
                                <span class="tfa-status-dot all"></span>All Status
                            </div>
                            <div class="tfa-custom-select-item" data-value="active">
                                <span class="tfa-status-dot active"></span>Active
                            </div>
                            <div class="tfa-custom-select-item" data-value="inactive">
                                <span class="tfa-status-dot inactive"></span>Inactive
                            </div>
                        </div>
                    </div>
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
                                <th class="text-center" style="width:90px">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tfa-tbody">
                            @include('admin-page.security.two-factor.components._users-table')
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
$(function () {
    var AJAX_URL  = '{{ route("admin.security.2fa.users") }}';
    var CSRF      = '{{ csrf_token() }}';
    var curPage   = {{ $users->currentPage() }};
    var lastPage  = {{ $users->lastPage() }};
    var searchTimer;

    function getFilters() {
        return {
            search: $.trim($('#tfa-search').val()),
            status: $('#tfa-status-filter').val(),
        };
    }

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

    function renderPagination(meta) {
        curPage  = meta.current_page;
        lastPage = meta.last_page;

        $('#tfa-pg-info').text(
            meta.total > 0
                ? 'Showing ' + meta.from + '–' + meta.to + ' of ' + meta.total + ' users'
                : 'No users found'
        );
        $('#tfa-found-count').text(meta.total + ' user(s) found');

        var $ctrl = $('#tfa-pg-controls').empty();
        if (lastPage <= 1) return;

        var $prev = $('<button class="btn btn-sm btn-outline-secondary tfa-pg-btn"><i class="fas fa-chevron-left"></i></button>');
        if (curPage <= 1) $prev.prop('disabled', true);
        else $prev.on('click', function () { loadPage(curPage - 1); });
        $ctrl.append($prev);

        pageWindows(curPage, lastPage).forEach(function (p) {
            if (p === null) {
                $ctrl.append('<span class="tfa-pg-ellipsis">…</span>');
            } else {
                var $btn = $('<button class="btn btn-sm btn-outline-secondary tfa-pg-btn' + (p === curPage ? ' active' : '') + '">' + p + '</button>');
                if (p !== curPage) { (function(pg){ $btn.on('click', function(){ loadPage(pg); }); })(p); }
                $ctrl.append($btn);
            }
        });

        var $next = $('<button class="btn btn-sm btn-outline-secondary tfa-pg-btn"><i class="fas fa-chevron-right"></i></button>');
        if (curPage >= lastPage) $next.prop('disabled', true);
        else $next.on('click', function () { loadPage(curPage + 1); });
        $ctrl.append($next);
    }

    function loadPage(page) {
        $('#tfa-tbody').css('opacity', .45);

        $.ajax({
            url:      AJAX_URL,
            data:     $.extend({ page: page }, getFilters()),
            headers:  { 'X-Requested-With': 'XMLHttpRequest' },
            dataType: 'json',
        }).done(function (res) {
            $('#tfa-tbody').html(res.tableBody).css('opacity', 1);
            $('#stat-active').text(res.active_count);
            $('#stat-inactive').text(res.inactive_count);
            renderPagination(res);
            $('html,body').animate({ scrollTop: $('#tfa-tbody').closest('.tfa-table-card').offset().top - 100 }, 200);
        }).fail(function () {
            $('#tfa-tbody').css('opacity', 1);
        });
    }

    // Search with 350ms debounce
    $('#tfa-search').on('input', function () {
        var val = $(this).val();
        $('#tfa-search-clear').toggle(val.length > 0);
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { loadPage(1); }, 350);
    });

    // Clear button
    $('#tfa-search-clear').on('click', function () {
        $('#tfa-search').val('');
        $(this).hide();
        loadPage(1);
    });

    // Custom status dropdown
    var $statusDropdown = $('#tfa-status-dropdown');
    var $statusFilter   = $('#tfa-status-filter');

    $('#tfa-status-btn').on('click', function (e) {
        e.stopPropagation();
        $statusDropdown.toggleClass('open');
    });

    $(document).on('click', '.tfa-custom-select-item', function () {
        var val   = $(this).data('value');
        var label = $(this).text().trim();
        $('.tfa-custom-select-item').removeClass('selected');
        $(this).addClass('selected');
        $('#tfa-status-label').text(label);
        $statusFilter.val(val);
        $statusDropdown.removeClass('open');
        loadPage(1);
    });

    // Close dropdown on outside click
    $(document).on('click', function (e) {
        if (!$statusDropdown.is(e.target) && $statusDropdown.has(e.target).length === 0) {
            $statusDropdown.removeClass('open');
        }
    });

    // Revoke 2FA via AJAX with SweetAlert2 confirmation
    $(document).on('click', '.btn-revoke-2fa', function () {
        var url  = $(this).data('url');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Force Revoke 2FA?',
            html:  'This will disable 2FA for <strong>' + name + '</strong>.<br>They will need to set it up again.',
            icon:  'warning',
            showCancelButton:   true,
            confirmButtonColor: '#d33',
            cancelButtonColor:  '#6c757d',
            confirmButtonText:  '<i class="fas fa-lock-open me-1"></i> Yes, Revoke!',
            cancelButtonText:   'Cancel',
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url:      url,
                type:     'POST',
                data:     { _token: CSRF },
                headers:  { 'X-Requested-With': 'XMLHttpRequest' },
                dataType: 'json',
            }).done(function (res) {
                Swal.fire({
                    icon:              'success',
                    title:             'Revoked!',
                    text:              res.message,
                    timer:             2000,
                    showConfirmButton: false,
                }).then(function () {
                    loadPage(curPage);
                });
            }).fail(function () {
                Swal.fire({
                    icon:  'error',
                    title: 'Error',
                    text:  'Something went wrong. Please try again.',
                });
            });
        });
    });

    // Init pagination on page load
    renderPagination({
        from:         {{ $users->firstItem() ?? 0 }},
        to:           {{ $users->lastItem() ?? 0 }},
        total:        {{ $users->total() }},
        current_page: {{ $users->currentPage() }},
        last_page:    {{ $users->lastPage() }},
    });
});
</script>
@endsection
