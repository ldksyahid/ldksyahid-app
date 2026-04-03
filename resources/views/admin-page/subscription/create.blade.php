@extends('admin-page.template.body')

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
    .form-control:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .form-text { font-size: 0.8rem; color: #6c757d; }
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
                <i class="fa fa-plus-circle me-2"></i>
                <span>Add</span>
                <span class="ms-1" style="color:#008b84;font-weight:700;">Subscribers</span>
            </h1>

            {{-- Validation Errors --}}
            @if ($errors->any())
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

            <form action="{{ route('admin.subscription.store') }}" method="POST">
                @csrf

                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="section-title mb-3"><i class="fas fa-envelope me-2"></i>Email List</h5>

                            <p class="text-muted mb-3">
                                Enter one or more emails. Separate each email with a <strong>new line</strong> or <strong>comma</strong>.
                                Emails that are already registered and active will be skipped automatically.
                            </p>

                            <div class="mb-3">
                                <label for="emails" class="form-label">Email List <span class="text-danger">*</span></label>
                                <textarea
                                    id="emails"
                                    name="emails"
                                    class="form-control font-monospace @error('emails') is-invalid @enderror"
                                    rows="10"
                                    placeholder="user1@example.com&#10;user2@example.com&#10;user3@example.com"
                                    required
                                >{{ old('emails') }}</textarea>
                                @error('emails')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">One email per line, or separate with commas.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.subscription.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-plus me-1"></i> Add Subscribers
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
