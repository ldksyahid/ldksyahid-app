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
                <h5 class="mb-4">Donations Database</h5>
                <div class="mt-3">
                    <table class="table table-bordered" id="data_donation_reguler">
                        <thead>
                            <tr align='center' class="small">
                                <th scope="col" style="width: 1%">No</th>
                                <th scope="col" style="width: 15%">Nama</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col" style="width: 18%">Waktu</th>
                                <th scope="col">Campaign</th>
                                <th scope="col">Status Pembayaran</th>
                                <th scope="col">Link Pembayaran</th>
                                @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
                                <th scope="col" style="width: 40px">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $pointer = 0;
                            @endphp
                            @forelse ($postDonation as $data)
                            <tr class="small">
                                <td scope="row" align='center'>{{ $pointer += 1 }}</td>
                                <td align="center">{{$data->nama_donatur}}</td>
                                <td align="center">{{ LFC::formatRupiah($data->jumlah_donasi) }}</td>
                                <td align="center" >{{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->created_at )->format('Y') }} <br> ({{ \Carbon\Carbon::parse( $data->created_at )->format('H:i T') }})</td>
                                <td align="center">{{ LFC::getNameCampaign($data->campaign_id) }}</td>
                                <td align="center">
                                    @if ($data->payment_status == 'PENDING')
                                        <span class="badge badge-pill bg-warning">{{ $data->payment_status }}</span>
                                    @elseif ($data->payment_status == 'PAID')
                                        <span class="badge badge-pill bg-success">{{ $data->payment_status }}</span>
                                    @else
                                        <span class="badge badge-pill bg-danger">{{ $data->payment_status }}</span>
                                    @endif
                                </td>
                                <td align="center"><a href="{{ $data->payment_link }}" target="_blank" rel="noopener noreferrer">Klik Disini</a></td>
                                @if (LFC::getRoleName(auth()->user()->getRoleNames()) == 'Superadmin')
                                <td align="center">
                                    <button class="btn btn-sm btn-primary m-1" onClick="deleteConfirmationDonation('{{ $data->id }}')"><i class="fa fa-trash"></i></button>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr class="small">
                                <td align='center' colspan="8">Data tidak ditemukan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#data_donation_reguler').DataTable();
} );
</script>
<script>
// ===== START CRUD DONATION =====
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
// ===== END CRUD DONATION =====
</script>
@endsection