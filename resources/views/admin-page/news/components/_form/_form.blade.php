@php
    // Set defaults if not provided
    $operation = $operation ?? 'create';
    $news = $news ?? null;

@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">News</span>
                @if($operation !== 'create' && $news)
                    <small class="text-muted d-block mt-2">{{ $news->title }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.news.store') : route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- News Information -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>News Information</h5>

                                <div class="mb-3">
                                    <label for="title" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Title @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $news->title }}</div>
                                    @else
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                            value="{{ old('title', $news->title ?? '') }}"
                                            placeholder="Enter news title"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter the news headline/title</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="datepublish" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Date Publish @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($news->datepublish)->isoFormat('dddd, DD MMMM YYYY') }}
                                        </div>
                                    @else
                                        <input type="date" class="form-control @error('datepublish') is-invalid @enderror" id="datepublish" name="datepublish"
                                            value="{{ old('datepublish', $news->datepublish ?? '') }}"
                                            required>
                                        @error('datepublish')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Select the publish date for this news</div>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="publisher" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Publisher @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $news->publisher }}</div>
                                    @else
                                        <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher"
                                            value="{{ old('publisher', $news->publisher ?? '') }}"
                                            placeholder="Enter publisher name"
                                            required>
                                        @error('publisher')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter the publisher name</div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="reporter" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                                Reporter @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                            </label>
                                            @if ($operation === 'view')
                                                <div class="form-control-plaintext">{{ $news->reporter }}</div>
                                            @else
                                                <input type="text" class="form-control @error('reporter') is-invalid @enderror" id="reporter" name="reporter"
                                                    value="{{ old('reporter', $news->reporter ?? '') }}"
                                                    placeholder="Enter reporter name"
                                                    required>
                                                @error('reporter')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="editor" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                                Editor @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                            </label>
                                            @if ($operation === 'view')
                                                <div class="form-control-plaintext">{{ $news->editor }}</div>
                                            @else
                                                <input type="text" class="form-control @error('editor') is-invalid @enderror" id="editor" name="editor"
                                                    value="{{ old('editor', $news->editor ?? '') }}"
                                                    placeholder="Enter editor name"
                                                    required>
                                                @error('editor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @if ($operation === 'view')
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($news->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($news->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($news->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted">({{ \Carbon\Carbon::parse($news->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Picture Upload -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-image me-2"></i>
                                    {{ $operation === 'view' ? 'News Image' : ($operation === 'create' ? 'Upload Image' : 'Image Management') }}
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        @if($operation !== 'view')
                                            Picture @if($operation === 'create') <span class="text-danger">*</span> @endif
                                            <span class="small text-muted">(Recommended: 1366 x 768 pixels)</span>
                                        @else
                                            Current Image
                                        @endif
                                    </label>

                                    <div class="image-preview-container {{ ($news && $news->gdrive_id) ? 'has-image' : '' }} mb-3">
                                        @if($news && $news->gdrive_id)
                                            <img id="imagePreview" src="{{ $news->getPictureUrl() }}" alt="News Preview">
                                        @else
                                            <img id="imagePreview" src="" alt="News Preview" style="display:none;">
                                            <x-svg-placeholder />
                                        @endif
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

                                <div class="mb-3">
                                    <label for="descpicture" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Picture Description @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $news->descpicture }}</div>
                                    @else
                                        <input type="text" class="form-control @error('descpicture') is-invalid @enderror" id="descpicture" name="descpicture"
                                            value="{{ old('descpicture', $news->descpicture ?? '') }}"
                                            placeholder="Enter picture description"
                                            required>
                                        @error('descpicture')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter a description for the image (alt text)</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- News Content -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-file-alt me-2"></i>News Content</h5>

                        <div class="mb-3">
                            <label for="body" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                Content @if($operation !== 'view') <span class="text-danger">*</span> @endif
                            </label>
                            @if ($operation === 'view')
                                <div class="news-content-preview border p-4 rounded bg-white">
                                    {!! $news->body !!}
                                </div>
                            @else
                                <textarea class="form-control summernote @error('body') is-invalid @enderror" id="body" name="body" required>{{ old('body', $news->body ?? '') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Write the full news article content using the editor above</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create News' : 'Update News' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
