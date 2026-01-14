@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $testimony = $testimony ?? null;

    $defaultImage = 'https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm';
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">Testimony</span>
                @if($operation !== 'create' && $testimony)
                    <small class="text-muted d-block mt-2">{{ $testimony->name }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.testimony.store') : route('admin.testimony.update', $testimony->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Profile Picture -->
                            <div class="col-md-4 text-center">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-user-circle me-2"></i>
                                    {{ $operation === 'view' ? 'Profile Picture' : ($operation === 'create' ? 'Upload Photo' : 'Photo Management') }}
                                </h5>

                                <div class="mb-3 d-flex flex-column align-items-center">
                                    <div class="image-preview-container {{ ($testimony && $testimony->gdrive_id) ? 'has-image' : '' }} mb-3">
                                        <img id="imagePreview"
                                            src="{{ ($testimony && $testimony->gdrive_id) ? $testimony->getPictureUrl() : $defaultImage }}"
                                            alt="Profile Preview">
                                    </div>

                                    @if ($operation !== 'view')
                                        <input type="file" class="form-control @error('picture') is-invalid @enderror" id="picture" name="picture"
                                            accept="image/jpeg,image/png,image/jpg"
                                            style="max-width: 300px;"
                                            {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text mt-2">
                                            @if($operation === 'create')
                                                Upload a JPG, JPEG, or PNG image (max 5MB)
                                            @else
                                                Leave blank to keep current image
                                            @endif
                                        </div>
                                        <small class="text-muted">Recommended: 100 x 100 pixels</small>
                                    @endif
                                </div>
                            </div>

                            <!-- Testimony Information -->
                            <div class="col-md-8">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Testimony Information</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Name @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $testimony->name }}</div>
                                        @else
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                                value="{{ old('name', $testimony->name ?? '') }}"
                                                placeholder="Enter full name"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="profession" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Profession @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $testimony->profession }}</div>
                                        @else
                                            <input type="text" class="form-control @error('profession') is-invalid @enderror" id="profession" name="profession"
                                                value="{{ old('profession', $testimony->profession ?? '') }}"
                                                placeholder="e.g., Student, Lecturer, Alumni"
                                                required>
                                            @error('profession')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="testimony" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Testimony @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext testimony-text">
                                            "{{ $testimony->testimony }}"
                                        </div>
                                    @else
                                        <textarea class="form-control @error('testimony') is-invalid @enderror" id="testimony" name="testimony"
                                            rows="4" maxlength="250"
                                            placeholder="Enter the testimony content (max 250 characters)"
                                            required>{{ old('testimony', $testimony->testimony ?? '') }}</textarea>
                                        @error('testimony')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="d-flex justify-content-between align-items-center mt-1">
                                            <div class="form-text">Share your experience or thoughts</div>
                                            <span id="charCounter" class="char-counter">0/250 characters</span>
                                        </div>
                                    @endif
                                </div>

                                @if ($operation === 'view')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Created At</label>
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($testimony->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                                <small class="text-muted">({{ \Carbon\Carbon::parse($testimony->created_at)->format('H:i T') }})</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Last Updated</label>
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($testimony->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                                <small class="text-muted">({{ \Carbon\Carbon::parse($testimony->updated_at)->format('H:i T') }})</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.testimony.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create Testimony' : 'Update Testimony' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.testimony.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.testimony.edit', $testimony->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
