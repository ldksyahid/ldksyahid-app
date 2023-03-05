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
                <div class="mt-3">
                    @forelse($postcampaign  as $key => $data)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="7">{{ $data->judul }}</th>
                            </tr>
                            <tr align='center' class="small">
                                <th scope="col" style="width: 10px">No</th>
                                <th scope="col" style="width: 170px">Nama</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Waktu</th>
                                <th scope="col">Status Pembayaran</th>
                                <th scope="col">Link Pembayaran</th>
                                <th scope="col" style="width: 40px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $pointer = 0;
                            @endphp
                            @if ($data->donation()->count() > 0)
                            @foreach ( $data->donation->reverse() as $donation)
                            <tr class="small">
                                <td scope="row" align='center'>{{$pointer += 1}}</td>
                                <td>{{ $donation->nama_donatur }}</td>
                                <td align="center">{{ LFC::formatRupiah($donation->jumlah_donasi) }}</td>
                                <td align="center">{{ \Carbon\Carbon::parse( $donation->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $donation->created_at )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $donation->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $donation->created_at )->format('Y') }} ({{ \Carbon\Carbon::parse( $donation->created_at )->format('H:i T') }})</td>
                                <td align="center">{{ $donation->payment_status }}</td>
                                <td align="center"><a href="{{ $donation->payment_link }}" target="_blank">Klik Disini</a></td>
                                <td align="center">
                                    <button type="submit" onclick="deleteConfirmationDonation('{{ $donation->id }}' )" id="delete-donation" class="btn btn-sm btn-primary mb-1"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="small">
                                <td scope="row" align='center' colspan="7">Data Tidak Ditemukan</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    @empty
                    <table class="table table-bordered">
                        <thead>
                            <tr align="center">
                                <th>
                                    <div style="height: 140px"></div>
                                    Data Tidak Ditemukan
                                    <div style="height: 140px"></div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Table End -->
@endsection

@section('scripts')
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
