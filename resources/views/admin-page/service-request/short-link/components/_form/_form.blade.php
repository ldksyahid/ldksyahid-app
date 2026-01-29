@php
    // Set defaults if not provided
    $operation = $operation ?? 'view';
    $reqshortlink = $reqshortlink ?? null;
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'update' ? 'edit' : 'eye' }} me-2"></i>
                <span>{{ $operation === 'update' ? 'Edit' : 'View' }}</span>
                <span class="highlighted-text ms-1">Request Shortlink</span>
                @if($reqshortlink)
                    <small class="text-muted d-block mt-2">{{ $reqshortlink->name }}</small>
                @endif
            </h1>

            @if ($operation === 'update')
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

            @if ($operation === 'update')
                <form action="{{ route('admin.reqservice.shortlink.update', $reqshortlink->id) }}" method="POST">
                    @csrf
                    @method('PUT')
            @endif

            <!-- Requester Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-user me-2"></i>Requester Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Full Name @if($operation === 'update') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $reqshortlink->name }}</div>
                                    @else
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                            value="{{ old('name', $reqshortlink->name ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="email" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Email @if($operation === 'update') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <a href="mailto:{{ $reqshortlink->email }}">{{ $reqshortlink->email }}</a>
                                        </div>
                                    @else
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                            value="{{ old('email', $reqshortlink->email ?? '') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Whatsapp Contact @if($operation === 'update') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $reqshortlink->whatsapp }}</div>
                                    @else
                                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp"
                                            value="{{ old('whatsapp', $reqshortlink->whatsapp ?? '') }}" required>
                                        @error('whatsapp')
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
                                            {{ \Carbon\Carbon::parse($reqshortlink->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($reqshortlink->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($reqshortlink->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($reqshortlink->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Link Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-link me-2"></i>Link Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="defaultLink" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Default Link @if($operation === 'update') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <a href="{{ $reqshortlink->defaultLink }}" target="_blank">{{ $reqshortlink->defaultLink }}</a>
                                        </div>
                                    @else
                                        <input type="text" class="form-control @error('defaultLink') is-invalid @enderror" id="defaultLink" name="defaultLink"
                                            value="{{ old('defaultLink', $reqshortlink->defaultLink ?? '') }}" required>
                                        @error('defaultLink')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customLink" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Custom Link @if($operation === 'update') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $reqshortlink->customLink }}</div>
                                    @else
                                        <input type="text" class="form-control @error('customLink') is-invalid @enderror" id="customLink" name="customLink"
                                            value="{{ old('customLink', $reqshortlink->customLink ?? '') }}" required>
                                        @error('customLink')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="note" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Note @if($operation === 'update') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="border rounded p-3 bg-white" style="min-height: 100px; white-space: pre-wrap;">{{ $reqshortlink->note }}</div>
                                    @else
                                        <textarea class="form-control @error('note') is-invalid @enderror" id="note" name="note"
                                            rows="4" required>{{ old('note', $reqshortlink->note ?? '') }}</textarea>
                                        @error('note')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="fixCustomLink" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Fix Custom Link
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            @if($reqshortlink->fixCustomLink)
                                                <a href="{{ $reqshortlink->fixCustomLink }}" target="_blank">{{ $reqshortlink->fixCustomLink }}</a>
                                            @else
                                                <span class="badge bg-warning text-dark">Not Set</span>
                                            @endif
                                        </div>
                                    @else
                                        <input type="text" class="form-control @error('fixCustomLink') is-invalid @enderror" id="fixCustomLink" name="fixCustomLink"
                                            value="{{ old('fixCustomLink', $reqshortlink->fixCustomLink ?? '') }}"
                                            placeholder="Enter the final custom link">
                                        @error('fixCustomLink')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($operation === 'update')
                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.reqservice.shortlink.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> Update Request Shortlink
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.reqservice.shortlink.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="https://api.whatsapp.com/send?phone={{ $reqshortlink->whatsapp }}&text=*%5BKUSTOM%20URL%20KAMU%20SUDAH%20JADI%5D*%0A%0A_Assalammu%27alaikum_%0A%0AHalo%20{{ $reqshortlink->name }}%20%F0%9F%98%80%2C%20Perkenalkan%20Saya%20_{{ Auth::User()->name }}_%2C%20Berikut%20hasil%20link%20yang%20telah%20kami%20Kustom%20menggunakan%20layanan%20kami%20%3A%0A%0A{{ $reqshortlink->fixCustomLink }}%0A%0A**Link%20Tersebut%20Wajib%20digunakan%20dengan%20Sebagaimana%20Mestinya*%0A%0ATerimakasih%20{{ $reqshortlink->name }}%20karena%20telah%20menggunakan%20layanan%20kami%20%F0%9F%98%89%0A%0A_Wassalammua%27laikum_%0A%0A%23KitaAdalahSaudara%0A%23LDKSyahid%0A%23PijarAskara%0A%23UINJakarta"
                           target="_blank" class="btn btn-success">
                            <i class="fa fa-paper-plane me-1"></i> Send via WhatsApp
                        </a>
                        <a href="{{ route('admin.reqservice.shortlink.edit', $reqshortlink->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
