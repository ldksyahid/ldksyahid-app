@extends('admin-page.template.body')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
@endsection

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded  justify-content-center mx-0">
        <div class="row">
            <h1 class="my-2 fs-4 fw-bold text-center">LDK Syahid URL Shortener Management System</h1>
            <form action="{{ route('admin.service.shortlink.shorten') }}" method="POST" class="my-2">
                @csrf
                @method('POST')
                <div class="input-group mb-3">
                    <input type="text" name="url" class="form-control" placeholder="URL Shortener">
                    <button class="btn btn-outline-secondary" type="submit">Shorten</button>
                </div>
            </form>
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover table-striped text-nowrap small" id="dataShortlinkTable">
                    <thead>
                        <tr class="small">
                            <th scope="col" class="text-start">No</th>
                            <th scope="col" class="text-center">URL Key</th>
                            <th scope="col" class="text-center">URL Destination</th>
                            <th scope="col" class="text-center">Short URL</th>
                            <th scope="col" class="text-center">Visitors</th>
                            <th scope="col" class="text-center">Created At</th>
                            <th scope="col" class="text-center">Created By</th>
                            <th scope="col" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($urls as $key => $item)
                        <tr class="small">
                            <th scope="row">{{ ++$key }}</th>
                            <td align="center">{{ $item->url_key }}</td>
                            <td align="center"><a href="{{ $item->destination_url }}" target="_blank">{{ $item->destination_url }}</a></td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="copyLink(`ldksyah.id/{{ $item->url_key }}`)"><i class="fa fa-copy small"></i></button>
                                <a href="{{ $item->default_short_url }}" target="_blank">ldksyah.id/{{ $item->url_key }}</a>
                            </td>
                            <td align="center">{{ $item->visits->count() }}</td>
                            <td align="center">{{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $item->created_at )->isoFormat('YYYY') }} ({{ \Carbon\Carbon::parse( $item->created_at )->format('H:i T') }})</td>
                            @if ($item->created_by != null)
                                <td align="center">{{ $item->created_by }}</td>
                            @else
                                <td align="center">Undifined</td>
                            @endif
                            <td align="center">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-{{ $key }}"><i class="fa fa-edit"></i></button>
                                @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
                                    <button type="button" onclick="deleteConfirmationShortlink({{$item->id}})" id="delete-shortlink" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                @else

                                @endif
                            </td>
                        </tr>
                        <!-- Modal -->
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
                            <td colspan='9', align='center'>No URL Shortener Data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD ARTICLE =====
// ini untuk konfirmasi delete
function deleteConfirmationShortlink(id) {
            // console.log(id);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                width: '350px',
            })

            Swal.fire({
                title: 'Are you sure ?',
                text: "You won't be able to revert this !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                    type: "get",
                    url: `{{ url('${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Shortlink has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD ARTICLE =====
</script>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1000,
        width: '350px',
    })

    function copyLink(link) {
        const input = document.createElement('input');
        input.value = link;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        Toast.fire({
            icon: 'success',
            title: 'Link copied to clipboard !'
        });
    }
</script>
<script>
$('#dataShortlinkTable').DataTable({
    responsive: true,
    fixedHeader: true,
});
</script>
@endsection
