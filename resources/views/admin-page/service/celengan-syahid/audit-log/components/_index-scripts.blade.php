<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function () {
        var baseUrl = @json(route('admin.service.index.auditlog'));

        // Match the Job Queue Log filter look
        $('#audit-action, #audit-entity').select2({
            minimumResultsForSearch: Infinity,
            width: '180px',
            dropdownAutoWidth: false,
        });

        function currentParams() {
            return {
                action_type: $('#audit-action').val() || '',
                entity_type: $('#audit-entity').val() || '',
                search:      $('#audit-search').val() || '',
            };
        }

        // url given (e.g. pagination link, already carries filters) → use as-is.
        // url omitted → baseUrl + current filter params (resets to page 1).
        function load(url) {
            var $tbody = $('#audit-tbody');
            $tbody.css('opacity', 0.45);

            $.ajax({
                url: url || baseUrl,
                data: url ? undefined : currentParams(),
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                dataType: 'json',
            }).done(function (res) {
                $('#audit-tbody').html(res.tableBody);
                $('#audit-pagination').html(res.pagination || '');
                if (res.stats) {
                    $('#audit-stat-total').text(res.stats.total);
                    $('#audit-stat-create').text(res.stats.create);
                    $('#audit-stat-update').text(res.stats.update);
                    $('#audit-stat-delete').text(res.stats.delete);
                }
            }).always(function () {
                $('#audit-tbody').css('opacity', 1);
            });
        }

        $('#audit-refresh').on('click', function (e) { e.preventDefault(); load(); });
        $('#audit-action, #audit-entity').on('change', function () { load(); });

        var searchTimer;
        $('#audit-search').on('input', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(load, 400);
        });

        // Pagination links (rendered inside #audit-pagination) → AJAX
        $(document).on('click', '#audit-pagination a', function (e) {
            var href = $(this).attr('href');
            if (!href || href === '#') return;
            e.preventDefault();
            load(href);
        });
    });
</script>
