@extends('admin-page.template.body')

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="my-2 fs-4 fw-bold text-center text-secondary">LDK Syahid URL Shortener Management System</h1>

            <div class="col-md-8 my-3">
                <form action="{{ route('admin.service.shortlink.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" id="searchInput" name="search" class="form-control" placeholder="Search by URL Key, URL Destination, Short URL, or Created By" value="{{ request('search') }}">
                        <button class="btn btn-custom-primary d-none" type="button" id="clearSearchBtn">
                            <i class="fa fa-times small"></i>
                        </button>
                        <button class="btn btn-custom-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>

            <div class="col-md-4 my-3">
                <form action="{{ route('admin.service.shortlink.shorten') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="input-group">
                        <input type="text" name="url" class="form-control" placeholder="Enter URL to shorten">
                        <button class="btn btn-custom-primary" type="submit">Shorten</button>
                    </div>
                </form>
            </div>

            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover table-borderless text-nowrap align-middle small table-shortlink" id="dataShortlinkTable">
                    <thead>
                        <tr>
                            @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
                                <th><input type="checkbox" id="selectAll" class="form-check-input m-0"></th>
                            @endif
                            <th class="text-start">No</th>

                            <th class="text-center">
                                <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'url_key', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'url_key' ? 'desc' : 'asc'])) }}">
                                    <span>URL Key</span>
                                    @if(request('sort_by') === 'url_key')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>

                            <th class="text-center">
                                <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'destination_url', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'destination_url' ? 'desc' : 'asc'])) }}">
                                    <span>URL Destination</span>
                                    @if(request('sort_by') === 'destination_url')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>

                            <th class="text-center">
                                <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'default_short_url', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'default_short_url' ? 'desc' : 'asc'])) }}">
                                    <span>Short URL</span>
                                    @if(request('sort_by') === 'default_short_url')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>

                            <th class="text-center">
                                <a href="{{ route('admin.service.shortlink.index',
                                        array_merge(request()->all(), [
                                            'sort_by'   => 'visits_count',
                                            'sort_order'=> request('sort_order') === 'asc' && request('sort_by') === 'visits_count' ? 'desc' : 'asc'
                                        ])) }}">
                                    <span>Visitors</span>
                                    @if(request('sort_by') === 'visits_count')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>

                            <th class="text-center">
                                <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'created_at' ? 'desc' : 'asc'])) }}">
                                    <span>Created At</span>
                                    @if(request('sort_by') === 'created_at')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>

                            <th class="text-center">
                                <a href="{{ route('admin.service.shortlink.index', array_merge(request()->all(), ['sort_by' => 'created_by', 'sort_order' => request('sort_order') === 'asc' && request('sort_by') === 'created_by' ? 'desc' : 'asc'])) }}">
                                    <span>Created By</span>
                                    @if(request('sort_by') === 'created_by')
                                        {!! request('sort_order') === 'asc' ? '<span class="sort-arrow">↑</span>' : '<span class="sort-arrow">↓</span>' !!}
                                    @endif
                                </a>
                            </th>

                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($urls as $key => $item)
                        <tr>
                            @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
                                <td><input type="checkbox" name="ids[]" value="{{ $item->id }}"></td>
                            @endif
                            <th scope="row">{{ ++$key }}</th>
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
                                @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
                                    <button type="button" onclick="deleteConfirmationShortlink({{ $item->id }})" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                @endif
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
                            <td colspan="9" class="text-center">No URL Shortener Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $urls->appends(['search' => request('search')])->links() }}
            </div>

            @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
            <div class="text-end mt-3">
                <form id="bulkDeleteForm" action="{{ route('admin.service.shortlink.bulkDelete') }}" method="POST">
                    @csrf
                    @method('POST')
                    <button type="button" id="bulkDeleteBtn" class="btn btn-danger">Bulk Delete</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
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
    .sort-arrow {
        color: #fff !important;
        font-weight: bold;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
