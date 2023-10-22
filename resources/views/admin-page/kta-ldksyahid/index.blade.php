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
                <h5 class="mb-4">KTA LDK Syahid Management System</h5>
                <a class='btn btn-primary' href="/admin/ktaldksyahid/create"><i class="fa fa-plus"></i> Create KTA LDK Syahid</a>
                {{-- START Data table KTA --}}
                <div class="m-3">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-nowrap small" id="dataKtaLdkSyahid">
                            <thead>
                                <tr class="small">
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Generation</th>
                                    <th scope="col" class="text-center">Member Number</th>
                                    <th scope="col" class="text-center">Link Profile</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ktaData as $key => $data)
                                    <tr class="small">
                                        <td scope="row" align='center'>{{$key + 1}}</td>
                                        <td align='center'>{{ $data->fullName }}</td>
                                        <td align='center'>{{ $data->getGeneration->generationName }}</td>
                                        <td align='center'>{{ $data->memberNumber }}</td>
                                        <td align='start'>
                                            <button class="btn btn-sm btn-primary" onclick="copyLink(`{{ env('APP_URL').'/kta/'.$data->linkProfile }}`)"><i class="fa fa-copy small"></i></button>
                                            <a href="{{ env('APP_URL')."/kta/".$data->linkProfile }}" target="_blank" rel="noopener noreferrer">{{ env('APP_URL')."/kta/".$data->linkProfile }}</a>
                                        </td>
                                        <td align="center">
                                            <a href="/admin/ktaldksyahid/{{ $data->id }}/edit" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                            <button type="submit" onclick="deleteConfirmationKTALDKSyahid({{ $data->id }})" id="delete-ktaldksyahid" class="btn btn-sm btn-primary"><i class="fa fa-trash"></i></button>
                                            <a class="btn btn-sm btn-primary" href="/admin/ktaldksyahid/{{ $data->id }}/preview"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td colspan='9', align='center'>No KTA LDK Syahid</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END Data table KTA --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
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
// ===== END CRUD KTA =====
</script>
<script>
$('#dataKtaLdkSyahid').DataTable({
    responsive: true,
    fixedHeader: true,
});
</script>
@endsection
