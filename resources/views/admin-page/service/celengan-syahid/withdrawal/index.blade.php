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
                        $dbExpected    = \App\Models\Donation::where('gateway','bisatopup')->where('payment_status','PAID')->sum('jumlah_donasi')
                                       - \App\Models\Withdrawal::where('status','COMPLETED')->sum('amount');
                        $disc          = $bisabillerBalance - $dbExpected;
                        $discThreshold = config('services.two_fa.discrepancy_threshold', 50000);
                    @endphp
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="fs-4 fw-bold text-brand">
                            Rp {{ number_format($bisabillerBalance, 0, ',', '.') }}
                        </div>
                        <small class="text-muted">Total across all campaigns</small>
                        @if($disc < 0)
                            <span class="badge bg-danger">
                                <i class="fas fa-exclamation-circle me-1"></i>Deficit Rp {{ number_format(abs($disc), 0, ',', '.') }}
                            </span>
                        @elseif(abs($disc) <= $discThreshold)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Balance Normal
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-exclamation-triangle me-1"></i>Gap Rp {{ number_format(abs($disc), 0, ',', '.') }} — Needs Review
                            </span>
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

        {{-- Filters --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm wi-filter-card">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                        <span class="fw-semibold" style="color:#00a79d; font-size:.9rem">
                            <i class="fas fa-filter me-1"></i>Filters
                        </span>
                        <button id="btn-clear-filter" class="wi-clear-btn" title="Clear all filters">
                            <i class="fas fa-times"></i> Clear filters
                        </button>
                    </div>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-1" style="font-size:.78rem; color:#6b7280; text-transform:uppercase; letter-spacing:.04em">Campaign</label>
                            <select id="filter-campaign" class="form-select form-select-sm">
                                <option value="">All Campaigns</option>
                                @foreach($campaigns as $id => $judul)
                                <option value="{{ $id }}">{{ $judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold mb-1" style="font-size:.78rem; color:#6b7280; text-transform:uppercase; letter-spacing:.04em">Status</label>
                            <select id="filter-status" class="form-select form-select-sm">
                                <option value="">All Status</option>
                                @foreach(['DRAFT','PENDING','COMPLETED','FAILED'] as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div id="active-filter-chips" class="d-flex gap-1 flex-wrap pb-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Withdrawal List --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-list-ul me-2"></i>Withdrawal List
                        </h5>
                        <small class="text-muted" id="filter-result-info"></small>
                    </div>

                    <div id="withdrawal-table-wrap">
                        @include('admin-page.service.celengan-syahid.withdrawal.components._table', compact('items'))
                    </div>

                    <div id="withdrawal-pagination" class="mt-3">
                        {{ $items->links() }}
                    </div>
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
    var AJAX_URL = '{{ route("admin.celsyahid.withdrawal.index") }}';

    // Select2 init
    $('#filter-campaign').select2({ placeholder: 'All Campaigns', allowClear: true, width: '100%', dropdownParent: $('body') });
    $('#filter-status').select2({
        placeholder: 'All Status',
        allowClear: true,
        width: '100%',
        dropdownParent: $('body'),
        templateResult: function (s) {
            if (!s.id) return s.text;
            var colors = { COMPLETED: '#198754', PENDING: '#856404', FAILED: '#b02a37', DRAFT: '#495057' };
            var col = colors[s.id] || '#495057';
            return $('<span style="color:' + col + '; font-weight:700">' + s.text + '</span>');
        }
    });

    function updateChips() {
        var chips   = $('#active-filter-chips');
        var camp    = $('#filter-campaign').find('option:selected').text();
        var status  = $('#filter-status').val();
        chips.empty();

        if ($('#filter-campaign').val()) {
            chips.append('<span class="wi-filter-chip"><i class="fas fa-flag"></i>' + camp + '</span>');
        }
        if (status) {
            chips.append('<span class="wi-filter-chip"><i class="fas fa-circle-half-stroke"></i>' + status + '</span>');
        }
    }

    function loadTable(page) {
        var params = {
            campaign_id: $('#filter-campaign').val() || '',
            status:      $('#filter-status').val() || '',
            page:        page || 1,
        };

        var $wrap = $('#withdrawal-table-wrap');
        $wrap.addClass('wi-loading');

        $.ajax({
            url: AJAX_URL,
            data: params,
            success: function (res) {
                $wrap.html(res.tableHtml).removeClass('wi-loading');
                $('#withdrawal-pagination').html(res.paginationHtml);

                $('#filter-result-info').text(
                    res.total > 0 ? res.total + ' record(s) found' : ''
                );

                updateChips();
                bindPagination();
            },
            error: function () {
                $wrap.removeClass('wi-loading');
            }
        });
    }

    function bindPagination() {
        $('#withdrawal-pagination a').off('click').on('click', function (e) {
            e.preventDefault();
            var url  = $(this).attr('href');
            var page = new URL(url).searchParams.get('page') || 1;
            loadTable(page);
            $('html, body').animate({ scrollTop: $('#withdrawal-table-wrap').offset().top - 100 }, 200);
        });
    }

    $('#btn-clear-filter').on('click', function () {
        $('#filter-campaign').val(null).trigger('change');
        $('#filter-status').val(null).trigger('change');
        loadTable(1);
    });

    // Auto-apply on change
    $('#filter-campaign, #filter-status').on('change', function () { loadTable(1); });

    // Initial state
    updateChips();
    bindPagination();
});
</script>
@endsection
