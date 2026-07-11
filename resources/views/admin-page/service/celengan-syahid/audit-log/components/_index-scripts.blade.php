<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    var baseUrl  = @json(route('admin.service.index.auditlog'));
    var curPage  = {{ $logs->currentPage() }};
    var lastPage = {{ $logs->lastPage() }};

    $('#audit-action, #audit-entity').select2({
        minimumResultsForSearch: Infinity,
        width: '180px',
        dropdownAutoWidth: false,
    });

    function currentParams() {
        return {
            action_type: $('#audit-action').val() || '',
            entity_type: $('#audit-entity').val() || '',
            search:      $('#audit-search').val()  || '',
        };
    }

    function renderPagination(meta) {
        if (!meta) return;
        curPage  = meta.current_page;
        lastPage = meta.last_page;

        $('#audit-pg-info').text(
            meta.total > 0
                ? 'Showing ' + meta.from + '–' + meta.to + ' of ' + meta.total + ' records'
                : 'No records found'
        );

        var $ctrl = $('#audit-pg-controls').empty();

        var $prev = $('<button class="btn btn-sm btn-outline-secondary audit-pg-btn"><i class="fas fa-chevron-left me-1"></i>Prev</button>');
        if (curPage <= 1) $prev.prop('disabled', true);
        else $prev.on('click', function () { load(null, curPage - 1); });
        $ctrl.append($prev);

        if (lastPage > 1) {
            var $badge = $('<span class="audit-pg-badge"></span>').text('Page ' + curPage + ' / ' + lastPage);
            $ctrl.append($badge);
        }

        var $next = $('<button class="btn btn-sm btn-outline-secondary audit-pg-btn">Next <i class="fas fa-chevron-right ms-1"></i></button>');
        if (curPage >= lastPage) $next.prop('disabled', true);
        else $next.on('click', function () { load(null, curPage + 1); });
        $ctrl.append($next);
    }

    // url = full URL with page (from old pagination links, kept for compat)
    // page = integer — build params + append ?page=N
    function load(url, page) {
        var $tbody = $('#audit-tbody');
        $tbody.css('opacity', 0.4);

        var ajaxUrl, ajaxData;
        if (url) {
            ajaxUrl  = url;
            ajaxData = undefined;
        } else {
            ajaxUrl  = baseUrl;
            ajaxData = Object.assign(currentParams(), { page: page || 1 });
        }

        $.ajax({
            url:     ajaxUrl,
            data:    ajaxData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            dataType: 'json',
        }).done(function (res) {
            $tbody.html(res.tableBody).css('opacity', 1);
            renderPagination(res.pagination);
            if (res.stats) {
                $('#audit-stat-total').text(res.stats.total.toLocaleString());
                $('#audit-stat-create').text(res.stats.create.toLocaleString());
                $('#audit-stat-update').text(res.stats.update.toLocaleString());
                $('#audit-stat-delete').text(res.stats.delete.toLocaleString());
            }
        }).fail(function () {
            $tbody.css('opacity', 1);
        });
    }

    // Init pagination on page load
    renderPagination({
        from:         {{ $logs->firstItem() ?? 0 }},
        to:           {{ $logs->lastItem() ?? 0 }},
        total:        {{ $logs->total() }},
        current_page: {{ $logs->currentPage() }},
        last_page:    {{ $logs->lastPage() }},
    });

    $('#audit-refresh').on('click', function (e) { e.preventDefault(); load(null, curPage); });
    $('#audit-action, #audit-entity').on('change', function () { load(null, 1); });

    var searchTimer;
    $('#audit-search').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { load(null, 1); }, 400);
    });
});
</script>
