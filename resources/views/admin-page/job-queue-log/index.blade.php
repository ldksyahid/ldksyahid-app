@extends('admin-page.template.body')

@section('styles')
    @include('admin-page.job-queue-log.components._index-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">

        {{-- Page Header --}}
        <div class="col-12 mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 page-header">
                <div>
                    <h1 class="page-title mb-0">
                        <i class="fas fa-stream me-2"></i>Job Queue Log
                    </h1>
                    <p class="text-muted mb-0 mt-1 small d-none d-md-block">Monitor job queue in real-time</p>
                </div>
                <div class="d-flex align-items-center gap-2 gap-md-3 flex-wrap header-controls">
                    <div class="live-indicator" id="live-indicator">
                        <span class="live-dot" id="live-dot"></span>
                        <span class="live-label" id="live-label">LIVE</span>
                    </div>
                    <div class="worker-countdown" id="worker-countdown" style="display:none;">
                        <i class="fas fa-bolt"></i>
                        Worker in <span id="countdown-value">—</span>
                    </div>
                    <span class="text-muted small d-none d-sm-inline" id="last-updated-text">Connecting...</span>
                    <button class="btn btn-sm btn-outline-secondary btn-rounded" id="btn-pause-resume">
                        <i class="fas fa-pause me-1"></i>Pause
                    </button>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="col-12 mb-3">
            <div class="row g-3">
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-total"><i class="fas fa-layer-group"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-total">—</div>
                            <div class="stat-label">Total Jobs</div>
                            <div class="stat-sub">in queue</div>
                        </div>
                        <div class="stat-change" id="stat-total-change"></div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-pending"><i class="fas fa-clock"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-pending">—</div>
                            <div class="stat-label">Pending</div>
                            <div class="stat-sub">waiting to run</div>
                        </div>
                        <div class="stat-change" id="stat-pending-change"></div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-processing"><i class="fas fa-spinner fa-spin-pulse"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-processing">—</div>
                            <div class="stat-label">Processing</div>
                            <div class="stat-sub">in progress</div>
                        </div>
                        <div class="stat-change" id="stat-processing-change"></div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-delayed"><i class="fas fa-hourglass-half"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-delayed">—</div>
                            <div class="stat-label">Delayed</div>
                            <div class="stat-sub">scheduled</div>
                        </div>
                        <div class="stat-change" id="stat-delayed-change"></div>
                    </div>
                </div>
                <div class="col-6 col-lg">
                    <div class="stat-card">
                        <div class="stat-icon stat-icon-failed"><i class="fas fa-times-circle"></i></div>
                        <div class="stat-info">
                            <div class="stat-value" id="stat-failed">—</div>
                            <div class="stat-label">Failed</div>
                            <div class="stat-sub">permanently failed</div>
                        </div>
                        <div class="stat-change" id="stat-failed-change"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Estimated Completion Card --}}
        <div class="col-12 mb-3" id="eta-card-wrap" style="display:none;">
            <div class="eta-card">
                <div class="eta-icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <div class="eta-body">
                    <div class="eta-title">Estimated Completion</div>
                    <div class="eta-main" id="eta-main">—</div>
                    <div class="eta-meta" id="eta-meta"></div>
                </div>
                <div class="eta-detail">
                    <div class="eta-detail-row">
                        <span class="eta-detail-label"><i class="fas fa-paper-plane me-1"></i>Rate</span>
                        <span class="eta-detail-val" id="eta-rate">—</span>
                    </div>
                    <div class="eta-detail-row">
                        <span class="eta-detail-label"><i class="fas fa-calendar-day me-1"></i>Daily limit</span>
                        <span class="eta-detail-val" id="eta-daily">300 / day</span>
                    </div>
                    <div class="eta-detail-row">
                        <span class="eta-detail-label"><i class="fas fa-envelope me-1"></i>Remaining</span>
                        <span class="eta-detail-val" id="eta-remaining">—</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gmail Daily Limit Banner --}}
        <div class="col-12 mb-3" id="daily-limit-banner" style="display:none;">
            <div class="daily-limit-alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Gmail Daily Sending Limit Active</strong>
                        <div class="small mt-1">
                            Email jobs are paused until the limit resets.
                            <span id="daily-limit-job-count" class="fw-semibold"></span> job(s) waiting.
                            Attempts will increase but these jobs are <strong>not stuck</strong> — they will resume automatically.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Bar --}}
        <div class="col-12 mb-3">
            <div class="filter-bar">
                <select id="filter-status">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="delayed">Delayed</option>
                    <option value="daily_limit">Daily Limit</option>
                    <option value="stuck">Stuck</option>
                    <option value="failed">Failed</option>
                </select>
                <select id="filter-queue">
                    <option value="all">All Queues</option>
                </select>
                <input type="text" class="form-control form-control-sm filter-search" id="filter-search"
                    placeholder="Search job type...">
                <div class="d-flex gap-1 ms-auto filter-actions">
                    <button class="btn btn-sm btn-outline-danger btn-rounded" id="btn-delete-stuck">
                        <i class="fas fa-trash-alt me-1"></i>Delete Stuck
                    </button>
                    <button class="btn btn-sm btn-outline-success btn-rounded" id="btn-retry-all-failed" style="display:none;">
                        <i class="fas fa-redo me-1"></i>Retry All
                    </button>
                    <button class="btn btn-sm btn-outline-danger btn-rounded" id="btn-delete-all-failed" style="display:none;">
                        <i class="fas fa-trash-alt me-1"></i>Delete All Failed
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="col-12 mb-3">
            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-sm align-middle mb-0" id="jobs-table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    ID
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Unique identifier of the job in the queue"></i>
                                </th>
                                <th class="text-center">
                                    Job Type
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="The class name of the queued job (e.g. SendSingleMailJob)"></i>
                                </th>
                                <th class="text-center">
                                    Queue
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Queue channel name this job is assigned to"></i>
                                </th>
                                <th class="text-center">
                                    Status
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Pending = waiting, Processing = reserved by worker, Delayed = scheduled for later, Daily Limit = paused by Gmail limit, Stuck = attempts ≥ 8 (likely failing)"></i>
                                </th>
                                <th class="text-center">
                                    Attempts
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="How many times this job has been tried. High numbers may indicate repeated failures"></i>
                                </th>
                                <th class="text-center">
                                    Available Date
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="The earliest date this job is allowed to be picked up and processed by the worker"></i>
                                </th>
                                <th class="text-center">
                                    Reserved Date
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="The date the worker reserved this job. Empty means it has not been picked up yet"></i>
                                </th>
                                <th class="text-center">
                                    Created Date
                                    <i class="fas fa-info-circle tooltip-icon"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="The date this job was first added to the queue"></i>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="jobs-tbody">
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-spinner fa-spin me-2"></i>Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="table-pagination d-flex align-items-center justify-content-between flex-wrap gap-2" id="pagination-bar">
                    <span class="text-muted small" id="pagination-info"></span>
                    <div class="d-flex gap-1 flex-wrap" id="pagination-controls"></div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Job Detail Modal --}}
