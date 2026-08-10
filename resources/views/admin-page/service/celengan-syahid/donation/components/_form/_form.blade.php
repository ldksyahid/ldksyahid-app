@php
    $operation  = $operation ?? 'create';
    $donation   = $donation ?? null;
    $campaigns  = $campaigns ?? collect();
    $isEdit     = $operation === 'edit';
    $formAction = $isEdit
        ? route('admin.service.donation.update', $donation->id)
        : route('admin.service.donation.store');
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">

            {{-- Page Title --}}
            <h1 class="page-title">
                <i class="fa fa-{{ $isEdit ? 'edit' : 'plus-circle' }} me-2"></i>
                <span>{{ $isEdit ? 'Edit' : 'Add' }}</span>
                <span class="highlighted-text ms-1">Donation</span>
                @if($isEdit && $donation)
                    <small class="text-muted d-block mt-2">{{ $donation->nama_donatur }} &mdash; #{{ $donation->id }}</small>
                @endif
            </h1>

            {{-- Validation errors --}}
            @if($errors->any())
            <div class="col-md-12 my-2">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>There were some problems with your input:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif

            <form action="{{ $formAction }}" method="POST" class="da-form">
                @csrf
                @if($isEdit) @method('PUT') @endif

                {{-- ══════════════════════════════════════════════════
                     DONOR INFORMATION
                     ══════════════════════════════════════════════════ --}}
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-user me-2"></i>Donor Information
                            </h5>
                            <div class="row">

                                {{-- Full Name --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-nama" class="form-label">
                                        Full Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('nama_donatur') is-invalid @enderror"
                                           id="da-nama" name="nama_donatur"
                                           value="{{ old('nama_donatur', $donation->nama_donatur ?? '') }}"
                                           placeholder="Enter donor full name"
                                           maxlength="100" required>
                                    @error('nama_donatur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-email" class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email"
                                           class="form-control @error('email_donatur') is-invalid @enderror"
                                           id="da-email" name="email_donatur"
                                           value="{{ old('email_donatur', $donation->email_donatur ?? '') }}"
                                           placeholder="donor@example.com"
                                           maxlength="150" required>
                                    @error('email_donatur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone Number --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-telp" class="form-label">
                                        Phone Number <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('no_telp_donatur') is-invalid @enderror"
                                           id="da-telp" name="no_telp_donatur"
                                           value="{{ old('no_telp_donatur', $donation->no_telp_donatur ?? '') }}"
                                           placeholder="08xxxxxxxxxx"
                                           maxlength="20" required>
                                    @error('no_telp_donatur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Age --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-usia" class="form-label">
                                        Age <span class="text-muted small">(optional)</span>
                                    </label>
                                    <input type="number"
                                           class="form-control @error('usia') is-invalid @enderror"
                                           id="da-usia" name="usia"
                                           value="{{ old('usia', $donation->usia ?? '') }}"
                                           placeholder="e.g. 21"
                                           min="1" max="120">
                                    @error('usia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Domicile --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-domisili" class="form-label">
                                        Domicile <span class="text-muted small">(optional)</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('domisili') is-invalid @enderror"
                                           id="da-domisili" name="domisili"
                                           value="{{ old('domisili', $donation->domisili ?? '') }}"
                                           placeholder="e.g. Jakarta"
                                           maxlength="100">
                                    @error('domisili')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Occupation --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-pekerjaan" class="form-label">
                                        Occupation <span class="text-muted small">(optional)</span>
                                    </label>
                                    <input type="text"
                                           class="form-control @error('pekerjaan') is-invalid @enderror"
                                           id="da-pekerjaan" name="pekerjaan"
                                           value="{{ old('pekerjaan', $donation->pekerjaan ?? '') }}"
                                           placeholder="e.g. Student"
                                           maxlength="100">
                                    @error('pekerjaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Message --}}
                                <div class="col-md-12 mb-3">
                                    <label for="da-pesan" class="form-label">
                                        Message <span class="text-muted small">(optional)</span>
                                    </label>
                                    <textarea class="form-control @error('pesan_donatur') is-invalid @enderror"
                                              id="da-pesan" name="pesan_donatur"
                                              rows="3" maxlength="500"
                                              placeholder="Donor's message or prayer...">{{ old('pesan_donatur', $donation->pesan_donatur ?? '') }}</textarea>
                                    @error('pesan_donatur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Max 500 characters</div>
                                </div>

                                {{-- Anonymous --}}
                                <div class="col-md-12">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="da-anonymous" name="is_anonymous"
                                               value="1"
                                               {{ old('is_anonymous', ($donation->is_anonymous ?? false)) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="da-anonymous">
                                            Hide donor name from public donor list (Anonymous)
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════════════
                     PAYMENT INFORMATION
                     ══════════════════════════════════════════════════ --}}
                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="section-title mb-3">
                                <i class="fas fa-receipt me-2"></i>Payment Information
                            </h5>
                            <div class="row">

                                {{-- Campaign --}}
                                <div class="col-md-12 mb-3">
                                    <label for="da-campaign" class="form-label">
                                        Campaign <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('campaign_id') is-invalid @enderror"
                                            id="da-campaign" name="campaign_id" required>
                                        <option value="">-- Select Campaign --</option>
                                        @foreach($campaigns as $campaign)
                                            <option value="{{ $campaign->id }}"
                                                {{ old('campaign_id', $donation->campaign_id ?? '') == $campaign->id ? 'selected' : '' }}>
                                                {{ $campaign->judul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('campaign_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Donation Amount --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-jumlah-display" class="form-label">
                                        Donation Amount <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                           class="form-control da-amount-input @error('jumlah_donasi') is-invalid @enderror"
                                           id="da-jumlah-display"
                                           placeholder="Rp0"
                                           autocomplete="off">
                                    <input type="hidden" id="da-jumlah-hidden" name="jumlah_donasi"
                                           value="{{ old('jumlah_donasi', $donation->jumlah_donasi ?? '') }}">
                                    @error('jumlah_donasi')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Minimum Rp1.000</div>
                                </div>

                                {{-- Payment Method --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-metode" class="form-label">
                                        Payment Method <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('metode_pembayaran') is-invalid @enderror"
                                            id="da-metode" name="metode_pembayaran" required>
                                        @foreach(['CASH', 'QRIS', 'EWALLET', 'TRANSFER', 'BANK_TRANSFER', 'OTHER'] as $method)
                                            <option value="{{ $method }}"
                                                {{ old('metode_pembayaran', $donation->metode_pembayaran ?? 'CASH') === $method ? 'selected' : '' }}>
                                                {{ $method }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('metode_pembayaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Payment Status --}}
                                <div class="col-md-6 mb-3">
                                    <label for="da-status" class="form-label">
                                        Payment Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror"
                                            id="da-status" name="payment_status" required>
                                        @foreach(['PAID', 'PENDING', 'SETTLED', 'EXPIRED', 'FAILED'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('payment_status', $donation->payment_status ?? 'PAID') === $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">For CASH payments, status is automatically set to PAID.</div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Form Actions ────────────────────────────────── --}}
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <button type="button"
                                onclick="window.location.href='{{ route('admin.service.index.donation') }}'"
                                class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i>
                            {{ $isEdit ? 'Update Donation' : 'Save Donation' }}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
