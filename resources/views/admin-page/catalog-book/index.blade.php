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
                <i class="fa fa-book me-2"></i>
                <span>LDK&nbsp;Syahid</span>
                <span class="highlighted-text ms-1">Book Catalog System</span>
            </h1>
            <div class="col-md-12 mb-3">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-plus-circle me-1"></i> How to Add a Book</h6>
                                <p class="card-text small text-muted">
                                    Click the <strong>"Add Book"</strong> button to add a new book to the catalog. Fill in all required fields including title, author, and ISBN.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-search me-1"></i> Search Feature</h6>
                                <p class="card-text small text-muted">
                                    Use the search filters in each column to find books more precisely.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-eye me-1"></i> View Details</h6>
                                <p class="card-text small text-muted">
                                    Click <i class="fa fa-eye small"></i> to view complete book details including description, cover image, and additional metadata.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-edit me-1"></i> Edit & Delete</h6>
                                <p class="card-text small text-muted">
                                    Click <i class="fa fa-edit small"></i> to edit book details (available for all roles). Only Superadmins are allowed to perform <i class="fa fa-trash small text-danger"></i> bulk delete.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 my-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.catalog.books.create') }}" class="btn btn-custom-primary">
                        <i class="fa fa-plus me-1"></i> Add Book
                    </a>
                </div>
                <div>
                    <button type="button" id="refreshBtn" class="btn btn-custom-primary me-2">
                        <i class="fa fa-sync-alt"></i> Refresh
                    </button>
                    <button type="button" id="clearFiltersBtn" class="btn btn-custom-primary">
                        <i class="fa fa-times"></i> Clear Filters
                    </button>
                </div>
            </div>

            <div class="table-responsive">
               <table class="table table-striped table-hover table-borderless text-nowrap align-middle table-books" id="dataBookTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" class="form-check-input m-0" {{ $isSuperadmin ? '' : 'disabled' }}>
                            </th>
                            <th class="text-start">No</th>
                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="createdDate">
                                        <span>Added Date</span>
                                        <span class="sort-arrow" id="sortArrowCreatedDate"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="added_date" class="form-control form-control-sm mt-1 daterangepicker-input" placeholder="Filter Added Date" value="{{ request('added_date') }}" autocomplete="off">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="isbn">
                                        <span>ISBN</span>
                                        <span class="sort-arrow" id="sortArrowIsbn"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="isbn" class="form-control form-control-sm mt-1 column-search" placeholder="Filter ISBN" value="{{ request('isbn') }}">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="titleBook">
                                        <span>Title</span>
                                        <span class="sort-arrow" id="sortArrowTitleBook"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="title" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Title" value="{{ request('title') }}">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="authorName">
                                        <span>Author</span>
                                        <span class="sort-arrow" id="sortArrowAuthorName"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="author" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Author" value="{{ request('author') }}">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="publisherName">
                                        <span>Publisher</span>
                                        <span class="sort-arrow" id="sortArrowPublisherName"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="publisher" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Publisher" value="{{ request('publisher') }}">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="categoryName">
                                        <span>Category</span>
                                        <span class="sort-arrow" id="sortArrowCategoryName"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="category" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Category" value="{{ request('category') }}">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="year">
                                        <span>Year</span>
                                        <span class="sort-arrow" id="sortArrowYear"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="year" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Year" value="{{ request('year') }}">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="bookTableBody">
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div id="showingInfo">
                    <p class="small text-muted mb-0">
                        @if ($books->count())
                            Showing {{ $books->firstItem() }}-{{ $books->lastItem() }} of {{ $books->total() }} books
                        @else
                            No data to display
                        @endif
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap" id="paginationContainer">
                    {{ $books->appends(request()->query())->links() }}
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
                <form id="bulkDeleteForm" action="{{ route('admin.catalog.books.bulkDelete') }}" method="POST" class="mb-0">
                    @csrf @method('POST')
                    <button type="button"
                            id="bulkDeleteBtn"
                            class="btn btn-danger btn-sm"
                            {{ $isSuperadmin ? '' : 'disabled title=Only Superadmin can perform bulk delete' }}>
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
    .table-books thead th {
        background-color: #00a79d !important;
        color: #fff !important;
        border-color: #00a79d !important;
        position: sticky;
        top: 0;
        z-index: 2;
    }
    .table-books tbody tr:hover {
        background-color: #e0f7f5 !important;
    }
    .table-books td,
    .table-books th {
        vertical-align: middle !important;
    }
    .table-books a {
        color: #00a79d;
        text-decoration: none;
    }
    .table-books a:hover {
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
    .table-books thead th a span {
        color: #fff !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
    }
    .table-books thead th a {
        text-decoration: none !important;
        display: inline-block;
        width: 100%;
    }
    .table-books {
        border-collapse: separate !important;
        border-spacing: 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: inset 0 0 12px rgba(0, 0, 0, 0.15);
    }
    .table-books thead th:first-child {
        border-top-left-radius: 10px;
    }
    .table-books thead th:last-child {
        border-top-right-radius: 10px;
    }
    .table-books tbody tr:last-child td:first-child {
        border-bottom-left-radius: 10px;
    }
    .table-books tbody tr:last-child td:last-child {
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
    .table-books input[type="text"]:focus,
    .table-books input[type="number"]:focus {
        border-color: #00a79d !important;
        box-shadow: 0 0 0 0.15rem rgba(0, 167, 157, 0.25) !important;
        outline: none !important;
    }
    .table-books input[type="text"]:hover,
    .table-books input[type="number"]:hover {
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

    #refreshBtn {
        min-width: 42px;
        align-items: center;
        justify-content: center;
    }

    #clearFiltersBtn {
        white-space: nowrap;
    }

    .skeleton-row {
        animation: pulse 1.5s infinite ease-in-out;
    }

    .skeleton {
        height: 20px;
        background: #e0f7f5;
        border-radius: 4px;
        margin: 5px 0;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    .table-books {
        table-layout: fixed;
    }
    .table-books th:nth-child(1),
    .table-books td:nth-child(1) { width: 50px; max-width: 50px; } /* Checkbox column */
    .table-books th:nth-child(2),
    .table-books td:nth-child(2) { width: 60px; max-width: 60px; } /* No column */
    .table-books th:nth-child(3),
    .table-books td:nth-child(3) { width: 120px; max-width: 120px; } /* Added Date */
    .table-books th:nth-child(4),
    .table-books td:nth-child(4) { width: 150px; max-width: 150px; } /* ISBN */
    .table-books th:nth-child(5),
    .table-books td:nth-child(5) { width: 250px; max-width: 250px; } /* Title */
    .table-books th:nth-child(6),
    .table-books td:nth-child(6) { width: 180px; max-width: 180px; } /* Author */
    .table-books th:nth-child(7),
    .table-books td:nth-child(7) { width: 180px; max-width: 180px; } /* Publisher */
    .table-books th:nth-child(8),
    .table-books td:nth-child(8) { width: 150px; max-width: 150px; } /* Category */
    .table-books th:nth-child(9),
    .table-books td:nth-child(9) { width: 80px; max-width: 80px; } /* Year */
    .table-books th:nth-child(10),
    .table-books td:nth-child(10) { width: 120px; max-width: 120px; } /* Action */

    .table-books td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .tooltip-inner {
        max-width: 500px;
        text-align: left;
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

    let sortBy = '{{ request("sort_by", "createdDate") }}';
    let sortOrder = '{{ request("sort_order", "desc") }}';
    let currentParams = {};

    $(document).ready(function() {
        currentParams = Object.fromEntries(new URLSearchParams(window.location.search));

        loadBooks();
        updateSortArrows();
        initColumnSearch();
        initDateRangePicker();

        $(document).ajaxComplete(function() {
            initColumnSearch();
        });

        function loadBooks(params = {}) {
            showLoading();

            const queryParams = {...currentParams, ...params};
            const queryString = new URLSearchParams(queryParams).toString();

            $.ajax({
                url: "{{ route('admin.catalog.books.indexAdmin') }}",
                type: 'GET',
                data: queryParams,
                success: function(response) {
                    if (response && typeof response === 'object') {
                        $('#bookTableBody').html(response.tableBody);
                        $('#paginationContainer').html(response.pagination);

                        if (response.total === 0) {
                            $('#showingInfo').html('<p class="small text-muted mb-0">No books found</p>');
                        } else {
                            $('#showingInfo').html(`<p class="small text-muted mb-0">Showing ${response.from}-${response.to} of ${response.total} books</p>`);
                        }
                    } else if (response) {
                        $('#bookTableBody').html(response);
                    } else {
                        showNoDataMessage();
                    }

                    $('#bookTableBody [data-bs-toggle="tooltip"]').tooltip('dispose');
                    $('#bookTableBody td').each(function() {
                        if (this.offsetWidth < this.scrollWidth) {
                            $(this).attr('data-bs-toggle', 'tooltip')
                                .attr('data-bs-placement', 'top')
                                .attr('title', $(this).text().trim());
                        }
                    });
                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    Toast.fire({
                        icon: 'error',
                        title: 'Error loading data'
                    });
                    showNoDataMessage();
                }
            });
        }

        function showNoDataMessage() {
            $('#bookTableBody').html(`
                <tr>
                    <td colspan="12" class="text-center py-4">
                        <div class="d-flex flex-column align-items-center">
                            <i class="fa fa-book-open fa-2x mb-2 text-muted"></i>
                            <span class="text-muted">No books found in the catalog</span>
                        </div>
                    </td>
                </tr>
            `);
            $('#showingInfo').html('<p class="small text-muted mb-0">No data available</p>');
            $('#paginationContainer').html('');
        }

        function showLoading() {
            let skeletonRows = '';
            for (let i = 0; i < 15; i++) {
                skeletonRows += `
                <tr class="skeleton-row">
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                    <td><div class="skeleton"></div></td>
                </tr>`;
            }
            $('#bookTableBody').html(skeletonRows);
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

        function initDateRangePicker() {
            $('input[name="added_date"]').daterangepicker({
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

            $('input[name="added_date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                currentParams.added_date = picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY');
                loadBooks();
            });

            $('input[name="added_date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                delete currentParams.added_date_start;
                delete currentParams.added_date_end;
                loadBooks();
            });
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

            currentParams.sort_by = sortBy;
            currentParams.sort_order = sortOrder;

            updateSortArrows();
            loadBooks();
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
                    delete currentParams[input.name];
                    loadBooks();
                });

                input.addEventListener('input', function() {
                    clearBtn.style.display = this.value ? 'block' : 'none';
                });
            });
        }

        $(document).on('keyup blur', '.column-search', function(e) {
            if (e.type === 'keyup' && e.key !== 'Enter') {
                return;
            }

            const value = $(this).val();
            const name = $(this).attr('name');

            if (value) {
                currentParams[name] = value;
            } else {
                delete currentParams[name];
            }

            loadBooks();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = new URL($(this).attr('href'));
            const page = url.searchParams.get('page');
            currentParams.page = page;
            loadBooks();
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

        $(document).on('click', '.delete-book-btn', function() {
            const bookId = $(this).data('id');

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
                        url: `{{ url('admin/catalog/books/') }}/${bookId}`,
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Book has been deleted!'
                            });
                            loadBooks();
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
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showCloseButton: true,
                width: '400px'
            });
        @endif

        @if(session('failed'))
            @if($errors->any())
                Toast.fire({
                    icon: 'error',
                    title: 'There were some problems with your input',
                    html: `
                        <ul class="text-start small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    `,
                    showCloseButton: true,
                    width: '500px'
                });
            @endif
        @endif

        function handleBulkDelete() {
            const checkboxes = $('input[name="ids[]"]:checked');
            const ids = checkboxes.map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No books selected',
                    text: 'Please select at least one book to delete.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete ${ids.length} book(s). This action cannot be undone!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.catalog.books.bulkDelete') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Selected books have been deleted!'
                            });
                            loadBooks();
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

        $('.column-search').each(function() {
            if ($(this).val()) {
                $(this).next('.column-search-clear').show();
            }
        });

        $('#refreshBtn').on('click', function() {
            loadBooks();
        });

        $('#clearFiltersBtn').on('click', function() {
            sortBy = 'createdDate';
            sortOrder = 'desc';

            currentParams = {
                sort_by: sortBy,
                sort_order: sortOrder,
                page: 1
            };

            $('.column-search').val('');
            $('input[name="added_date"]').val('');
            $('.column-search-clear').hide();
            updateSortArrows();

            loadBooks();
        });
    });
</script>
@endsection
