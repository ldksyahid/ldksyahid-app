@extends('admin-page.template.body')

@section('head')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
@endsection

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">IT Support Management System</h5>
                <a class='btn btn-primary' href="/admin/about/itsupport/create"><i class="fa fa-plus"></i> Create IT Support</a>
                {{-- START Data table IT Support --}}
                <div class="table-responsive">
                    <div class="mt-3">
                        <table class="table table-hover table-striped text-nowrap small" id="dataItSupport">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Name</th>
                                <th scope="col" class="text-center">Forkat</th>
                                <th scope="col" class="text-center">Position</th>
                                <th scope="col" class="text-center">Instagram Link</th>
                                <th scope="col" class="text-center">Linkedin Link</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postitsupport as $key => $data)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td align='center'>{{ $data->name }}</td>
                                <td align='center'>{{ $data->forkat }}</td>
                                <td align='center'>{{ $data->position }}</td>
                                <td align='center'><a href="{{ $data->linkInstagram }}" target="_blank" rel="noopener noreferrer">{{ $data->linkInstagram }}</a></td>
                                <td align='center'><a href="{{ $data->linkLinkedin }}" target="_blank" rel="noopener noreferrer">{{ $data->linkLinkedin }}</a></td>
                                <td align="center">
                                    <a href="/admin/about/itsupport/{{ $data->id }}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                    <button type="submit" onclick="deleteConfirmationITSupport({{ $data->id }})" id="delete-itsupport" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                    <a class="btn btn-sm btn-primary" href="/admin/about/itsupport/{{ $data->id }}/preview"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='8', align='center'>No IT Support Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    </div>
                </div>
                {{-- END Data table IT Support --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD ITSupport =====
// ini untuk konfirmasi delete
function deleteConfirmationITSupport(id) {
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
                    url: `{{ url('/admin/about/itsupport/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'IT Support has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD ITSupport =====
</script>
<script>
    $('#dataItSupport').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection
