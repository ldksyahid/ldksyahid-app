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
                <i class="fa fa-file-invoice-dollar me-2"></i>
                <span>LDK&nbsp;Syahid</span>
                <span class="highlighted-text ms-1">Finance Report System</span>
            </h1>

            <!-- GUIDE CARDS SECTION -->
            <div class="col-md-12 mb-3">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-plus-circle me-1"></i> How to Add a Report</h6>
                                <p class="card-text small text-muted">
                                    Click the <strong>"Add Report"</strong> button to add a new finance report. Fill in all required fields including file name and select LDK.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-search me-1"></i> Search Feature</h6>
                                <p class="card-text small text-muted">
                                    Use the search filters in each column to find reports more precisely.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-eye me-1"></i> View Details</h6>
                                <p class="card-text small text-muted">
                                    Click <i class="fa fa-eye small"></i> to view complete report details including file information and LDK details.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card card-guide h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-custom fw-bold"><i class="fa fa-edit me-1"></i> Edit & Bulk Delete</h6>
                                <p class="card-text small text-muted">
                                    Click <i class="fa fa-edit small"></i> to edit report details. Only Superadmins can perform <i class="fa fa-trash small text-danger"></i> bulk delete.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END GUIDE CARDS SECTION -->

            <div class="col-md-12 my-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.finance-report.create') }}" class="btn btn-custom-primary">
                        <i class="fa fa-plus me-1"></i> Add Report
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
               <table class="table table-striped table-hover table-borderless text-nowrap align-middle table-reports" id="dataReportTable">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll" class="form-check-input m-0" {{ $isSuperadmin ? '' : 'disabled' }}>
                            </th>
                            <th class="text-start" width="50">No</th>
                            <th class="text-center" width="150">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="createdDate">
                                        <span>Created Date</span>
                                        <span class="sort-arrow" id="sortArrowCreatedDate"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="created_date" class="form-control form-control-sm mt-1 daterangepicker-input" placeholder="Filter Created Date" value="{{ request('created_date') }}" autocomplete="off">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center" width="250">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort-by="fileName">
                                        <span>File Name</span>
                                        <span class="sort-arrow" id="sortArrowFileName"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="file_name" class="form-control form-control-sm mt-1 column-search" placeholder="Filter File Name" value="{{ request('file_name') }}">
                                    </div>
                                </div>
                            </th>
                            <th class="text-center" width="150">
                                <div class="d-flex flex-column">
                                    <span>Tag</span>
                                    <div class="position-relative">
                                        <select name="ldk_tag" class="form-control form-control-sm mt-1 column-search" style="width: 100%">
                                            <option value="">All Tags</option>
                                            @foreach($ldkTags as $tag)
                                                <option value="{{ $tag }}"
                                                    {{ request('ldk_tag') == $tag ? 'selected' : '' }}>
                                                    {{ $tag }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </th>
                            <th class="text-center" width="120">Action</th>
                        </tr>
                    </thead>
                    <tbody id="reportTableBody">
                        @include('admin-page.finance-report.components._index._index-table')
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div id="showingInfo">
                    <p class="small text-muted mb-0">
                        @if ($financeReports->count())
                            Showing {{ $financeReports->firstItem() }}-{{ $financeReports->lastItem() }} of {{ $financeReports->total() }} reports
                        @else
                            No data to display
                        @endif
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap" id="paginationContainer">
                    {{ $financeReports->appends(request()->query())->links() }}
                </div>
            </div>

            <!-- Bulk Delete Button Section -->
            <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
                <form id="bulkDeleteForm" action="{{ route('admin.finance-report.bulk-delete') }}" method="POST" class="mb-0">
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
    @include('admin-page.finance-report.components._index._index-styles')
@endsection

@section('scripts')
    @include('admin-page.finance-report.components._index._index-scripts')
@endsection
