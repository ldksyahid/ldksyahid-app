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
@include('admin-page.service.celengan-syahid.donation.components._show-styles')
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fas fa-donate me-2"></i>
                <span>Detail</span>
                <span class="highlighted-text ms-1">Donation</span>
                <small>#{{ $donation->id }} &mdash; {{ $donation->nama_donatur }}</small>
            </h1>
        </div>

        {{-- Amount + Status Card --}}
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="text-muted small">Total Donation</div>
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
                        <i class="fas fa-user me-2"></i>Donor Information
                    </h5>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <div class="form-control-plaintext">
                                {{ $donation->nama_donatur }}
                                @if($donation->is_anonymous)
                                    <span class="badge bg-secondary ms-1">Anonymous (public)</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <div class="form-control-plaintext">{{ $donation->email_donatur ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <div class="form-control-plaintext">{{ $donation->no_telp_donatur ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Age</label>
                            <div class="form-control-plaintext">{{ $donation->usia ? $donation->usia . ' years old' : '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Domicile</label>
                            <div class="form-control-plaintext">{{ $donation->domisili ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Occupation</label>
                            <div class="form-control-plaintext">{{ $donation->pekerjaan ?: '—' }}</div>
                        </div>
                        <div class="col-12 mb-0">
                            <label class="form-label fw-bold">Message / Prayer</label>
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
                        <i class="fas fa-receipt me-2"></i>Payment Information
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
                            <label class="form-label fw-bold">Date</label>
                            <div class="form-control-plaintext">
                                {{ optional($donation->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm') ?: '—' }}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Payment Method</label>
                            <div class="form-control-plaintext">{{ $donation->metode_pembayaran ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Merchant</label>
                            <div class="form-control-plaintext">{{ $donation->nama_merchant ?: '—' }}</div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Admin Fee</label>
                            <div class="form-control-plaintext">
                                {{ $donation->biaya_admin ? LFC::formatRupiah($donation->biaya_admin) : '—' }}
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label class="form-label fw-bold">Total Billed</label>
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
                            <div style="padding: .375rem 0;">
                                @if($donation->payment_link)
                                    <a href="{{ $donation->payment_link }}" target="_blank" rel="noopener"
                                       class="btn btn-custom-primary mb-2">
                                        <i class="fa fa-external-link-alt me-2"></i> Open Payment Link
                                    </a>
                                    <div class="payment-link-url" style="word-break: break-all; font-size: .75rem;">
                                        {{ $donation->payment_link }}
                                    </div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="col-12 d-flex justify-content-end gap-2 mb-4">
            <a href="{{ route('admin.service.index.donation') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <a href="{{ route('admin.service.donation.edit', $donation->id) }}" class="btn btn-custom-primary">
                <i class="fa fa-edit me-1"></i> Edit
            </a>
        </div>

    </div>
</div>
@endsection
