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
                <form action="{{ route('admin.service.shortlink.shorten') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="input-group">
                        <input type="text" name="url" class="form-control" placeholder="Enter URL to shorten">
                        <button class="btn btn-custom-primary" type="submit">Shorten</button>
                    </div>
                </form>
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
                                        <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'url_key', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'url_key' ? 'desc' : 'asc'])) }}">
                                            <span>URL Key</span>
                                            @if(request('sort_by') === 'url_key'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="url_key" class="form-control form-control-sm mt-1 column-search" placeholder="Search URL Key" value="{{ request('url_key') }}">
                                        </div>
                                    </div>
                                </th>

                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'destination_url', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'destination_url' ? 'desc' : 'asc'])) }}">
                                            <span>URL Destination</span>
                                            @if(request('sort_by') === 'destination_url'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="destination_url" class="form-control form-control-sm mt-1 column-search" placeholder="Search Destination" value="{{ request('destination_url') }}">
                                        </div>
                                    </div>
                                </th>

                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'default_short_url', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'default_short_url' ? 'desc' : 'asc'])) }}">
                                            <span>Short URL</span>
                                            @if(request('sort_by') === 'default_short_url'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="default_short_url" class="form-control form-control-sm mt-1 column-search" placeholder="Search Short URL" value="{{ request('default_short_url') }}">
                                        </div>
                                    </div>
                                </th>

                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'visits_count', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'visits_count' ? 'desc' : 'asc'])) }}">
                                            <span>Visitors</span>
                                            @if(request('sort_by') === 'visits_count'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="visits_count" class="form-control form-control-sm mt-1 column-search" placeholder="Search Visitors" value="{{ request('visits_count') }}">
                                        </div>
                                    </div>
                                </th>

                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'created_at' ? 'desc' : 'asc'])) }}">
                                            <span>Created At</span>
                                            @if(request('sort_by') === 'created_at'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="created_at" class="form-control form-control-sm mt-1 daterangepicker-input" placeholder="Filter Created At" value="{{ request('created_at') }}" autocomplete="off">
                                        </div>
                                    </div>
                                </th>

                                <th class="text-center">
                                    <div class="d-flex flex-column">
                                        <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'created_by', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'created_by' ? 'desc' : 'asc'])) }}">
                                            <span>Creator</span>
                                            @if(request('sort_by') === 'created_by'))
                                                {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                            @endif
                                        </a>
                                        <div class="position-relative">
                                            <input type="text" name="created_by" class="form-control form-control-sm mt-1 column-search" placeholder="Search Creator" value="{{ request('created_by') }}">
                                        </div>
                                    </div>
                                </th>

                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($urls as $key => $item)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $item->id }}" {{ $isSuperadmin ? '' : 'disabled' }}>
                                </td>
                                <th scope="row">{{ $urls->firstItem() + $key }}</th>
                                <td class="text-center">{{ $item->url_key }}</td>
                                <td class="text-center"><a href="{{ $item->destination_url }}" target="_blank">{{ $item->destination_url }}</a></td>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="copyLink('{{ $item->url_key }}')">
                                        <i class="fa fa-copy small"></i>
                                    </button>
                                    <a href="{{ url($item->url_key) }}" target="_blank">{{ parse_url(url($item->url_key), PHP_URL_HOST) }}{{ parse_url(url($item->url_key), PHP_URL_PATH) }}</a>
                                </td>
                                <td class="text-center">{{ $item->visits->count() }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('YYYY') }} ({{ \Carbon\Carbon::parse( $item->created_at )->format('H:i T') }})</td>
                                <td class="text-center">{{ $item->created_by ?? 'Undefined' }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $key }}"><i class="fa fa-edit"></i></button>
                                    <button type="button"
                                        class="btn btn-sm btn-danger"
                                        onclick="{{ $isSuperadmin ? 'deleteConfirmationShortlink(' . $item->id . ')' : 'void(0)' }}"
                                        {{ $isSuperadmin ? '' : 'disabled' }}>
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal-{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('admin.service.shortlink.update', $item->id) }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="key" class="form-label">URL Key</label>
                                                    <input type="text" name="url" value="{{ $item->url_key }}" class="form-control" id="key">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="destination" class="form-label">Destination URL</label>
                                                    <input type="text" name="destination" value="{{ $item->destination_url }}" class="form-control" id="destination">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">No Shortlink Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                <div>
                    @if ($urls->count())
                        <p class="small text-muted mb-0">
                            Showing {{ $urls->firstItem() }}–{{ $urls->lastItem() }} of {{ $urls->total() }} shortlinks
                        </p>
                    @else
                        <p class="small text-muted mb-0">No data to display</p>
                    @endif
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    {{ $urls->appends(request()->query())->links() }}
                </div>
            </div>

            <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
                <form id="bulkDeleteForm" action="{{ route('admin.service.shortlink.bulkDelete') }}" method="POST" class="mb-0">
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
    const baseUrl = '{{ url('/') }}';

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        width: '350px',
    });

    function copyLink(urlKey) {
        const fullLink = new URL(`${baseUrl}/${urlKey}`);
        const linkWithoutProtocol = `${fullLink.host}${fullLink.pathname}`;
        const input = document.createElement('input');
        input.value = linkWithoutProtocol;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        Toast.fire({
            icon: 'success',
            title: 'Link copied to clipboard!'
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
                    type: "GET",
                    url: `{{ url('${id}/destroy') }}`.replace('${id}', id),
                    success: function(data) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Shortlink has been deleted!'
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
            alert('Please select at least one item to delete.');
            return;
        }

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
                    type: "POST",
                    url: `{{ route('admin.service.shortlink.bulkDelete') }}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        ids: ids
                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Selected shortlinks have been deleted!'
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

    $(document).ready(function() {
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
            $('#searchForm').submit();
        });

        $('input[name="created_at"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#searchForm').submit();
        });

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
