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
                <i class="fa fa-phone me-2"></i>
                <span>{{ ucfirst($titleForm) }}</span>
                <span class="highlighted-text ms-1">{{ $entityLabel }}</span>
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
                                    <label for="buttonName" class="form-label">Button Name <span class="text-danger">*</span></label>
                                    @if ($operation === 'view')
                                        <input type="text" class="form-control" value="{{ $callKestari->buttonName ?? 'N/A' }}" readonly>
                                    @else
                                        <input type="text" class="form-control @error('buttonName') is-invalid @enderror"
                                            id="buttonName" name="buttonName" value="{{ old('buttonName', $callKestari->buttonName ?? '') }}" required>
                                        @error('buttonName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                    <div class="form-text">Name that will appear on the button</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="appear" class="form-label">Appear Position <span class="text-danger">*</span></label>
                                    @if ($operation === 'view')
                                        <div class="mt-2">
                                            @if($callKestari->appear == 'Up')
                                                <span class="badge bg-primary">Up</span>
                                            @else
                                                <span class="badge bg-secondary">Down</span>
                                            @endif
                                        </div>
                                    @else
                                        <select class="form-select @error('appear') is-invalid @enderror" id="appear" name="appear" required>
                                            <option value="">Select Position</option>
                                            <option value="Up" {{ old('appear', $callKestari->appear ?? '') == 'Up' ? 'selected' : '' }}>Up</option>
                                            <option value="Down" {{ old('appear', $callKestari->appear ?? '') == 'Down' ? 'selected' : '' }}>Down</option>
                                        </select>
                                        @error('appear')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                    <div class="form-text">Position where this button will appear</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Link <span class="text-danger">*</span></label>
                            @if ($operation === 'view')
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $callKestari->link ?? 'N/A' }}" readonly>
                                    <button class="btn btn-custom-primary" type="button"
                                        onclick="copyLink('{{ $callKestari->link }}', false)">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                    <a href="{{ $callKestari->link }}" target="_blank" class="btn btn-custom-primary">
                                        <i class="fa fa-external-link-alt"></i>
                                    </a>
                                </div>
                            @else
                                <input type="url" class="form-control @error('link') is-invalid @enderror"
                                    id="link" name="link" value="{{ old('link', $callKestari->link ?? '') }}" required placeholder="https://example.com">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            @endif
                            <div class="form-text">Full URL including https://</div>
                        </div>

                        @if ($operation === 'view')
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Created At</b></label>
                                        <input type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($callKestari->created_at)->isoFormat('dddd, DD MMMM YYYY HH:mm') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label"><b>Updated At</b></label>
                                        <input type="text" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($callKestari->updated_at)->isoFormat('dddd, DD MMMM YYYY HH:mm') }}" readonly>
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
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.service.callkestari.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.service.callkestari.edit', $callKestari->id) }}" class="btn btn-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif

            @if ($operation !== 'view')
                </form>
            @endif
        </div>
    </div>
</div>
