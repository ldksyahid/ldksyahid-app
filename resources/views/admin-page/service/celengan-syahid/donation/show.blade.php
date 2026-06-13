@extends('admin-page.template.body')

@php
    use App\Http\Controllers\LibraryFunctionController as LFC;

    $statusBadge = [
        'PAID'    => 'bg-success',
        'SETTLED' => 'bg-success',
        'PENDING' => 'bg-warning',
        'EXPIRED' => 'bg-secondary',
        'FAILED'  => 'bg-danger',
    ][$donation->payment_status] ?? 'bg-danger';
@endphp

@section('styles')
<style>
/* Page title — mirrors comment view */
.page-title {
    font-size: 1.65rem !important;
    font-weight: 600 !important;
    text-align: center !important;
    color: #00a79d !important;
    margin: .75rem 0 1.5rem !important;
    position: relative;
    display: inline-block;
}
.page-title .highlighted-text { color: #008b84; font-weight: 700; }
.page-title::after {
    content: '';
    display: block;
    height: 4px;
    width: 120px;
    margin: .35rem auto 0;
    border-radius: 3px;
    background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
}
.page-title small {
    color: #6c757d !important;
    font-size: .9rem !important;
    font-weight: 400 !important;
    display: block !important;
    margin-top: .4rem;
}

/* Section title — mirrors comment view */
.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #00a79d;
    padding-bottom: .5rem;
    border-bottom: 2px solid #e0f7f5;
}
html.dark-mode .section-title { color: #2dd4bf; border-bottom-color: rgba(45,212,191,.15); }

/* Cards — mirrors comment view */
.card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,.08); }

/* Label/value rows */
.form-label.fw-bold { color: #495057; font-weight: 600; }
html.dark-mode .form-label.fw-bold { color: #9ca3af; }

.form-control-plaintext {
    padding: .375rem 0;
    margin-bottom: 0;
    line-height: 1.5;
    background-color: transparent;
    border: solid transparent;
    border-width: 1px 0;
    min-height: 38px;
    display: flex;
    align-items: center;
    word-break: break-word;
}

/* Amount highlight */
.dd-amount { font-size: 1.6rem; font-weight: 800; color: #00a79d; }
html.dark-mode .dd-amount { color: #2dd4bf; }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-donate me-2"></i>
                <span>Detail</span>
                <span class="highlighted-text ms-1">Donasi</span>
                <small>#{{ $donation->id }} &mdash; {{ $donation->nama_donatur }}</small>
            </h1>
        </div>

        {{-- Amount + Status Card --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="text-muted small">Total Donasi</div>
                        <div class="dd-amount">{{ LFC::formatRupiah($donation->jumlah_donasi) }}</div>
                    </div>
                    <span class="badge {{ $statusBadge }} fs-6 px-3 py-2">{{ $donation->payment_status }}</span>
                </div>
            </div>
        </div>

        {{-- Donor Info --}}
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-user me-2"></i>Data Donatur
                    </h5>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Nama</label>
                            <div class="form-control-plaintext">
                                {{ $donation->nama_donatur }}
                                @if($donation->is_anonymous)
                                    <span class="badge bg-secondary ms-1">Anonymous (publik)</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <div class="form-control-plaintext">{{ $donation->email_donatur ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">No. Telepon</label>
                            <div class="form-control-plaintext">{{ $donation->no_telp_donatur ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Usia</label>
                            <div class="form-control-plaintext">{{ $donation->usia ? $donation->usia . ' tahun' : '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Domisili</label>
                            <div class="form-control-plaintext">{{ $donation->domisili ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Pekerjaan</label>
                            <div class="form-control-plaintext">{{ $donation->pekerjaan ?: '—' }}</div>
                        </div>
                        <div class="col-12 mb-0">
                            <label class="form-label fw-bold">Pesan / Do'a</label>
                            <div class="form-control-plaintext" style="align-items: flex-start; white-space: pre-wrap;">{{ $donation->pesan_donatur ?: '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment Info --}}
        <div class="col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="section-title mb-3">
                        <i class="fas fa-receipt me-2"></i>Info Pembayaran
                    </h5>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Campaign</label>
                            <div class="form-control-plaintext">
                                @if($campaign)
                                    <a href="{{ route('admin.service.preview.campaign', $campaign->id) }}">{{ $campaign->judul }}</a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Tanggal</label>
                            <div class="form-control-plaintext">
                                {{ optional($donation->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm') ?: '—' }}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Metode Pembayaran</label>
                            <div class="form-control-plaintext">{{ $donation->metode_pembayaran ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Merchant</label>
                            <div class="form-control-plaintext">{{ $donation->nama_merchant ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Biaya Admin</label>
                            <div class="form-control-plaintext">
                                {{ $donation->biaya_admin ? LFC::formatRupiah($donation->biaya_admin) : '—' }}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Total Tagihan</label>
                            <div class="form-control-plaintext">
                                {{ $donation->total_tagihan ? LFC::formatRupiah($donation->total_tagihan) : '—' }}
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Doc No</label>
                            <div class="form-control-plaintext">{{ $donation->doc_no ?: '—' }}</div>
                        </div>
                        <div class="col-12 mb-0">
                            <label class="form-label fw-bold">Payment Link</label>
                            <div class="form-control-plaintext">
                                @if($donation->payment_link)
                                    <a href="{{ $donation->payment_link }}" target="_blank" rel="noopener" class="btn btn-sm btn-custom-primary">
                                        <i class="fa fa-external-link-alt me-1"></i> Buka Link
                                    </a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Back Button (di bawah, seperti comment view) --}}
        <div class="col-12 d-flex justify-content-end mb-4">
            <a href="{{ route('admin.service.index.donation') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>

    </div>
</div>
@endsection
