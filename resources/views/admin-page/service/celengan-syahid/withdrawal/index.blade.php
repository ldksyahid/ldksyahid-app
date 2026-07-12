@extends('admin-page.template.body')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
@include('admin-page.service.celengan-syahid.withdrawal.components._withdrawal-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-money-bill-transfer me-2"></i>
                <span>Withdrawal</span>
                <span class="highlighted-text ms-1">History</span>
            </h1>
        </div>

        {{-- Balance Card --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-building-columns me-2"></i>Amdigipay - Bisatopup Account Balance
                    </h5>
                    @if($bisabillerBalance !== null)
                    @php
                        $mdrRIdx       = (float) config('services.bisatopup.qris_mdr_percent', 1) / 100;
                        $dbExpected    = (int) \App\Models\Donation::where('gateway','bisatopup')
                                            ->where('payment_status','PAID')
                                            ->selectRaw('SUM(COALESCE(total_tagihan, jumlah_donasi + biaya_admin) - CEIL(COALESCE(total_tagihan, jumlah_donasi + biaya_admin) * ?)) as wc', [$mdrRIdx])
                                            ->value('wc')
                                       - (int) \App\Models\Withdrawal::where('status','COMPLETED')->sum('amount');
                        $disc          = $bisabillerBalance - $dbExpected;
                        $discThreshold = config('services.two_fa.discrepancy_threshold', 50000);
                    @endphp
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="fs-4 fw-bold text-brand">
                            Rp {{ number_format($bisabillerBalance, 0, ',', '.') }}
                        </div>
                        <small class="text-muted">Total across all campaigns</small>
                        @if($disc < 0)
                            <span class="badge bg-danger"><i class="fas fa-exclamation-circle me-1"></i>Deficit Rp {{ number_format(abs($disc), 0, ',', '.') }}</span>
                        @elseif(abs($disc) <= $discThreshold)
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Balance Normal</span>
                        @else
                            <span class="badge bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i>Gap Rp {{ number_format(abs($disc), 0, ',', '.') }} — Needs Review</span>
                        @endif
                        <a href="{{ route('admin.celsyahid.balance.report') }}" class="btn-balance-report">
                            <i class="fas fa-balance-scale me-1"></i> Balance Report
                        </a>
                    </div>
                    @else
                    <span class="text-muted"><i class="fas fa-circle-exclamation me-1"></i>Unable to fetch balance from Amdigipay - Bisatopup.</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Flat Filter Bar --}}
        <div class="col-12 mb-3">
            <div class="wi-flat-filter">
                <div style="min-width:220px; flex:1">
                    <select id="filter-campaign" class="form-select form-select-sm">
                        <option value="">All Campaigns</option>
                        @foreach($campaigns as $id => $judul)
                        <option value="{{ $id }}">{{ $judul }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="min-width:150px">
                    <select id="filter-status" class="form-select form-select-sm">
                        <option value="">All Status</option>
                        @foreach(['DRAFT','PENDING','COMPLETED','FAILED'] as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="active-filter-chips" class="d-flex gap-1 flex-wrap"></div>
                <div class="ms-auto">
                    <button id="btn-clear-filter" class="wi-clear-btn" title="Clear all filters">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="col-12 mb-4">
            <div class="wi-table-card">
                <div class="d-flex justify-content-between align-items-center px-3 pt-3 pb-2 flex-wrap gap-2">
                    <span class="fw-semibold" style="color:#495057; font-size:.9rem">
                        <i class="fas fa-list-ul me-1 text-muted"></i>Withdrawal List
                    </span>
                    <small class="text-muted" id="wi-result-info"></small>
                </div>

                <div id="withdrawal-table-wrap">
                    @include('admin-page.service.celengan-syahid.withdrawal.components._table', compact('items'))
                </div>

                <div class="wi-table-pagination" id="wi-pagination-bar">
                    <span class="text-muted small" id="wi-pg-info">
                        @if($items->total() > 0)
                            Showing {{ $items->firstItem() }}–{{ $items->lastItem() }} of {{ $items->total() }} records
                        @endif
                    </span>
                    <div class="d-flex align-items-center gap-2" id="wi-pg-controls"></div>
                </div>
            </div>
        </div>

        {{-- Action bar --}}
        <div class="col-12 d-flex justify-content-end gap-2 mb-4">
            @role('Superadmin')
            <a href="{{ route('admin.celsyahid.withdrawal.create') }}" class="btn btn-custom-primary">
                <i class="fas fa-plus me-1"></i> New Withdrawal
            </a>
            @endrole
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    var AJAX_URL   = '{{ route("admin.celsyahid.withdrawal.index") }}';
    var curPage    = {{ $items->currentPage() }};
    var lastPage   = {{ $items->lastPage() }};

    // Select2
    $('#filter-campaign').select2({ placeholder: 'All Campaigns', allowClear: true, width: '100%', dropdownParent: $('body') });
    $('#filter-status').select2({
        placeholder: 'All Status', allowClear: true, width: '100%', dropdownParent: $('body'),
        templateResult: function (s) {
            if (!s.id) return s.text;
            var cols = { COMPLETED: '#198754', PENDING: '#856404', FAILED: '#b02a37', DRAFT: '#495057' };
            return $('<span style="color:' + (cols[s.id] || '#495057') + '; font-weight:700">' + s.text + '</span>');
        }
    });

    function updateChips() {
        var $chips = $('#active-filter-chips').empty();
        var campVal = $('#filter-campaign').val();
        var statVal = $('#filter-status').val();
        if (campVal) {
            var campText = $('#filter-campaign option:selected').text();
            $chips.append('<span class="wi-filter-chip"><i class="fas fa-flag"></i>' + campText + '</span>');
        }
        if (statVal) {
            $chips.append('<span class="wi-filter-chip"><i class="fas fa-circle-half-stroke"></i>' + statVal + '</span>');
        }
    }

    function pageWindows(cur, last) {
        var show = {}, arr = [];
        [1, last].forEach(function (p) { if (p >= 1 && p <= last) show[p] = true; });
        for (var p = Math.max(1, cur - 2); p <= Math.min(last, cur + 2); p++) show[p] = true;
        var prev = 0;
        Object.keys(show).map(Number).sort(function (a, b) { return a - b; }).forEach(function (p) {
            if (prev && p - prev > 1) arr.push(null);
            arr.push(p);
            prev = p;
        });
        return arr;
    }

    function renderPagination(meta) {
        $('#wi-pg-info').text(
            meta.total > 0
                ? 'Showing ' + meta.from + '–' + meta.to + ' of ' + meta.total + ' records'
                : 'No records found'
        );
        curPage  = meta.current_page;
        lastPage = meta.last_page;

        var $ctrl = $('#wi-pg-controls').empty();
        if (lastPage <= 1) return;

        var $prev = $('<button class="btn btn-sm btn-outline-secondary wi-pg-btn"><i class="fas fa-chevron-left"></i></button>');
        if (curPage <= 1) $prev.prop('disabled', true);
        else $prev.on('click', function () { loadTable(curPage - 1); });
        $ctrl.append($prev);

        pageWindows(curPage, lastPage).forEach(function (p) {
            if (p === null) {
                $ctrl.append('<span class="wi-pg-ellipsis">…</span>');
            } else {
                var $btn = $('<button class="btn btn-sm btn-outline-secondary wi-pg-btn' + (p === curPage ? ' active' : '') + '">' + p + '</button>');
                if (p !== curPage) { var pg = p; $btn.on('click', function () { loadTable(pg); }); }
                $ctrl.append($btn);
            }
        });

        var $next = $('<button class="btn btn-sm btn-outline-secondary wi-pg-btn"><i class="fas fa-chevron-right"></i></button>');
        if (curPage >= lastPage) $next.prop('disabled', true);
        else $next.on('click', function () { loadTable(curPage + 1); });
        $ctrl.append($next);
    }

    function loadTable(page) {
        var params = {
            campaign_id: $('#filter-campaign').val() || '',
            status:      $('#filter-status').val()   || '',
            page:        page || 1,
        };
        $('#withdrawal-table-wrap').addClass('wi-loading');

        $.ajax({
            url: AJAX_URL, data: params,
            success: function (res) {
                $('#withdrawal-table-wrap').html(res.tableHtml).removeClass('wi-loading');
                $('#wi-result-info').text(res.total > 0 ? res.total + ' record(s)' : '');
                updateChips();
                renderPagination(res);
                $('html, body').animate({ scrollTop: $('#withdrawal-table-wrap').offset().top - 100 }, 200);
            },
            error: function () { $('#withdrawal-table-wrap').removeClass('wi-loading'); }
        });
    }

    $('#btn-clear-filter').on('click', function () {
        $('#filter-campaign').val(null).trigger('change');
        $('#filter-status').val(null).trigger('change');
        loadTable(1);
    });

    $('#filter-campaign, #filter-status').on('change', function () { loadTable(1); });

    // Init
    updateChips();
    renderPagination({
        from:         {{ $items->firstItem() ?? 0 }},
        to:           {{ $items->lastItem() ?? 0 }},
        total:        {{ $items->total() }},
        current_page: {{ $items->currentPage() }},
        last_page:    {{ $items->lastPage() }},
    });
});
</script>
@endsection
