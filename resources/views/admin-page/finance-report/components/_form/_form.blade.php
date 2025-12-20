@props([
    'operation' => 'create',
    'financeReport' => null,
    'ldkTags' => []
])

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-file-invoice-dollar me-2"></i>
                <span>{{ ucfirst($operation) }}</span>
                <span class="highlighted-text ms-1">Finance Report</span>
                @if($operation !== 'create' && $financeReport)
                    <small class="text-muted d-block mt-2">{{ $financeReport->fileName }}</small>
                @endif
            </h1>

            @if($operation !== 'view')
                @if(session('success') || session('error') || $errors->any())
                    <div class="col-md-12 my-3">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>There were some problems with your input:</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                @endif

                <form action="{{ $operation === 'create' ? route('admin.finance-report.store') : route('admin.finance-report.update', $financeReport->financeReportID) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @if($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Report Information -->
                            <div class="{{ $operation === 'view' ? 'col-md-6' : 'col-md-12' }}">
                                <h5 class="section-title mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ $operation === 'view' ? 'Report Details' : 'Report Information' }}
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        File Name {{ $operation !== 'view' ? '<span class="text-danger">*</span>' : '' }}
                                    </label>
                                    @if($operation === 'view')
                                        <div class="form-control-plaintext">{{ $financeReport->fileName }}</div>
                                    @else
                                        <input type="text" class="form-control @error('fileName') is-invalid @enderror"
                                               id="fileName" name="fileName"
                                               value="{{ old('fileName', $financeReport->fileName ?? '') }}"
                                               required>
                                        @error('fileName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($operation === 'create')
                                            <div class="form-text">Enter a descriptive name for the finance report</div>
                                        @endif
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        LDK Tag {{ $operation !== 'view' ? '<span class="text-danger">*</span>' : '' }}
                                    </label>
                                    @if($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <span class="badge bg-primary">{{ $financeReport->ldkTag }}</span>
                                        </div>
                                    @else
                                        <select class="form-select @error('ldkID') is-invalid @enderror"
                                                id="ldkID" name="ldkID" required>
                                            <option value="">Select LDK Tag</option>
                                            @foreach($ldkTags as $ldk)
                                                <option value="{{ $ldk->ldkID }}"
                                                    {{ old('ldkID', $financeReport->ldkID ?? '') == $ldk->ldkID ? 'selected' : '' }}>
                                                    {{ $ldk->ldkTag }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ldkID')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>

                                @if($operation === 'view')
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created Date</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($financeReport->createdDate)->isoFormat('DD MMMM YYYY HH:mm') }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created By</label>
                                        <div class="form-control-plaintext">{{ $financeReport->createdBy }}</div>
                                    </div>

                                    @if($financeReport->editedDate)
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Last Edited</label>
                                            <div class="form-control-plaintext">
                                                {{ \Carbon\Carbon::parse($financeReport->editedDate)->isoFormat('DD MMMM YYYY HH:mm') }}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Edited By</label>
                                            <div class="form-control-plaintext">{{ $financeReport->editedBy }}</div>
                                        </div>
                                    @endif
                                @endif
                            </div>

                            <!-- PDF File Section -->
                            @if($operation === 'view')
                                <div class="col-md-6">
                                    <h5 class="section-title mb-3"><i class="fas fa-file-pdf me-2"></i>PDF File</h5>

                                    @if($financeReport->fileGdriveID)
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fa fa-file-pdf text-danger fa-4x mb-3"></i>
                                                <h5 class="mb-3">{{ $financeReport->fileName }}.pdf</h5>

                                                <div class="d-flex justify-content-center gap-2 mb-3 flex-wrap">
                                                    <a href="{{ $financeReport->fileUrl() }}" target="_blank" class="btn btn-custom-primary">
                                                        <i class="fa fa-download me-1"></i> Download PDF
                                                    </a>
                                                    <a href="{{ $financeReport->fileViewUrl() }}" target="_blank" class="btn btn-outline-primary">
                                                        <i class="fa fa-eye me-1"></i> View in Drive
                                                    </a>
                                                </div>

                                                <!-- Embedded PDF Viewer -->
                                                <div class="mt-4">
                                                    <h6 class="mb-2">Preview:</h6>
                                                    <iframe src="{{ $financeReport->fileUrl() }}"
                                                        style="width: 100%; height: 300px; border: 1px solid #ddd; border-radius: 8px;"
                                                        frameborder="0">
                                                    </iframe>
                                                    <div class="form-text mt-2">Note: PDF preview may require download in some browsers</div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="fa fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                                <h5 class="mb-0">No PDF file uploaded</h5>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- PDF Upload/Update Section -->
                                <div class="col-md-12 mt-4">
                                    <h5 class="section-title mb-3">
                                        <i class="fas fa-file-upload me-2"></i>
                                        {{ $operation === 'create' ? 'Upload PDF File' : 'PDF File Management' }}
                                    </h5>

                                    @if($operation === 'update' && $financeReport->fileGdriveID)
                                        <div class="mb-4">
                                            <label class="form-label">Current PDF File</label>
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-file-pdf text-danger fa-2x me-3"></i>
                                                            <div>
                                                                <div class="fw-bold">{{ $financeReport->fileName }}.pdf</div>
                                                                <small class="text-muted">Uploaded on {{ \Carbon\Carbon::parse($financeReport->createdDate)->isoFormat('DD MMMM YYYY') }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 mt-md-0">
                                                            <a href="{{ $financeReport->fileUrl() }}" target="_blank" class="btn btn-sm btn-outline-primary me-2">
                                                                <i class="fa fa-download"></i> Download
                                                            </a>
                                                            <a href="{{ $financeReport->fileViewUrl() }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-text mt-2">Leave the file field blank to keep current file</div>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="pdfFile" class="form-label">
                                            {{ $operation === 'create' ? 'Select PDF File' : 'Update PDF File (Optional)' }}
                                            @if($operation === 'create') <span class="text-danger">*</span> @endif
                                        </label>
                                        <input type="file" class="form-control @error('pdfFile') is-invalid @enderror"
                                               id="pdfFile" name="pdfFile"
                                               accept=".pdf"
                                               {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('pdfFile')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            @if($operation === 'create')
                                                Upload a PDF file (max 5MB)
                                            @else
                                                Upload a new PDF file to replace the current one (max 5MB)
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($operation !== 'view')
                <!-- Form Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.finance-report.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i>
                            {{ $operation === 'create' ? 'Save Report' : 'Update Report' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <!-- View Mode Actions -->
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.finance-report.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.finance-report.edit', $financeReport->financeReportID) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
