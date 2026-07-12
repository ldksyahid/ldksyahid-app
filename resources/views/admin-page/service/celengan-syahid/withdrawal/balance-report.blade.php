@extends('admin-page.template.body')

@section('styles')
@include('admin-page.service.celengan-syahid.withdrawal.components._balance-report-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Header --}}
        <div class="col-12 mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 br-page-header">
                <div>
                    <h1 class="br-page-title mb-0">
                        <i class="fas fa-balance-scale me-2"></i>Balance Report
                    </h1>
                    <p class="text-muted mb-0 mt-1 small">Bisatopup wallet vs. internal DB — QRIS transactions only</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.celsyahid.withdrawal.index') }}" class="btn btn-sm btn-outline-secondary btn-rounded">
                        <i class="fas fa-arrow-left me-1"></i>Withdrawals
                    </a>
                    <a href="{{ route('admin.celsyahid.balance.report') }}" class="btn btn-sm btn-outline-secondary btn-rounded">
                        <i class="fas fa-sync-alt me-1"></i>Refresh
                    </a>
                </div>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="col-12 mb-4">
            <div class="row g-3">
                {{-- Actual Balance --}}
                <div class="col-md-4">
                    <div class="br-stat-card">
                        <div class="br-stat-icon br-icon-actual"><i class="fas fa-wallet"></i></div>
                        <div class="br-stat-info">
                            <div class="br-stat-label">Actual Balance</div>
                            <div class="br-stat-value">
                                @if($actualBalance !== null)
                                    Rp {{ number_format($actualBalance, 0, ',', '.') }}
                                @else
                                    <span class="text-muted small fw-normal">Unable to fetch</span>
                                @endif
                            </div>
                            <div class="br-stat-sub">Bisatopup API</div>
                        </div>
                    </div>
                </div>

                {{-- Expected Balance --}}
                <div class="col-md-4">
                    <div class="br-stat-card">
                        <div class="br-stat-icon br-icon-expected"><i class="fas fa-database"></i></div>
                        <div class="br-stat-info">
                            <div class="br-stat-label">Expected Balance</div>
                            <div class="br-stat-value">Rp {{ number_format($totalExpected, 0, ',', '.') }}</div>
                            <div class="br-stat-sub">Calculated from DB</div>
                        </div>
                    </div>
                </div>

                {{-- Discrepancy --}}
                <div class="col-md-4">
                    <div class="br-stat-card">
                        <div class="br-stat-icon {{ $discrepancy === null ? 'br-icon-neutral' : ($discrepancy < 0 ? 'br-icon-deficit' : ($isNormal ? 'br-icon-normal' : 'br-icon-warning')) }}">
                            <i class="fas {{ $discrepancy === null ? 'fa-question-circle' : ($discrepancy < 0 ? 'fa-exclamation-circle' : ($isNormal ? 'fa-check-circle' : 'fa-exclamation-triangle')) }}"></i>
                        </div>
                        <div class="br-stat-info">
                            <div class="br-stat-label">Discrepancy</div>
                            <div class="br-stat-value">
                                @if($discrepancy !== null)
                                    @if($discrepancy < 0)
                                        <span class="text-danger">− Rp {{ number_format(abs($discrepancy), 0, ',', '.') }}</span>
                                    @else
                                        <span class="{{ $isNormal ? 'text-success' : 'text-warning' }}">
                                            + Rp {{ number_format($discrepancy, 0, ',', '.') }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted small fw-normal">N/A</span>
                                @endif
                            </div>
                            <div class="br-stat-sub">
                                @if($discrepancy === null) —
                                @elseif($discrepancy < 0) Deficit
                                @elseif($isNormal) Normal (≤ Rp {{ number_format($threshold, 0, ',', '.') }})
                                @else Needs Review
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Discrepancy Explanation --}}
        <div class="col-12 mb-4">
            <div class="br-explain-card">
                <div class="br-explain-header">
                    <i class="fas fa-info-circle me-2"></i>Why might there be a discrepancy?
                </div>
                <div class="br-explain-body">
                    <ul class="mb-3">
                        <li>Bisatopup deducts MDR (1%) using <strong>ceiling rounding</strong> per transaction — e.g. 1% of Rp 20.202 = Rp 202.02 → charged as Rp 203. Expected balance here is calculated with the same CEIL formula.</li>
                        <li>Donations with <code>PAID</code> status but not yet settled to the Bisatopup wallet (T+1 / T+2 settlement delay).</li>
                        <li>DRAFT / PENDING / FAILED withdrawals are excluded — only <code>COMPLETED</code> withdrawals are counted as debits.</li>
                    </ul>
                    <div class="d-flex gap-2 flex-wrap">
                        <span class="discrepancy-badge discrepancy-normal">
                            <i class="fas fa-check-circle"></i> Normal — gap ≤ Rp {{ number_format($threshold, 0, ',', '.') }}
                        </span>
                        <span class="discrepancy-badge discrepancy-warning">
                            <i class="fas fa-exclamation-triangle"></i> Needs Review — gap > threshold
                        </span>
                        <span class="discrepancy-badge discrepancy-deficit">
                            <i class="fas fa-exclamation-circle"></i> Deficit — actual &lt; expected
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Breakdown Table --}}
        <div class="col-12 mb-4">
            <div class="wi-table-card">
                {{-- Card header --}}
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-3 flex-wrap gap-2">
                    <span class="fw-semibold" style="font-size:.95rem; color:#495057">
                        <i class="fas fa-table me-2 text-muted"></i>Breakdown per Campaign
                        <span class="br-qris-badge ms-2">QRIS only</span>
                    </span>
                    <small class="text-muted">Last updated: {{ now()->format('d M Y, H:i') }}</small>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover wi-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:42px" class="ps-4">#</th>
                                <th>Campaign</th>
                                <th class="text-end" style="min-width:140px">QRIS PAID<br><span class="fw-normal text-muted" style="font-size:.72rem">(Gross)</span></th>
                                <th class="text-end" style="min-width:130px">After MDR<br><span class="fw-normal text-muted" style="font-size:.72rem">(1%)</span></th>
                                <th class="text-center" style="width:60px">Txn</th>
                                <th class="text-end" style="min-width:120px">Withdrawn</th>
                                <th class="text-end" style="min-width:130px">Net Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rows as $i => $row)
                            @php $netPositive = $row['net'] >= 0; @endphp
                            <tr>
                                <td class="ps-4 text-muted small">{{ $i + 1 }}</td>
                                <td>
                                    <span class="fw-semibold" style="font-size:.875rem">{{ $row['campaign'] }}</span>
                                </td>
                                <td class="text-end text-muted small">Rp {{ number_format($row['total_qris'], 0, ',', '.') }}</td>
                                <td class="text-end small">Rp {{ number_format($row['wallet_credit'], 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="br-txn-badge">{{ $row['txn_count'] }}</span>
                                </td>
                                <td class="text-end">
                                    @if($row['total_withdrawn'] > 0)
                                        <span class="br-withdrawn">Rp {{ number_format($row['total_withdrawn'], 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span class="br-net {{ $netPositive ? 'br-net-positive' : 'br-net-negative' }}">
                                        Rp {{ number_format($row['net'], 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="text-center py-5 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                                        No QRIS transactions found.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($rows->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="6" class="ps-4 text-end br-tfoot-label">Total Expected Balance</td>
                                <td class="text-end br-tfoot-value">Rp {{ number_format($totalExpected, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                {{-- Footer info --}}
                <div class="br-table-footer">
                    <span class="text-muted small">
                        <i class="fas fa-circle-info me-1"></i>
                        MDR = Merchant Discount Rate charged by Bisatopup on each QRIS transaction. Withdrawn = COMPLETED withdrawals only.
                    </span>
                </div>
            </div>
        </div>

        {{-- Balance History Table --}}
        <div class="col-12 mb-4">
            <div class="wi-table-card">
                {{-- Card header --}}
                <div class="d-flex justify-content-between align-items-start px-4 pt-4 pb-3 flex-wrap gap-3">
                    <div class="d-flex align-items-center" style="gap:.75rem">
                        <span class="fw-semibold" style="font-size:.95rem; color:#495057">
                            <i class="fas fa-history me-2 text-muted"></i>Balance History
                        </span>
                        <span class="br-qris-badge">From DB</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="bh-summary-pill-wrap" id="bh-wrap-credit" style="display:none">
                            <div class="bh-summary-label">Total Credit (in)</div>
                            <span class="bh-pill-credit" id="bh-pill-credit"></span>
                        </div>
                        <div class="bh-summary-pill-wrap" id="bh-wrap-debit" style="display:none">
                            <div class="bh-summary-label">Total Debit (out)</div>
                            <span class="bh-pill-debit" id="bh-pill-debit"></span>
                        </div>
                        <small class="text-muted align-self-end" id="bh-found-count">—</small>
                    </div>
                </div>

                {{-- Search & Filter --}}
                <div class="bh-filter-bar">
                    <div class="bh-search-group">
                        <span class="bh-search-icon"><i class="fas fa-search"></i></span>
                        <input type="text" id="bh-search" class="bh-search-input"
                               placeholder="Search reference, donor, campaign…">
                        <button type="button" id="bh-search-clear" class="bh-search-clear" style="display:none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <input type="hidden" id="bh-type-filter" value="">
                    <div class="bh-custom-select" id="bh-type-dropdown">
                        <button type="button" class="bh-custom-select-btn" id="bh-type-btn">
                            <span class="bh-select-label" id="bh-type-label">All Types</span>
                            <i class="fas fa-chevron-down bh-select-arrow"></i>
                        </button>
                        <div class="bh-custom-select-menu" id="bh-type-menu">
                            <div class="bh-select-item selected" data-value="">
                                <span class="bh-select-dot bh-dot-all"></span>All Types
                            </div>
                            <div class="bh-select-item" data-value="PAYMENT">
                                <span class="bh-select-dot bh-dot-credit"></span>Payment (Credit)
                            </div>
                            <div class="bh-select-item" data-value="DISBURSEMENT">
                                <span class="bh-select-dot bh-dot-debit"></span>Transfer (Debit)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover wi-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3" style="min-width:120px">Type</th>
                                <th style="min-width:110px">Date</th>
                                <th style="min-width:200px">Campaign / Ref</th>
                                <th class="text-end" style="min-width:130px">Amount</th>
                                <th class="text-end" style="min-width:130px">Balance After</th>
                                <th class="text-center pe-3" style="width:60px">View</th>
                            </tr>
                        </thead>
                        <tbody id="bh-tbody">
                            <tr><td colspan="6"><div class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin fa-lg"></i></div></td></tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="bh-pagination-bar">
                    <span class="text-muted small" id="bh-pg-info"></span>
                    <div class="d-flex gap-1" id="bh-pg-controls"></div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Detail Popup Modal --}}
<div class="modal fade" id="bh-detail-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px">
        <div class="modal-content bh-modal-content">
            <div class="bh-modal-header" id="bh-modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="bh-modal-icon" id="bh-modal-icon"><i class="fas fa-circle-info"></i></div>
                    <div>
                        <div class="bh-modal-title" id="bh-modal-title">Transaction Detail</div>
                        <div class="bh-modal-sub" id="bh-modal-sub"></div>
                    </div>
                </div>
                <button type="button" class="bh-modal-close" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="bh-modal-body" id="bh-modal-body"></div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(function () {
    var AJAX_URL = '{{ route("admin.celsyahid.balance.history") }}';
    var curPage  = 1, lastPage = 1, searchTimer;

    function getFilters() {
        return { search: $.trim($('#bh-search').val()), type: $('#bh-type-filter').val() };
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
        $('#bh-pg-info').text(meta.total > 0 ? 'Showing ' + meta.from + '–' + meta.to + ' of ' + meta.total + ' records' : 'No records found');
        $('#bh-found-count').text(meta.total + ' record(s)');

        function fmtRp(n) { return 'Rp ' + Number(n||0).toLocaleString('id-ID'); }
        if (meta.total_credit !== undefined) {
            $('#bh-pill-credit').text('+ ' + fmtRp(meta.total_credit));
            $('#bh-pill-debit').text('− ' + fmtRp(meta.total_debit));
            $('#bh-wrap-credit, #bh-wrap-debit').css('display', '');
        }

        var $ctrl = $('#bh-pg-controls').empty();
        if (lastPage <= 1) return;

        var $prev = $('<button class="btn btn-sm btn-outline-secondary bh-pg-btn"><i class="fas fa-chevron-left"></i></button>');
        if (curPage <= 1) $prev.prop('disabled', true);
        else $prev.on('click', function () { load(curPage - 1); });
        $ctrl.append($prev);

        pageWindows(curPage, lastPage).forEach(function (p) {
            if (p === null) { $ctrl.append('<span class="bh-pg-ellipsis">…</span>'); return; }
            var $btn = $('<button class="btn btn-sm btn-outline-secondary bh-pg-btn' + (p === curPage ? ' active' : '') + '">' + p + '</button>');
            if (p !== curPage) { (function(pg){ $btn.on('click', function(){ load(pg); }); })(p); }
            $ctrl.append($btn);
        });

        var $next = $('<button class="btn btn-sm btn-outline-secondary bh-pg-btn"><i class="fas fa-chevron-right"></i></button>');
        if (curPage >= lastPage) $next.prop('disabled', true);
        else $next.on('click', function () { load(curPage + 1); });
        $ctrl.append($next);
    }

    function load(page) {
        $('#bh-tbody').css('opacity', .45);
        $.ajax({
            url: AJAX_URL, data: $.extend({ page: page || 1 }, getFilters()),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }, dataType: 'json',
        }).done(function (res) {
            $('#bh-tbody').html(res.html).css('opacity', 1);
            renderPagination(res);
        }).fail(function () { $('#bh-tbody').css('opacity', 1); });
    }

    $('#bh-search').on('input', function () {
        var v = $(this).val();
        $('#bh-search-clear').toggle(v.length > 0);
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { load(1); }, 350);
    });
    $('#bh-search-clear').on('click', function () { $('#bh-search').val(''); $(this).hide(); load(1); });
    // Custom type dropdown
    $('#bh-type-btn').on('click', function (e) {
        e.stopPropagation();
        $('#bh-type-dropdown').toggleClass('open');
    });
    $(document).on('click', '.bh-select-item', function () {
        var val   = $(this).data('value');
        var label = $(this).text().trim();
        $('.bh-select-item').removeClass('selected');
        $(this).addClass('selected');
        $('#bh-type-label').text(label);
        $('#bh-type-filter').val(val);
        $('#bh-type-dropdown').removeClass('open');
        load(1);
    });
    $(document).on('click', function (e) {
        if (!$('#bh-type-dropdown').is(e.target) && $('#bh-type-dropdown').has(e.target).length === 0) {
            $('#bh-type-dropdown').removeClass('open');
        }
    });

    $(document).on('click', '.bh-view-btn', function () {
        var type   = $(this).data('type');
        var detail = $(this).data('detail');
        if (typeof detail === 'string') { try { detail = JSON.parse(detail); } catch(e) {} }

        var isCredit = (type === 'PAYMENT');
        var icon  = isCredit ? 'fa-arrow-circle-down' : 'fa-arrow-circle-up';
        var color = isCredit ? '#00a79d' : '#d97706';

        $('#bh-modal-icon').html('<i class="fas ' + icon + '" style="font-size:1.4rem;color:' + color + '"></i>');
        $('#bh-modal-title').text(isCredit ? 'Payment Credit' : 'Transfer Debit');
        $('#bh-modal-sub').text(detail.doc_no || detail.reff_id || '');
        $('#bh-modal-header').css('border-bottom-color', isCredit ? 'rgba(0,167,157,.15)' : 'rgba(217,119,6,.15)');

        var rows = '';
        if (isCredit) {
            rows += bhRow('Campaign', detail.campaign);
            rows += bhRow('Date', detail.date);
            rows += bhRow('Reference', detail.doc_no);
            rows += bhRow('Donor', detail.donor);
            rows += bhRow('Email', detail.email);
            rows += bhRowAmt('Gross Amount', detail.total_tagihan);
            rows += bhRowAmt('MDR Fee (1%)', detail.mdr, false, '#d97706');
            rows += bhRowAmt('Wallet Credit', detail.total_tagihan - detail.mdr, true, '#00a79d');
        } else {
            rows += bhRow('Campaign', detail.campaign);
            rows += bhRow('Executed', detail.executed_at);
            rows += bhRow('Completed', detail.completed_at);
            rows += bhRow('Ref ID', detail.reff_id);
            rows += bhRow('Bank', detail.bank_code);
            rows += bhRow('Account', detail.account_number);
            rows += bhRow('Recipient', detail.account_holder);
            rows += bhRowAmt('Amount', detail.amount, true, '#d97706');
            rows += bhRowAmt('Transfer Fee', detail.fee);
        }

        $('#bh-modal-body').html('<div class="bh-detail-grid">' + rows + '</div>');
        new bootstrap.Modal(document.getElementById('bh-detail-modal')).show();
    });

    function bhRow(label, value) {
        return '<div class="bh-detail-row"><span class="bh-detail-label">' + label + '</span><span class="bh-detail-value">' + (value || '—') + '</span></div>';
    }
    function bhRowAmt(label, amount, bold, color) {
        var style = (bold ? 'font-weight:700;' : '') + (color ? 'color:' + color + ';' : '');
        var fmt = 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
        return '<div class="bh-detail-row"><span class="bh-detail-label">' + label + '</span><span class="bh-detail-value" style="' + style + '">' + fmt + '</span></div>';
    }

    load(1);
});
</script>
@endsection
