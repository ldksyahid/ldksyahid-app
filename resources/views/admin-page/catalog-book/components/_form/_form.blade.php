@props([
    'operation' => 'create',
    'book' => null,
    'titleForm' => '',
    'entityLabel' => 'Book'
])

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-book me-2"></i>
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
                <form action="{{ $operation === 'create' ? route('admin.catalog.books.store') : route('admin.catalog.books.update', $book->bookID) }}" method="POST" enctype="multipart/form-data">
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
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn"
                                        value="{{ old('isbn', $book->isbn ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : '' }}>
                                    @error('isbn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="titleBook" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('titleBook') is-invalid @enderror" id="titleBook" name="titleBook"
                                        value="{{ old('titleBook', $book->titleBook ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('titleBook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="authorName" class="form-label">Author <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('authorName') is-invalid @enderror" id="authorName" name="authorName"
                                        value="{{ old('authorName', $book->authorName ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('authorName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="publisherName" class="form-label">Publisher <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('publisherName') is-invalid @enderror" id="publisherName" name="publisherName"
                                        value="{{ old('publisherName', $book->publisherName ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('publisherName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="categoryName" class="form-label">Category <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('categoryName') is-invalid @enderror" id="categoryName" name="categoryName"
                                        value="{{ old('categoryName', $book->categoryName ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('categoryName')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-book-open me-2"></i>Additional Information</h5>

                                <div class="mb-3">
                                    <label for="language" class="form-label">Language <span class="text-danger">*</span></label>
                                    @if ($operation === 'view')
                                        <input type="text" class="form-control" value="{{ $book->language }}" readonly>
                                    @else
                                        <select class="form-select @error('language') is-invalid @enderror" id="language" name="language" required>
                                            <option value="">Select Language</option>
                                            <option value="English" {{ old('language', $book->language ?? '') == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="Indonesian" {{ old('language', $book->language ?? '') == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                                            <option value="Arabic" {{ old('language', $book->language ?? '') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                            <option value="Other" {{ old('language', $book->language ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    @endif
                                    @error('language')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year"
                                        value="{{ old('year', $book->year ?? '') }}"
                                        min="1900" max="{{ date('Y') }}"
                                        {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="pages" class="form-label">Pages <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('pages') is-invalid @enderror" id="pages" name="pages"
                                        value="{{ old('pages', $book->pages ?? '') }}"
                                        min="1" {{ $operation === 'view' ? 'readonly' : 'required' }}>
                                    @error('pages')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="edition" class="form-label">Edition</label>
                                    <input type="text" class="form-control @error('edition') is-invalid @enderror" id="edition" name="edition"
                                        value="{{ old('edition', $book->edition ?? '') }}"
                                        {{ $operation === 'view' ? 'readonly' : '' }}>
                                    @error('edition')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5 class="section-title mb-3"><i class="fas fa-align-left me-2"></i>Description</h5>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Short Description <span class="text-danger">*</span></label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $book->description }}</div>
                                    @else
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $book->description ?? '') }}</textarea>
                                    @endif
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="synopsis" class="form-label">Synopsis</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $book->synopsis ?? 'N/A' }}</div>
                                    @else
                                        <textarea class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" name="synopsis" rows="5">{{ old('synopsis', $book->synopsis ?? '') }}</textarea>
                                    @endif
                                    @error('synopsis')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Media Section -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-image me-2"></i>Cover Image</h5>

                                @if ($operation === 'view')
                                    <div class="mb-3">
                                        <div>
                                            @if($book->coverImageGdriveID)
                                                <img src="{{ $book->coverImageUrl() }}" alt="Book Cover" class="img-thumbnail" style="max-height: 300px;">
                                            @else
                                                <div class="no-image-placeholder bg-light p-4 text-center rounded border" style="max-height: 300px;">
                                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                    <p class="mb-0">No Cover Image</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="coverImage" class="form-label">
                                            {{ $operation === 'create' ? 'Upload Cover Image' : 'Update Cover Image' }}
                                            (Optional)
                                        </label>
                                        <input type="file" class="form-control @error('coverImage') is-invalid @enderror" id="coverImage" name="coverImage"
                                            accept="image/*">
                                        @error('coverImage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Recommended size: 300x450 pixels, max 2MB</div>
                                        @if ($operation === 'update' && $book->coverImage)
                                            <div class="form-text">Leave blank to keep current image</div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <h5 class="section-title mb-3"><i class="fas fa-file-pdf me-2"></i>PDF File</h5>

                                @if ($operation === 'view' && $book->pdfFileName)
                                    <div class="mb-3">
                                        <div class="pdf-preview text-center">
                                            @if($book->pdfFileName)
                                                <div class="pdf-preview-content">
                                                    <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                    <p class="mb-2">{{ $book->pdfFileName }}</p>
                                                    <a href="{{ $book->pdfFileUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i> View PDF
                                                    </a>
                                                </div>
                                            @else
                                                <div class="no-media-placeholder">
                                                    <i class="fas fa-file-pdf fa-2x"></i>
                                                    <p>No PDF file</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <label for="pdfFileName" class="form-label">
                                            {{ $operation === 'create' ? 'Upload PDF File' : 'Update PDF File' }}
                                            @if ($operation === 'create') <span class="text-danger">*</span> @endif
                                        </label>
                                        <input type="file" class="form-control @error('pdfFileName') is-invalid @enderror" id="pdfFileName" name="pdfFileName"
                                            accept=".pdf" {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('pdfFileName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Max file size: 10MB</div>
                                        @if ($operation === 'update' && $book->pdfFileName)
                                            <div class="form-text">Leave blank to keep current file</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- SEO & Tags -->
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h5 class="section-title mb-3"><i class="fas fa-tags me-2"></i>Tags & SEO</h5>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $book->tags ?? 'N/A' }}</div>
                                    @else
                                        <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags"
                                            value="{{ old('tags', $book->tags ?? '') }}" placeholder="Separate tags with commas">
                                    @endif
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Example: islam, education, history</div>
                                </div>

                                <div class="mb-3">
                                    <label for="metaKeywords" class="form-label">Meta Keywords</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $book->metaKeywords ?? 'N/A' }}</div>
                                    @else
                                        <textarea class="form-control @error('metaKeywords') is-invalid @enderror" id="metaKeywords" name="metaKeywords" rows="2">{{ old('metaKeywords', $book->metaKeywords ?? '') }}</textarea>
                                    @endif
                                    @error('metaKeywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="metaDescription" class="form-label">Meta Description</label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $book->metaDescription ?? 'N/A' }}</div>
                                    @else
                                        <textarea class="form-control @error('metaDescription') is-invalid @enderror" id="metaDescription" name="metaDescription" rows="3">{{ old('metaDescription', $book->metaDescription ?? '') }}</textarea>
                                    @endif
                                    @error('metaDescription')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Recommended length: 150-160 characters</div>
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
                        <button type="button" onclick="window.location.href='{{ route('admin.catalog.books.indexAdmin') }}'" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Save Book' : 'Update Book' }}
                        </button>
                    </div>
                </div>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.catalog.books.indexAdmin') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.catalog.books.edit', $book->bookID) }}" class="btn btn-primary">
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
