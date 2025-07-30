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
                                <h6 class="card-title text-custom fw-bold">
                                    <i class="fa fa-copy me-1"></i> Copy Values
                                </h6>
                                <p class="card-text small text-muted">
                                    Click the <i class="fa fa-copy small"></i> icon next to the URL Key, Destination URL, or Short URL to copy the value to your clipboard.
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

            <div class="col-md-12">
                <form id="shortenForm">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="url" class="form-control" placeholder="Enter URL to shorten">
                        <button class="btn btn-custom-primary" type="submit">Shorten</button>
                    </div>
                </form>
            </div>

           <div class="col-md-12 my-3 d-flex justify-content-end">
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
                <form id="searchForm" action="{{ route('admin.service.shortlink.index') }}" method="GET">
                    <table class="table table-striped table-hover table-borderless text-nowrap align-middle small table-shortlink" id="dataShortlinkTable">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" id="selectAll" class="form-check-input m-0" {{ $isSuperadmin ? '' : 'disabled' }}>
                                </th>
                                <th class="text-start">No</th>

                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort="url_key">
                                        <span>URL Key</span>
                                        <span class="sort-arrow" id="url_key_arrow"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm mt-1 column-search" data-column="url_key" placeholder="Search URL Key">
                                    </div>
                                </div>
                            </th>

                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort="destination_url">
                                        <span>URL Destination</span>
                                        <span class="sort-arrow" id="destination_url_arrow"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm mt-1 column-search" data-column="destination_url" placeholder="Search Destination">
                                    </div>
                                </div>
                            </th>

                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort="default_short_url">
                                        <span>Short URL</span>
                                        <span class="sort-arrow" id="default_short_url_arrow"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm mt-1 column-search" data-column="default_short_url" placeholder="Search Short URL">
                                    </div>
                                </div>
                            </th>

                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort="visits_count">
                                        <span>Visitors</span>
                                        <span class="sort-arrow" id="visits_count_arrow"></span>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle visits-dropdown" type="button" id="visitsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span id="visitsDropdownLabel">All Visitors</span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end visits-dropdown-menu" aria-labelledby="visitsDropdown">
                                            <li><h6 class="dropdown-header">Visitor Range</h6></li>
                                            <li><a class="dropdown-item visits-option" href="#" data-range="">All Visitors</a></li>
                                            <li><hr class="dropdown-divider m-0"></li>
                                            <li><a class="dropdown-item visits-option" href="#" data-range="0-10">0 - 10 visitors</a></li>
                                            <li><a class="dropdown-item visits-option" href="#" data-range="11-50">11 - 50 visitors</a></li>
                                            <li><a class="dropdown-item visits-option" href="#" data-range="51-100">51 - 100 visitors</a></li>
                                            <li><a class="dropdown-item visits-option" href="#" data-range="101-500">101 - 500 visitors</a></li>
                                            <li><a class="dropdown-item visits-option" href="#" data-range="501-1000">501 - 1000 visitors</a></li>
                                            <li><a class="dropdown-item visits-option" href="#" data-range="1001+">1000+ visitors</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </th>

                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort="created_at">
                                        <span>Created At</span>
                                        <span class="sort-arrow" id="created_at_arrow"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" name="created_at" class="form-control form-control-sm mt-1 date-range-filter" placeholder="Filter Created At" value="{{ request('created_at') }}" autocomplete="off">
                                    </div>
                                </div>
                            </th>

                            <th class="text-center">
                                <div class="d-flex flex-column">
                                    <a href="#" class="sort-link" data-sort="created_by">
                                        <span>Creator</span>
                                        <span class="sort-arrow" id="created_by_arrow"></span>
                                    </a>
                                    <div class="position-relative">
                                        <input type="text" class="form-control form-control-sm mt-1 column-search" data-column="created_by" placeholder="Search Creator">
                                    </div>
                                </div>
                            </th>

                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="shortlinkTableBody">
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div id="showingInfo">
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap" id="paginationLinks">
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
                <form id="bulkDeleteForm" method="POST" class="mb-0">
                    @csrf
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

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title fw-semibold text-white">
                    <i class="fas fa-pencil-alt me-2"></i>Edit Shortlink
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editForm">
                    @csrf
                    <input type="hidden" name="id" id="editId">

                    <div class="mb-4">
                        <label for="editUrl" class="form-label fw-semibold text-dark">
                            <i class="fas fa-key me-2 text-primary"></i>URL Key
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-link text-primary"></i>
                            </span>
                            <input type="text" name="url" class="form-control border-start-0" id="editUrl" placeholder="e.g. yusuf">
                        </div>
                        <small class="text-muted mt-1 d-block">Customize your short URL identifier</small>
                    </div>

                    <div class="mb-4">
                        <label for="editDestination" class="form-label fw-semibold text-dark">
                            <i class="fas fa-external-link-alt me-2 text-primary"></i>Destination URL
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-globe text-primary"></i>
                            </span>
                            <input type="text" name="destination" class="form-control border-start-0" id="editDestination" placeholder="e.g. https://example.com">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
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
    .table-shortlink thead th .form-control-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        height: calc(1.5em + 0.5rem + 2px);
    }
    .table-shortlink thead th .form-control-sm:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .position-relative {
        position: relative;
    }
    .position-absolute {
        position: absolute;
    }
    .end-0 {
        right: 0;
    }
    .top-50 {
        top: 50%;
    }
    .translate-middle-y {
        transform: translateY(-50%);
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
    }
    .table-shortlink th:nth-child(1),
    .table-shortlink td:nth-child(1) { width: 50px; max-width: 50px; }
    .table-shortlink th:nth-child(2),
    .table-shortlink td:nth-child(2) { width: 60px; max-width: 60px; }
    .table-shortlink th:nth-child(3),
    .table-shortlink td:nth-child(3) { width: 300px; max-width: 300px; }
    .table-shortlink th:nth-child(4),
    .table-shortlink td:nth-child(4) { width: 350px; max-width: 350px; }
    .table-shortlink th:nth-child(5),
    .table-shortlink td:nth-child(5) { width: 400px; max-width: 400px; }
    .table-shortlink th:nth-child(6),
    .table-shortlink td:nth-child(6) { width: 180px; max-width: 180px; }
    .table-shortlink th:nth-child(7),
    .table-shortlink td:nth-child(7) { width: 225px; max-width: 225px; }
    .table-shortlink th:nth-child(8),
    .table-shortlink td:nth-child(8) { width: 120px; max-width: 120px; }
    .table-shortlink th:nth-child(9),
    .table-shortlink td:nth-child(9) { width: 100px; max-width: 100px; }
    .table-shortlink td {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .table-shortlink {
        table-layout: fixed;
    }
    .tooltip-inner {
        max-width: 500px;
        text-align: left;
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
    .modal-content {
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #00a79d 0%, #008b84 100%);
        border-bottom: none;
    }
    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    .modal-title {
        font-size: 1.25rem;
        letter-spacing: 0.5px;
    }
    .modal-body {
        padding: 1.75rem;
    }
    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #495057;
    }
    .btn-light:hover {
        background-color: #e9ecef;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .modal.fade .modal-dialog {
        animation: fadeIn 0.3s ease-out;
    }
    /* Visits Dropdown Styles */
    .visits-dropdown {
        background-color: white;
        border: 1px solid #dee2e6;
        color: #495057;
        width: 100%;
        text-align: left;
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        transition: all 0.2s ease;
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .visits-dropdown::after {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
    }

    .visits-dropdown:hover {
        background-color: #f8f9fa;
    }

    .visits-dropdown:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
        border-color: #00a79d;
    }

    .visits-dropdown-menu {
        min-width: 160px;
        max-width: 200px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 0;
    }

    .visits-dropdown-menu .dropdown-header {
        font-size: 0.7rem;
        font-weight: 600;
        color: #00a79d;
        padding: 0.25rem 0.75rem;
    }

    .visits-dropdown-menu .dropdown-item {
        font-size: 0.75rem;
        padding: 0.35rem 0.75rem;
        color: #212529;
        transition: all 0.2s ease;
        white-space: normal;
        word-wrap: break-word;
    }

    .visits-dropdown-menu .dropdown-item:hover,
    .visits-dropdown-menu .dropdown-item:focus {
        background-color: #e0f7f5;
        color: #008b84;
    }

    .visits-dropdown-menu .dropdown-item.active {
        background-color: #00a79d;
        color: white;
    }

    .visits-dropdown-menu .dropdown-divider {
        margin: 0;
        border-color: #e9ecef;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function() {
        const baseUrl = '{{ url('/') }}';
        let currentParams = {
            sort_by: 'created_at',
            sort_order: 'desc'
        };

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            width: '400px',
        });

        loadTableData();

        function loadTableData() {
            showLoading();

            $.ajax({
                url: '{{ route("admin.service.shortlink.index") }}',
                type: 'GET',
                data: currentParams,
                success: function(response) {
                    $('#shortlinkTableBody').html(response.html);
                    $('#paginationLinks').html(response.pagination);

                    const showingInfo = `Showing ${response.showing.first}–${response.showing.last} of ${response.total} shortlinks`;
                    $('#showingInfo').html(`<p class="small text-muted mb-0">${showingInfo}</p>`);

                    updateSortArrows();

                    $('#shortlinkTableBody [data-bs-toggle="tooltip"]').tooltip('dispose');
                    $('#shortlinkTableBody td').each(function() {
                        if (this.offsetWidth < this.scrollWidth) {
                            $(this).attr('data-bs-toggle', 'tooltip')
                                .attr('data-bs-placement', 'top')
                                .attr('title', $(this).text().trim());
                        }
                    });
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    $('#shortlinkTableBody .btn').each(function() {
                        const title = $(this).attr('title') || $(this).data('original-title');
                        if (title) {
                            $(this).tooltip({
                                placement: 'top',
                                trigger: 'hover'
                            });
                        }
                    });
                },
                error: function(xhr) {
                    showAlert('danger', 'Error loading data');
                }
            });
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
                </tr>`;
            }

            $('#shortlinkTableBody').html(skeletonRows);
        }

        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            $('#alertContainer').html(alertHtml);

            setTimeout(() => {
                $('.alert').alert('close');
            }, 10000);
        }

        function updateSortArrows() {
            $('.sort-arrow').html('');
            if (currentParams.sort_by) {
                const arrow = currentParams.sort_order === 'asc' ? '↑' : '↓';
                $(`#${currentParams.sort_by}_arrow`).html(arrow);
            }
        }

        $(document).on('click', '.sort-link', function(e) {
            e.preventDefault();
            const sortBy = $(this).data('sort');

            if (currentParams.sort_by === sortBy) {
                currentParams.sort_order = currentParams.sort_order === 'asc' ? 'desc' : 'asc';
            } else {
                currentParams.sort_by = sortBy;
                currentParams.sort_order = 'desc';
            }

            loadTableData();
        });

        document.querySelectorAll('.column-search').forEach(input => {
            const clearBtn = document.createElement('button');
            clearBtn.innerHTML = '<i class="fa fa-times"></i>';
            clearBtn.className = 'column-search-clear';
            clearBtn.style.display = input.value ? 'block' : 'none';

            clearBtn.addEventListener('click', function() {
                input.value = '';
                this.style.display = 'none';
            });

            const wrapper = input.parentNode;
            wrapper.appendChild(clearBtn);

            input.addEventListener('input', function() {
                clearBtn.style.display = this.value ? 'block' : 'none';
            });
        });

        $(document).on('keyup blur', '.column-search', function(e) {
            const value = $(this).val();

            if (!value) return;

            if (e.type === 'keyup' && e.key !== 'Enter') {
                return;
            }

            const column = $(this).data('column');
            currentParams[column] = value;

            loadTableData();
        });

        $(document).on('click', '.column-search-clear', function() {
            const input = $(this).siblings('.column-search');
            input.val('');
            const column = input.data('column');
            delete currentParams[column];
            loadTableData();
        });

        $('#shortenForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route("admin.service.shortlink.shorten") }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                        showCloseButton: true,
                        timer: 1500,
                        width: '400px'
                    });
                    $('#shortenForm')[0].reset();
                    loadTableData();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        for (const field in errors) {
                            errorMessages += errors[field].join('<br>') + '<br>';
                        }

                        Toast.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            showCloseButton: true,
                            timer: 4500,
                            timerProgressBar: true,
                            width: '500px'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error shortening URL',
                            showCloseButton: true,
                            timer: 4500,
                            timerProgressBar: true,
                            width: '500px'
                        });
                    }
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const url = $(this).data('url');
            const destination = $(this).data('destination');

            $('#editId').val(id);
            $('#editUrl').val(url);
            $('#editDestination').val(destination);

            $('#editModal').modal('show');
        });

        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            const id = $('#editId').val();

            $.ajax({
                url: `/admin/service/shortlink/${id}`,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message,
                        showCloseButton: true,
                        timer: 1500,
                        width: '400px'
                    });
                    loadTableData();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        for (const field in errors) {
                            errorMessages += errors[field].join('<br>') + '<br>';
                        }

                        Toast.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMessages,
                            showCloseButton: true,
                            timer: 4500,
                            timerProgressBar: true,
                            width: '500px'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'Error updating URL',
                            showCloseButton: true,
                            timer: 4500,
                            timerProgressBar: true,
                            width: '500px'
                        });
                    }
                },
                complete: function() {
                    $('#editModal').modal('hide');
                }
            });
        });

        $(document).on('click', '.delete-btn', function() {
            const id = $(this).data('id');

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
                        url: `/admin/service/shortlink/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message,
                                showCloseButton: true,
                                timer: 1500,
                                width: '400px'
                            });
                            loadTableData();
                        },
                        error: function(xhr) {
                            Toast.fire({
                                icon: 'error',
                                title: 'Error deleting URL',
                                text: xhr.responseJSON?.message || 'Something went wrong',
                                showCloseButton: true,
                                timer: 4500,
                                timerProgressBar: true,
                                width: '500px'
                            });
                        }
                    });
                }
            });
        });

        $('#selectAll').on('change', function() {
            $('input[name="ids[]"]').prop('checked', this.checked);
            toggleBulkDeleteButton();
        });

        $(document).on('change', 'input[name="ids[]"]', function() {
            toggleBulkDeleteButton();

            const totalCheckboxes = $('input[name="ids[]"]').length;
            const checkedCheckboxes = $('input[name="ids[]"]:checked').length;
            $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
        });

        function toggleBulkDeleteButton() {
            const anyChecked = $('input[name="ids[]"]:checked').length > 0;
            $('#bulkDeleteBtn').prop('disabled', !anyChecked);
        }

        $('#bulkDeleteBtn').on('click', function() {
            const ids = $('input[name="ids[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                showAlert('danger', 'Please select at least one item to delete.');
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
                        url: '{{ route("admin.service.shortlink.bulkDelete") }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids
                        },
                        success: function(response) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message,
                                showCloseButton: true,
                                timer: 1500,
                                width: '400px'
                            });
                            loadTableData();
                            $('#selectAll').prop('checked', false);
                        },
                        error: function(xhr) {
                            showAlert('danger', 'Error deleting URLs');
                        }
                    });
                }
            });
        });

        window.copyLink = function(urlKey, withBaseUrl = true) {
            let fullLink;

            if (withBaseUrl) {
                fullLink = `${baseUrl}/${urlKey}`;
            } else {
                fullLink = urlKey;
            }

            navigator.clipboard.writeText(fullLink).then(() => {
                Toast.fire({
                    icon: 'success',
                    title: 'Copied to clipboard!',
                    showCloseButton: true,
                    timer: 1500,
                    width: '400px'
                });
            }).catch(err => {
                Toast.fire({
                    icon: 'error',
                    title: 'Failed to copy text',
                    showCloseButton: true,
                    timer: 3000
                });
            });
        };

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const page = url.split('page=')[1];
            currentParams.page = page;
            loadTableData();
        });

        $('.date-range-filter').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD-MM-YYYY',
                cancelLabel: 'Clear',
                applyLabel: 'Apply',
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

        $('.date-range-filter').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            currentParams.created_at_start = picker.startDate.format('DD-MM-YYYY');
            currentParams.created_at_end = picker.endDate.format('DD-MM-YYYY');
            loadTableData();
        });

        $('.date-range-filter').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            delete currentParams.created_at_start;
            delete currentParams.created_at_end;
            loadTableData();
        });

        $(document).on('click', '.visits-option', function(e) {
            e.preventDefault();
            const range = $(this).data('range');
            const label = $(this).text().trim();

            $('#visitsDropdownLabel').text(label.split(' ')[0] === 'All' ? 'All Visitors' : label);

            if (range) {
                currentParams.visits_range = range;
            } else {
                delete currentParams.visits_range;
            }

            loadTableData();
        });

       $(document).on('shown.bs.dropdown', '#visitsDropdown', function() {
            const currentRange = currentParams.visits_range || '';
            $('.visits-option').removeClass('active');
            $(`.visits-option[data-range="${currentRange}"]`).addClass('active');
        });

        $('#refreshBtn').on('click', function() {
            loadTableData();
        });

        $('#clearFiltersBtn').on('click', function() {
            currentParams = {
                sort_by: 'created_at',
                sort_order: 'desc'
            };

            $('.column-search').val('');
            $('.date-range-filter').val('');
            $('.column-search-clear').hide();
            $('#visitsDropdownLabel').text('All Visitors');

            loadTableData();
        });
    });
</script>
@endsection
