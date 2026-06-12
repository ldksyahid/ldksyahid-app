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
    .dd-card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,.08); }
    .dd-title { font-size: 1.5rem; font-weight: 700; color: #00a79d; }
    .dd-section-title { font-size: 1rem; font-weight: 600; color: #00a79d; border-bottom: 2px solid #e0f7f5; padding-bottom: .5rem; margin-bottom: 1rem; }
    .dd-row { display: flex; padding: .55rem 0; border-bottom: 1px solid #f1f1f1; }
    .dd-label { flex: 0 0 180px; color: #6c757d; font-weight: 500; }
    .dd-value { flex: 1; color: #212529; word-break: break-word; }
    .dd-amount { font-size: 1.6rem; font-weight: 800; color: #00a79d; }
    html.dark-mode .dd-card { background: #2b2f33; color: #e4e6eb; }
    html.dark-mode .dd-value { color: #e4e6eb; }
    html.dark-mode .dd-row { border-bottom-color: #373b3e; }
    html.dark-mode .dd-section-title { border-bottom-color: #373b3e; }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded mx-0">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
            <h1 class="dd-title mb-0"><i class="fa fa-donate me-2"></i>Donation Detail</h1>
            <a href="{{ route('admin.service.index.donation') }}" class="btn btn-custom-primary">
                <i class="fa fa-arrow-left me-1"></i> Back to List
            </a>
        </div>

        {{-- Amount + status --}}
        <div class="col-12 mb-3">
            <div class="card dd-card">
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="text-muted small">Total Donation</div>
                        <div class="dd-amount">{{ LFC::formatRupiah($donation->jumlah_donasi) }}</div>
                    </div>
                    <span class="badge {{ $statusBadge }} fs-6 px-3 py-2">{{ $donation->payment_status }}</span>
                </div>
            </div>
        </div>

        {{-- Donor info --}}
        <div class="col-lg-6 mb-3">
            <div class="card dd-card h-100">
                <div class="card-body">
                    <h5 class="dd-section-title"><i class="fa fa-user me-2"></i>Donor</h5>
                    <div class="dd-row">
                        <span class="dd-label">Name</span>
                        <span class="dd-value">
                            {{ $donation->nama_donatur }}
                            @if($donation->is_anonymous)
                                <span class="badge bg-secondary ms-1">Anonymous (public)</span>
                            @endif
                        </span>
                    </div>
                    <div class="dd-row"><span class="dd-label">Email</span><span class="dd-value">{{ $donation->email_donatur ?: '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Phone</span><span class="dd-value">{{ $donation->no_telp_donatur ?: '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Age</span><span class="dd-value">{{ $donation->usia ?: '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Domicile</span><span class="dd-value">{{ $donation->domisili ?: '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Occupation</span><span class="dd-value">{{ $donation->pekerjaan ?: '-' }}</span></div>
                    <div class="dd-row" style="border-bottom:none;">
                        <span class="dd-label">Message</span>
                        <span class="dd-value">{{ $donation->pesan_donatur ?: '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payment info --}}
        <div class="col-lg-6 mb-3">
            <div class="card dd-card h-100">
                <div class="card-body">
                    <h5 class="dd-section-title"><i class="fa fa-receipt me-2"></i>Payment</h5>
                    <div class="dd-row">
                        <span class="dd-label">Campaign</span>
                        <span class="dd-value">
                            @if($campaign)
                                <a href="{{ route('admin.service.preview.campaign', $campaign->id) }}">{{ $campaign->judul }}</a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <div class="dd-row"><span class="dd-label">Date</span><span class="dd-value">{{ optional($donation->created_at)->isoFormat('dddd, D MMMM YYYY HH:mm') }}</span></div>
                    <div class="dd-row"><span class="dd-label">Payment Method</span><span class="dd-value">{{ $donation->metode_pembayaran ?: '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Merchant</span><span class="dd-value">{{ $donation->nama_merchant ?: '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Admin Fee</span><span class="dd-value">{{ $donation->biaya_admin ? LFC::formatRupiah($donation->biaya_admin) : '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Total Billed</span><span class="dd-value">{{ $donation->total_tagihan ? LFC::formatRupiah($donation->total_tagihan) : '-' }}</span></div>
                    <div class="dd-row"><span class="dd-label">Doc No</span><span class="dd-value">{{ $donation->doc_no ?: '-' }}</span></div>
                    <div class="dd-row" style="border-bottom:none;">
                        <span class="dd-label">Payment Link</span>
                        <span class="dd-value">
                            @if($donation->payment_link)
                                <a href="{{ $donation->payment_link }}" target="_blank" rel="noopener" class="btn btn-sm btn-custom-primary">
                                    <i class="fa fa-external-link-alt me-1"></i> Open
                                </a>
                            @else
                                -
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
