@extends('admin-page.template.body')

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet" />
<style>
    .page-title {
        font-size: 1.65rem; font-weight: 600; text-align: center;
        color: #00a79d; margin: .75rem 0 1.5rem; position: relative; display: inline-block;
    }
    .page-title::after {
        content: ''; display: block; height: 4px; width: 120px;
        margin: .35rem auto 0; border-radius: 3px;
        background: linear-gradient(90deg,#00a79d 0%,#008b84 100%);
    }
    .section-title {
        font-size: 1.05rem; font-weight: 600; color: #00a79d;
        padding-bottom: 0.5rem; border-bottom: 2px solid #e0f7f5;
    }
    .btn-custom-primary {
        color: #fff; background-color: #00a79d; border: 1px solid #00a79d; transition: all 0.3s ease;
    }
    .btn-custom-primary:hover { background-color: #008b84; border-color: #008b84; color: #fff; }
    .btn-custom-primary:disabled { opacity: 0.7; cursor: not-allowed; }
    .card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .form-control:focus, .form-select:focus {
        border-color: #00a79d; box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25);
    }
    /* Recipient toggle */
    .recipient-toggle { display: flex; gap: 0.75rem; margin-bottom: 1rem; }
    .recipient-toggle .btn-toggle {
        flex: 1; padding: 0.65rem 1rem; border-radius: 10px; font-size: 0.9rem; font-weight: 600;
        border: 2px solid #e2e8f0; background: #fff; color: #6c757d; cursor: pointer;
        transition: all 0.2s ease; text-align: center;
    }
    .recipient-toggle .btn-toggle.active {
        border-color: #00a79d; background: rgba(0,167,157,0.08); color: #00a79d;
    }
    .recipient-toggle .btn-toggle:hover:not(.active) {
        border-color: #b2d8d8; background: #f0fffe;
    }
    /* Email tag badges */
    .email-count-badge {
        display: inline-block; background: #00a79d; color: #fff;
        font-size: 0.75rem; font-weight: 600; padding: 2px 10px;
        border-radius: 20px; margin-left: 0.5rem;
    }
    .note-editor { border-radius: 8px !important; }

    /* ── Dark Mode ── */
    html.dark-mode .card {
        background: #2b2f33 !important; border-color: #373b3e !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
    }
    html.dark-mode .section-title {
        color: #00a79d; border-bottom-color: #373b3e;
    }
    html.dark-mode .form-control,
    html.dark-mode .form-select {
        background-color: #1a1d21; border-color: #373b3e; color: #e4e6eb;
    }
    html.dark-mode .form-control:focus,
    html.dark-mode .form-select:focus {
        background-color: #1a1d21; border-color: #00a79d; color: #e4e6eb;
        box-shadow: 0 0 0 0.2rem rgba(0,167,157,0.25);
    }
    html.dark-mode .form-control::placeholder { color: #6c757d; }
    html.dark-mode .form-label { color: #e4e6eb; }
    html.dark-mode .form-text { color: #b0b3b8; }
    html.dark-mode .recipient-toggle .btn-toggle {
        background: #1a1d21; border-color: #373b3e; color: #b0b3b8;
    }
    html.dark-mode .recipient-toggle .btn-toggle.active {
        border-color: #00a79d; background: rgba(0,167,157,0.15); color: #00a79d;
    }
    html.dark-mode .recipient-toggle .btn-toggle:hover:not(.active) {
        border-color: #00a79d; background: #2b2f33; color: #e4e6eb;
    }
    #subscribersSection .alert { border: none !important; }
    html.dark-mode #subscribersSection .alert {
        background: rgba(0,167,157,0.1) !important; color: #00a79d !important;
        border: none !important;
    }
    html.dark-mode .note-editor.note-frame {
        border-color: #373b3e !important;
    }
    html.dark-mode .note-toolbar {
        background: #2b2f33 !important; border-bottom-color: #373b3e !important;
    }
    html.dark-mode .note-toolbar .btn { color: #e4e6eb !important; }
    html.dark-mode .note-toolbar .btn:hover { background: #373b3e !important; }
    html.dark-mode .note-editable {
        background: #1a1d21 !important; color: #e4e6eb !important;
    }
    html.dark-mode .note-statusbar {
        background: #2b2f33 !important; border-top-color: #373b3e !important;
    }
    /* Summernote dropdown & color picker */
    html.dark-mode .note-dropdown-menu,
    html.dark-mode .note-color-palette,
    html.dark-mode .note-color-all,
    html.dark-mode .note-holder,
    html.dark-mode .note-color .dropdown-menu {
        background: #2b2f33 !important; border-color: #373b3e !important;
    }
    html.dark-mode .note-dropdown-menu .dropdown-item {
        color: #e4e6eb !important;
    }
    html.dark-mode .note-dropdown-menu .dropdown-item:hover,
    html.dark-mode .note-dropdown-menu .dropdown-item:focus {
        background: #373b3e !important; color: #e4e6eb !important;
    }
    html.dark-mode .note-color-reset,
    html.dark-mode .note-color-select,
    html.dark-mode .note-color-select-btn {
        background: #1a1d21 !important; border-color: #373b3e !important;
        color: #e4e6eb !important;
    }
    html.dark-mode .note-color-reset:hover,
    html.dark-mode .note-color-select:hover {
        background: #373b3e !important;
    }
    html.dark-mode .note-holder-custom input[type="color"] {
        border-color: #373b3e !important; background: #1a1d21 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">
        <div class="row">
            <div class="text-center mb-3">
                <h1 class="page-title">
                    <i class="fas fa-paper-plane me-2"></i>Generate Email
                </h1>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="col-md-12 mb-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>There were some problems with your input:</strong>
                        <ul class="mb-0 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.email-config.generate.send') }}" method="POST" id="generateEmailForm">
                @csrf

                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="section-title mb-4"><i class="fas fa-envelope me-2"></i>Email Content</h5>

                            {{-- Subject --}}
                            <div class="mb-4">
                                <label for="subject" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                <input type="text" id="subject" name="subject"
                                    class="form-control @error('subject') is-invalid @enderror"
                                    value="{{ old('subject') }}"
                                    placeholder="Enter email subject..."
                                    required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Body --}}
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Body <span class="text-danger">*</span></label>
                                <textarea id="body" name="body" class="summernote">{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="section-title mb-4"><i class="fas fa-users me-2"></i>Recipients</h5>

                            <input type="hidden" name="recipient_type" id="recipient_type" value="{{ old('recipient_type', 'subscribers') }}">

                            {{-- Toggle --}}
                            <div class="recipient-toggle">
                                <div class="btn-toggle {{ old('recipient_type', 'subscribers') === 'subscribers' ? 'active' : '' }}"
                                     data-value="subscribers" onclick="setRecipientType('subscribers')">
                                    <i class="fas fa-users me-2"></i>All Active Subscribers
                                    <span class="email-count-badge" id="subscriberCount">–</span>
                                </div>
                                <div class="btn-toggle {{ old('recipient_type') === 'custom' ? 'active' : '' }}"
                                     data-value="custom" onclick="setRecipientType('custom')">
                                    <i class="fas fa-at me-2"></i>Custom Emails
                                </div>
                            </div>

                            {{-- Subscribers info --}}
                            <div id="subscribersSection" class="{{ old('recipient_type') === 'custom' ? 'd-none' : '' }}">
                                <div class="alert alert-info border-0 py-2 px-3" style="background:transparent;color:#007a73;">
                                    <i class="fas fa-circle-info me-2"></i>
                                    Email will be sent to all <strong>active subscribers</strong>.
                                </div>
                            </div>

                            {{-- Custom emails textarea --}}
                            <div id="customSection" class="{{ old('recipient_type') !== 'custom' ? 'd-none' : '' }}">
                                <label for="custom_emails" class="form-label fw-semibold">
                                    Email Addresses <span class="text-danger">*</span>
                                    <span class="text-muted fw-normal small ms-1">(one per line, or comma-separated)</span>
                                </label>
                                <textarea id="custom_emails" name="custom_emails" rows="6"
                                    class="form-control font-monospace @error('custom_emails') is-invalid @enderror"
                                    placeholder="example@email.com&#10;another@email.com&#10;third@email.com">{{ old('custom_emails') }}</textarea>
                                @error('custom_emails')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text" id="emailCountInfo"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-5">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.subscription.index') }}" class="btn btn-danger">
                            <i class="fa fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-custom-primary" id="submitBtn">
                            <i class="fas fa-paper-plane me-1"></i> Send Email
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // Init Summernote
    $('.summernote').summernote({
        height: 350,
        minHeight: 200,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'italic', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['view', ['fullscreen', 'codeview']],
        ],
        callbacks: { onInit: function() { $('body > .note-popover').hide(); } }
    });

    // Load subscriber count
    fetchSubscriberCount();

    // Custom emails live counter
    $('#custom_emails').on('input', updateEmailCount);
    updateEmailCount();

    // Form submit
    $('#generateEmailForm').on('submit', function(e) {
        e.preventDefault();

        const subject = $('#subject').val().trim();
        if (!subject) {
            Swal.fire({ icon: 'error', title: 'Subject Required', text: 'Please enter an email subject.', confirmButtonColor: '#00a79d' });
            return;
        }

        const body = $('.summernote').summernote('code');
        if (!body || body === '<p><br></p>' || body.trim() === '') {
            Swal.fire({ icon: 'error', title: 'Body Required', text: 'Please write the email body.', confirmButtonColor: '#00a79d' });
            return;
        }

        const recipientType = $('#recipient_type').val();
        let recipientLabel = 'all active subscribers';
        if (recipientType === 'custom') {
            const emails = parseEmails($('#custom_emails').val());
            if (emails.length === 0) {
                Swal.fire({ icon: 'error', title: 'No Recipients', text: 'Please enter at least one valid email address.', confirmButtonColor: '#00a79d' });
                return;
            }
            recipientLabel = `${emails.length} recipient(s)`;
        }

        Swal.fire({
            icon: 'question',
            title: 'Send Email?',
            html: `Are you sure you want to send <strong>"${subject}"</strong> to ${recipientLabel}?`,
            showCancelButton: true,
            confirmButtonColor: '#00a79d',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Send',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#submitBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Sending...');
                this.submit();
            }
        });
    });

    @if(session('success'))
    Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true })
        .fire({ icon: 'success', title: '{{ session('success') }}' });
    @endif
});

