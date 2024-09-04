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
                <h5 class="mb-4">Jumbotron Management System</h5>
                <a class='btn btn-primary' href="/admin/jumbotron/create"><i class="fa fa-plus"></i> Create Jumbotron</a>
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataJumbotron">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Picture</th>
                                    <th scope="col" class="text-center">Button Name</th>
                                    <th scope="col" class="text-center">Button Link</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($postjumbotron as $key => $postjumbotron)
                                <tr>
                                    <td scope="row" align='center'>{{$key + 1}}</td>
                                    <td align='center'>
                                        <img style="width: 100px;" src="https://lh3.googleusercontent.com/d/{{ $postjumbotron->gdrive_id }}" alt="{{$postjumbotron->title}}" class="card-img"/>
                                    </td>
                                    @if ($postjumbotron->btnname != null || $postjumbotron->btnlink != null)
                                        <td align='center'>{{$postjumbotron->btnname}}</td>
                                        <td align='center'><a href="{{$postjumbotron->btnlink}}" target="_blank">{{$postjumbotron->btnlink}}</a></td>
                                    @else
                                        <td align='center'>None</td>
                                        <td align='center'>None</td>
                                    @endif
                                    <td align="center">
                                        <a href="/admin/jumbotron/{{$postjumbotron->id}}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationJumbotron({{$postjumbotron->id}})" id="delete-jumbotron" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/jumbotron/{{$postjumbotron->id}}/preview"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No Jumbotron Data</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD JUMBOTRON =====
// ini untuk konfirmasi delete
        function deleteConfirmationJumbotron(id) {
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
                    url: `{{ url('/admin/jumbotron/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Jumbotron has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD JUMBOTRON =====
</script>
<script>
    $('#dataJumbotron').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection
