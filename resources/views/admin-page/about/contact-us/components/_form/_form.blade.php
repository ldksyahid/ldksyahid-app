@php
    $operation = $operation ?? 'view';
    $data = $data ?? null;
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-eye me-2"></i>
                <span>View</span>
                <span class="highlighted-text ms-1">Contact Message</span>
                @if($data)
                    <small class="text-muted d-block mt-2">{{ $data->subject }}</small>
                @endif
            </h1>

            <!-- Sender Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-user me-2"></i>Sender Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <div class="form-control-plaintext">{{ $data->name }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Email Address</label>
                                    <div class="form-control-plaintext">
                                        <a href="mailto:{{ $data->email }}">{{ $data->email }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subject</label>
                                    <div class="form-control-plaintext">{{ $data->subject }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date</label>
                                    <div class="form-control-plaintext">
                                        {{ \Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                        <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($data->created_at)->format('H:i T') }})</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-envelope-open-text me-2"></i>Message</h5>
                        <div class="border rounded p-3 bg-white" style="min-height: 100px; white-space: pre-wrap;">{{ $data->message }}</div>
                    </div>
                </div>
            </div>

            <!-- View Mode Actions -->
            <div class="row mb-5">
                <div class="col-md-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.about.contact.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
