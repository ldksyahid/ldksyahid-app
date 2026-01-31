@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $gallery = $gallery ?? null;

@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">Gallery</span>
                @if($operation !== 'create' && $gallery)
                    <small class="text-muted d-block mt-2">{{ $gallery->eventName }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.about.gallery.store') : route('admin.about.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <!-- Event Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Event Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="eventName" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Event Name @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $gallery->eventName }}</div>
                                    @else
                                        <input type="text" class="form-control @error('eventName') is-invalid @enderror" id="eventName" name="eventName"
                                            value="{{ old('eventName', $gallery->eventName ?? '') }}"
                                            placeholder="Enter event name"
                                            required>
                                        @error('eventName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="eventTheme" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Event Theme @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $gallery->eventTheme }}</div>
                                    @else
                                        <input type="text" class="form-control @error('eventTheme') is-invalid @enderror" id="eventTheme" name="eventTheme"
                                            value="{{ old('eventTheme', $gallery->eventTheme ?? '') }}"
                                            placeholder="Enter event theme"
                                            required>
                                        @error('eventTheme')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="eventDescription" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Event Description @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $gallery->eventDescription }}</div>
                                    @else
                                        <textarea class="form-control @error('eventDescription') is-invalid @enderror" id="eventDescription" name="eventDescription"
                                            rows="3" placeholder="Enter event description" required>{{ old('eventDescription', $gallery->eventDescription ?? '') }}</textarea>
                                        @error('eventDescription')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkEmbedYoutube" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Embed Youtube Link
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($gallery->linkEmbedYoutube)
                                                <a href="{{ $gallery->linkEmbedYoutube }}" target="_blank">{{ $gallery->linkEmbedYoutube }}</a>
                                            @else
                                                <span class="text-muted">Not provided</span>
                                            @endif
                                        </div>
                                    @else
                                        <input type="url" class="form-control @error('linkEmbedYoutube') is-invalid @enderror" id="linkEmbedYoutube" name="linkEmbedYoutube"
                                            value="{{ old('linkEmbedYoutube', $gallery->linkEmbedYoutube ?? '') }}"
                                            placeholder="https://youtube.com/...">
                                        @error('linkEmbedYoutube')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkDoc" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Documentation Link
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($gallery->linkDoc)
                                                <a href="{{ $gallery->linkDoc }}" target="_blank">{{ $gallery->linkDoc }}</a>
                                            @else
                                                <span class="text-muted">Not provided</span>
                                            @endif
                                        </div>
                                    @else
                                        <input type="url" class="form-control @error('linkDoc') is-invalid @enderror" id="linkDoc" name="linkDoc"
                                            value="{{ old('linkDoc', $gallery->linkDoc ?? '') }}"
                                            placeholder="https://...">
                                        @error('linkDoc')
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
                                            {{ \Carbon\Carbon::parse($gallery->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($gallery->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($gallery->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($gallery->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Group Photo -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3">
                            <i class="fas fa-image me-2"></i>
                            Group Photo @if($operation === 'create') <span class="text-danger">*</span> @endif
                        </h5>
                        <div class="text-center mb-3">
                            <div class="image-preview-container group-photo {{ ($gallery && $gallery->gdrive_id) ? 'has-image' : '' }}">
                                @if($gallery && $gallery->gdrive_id)
                                    <img id="groupPhotoPreview" src="{{ $gallery->getGroupPhotoUrl() }}" alt="Group Photo Preview">
                                @else
                                    <img id="groupPhotoPreview" src="" alt="Group Photo Preview" style="display:none;">
                                    <x-svg-placeholder />
                                @endif
                            </div>
                        </div>
                        @if ($operation !== 'view')
                            <input type="file" class="form-control @error('groupPhoto') is-invalid @enderror" id="groupPhoto" name="groupPhoto"
                                accept="image/jpeg,image/png,image/jpg"
                                {{ $operation === 'create' ? 'required' : '' }}>
                            @error('groupPhoto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-center">
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

            <!-- Additional Photos -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-images me-2"></i>Additional Photos (Optional)</h5>
                        <div class="row">
                            @for($i = 1; $i <= 12; $i++)
                                <div class="col-md-4 col-lg-3 mb-3">
                                    <label for="photo{{ $i }}" class="form-label">Photo {{ $i }}</label>
                                    <div class="image-preview-container small-preview {{ ($gallery && $gallery->getPhotoUrl($i)) ? 'has-image' : '' }} mb-2">
                                        @if($gallery && $gallery->getPhotoUrl($i))
                                            <img id="photoPreview{{ $i }}" src="{{ $gallery->getPhotoUrl($i) }}" alt="Photo {{ $i }} Preview">
                                        @else
                                            <img id="photoPreview{{ $i }}" src="" alt="Photo {{ $i }} Preview" style="display:none;">
                                            <x-svg-placeholder height="150" />
                                        @endif
                                    </div>
                                    @if ($operation !== 'view')
                                        <input type="file" class="form-control form-control-sm" id="photo{{ $i }}" name="photo{{ $i }}"
                                            accept="image/jpeg,image/png,image/jpg">
                                    @endif
                                </div>
                            @endfor
                        </div>
                        @if ($operation !== 'view')
                            <div class="form-text text-end">
                                <i class="fas fa-info-circle me-1"></i>
                                Insert photos gradually (maximum 4 photos at a time), then update to re-insert.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.about.gallery.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create Gallery' : 'Update Gallery' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.about.gallery.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.about.gallery.edit', $gallery->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
