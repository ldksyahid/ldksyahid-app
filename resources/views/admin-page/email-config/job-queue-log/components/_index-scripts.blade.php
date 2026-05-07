<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    // ── State ──────────────────────────────────────────────────────────────
    var isPaused        = false;
    var pollingInterval = null;
    var updateTimer     = null;
    var secondsSince    = 0;
    var currentPage     = 1;
    var previousStats   = null;
    var previousJobs    = {};
    var currentJobs     = {};
    var currentModalId  = null;

    var POLL_INTERVAL   = 3000;
    var STUCK_THRESHOLD = 8;

    // CSRF for AJAX mutations
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── Bootstrap Tooltips ─────────────────────────────────────────────────
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
        new bootstrap.Tooltip(el, { trigger: 'hover' });
    });

    // ── SweetAlert2 Helpers (matches admin-page pattern) ──────────────────
    function swalConfirm(opts, onConfirm) {
        Swal.fire($.extend({
            title              : 'Are you sure?',
            text               : "You won't be able to revert this!",
            icon               : 'warning',
            showCancelButton   : true,
            confirmButtonColor : '#3085d6',
            cancelButtonColor  : '#d33',
            confirmButtonText  : 'Yes, delete it!',
        }, opts)).then(function (result) {
            if (result.isConfirmed) onConfirm();
        });
    }

    function swalSuccess(msg) {
        Swal.mixin({
            toast             : true,
            position          : 'top-end',
            showConfirmButton : false,
            timer             : 1500,
            width             : '350px',
        }).fire({ icon: 'success', title: msg });
    }

    function swalError(msg) {
        Swal.fire({ icon: 'error', title: 'Error!', text: msg, confirmButtonColor: '#00a79d' });
    }

    // ── Polling ────────────────────────────────────────────────────────────
    function startPolling() {
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(fetchData, POLL_INTERVAL);
    }

    function stopPolling() {
        clearInterval(pollingInterval);
        pollingInterval = null;
    }

    function resetUpdateTimer() {
        secondsSince = 0;
        clearInterval(updateTimer);
        updateTimer = setInterval(function () {
            secondsSince++;
            $('#last-updated-text').text('Last updated: ' + secondsSince + 's ago');
        }, 1000);
    }

    // ── Fetch Data ─────────────────────────────────────────────────────────
    function fetchData() {
        var params = {
            status : $('#filter-status').val() || 'all',
            queue  : $('#filter-queue').val()  || 'all',
            search : $('#filter-search').val() || '',
            page   : currentPage
        };

        $.getJSON('/admin/email-config/job-queue-log/data', params)
            .done(function (response) {
                updateStats(response.stats, response.gmail_daily_limit);
                updateQueuesFilter(response.queues);
                updateTable(response.jobs);
                resetUpdateTimer();
                setLiveState(true);
            })
            .fail(function () {
                setLiveState(false);
                $('#last-updated-text').text('Connection error — retrying...');
            });
    }

    // ── Stats ──────────────────────────────────────────────────────────────
    function updateStats(stats, gmailDailyLimit) {
        $('#stat-total').text(Number(stats.total).toLocaleString());
        $('#stat-pending').text(Number(stats.pending).toLocaleString());
        $('#stat-processing').text(Number(stats.processing).toLocaleString());
        $('#stat-delayed').text(Number(stats.delayed).toLocaleString());

        if (previousStats) {
            setChange('total',      stats.total      - previousStats.total);
            setChange('pending',    stats.pending    - previousStats.pending);
            setChange('processing', stats.processing - previousStats.processing);
            setChange('delayed',    stats.delayed    - previousStats.delayed);
        }
        previousStats = stats;

        // Gmail daily limit banner
        if (gmailDailyLimit && stats.daily_limit > 0) {
            $('#daily-limit-job-count').text(stats.daily_limit);
            $('#daily-limit-banner').slideDown(200);
        } else {
            $('#daily-limit-banner').slideUp(200);
        }
    }

    function setChange(key, diff) {
        var $el = $('#stat-' + key + '-change');
        if (diff === 0) { $el.text('').removeClass('up down'); return; }
        $el.text((diff > 0 ? '▲ +' : '▼ ') + diff)
           .removeClass('up down').addClass(diff > 0 ? 'up' : 'down');
    }

    // ── Queues Filter ──────────────────────────────────────────────────────
    function updateQueuesFilter(queues) {
        var $sel    = $('#filter-queue');
        var current = $sel.val();
        $sel.find('option:not(:first)').remove();
        (queues || []).forEach(function (q) {
            $sel.append('<option value="' + q + '">' + q + '</option>');
        });
        if (current && current !== 'all') $sel.val(current);
        $sel.trigger('change.select2');
    }

    // ── Table ──────────────────────────────────────────────────────────────
    function updateTable(paginator) {
        var jobs   = paginator.data || [];
        var $tbody = $('#jobs-tbody');

        if (jobs.length === 0) {
            $tbody.html(
                '<tr><td colspan="9" class="text-center py-5 text-muted">' +
                '<i class="fas fa-inbox me-2"></i>No jobs found for current filter.</td></tr>'
            );
            updatePagination(paginator);
            return;
        }

        var nextJobs = {};
        jobs.forEach(function (j) { nextJobs[j.ID] = j; });

        var html = '';
        jobs.forEach(function (j) { html += buildRow(j); });

        $tbody.html(html);

        // Flash new rows
        jobs.forEach(function (j) {
            if (!currentJobs[j.ID]) {
                $tbody.find('tr[data-id="' + j.ID + '"]').addClass('row-flash');
            }
        });

        currentJobs = nextJobs;
        updatePagination(paginator);
    }

    function buildRow(j) {
        var badge    = buildBadge(j.job_status);
        var avail    = j.availableDate || '—';
        var reserved = j.reservedDate  ? j.reservedDate : '<span class="text-muted">—</span>';
        var created  = j.createdDate   || '—';
        var jobType  = escHtml(j.job_type || 'Unknown');

        return '<tr data-id="' + j.ID + '">' +
            '<td><span class="text-muted" style="font-size:0.75rem">#</span>' + j.ID + '</td>' +
            '<td><code class="small">' + jobType + '</code></td>' +
            '<td><span class="badge bg-light text-dark border small rounded-pill">' + escHtml(j.queue) + '</span></td>' +
            '<td>' + badge + '</td>' +
            '<td>' + buildAttemptsBadge(j.attempts) + '</td>' +
            '<td class="small">' + avail + '</td>' +
            '<td class="small">' + reserved + '</td>' +
            '<td class="small">' + created + '</td>' +
            '<td>' +
            '<button class="btn btn-xs btn-outline-primary btn-detail" data-id="' + j.ID + '">' +
            '<i class="fas fa-eye me-1"></i>Detail</button>' +
            '</td>' +
            '</tr>';
    }

    function buildBadge(status) {
        var map = {
            pending:     ['badge-pending',     'Pending'],
            processing:  ['badge-processing',  'Processing'],
            delayed:     ['badge-delayed',     'Delayed'],
            daily_limit: ['badge-daily-limit', 'Daily Limit'],
            stuck:       ['badge-stuck',       'Stuck'],
        };
        var cfg = map[status] || map.pending;
        return '<span class="badge-status ' + cfg[0] + '">' +
               '<span class="status-dot"></span>' + cfg[1] + '</span>';
    }

    function buildAttemptsBadge(attempts) {
        if (attempts === 0) return '<span class="text-muted">0</span>';
        if (attempts >= STUCK_THRESHOLD) return '<span class="badge bg-danger rounded-pill">' + attempts + '</span>';
        if (attempts >= 2)              return '<span class="badge bg-warning text-dark rounded-pill">' + attempts + '</span>';
        return '<span class="badge bg-light text-dark border rounded-pill">' + attempts + '</span>';
    }

    // ── Pagination ─────────────────────────────────────────────────────────
    function updatePagination(p) {
        var from  = p.from  || 0;
        var to    = p.to    || 0;
        var total = p.total || 0;

        $('#pagination-info').text(
            total === 0 ? 'No results' :
            'Showing ' + from + '–' + to + ' of ' + total.toLocaleString() + ' jobs'
        );

        var $ctrl = $('#pagination-controls').empty();
        if (!p.last_page || p.last_page <= 1) return;

        // Prev button
        $ctrl.append(
            '<button class="btn btn-sm btn-outline-secondary" id="pg-prev"' +
            (p.current_page <= 1 ? ' disabled' : '') + '>' +
            '<i class="fas fa-chevron-left"></i></button>'
        );

        // Page numbers (window of 5)
        var start = Math.max(1, p.current_page - 2);
        var end   = Math.min(p.last_page, p.current_page + 2);
        if (start > 1) {
            $ctrl.append('<button class="btn btn-sm btn-outline-secondary pg-num" data-page="1">1</button>');
            if (start > 2) $ctrl.append('<span class="px-1 text-muted">…</span>');
        }
        for (var i = start; i <= end; i++) {
            $ctrl.append(
                '<button class="btn btn-sm ' +
                (i === p.current_page ? 'btn-primary' : 'btn-outline-secondary') +
                ' pg-num" data-page="' + i + '">' + i + '</button>'
            );
        }
        if (end < p.last_page) {
            if (end < p.last_page - 1) $ctrl.append('<span class="px-1 text-muted">…</span>');
            $ctrl.append('<button class="btn btn-sm btn-outline-secondary pg-num" data-page="' + p.last_page + '">' + p.last_page + '</button>');
        }

        // Next button
        $ctrl.append(
            '<button class="btn btn-sm btn-outline-secondary" id="pg-next"' +
            (p.current_page >= p.last_page ? ' disabled' : '') + '>' +
            '<i class="fas fa-chevron-right"></i></button>'
        );
    }

    // ── Detail Modal ───────────────────────────────────────────────────────
    function openDetail(id) {
        var j = currentJobs[id];
        if (!j) { swalError('Job data not found in current view. Try refreshing.'); return; }

        currentModalId = id;
        $('#modal-job-id').text('#' + id);
        $('#m-job-type').text(j.job_type  || '—');
        $('#m-job-full').text(j.job_full  || '—');
        $('#m-queue').text(j.queue        || '—');
        $('#m-uuid').text(j.job_uuid      || '—');
        var attemptNote = '';
        if (j.job_status === 'daily_limit') {
            attemptNote = '  — waiting for Gmail daily limit reset';
        } else if (j.attempts >= STUCK_THRESHOLD) {
            attemptNote = '  ⚠ High — may be stuck';
        }
        $('#m-attempts').text(j.attempts + attemptNote);
        $('#m-created').text(j.createdDate    || '—');
        $('#m-available').text(j.availableDate || '—');
        $('#m-reserved').text(j.reservedDate  || '—');
        $('#m-status').html(buildBadge(j.job_status));
        $('#m-raw-payload').text(j.payload_clean || '—').hide();
        $('#btn-toggle-payload').html('<i class="fas fa-chevron-down me-1"></i>Show');

        // Mail info
        var mi = j.mail_info || {};
        var mailHtml = '';
        if (mi.to)      mailHtml += buildInfoRow('To',      mi.to);
        if (mi.subject) mailHtml += buildInfoRow('Subject', mi.subject);
        $('#m-mail-info').html(
            mailHtml || '<span class="text-muted small">No mail info extractable from payload</span>'
        );

        $('#job-detail-modal').modal('show');
    }

    function buildInfoRow(key, val) {
        return '<div class="info-row">' +
            '<span class="info-key">' + escHtml(key) + '</span>' +
            '<span class="info-val">'  + escHtml(val) + '</span>' +
            '</div>';
    }

    // ── Delete Job ─────────────────────────────────────────────────────────
    function deleteJob(id, callback) {
        $.ajax({
            url  : '/admin/email-config/job-queue-log/' + id,
            type : 'DELETE',
        }).done(function (res) {
            if (res.success) {
                swalSuccess('Job #' + id + ' has been deleted.');
                if (callback) callback();
                fetchData();
            } else {
                swalError(res.message || 'Failed to delete job.');
            }
        }).fail(function (xhr) {
            var msg = 'Failed to delete job.';
            if (xhr.status === 404) {
                try { msg = JSON.parse(xhr.responseText).message; } catch(e) {}
            }
            swalError(msg);
        });
    }

    // ── Helpers ────────────────────────────────────────────────────────────
    function setLiveState(live) {
        if (live) {
            $('#live-indicator').removeClass('paused');
            $('#live-label').text(isPaused ? 'PAUSED' : 'LIVE');
        } else {
            $('#live-label').text('ERROR');
        }
    }

    function escHtml(s) {
        if (!s) return '';
        return String(s)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    // ── Event Handlers ─────────────────────────────────────────────────────

    // Pause / Resume
    $('#btn-pause-resume').on('click', function () {
        isPaused = !isPaused;
        if (isPaused) {
            stopPolling(); clearInterval(updateTimer);
            $(this).html('<i class="fas fa-play me-1"></i>Resume');
            $('#live-indicator').addClass('paused');
            $('#live-label').text('PAUSED');
            $('#last-updated-text').text('Polling paused');
        } else {
            $(this).html('<i class="fas fa-pause me-1"></i>Pause');
            $('#live-indicator').removeClass('paused');
            $('#live-label').text('LIVE');
            fetchData(); startPolling();
        }
    });

    // Filters
    $('#filter-status, #filter-queue').on('change', function () {
        currentPage = 1; fetchData();
    });
    var searchTimer;
    $('#filter-search').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { currentPage = 1; fetchData(); }, 400);
    });

    // Pagination
    $(document).on('click', '#pg-prev', function () {
        if (currentPage > 1) { currentPage--; fetchData(); }
    });
    $(document).on('click', '#pg-next', function () {
        currentPage++; fetchData();
    });
    $(document).on('click', '.pg-num', function () {
        var page = parseInt($(this).data('page'));
        if (page !== currentPage) { currentPage = page; fetchData(); }
    });

    // Open detail
    $(document).on('click', '.btn-detail', function () {
        openDetail($(this).data('id'));
    });

    // Delete from modal
    $('#modal-btn-delete').on('click', function () {
        if (!currentModalId) return;
        swalConfirm({
            title: 'Delete Job #' + currentModalId + '?',
            text : 'This job will be permanently removed from the queue.',
            icon : 'warning',
        }, function () {
            deleteJob(currentModalId, function () {
                $('#job-detail-modal').modal('hide');
            });
        });
    });

    // Delete stuck
    $('#btn-delete-stuck').on('click', function () {
        if (!previousStats || previousStats.stuck === 0) {
            swalError('There are no stuck jobs to delete.');
            return;
        }
        swalConfirm({
            title: 'Delete All Stuck Jobs?',
            text : 'This will permanently delete all jobs with ' + STUCK_THRESHOLD + ' or more attempts (' + previousStats.stuck + ' jobs).',
            icon : 'warning',
        }, function () {
            $.ajax({
                url  : '/admin/email-config/job-queue-log',
                type : 'DELETE',
            }).done(function (res) {
                swalSuccess('Deleted ' + (res.deleted || 0) + ' stuck job(s) successfully.');
                fetchData();
            }).fail(function () {
                swalError('Failed to delete stuck jobs.');
            });
        });
    });

    // Toggle raw payload
    $('#btn-toggle-payload').on('click', function () {
        var $pre = $('#m-raw-payload');
        if ($pre.is(':visible')) {
            $pre.hide();
            $(this).html('<i class="fas fa-chevron-down me-1"></i>Show');
        } else {
            $pre.show();
            $(this).html('<i class="fas fa-chevron-up me-1"></i>Hide');
        }
    });

    // ── Init ───────────────────────────────────────────────────────────────
    $('#filter-status').select2({
        minimumResultsForSearch: Infinity,
        width: '180px',
        dropdownAutoWidth: false,
    });
    $('#filter-queue').select2({
        minimumResultsForSearch: Infinity,
        width: '180px',
        dropdownAutoWidth: false,
    });

    fetchData();
    startPolling();
});
</script>
