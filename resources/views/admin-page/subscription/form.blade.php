@extends('admin-page.template.body')

@php $operation = $operation ?? 'edit'; @endphp

@section('styles')
<style>
    .page-title {
        font-size: 1.65rem;
        font-weight: 600;
        text-align: center;
        color: #00a79d;
        margin: .75rem 0 1.5rem;
        position: relative;
        display: inline-block;
    }
    .page-title::after {
        content: '';
        display: block;
        height: 4px;
        width: 120px;
        margin: .35rem auto 0;
        border-radius: 3px;
        background: linear-gradient(90deg,#00a79d 0%,#008b84 100%);
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #00a79d;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e0f7f5;
    }
    .btn-custom-primary {
        color: #fff;
        background-color: #00a79d;
        border: 1px solid #00a79d;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background-color: #008b84;
        border-color: #008b84;
        color: #fff;
    }
    .btn-custom-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .form-control:focus, .form-select:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .form-text { font-size: 0.8rem; color: #6c757d; }
    .form-label.fw-bold { color: #495057; font-weight: 600; }
    .form-control-plaintext {
        padding: 0.375rem 0;
        line-height: 1.5;
        min-height: 38px;
        display: flex;
        align-items: center;
    }
    .info-label { font-size: 0.85rem; color: #6c757d; font-weight: 600; margin-bottom: 0.25rem; }
    .info-value { font-size: 0.95rem; color: #212529; }
    @media (max-width: 768px) {
        .page-title { font-size: 1.35rem; }
        .card-body { padding: 1rem; }
        .d-flex.justify-content-end.gap-2 { flex-direction: column; }
        .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'view' ? 'eye' : 'edit' }} me-2"></i>
                <span>{{ $operation === 'view' ? 'View' : 'Edit' }}</span>
                <span class="ms-1" style="color:#008b84;font-weight:700;">Subscriber</span>
                <small class="text-muted d-block mt-2" style="font-size:0.9rem;">{{ $subscription->email }}</small>
            </h1>

            {{-- Validation Errors (edit mode only) --}}
            @if ($operation !== 'view' && $errors->any())
                <div class="col-md-12 mb-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>There were some problems with your input:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if ($operation !== 'view')
                <form action="{{ route('admin.subscription.update', $subscription->subscriberID) }}" method="POST">
                    @csrf
                    @method('PUT')
            @endif

            {{-- Subscriber Information --}}
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-user me-2"></i>Subscriber Information</h5>

                        <div class="row">
                            <div class="col-md-6">
                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Email
                                        @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $subscription->email }}</div>
                                    @else
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $subscription->email) }}"
                                            required
                                        >
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter the subscriber's email address</div>
                                    @endif
                                </div>

                                {{-- Status --}}
                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Status
                                        @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($subscription->flagActive)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="d-flex gap-3 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flagActive" id="statusActive" value="1"
                                                    {{ old('flagActive', $subscription->flagActive ? '1' : '0') == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label text-success fw-semibold" for="statusActive">
                                                    <i class="fa fa-check-circle me-1"></i> Active
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="flagActive" id="statusInactive" value="0"
                                                    {{ old('flagActive', $subscription->flagActive ? '1' : '0') == '0' ? 'checked' : '' }}>
                                                <label class="form-check-label text-secondary fw-semibold" for="statusInactive">
                                                    <i class="fa fa-times-circle me-1"></i> Inactive
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- Read-only date info --}}
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <p class="info-label">Subscribed Date</p>
                                        <p class="info-value">
                                            {{ $subscription->subscribedDate ? $subscription->subscribedDate->isoFormat('DD MMM YYYY, HH:mm') : '-' }}
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="info-label">Unsubscribed Date</p>
                                        <p class="info-value">
                                            {{ $subscription->unsubscribedDate ? $subscription->unsubscribedDate->isoFormat('DD MMM YYYY, HH:mm') : '-' }}
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="info-label">Created Date</p>
                                        <p class="info-value">
                                            {{ $subscription->createdDate ? $subscription->createdDate->isoFormat('DD MMM YYYY, HH:mm') : '-' }}
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="info-label">Last Updated</p>
                                        <p class="info-value">
                                            {{ $subscription->editedDate ? $subscription->editedDate->isoFormat('DD MMM YYYY, HH:mm') : '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.subscription.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
                </form>
            @else
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.subscription.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.subscription.edit', $subscription->subscriberID) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
