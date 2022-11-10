@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Schedule Database</h5>
                <a class='btn btn-primary' href="/admin/schedule/create"><i class="fa fa-plus"></i> Create Schedule</a>
                {{-- START Data table Article --}}
                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col">Title</th>
                                <th scope="col">Month</th>
                                <th scope="col">Year</th>
                                <th scope="col">Picture</th>
                                <th scope="col" style="width: 10px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postschedule as $key => $postschedule)
                            <tr>
                                <td scope="row" align='center'>{{ $key+1 }}</td>
                                <td>{{ $postschedule->title }}</td>
                                <td align='center'>{{ $postschedule->month }}</td>
                                <td align='center'>{{ $postschedule->year }}</td>
                                <td align='center'>
                                    <img style="width: 100px;" src="{{ asset($postschedule->picture) }}" alt="{{$postschedule->title}}" class="card-img-top"/>
                                </td>
                                <td align="center">
                                    <a href="/admin/schedule/{{$postschedule->id}}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                    <button type="submit" onclick="deleteConfirmationSchedule({{ $postschedule->id }})" id="delete-schedule" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                    <a class="btn btn-sm btn-primary" href="/schedule" target="_blank"><i class="fa fa-eye"></i></a>
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
                {{-- END Data table Jumbotron --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
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
@endsection
