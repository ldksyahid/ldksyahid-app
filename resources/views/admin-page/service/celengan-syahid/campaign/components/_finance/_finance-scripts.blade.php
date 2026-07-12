<script>
// ── Withdrawal History AJAX pagination ─────────────────────────────
$(function () {
    var AJAX_URL = '{{ route("admin.celsyahid.campaign.finance", $campaign->id) }}';
    var curPage  = {{ $withdrawals->currentPage() }};
    var lastPage = {{ $withdrawals->lastPage() }};

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
        $('#finance-wd-pg-info').text(
            meta.total > 0 ? 'Showing ' + meta.from + '–' + meta.to + ' of ' + meta.total + ' records' : ''
        );
        var $ctrl = $('#finance-wd-pg-controls').empty();
        if (lastPage <= 1) return;

        var $prev = $('<button class="btn btn-sm btn-outline-secondary wi-pg-btn"><i class="fas fa-chevron-left"></i></button>');
        if (curPage <= 1) $prev.prop('disabled', true);
        else $prev.on('click', function () { loadPage(curPage - 1); });
        $ctrl.append($prev);

        pageWindows(curPage, lastPage).forEach(function (p) {
            if (p === null) { $ctrl.append('<span class="wi-pg-ellipsis">…</span>'); return; }
            var $btn = $('<button class="btn btn-sm btn-outline-secondary wi-pg-btn' + (p === curPage ? ' active' : '') + '">' + p + '</button>');
            if (p !== curPage) { (function(pg){ $btn.on('click', function(){ loadPage(pg); }); })(p); }
            $ctrl.append($btn);
        });

        var $next = $('<button class="btn btn-sm btn-outline-secondary wi-pg-btn"><i class="fas fa-chevron-right"></i></button>');
        if (curPage >= lastPage) $next.prop('disabled', true);
        else $next.on('click', function () { loadPage(curPage + 1); });
        $ctrl.append($next);
    }

    function loadPage(page) {
        $('#finance-wd-tbody').css('opacity', .45);
        $.ajax({
            url: AJAX_URL, data: { page: page },
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            dataType: 'json',
        }).done(function (res) {
            $('#finance-wd-tbody').html(res.tableBody).css('opacity', 1);
            renderPagination(res);
            $('html,body').animate({ scrollTop: $('#finance-wd-tbody').closest('.card').offset().top - 80 }, 200);
        }).fail(function () {
            $('#finance-wd-tbody').css('opacity', 1);
        });
    }

    renderPagination({
        from:         {{ $withdrawals->firstItem() ?? 0 }},
        to:           {{ $withdrawals->lastItem() ?? 0 }},
        total:        {{ $withdrawals->total() }},
        current_page: {{ $withdrawals->currentPage() }},
        last_page:    {{ $withdrawals->lastPage() }},
    });
});

(function () {
    // Auto-refresh Bisabiller balance every 5 minutes
    var REFRESH_INTERVAL = 5 * 60 * 1000;
    var balanceEl   = document.getElementById('bisabiller-balance-value');
    var refreshedEl = document.getElementById('bisabiller-balance-refreshed');

    function refreshBalance() {
        if (!balanceEl) return;
        fetch('{{ route("admin.celsyahid.withdrawal.balance") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.balance !== undefined && data.balance !== null) {
                balanceEl.textContent = 'Rp ' + parseInt(data.balance).toLocaleString('id-ID');
            }
            if (refreshedEl) {
                var now = new Date();
                refreshedEl.textContent = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
            }
        })
        .catch(function () { /* silent */ });
    }

    setInterval(refreshBalance, REFRESH_INTERVAL);
})();
</script>