<div class="modal fade" id="job-detail-modal" tabindex="-1" aria-labelledby="jobDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content jql-modal-content">
            <div class="modal-header jql-modal-header">
                <h5 class="modal-title text-white" id="jobDetailModalLabel">
                    <i class="fas fa-stream me-2"></i>
                    Job Details &mdash; <span id="modal-job-id">—</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Job Class</div>
                            <div class="detail-value fw-semibold" id="m-job-type">—</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Full Class</div>
                            <div class="detail-value font-monospace small text-break" id="m-job-full">—</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Queue</div>
                            <div class="detail-value" id="m-queue">—</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">UUID</div>
                            <div class="detail-value font-monospace small text-break" id="m-uuid">—</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-group">
                            <div class="detail-label">Status</div>
                            <div id="m-status">—</div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Attempts</div>
                            <div class="detail-value" id="m-attempts">—</div>
                        </div>
                    </div>

                    <div class="col-12" id="m-exception-section" style="display:none;">
                        <div class="detail-section-title">EXCEPTION</div>
                        <pre class="raw-payload" id="m-exception" style="display:block; max-height:180px;"></pre>
                    </div>

                    <div class="col-12">
                        <div class="detail-section-title">MAIL INFO</div>
                        <div class="detail-infobox" id="m-mail-info">
                            <span class="text-muted small">No mail info available</span>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="detail-section-title">TIMESTAMPS</div>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="detail-label">Created Date</div>
                                <div class="detail-value small" id="m-created">—</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">Available Date</div>
                                <div class="detail-value small" id="m-available">—</div>
                            </div>
                            <div class="col-md-4">
                                <div class="detail-label">Reserved Date</div>
                                <div class="detail-value small" id="m-reserved">—</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="detail-section-title d-flex align-items-center justify-content-between">
                            <span>RAW PAYLOAD</span>
                            <button class="btn btn-xs btn-outline-secondary btn-rounded" id="btn-toggle-payload">
                                <i class="fas fa-chevron-down me-1"></i>Show
                            </button>
                        </div>
                        <pre id="m-raw-payload" class="raw-payload" style="display:none;"></pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-success btn-rounded" id="modal-btn-retry" style="display:none;">
                    <i class="fas fa-redo me-1"></i>Retry Job
                </button>
                <button type="button" class="btn btn-sm btn-outline-danger btn-rounded" id="modal-btn-delete">
                    <i class="fas fa-trash-alt me-1"></i>Delete Job
                </button>
                <button type="button" class="btn btn-sm btn-secondary btn-rounded" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('admin-page.job-queue-log.components._index-scripts')
@endsection
