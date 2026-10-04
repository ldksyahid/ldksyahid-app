<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    var DATA_URL  = "{{ route('admin.laravel-log.data') }}";
    var CLEAR_URL = "{{ route('admin.laravel-log.clear') }}";
    var currentPage = 1;
    var entriesById = {};

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    function swalConfirm(opts, onConfirm) {
        Swal.fire($.extend({
            title              : 'Are you sure?',
            icon               : 'warning',
            showCancelButton   : true,
            confirmButtonColor : '#3085d6',
            cancelButtonColor  : '#d33',
            confirmButtonText  : 'Yes, continue!',
        }, opts)).then(function (result) {
            if (result.isConfirmed) onConfirm();
        });
    }

    function swalSuccess(msg) {
        Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 1500, width: '350px',
        }).fire({ icon: 'success', title: msg });
    }

    function swalError(msg) {
        Swal.fire({ icon: 'error', title: 'Error!', text: msg, confirmButtonColor: '#00a79d' });
    }

    function escapeHtml(str) {
        return $('<div>').text(str == null ? '' : str).html();
    }

    function levelBadge(level) {
        var l = (level || '').toLowerCase();
        return '<span class="badge-level badge-level-' + l + '">' + escapeHtml(level) + '</span>';
    }

    function formatBytes(bytes) {
        if (!bytes) return '0 B';
        var units = ['B', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(1024));
        return (bytes / Math.pow(1024, i)).toFixed(i === 0 ? 0 : 1) + ' ' + units[i];
    }

    function renderRows(entries) {
        var $tbody = $('#log-tbody').empty();
        entriesById = {};

        if (entries.length === 0) {
            $tbody.append('<tr><td colspan="4" class="text-center py-5 text-muted">No log entries found.</td></tr>');
            return;
        }

        entries.forEach(function (entry, idx) {
            entriesById[idx] = entry;
            var $row = $(
                '<tr>' +
                    '<td class="small text-nowrap">' + escapeHtml(entry.timestamp) + '</td>' +
                    '<td class="text-center">' + levelBadge(entry.level) + '</td>' +
                    '<td class="ll-message" title="' + escapeHtml(entry.excerpt) + '">' + escapeHtml(entry.excerpt) + '</td>' +
                    '<td class="text-center">' +
                        '<button class="btn btn-sm btn-outline-primary btn-rounded btn-view-entry" data-idx="' + idx + '">' +
                            '<i class="fas fa-eye"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>'
            );
            $tbody.append($row);
        });
    }

    function renderPagination(meta) {
        $('#pagination-info').text(
            meta.total > 0
                ? 'Showing ' + meta.from + '–' + meta.to + ' of ' + meta.total + ' entries'
                : 'No entries'
        );

        var $ctrl = $('#pagination-controls').empty();
        if (meta.last_page <= 1) return;

        var $prev = $('<button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-left"></i></button>');
        if (meta.current_page <= 1) $prev.prop('disabled', true);
        else $prev.on('click', function () { fetchData(meta.current_page - 1); });
        $ctrl.append($prev);

        $ctrl.append('<span class="small text-muted px-2 align-self-center">Page ' + meta.current_page + ' / ' + meta.last_page + '</span>');

        var $next = $('<button class="btn btn-sm btn-outline-secondary"><i class="fas fa-chevron-right"></i></button>');
        if (meta.current_page >= meta.last_page) $next.prop('disabled', true);
        else $next.on('click', function () { fetchData(meta.current_page + 1); });
        $ctrl.append($next);
    }

    function fetchData(page) {
        currentPage = page || 1;
        $('#log-tbody').html('<tr><td colspan="4" class="text-center py-5 text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</td></tr>');

        $.ajax({
            url: DATA_URL,
            data: {
                page:   currentPage,
                level:  $('#filter-level').val(),
                search: $('#filter-search').val(),
            },
        }).done(function (res) {
            renderRows(res.entries.data);
            renderPagination(res.entries);

            $('#stat-total').text(res.stats.total);
            $('#stat-critical').text(res.stats.emergency + res.stats.alert + res.stats.critical);
            $('#stat-error').text(res.stats.error);
            $('#stat-warning').text(res.stats.warning);
            $('#stat-info').text(res.stats.notice + res.stats.info + res.stats.debug);

            $('#file-meta').html(
                '<i class="fas fa-hdd me-1"></i>' + formatBytes(res.file_size) +
                (res.updated_at ? ' &middot; Last written ' + escapeHtml(res.updated_at) : '')
            );

            $('#truncated-banner').toggle(!!res.truncated);
        }).fail(function () {
            $('#log-tbody').html('<tr><td colspan="4" class="text-center py-5 text-danger">Failed to load log data.</td></tr>');
        });
    }

    $('#log-tbody').on('click', '.btn-view-entry', function () {
        var entry = entriesById[$(this).data('idx')];
        if (!entry) return;
        $('#modal-log-time').text(entry.timestamp);
        $('#modal-log-level').html(levelBadge(entry.level));
        $('#modal-log-body').text(entry.body);
        new bootstrap.Modal(document.getElementById('log-detail-modal')).show();
    });

    $('#filter-level').on('change', function () { fetchData(1); });
    var searchTimer = null;
    $('#filter-search').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { fetchData(1); }, 400);
    });
    $('#btn-refresh').on('click', function () { fetchData(currentPage); });

    $('#btn-clear-log').on('click', function () {
        swalConfirm({
            title: 'Clear Laravel Log?',
            text : 'The entire log file will be permanently emptied. This cannot be undone — download it first if you need a copy.',
            confirmButtonText: 'Yes, clear it!',
        }, function () {
            $.ajax({ url: CLEAR_URL, type: 'DELETE' })
                .done(function () {
                    swalSuccess('Log cleared successfully.');
                    fetchData(1);
                })
                .fail(function () {
                    swalError('Failed to clear the log file.');
                });
        });
    });

    fetchData(1);
});
</script>
