@extends('admin-page.template.body')

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
    $isSuperadmin = LFC::getRoleName(auth()->user()->getRoleNames()) === 'Superadmin';
@endphp
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-link me-2"></i>
                <span>LDK&nbsp;Syahid</span>
                <span class="highlighted-text ms-1">Shortlink System</span>
            </h1>
            <div class="col-md-12 mb-3">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-magic me-1"></i> How to Create a Shortlink</h6>
                                <p class="card-text small text-muted">
                                    Enter the complete URL you wish to shorten, click <strong>"Shorten"</strong>, and afterward, feel free to edit the shortlink according to your needs.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-search me-1"></i> Search Feature</h6>
                                <p class="card-text small text-muted">
                                    You can now search in each column by typing in the search field below each column header.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-copy me-1"></i> Copy Link</h6>
                                <p class="card-text small text-muted">
                                    Click the <i class="fa fa-copy small"></i> icon next to the shortlink to copy it to your clipboard.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-edit me-1"></i> Edit & Delete</h6>
                                <p class="card-text small text-muted">
                                    Click <i class="fa fa-edit small"></i> to edit a shortlink (available for all roles), or <i class="fa fa-trash small text-danger"></i> to delete it (only Superadmins are allowed to delete).
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 my-3">
                <form id="shortenForm">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="url" class="form-control" placeholder="Enter URL to shorten" required>
                        <button class="btn btn-custom-primary" type="submit">Shorten</button>
                    </div>
                </form>
            </div>

            <div class="col-md-12 my-3">
                <div id="alertContainer"></div>
            </div>

            <div class="table-responsive">
                <form id="searchForm">
                    <table class="table table-striped table-hover table-borderless text-nowrap align-middle small table-shortlink" id="dataShortlinkTable">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" class="form-check-input m-0" {{ $isSuperadmin ? '' : 'disabled' }}>
                                </th>
                                <th class="text-start">No</th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="sort-link" data-sort-by="url_key">
                                            <span>URL Key</span>
                                            <span class="sort-arrow" id="sortArrowUrlKey"></span>
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="url_key" class="form-control form-control-sm mt-1 column-search" placeholder="Search URL Key" value="{{ request('url_key') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="sort-link" data-sort-by="destination_url">
                                            <span>URL Destination</span>
                                            <span class="sort-arrow" id="sortArrowDestinationUrl"></span>
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="destination_url" class="form-control form-control-sm mt-1 column-search" placeholder="Search Destination" value="{{ request('destination_url') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="sort-link" data-sort-by="default_short_url">
                                            <span>Short URL</span>
                                            <span class="sort-arrow" id="sortArrowDefaultShortUrl"></span>
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="default_short_url" class="form-control form-control-sm mt-1 column-search" placeholder="Search Short URL" value="{{ request('default_short_url') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="sort-link" data-sort-by="visits_count">
                                            <span>Visitors</span>
                                            <span class="sort-arrow" id="sortArrowVisitsCount"></span>
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="visits_count" class="form-control form-control-sm mt-1 column-search" placeholder="Search Visitors" value="{{ request('visits_count') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="sort-link" data-sort-by="created_at">
                                            <span>Created At</span>
                                            <span class="sort-arrow" id="sortArrowCreatedAt"></span>
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="created_at" class="form-control form-control-sm mt-1 daterangepicker-input" placeholder="Filter Created At" value="{{ request('created_at') }}" autocomplete="off">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="sort-link" data-sort-by="created_by">
                                            <span>Creator</span>
                                            <span class="sort-arrow" id="sortArrowCreatedBy"></span>
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="created_by" class="form-control form-control-sm mt-1 column-search" placeholder="Search Creator" value="{{ request('created_by') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="shortlinkTableBody">
                            @include('admin-page.service.short-link._index_table', ['urls' => $urls])
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div>
                    <p class="small text-muted mb-0 result-count">
                        @if ($urls->count())
                            Showing {{ $urls->firstItem() }}-{{ $urls->lastItem() }} of {{ $urls->total() }} shortlinks
                        @else
                            No data to display
                        @endif
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap" id="paginationContainer">
                    {{ $urls->appends(request()->query())->links() }}
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
                <form id="bulkDeleteForm">
                    @csrf
                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger btn-sm" {{ $isSuperadmin ? '' : 'disabled title=Only Superadmin can perform bulk delete' }}>
                        Bulk Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    .table-shortlink thead th {
        background-color: #00a79d !important;
        color: #fff !important;
        border-color: #00a79d !important;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .table-shortlink tbody tr:hover {
        background-color: #e0f7f5 !important;
    }
    .table-shortlink td,
    .table-shortlink th {
        vertical-align: middle !important;
    }
    .table-shortlink a {
        color: #00a79d;
        text-decoration: none;
    }
    .table-shortlink a:hover {
        text-decoration: underline;
        color: #008b84;
    }
    .pagination .page-link {
        color: #00a79d;
    }
    .pagination .page-link:hover {
        background-color: #e0f7f5;
        color: #008b84;
    }
    .pagination .page-item.active .page-link {
        background-color: #00a79d;
        color: #fff;
    }
    .pagination .page-link:focus {
        box-shadow: none;
    }
    .btn-custom-primary {
        color: #fff;
        background-color: #00a79d;
        border: 1px solid #00a79d;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background-color: #008b84;
        border-color: #008b84;
        color: #fff;
    }
    .btn-custom-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .text-secondary {
        color: #191C24 !important;
    }
    .input-group input:focus {
        box-shadow: none !important;
        border-color: #00a79d !important;
        outline: none;
    }
    .table-shortlink thead th a span {
        color: #fff !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
    }
    .table-shortlink thead th a {
        text-decoration: none !important;
        display: inline-block;
        width: 100%;
    }
    .table-shortlink {
        border-collapse: separate !important;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: inset 0 0 12px rgba(0, 0, 0, 0.15);
    }
    .table-shortlink thead th:first-child {
        border-top-left-radius: 10px;
    }
    .table-shortlink thead th:last-child {
        border-top-right-radius: 10px;
    }
    .table-shortlink tbody tr:last-child td:first-child {
        border-bottom-left-radius: 10px;
    }
    .table-shortlink tbody tr:last-child td:last-child {
        border-bottom-right-radius: 10px;
    }
    .sort-arrow {
        color: #fff !important;
        font-weight: bold;
    }
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.0rem;
    }
    .page-title {
        font-size: 1.65rem;
        font-weight: 600;
        text-align: center;
        color: #00a79d;
        margin: .75rem 0 1.5rem;
        position: relative;
        display: inline-block;
    }
    .page-title .highlighted-text {
        color: #008b84;
        font-weight: 700;
    }
    .page-title::after {
        content: '';
        display: block;
        height: 4px;
        width: 120px;
        margin: .35rem auto 0;
        border-radius: 3px;
        background: linear-gradient(90deg,#00a79d 0%,#008b84 100%);
    }
    .text-custom {
        color: #00a79d;
    }
    .card .card-title {
        font-size: 0.95rem;
    }
    .card .card-text {
        font-size: 0.8rem;
    }
    .card-guide {
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .card-guide:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
        cursor: pointer;
    }
    .pagination .page-item {
        flex: 0 0 auto;
    }
    .form-control-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    .table-shortlink input[type="text"]:focus,
    .table-shortlink input[type="number"]:focus {
        border-color: #00a79d !important;
        box-shadow: 0 0 0 0.15rem rgba(0, 167, 157, 0.25) !important;
        outline: none !important;
    }
    .table-shortlink input[type="text"]:hover,
    .table-shortlink input[type="number"]:hover {
        border-color: #00a79d;
    }
    #bulkDeleteBtn {
        min-width: 100px;
    }
    .position-relative {
        position: relative;
    }
    .column-search-clear {
        position: absolute;
        right: 5px;
        top: 60%;
        transform: translateY(-50%);
        background: transparent;
        border: none;
        color: #6c757d;
        cursor: pointer;
        display: none;
    }
    .column-search-clear:hover {
        color: #495057;
    }
    .daterangepicker {
        font-family: inherit;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        border: 1px solid #e0e0e0;
    }
    .daterangepicker td.active,
    .daterangepicker td.active:hover {
        background-color: #00a79d;
    }
    .daterangepicker .drp-buttons .btn {
        padding: 5px 15px;
        border-radius: 4px;
        font-size: 0.875rem;
    }
    .daterangepicker .drp-buttons .btn.applyBtn {
        background-color: #00a79d;
        border-color: #00a79d;
    }
    .daterangepicker .drp-buttons .btn.applyBtn:hover {
        background-color: #008b84;
        border-color: #008b84;
    }
    .daterangepicker .drp-buttons .btn.cancelBtn {
        color: #495057;
    }
    .daterangepicker .drp-buttons .btn.cancelBtn:hover {
        background-color: #f8f9fa;
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        width: '350px',
    });

    let sortBy = '{{ request("sort_by", "created_at") }}';
    let sortOrder = '{{ request("sort_order", "desc") }}';

    $(document).ready(function() {
        updateSortArrows();
        initColumnSearch();

        $(document).ajaxComplete(function() {
            initColumnSearch();
        });

        function loadShortlinks(params = {}) {
            $('#shortlinkTableBody').html('<tr><td colspan="9" class="text-center">Loading...</td></tr>');

            params.sort_by = sortBy;
            params.sort_order = sortOrder;

            $.ajax({
                url: "{{ route('admin.service.shortlink.index') }}",
                data: params,
                success: function(response) {
                    if (response) {
                        if (response.tableBody) {
                            $('#shortlinkTableBody').html(response.tableBody);
                        } else if (response) {
                            $('#shortlinkTableBody').html(response);
                        } else {
                            $('#shortlinkTableBody').html('<tr><td colspan="9" class="text-center">Error loading data</td></tr>');
                        }

                        if (response.pagination) {
                            $('#paginationContainer').html(response.pagination);
                        } else {
                            $('#paginationContainer').empty();
                        }

                        if (response.from !== null && response.to !== null && response.total !== null) {
                            $('.result-count').text(`Showing ${response.from}-${response.to} of ${response.total} shortlinks`);
                        } else if (response.total === 0) {
                            $('.result-count').text('No data to display');
                        }
                    } else {
                        console.error('Empty response received');
                        $('#shortlinkTableBody').html('<tr><td colspan="9" class="text-center">Error: Empty response from server</td></tr>');
                    }
                },
                error: function(xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error loading data'
                    });
                    $('#shortlinkTableBody').html('<tr><td colspan="9" class="text-center">Error loading data</td></tr>');
                }
            });
        }

        function updateSortArrows() {
            $('.sort-arrow').html('');
            if (sortBy) {
                const arrowElement = $(`#sortArrow${sortBy.charAt(0).toUpperCase() + sortBy.slice(1)}`);
                if (arrowElement.length) {
                    arrowElement.html(sortOrder === 'asc' ? '↑' : '↓');
                }
            }
        }

        $(document).on('click', '.sort-link', function(e) {
            e.preventDefault();
            const newSortBy = $(this).data('sort-by');

            if (sortBy === newSortBy) {
                sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
            } else {
                sortBy = newSortBy;
                sortOrder = 'desc';
            }

            updateSortArrows();
            loadShortlinks($('#searchForm').serializeArray());
        });

        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            loadShortlinks($(this).serializeArray());
        });

        $('input[name="created_at"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'DD-MM-YYYY',
                separator: ' - ',
                applyLabel: 'Apply',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            },
            opens: 'right',
            drops: 'down'
        });

        $('input[name="created_at"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            loadShortlinks($('#searchForm').serializeArray());
        });

        $('input[name="created_at"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            loadShortlinks($('#searchForm').serializeArray());
        });

        function initColumnSearch() {
            document.querySelectorAll('.column-search').forEach(input => {
                if (input.nextElementSibling && input.nextElementSibling.classList.contains('column-search-clear')) {
                    return;
                }

                const clearBtn = document.createElement('button');
                clearBtn.innerHTML = '<i class="fa fa-times"></i>';
                clearBtn.className = 'column-search-clear';
                clearBtn.style.display = input.value ? 'block' : 'none';
                clearBtn.type = 'button';

                input.insertAdjacentElement('afterend', clearBtn);

                clearBtn.addEventListener('click', function() {
                    input.value = '';
                    this.style.display = 'none';
                    loadShortlinks($('#searchForm').serializeArray());
                });

                input.addEventListener('input', function() {
                    clearBtn.style.display = this.value ? 'block' : 'none';
                });

                input.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') {
                        loadShortlinks($('#searchForm').serializeArray());
                    }
                });
            });
        }

        $(document).on('click', '.column-search-clear', function() {
            const input = $(this).prev('.column-search');
            input.val('');
            $(this).hide();
            loadShortlinks($('#searchForm').serializeArray());
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = new URL($(this).attr('href'));
            const page = url.searchParams.get('page');
            loadShortlinks([...$('#searchForm').serializeArray(), {name: 'page', value: page}]);
        });

        $('#selectAll').on('change', function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
            updateBulkDeleteButton();
        });

        $(document).on('change', 'input[name="ids[]"]', function() {
            updateBulkDeleteButton();

            const allChecked = $('input[name="ids[]"]:checked').length === $('input[name="ids[]"]').length;
            $('#selectAll').prop('checked', allChecked);
        });

        function updateBulkDeleteButton() {
            const anyChecked = $('input[name="ids[]"]:checked').length > 0;
            $('#bulkDeleteBtn').prop('disabled', !anyChecked);
        }

        function copyLink(urlKey) {
            const fullUrl = new URL(`{{ url('/') }}/${urlKey}`);
            const linkWithoutProtocol = `${fullUrl.host}${fullUrl.pathname}`;
            navigator.clipboard.writeText(linkWithoutProtocol).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Link copied to clipboard!'
                });
            }).catch(() => {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to copy link'
                });
            });
        }

        function deleteConfirmationShortlink(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: `{{ url('admin/service/shortlink') }}/${id}`,
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Shortlink has been deleted!'
                            });
                            loadShortlinks($('#searchForm').serializeArray());
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        function handleBulkDelete() {
            const checkboxes = $('input[name="ids[]"]:checked');
            const ids = checkboxes.map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No shortlinks selected',
                    text: 'Please select at least one shortlink to delete.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${ids.length} shortlink(s). This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.service.shortlink.bulkDelete') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Selected shortlinks have been deleted!'
                            });
                            loadShortlinks($('#searchForm').serializeArray());
                            $('#selectAll').prop('checked', false);
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Something went wrong.',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        $('#bulkDeleteBtn').on('click', handleBulkDelete);

        $('#shortenForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');

            submitBtn.prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.service.shortlink.shorten') }}",
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'URL shortened successfully!'
                    });
                    form.trigger('reset');
                    loadShortlinks($('#searchForm').serializeArray());
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        for (const field in errors) {
                            errorMessages += errors[field][0] + '<br>';
                        }

                        $('#alertContainer').html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>There were some problems with your input:</strong><br>
                                ${errorMessages}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to shorten URL'
                        });
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                }
            });
        });

        $(document).on('submit', '.edit-form', function(e) {
            e.preventDefault();
            const form = $(this);
            const id = form.data('id');
            const submitBtn = form.find('button[type="submit"]');

            submitBtn.prop('disabled', true);
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').text('');

            $.ajax({
                url: `{{ url('admin/service/shortlink') }}/${id}`,
                type: "POST",
                data: form.serialize(),
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: 'Shortlink updated successfully!'
                    });
                    $(`#editModal-${id}`).modal('hide');
                    loadShortlinks($('#searchForm').serializeArray());
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            const input = form.find(`[name="${field}"]`);
                            const feedback = form.find(`.${field}-feedback`);
                            input.addClass('is-invalid');
                            feedback.text(errors[field][0]);
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Failed to update shortlink'
                        });
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false);
                }
            });
        });

        $('.column-search').each(function() {
            if ($(this).val()) {
                $(this).next('.column-search-clear').show();
            }
        });
    });
</script>
@endsection
