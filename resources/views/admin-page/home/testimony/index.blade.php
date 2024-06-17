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
                <h5 class="mb-4">Testimony Management System</h5>
                <a class='btn btn-primary' href="/admin/testimony/create"><i class="fa fa-plus"></i> Create Testimony</a>
                {{-- START Data table Testimony --}}
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataTestimony">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Profession</th>
                                    <th scope="col" class="text-center">Photo Profile</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posttestimony as $key => $posttestimony)
                                <tr>
                                    <td scope="row" align='center'>{{$key + 1}}</td>
                                    <td align="center">{{ $posttestimony->name }}</td>
                                    <td align="center">{{ $posttestimony->profession }}</td>
                                    <td align="center">
                                        <img style="width: 100px;" src="https://lh3.google.com/u/0/d/{{ $posttestimony->gdrive_id }}" alt="{{$posttestimony->name}}" class="card-img"/>
                                    </td>
                                    <td align="center">
                                        <a href="/admin/testimony/{{$posttestimony->id}}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationTestimony({{$posttestimony->id}})" id="delete-testimony" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/testimony/{{$posttestimony->id}}/preview"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No Testimony Data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END Data table Testimony --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD TESTIMONY =====
// ini untuk konfirmasi delete
        function deleteConfirmationTestimony(id) {
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
                    url: `{{ url('/admin/testimony/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Testimony has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD TESTIMONY =====
</script>
<script>
    $('#dataTestimony').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection
