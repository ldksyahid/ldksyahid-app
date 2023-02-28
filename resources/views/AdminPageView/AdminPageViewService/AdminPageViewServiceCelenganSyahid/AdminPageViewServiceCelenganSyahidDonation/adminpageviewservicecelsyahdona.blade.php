@extends('AdminPageView.AdminPageViewTemplate.bodyadminpage')

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h5 class="mb-4">Donations Database</h5>
                {{-- START Data table Campaign --}}
                <div class="mt-3">
                    <table class="table table-bordered" id="data_donation_reguler">
                        <thead>
                            <tr align='center'>
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col" style="width: 170px">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telp</th>
                                <th scope="col">Donasi</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Waktu</th>
                                <th scope="col" style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postdonation  as $key => $data)
                            <tr class="small">
                                <td scope="row" align='center'>{{$key + 1}}</td>
                                <td>{{ $data->nama_donatur }}</td>
                                <td>{{ $data->email_donatur }}</td>
                                <td>{{ $data->no_telp_donatur }}</td>
                                <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ducimus a, aut dolore sit voluptates aperiam.</td>
                                <td>{{ LFC::FormatRupiah($data->jumlah_donasi) }}</td>
                                <td align="center">{{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->created_at )->format('Y') }}</td>
                                <td align="center">
                                    <button type="submit" onclick="deleteConfirmationDonation('{{ $data->id }}')" id="delete-donation" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
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
function deleteConfirmationDonation(id) {
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
                    url: `{{ url('/admin/service/celengansyahid/donation/${id}/destroy') }}`,
                        success: function(data) {
                            setTimeout(function () { location.reload(1); }, 300);
                            Toast.fire({
                                icon: 'success',
                                title: 'Donation has been deleted !'
                            });
                        }
                    });

                }
            })
}
// ===== END CRUD CAMPAIGN =====
</script>

<script>
    $(document).ready(function() {
    $('#data_donation_reguler').DataTable();
} );
</script>


@endsection
