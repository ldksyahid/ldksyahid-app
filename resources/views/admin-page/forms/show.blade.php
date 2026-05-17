@extends('admin-page.template.body')

@section('styles')
<style>
.detail-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    padding: 1.5rem;
    margin-bottom: 1.25rem;
}
.detail-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: .85rem;
    margin-bottom: 1.25rem;
}
.detail-card-header h5 { font-weight: 700; margin: 0; }
.stat-box {
    text-align: center;
    padding: 1.25rem;
    background: #f9fafb;
    border-radius: 10px;
}
.stat-box .stat-num { font-size: 2rem; font-weight: 800; color: #1a6b3a; }
.stat-box .stat-lbl { font-size: .75rem; color: #6b7280; text-transform: uppercase; letter-spacing: .05em; }
.status-badge-lg { font-size: .9rem; padding: .45rem 1rem; border-radius: 50px; }
.field-pill {
    display: inline-flex; align-items: center; gap: .35rem;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 20px; padding: .25rem .75rem;
    font-size: .8rem; color: #166534; margin: .2rem;
}
.field-pill.system { background: #fef3c7; border-color: #fde68a; color: #92400e; }
.gdrive-link {
    display: flex; align-items: center; gap: .5rem;
    padding: .65rem 1rem; background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 8px; text-decoration: none; color: #166534;
    font-size: .875rem; font-weight: 600; transition: all .2s;
}
.gdrive-link:hover { background: #dcfce7; color: #166534; text-decoration: none; }
.gdrive-link i { font-size: 1.1rem; }
.action-bar { display: flex; gap: .5rem; flex-wrap: wrap; }

/* Dark mode */
html.dark-mode .detail-card { background: #1a1d23; box-shadow: 0 2px 12px rgba(0,0,0,.25); }
html.dark-mode .detail-card-header { border-bottom-color: #2d3139; }
html.dark-mode .detail-card-header h5 { color: #e4e6eb; }
html.dark-mode .stat-box { background: #22252d; }
html.dark-mode .stat-box .stat-num { color: #4ade80; }
html.dark-mode .stat-box .stat-lbl { color: #9ca3af; }
html.dark-mode .field-pill { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .field-pill.system { background: #2d2510; border-color: #4a3a1a; color: #fbbf24; }
html.dark-mode .gdrive-link { background: #1a2d1e; border-color: #2d4a30; color: #86efac; }
html.dark-mode .gdrive-link:hover { background: #1f3524; color: #86efac; }
html.dark-mode .table-borderless td,
html.dark-mode .table-borderless th { color: #c8cdd3; }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-1"><i class="fa fa-wpforms me-2 text-primary"></i>{{ $form->title }}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size:.85rem;">
                    <li class="breadcrumb-item"><a href="{{ route('admin.forms.index') }}">Forms</a></li>
                    <li class="breadcrumb-item active">{{ Str::limit($form->title, 40) }}</li>
                </ol>
            </nav>
        </div>

        <div class="action-bar">
            <a href="{{ route('admin.forms.builder', $form->formID) }}" class="btn btn-primary btn-sm">
                <i class="fa fa-hammer me-1"></i> Form Builder
            </a>
            <a href="{{ route('admin.forms.edit', $form->formID) }}" class="btn btn-warning btn-sm">
                <i class="fa fa-edit me-1"></i> Edit
            </a>

            @if($form->status === 'draft' || $form->status === 'closed')
                <form action="{{ route('admin.forms.publish', $form->formID) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fa fa-check-circle me-1"></i> Publish
                    </button>
                </form>
            @elseif($form->status === 'published')
                <form action="{{ route('admin.forms.close', $form->formID) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="fa fa-stop-circle me-1"></i> Close Form
                    </button>
                </form>
            @endif

            @if($form->status === 'published')
            <button class="btn btn-outline-info btn-sm" onclick="copyFormUrl()" title="Copy Form URL">
                <i class="fa fa-copy me-1"></i> Copy URL
            </button>
            @endif
        </div>
    </div>

    <div class="row g-4">

        {{-- Left column --}}
        <div class="col-lg-8">

            {{-- Stats --}}
            <div class="detail-card">
                <div class="row g-3">
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-num">{{ number_format($form->totalSubmission) }}</div>
                            <div class="stat-lbl">Total Submissions</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-num">{{ $form->activeFields->count() }}</div>
                            <div class="stat-lbl">Fields</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <div class="stat-num">v{{ $form->version }}</div>
                            <div class="stat-lbl">Form Version</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form info --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fa fa-info-circle me-2 text-primary"></i>Form Information</h5>
                    <span class="badge status-badge-lg
                        @if($form->status === 'published') bg-success
                        @elseif($form->status === 'draft') bg-secondary
                        @elseif($form->status === 'closed') bg-warning text-dark
                        @else bg-dark @endif">
                        {{ ucfirst($form->status) }}
                    </span>
                </div>

                @if($form->description)
                <p class="text-muted mb-3" style="font-size:.9rem;">{{ $form->description }}</p>
                @endif

                <table class="table table-borderless table-sm" style="font-size:.875rem;">
                    <tr>
                        <th class="text-muted fw-normal" style="width:150px;">Public URL</th>
                        <td>
                            <code id="formPublicUrl">{{ url('/form/' . $form->slug) }}</code>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Created By</th>
                        <td>{{ $form->createdBy }}</td>
                    </tr>
                    <tr>
                        <th class="text-muted fw-normal">Created Date</th>
                        <td>{{ $form->createdDate?->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</td>
                    </tr>
                    @if($form->startDate || $form->endDate)
                    <tr>
                        <th class="text-muted fw-normal">Active Period</th>
                        <td>
                            {{ $form->startDate ? $form->startDate->format('d M Y H:i') : '—' }}
                            until
                            {{ $form->endDate ? $form->endDate->format('d M Y H:i') : 'no limit' }}
                        </td>
                    </tr>
                    @endif
                    @if($form->maxSubmission)
                    <tr>
                        <th class="text-muted fw-normal">Max. Submissions</th>
                        <td>{{ number_format($form->maxSubmission) }}</td>
                    </tr>
                    @endif
                </table>
            </div>

            {{-- Fields list --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fa fa-list me-2 text-info"></i>Form Fields</h5>
                    <a href="{{ route('admin.forms.builder', $form->formID) }}" class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-plus me-1"></i> Manage Fields
                    </a>
                </div>

                @forelse($form->activeFields as $field)
                <span class="field-pill {{ $field->isSystemField ? 'system' : '' }}">
                    <i class="fa
                        @switch($field->fieldType)
                            @case('email') fa-envelope @break
                            @case('file') @case('image') fa-file-upload @break
                            @case('dropdown') fa-chevron-circle-down @break
                            @case('radio') fa-dot-circle @break
                            @case('checkbox') fa-check-square @break
                            @case('date') @case('datetime') fa-calendar @break
                            @case('number') fa-hashtag @break
                            @default fa-font
                        @endswitch
                        fa-sm"></i>
                    {{ $field->label }}
                    @if($field->isRequired) <span style="color:#ef4444;">*</span> @endif
                    @if($field->isSystemField) <i class="fa fa-lock fa-xs" title="System field"></i> @endif
                </span>
                @empty
                <p class="text-muted mb-0" style="font-size:.875rem;">
                    No fields yet. <a href="{{ route('admin.forms.builder', $form->formID) }}">Open Form Builder</a> to add fields.
                </p>
                @endforelse
            </div>

        </div>

        {{-- Right column --}}
        <div class="col-lg-4">

            {{-- Google Drive --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fab fa-google-drive me-2 text-success"></i>Google Drive</h5>
                </div>

                @if($form->gdriveSpreadsheetUrl)
                <a href="{{ $form->gdriveSpreadsheetUrl }}" target="_blank" class="gdrive-link mb-2 d-flex">
                    <i class="fas fa-table"></i>
                    <span>View Responses Spreadsheet</span>
                    <i class="fas fa-external-link-alt ms-auto" style="font-size:.75rem;opacity:.6;"></i>
                </a>
                @endif

                @if($form->gdriveAttachmentsFolderUrl)
                <a href="{{ $form->gdriveAttachmentsFolderUrl }}" target="_blank" class="gdrive-link d-flex">
                    <i class="fas fa-folder"></i>
                    <span>Attachments Folder</span>
                    <i class="fas fa-external-link-alt ms-auto" style="font-size:.75rem;opacity:.6;"></i>
                </a>
                @else
                <p class="text-muted mb-0" style="font-size:.8rem;">
                    <i class="fa fa-info-circle me-1"></i>
                    GDrive not yet configured.
                </p>
                @endif
            </div>

            {{-- Collaborators --}}
            @if($form->collaboratorEmails)
            <div class="detail-card">
                <div class="detail-card-header">
                    <h5><i class="fa fa-users me-2 text-warning"></i>Collaborators</h5>
                </div>
                @foreach($form->collaboratorEmails as $collab)
                <div class="d-flex align-items-center gap-2 mb-2">
                    <span style="width:32px;height:32px;background:#f0fdf4;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-user fa-sm text-success"></i>
                    </span>
                    <span style="font-size:.85rem;">{{ $collab }}</span>
                </div>
                @endforeach
            </div>
            @endif

            {{-- Danger zone --}}
            <div class="detail-card" style="border: 1px solid #fee2e2;">
                <div class="detail-card-header">
                    <h5 class="text-danger"><i class="fa fa-exclamation-triangle me-2"></i>Danger Zone</h5>
                </div>
                <form action="{{ route('admin.forms.destroy', $form->formID) }}" method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this form? This action cannot be undone.')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                        <i class="fa fa-trash me-2"></i>Delete Form
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function copyFormUrl() {
    const url = document.getElementById('formPublicUrl').textContent.trim();
    navigator.clipboard.writeText(url).then(() => {
        toastr && toastr.success('Form URL copied to clipboard!');
    }).catch(() => {
        prompt('Copy this URL:', url);
    });
}
</script>
@endsection
