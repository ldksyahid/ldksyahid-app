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

                                @if ($operation !== 'view' && $operation === 'update' && $user && !$user->password)
                                    <div class="google-info-alert d-flex align-items-center gap-2 py-2 px-3 mb-3">
                                        <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0">
                                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                        </svg>
                                        <span>This user registered via Google. Password field can be left blank.</span>
                                    </div>
                                @endif

                                @if ($operation === 'view')
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Login Method</label>
                                        <div class="form-control-plaintext">
                                            @if($user->googleID)
                                                <div class="d-flex align-items-center gap-2">
                                                    <svg width="16" height="16" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                                    </svg>
                                                    <span>Google{{ !$user->password ? ' (no password set)' : ' + Password' }}</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="fa fa-key text-secondary"></i>
                                                    <span>Email & Password</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

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
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($user->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($user->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($user->updated_at)->format('H:i T') }})</small>
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

                                    @php
                                        $googleAvatar = $user->profile->googleAvatar ?? null;
                                        $driveAvatar  = $user->profile->gdrive_id ?? null;
                                        $nickName     = $user->profile->namapanggilan ?? null;
                                    @endphp
                                    @if($user->profile || $user->googleID)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Profile</label>
                                            <div class="info-card p-3">
                                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                                    {{-- Google profile picture (from OAuth) --}}
                                                    @if($googleAvatar)
                                                        <div class="profile-picture-container google-avatar-wrap" title="Google profile picture">
                                                            <img src="{{ $googleAvatar }}" alt="Google Profile"
                                                                onerror="this.closest('.google-avatar-wrap').style.display='none'">
                                                            <span class="google-avatar-badge">
                                                                <svg width="11" height="11" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                    @endif
                                                    {{-- LDK profile picture (from Google Drive upload) --}}
                                                    @if($driveAvatar)
                                                        <div class="profile-picture-container">
                                                            <img src="https://lh3.googleusercontent.com/d/{{ $driveAvatar }}" alt="LDK Profile">
                                                        </div>
                                                    @endif
                                                    <div>
                                                        @if($nickName)
                                                            <div class="fw-bold">{{ $nickName }}</div>
                                                        @endif
                                                        @if($user->profile)
                                                            <small class="text-muted">Profile completed</small>
                                                        @else
                                                            <small class="text-muted">No LDK profile yet</small>
                                                        @endif
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
