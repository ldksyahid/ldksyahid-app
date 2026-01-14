@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $schedule = $schedule ?? null;

    $defaultImage = 'https://lh3.googleusercontent.com/d/1STslQ7I3qeakz_Pu5ZY5V8RcsxxcrqOm';
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">Schedule</span>
                @if($operation !== 'create' && $schedule)
                    <small class="text-muted d-block mt-2">{{ $schedule->title }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.schedule.store') : route('admin.schedule.update', $schedule->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Picture Upload -->
                            <div class="col-md-4">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-image me-2"></i>
                                    {{ $operation === 'view' ? 'Schedule Image' : ($operation === 'create' ? 'Upload Image' : 'Image Management') }}
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        @if($operation !== 'view')
                                            Picture @if($operation === 'create') <span class="text-danger">*</span> @endif
                                            <span class="small text-muted d-block">(1080 x 1350 pixels)</span>
                                        @else
                                            Current Image
                                        @endif
                                    </label>

                                    <div class="image-preview-container {{ ($schedule && $schedule->gdrive_id) ? 'has-image' : '' }} mb-3">
                                        <img id="imagePreview"
                                            src="{{ ($schedule && $schedule->gdrive_id) ? $schedule->getPictureUrl() : $defaultImage }}"
                                            alt="Schedule Preview">
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
                                                Leave blank to keep current image
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Schedule Information -->
                            <div class="col-md-8">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Schedule Information</h5>

                                <div class="mb-3">
                                    <label for="title" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Title @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $schedule->title }}</div>
                                    @else
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                            value="{{ old('title', $schedule->title ?? '') }}"
                                            placeholder="Enter schedule title"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter a title for this schedule</div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="month" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Month @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $schedule->month }}</div>
                                        @else
                                            <input type="text" class="form-control @error('month') is-invalid @enderror" id="month" name="month"
                                                value="{{ old('month', $schedule->month ?? '') }}"
                                                placeholder="e.g., January, February"
                                                required>
                                            @error('month')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="year" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Year @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $schedule->year }}</div>
                                        @else
                                            <input type="text" class="form-control @error('year') is-invalid @enderror" id="year" name="year"
                                                value="{{ old('year', $schedule->year ?? '') }}"
                                                placeholder="e.g., 2024"
                                                required>
                                            @error('year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                </div>

                                @if ($operation === 'view')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Created At</label>
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($schedule->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                                <small class="text-muted">({{ \Carbon\Carbon::parse($schedule->created_at)->format('H:i T') }})</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Last Updated</label>
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($schedule->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                                <small class="text-muted">({{ \Carbon\Carbon::parse($schedule->updated_at)->format('H:i T') }})</small>
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
                        <a href="{{ route('admin.schedule.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create Schedule' : 'Update Schedule' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.schedule.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.schedule.edit', $schedule->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
