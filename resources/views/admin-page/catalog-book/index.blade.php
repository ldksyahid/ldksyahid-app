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

            <div class="col-md-12 my-3 text-end">
                <a href="{{ route('admin.catalog.books.create') }}" class="btn btn-custom-primary">
                    <i class="fa fa-plus me-1"></i> Add Book
                </a>
            </div>

            <div class="col-md-12 my-3">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('failed'))
                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>There were some problems with your input:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                @endif
            </div>

            <div class="table-responsive">
                <form id="searchForm" action="{{ route('admin.catalog.books.indexAdmin') }}" method="GET">
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
                            @include('admin-page.catalog-book.components._index-table', ['books' => $books])
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div>
                    <p class="small text-muted mb-0 result-count">
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

    $(document).ready(function() {
        updateSortArrows();
        initColumnSearch();

        $(document).ajaxComplete(function() {
            initColumnSearch();
        });


        function loadBooks(params = {}) {
            $('#bookTableBody').html('<tr><td colspan="12" class="text-center">Loading...</td></tr>');

            params.sort_by = sortBy;
            params.sort_order = sortOrder;

            $.ajax({
                url: "{{ route('admin.catalog.books.indexAdmin') }}",
                data: params,
                success: function(response) {
                    if (response) {
                        if (response.tableBody) {
                            $('#bookTableBody').html(response.tableBody);
                        } else if (response) {
                            $('#bookTableBody').html(response);
                        } else {
                            $('#bookTableBody').html('<tr><td colspan="12" class="text-center">Error loading data</td></tr>');
                        }

                        if (response.pagination) {
                            $('#paginationContainer').html(response.pagination);
                        } else {
                            $('#paginationContainer').empty();
                        }

                        if (response.from !== null && response.to !== null && response.total !== null) {
                            $('.result-count').text(`Showing ${response.from}-${response.to} of ${response.total} books`);
                        } else if (response.total === 0) {
                            $('.result-count').text('No data to display');
                        }
                    } else {
                        console.error('Empty response received');
                        $('#bookTableBody').html('<tr><td colspan="12" class="text-center">Error: Empty response from server</td></tr>');
                    }
                },
                error: function(xhr) {
                    Toast.fire({
                        icon: 'error',
                        title: 'Error loading data'
                    });
                    $('#bookTableBody').html('<tr><td colspan="12" class="text-center">Error loading data</td></tr>');
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
            loadBooks($('#searchForm').serializeArray());
        });

        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            loadBooks($(this).serializeArray());
        });

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
            loadBooks($('#searchForm').serializeArray());
        });

        $('input[name="added_date"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            loadBooks($('#searchForm').serializeArray());
        });

        $('.column-search').on('keyup', function(e) {
            if (e.key === 'Enter') {
                loadBooks($('#searchForm').serializeArray());
            }
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
                    loadBooks($('#searchForm').serializeArray());
                });

                input.addEventListener('input', function() {
                    clearBtn.style.display = this.value ? 'block' : 'none';
                });

                input.addEventListener('keyup', function(e) {
                    if (e.key === 'Enter') {
                        loadBooks($('#searchForm').serializeArray());
                    }
                });
            });
        }

        $(document).on('click', '.column-search-clear', function() {
            const input = $(this).prev('.column-search');
            input.val('');
            $(this).hide();
            loadBooks($('#searchForm').serializeArray());
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = new URL($(this).attr('href'));
            const page = url.searchParams.get('page');
            loadBooks([...$('#searchForm').serializeArray(), {name: 'page', value: page}]);
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

        function deleteConfirmationBook(id) {
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
                        url: `{{ url('admin/catalog/books/') }}/${id}`,
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(data) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Book has been deleted!'
                            });
                            loadBooks($('#searchForm').serializeArray());
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
                            loadBooks($('#searchForm').serializeArray());
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
    });
</script>
@endsection
