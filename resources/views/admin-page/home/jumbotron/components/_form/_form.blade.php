@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $jumbotron = $jumbotron ?? null;

    $hasButton = $jumbotron && ($jumbotron->btnname || $jumbotron->btnlink);
    $defaultImage = 'https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm';
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">Jumbotron</span>
                @if($operation !== 'create' && $jumbotron)
                    <small class="text-muted d-block mt-2">{{ $jumbotron->title }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.jumbotron.store') : route('admin.jumbotron.update', $jumbotron->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Jumbotron Information -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Jumbotron Information</h5>

                                <div class="mb-3">
                                    <label for="title" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Title @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $jumbotron->title }}</div>
                                    @else
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                            value="{{ old('title', $jumbotron->title ?? '') }}"
                                            placeholder="Enter jumbotron title"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter a title for this jumbotron slide</div>
                                    @endif
                                </div>

                                @if ($operation !== 'view')
                                    <div class="mb-3">
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="toggleButton" {{ $hasButton ? 'checked' : '' }}>
                                            <span>Add Button to Jumbotron?</span>
                                        </label>
                                    </div>

                                    <div id="buttonFields" class="button-fields" style="display: {{ $hasButton ? 'block' : 'none' }};">
                                        <div class="mb-3">
                                            <label for="buttonname" class="form-label">Button Name</label>
                                            <input type="text" class="form-control" id="buttonname" name="buttonname"
                                                value="{{ old('buttonname', $jumbotron->btnname ?? '') }}"
                                                placeholder="e.g., Learn More">
                                            <div class="form-text">The text displayed on the button</div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="buttonlink" class="form-label">Button Link</label>
                                            <input type="text" class="form-control" id="buttonlink" name="buttonlink"
                                                value="{{ old('buttonlink', $jumbotron->btnlink ?? '') }}"
                                                placeholder="e.g., https://example.com">
                                            <div class="form-text">The URL the button will link to</div>
                                        </div>
                                    </div>
                                @else
                                    @if ($hasButton)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Button Name</label>
                                            <div class="form-control-plaintext">{{ $jumbotron->btnname ?: 'None' }}</div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Button Link</label>
                                            <div class="form-control-plaintext">
                                                @if($jumbotron->btnlink)
                                                    <a href="{{ $jumbotron->btnlink }}" target="_blank">{{ $jumbotron->btnlink }}</a>
                                                @else
                                                    None
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Button</label>
                                            <div class="form-control-plaintext text-muted">No button configured</div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($jumbotron->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($jumbotron->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($jumbotron->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($jumbotron->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Picture Upload -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-image me-2"></i>
                                    {{ $operation === 'view' ? 'Jumbotron Image' : ($operation === 'create' ? 'Upload Image' : 'Image Management') }}
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        @if($operation !== 'view')
                                            Picture @if($operation === 'create') <span class="text-danger">*</span> @endif
                                            <span class="small text-muted">(Recommended: 1440 x 560 pixels)</span>
                                        @else
                                            Current Image
                                        @endif
                                    </label>

                                    <div class="image-preview-container {{ ($jumbotron && $jumbotron->gdrive_id) ? 'has-image' : '' }} mb-3">
                                        <img id="imagePreview"
                                            src="{{ ($jumbotron && $jumbotron->gdrive_id) ? $jumbotron->getPictureUrl() : $defaultImage }}"
                                            alt="Jumbotron Preview">
                                    </div>

                                    @if ($operation !== 'view')
                                        <input type="file" class="form-control @error('picture') is-invalid @enderror" id="picture" name="picture"
                                            accept="image/jpeg,image/png,image/jpg"
                                            {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('picture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($operation === 'create')
                                                Upload a JPG, JPEG, or PNG image (max 5MB)
                                            @else
                                                Leave blank to keep current image. Upload new image to replace (max 5MB)
                                            @endif
                                        </div>
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
                        <a href="{{ route('admin.jumbotron.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create Jumbotron' : 'Update Jumbotron' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.jumbotron.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.jumbotron.edit', $jumbotron->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
