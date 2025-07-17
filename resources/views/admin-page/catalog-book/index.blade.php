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
                                    Use the search bar to look for books by <strong>title</strong>, <strong>author</strong>, <strong>publisher</strong>, <strong>ISBN</strong>, or <strong>category</strong>.
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

            <div class="col-md-12 my-3">
                <form action="{{ route('admin.catalog.books.indexAdmin') }}" method="GET">
                    <div class="input-group">
                        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search by title, author, publisher, ISBN, or category" value="{{ request('search') }}">
                        <button class="btn btn-custom-primary d-none" type="button" id="clearSearchBtn">
                            <i class="fa fa-times small"></i>
                        </button>
                        <button class="btn btn-custom-primary" type="submit">Search</button>
                    </div>
                </form>
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
                <table class="table table-striped table-hover table-borderless text-nowrap align-middle table-books" id="dataBookTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" class="form-check-input m-0" {{ $isSuperadmin ? '' : 'disabled' }}>
                            </th>
                            <th class="text-start">No</th>
                            <th class="text-center">
                                <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'isbn', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'isbn' ? 'desc' : 'asc'])) }}">
                                    <span>ISBN</span>
                                    @if(request('sort_by') === 'isbn')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'titleBook', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'titleBook' ? 'desc' : 'asc'])) }}">
                                    <span>Title</span>
                                    @if(request('sort_by') === 'titleBook')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'authorName', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'authorName' ? 'desc' : 'asc'])) }}">
                                    <span>Author</span>
                                    @if(request('sort_by') === 'authorName')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'publisherName', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'publisherName' ? 'desc' : 'asc'])) }}">
                                    <span>Publisher</span>
                                    @if(request('sort_by') === 'publisherName')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'categoryName', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'categoryName' ? 'desc' : 'asc'])) }}">
                                    <span>Category</span>
                                    @if(request('sort_by') === 'categoryName')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'readCount', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'readCount' ? 'desc' : 'asc'])) }}">
                                    <span>Reads</span>
                                    @if(request('sort_by') === 'readCount')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">
                                <a href="{{ route('admin.catalog.books.indexAdmin', array_merge(request()->all(), ['sort_by' => 'createdDate', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'createdDate' ? 'desc' : 'asc'])) }}">
                                    <span>Added Date</span>
                                    @if(request('sort_by') === 'createdDate')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($books as $key => $book)
                        <tr>
                            <td>
                                <input type="checkbox" name="ids[]" value="{{ $book->id }}" {{ $isSuperadmin ? '' : 'disabled' }}>
                            </td>
                            <th scope="row">{{ $books->firstItem() + $key }}</th>
                            <td class="text-center">{{ $book->isbn }}</td>
                            <td class="text-center">{{ $book->titleBook }}</td>
                            <td class="text-center">{{ $book->authorName }}</td>
                            <td class="text-center">{{ $book->publisherName }}</td>
                            <td class="text-center">{{ $book->categoryName }}</td>
                            <td class="text-center">{{ $book->readCount }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($book->createdDate)->isoFormat('DD MMMM YYYY') }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.catalog.books.show', $book->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.catalog.books.edit', $book->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-danger"
                                        onclick="{{ 'deleteConfirmationBook(' . $book->id . ')' }}"
                                        title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No books found in the catalog</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div>
                    @if ($books->count())
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
    #bulkDeleteBtn {
        min-width: 100px;
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
    @media (max-width: 576px) {
        .pagination {
            font-size: 0.8rem;
        }
        .pagination .page-link {
            padding: 0.25rem 0.5rem;
        }
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
        const searchInput = document.getElementById('searchInput');
        const clearSearchBtn = document.getElementById('clearSearchBtn');

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

        function toggleClearButton() {
            if (searchInput.value.trim() !== '') {
                clearSearchBtn.classList.remove('d-none');
            } else {
                clearSearchBtn.classList.add('d-none');
            }
        }

        searchInput.addEventListener('input', toggleClearButton);

        clearSearchBtn.addEventListener('click', function () {
            searchInput.value = '';
            toggleClearButton();
            searchInput.form.submit();
        });

        toggleClearButton();
    });
</script>
@endsection
