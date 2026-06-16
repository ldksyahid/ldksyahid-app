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

        {{-- Card 1: Amdigipay - Bisatopup Balance --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-building-columns me-2"></i>Amdigipay - Bisatopup Account Balance
                    </h5>
                    @if($bisabillerBalance !== null)
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="fs-4 fw-bold text-brand">
                            Rp {{ number_format($bisabillerBalance, 0, ',', '.') }}
                        </div>
                        <small class="text-muted">Total across all campaigns</small>
                        @php
                            $dbExpected = \App\Models\Donation::where('gateway','bisatopup')->where('payment_status','PAID')->sum('jumlah_donasi')
                                - \App\Models\Donation::where('gateway','bisatopup')->where('payment_status','PAID')->sum('biaya_admin')
                                - \App\Models\Withdrawal::where('status','COMPLETED')->sum('amount');
                            $disc = $bisabillerBalance - $dbExpected;
                            $discThreshold = config('services.two_fa.discrepancy_threshold', 50000);
                        @endphp
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
                    <span class="text-muted">Unable to fetch balance from Amdigipay - Bisatopup.</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Card 2: Filters --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="section-title mb-3"><i class="fas fa-filter me-2"></i>Filters</h5>
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Campaign</label>
                            <select id="filter-campaign" class="form-select">
                                <option value="">All Campaigns</option>
                                @foreach($campaigns as $id => $judul)
                                <option value="{{ $id }}">{{ $judul }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Status</label>
                            <select id="filter-status" class="form-select">
                                <option value="">All Status</option>
                                @foreach(['DRAFT','PENDING','COMPLETED','FAILED'] as $s)
                                <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button id="btn-apply-filter" class="btn btn-custom-primary w-100">
                                <i class="fas fa-search me-1"></i> Apply
                            </button>
                        </div>
                        <div class="col-md-2">
                            <button id="btn-clear-filter" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-1"></i> Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 3: Withdrawal List --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <h5 class="section-title mb-0"><i class="fas fa-list me-2"></i>Withdrawal List</h5>
                        <small class="text-muted" id="filter-result-info"></small>
                    </div>
                    <div id="withdrawal-table-wrap">
                        @include('admin-page.service.celengan-syahid.withdrawal.components._table', compact('items'))
                    </div>
                    <div id="withdrawal-pagination">
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
    $('#filter-status').select2({ placeholder: 'All Status', allowClear: true, width: '100%', dropdownParent: $('body') });

    function loadTable(page) {
        var params = {
            campaign_id: $('#filter-campaign').val() || '',
            status:      $('#filter-status').val() || '',
            page:        page || 1,
        };

        $('#withdrawal-table-wrap').css('opacity', '.5');

        $.ajax({
            url: AJAX_URL,
            data: params,
            success: function (res) {
                $('#withdrawal-table-wrap').html(res.tableHtml).css('opacity', '1');
                $('#withdrawal-pagination').html(res.paginationHtml);

                var info = res.total > 0
                    ? res.total + ' record(s) found'
                    : '';
                $('#filter-result-info').text(info);

                // Re-bind pagination links
                bindPagination();
            },
            error: function () {
                $('#withdrawal-table-wrap').css('opacity', '1');
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

    $('#btn-apply-filter').on('click', function () { loadTable(1); });

    $('#btn-clear-filter').on('click', function () {
        $('#filter-campaign').val('').trigger('change');
        $('#filter-status').val('').trigger('change');
        loadTable(1);
    });

    // Enter key on selects
    $('#filter-campaign, #filter-status').on('change', function () { loadTable(1); });

    // Init pagination binding on page load
    bindPagination();
});
</script>
@endsection
