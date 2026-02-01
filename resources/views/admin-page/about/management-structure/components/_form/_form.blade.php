@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $structure = $structure ?? null;

@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">Structure</span>
                @if($operation !== 'create' && $structure)
                    <small class="text-muted d-block mt-2">{{ $structure->structureName }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.about.structure.store') : route('admin.about.structure.update', $structure->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Structure Information -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Structure Information</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="batch" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Batch @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $structure->batch }}</div>
                                        @else
                                            <input type="text" class="form-control @error('batch') is-invalid @enderror" id="batch" name="batch"
                                                value="{{ old('batch', $structure->batch ?? '') }}"
                                                placeholder="e.g., 25"
                                                required>
                                            @error('batch')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Enter the batch number</div>
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="period" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Period @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $structure->period }}</div>
                                        @else
                                            <input type="text" class="form-control @error('period') is-invalid @enderror" id="period" name="period"
                                                value="{{ old('period', $structure->period ?? '') }}"
                                                placeholder="e.g., 2023"
                                                required>
                                            @error('period')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <div class="form-text">Enter the period (e.g., 2023)</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="structureName" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Structure Name @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $structure->structureName }}</div>
                                    @else
                                        <input type="text" class="form-control @error('structureName') is-invalid @enderror" id="structureName" name="structureName"
                                            value="{{ old('structureName', $structure->structureName ?? '') }}"
                                            placeholder="Enter structure name"
                                            required>
                                        @error('structureName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter the name of the organizational structure</div>
                                    @endif
                                </div>

                                @if ($operation === 'view')
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($structure->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($structure->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($structure->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($structure->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Structure Description -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-align-left me-2"></i>Structure Description</h5>

                                <div class="mb-3">
                                    <label for="structureDescription" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Description @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $structure->structureDescription }}</div>
                                    @else
                                        <textarea class="form-control @error('structureDescription') is-invalid @enderror" id="structureDescription" name="structureDescription"
                                            rows="5"
                                            placeholder="Enter structure description"
                                            required>{{ old('structureDescription', $structure->structureDescription ?? '') }}</textarea>
                                        @error('structureDescription')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Describe the organizational structure</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Structure Images -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-images me-2"></i>Structure Images</h5>

                        <div class="row">
                            <!-- Structure Logo -->
                            <div class="col-md-6 mb-4">
                                <h6 class="mb-3 text-muted">
                                    <i class="fas fa-image me-2"></i>
                                    {{ $operation === 'view' ? 'Structure Logo' : ($operation === 'create' ? 'Upload Logo' : 'Logo Management') }}
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        @if($operation !== 'view')
                                            Logo @if($operation === 'create') <span class="text-danger">*</span> @endif
                                            <span class="small text-muted">(No Background 1080 x 1080 pixels)</span>
                                        @else
                                            Current Logo
                                        @endif
                                    </label>

                                    <div class="image-preview-container {{ ($structure && $structure->gdrive_id) ? 'has-image' : '' }} mb-3">
                                        @if($structure && $structure->gdrive_id)
                                            <img id="logoPreview" src="{{ $structure->getLogoUrl() }}" alt="Logo Preview" style="max-height: 300px;">
                                        @else
                                            <img id="logoPreview" src="" alt="Logo Preview" style="display:none; max-height: 300px;">
                                            <x-svg-placeholder />
                                        @endif
                                    </div>

                                    @if ($operation !== 'view')
                                        <input type="file" class="form-control @error('structureLogo') is-invalid @enderror" id="structureLogo" name="structureLogo"
                                            accept="image/jpeg,image/png,image/jpg"
                                            {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('structureLogo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($operation === 'create')
                                                Upload a transparent PNG logo (max 5MB)
                                            @else
                                                Leave blank to keep current logo. Upload new image to replace (max 5MB)
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Structure Image -->
                            <div class="col-md-6 mb-4">
                                <h6 class="mb-3 text-muted">
                                    <i class="fas fa-image me-2"></i>
                                    {{ $operation === 'view' ? 'Structure Image' : ($operation === 'create' ? 'Upload Structure Image' : 'Structure Image Management') }}
                                </h6>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        @if($operation !== 'view')
                                            Structure Image @if($operation === 'create') <span class="text-danger">*</span> @endif
                                            <span class="small text-muted">(1515 x >=2560 pixels)</span>
                                        @else
                                            Current Structure Image
                                        @endif
                                    </label>

                                    <div class="image-preview-container {{ ($structure && $structure->gdrive_id_2) ? 'has-image' : '' }} mb-3">
                                        @if($structure && $structure->gdrive_id_2)
                                            <img id="imagePreview" src="{{ $structure->getStructureImageUrl() }}" alt="Structure Image Preview" style="max-height: 300px;">
                                        @else
                                            <img id="imagePreview" src="" alt="Structure Image Preview" style="display:none; max-height: 300px;">
                                            <x-svg-placeholder />
                                        @endif
                                    </div>

                                    @if ($operation !== 'view')
                                        <input type="file" class="form-control @error('structureImage') is-invalid @enderror" id="structureImage" name="structureImage"
                                            accept="image/jpeg,image/png,image/jpg"
                                            {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('structureImage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($operation === 'create')
                                                Upload a JPG, JPEG, or PNG structure image (max 5MB)
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
                        <a href="{{ route('admin.about.structure.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create Structure' : 'Update Structure' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.about.structure.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.about.structure.edit', $structure->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
