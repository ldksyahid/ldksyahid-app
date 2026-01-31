@php
    $operation = $operation ?? 'create';
    $callKestari = $callKestari ?? null;
    $titleForm = $titleForm ?? '';
    $entityLabel = $entityLabel ?? 'Call Kestari';
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ ucfirst($titleForm) }}</span>
                <span class="highlighted-text ms-1">{{ $entityLabel }}</span>
                @if($operation !== 'create' && $callKestari)
                    <small class="text-muted d-block mt-2">{{ $callKestari->buttonName }}</small>
                @endif
            </h1>

            @if ($operation !== 'view')
                <div class="col-md-12 my-3">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>There were some problems with your input:</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
            @endif

            @if ($operation !== 'view')
                <form action="{{ $operation === 'create' ? route('admin.service.callkestari.store') : route('admin.service.callkestari.update', $callKestari->id) }}" method="POST">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Call Kestari Information</h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="buttonName" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Button Name @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $callKestari->buttonName ?? 'N/A' }}</div>
                                    @else
                                        <input type="text" class="form-control @error('buttonName') is-invalid @enderror"
                                            id="buttonName" name="buttonName" value="{{ old('buttonName', $callKestari->buttonName ?? '') }}" required>
                                        @error('buttonName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Name that will appear on the button</div>
                                    @endif
                                </div>
                            </div>

                            @if ($operation !== 'view')
                                <input type="hidden" name="appear" value="Up">
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                Link @if($operation !== 'view') <span class="text-danger">*</span> @endif
                            </label>
                            @if ($operation === 'view')
                                <div class="form-control-plaintext">
                                    <a href="{{ $callKestari->link }}" target="_blank">{{ $callKestari->link }}</a>
                                    <button class="btn btn-sm btn-custom-primary ms-2" type="button"
                                        onclick="copyLink('{{ $callKestari->link }}', false)">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                            @else
                                <input type="url" class="form-control @error('link') is-invalid @enderror"
                                    id="link" name="link" value="{{ old('link', $callKestari->link ?? '') }}" required placeholder="https://example.com">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Full URL including https://</div>
                            @endif
                        </div>

                        @if ($operation === 'view')
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($callKestari->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($callKestari->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($callKestari->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($callKestari->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <button type="button" onclick="window.location.href='{{ route('admin.service.callkestari.index') }}'" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Save Call Kestari' : 'Update Call Kestari' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.service.callkestari.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.service.callkestari.edit', $callKestari->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
