@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Campaigns Database</h5>
                <a class='btn btn-primary' href="/admin/service/celengansyahid/campaign/create"><i class="fa fa-plus"></i> Buat Campaign</a>
                {{-- START Data table Campaign --}}
                <div class="mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col" style="width: 170px">Judul</th>
                                <th scope="col">Ketegori</th>
                                <th scope="col">Poster</th>
                                <th scope="col">Penanggung Jawab</th>
                                <th scope="col" style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postcampaign as $key => $data)
                            <tr>
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td>{{ $data->judul }}</td>
                                <td>{{ $data->kategori }}</td>
                                <td>
                                    <img style="width: 100px;" src="{{ asset($data->poster) }}" alt="{{ $data->judul }}" class="card-img-top"/>
                                </td>
                                <td>{{ $data->nama_pj }}</td>
                                <td align="center">
                                    <a href="/admin/service/celengansyahid/campaign/{{ $data->id }}/edit" class="btn btn-sm btn-primary mb-1"><i class="fa fa-edit"></i></a>
                                    <button type="submit" onclick="deleteConfirmationCampaign({{ $data->id }})" id="delete-campaign" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                    <a class="btn btn-sm btn-primary" href="/admin/service/celengansyahid/campaign/{{ $data->id }}/preview" target="_blank"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='9', align='center'>Data Tidak Ditemukan</td>
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

