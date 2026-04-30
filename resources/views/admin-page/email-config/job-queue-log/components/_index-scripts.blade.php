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
    var previousJobs    = {};   // id → { status, attempts }
    var currentJobs     = {};   // id → full job object (for modal)
    var activityCount   = 0;
    var feedCollapsed   = false;
    var currentModalId  = null;

    var POLL_INTERVAL  = 3000;   // ms
    var STUCK_THRESHOLD = 3;

    // CSRF for AJAX mutations
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    // ── Bootstrap Tooltips ─────────────────────────────────────────────────
    var tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltipEls.forEach(function (el) { new bootstrap.Tooltip(el, { trigger: 'hover' }); });

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
            status : $('#filter-status').val()  || 'all',
            queue  : $('#filter-queue').val()   || 'all',
            search : $('#filter-search').val()  || '',
            page   : currentPage
        };

        $.getJSON('/admin/email-config/job-queue-log/data', params)
            .done(function (response) {
                updateStats(response.stats);
                updateQueuesFilter(response.queues);
                updateTable(response.jobs);
                detectChanges(response.jobs.data, response.stats);
                resetUpdateTimer();
                setLiveState(true);
            })
            .fail(function () {
                setLiveState(false);
                $('#last-updated-text').text('Connection error — retrying...');
            });
    }

    // ── Stats ──────────────────────────────────────────────────────────────
    function updateStats(stats) {
        setStatCard('total',      stats.total,      'stat-icon-total');
        setStatCard('pending',    stats.pending,     'stat-icon-pending');
        setStatCard('processing', stats.processing,  'stat-icon-processing');
        setStatCard('delayed',    stats.delayed,     'stat-icon-delayed');

        if (previousStats) {
            setChange('total',      stats.total      - previousStats.total);
            setChange('pending',    stats.pending    - previousStats.pending);
            setChange('processing', stats.processing - previousStats.processing);
            setChange('delayed',    stats.delayed    - previousStats.delayed);
        }
        previousStats = stats;
    }

    function setStatCard(key, val, _) {
        $('#stat-' + key).text(Number(val).toLocaleString());
    }

    function setChange(key, diff) {
        var $el = $('#stat-' + key + '-change');
        if (diff === 0) { $el.text('').removeClass('up down'); return; }
        $el.text((diff > 0 ? '▲ +' : '▼ ') + diff)
           .removeClass('up down')
           .addClass(diff > 0 ? 'up' : 'down');
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
        $sel.trigger('change.select2'); // notify Select2 to re-render
    }

    // ── Table ──────────────────────────────────────────────────────────────
    function updateTable(paginator) {
        var jobs   = paginator.data || [];
        var $tbody = $('#jobs-tbody');

        if (jobs.length === 0) {
            $tbody.html('<tr><td colspan="9" class="text-center py-5 text-muted">' +
                '<i class="fas fa-inbox me-2"></i>No jobs found for current filter.</td></tr>');
            updatePagination(paginator);
            return;
        }

        // Build map of new jobs for flash detection
        var newIds = {};
        jobs.forEach(function (j) { newIds[j.ID] = true; });

        var html = '';
        var nextJobs = {};
        jobs.forEach(function (j) {
            nextJobs[j.ID] = j;
            html += buildRow(j);
        });

        $tbody.html(html);

        // Flash rows that are new
        jobs.forEach(function (j) {
            if (!currentJobs[j.ID]) {
                $tbody.find('tr[data-id="' + j.ID + '"]').addClass('row-flash');
            }
        });

        currentJobs = nextJobs;
        updatePagination(paginator);
    }

    function buildRow(j) {
        var badge   = buildBadge(j.job_status);
        var avail   = j.availableDate  || '—';
        var reserved = j.reservedDate  ? j.reservedDate : '<span class="text-muted">—</span>';
        var created = j.createdDate    || '—';
        var jobType = escHtml(j.job_type || 'Unknown');

        return '<tr data-id="' + j.ID + '">' +
            '<td><span class="text-muted small">#</span>' + j.ID + '</td>' +
            '<td><code class="small">' + jobType + '</code></td>' +
            '<td><span class="badge bg-light text-dark border small">' + escHtml(j.queue) + '</span></td>' +
            '<td>' + badge + '</td>' +
            '<td>' + buildAttemptsBadge(j.attempts) + '</td>' +
            '<td class="small">' + avail + '</td>' +
            '<td class="small">' + reserved + '</td>' +
            '<td class="small">' + created + '</td>' +
            '<td><button class="btn btn-xs btn-outline-primary btn-detail" data-id="' + j.ID + '">' +
            '<i class="fas fa-eye me-1"></i>Detail</button></td>' +
            '</tr>';
    }

    function buildBadge(status) {
        var map = {
            pending:    ['badge-pending',    '⏳', 'Pending'],
            processing: ['badge-processing', '●',  'Processing'],
            delayed:    ['badge-delayed',    '⏱',  'Delayed'],
            stuck:      ['badge-stuck',      '⚠',  'Stuck'],
        };
        var cfg = map[status] || map.pending;
        return '<span class="badge-status ' + cfg[0] + '">' +
               '<span class="status-dot"></span>' + cfg[2] + '</span>';
    }

    function buildAttemptsBadge(attempts) {
        if (attempts === 0) return '<span class="text-muted">0</span>';
        if (attempts >= STUCK_THRESHOLD) {
            return '<span class="badge bg-danger rounded-pill">' + attempts + '</span>';
        }
        if (attempts >= 2) {
            return '<span class="badge bg-warning text-dark rounded-pill">' + attempts + '</span>';
        }
        return '<span class="badge bg-light text-dark border rounded-pill">' + attempts + '</span>';
    }

    // ── Pagination ─────────────────────────────────────────────────────────
    function updatePagination(p) {
        var from  = p.from  || 0;
        var to    = p.to    || 0;
        var total = p.total || 0;
        $('#pagination-info').text(
            total === 0 ? 'No results' :
            'Showing ' + from + '–' + to + ' of ' + total + ' jobs'
        );

        var $ctrl = $('#pagination-controls').empty();
        if (p.last_page <= 1) return;

        $ctrl.append(
            '<button class="btn btn-sm btn-outline-secondary" id="pg-prev" ' +
            (p.current_page <= 1 ? 'disabled' : '') + '>' +
            '<i class="fas fa-chevron-left"></i></button>'
        );

        // Show limited pages
        var start = Math.max(1, p.current_page - 2);
        var end   = Math.min(p.last_page, p.current_page + 2);
        for (var i = start; i <= end; i++) {
            $ctrl.append(
                '<button class="btn btn-sm ' +
                (i === p.current_page ? 'btn-primary' : 'btn-outline-secondary') +
                ' pg-num" data-page="' + i + '">' + i + '</button>'
            );
        }

        $ctrl.append(
            '<button class="btn btn-sm btn-outline-secondary" id="pg-next" ' +
            (p.current_page >= p.last_page ? 'disabled' : '') + '>' +
            '<i class="fas fa-chevron-right"></i></button>'
        );
    }

    // ── Activity Feed ──────────────────────────────────────────────────────
    function detectChanges(jobs, stats) {
        var currentIds = {};
        jobs.forEach(function (j) { currentIds[j.ID] = { status: j.job_status, attempts: j.attempts }; });

        // New jobs on current page
        Object.keys(currentIds).forEach(function (id) {
            if (!previousJobs[id]) {
                addFeedEntry('new', 'fas fa-plus-circle',
                    'Job <strong>#' + id + '</strong> added to queue',
                    currentJobs[id] ? currentJobs[id].job_type : '');
            } else {
                // Status changed
                if (previousJobs[id].status !== currentIds[id].status) {
                    addFeedEntry('status', 'fas fa-exchange-alt',
                        'Job <strong>#' + id + '</strong> changed to <em>' + currentIds[id].status + '</em>',
                        currentJobs[id] ? currentJobs[id].job_type : '');
                }
                // Attempts increased
                if (currentIds[id].attempts > previousJobs[id].attempts) {
                    addFeedEntry('attempts', 'fas fa-exclamation-triangle',
                        'Job <strong>#' + id + '</strong> attempts reached <strong>' + currentIds[id].attempts + '</strong>',
                        currentJobs[id] ? currentJobs[id].job_type : '');
                }
            }
        });

        // Jobs removed from current page
        Object.keys(previousJobs).forEach(function (id) {
            if (!currentIds[id]) {
                addFeedEntry('removed', 'fas fa-check-circle',
                    'Job <strong>#' + id + '</strong> removed from queue', '');
            }
        });

        // Stats changes summary
        if (previousStats) {
            var diff = stats.stuck - previousStats.stuck;
            if (diff > 0) {
                addFeedEntry('attempts', 'fas fa-exclamation-circle',
                    'Stuck jobs increased by <strong>' + diff + '</strong> (total: ' + stats.stuck + ')', '');
            }
        }

        previousJobs = currentIds;
    }

    function addFeedEntry(type, icon, msg, jobType) {
        var now   = new Date();
        var time  = pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());
        var typeStr = jobType ? '<span class="feed-type"> — ' + escHtml(jobType) + '</span>' : '';

        var html = '<div class="feed-entry">' +
            '<span class="feed-time">' + time + '</span>' +
            '<span class="feed-icon ' + type + '"><i class="' + icon + '"></i></span>' +
            '<span class="feed-msg">' + msg + typeStr + '</span>' +
            '</div>';

        $('#feed-empty').hide();
        $('#feed-entries').prepend(html);
        activityCount++;
        $('#feed-count').text(activityCount);

        // Keep max 50 entries
        var entries = $('#feed-entries .feed-entry');
        if (entries.length > 50) entries.last().remove();
    }

    // ── Detail Modal ───────────────────────────────────────────────────────
    function openDetail(id) {
        var j = currentJobs[id];
        if (!j) return;

        currentModalId = id;
        $('#modal-job-id').text('#' + id);
        $('#m-job-type').text(j.job_type   || '—');
        $('#m-job-full').text(j.job_full   || '—');
        $('#m-queue').text(j.queue         || '—');
        $('#m-uuid').text(j.job_uuid       || '—');
        $('#m-attempts').text(j.attempts + (j.attempts >= STUCK_THRESHOLD ? ' ⚠ High attempts' : ''));
        $('#m-created').text(j.createdDate   || '—');
        $('#m-available').text(j.availableDate || '—');
        $('#m-reserved').text(j.reservedDate  || '—');
        $('#m-status').html(buildBadge(j.job_status));
        $('#m-raw-payload').text(j.payload_clean || '—').hide();
        $('#btn-toggle-payload').html('<i class="fas fa-chevron-down me-1"></i>Show');

        // Mail info
        var mi  = j.mail_info || {};
        var mailHtml = '';
        if (mi.to)      mailHtml += buildInfoRow('To',      mi.to);
        if (mi.subject) mailHtml += buildInfoRow('Subject', mi.subject);
        $('#m-mail-info').html(mailHtml || '<span class="text-muted small">No mail info extractable from payload</span>');

        $('#job-detail-modal').modal('show');
    }

    function buildInfoRow(key, val) {
        return '<div class="info-row">' +
            '<span class="info-key">' + escHtml(key) + '</span>' +
            '<span class="info-val">' + escHtml(val) + '</span>' +
            '</div>';
    }

    // ── Delete Job ─────────────────────────────────────────────────────────
    function deleteJob(id, callback) {
        $.ajax({
            url    : '/admin/email-config/job-queue-log/' + id,
            type   : 'DELETE',
        }).done(function () {
            if (callback) callback();
            fetchData();
        }).fail(function () {
            alert('Failed to delete job #' + id);
        });
    }

    // ── Helpers ────────────────────────────────────────────────────────────
    function setLiveState(live) {
        if (live) {
            $('#live-indicator').removeClass('paused');
            $('#live-dot').css('animation', '');
            $('#live-label').text(isPaused ? 'PAUSED' : 'LIVE');
        } else {
            $('#live-label').text('ERROR');
        }
    }

    function escHtml(s) {
        if (!s) return '';
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    function pad(n) { return n < 10 ? '0' + n : n; }

    // ── Event Handlers ─────────────────────────────────────────────────────

    // Pause / Resume
    $('#btn-pause-resume').on('click', function () {
        isPaused = !isPaused;
        if (isPaused) {
            stopPolling();
            clearInterval(updateTimer);
            $(this).html('<i class="fas fa-play me-1"></i>Resume');
            $('#live-indicator').addClass('paused');
            $('#live-label').text('PAUSED');
            $('#last-updated-text').text('Polling paused');
        } else {
            $(this).html('<i class="fas fa-pause me-1"></i>Pause');
            $('#live-indicator').removeClass('paused');
            $('#live-label').text('LIVE');
            fetchData();
            startPolling();
        }
    });

    // Filters trigger immediate re-fetch on page 1
    $('#filter-status, #filter-queue').on('change', function () {
        currentPage = 1;
        fetchData();
    });

    var searchTimer;
    $('#filter-search').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () {
            currentPage = 1;
            fetchData();
        }, 400);
    });

    // Pagination prev/next
    $(document).on('click', '#pg-prev', function () {
        if (currentPage > 1) { currentPage--; fetchData(); }
    });
    $(document).on('click', '#pg-next', function () {
        currentPage++; fetchData();
    });
    $(document).on('click', '.pg-num', function () {
        currentPage = parseInt($(this).data('page'));
        fetchData();
    });

    // Open detail modal
    $(document).on('click', '.btn-detail', function () {
        openDetail($(this).data('id'));
    });

    // Delete job from modal
    $('#modal-btn-delete').on('click', function () {
        if (!currentModalId) return;
        if (!confirm('Delete job #' + currentModalId + '? This cannot be undone.')) return;
        deleteJob(currentModalId, function () {
            $('#job-detail-modal').modal('hide');
        });
    });

    // Delete stuck jobs
    $('#btn-delete-stuck').on('click', function () {
        if (!confirm('Delete ALL stuck jobs (attempts ≥ 3)? This cannot be undone.')) return;
        $.ajax({
            url  : '/admin/email-config/job-queue-log',
            type : 'DELETE',
        }).done(function (res) {
            addFeedEntry('removed', 'fas fa-trash-alt',
                'Deleted <strong>' + (res.deleted || 0) + '</strong> stuck jobs', '');
            fetchData();
        }).fail(function () {
            alert('Failed to delete stuck jobs.');
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

    // Clear activity feed
    $('#btn-clear-feed').on('click', function () {
        $('#feed-entries').empty();
        $('#feed-empty').show();
        activityCount = 0;
        $('#feed-count').text(0);
    });

    // Toggle feed collapse
    $('#btn-toggle-feed').on('click', function () {
        feedCollapsed = !feedCollapsed;
        if (feedCollapsed) {
            $('#feed-body').slideUp(200);
            $('#feed-toggle-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        } else {
            $('#feed-body').slideDown(200);
            $('#feed-toggle-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        }
    });

    // ── Init ───────────────────────────────────────────────────────────────

    // Init Select2 on filter dropdowns
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
