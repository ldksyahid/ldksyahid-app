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
                                    <a href="#" class="sort-link" data-sort-by="bookCategoryID">
                                        <span>Category</span>
                                        <span class="sort-arrow" id="sortArrowBookCategoryID"></span>
                                    </a>
                                    <div class="position-relative">
                                        <select name="category" class="form-control form-control-sm mt-1 column-search" style="width: 100%">
                                            <option value="">All Categories</option>
                                            @foreach($bookCategories as $category)
                                                <option value="{{ $category->bookCategoryName }}" 
                                                    {{ request('category') == $category->bookCategoryName ? 'selected' : '' }}>
                                                    {{ $category->bookCategoryName }}
                                                </option>
                                            @endforeach
                                        </select>
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
    @include('admin-page.catalog-book.components._index._index-styles')
@endsection

@section('scripts')
    @include('admin-page.catalog-book.components._index._index-scripts')
@endsection
