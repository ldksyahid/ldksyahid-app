@php
    $operation = $operation ?? 'create';
    $ktaData = $ktaData ?? null;
    $facultyModel = $facultyModel ?? collect();
    $generationModel = $generationModel ?? collect();

    $defaultMaleImage = 'https://lh3.googleusercontent.com/d/1dpTivBD1VPetcmHj3psiz75si_n1PwTo';
    $defaultFemaleImage = 'https://lh3.googleusercontent.com/d/1wssPqERqsehbQIrUsp9ntd9RHe8m77OQ';
    $currentPhoto = null;
    if ($ktaData) {
        if ($ktaData->gdrive_id) {
            $currentPhoto = $ktaData->getPhotoUrl();
        } elseif ($ktaData->gender === 'Female') {
            $currentPhoto = $defaultFemaleImage;
        } elseif ($ktaData->gender === 'Male') {
            $currentPhoto = $defaultMaleImage;
        }
    }
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">KTA LDK Syahid</span>
                @if($operation !== 'create' && $ktaData)
                    <small class="text-muted d-block mt-2">{{ $ktaData->fullName }}</small>
                @endif
            </h1>

            @if ($operation !== 'view')
                <div class="col-md-12 my-3">
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
                </div>
            @endif

            @if ($operation !== 'view')
                <form action="{{ $operation === 'create' ? route('admin.ktaldksyahid.store') : route('admin.ktaldksyahid.update', $ktaData->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <!-- Personal Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-user me-2"></i>Personal Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputFullName" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Full Name @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->fullName }}</div>
                                    @else
                                        <input type="text" class="form-control @error('fullName') is-invalid @enderror" id="inputFullName" name="fullName"
                                            value="{{ old('fullName', $ktaData->fullName ?? '') }}" required>
                                        @error('fullName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Gender @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <span class="badge {{ $ktaData->gender === 'Male' ? 'bg-dark' : 'bg-warning' }}">{{ $ktaData->gender }}</span>
                                        </div>
                                    @else
                                        <div class="d-flex gap-3 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="genderMale" value="Male"
                                                    {{ old('gender', $ktaData->gender ?? '') === 'Male' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="genderMale"><span class="badge bg-dark">Male</span></label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="Female"
                                                    {{ old('gender', $ktaData->gender ?? '') === 'Female' ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="genderFemale"><span class="badge bg-warning">Female</span></label>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputNim" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        NIM @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->nim }}</div>
                                    @else
                                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="inputNim" name="nim"
                                            value="{{ old('nim', $ktaData->nim ?? '') }}" required>
                                        @error('nim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-graduation-cap me-2"></i>Academic Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputFaculty" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Faculty @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->getFaculty->facultyName ?? '-' }}</div>
                                    @else
                                        <select class="form-select" name="faculty" id="inputFaculty" data-placeholder="-- Choose Faculty --">
                                            <option value="">-- Choose Faculty --</option>
                                            @foreach ($facultyModel as $id => $name)
                                                <option value="{{ $id }}" {{ old('faculty', $ktaData->facultyID ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMajor" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Major @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->getMajor->majorName ?? '-' }}</div>
                                    @else
                                        <select class="form-select" name="major" id="inputMajor" data-placeholder="-- Choose Major --">
                                            <option value="">-- Choose Major --</option>
                                            @if ($operation === 'update' && $ktaData && $ktaData->getMajor)
                                                <option value="{{ $ktaData->getMajor->id }}" selected>{{ $ktaData->getMajor->majorName }}</option>
                                            @endif
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputGeneration" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Generation @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->getGeneration->generationName ?? '-' }}</div>
                                    @else
                                        <select class="form-select" name="generation" id="inputGeneration" data-placeholder="-- Choose Generation --">
                                            <option value="">-- Choose Generation --</option>
                                            @foreach ($generationModel as $id => $name)
                                                <option value="{{ $id }}" {{ old('generation', $ktaData->generationID ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member & Link Profile -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-id-card me-2"></i>Member Details</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputMemberNumber" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Member Number @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->memberNumber }}</div>
                                    @else
                                        <input type="text" class="form-control @error('memberNumber') is-invalid @enderror" id="inputMemberNumber" name="memberNumber"
                                            value="{{ old('memberNumber', $ktaData->memberNumber ?? '') }}" required>
                                        @error('memberNumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputLinkProfile" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Link Profile @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <a href="{{ url('/kta/' . $ktaData->linkProfile) }}" target="_blank">{{ url('/kta/' . $ktaData->linkProfile) }}</a>
                                        </div>
                                    @else
                                        <input type="text" class="form-control @error('linkProfile') is-invalid @enderror" id="inputLinkProfile" name="linkProfile"
                                            value="{{ old('linkProfile', $ktaData->linkProfile ?? '') }}" required style="text-transform: lowercase;">
                                        @error('linkProfile') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Photo Profile -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-image me-2"></i>Photo Profile</h5>
                        <div class="text-center mb-3">
                            <div class="image-preview-container {{ ($ktaData && $ktaData->gdrive_id) ? 'has-image' : '' }}">
                                @if($currentPhoto)
                                    <img id="frame" src="{{ $currentPhoto }}" alt="Photo Profile Preview">
                                @else
                                    <img id="frame" src="" alt="Photo Profile Preview" style="display:none;">
                                    <x-svg-placeholder />
                                @endif
                            </div>
                        </div>
                        @if ($operation !== 'view')
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo"
                                accept="image/jpeg,image/png,image/jpg,image/webp">
                            @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="form-text text-center">Upload a JPG, JPEG, PNG, or WebP image (150 x 200 Pixel, max 5MB)</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Additional Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputSlogan" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Slogan</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->slogan ?: '-' }}</div>
                                    @else
                                        <textarea class="form-control" name="slogan" id="inputSlogan">{{ old('slogan', $ktaData->slogan ?? '') }}</textarea>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputBackground" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Background</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $ktaData->background ?: '-' }}</div>
                                    @else
                                        <textarea class="form-control" name="background" id="inputBackground">{{ old('background', $ktaData->background ?? '') }}</textarea>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputEmail" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Email</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($ktaData->email)
                                                <a href="mailto:{{ $ktaData->email }}">{{ $ktaData->email }}</a>
                                            @else - @endif
                                        </div>
                                    @else
                                        <input type="text" class="form-control" id="inputEmail" name="email" value="{{ old('email', $ktaData->email ?? '') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputLinkedIn" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">LinkedIn</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($ktaData->linkedIn)
                                                <a href="{{ $ktaData->linkedIn }}" target="_blank">{{ $ktaData->linkedIn }}</a>
                                            @else - @endif
                                        </div>
                                    @else
                                        <input type="text" class="form-control" id="inputLinkedIn" name="linkedIn" value="{{ old('linkedIn', $ktaData->linkedIn ?? '') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputInstagram" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Instagram</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($ktaData->instagram)
                                                <a href="{{ $ktaData->instagram }}" target="_blank">{{ $ktaData->instagram }}</a>
                                            @else - @endif
                                        </div>
                                    @else
                                        <input type="text" class="form-control" id="inputInstagram" name="instagram" value="{{ old('instagram', $ktaData->instagram ?? '') }}">
                                    @endif
                                </div>
                            </div>

                            @if ($operation === 'view')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($ktaData->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($ktaData->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($ktaData->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($ktaData->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.ktaldksyahid.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create KTA' : 'Update KTA' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.ktaldksyahid.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.ktaldksyahid.edit', $ktaData->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
