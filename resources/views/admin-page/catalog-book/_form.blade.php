@extends('admin-page.template.body')

@section('content')
@php
    use App\Http\Controllers\LibraryFunctionController as LFC;
@endphp
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-book me-2"></i>
                <span>Add New</span>
                <span class="highlighted-text ms-1">Book</span>
            </h1>

            <div class="col-md-12 my-3">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('failed'))
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
                @endif
            </div>

            <form action="{{ route('admin.catalog.books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12 mb-4 rounded">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-6">
                                    <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>

                                    <div class="mb-3">
                                        <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn') }}" required>
                                        @error('isbn')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="titleBook" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('titleBook') is-invalid @enderror" id="titleBook" name="titleBook" value="{{ old('titleBook') }}" required>
                                        @error('titleBook')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="authorName" class="form-label">Author <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('authorName') is-invalid @enderror" id="authorName" name="authorName" value="{{ old('authorName') }}" required>
                                        @error('authorName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="publisherName" class="form-label">Publisher <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('publisherName') is-invalid @enderror" id="publisherName" name="publisherName" value="{{ old('publisherName') }}" required>
                                        @error('publisherName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="categoryName" class="form-label">Category <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('categoryName') is-invalid @enderror" id="categoryName" name="categoryName" value="{{ old('categoryName') }}" required>
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
                                        <select class="form-select @error('language') is-invalid @enderror" id="language" name="language" required>
                                            <option value="">Select Language</option>
                                            <option value="English" {{ old('language') == 'English' ? 'selected' : '' }}>English</option>
                                            <option value="Indonesian" {{ old('language') == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                                            <option value="Arabic" {{ old('language') == 'Arabic' ? 'selected' : '' }}>Arabic</option>
                                            <option value="Other" {{ old('language') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('year') is-invalid @enderror" id="year" name="year" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}" required>
                                        @error('year')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="pages" class="form-label">Pages</label>
                                        <input type="number" class="form-control @error('pages') is-invalid @enderror" id="pages" name="pages" value="{{ old('pages') }}" min="1">
                                        @error('pages')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="edition" class="form-label">Edition</label>
                                        <input type="text" class="form-control @error('edition') is-invalid @enderror" id="edition" name="edition" value="{{ old('edition') }}">
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
                                        <label for="description" class="form-label">Short Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="synopsis" class="form-label">Synopsis</label>
                                        <textarea class="form-control @error('synopsis') is-invalid @enderror" id="synopsis" name="synopsis" rows="5">{{ old('synopsis') }}</textarea>
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

                                    <div class="mb-3">
                                        <label for="coverImage" class="form-label">Upload Cover Image <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control @error('coverImage') is-invalid @enderror" id="coverImage" name="coverImage" accept="image/*" required>
                                        @error('coverImage')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Recommended size: 300x450 pixels, max 2MB</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="section-title mb-3"><i class="fas fa-file-pdf me-2"></i>PDF File</h5>

                                    <div class="mb-3">
                                        <label for="pdfFileName" class="form-label">Upload PDF File</label>
                                        <input type="file" class="form-control @error('pdfFileName') is-invalid @enderror" id="pdfFileName" name="pdfFileName" accept=".pdf">
                                        @error('pdfFileName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Max file size: 10MB</div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO & Tags -->
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 class="section-title mb-3"><i class="fas fa-tags me-2"></i>Tags & SEO</h5>

                                    <div class="mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control @error('tags') is-invalid @enderror" id="tags" name="tags" value="{{ old('tags') }}" placeholder="Separate tags with commas">
                                        @error('tags')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Example: islam, education, history</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="metaKeywords" class="form-label">Meta Keywords</label>
                                        <textarea class="form-control @error('metaKeywords') is-invalid @enderror" id="metaKeywords" name="metaKeywords" rows="2">{{ old('metaKeywords') }}</textarea>
                                        @error('metaKeywords')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="metaDescription" class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('metaDescription') is-invalid @enderror" id="metaDescription" name="metaDescription" rows="3">{{ old('metaDescription') }}</textarea>
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
            <!-- Form Actions -->
            <div class="row mb-5">
                <div class="col-md-12 d-flex justify-content-end gap-2">
                    <button type="button" onclick="window.location.href='{{ route('admin.catalog.books.indexAdmin') }}'" class="btn btn-danger">
                        <i class="fa fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-custom-primary">
                        <i class="fa fa-save me-1"></i> Save Book
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .page-title {
        font-size: 1.65rem;
        font-weight: 600;
        text-align: center;
        color: #00a79d;
        margin: .75rem 0 1.5rem;
        position: relative;
        display: inline-block;
    }
    .page-title .highlighted-text {
        color: #008b84;
        font-weight: 700;
    }
    .page-title::after {
        content: '';
        display: block;
        height: 4px;
        width: 120px;
        margin: .35rem auto 0;
        border-radius: 3px;
        background: linear-gradient(90deg,#00a79d 0%,#008b84 100%);
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #00a79d;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e0f7f5;
    }
    .btn-custom-primary {
        color: #fff;
        background-color: #00a79d;
        border: 1px solid #00a79d;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background-color: #008b84;
        border-color: #008b84;
        color: #fff;
    }
    .btn-custom-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .form-control:focus, .form-select:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .form-text {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .invalid-feedback {
        font-size: 0.85rem;
    }
    .select2-container .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
        right: 10px;
    }
    .select2-container--bootstrap-5 .select2-results__option {
        padding: 10px 12px;
        font-size: 0.95rem;
        color: #333;
        transition: background-color 0.2s ease-in-out;
    }
    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
        background-color: #00a79d !important;
        color: #fff;
    }
    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: #e0f7f5;
        color: #008b84;
        font-weight: 600;
    }
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
        color: #212529;
        font-weight: 500;
    }
    .select2-container--bootstrap-5 .select2-selection__arrow b {
        border-color: #00a79d transparent transparent transparent;
    }
    .select2-container--open .select2-selection--single {
        border: 1px solid #00bfa6 !important;
    }
    .select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected],
    .select2-container--bootstrap-5 .select2-results__option--highlighted {
        background-color: #00a79d !important;
        color: white !important;
    }
    .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
        background-color: #e0f7f5 !important;
        color: #008b84 !important;
        font-weight: 600;
    }
    .select2-container--bootstrap-5 .select2-search__field {
        border: 1px solid #ced4da !important;
        border-radius: 4px;
        padding: 6px 10px;
        font-size: 0.9rem;
        color: #212529;
        outline: none;
        box-shadow: none !important;
    }
    .select2-container--bootstrap-5 .select2-search__field:focus {
        border-color: #00a79d !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25) !important;
    }
    .select2-container--bootstrap-5 .select2-selection__placeholder {
        color: #6c757d;
    }
    .select2-container--bootstrap-5 .select2-selection__rendered {
        color: #6c757d!important;
        font-weight: 600;
    }

    .select2-container--bootstrap-5 .select2-selection {
        background-color: #ffffff !important;
        border: 1px solid #ced4da;
        border-radius: 6px;
    }
    .select2-container--bootstrap-5 .select2-selection--single {
        height: calc(2.5rem + 2px);
        padding: 0.375rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        background-color: #fff;
        font-size: 1rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }

    .select2-container--bootstrap-5 .select2-selection__rendered {
        line-height: 1.8rem;
        color: #6c757d;
    }

    .select2-container--bootstrap-5 .select2-selection__arrow {
        top: 8px;
        right: 10px;
    }

    .select2-dropdown {
        border-radius: 0.75rem;
        border: 1px solid #00bfa6;
        font-size: 0.95rem;
        overflow: hidden;
        animation: dropdownFadeIn 0.2s ease forwards;
    }

    .select2-results__option {
        padding: 10px 14px;
        transition: all 0.2s ease;
        border-bottom: 1px solid #e0f2ef;
        cursor: pointer;
    }

    .select2-results__option:last-child {
        border-bottom: none;
    }

    .select2-results__option--highlighted {
        background-color: #00bfa6 !important;
        color: white !important;
    }

    .select2-results__option[aria-selected="true"] {
        background-color: #e6f9f6;
        color: #007f73;
    }
    .select2-search__field {
        outline: none !important;
        box-shadow: none !important;
        color: #6c757d;
    }

    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#language').select2({
            placeholder: 'Select Language',
            width: '100%',
            dropdownPosition: 'below'
        });
    });

    document.getElementById('coverImage').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.match('image.*')) {
            const reader = new FileReader();
            reader.onload = function(e) {
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        const title = document.getElementById('titleBook').value;
        if (!title) {
            e.preventDefault();
            Swal.fire({
                title: 'Error!',
                text: 'Title is required',
                icon: 'error',
                confirmButtonColor: '#00a79d'
            });
            return;
        }
    });
</script>
@endsection
