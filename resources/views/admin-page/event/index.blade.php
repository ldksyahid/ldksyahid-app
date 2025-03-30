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
                <h5 class="mb-4">Event Management System</h5>
                <a class='btn btn-primary' href="/admin/event/create"><i class="fa fa-plus"></i> Create Event</a>
                {{-- START Data table Jumbotron --}}
                <div class="mt-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataEvent">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Title</th>
                                    <th scope="col" class="text-center">Event Organizer</th>
                                    <th scope="col" class="text-center">Date Event</th>
                                    <th scope="col" class="text-center">Link Regist</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($postevent as $key => $postevent)
                                <tr>
                                    <td scope="row" align='center'>{{$key + 1}}</td>
                                    <td align='center'>{{ $postevent->title }}</td>
                                    <td align='center'>{{ $postevent->division }}</td>
                                    @if ($postevent->start != null)
                                    <td align='center'>{{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('dddd') }} {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->start )->format('Y') }}</td>
                                    @else
                                    <td align='center'>Undifined</td>
                                    @endif
                                    <td align='center'>
                                        @if ($postevent->linkRegist != null)
                                            <a href="{{ $postevent->linkRegist }}" target="_blank" rel="noopener noreferrer">{{ $postevent->linkRegist }}</a>
                                        @else
                                            Undifined
                                        @endif
                                    </td>
                                    <td align="center">
                                        <a href="/admin/event/{{ $postevent->id }}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationEvent({{ $postevent->id }})" id="delete-event" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/event/{{ $postevent->id }}/preview"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No Event Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END Data table Jumbotron --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<script>
// ===== START CRUD EVENT =====
// ini untuk konfirmasi delete
function deleteConfirmationEvent(id) {
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
                    url: `{{ url('/admin/event/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Event has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD EVENT =====
</script>
<script>
    $('#dataEvent').DataTable({
        responsive: true,
        fixedHeader: true,
    });
</script>
@endsection

