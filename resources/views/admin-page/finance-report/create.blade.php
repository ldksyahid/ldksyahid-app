@extends('admin-page.template.body')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-file-invoice-dollar me-2"></i>
                <span>Add New</span>
                <span class="highlighted-text ms-1">Finance Report</span>
            </h1>

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

            <form action="{{ route('admin.finance-report.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-12">
                                    <h5 class="section-title mb-3"><i class="fas fa-info-circle me-2"></i>Report Information</h5>

                                    <div class="mb-3">
                                        <label for="fileName" class="form-label">File Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('fileName') is-invalid @enderror" id="fileName" name="fileName"
                                            value="{{ old('fileName') }}" required>
                                        @error('fileName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Enter a descriptive name for the finance report</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ldkID" class="form-label">LDK Tag <span class="text-danger">*</span></label>
                                        <select class="form-select @error('ldkID') is-invalid @enderror" id="ldkID" name="ldkID" required>
                                            <option value="">Select LDK Tag</option>
                                            @foreach($ldkTags as $ldk)
                                                <option value="{{ $ldk->ldkID }}" {{ old('ldkID') == $ldk->ldkID ? 'selected' : '' }}>
                                                    {{ $ldk->ldkTag }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ldkID')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="pdfFile" class="form-label">PDF File <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control @error('pdfFile') is-invalid @enderror" id="pdfFile" name="pdfFile"
                                            accept=".pdf" required>
                                        @error('pdfFile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Upload a PDF file (max 5MB)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.finance-report.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> Save Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
    @include('admin-page.finance-report.components._form._form-styles')
@endsection

@section('scripts')
    @include('admin-page.finance-report.components._form._form-scripts')
@endsection
