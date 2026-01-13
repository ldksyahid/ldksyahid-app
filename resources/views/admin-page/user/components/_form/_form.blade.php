@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $user = $user ?? null;
    $roles = $roles ?? [];
    $currentRole = $currentRole ?? null;
    $roleName = $roleName ?? null;

    $roleClasses = [
        'Superadmin' => 'bg-role-superadmin',
        'HelperAdmin' => 'bg-role-helperadmin',
        'HelperCelsyahid' => 'bg-role-helpercelsyahid',
        'HelperEventMart' => 'bg-role-helpereventmart',
        'HelperSPAM' => 'bg-role-helperspam',
        'HelperMedia' => 'bg-role-helpermedia',
        'HelperLetter' => 'bg-role-helperletter',
        'User' => 'bg-role-user',
    ];
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'user-plus' : ($operation === 'update' ? 'user-edit' : 'user') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">User</span>
                @if($operation !== 'create' && $user)
                    <small class="text-muted d-block mt-2">{{ $user->name }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.user.store') : route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- User Information -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>User Information</h5>

                                <div class="mb-3">
                                    <label for="name" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Name @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $user->name }}</div>
                                    @else
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                            value="{{ old('name', $user->name ?? '') }}"
                                            placeholder="Enter user name"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter the full name of the user</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Email @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $user->email }}</div>
                                    @else
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                            value="{{ old('email', $user->email ?? '') }}"
                                            placeholder="Enter email address"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter a valid email address</div>
                                    @endif
                                </div>

                                @if ($operation !== 'view')
                                    <div class="mb-3">
                                        <label for="password" class="form-label">
                                            Password @if($operation === 'create') <span class="text-danger">*</span> @endif
                                        </label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                            placeholder="{{ $operation === 'create' ? 'Enter password' : 'Leave blank to keep current password' }}"
                                            {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($operation === 'create')
                                                Minimum 6 characters
                                            @else
                                                Leave blank if you don't want to change the password
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if ($operation === 'view')
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Email Verification</label>
                                        <div class="form-control-plaintext">
                                            @if($user->email_verified_at)
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa fa-check-circle text-success"></i>
                                                    <span>Verified on {{ \Carbon\Carbon::parse($user->email_verified_at)->isoFormat('DD MMMM YYYY, HH:mm') }}</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa fa-times-circle text-danger"></i>
                                                    <span>Not verified</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($user->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($user->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($user->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Role Selection -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-user-tag me-2"></i>
                                    {{ $operation === 'view' ? 'Role Information' : 'Select Role' }}
                                </h5>

                                @if ($operation === 'view')
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Current Role</label>
                                        <div class="form-control-plaintext">
                                            <span class="badge {{ $roleClasses[$roleName] ?? 'bg-role-user' }} fs-6">{{ $roleName }}</span>
                                        </div>
                                    </div>

                                    @if($user->profile)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Profile</label>
                                            <div class="info-card p-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    @if($user->profile->gdrive_id)
                                                        <div class="profile-picture-container">
                                                            <img src="https://lh3.googleusercontent.com/d/{{ $user->profile->gdrive_id }}" alt="Profile">
                                                        </div>
                                                    @endif
                                                    <div>
                                                        @if($user->profile->namapanggilan)
                                                            <div class="fw-bold">{{ $user->profile->namapanggilan }}</div>
                                                        @endif
                                                        <small class="text-muted">Profile completed</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="mb-3">
                                        <label class="form-label">
                                            Role <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-text mb-2">Select a role for this user</div>

                                        @foreach($roles as $role)
                                            @php
                                                $isChecked = false;
                                                if ($operation === 'update') {
                                                    $isChecked = (old('roleName', $currentRole) == $role->name) || ($currentRole == null && $role->name == 'User');
                                                } else {
                                                    $isChecked = old('roleName') == $role->name;
                                                }
                                            @endphp
                                            <label class="role-option {{ $isChecked ? 'selected' : '' }}">
                                                <input type="radio" name="roleName" value="{{ $role->name }}"
                                                    {{ $isChecked ? 'checked' : '' }}>
                                                <span>{{ $role->name }}</span>
                                                <span class="role-badge badge {{ $roleClasses[$role->name] ?? 'bg-role-user' }}">{{ $role->name }}</span>
                                            </label>
                                        @endforeach

                                        @error('roleName')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
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
                        <a href="{{ route('admin.user.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create User' : 'Update User' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        @if(!$user->isProtected())
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-custom-primary">
                                <i class="fa fa-edit me-1"></i> Edit
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
