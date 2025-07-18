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

            <div class="col-md-2 my-3 text-start">
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
                    @if ($errors->any()))
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
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'isbn', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'isbn' ? 'desc' : 'asc'])) }}">
                                            <span>ISBN</span>
                                            @if(request('sort_by') === 'isbn'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="isbn" class="form-control form-control-sm mt-1 column-search" placeholder="Filter ISBN" value="{{ request('isbn') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'titleBook', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'titleBook' ? 'desc' : 'asc'])) }}">
                                            <span>Title</span>
                                            @if(request('sort_by') === 'titleBook'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="title" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Title" value="{{ request('title') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'authorName', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'authorName' ? 'desc' : 'asc'])) }}">
                                            <span>Author</span>
                                            @if(request('sort_by') === 'authorName'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="author" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Author" value="{{ request('author') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'publisherName', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'publisherName' ? 'desc' : 'asc'])) }}">
                                            <span>Publisher</span>
                                            @if(request('sort_by') === 'publisherName'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="publisher" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Publisher" value="{{ request('publisher') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'categoryName', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'categoryName' ? 'desc' : 'asc'])) }}">
                                            <span>Category</span>
                                            @if(request('sort_by') === 'categoryName'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="category" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Category" value="{{ request('category') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'language', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'language' ? 'desc' : 'asc'])) }}">
                                            <span>Language</span>
                                            @if(request('sort_by') === 'language'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="language" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Language" value="{{ request('language') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'year', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'year' ? 'desc' : 'asc'])) }}">
                                            <span>Year</span>
                                            @if(request('sort_by') === 'year'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="year" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Year" value="{{ request('year') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'readCount', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'readCount' ? 'desc' : 'asc'])) }}">
                                            <span>Reads</span>
                                            @if(request('sort_by') === 'readCount'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="reads" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Reads" value="{{ request('reads') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'createdDate', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'createdDate' ? 'desc' : 'asc'])) }}">
                                            <span>Added Date</span>
                                            @if(request('sort_by') === 'createdDate'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="added_date" class="form-control form-control-sm mt-1 column-search" placeholder="Filter Added Date" value="{{ request('added_date') }}">
                                        </div>
                                    </div>
                                </th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($books as $key => $book)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $book->bookID }}" {{ $isSuperadmin ? '' : 'disabled' }}>
                                </td>
                                <th scope="row">{{ $books->firstItem() + $key }}</th>
                                <td class="text-center">{{ $book->isbn }}</td>
                                <td class="text-center">{{ $book->titleBook }}</td>
                                <td class="text-center">{{ $book->authorName }}</td>
                                <td class="text-center">{{ $book->publisherName }}</td>
                                <td class="text-center">{{ $book->categoryName }}</td>
                                <td class="text-center">{{ $book->language }}</td>
                                <td class="text-center">{{ $book->year }}</td>
                                <td class="text-center">{{ $book->readCount }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($book->createdDate)->isoFormat('DD MMMM YYYY') }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.catalog.books.show', $book->bookID) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.catalog.books.edit', $book->bookID) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-danger"
                                            onclick="{{ 'deleteConfirmationBook(' . $book->bookID . ')' }}"
                                            title="Delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">No books found in the catalog</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div>
                    @if ($books->count()))
                        <p class="small text-muted mb-0">
                            Showing {{ $books->firstItem() }}–{{ $books->lastItem() }} of {{ $books->total() }} books
                        </p>
                    @else
                        <p class="small text-muted mb-0">No data to display</p>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
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
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        width: '350px',
    });

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
                    url: `{{ url('admin/catalog/books/${id}') }}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Book has been deleted!'
                        });
                        setTimeout(function () { location.reload(); }, 300);
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
        const checkboxes = document.querySelectorAll('input[name="ids[]"]:checked');
        const ids = Array.from(checkboxes).map(checkbox => checkbox.value);

        if (ids.length === 0) {
            alert('Please select at least one book to delete.');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: `{{ route('admin.catalog.books.bulkDelete') }}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Selected books have been deleted!'
                        });
                        location.reload();
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

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.column-search').forEach(input => {
            const clearBtn = document.createElement('button');
            clearBtn.innerHTML = '<i class="fa fa-times"></i>';
            clearBtn.className = 'column-search-clear';
            clearBtn.style.display = input.value ? 'block' : 'none';

            clearBtn.addEventListener('click', function() {
                input.value = '';
                this.style.display = 'none';
                document.getElementById('searchForm').submit();
            });

            const wrapper = input.parentNode;
            wrapper.appendChild(clearBtn);

            input.addEventListener('input', function() {
                clearBtn.style.display = this.value ? 'block' : 'none';
            });

            input.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('searchForm').submit();
                }
            });
        });

        document.getElementById('selectAll')?.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });

        document.querySelectorAll('input[name="ids[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const anyChecked = document.querySelectorAll('input[name="ids[]"]:checked').length > 0;
                document.getElementById('bulkDeleteBtn').disabled = !anyChecked;
            });
        });

        document.getElementById('bulkDeleteBtn')?.addEventListener('click', handleBulkDelete);
    });
</script>
@endsection
