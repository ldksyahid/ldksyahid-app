@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('style')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/navcelengan.css') }}" rel="stylesheet" />
<link href="{{ asset('css/cardcelengan.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="website-responsive">
    <div class="container-fluid d-none" style="background-color: #fbe5e5;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-danger">
                    <p style="font-size:28px;"><strong>Pembayaran Gagal</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="background-color: #e5fbe9;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-success">
                    <p style="font-size:28px;"><strong>Pembayaran Berhasil</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container px-4 py-3  w-50">
        <div>
            <div class="col col-md-12 my-4">
                <div class="text-center">
                    <h6 class="text-body mb-2" style="font-size: 24px">Detail Transaksi</h6>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>ID Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">DNS29221146638791</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Tanggal Transaksi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">29 Januari 2023, 22.11</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Atas Nama</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">Manusia baik</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Metode Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">E-Wallet</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Nama Bank/E-Wallet</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">OVO</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">Rp10.000</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Biaya Admin</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">Rp100</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Kode Unik</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">0</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p>Total Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 16px;">Rp10.100</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">KEMBALI</a>
                    </div>
                </div>
                <div class="col col-lg-6">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">SIMPAN BUKTI TRANSAKSI</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-responsive">
    <div class="container-fluid" style="background-color: #fbe5e5;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-danger">
                    <p style="font-size:26px;"><strong>Pembayaran Gagal</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid d-none" style="background-color: #e5fbe9;">
        <div class="container w-75">
            <div class="col col-lg-12">
                <div class="py-5 text-center text-success">
                    <p style="font-size:26px;"><strong>Pembayaran Berhasil</strong></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container px-4 py-3">
        <div>
            <div class="col col-md-12 my-4">
                <div class="text-center">
                    <h6 class="text-body mb-2" style="font-size: 22px">Detail Transaksi</h6>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">ID Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">DNS29221146638791</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Tanggal Transaksi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">29 Januari 2023, 22.11</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Atas Nama</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">Manusia baik</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Metode Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">E-Wallet</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Nama Bank/E-Wallet</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">OVO</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Donasi</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">Rp10.000</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Biaya Admin</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">Rp100</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Kode Unik</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">0</strong>
                </div>
            </div>
            <div class="row my-4">
                <div class="col col-lg-6 text-start">
                    <p style="font-size: 14px;">Total Pembayaran</p>
                </div>
                <div class="col col-lg-6 text-end">
                    <strong style="font-size: 14px;">Rp10.100</strong>
                </div>
            </div>
            <div class="col col-md-12 my-4">
                <div class="col col-md-12 my-4">
                    <div class="text-center">
                        <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">SIMPAN BUKTI TRANSAKSI</a>
                    </div>
                </div>
                <div class="text-center">
                    <a class="btn btn-outline-primary py-2 px-5 w-100" style="border-radius: 5px;" href="/service/celengansyahid/">KEMBALI</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
@endsection
