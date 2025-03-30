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
                <h5 class="mb-4">Schedule Management System</h5>
                <a class='btn btn-primary' href="/admin/schedule/create"><i class="fa fa-plus"></i> Create Schedule</a>
                {{-- START Data table Schedule --}}
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataSchedule">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Title</th>
                                    <th scope="col" class="text-center">Month</th>
                                    <th scope="col" class="text-center">Year</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($postschedule as $key => $postschedule)
                                <tr>
                                    <td align='center'>{{ $key+1 }}</td>
                                    <td align='center'>{{ $postschedule->title }}</td>
                                    <td align='center'>{{ $postschedule->month }}</td>
                                    <td align='center'>{{ $postschedule->year }}</td>
                                    <td align="center">
                                        <a href="/admin/schedule/{{$postschedule->id}}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationSchedule({{ $postschedule->id }})" id="delete-schedule" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/schedule/{{$postschedule->id}}/preview"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No Schedule Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END Data table Schedule --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD SCHEDULE =====
// ini untuk konfirmasi delete
function deleteConfirmationSchedule(id) {
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
                    url: `{{ url('/admin/schedule/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Schedule has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD SCHEDULE =====
</script>
<script>
    $('#dataSchedule').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection
