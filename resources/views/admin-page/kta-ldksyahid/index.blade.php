@extends('admin-page.template.body')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">KTA LDK Syahid Database</h5>
                <a class='btn btn-primary' href="/admin/ktaldksyahid/create"><i class="fa fa-plus"></i> Create KTA LDK Syahid</a>
                {{-- START Data table KTA --}}
                <div class="mt-3">
                    <table class="table table-bordered small">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">NIM</th>
                                <th scope="col">Generation</th>
                                <th scope="col">Member Number</th>
                                <th scope="col" style="width: 10px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ktaData as $key => $data)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td align='center'>{{ $data->fullName }}</td>
                                <td align='center'>{{ $data->nim }}</td>
                                <td align='center'>{{ $data->generation }}</td>
                                <td align='center'>{{ $data->memberNumber }}</td>
                                <td align="center">
                                        <a href="/admin/ktaldksyahid/{{ $data->id }}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                        <button type="submit" onclick="deleteConfirmationKTALDKSyahid({{ $postarticle->id }})" id="delete-ktaldksyahid" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                        <a class="btn btn-sm btn-primary" href="/admin/ktaldksyahid/{{ $postarticle->id }}/preview"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='9', align='center'>No KTA Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- END Data table KTA --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script>
// ===== START CRUD KTA =====
// ini untuk konfirmasi delete
function deleteConfirmationKTALDKSyahid(id) {
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
                    url: `{{ url('/admin/ktaldksyahid/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'KTA LDK Syahid has been deleted !'
                            });
                        }
                    });

                }
            })
        }
// ===== END CRUD ARTICLE =====
</script>
@endsection
