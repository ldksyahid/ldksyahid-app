@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('style')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/navcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />
@endsection

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<div class="website-responsive">
    @if ($data->payment_status == 'PAID')
    <div class="container-fluid" style="background-color: #e5fbe9;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-success">
                    <p style="font-size:28px;"><strong>Pembayaran Berhasil</strong></p>
                </div>
            </div>
        </div>
    </div>
    @elseif ($data->payment_status == 'PENDING')
    <div class="container-fluid" style="background-color: #fbf9e5;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-warning">
                    <p style="font-size:28px;"><strong>Menunggu Pembayaran</strong> <br> <span class="small">Silahkan Selesaikan Proses Pembayaran</span></p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container-fluid" style="background-color: #fbe5e5;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-danger">
                    <p style="font-size:28px;"><strong>Pembayaran Gagal</strong></p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="container px-4 py-3  w-50">
        <div>
            <div class="col col-md-12 my-4">
                <div class="text-center">
                    <h6 class="text-body mb-2" style="font-size: 24px">Detail Pembayaran</h6>
                </div>
            </div>
            <div class="row my-4" style="background-color: #f8f8f8;">
                <div class="col col-lg-6 text-start">
                    <p>ID Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 15px;">{{ $data->id }}</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Waktu Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 15px;">{{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('D') }} {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('Y') }} Pada Pukul {{ \Carbon\Carbon::parse( $data->created_at )->format('H:i T') }}</strong>
                </div>
            </div>
            <div class="row my-4" style="background-color: #f8f8f8;">
                <div class="col col-lg-6 text-start">
                    <p>Campaign</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">{{ $campaign->judul }}</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Atas Nama</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">{{ $data->nama_donatur }}</strong>
                </div>
            </div>
            <div class="row my-4" style="background-color: #f8f8f8;">
                <div class="col col-lg-6 text-start">
                    <p>Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">{{ LFC::formatRupiah($data->jumlah_donasi) }}</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Total Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">{{ LFC::formatRupiah($data->jumlah_donasi) }}</strong>
                </div>
            </div>
            @if ($data->payment_status == 'PAID')
            <div class="row my-4">
                <div class="col col-lg-6">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">KEMBALI</a>
                    </div>
                </div>
                <div class="col col-lg-6">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/simpan-bukti/{{ $campaign->link }}/{{ $data->id }}" target="_blank">SIMPAN PEMBAYARAN</a>
                    </div>
                </div>
            </div>
            @elseif ($data->payment_status == 'PENDING')
            <div class="row my-4">
                <div class="col col-lg-12">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/payment/{{ $data->id }}" target="_blank">BAYAR SEKARANG</a>
                    </div>
                </div>
                <br><br>
                <div class="col col-lg-12">
                    <div class="text-center">
                        <button class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;"  onclick="refreshPage()">MUAT ULANG HALAMAN</button>
                    </div>
                </div>
            </div>
            @else
            <div class="row my-4">
                <div class="col col-lg-6">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/" target="_blank">BAYAR SEKARANG</a>
                    </div>
                </div>
                <div class="col col-lg-6">
                    <div class="text-center">
                        <button class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;"  onclick="refreshPage()">MUAT ULANG HALAMAN</button>
                    </div>
                </div>
                <br><br>
                <div class="col col-lg-12">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">KEMBALI</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="mobile-responsive">
    @if ($data->payment_status == 'PAID')
    <div class="container-fluid" style="background-color: #e5fbe9;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-success">
                    <p style="font-size:26px;"><strong>Pembayaran Berhasil</strong></p>
                </div>
            </div>
        </div>
    </div>
    @elseif ($data->payment_status == 'PENDING')
    <div class="container-fluid" style="background-color: #fbf9e5;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-warning">
                    <p style="font-size:26px;"><strong>Menunggu Pembayaran</strong> <br> <span class="small">Silahkan Selesaikan Proses Pembayaran</span></p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container-fluid" style="background-color: #fbe5e5;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-danger">
                    <p style="font-size:26px;"><strong>Pembayaran Gagal</strong></p>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="container px-4 py-3">
        <div>
            <div class="col col-md-12 my-4">
                <div class="text-center">
                    <h6 class="text-body mb-2" style="font-size: 22px">Detail Pembayaran</h6>
                </div>
            </div>
            <div class="row my-4" style="background-color: #f8f8f8;">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">ID Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">{{ $data->id }}</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Waktu Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">{{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('D') }} {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $data->created_at )->isoFormat('Y') }} Pada Pukul {{ \Carbon\Carbon::parse( $data->created_at )->format('H:i T') }}</strong>
                </div>
            </div>
            <div class="row my-4" style="background-color: #f8f8f8;">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Campaign</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">{{ $campaign->judul }}</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Atas Nama</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">{{ $data->nama_donatur }}</strong>
                </div>
            </div>
            <div class="row my-4" style="background-color: #f8f8f8;">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">Rp10.000</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Total Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">{{ LFC::formatRupiah($data->jumlah_donasi) }}</strong>
                </div>
            </div>
            @if ($data->payment_status == 'PAID')
            <div class="col col-md-12 my-4">
                <div class="col col-md-12 my-4">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/simpan-bukti/{{ $campaign->link }}/{{ $data->id }}" target="_blank">SIMPAN PEMBAYARAN</a>
                    </div>
                </div>
                <div class="text-center">
                    <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">KEMBALI</a>
                </div>
            </div>
            @elseif ($data->payment_status == 'PENDING')
            <div class="col col-md-12 my-4">
                <div class="col col-md-12 my-4">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/payment/{{ $data->id }}" target="_blank">BAYAR SEKARANG</a>
                    </div>
                </div>
                <div class="text-center">
                    <button class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" onclick="refreshPage()">MUAT ULANG HALAMAN</button>
                </div>
            </div>
            @else
            <div class="col col-lg-12 my-4">
                <div class="text-center">
                    <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/payment/{{ $data->id }}" target="_blank">BAYAR SEKARANG</a>
                </div>
            </div>
            <div class="col col-lg-12 my-4">
                <div class="text-center">
                    <button class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" onclick="refreshPage()">MUAT ULANG HALAMAN</button>
                </div>
            </div>
            <div class="col col-lg-12 my-4">
                <div class="text-center">
                    <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">KEMBALI</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
function refreshPage() {
    location.reload();
}
</script>
@endsection
