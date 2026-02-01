@php
    use App\Http\Controllers\LibraryFunctionController as LFC;

    $operation = $operation ?? 'create';
    $data = $data ?? null;
    $provinces = $provinces ?? collect();

    $currentPoster = ($data && $data->gdrive_id) ? 'https://lh3.googleusercontent.com/d/' . $data->gdrive_id : null;
    $currentLogo = ($data && $data->gdrive_id_1) ? 'https://lh3.googleusercontent.com/d/' . $data->gdrive_id_1 : null;

    $hasOrganization = $data && ($data->nama_pj != null || $data->link_pj != null);
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <h1 class="page-title">
                <i class="fa fa-{{ $operation === 'create' ? 'plus-circle' : ($operation === 'update' ? 'edit' : 'eye') }} me-2"></i>
                <span>{{ $operation === 'create' ? 'Add New' : ($operation === 'update' ? 'Edit' : 'View') }}</span>
                <span class="highlighted-text ms-1">Campaign</span>
                @if($operation !== 'create' && $data)
                    <small class="text-muted d-block mt-2">{{ $data->judul }}</small>
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
                <form action="{{ $operation === 'create' ? route('admin.service.store.campaign') : route('admin.service.update.campaign', $data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($operation === 'update')
                        @method('PUT')
                    @endif
            @endif

            <!-- Campaign Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-bullhorn me-2"></i>Campaign Information</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="inputJudulCampaign" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Title @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $data->judul }}</div>
                                    @else
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="inputJudulCampaign" name="judul"
                                            value="{{ old('judul', $data->judul ?? '') }}" required>
                                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="chooseKategoriCampaign" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Category @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <span class="badge bg-info">{{ $data->kategori }}</span>
                                        </div>
                                    @else
                                        <select class="form-select @error('kategori') is-invalid @enderror" name="kategori" id="chooseKategoriCampaign" data-placeholder="-- Choose Category --" required>
                                            <option value="" disabled {{ !old('kategori', $data->kategori ?? '') ? 'selected' : '' }}>-- Choose Category --</option>
                                            @foreach (['Pendidikan', 'Kemanusiaan', 'Kesehatan', 'Ekonomi', 'Sosial Dakwah', 'Lingkungan'] as $cat)
                                                <option value="{{ $cat }}" {{ old('kategori', $data->kategori ?? '') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                            @endforeach
                                        </select>
                                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputLink" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Link @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            <a href="{{ url('/celengan-syahid/' . $data->link) }}" target="_blank">{{ url('/celengan-syahid/' . $data->link) }}</a>
                                        </div>
                                    @else
                                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="inputLink" name="link"
                                            value="{{ old('link', $data->link ?? '') }}" required style="text-transform: lowercase;">
                                        @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-map-marker-alt me-2"></i>Location Information</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputProvinsiCampaign" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Province @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $data->provinsi ?? '-' }}</div>
                                    @else
                                        <select class="form-select" name="provinsi" id="inputProvinsiCampaign" data-placeholder="-- Choose Province --">
                                            <option value="">-- Choose Province --</option>
                                            @foreach ($provinces as $id => $name)
                                                <option value="{{ $name }}" {{ old('provinsi', $data->provinsi ?? '') == $name ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="inputKotaCampaign" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        City @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $data->kota ?? '-' }}</div>
                                    @else
                                        <select class="form-select" name="kota" id="inputKotaCampaign" data-placeholder="-- Choose City --">
                                            <option value="">-- Choose City --</option>
                                            @if ($operation === 'update' && $data && $data->kota)
                                                <option value="{{ $data->kota }}" selected>{{ strtoupper($data->kota) }}</option>
                                            @endif
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Details -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-file-alt me-2"></i>Campaign Details</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="inputTargetBiaya" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Cost Targets @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ LFC::formatRupiah($data->target_biaya) }}</div>
                                    @else
                                        <input type="text" class="form-control @error('target_biaya') is-invalid @enderror" id="inputTargetBiaya" name="target_biaya"
                                            value="{{ old('target_biaya', ($data ? LFC::formatRupiah($data->target_biaya) : '')) }}" required>
                                        @error('target_biaya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="inputCerita" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Story Details @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="border p-3 rounded bg-white">{!! $data->cerita !!}</div>
                                    @else
                                        <textarea class="form-control summernote" name="cerita" id="inputCerita" required>{{ $data->cerita ?? '' }}</textarea>
                                        @error('cerita') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="inputTujuan" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Goals @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">{{ $data->tujuan ?: '-' }}</div>
                                    @else
                                        <textarea class="form-control @error('tujuan') is-invalid @enderror" name="tujuan" id="inputTujuan" style="height: 100px;" required>{{ old('tujuan', $data->tujuan ?? '') }}</textarea>
                                        @error('tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="inputKabarTerbaru" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Latest News</label>
                                    @if ($operation === 'view')
                                        <div class="border p-3 rounded bg-white">{!! $data->kabar_terbaru ?: '-' !!}</div>
                                    @else
                                        <textarea class="form-control summernote" name="kabar_terbaru" id="inputKabarTerbaru">{{ $data->kabar_terbaru ?? '' }}</textarea>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media & Contact -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-image me-2"></i>Media & Contact</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="poster" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Poster @if($operation !== 'view') <span class="small text-muted">(1920 x 1080 Pixel)</span> @endif
                                    </label>
                                    <div class="text-center mb-3">
                                        <div class="image-preview-container {{ ($data && $data->gdrive_id) ? 'has-image' : '' }}">
                                            @if($currentPoster)
                                                <img id="framePoster" src="{{ $currentPoster }}" alt="Poster Preview">
                                            @else
                                                <img id="framePoster" src="" alt="Poster Preview" style="display:none;">
                                                <x-svg-placeholder />
                                            @endif
                                        </div>
                                    </div>
                                    @if ($operation !== 'view')
                                        <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster"
                                            accept="image/jpeg,image/png,image/jpg" {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputDeadlineCampaign" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        Deadline @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">
                                            {{ $data->deadline ? \Carbon\Carbon::parse($data->deadline)->isoFormat('dddd, DD MMMM YYYY') : '-' }}
                                        </div>
                                    @else
                                        <input type="text" class="form-control flatpickr-date @error('deadline') is-invalid @enderror" id="inputDeadlineCampaign" name="deadline"
                                            value="{{ old('deadline', $data->deadline ?? '') }}" {{ $operation === 'create' ? 'required' : '' }}>
                                        @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="inputTelpPJ" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">
                                        PIC Contact @if($operation !== 'view') <span class="text-danger">*</span> @endif
                                    </label>
                                    @if ($operation === 'view')
                                        <div class="form-control-plaintext">+62{{ $data->telp_pj ?? '-' }}</div>
                                    @else
                                        <div class="input-group">
                                            <span class="input-group-text">+62</span>
                                            <input type="text" class="form-control @error('telp_pj') is-invalid @enderror" id="inputTelpPJ" name="telp_pj"
                                                value="{{ old('telp_pj', $data->telp_pj ?? '') }}" {{ $operation === 'create' ? 'required' : '' }}>
                                            @error('telp_pj') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Organization Details -->
            <div class="col-md-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="section-title mb-3"><i class="fas fa-building me-2"></i>Organization Details</h5>
                        @if ($operation !== 'view')
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="cekOrganisasi" {{ $hasOrganization ? 'checked' : '' }}>
                                <label class="form-check-label" for="cekOrganisasi">Organizations other than UKM LDK Syahid ?</label>
                            </div>
                        @endif
                        <div id="formOrganisasi" @if(!$hasOrganization && $operation !== 'view') style="display: none;" @endif>
                            @if ($operation === 'view' && !$hasOrganization)
                                <div class="form-control-plaintext text-muted">No external organization</div>
                            @else
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="logoPj" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Organization Logo</label>
                                            <div class="text-center mb-3">
                                                <div class="image-preview-container {{ ($data && $data->gdrive_id_1) ? 'has-image' : '' }}">
                                                    @if($currentLogo)
                                                        <img id="frameLogo" src="{{ $currentLogo }}" alt="Logo Preview" style="width: 150px; height: 150px; object-fit: contain;">
                                                    @else
                                                        <img id="frameLogo" src="" alt="Logo Preview" style="display:none; width: 150px; height: 150px; object-fit: contain;">
                                                        <x-svg-placeholder height="150" />
                                                    @endif
                                                </div>
                                            </div>
                                            @if ($operation !== 'view')
                                                <input type="file" class="form-control" id="logoPj" name="logo_pj"
                                                    accept="image/jpeg,image/png,image/jpg">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="inputNamaPJ" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Organization Name</label>
                                            @if ($operation === 'view')
                                                <div class="form-control-plaintext">{{ $data->nama_pj ?: '-' }}</div>
                                            @else
                                                <input type="text" class="form-control" id="inputNamaPJ" name="nama_pj"
                                                    value="{{ old('nama_pj', $data->nama_pj ?? '') }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="inputLinkPJ" class="form-label {{ $operation === 'view' ? 'fw-bold' : '' }}">Organization Profile Links</label>
                                            @if ($operation === 'view')
                                                <div class="form-control-plaintext">
                                                    @if($data->link_pj)
                                                        <a href="{{ $data->link_pj }}" target="_blank">{{ $data->link_pj }}</a>
                                                    @else - @endif
                                                </div>
                                            @else
                                                <input type="text" class="form-control" id="inputLinkPJ" name="link_pj"
                                                    value="{{ old('link_pj', $data->link_pj ?? '') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($operation === 'view')
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Created At</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($data->created_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($data->created_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Last Updated</label>
                                        <div class="form-control-plaintext">
                                            {{ \Carbon\Carbon::parse($data->updated_at)->isoFormat('dddd, DD MMMM YYYY') }}
                                            <small class="text-muted ms-1">({{ \Carbon\Carbon::parse($data->updated_at)->format('H:i T') }})</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($operation !== 'view')
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.service.index.celsyahid.dashboard') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary">
                            <i class="fa fa-save me-1"></i> {{ $operation === 'create' ? 'Create Campaign' : 'Update Campaign' }}
                        </button>
                    </div>
                </div>
                </form>
            @else
                <div class="row mb-5">
                    <div class="col-md-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.service.index.celsyahid.dashboard') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left me-1"></i> Back
                        </a>
                        <a href="{{ route('admin.service.edit.campaign', $data->id) }}" class="btn btn-custom-primary">
                            <i class="fa fa-edit me-1"></i> Edit
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
