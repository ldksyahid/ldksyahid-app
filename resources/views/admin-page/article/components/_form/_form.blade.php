@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $article = $article ?? null;

@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">Article</span>
                @if($operation !== 'create' && $article)
                    <small class="text-muted d-block mt-2">{{ $article->title }}</small>
                @endif
            </h1>

            @if ($operation !== 'view')
                <div class="col-md-12 my-3">
                    @if ($operation === 'create')
                        <div class="email-notif-warning">
                            <div class="en-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="en-title">Email Notification Warning</div>
                                <div class="en-sub">Please make sure all the information is correct before submitting.</div>
                                <div class="en-meta">
                                    <span><i class="fas fa-paper-plane me-1"></i>Publishing this article will <strong>automatically send an email notification</strong> to all active subscribers.</span>
                                </div>
                            </div>
                            <button type="button" class="en-close" aria-label="Close">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

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
                <form action="{{ $operation === 'create' ? route('admin.article.store') : route('admin.article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Article Information -->
                            <div class="col-md-8">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Article Information</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Title @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $article->title }}</div>
                                        @else
                                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                                value="{{ old('title', $article->title ?? '') }}"
                                                placeholder="Enter article title"
                                                required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="theme" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Theme @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $article->theme }}</div>
                                        @else
                                            <input type="text" class="form-control @error('theme') is-invalid @enderror" id="theme" name="theme"
                                                value="{{ old('theme', $article->theme ?? '') }}"
                                                placeholder="e.g., Technology, Education, Islam"
                                                required>
                                            @error('theme')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="datearticle" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Publish Date @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($article->dateevent)->isoFormat('dddd, DD MMMM YYYY') }}
                                            </div>
                                        @else
                                            <input type="text" class="form-control flatpickr-date @error('datearticle') is-invalid @enderror" id="datearticle" name="datearticle"
                                                value="{{ old('datearticle', $article ? $article->dateevent->format('Y-m-d') : '') }}"
                                                required>
                                            @error('datearticle')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="writer" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Writer @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $article->writer }}</div>
                                        @else
                                            <input type="text" class="form-control @error('writer') is-invalid @enderror" id="writer" name="writer"
                                                value="{{ old('writer', $article->writer ?? '') }}"
                                                placeholder="Enter writer name"
                                                required>
                                            @error('writer')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="editor" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                            Editor @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        </label>
                                        @if ($operation === 'view')
                                            <div class="form-control-plaintext">{{ $article->editor }}</div>
                                        @else
                                            <input type="text" class="form-control @error('editor') is-invalid @enderror" id="editor" name="editor"
                                                value="{{ old('editor', $article->editor ?? '') }}"
                                                placeholder="Enter editor name"
                                                required>
                                            @error('editor')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="embedpdf" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Embed Link @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                        @if($operation !== 'view')
                                            <span class="small text-muted">(Platform: <a href="https://anyflip.com/" target="_blank">anyflip.com</a>)</span>
                                        @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <a href="{{ $article->embedpdf }}" target="_blank">{{ $article->embedpdf }}</a>
                                        </div>
                                    @else
                                        <input type="url" class="form-control @error('embedpdf') is-invalid @enderror" id="embedpdf" name="embedpdf"
                                            value="{{ old('embedpdf', $article->embedpdf ?? '') }}"
                                            placeholder="https://online.anyflip.com/..."
                                            required>
                                        @error('embedpdf')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter the embed URL from anyflip.com</div>
                                    @endif
                                </div>

                                @if ($operation === 'view')
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Created At</label>
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($article->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                                <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($article->created_at)->format('H:i T') }})</small>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Last Updated</label>
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($article->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                                <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($article->updated_at)->format('H:i T') }})</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Poster Upload -->
                            <div class="col-md-4">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-image me-2"></i>
                                    {{ $operation === 'view' ? 'Article Poster' : ($operation === 'create' ? 'Upload Poster' : 'Poster Management') }}
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        @if($operation !== 'view')
                                            Poster @if($operation === 'create') <span class="text-danger">*</span> @endif
                                            <span class="small text-muted">(550 x 400 pixels)</span>
                                        @else
                                            Current Poster
                                        @endif
                                    </label>

                                    <div class="image-preview-container {{ ($article && $article->gdrive_id) ? 'has-image' : '' }} mb-3">
                                        @if($article && $article->gdrive_id)
                                            <img id="imagePreview" src="{{ $article->getPosterUrl() }}" alt="Article Poster Preview">
                                        @else
                                            <img id="imagePreview" src="" alt="Article Poster Preview" style="display:none;">
                                            <x-svg-placeholder />
                                        @endif
                                    </div>

                                    @if ($operation !== 'view')
                                        <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster"
                                            accept="image/jpeg,image/png,image/jpg"
                                            {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('poster')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($operation === 'create')
                                                Upload a JPG, JPEG, or PNG image (max 5MB)
                                            @else
                                                Leave blank to keep current poster
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
                        <a href="{{ route('admin.article.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create Article' : 'Update Article' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.article.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.article.edit', $article->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
