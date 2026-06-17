@extends('landing-page.template.body')

@section('title', $title)

@section('content')

<section id="verifikasi-section">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">

                @if ($suratLog && $suratLog->isApproved())

                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <div class="mb-4">
                            <span class="d-inline-flex align-items-center justify-content-center
                                         bg-success-subtle rounded-circle"
                                  style="width:72px;height:72px">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </span>
                        </div>
                        <h4 class="fw-bold text-success mb-2">Surat Terverifikasi</h4>
                        <p class="text-muted mb-4">Surat ini adalah dokumen resmi yang diterbitkan oleh LDK Syahid UIN Jakarta.</p>

                        <table class="table table-borderless table-sm text-start small">
                            <tr>
                                <td class="text-muted fw-semibold" style="width:150px">Jenis Surat</td>
                                <td>: {{ $suratLog->label }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Nomor Surat</td>
                                <td>: {{ $suratLog->nomor_surat }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Atas Nama</td>
                                <td>: {{ $suratLog->user?->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Diterbitkan</td>
                                <td>: {{ $suratLog->approved_at?->locale('id')->translatedFormat('d F Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted fw-semibold">Kode Verifikasi</td>
                                <td>: <code>{{ $kode }}</code></td>
                            </tr>
                        </table>
                    </div>

                @elseif ($suratLog && !$suratLog->isApproved())

                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <div class="mb-4">
                            <span class="d-inline-flex align-items-center justify-content-center
                                         bg-warning-subtle rounded-circle"
                                  style="width:72px;height:72px">
                                <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                            </span>
                        </div>
                        <h4 class="fw-bold text-warning mb-2">Surat Belum Aktif</h4>
                        <p class="text-muted mb-0">Surat dengan kode ini ditemukan, namun belum mendapatkan persetujuan resmi dari admin LDK Syahid.</p>
                    </div>

                @else

                    <div class="card border-0 shadow-sm rounded-4 p-5">
                        <div class="mb-4">
                            <span class="d-inline-flex align-items-center justify-content-center
                                         bg-danger-subtle rounded-circle"
                                  style="width:72px;height:72px">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </span>
                        </div>
                        <h4 class="fw-bold text-danger mb-2">Surat Tidak Ditemukan</h4>
                        <p class="text-muted mb-0">Kode verifikasi <code>{{ $kode }}</code> tidak terdaftar dalam sistem LDK Syahid. Pastikan kode yang digunakan benar.</p>
                    </div>

                @endif

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary rounded-3">
                        <i class="fas fa-home me-1"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection