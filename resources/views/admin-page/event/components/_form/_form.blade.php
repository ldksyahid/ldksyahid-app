@php
    $operation = $operation ?? 'create';
    $event = $event ?? null;
    $titleForm = $titleForm ?? '';
    $entityLabel = $entityLabel ?? 'Event';
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-calendar-alt me-2"></i>
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
                <form action="{{ $operation === 'create' ? route('admin.event.store') : route('admin.event.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                        value="{{ old('title', $event->title ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="division" class="form-label">Event Organizer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('division') is-invalid @enderror" id="division" name="division"
                                        value="{{ old('division', $event->division ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('division')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="tag" class="form-label">Tag <span class="text-danger">*</span></label>
                                    @if ($operation === 'view')
                                        <input type="text" class="form-control" value="{{ $event->tag ?? 'N/A' }}" readonly>
                                    @else
                                        <select class="form-select @error('tag') is-invalid @enderror" id="tag" name="tag" required>
                                            <option value="">Select Tag</option>
                                            <option value="Seminar" {{ old('tag', $event->tag ?? '') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                            <option value="Pelatihan" {{ old('tag', $event->tag ?? '') == 'Pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                        </select>
                                    @endif
                                    @error('tag')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location"
                                        value="{{ old('location', $event->location ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="place" class="form-label">Place Type <span class="text-danger">*</span></label>
                                    @if ($operation === 'view')
                                        <input type="text" class="form-control" value="{{ $event->place ?? 'N/A' }}" readonly>
                                    @else
                                        <select class="form-select @error('place') is-invalid @enderror" id="place" name="place" required>
                                            <option value="">Select Place Type</option>
                                            <option value="Online" {{ old('place', $event->place ?? '') == 'Online' ? 'selected' : '' }}>Online</option>
                                            <option value="Offline" {{ old('place', $event->place ?? '') == 'Offline' ? 'selected' : '' }}>Offline</option>
                                            <option value="Hybrid" {{ old('place', $event->place ?? '') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        </select>
                                    @endif
                                    @error('place')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="linkLocation" class="form-label">Link Location</label>
                                    <input type="url" class="form-control @error('linkLocation') is-invalid @enderror" id="linkLocation" name="linkLocation"
                                        value="{{ old('linkLocation', $event->linkLocation ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : '' }}
                                        placeholder="https://example.com">
                                    @error('linkLocation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional - Link to event location (Google Maps, Zoom, etc.)</div>
                                </div>
                            </div>

                            <!-- Schedule & Links -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-clock me-2"></i>Schedule & Registration</h5>

                                <div class="mb-3">
                                    <label for="start" class="form-label">Start Event <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('start') is-invalid @enderror" id="start" name="start"
                                        value="{{ old('start', ($event && $event->start) ? \Carbon\Carbon::parse($event->start)->format('Y-m-d\TH:i') : '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('start')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="finished" class="form-label">Event Finished <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('finished') is-invalid @enderror" id="finished" name="finished"
                                        value="{{ old('finished', ($event && $event->finished) ? \Carbon\Carbon::parse($event->finished)->format('Y-m-d\TH:i') : '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('finished')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="closeRegist" class="form-label">Close Registration <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('closeRegist') is-invalid @enderror" id="closeRegist" name="closeRegist"
                                        value="{{ old('closeRegist', ($event && $event->closeRegist) ? \Carbon\Carbon::parse($event->closeRegist)->format('Y-m-d\TH:i') : '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('closeRegist')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="linkRegist" class="form-label">Link Registration <span class="text-danger">*</span></label>
                                    <input type="url" class="form-control @error('linkRegist') is-invalid @enderror" id="linkRegist" name="linkRegist"
                                        value="{{ old('linkRegist', $event->linkRegist ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}
                                        placeholder="https://example.com/register">
                                    @error('linkRegist')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="linkDoc" class="form-label">Link Documentation</label>
                                    <input type="url" class="form-control @error('linkDoc') is-invalid @enderror" id="linkDoc" name="linkDoc"
                                        value="{{ old('linkDoc', $event->linkDoc ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : '' }}
                                        placeholder="https://example.com/docs">
                                    @error('linkDoc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional - Link to event documentation</div>
                                </div>

                                <div class="mb-3">
                                    <label for="linkPresent" class="form-label">Link Presentation</label>
                                    <input type="url" class="form-control @error('linkPresent') is-invalid @enderror" id="linkPresent" name="linkPresent"
                                        value="{{ old('linkPresent', $event->linkPresent ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : '' }}
                                        placeholder="https://example.com/slides">
                                    @error('linkPresent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional - Link to presentation slides</div>
                                </div>
                            </div>
                        </div>

                        <!-- Broadcast Section -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5 class="section-title mb-3"><i class="fas fa-bullhorn me-2"></i>Broadcast Message</h5>

                                <div class="mb-3">
                                    <label for="broadcast" class="form-label">Broadcast Event <span class="text-danger">*</span></label>
                                    @if ($operation === 'view')
                                        <div class="border p-4 rounded bg-white">
                                            {!! $event->broadcast !!}
                                        </div>
                                    @else
                                        <textarea class="form-control @error('broadcast') is-invalid @enderror" id="broadcast" name="broadcast" rows="5" required>{{ old('broadcast', $event->broadcast ?? '') }}</textarea>
                                    @endif
                                    @error('broadcast')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Poster & Contact Person -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-image me-2"></i>Event Poster</h5>

                                @if ($operation === 'view')
                                    <div class="mb-3">
                                        <div>
                                            @if($event->gdrive_id)
                                                <img src="https://lh3.googleusercontent.com/d/{{ $event->gdrive_id }}" alt="Event Poster" class="img-thumbnail" style="max-height: 300px;">
                                            @else
                                                <div class="no-image-placeholder bg-light p-4 text-center rounded border" style="max-height: 300px;">
                                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                    <p class="mb-0">No Poster Image</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="poster" class="form-label">
                                            {{ $operation === 'create' ? 'Upload Poster' : 'Update Poster' }}
                                            @if($operation === 'create')
                                                <span class="text-danger">*</span>
                                            @else
                                                (Optional)
                                            @endif
                                        </label>
                                        <div class="mb-2">
                                            @if($operation === 'update' && $event->gdrive_id)
                                                <img id="posterPreview" src="https://lh3.googleusercontent.com/d/{{ $event->gdrive_id }}" alt="Current Poster" class="img-thumbnail mb-2" style="max-height: 200px;">
                                            @else
                                                <img id="posterPreview" src="" alt="Preview" class="img-thumbnail mb-2" style="max-height: 200px; display:none;">
                                                <x-svg-placeholder />
                                            @endif
                                        </div>
                                        <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster"
                                            accept="image/png, image/jpeg, image/jpg"
                                            {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('poster')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Recommended size: 1080 x 1350 pixels, max 5MB</div>
                                        @if ($operation === 'update' && $event->poster)
                                            <div class="form-text">Leave blank to keep current poster</div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-address-book me-2"></i>Contact Person</h5>

                                <div class="mb-3">
                                    <label for="nameCntctPrsn1" class="form-label">Name Contact Person 1 <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nameCntctPrsn1') is-invalid @enderror" id="nameCntctPrsn1" name="nameCntctPrsn1"
                                        value="{{ old('nameCntctPrsn1', $event->nameCntctPrsn1 ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('nameCntctPrsn1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cntctPrsn1" class="form-label">Phone Contact Person 1 <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">+62</span>
                                        <input type="text" class="form-control @error('cntctPrsn1') is-invalid @enderror" id="cntctPrsn1" name="cntctPrsn1"
                                            value="{{ old('cntctPrsn1', $event->cntctPrsn1 ?? '') }}"
                                            {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    </div>
                                    @error('cntctPrsn1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nameCntctPrsn2" class="form-label">Name Contact Person 2</label>
                                    <input type="text" class="form-control @error('nameCntctPrsn2') is-invalid @enderror" id="nameCntctPrsn2" name="nameCntctPrsn2"
                                        value="{{ old('nameCntctPrsn2', $event->nameCntctPrsn2 ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : '' }}>
                                    @error('nameCntctPrsn2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional</div>
                                </div>

                                <div class="mb-3">
                                    <label for="cntctPrsn2" class="form-label">Phone Contact Person 2</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+62</span>
                                        <input type="text" class="form-control @error('cntctPrsn2') is-invalid @enderror" id="cntctPrsn2" name="cntctPrsn2"
                                            value="{{ old('cntctPrsn2', $event->cntctPrsn2 ?? '') }}"
                                            {{ $operation === 'view' ? 'readonly' : '' }}>
                                    </div>
                                    @error('cntctPrsn2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional</div>
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
                        <button type="button" onclick="window.location.href='{{ route('admin.event.index') }}'" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Save Event' : 'Update Event' }}
                        </button>
                    </div>
                </div>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-primary">
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
