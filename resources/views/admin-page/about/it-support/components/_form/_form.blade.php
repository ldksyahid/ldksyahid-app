@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $itsupport = $itsupport ?? null;

@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">IT Support</span>
                @if($operation !== 'create' && $itsupport)
                    <small class="text-muted d-block mt-2">{{ $itsupport->name }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.about.itsupport.store') : route('admin.about.itsupport.update', $itsupport->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <!-- Personal Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Name @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $itsupport->name }}</div>
                                    @else
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                            value="{{ old('name', $itsupport->name ?? '') }}"
                                            placeholder="Enter name"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="forkat" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Forkat @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $itsupport->forkat }}</div>
                                    @else
                                        <input type="text" class="form-control @error('forkat') is-invalid @enderror" id="forkat" name="forkat"
                                            value="{{ old('forkat', $itsupport->forkat ?? '') }}"
                                            placeholder="Enter forkat"
                                            required>
                                        @error('forkat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="position" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Position @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $itsupport->position }}</div>
                                    @else
                                        <input type="text" class="form-control @error('position') is-invalid @enderror" id="position" name="position"
                                            value="{{ old('position', $itsupport->position ?? '') }}"
                                            placeholder="Enter position"
                                            required>
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>

                            @if ($operation === 'view')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($itsupport->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($itsupport->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($itsupport->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($itsupport->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Profile -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-image me-2"></i>
                            Photo Profile @if($operation === 'create') <span class="text-danger">*</span> @endif
                        </h5>
                        <div class="text-center mb-3">
                            <div class="image-preview-container {{ ($itsupport && $itsupport->gdrive_id) ? 'has-image' : '' }}">
                                @if($itsupport && $itsupport->gdrive_id)
                                    <img id="photoProfilePreview" src="{{ $itsupport->getPhotoProfileUrl() }}" alt="Photo Profile Preview">
                                @else
                                    <img id="photoProfilePreview" src="" alt="Photo Profile Preview" style="display:none;">
                                    <x-svg-placeholder />
                                @endif
                            </div>
                        </div>
                        @if ($operation !== 'view')
                            <input type="file" class="form-control @error('photoProfile') is-invalid @enderror" id="photoProfile" name="photoProfile"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                {{ $operation === 'create' ? 'required' : '' }}>
                            @error('photoProfile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-center">
                                @if($operation === 'create')
                                    Upload a JPG, JPEG, PNG, or WebP image (300 x 350 Pixel, max 5MB)
                                @else
                                    Leave blank to keep current image. Upload new image to replace (max 5MB)
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Social Links -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-link me-2"></i>Social Links</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkInstagram" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Instagram Link @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($itsupport->linkInstagram)
                                                <a href="{{ $itsupport->linkInstagram }}" target="_blank">{{ $itsupport->linkInstagram }}</a>
                                            @else
                                                <span class="text-muted">Not provided</span>
                                            @endif
                                        </div>
                                    @else
                                        <input type="text" class="form-control @error('linkInstagram') is-invalid @enderror" id="linkInstagram" name="linkInstagram"
                                            value="{{ old('linkInstagram', $itsupport->linkInstagram ?? '') }}"
                                            placeholder="https://instagram.com/..."
                                            required>
                                        @error('linkInstagram')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkLinkedin" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Linkedin Link @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($itsupport->linkLinkedin)
                                                <a href="{{ $itsupport->linkLinkedin }}" target="_blank">{{ $itsupport->linkLinkedin }}</a>
                                            @else
                                                <span class="text-muted">Not provided</span>
                                            @endif
                                        </div>
                                    @else
                                        <input type="text" class="form-control @error('linkLinkedin') is-invalid @enderror" id="linkLinkedin" name="linkLinkedin"
                                            value="{{ old('linkLinkedin', $itsupport->linkLinkedin ?? '') }}"
                                            placeholder="https://linkedin.com/in/..."
                                            required>
                                        @error('linkLinkedin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.about.itsupport.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create IT Support' : 'Update IT Support' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.about.itsupport.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.about.itsupport.edit', $itsupport->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