function setRecipientType(type) {
    $('#recipient_type').val(type);
    $('.btn-toggle').removeClass('active');
    $(`.btn-toggle[data-value="${type}"]`).addClass('active');

    if (type === 'subscribers') {
        $('#subscribersSection').removeClass('d-none');
        $('#customSection').addClass('d-none');
    } else {
        $('#subscribersSection').addClass('d-none');
        $('#customSection').removeClass('d-none');
    }
}

function parseEmails(raw) {
    const lines = raw.split(/[\r\n,;]+/);
    return lines.map(e => e.trim()).filter(e => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e));
}

function updateEmailCount() {
    const emails = parseEmails($('#custom_emails').val());
    const info = document.getElementById('emailCountInfo');
    if (!info) return;
    info.textContent = emails.length > 0 ? `${emails.length} valid email(s) detected` : '';
}

// Fix Summernote color swatches in dark mode
(function() {
    function fixColorBtns(root) {
        if (!document.documentElement.classList.contains('dark-mode')) return;
        (root || document).querySelectorAll('.note-color-btn[data-value]').forEach(function(btn) {
            const color = btn.getAttribute('data-value');
            if (color) btn.style.setProperty('background-color', color, 'important');
        });
    }
    // Watch for Summernote dropdowns being inserted
    new MutationObserver(function(mutations) {
        mutations.forEach(function(m) {
            m.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) fixColorBtns(node);
            });
        });
    }).observe(document.body, { childList: true, subtree: true });
    // Also watch dark mode toggle changes
    new MutationObserver(function() { fixColorBtns(); })
        .observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
})();

function fetchSubscriberCount() {
    fetch('{{ route('admin.subscription.index') }}', {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        // Use total from response if available
        if (data.total !== undefined) {
            document.getElementById('subscriberCount').textContent = data.total;
        }
    })
    .catch(() => {});
}
</script>
@endsection
