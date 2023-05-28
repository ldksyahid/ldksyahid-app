@extends('admin-page.template.body')

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Campaign Database</h5>
                <a class='btn btn-primary' href="/admin/service/celengansyahid/campaign/create"><i class="fa fa-plus"></i> Create Campaign</a>
                {{-- START Data table Campaign --}}
                <div class="mt-3">
                    <table class="table table-bordered small">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col" style="width: 170px">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col">Poster</th>
                                <th scope="col">PIC</th>
                                <th scope="col">Cost Target</th>
                                <th scope="col">Deadline</th>
                                <th scope="col" style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postcampaign as $key => $data)
                            <tr class="small">
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td>{{ $data->judul }}</td>
                                <td align="center">{{ $data->kategori }}</td>
                                <td align="center">
                                    <img style="width: 200px;" class="rounded" src="{{ asset($data->poster) }}" alt="{{ $data->judul }}"/>
                                </td>
                                @if ($data->nama_pj != null && $data->link_pj != null)
                                    <td align="center"><a href="{{ $data->link_pj }}" target="_blank">{{ $data->nama_pj }}</a></td>
                                @else
                                    <td align="center"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></td>
                                @endif
                                <td align="center" id="target_biaya">{{ LFC::formatRupiah($data->target_biaya) }}</td>
                                <td align="center">{{ \Carbon\Carbon::parse( $data->deadline )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->deadline )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $data->deadline )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->deadline )->format('Y') }}</td>
                                <td align="center">
                                    <a href="/admin/service/celengansyahid/campaign/{{ $data->id }}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                    <button type="submit" onclick="deleteConfirmationCampaign('{{ $data->id }}')" id="delete-campaign" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                    <a class="btn btn-sm btn-primary" href="/admin/service/celengansyahid/campaign/{{ $data->id }}/preview" ><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='9', align='center'>No Campaign Data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- END Data table Campaign --}}
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script>
// ===== START CRUD CAMPAIGN =====
// ini untuk konfirmasi delete
function deleteConfirmationCampaign(id) {
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
                    url: `{{ url('/admin/service/celengansyahid/campaign/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Campaign has been deleted !'
                            });
                        }
                    });

                }
            })
}
// ===== END CRUD CAMPAIGN =====
</script>


@endsection
