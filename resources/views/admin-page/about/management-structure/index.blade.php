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
                <h5 class="mb-4">Structure Management System</h5>
                <a class='btn btn-primary' href="/admin/about/structure/create"><i class="fa fa-plus"></i> Create Structure</a>
                {{-- START Data table Structure --}}
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataStructure">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Period</th>
                                    <th scope="col" class="text-center">Structure Name</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($poststructure as $key => $data)
                                <tr>
                                    <td scope="row" align='center'>{{ $key+1 }}</td>
                                    <td align='center'>{{ $data->batch }}</td>
                                    <td align='center'>{{ $data->period }}</td>
                                    <td align='center'>{{ $data->structureName }}</td>
                                    <td align="center">
                                        <a href="/admin/about/structure/{{ $data->id }}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationStructure({{ $data->id }})" id="delete-structure" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/about/structure/{{ $data->id }}/preview"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No Structure Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END Data table Structure --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD STRUCTURE =====
// ini untuk konfirmasi delete
function deleteConfirmationStructure(id) {
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
                    url: `{{ url('/admin/about/structure/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Structure has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD STRUCTURE =====
</script>
<script>
    $('#dataStructure').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection
